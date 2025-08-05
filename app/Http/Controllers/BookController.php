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
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre' => 'nullable|string|max:50',
        'published_year' => 'required|integer|min:1000|max:3000',
        'availability' => 'required|integer|min:0',
        'cover' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    // Create the book record first
    $book = Book::create($validated);

    // Handle cover upload if exists
    if ($request->hasFile('cover')) {
        $file = $request->file('cover');
        $ext = $file->getClientOriginalExtension();
        $fileName = 'book-' . $book->id . '.' . $ext;
        $destination = public_path('cover');

        // Make sure directory exists
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move file
        $file->move($destination, $fileName);

        // Save public URL in the DB
        $book->cover_image = url('cover/' . $fileName);
        $book->save();
    }

    // Generate QR code
    $this->generateQrFile($book);

    return response()->json([
        'message' => 'Book added successfully!',
        'book' => $book
    ], 201);
}

    public function show($id)
    {
        return response()->json(Book::findOrFail($id));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
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
