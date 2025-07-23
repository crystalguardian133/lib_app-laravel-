<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        $books = Book::all();
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

    // Check for duplicates (optional)
    $exists = Book::where('title', $validated['title'])
                  ->where('author', $validated['author'])
                  ->first();

    if ($exists) {
        return response()->json([
            'message' => 'Book already exists.'
        ], 409);
    }

    $book = Book::create($validated);

    return response()->json([
        'message' => 'Book added successfully!',
        'book' => $book
    ], 201);
}


    public function edit(Book $book) {
        return view('books.edit', compact('book'));
    }


    // Show form data
public function show($isbn)
{
    return response()->json(Book::where('isbn', $isbn)->first());
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

    $book->update($request->only(['title', 'author', 'published_year', 'genre', 'availability']));

    return response()->json(['success' => true, 'message' => 'Book updated']);
}

public function destroy($id)
{
    Book::destroy($id);
    return response()->json(['success' => true, 'message' => 'Book deleted']);
}
}