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

            // Ensure QR directory exists
            if (!file_exists($qrDirectory)) {
                mkdir($qrDirectory, 0755, true);
            }

            // Generate QR if not already generated
            if (!file_exists($qrPath)) {
                $this->generateQrFile($book);
            }

            // Add qr_url attribute to each book
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
        ]);

        // Optional duplicate check
        $exists = Book::where('title', $validated['title'])
                      ->where('author', $validated['author'])
                      ->first();

        if ($exists) {
            return response()->json(['message' => 'Book already exists.'], 409);
        }

        $book = Book::create($validated);

        // Generate QR code after creation
        $this->generateQrFile($book);

        return response()->json([
            'message' => 'Book added successfully!',
            'book' => $book
        ], 201);
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function show($id)
    {
        return response()->json(Book::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'published_year' => 'required|integer',
            'availability' => 'required|integer'
        ]);

        $book->update($request->only([
            'title', 'author', 'published_year', 'genre', 'availability'
        ]));

        return response()->json(['success' => true, 'message' => 'Book updated']);
    }

    private function generateQrFile(Book $book)
{
    $qrPath = public_path('qrcode/books/book-' . $book->id . '.png');
    $book->qr_url = asset('qrcode/books/' . $qrFileName);

    if (!file_exists(dirname($qrPath))) {
        mkdir(dirname($qrPath), 0755, true);
    }

    if (!file_exists($qrPath)) {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_H, // high error correction
            'scale' => 10,               // sharpness
        ]);

        $qrData = route('books.show', $book->id); // or any unique book string

        (new QRCode($options))->render($qrData, $qrPath);
    }

    return $qrPath;
}


    public function destroy($id)
    {
        Book::destroy($id);
        return response()->json(['success' => true, 'message' => 'Book deleted']);
    }
}