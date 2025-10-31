<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        foreach ($books as $book) {
            $qrFileName = 'book-' . $book->id . '.png';
            $qrDirectory = public_path('qrcode/books/');
            $qrPath = $qrDirectory . $qrFileName;

            if (!file_exists($qrDirectory)) {
                mkdir($qrDirectory, 0755, true);
            }

            if (!file_exists($qrPath)) {
                $this->generateQrFile($book);
            }

            $book->qr_url = asset('qrcode/books/' . $qrFileName);
        }

        return view('books.index', compact('books'));
    }

public function store(Request $request)
{
    // Debug: Log the request data
    \Log::info('Book creation request data:', $request->all());
    \Log::info('Files in request:', $request->allFiles());

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre' => 'nullable|string|max:50',
        'published_year' => 'required|integer|min:1000|max:3000',
        'availability' => 'required|integer|min:0',
        'cover' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120' // 5MB to match your JS, consistent mimes order
    ]);

    // Remove cover from validated data to avoid mass assignment issues
    $bookData = collect($validated)->except('cover')->toArray();
    
    try {
        // Create the book record first
        $book = Book::create($bookData);
        \Log::info('Book created with ID: ' . $book->id);

        // Handle cover upload if exists
        if ($request->hasFile('cover')) {
            \Log::info('Cover file detected');
            
            $file = $request->file('cover');
            
            // Additional file validation
            if (!$file->isValid()) {
                \Log::error('Invalid file upload');
                return response()->json(['error' => 'Invalid file upload'], 400);
            }

            $originalName = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $fileName = 'book-' . $book->id . '-' . time() . '.' . $ext;
            $destination = public_path('cover');

            \Log::info('Attempting to upload: ' . $originalName . ' as ' . $fileName);

            // Make sure directory exists
            if (!file_exists($destination)) {
                if (!mkdir($destination, 0755, true)) {
                    \Log::error('Failed to create cover directory');
                    return response()->json(['error' => 'Failed to create upload directory'], 500);
                }
                \Log::info('Created cover directory');
            }

            // Check if directory is writable
            if (!is_writable($destination)) {
                \Log::error('Cover directory is not writable: ' . $destination);
                return response()->json(['error' => 'Upload directory is not writable'], 500);
            }

            // Move file to destination
            if ($file->move($destination, $fileName)) {
                // Verify the file was actually moved
                $fullPath = $destination . '/' . $fileName;
                if (file_exists($fullPath)) {
                    // Save the relative path in the database
                    $book->cover_image = 'cover/' . $fileName;
                    if ($book->save()) {
                        \Log::info('Cover uploaded and saved successfully: ' . $fileName);
                        \Log::info('Database updated with cover_image: ' . $book->cover_image);
                    } else {
                        \Log::error('Failed to save cover_image to database');
                    }
                } else {
                    \Log::error('File was not found after move operation');
                }
            } else {
                \Log::error('Failed to move uploaded file to: ' . $destination . '/' . $fileName);
                return response()->json(['error' => 'Failed to save uploaded file'], 500);
            }
        } else {
            \Log::info('No cover file in request');
        }

        // Generate QR code
        $this->generateQrFile($book);

        // Refresh the model to get all updated data
        $book = $book->fresh();
        
        return response()->json([
            'message' => 'Book added successfully!',
            'book' => $book
        ], 201);

    } catch (\Exception $e) {
        \Log::error('Error creating book: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'error' => 'Failed to create book: ' . $e->getMessage()
        ], 500);
    }
}

    public function show($id)
    {
        return response()->json(Book::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'nullable|string|max:50',
            'published_year' => 'required|integer|min:1000|max:3000',
            'availability' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = 'cover-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('cover'), $filename);
            $validated['cover_image'] = 'cover/' . $filename;
        }

        $book->update($validated);
        $this->generateQrFile($book);

        return response()->json(['success' => true, 'message' => 'Book updated']);
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return response()->json(['success' => true, 'message' => 'Book deleted']);
    }

    public function getMediaImages()
    {
        $imageDirectories = [
            public_path('images'),
            public_path('cover'),
            public_path('qrcode/books'),
            public_path('resource/member_images')
        ];

        $images = [];

        foreach ($imageDirectories as $directory) {
            if (file_exists($directory) && is_dir($directory)) {
                $files = scandir($directory);

                foreach ($files as $file) {
                    $filePath = $directory . '/' . $file;
                    $fileName = basename($file);

                    // Skip directories and hidden files
                    if (is_file($filePath) && !str_starts_with($fileName, '.')) {
                        // Check if it's an image file
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                        if (in_array($extension, $imageExtensions)) {
                            $images[] = [
                                'name' => $fileName,
                                'path' => str_replace(public_path(), '', $filePath),
                                'url' => asset($fileName),
                                'size' => filesize($filePath),
                                'modified' => date('Y-m-d H:i:s', filemtime($filePath))
                            ];
                        }
                    }
                }
            }
        }

        // Sort by modified date (newest first)
        usort($images, function($a, $b) {
            return strtotime($b['modified']) - strtotime($a['modified']);
        });

        return response()->json($images);
    }

    private function generateQrFile(Book $book)
    {
        $qrFileName = 'book-' . $book->id . '.png';
        $qrPath = public_path('qrcode/books/' . $qrFileName);

        if (!file_exists(dirname($qrPath))) {
            mkdir(dirname($qrPath), 0755, true);
        }

        if (!file_exists($qrPath)) {
            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_H,
                'scale' => 10,
            ]);

            $qrData = route('books.show', $book->id); // QR code links to book details
            (new QRCode($options))->render($qrData, $qrPath);
        }

        $book->qr_url = asset('qrcode/books/' . $qrFileName);
        $book->save();
    }
}
