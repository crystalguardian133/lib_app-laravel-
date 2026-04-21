<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SystemLog;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private function findBookOrFail(string $identifier): Book
    {
        return Book::where('uuid', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();
    }

    /**
     * Return all unique genres (flattened from genres array and legacy genre string) for filter dropdown.
     */
    public function allGenres(Request $request)
    {
        // Get all genres from genres array and legacy genre string
        $genres = Book::query()
            ->select(['genres', 'genre'])
            ->get()
            ->flatMap(function ($book) {
                $arr = [];
                // Always decode genres as array
                $genresArr = $book->genres;
                if (is_string($genresArr)) {
                    $genresArr = json_decode($genresArr, true);
                }
                if (is_array($genresArr) && !empty($genresArr)) {
                    foreach ($genresArr as $g) {
                        if (is_string($g)) {
                            $arr = array_merge($arr, $this->splitGenres($g));
                        }
                    }
                }
                if (!empty($book->genre)) {
                    $arr = array_merge($arr, $this->splitGenres($book->genre));
                }
                return $arr;
            })
            ->map(function ($g) { return trim($g); })
            ->filter(fn($g) => $g !== '')
            ->unique()
            ->sort()
            ->values();
        return response()->json(['genres' => $genres]);
    }
    public function index(Request $request)
    {
        if (! Auth::check() || ! Auth::user()->hasPermission('manage-books')) {
            abort(403, 'Unauthorized. You do not have permission to view books.');
        }

        $request->validate([
            'search'   => 'nullable|string|max:255',
            'genre'    => 'nullable|string|max:50',
            'year'     => 'nullable|integer|min:1000|max:3000',
            'status'   => 'nullable|in:available,unavailable',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort_by'  => 'nullable|in:title,published_year,status',
            'sort_dir' => 'nullable|in:asc,desc',
        ]);

        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search');
        $genre   = $request->get('genre');
        $year    = $request->get('year');
        $status  = $request->get('status');
        $sortBy  = $request->get('sort_by');
        $sortDir = strtolower($request->get('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $applySorting = function ($queryBuilder) use ($sortBy, $sortDir) {
            if ($sortBy === 'title') {
                return $queryBuilder->orderBy('title', $sortDir)->orderBy('id', 'asc');
            }

            if ($sortBy === 'published_year') {
                return $queryBuilder->orderBy('published_year', $sortDir)->orderBy('id', 'asc');
            }

            if ($sortBy === 'status') {
                $direction = $sortDir === 'desc' ? 'DESC' : 'ASC';
                return $queryBuilder
                    ->orderByRaw("CASE WHEN availability > 0 THEN 0 ELSE 1 END {$direction}")
                    ->orderBy('title', 'asc')
                    ->orderBy('id', 'asc');
            }

            return $queryBuilder->orderBy('id', 'asc');
        };

        $query = Book::query();

        // Global search: try FULLTEXT, fallback to LIKE if needed
        if ($search) {
            // Try FULLTEXT first
            $query->whereRaw('MATCH(title, author, genre) AGAINST (? IN BOOLEAN MODE)', [$search . '*']);
        }

        // Apply filters
        if ($genre) {
            // Filter by genres array or legacy genre string
            $query->where(function($q) use ($genre) {
                $q->whereJsonContains('genres', $genre)
                  ->orWhere('genre', 'LIKE', "%$genre%");
            });
        }
        if ($year) {
            $query->where('published_year', $year);
        }
        if ($status === 'available') {
            $query->where('availability', '>', 0);
        } elseif ($status === 'unavailable') {
            $query->where('availability', '<=', 0);
        }

        // Paginate and check if FULLTEXT returned results, fallback to LIKE if not
        $books = $applySorting($query)->paginate($perPage)->appends($request->except('page'));
        if ($search && $books->total() === 0) {
            // Fallback: LIKE search on all major fields
            $query = Book::query();
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                  ->orWhere('author', 'LIKE', "%$search%")
                  ->orWhere('genre', 'LIKE', "%$search%")
                  ->orWhere('published_year', 'LIKE', "%$search%")
                  ->orWhere('availability', 'LIKE', "%$search%")
                  ->orWhereJsonContains('genres', $search)
                  ;
            });
            if ($genre) {
                $query->where(function($q) use ($genre) {
                    $q->whereJsonContains('genres', $genre)
                      ->orWhere('genre', 'LIKE', "%$genre%");
                });
            }
            if ($year) {
                $query->where('published_year', $year);
            }
            if ($status === 'available') {
                $query->where('availability', '>', 0);
            } elseif ($status === 'unavailable') {
                $query->where('availability', '<=', 0);
            }
            $books = $applySorting($query)->paginate($perPage)->appends($request->except('page'));
        }

        foreach ($books as $book) {
            $this->generateQrFileIfMissing($book);
            $qrFileName  = 'book-' . $book->id . '.png';
            $book->qr_url = asset('qrcode/books/' . $qrFileName);
        }

        if ($request->ajax()) {
            // Return JSON for AJAX search
            $rows = [];
            foreach ($books as $book) {
                $rows[] = [
                    'id' => $book->id,
                    'uuid' => $book->uuid,
                    'title' => $book->title,
                    'author' => $book->author,
                    'genre' => $book->genre,
                    'genres' => $book->genres_list, // always array
                    'published_year' => $book->published_year,
                    'availability' => $book->availability,
                    'cover_image' => $book->cover_image ?? '/images/no-cover.jpg',
                    'qr_url' => $book->qr_url ?? '',
                ];
            }
            return response()->json([
                'rows' => $rows,
                'pagination' => [
                    'current_page' => $books->currentPage(),
                    'last_page' => $books->lastPage(),
                    'per_page' => $books->perPage(),
                    'total' => $books->total(),
                    'from' => $books->firstItem(),
                    'to' => $books->lastItem(),
                ],
            ]);
        }

        return view('books.index', compact('books', 'perPage', 'search', 'genre', 'year', 'status', 'sortBy', 'sortDir'));
    }

    public function store(Request $request)
    {
        if (! Auth::check() || ! Auth::user()->hasPermission('manage-books')) {
            return response()->json(['error' => 'Unauthorized. You do not have permission to create books.'], 403);
        }

        \Log::info('Book creation request data:', $request->all());
        \Log::info('Files in request:', $request->allFiles());

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'genre'            => 'nullable|string|max:255',
            'published_year'   => 'required|integer|min:1000|max:3000',
            'availability'     => 'required|integer|min:0',
            'cover'            => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120',
            'temp_image'       => 'nullable|string',
        ]);

        $bookData = collect($validated)->except(['cover', 'temp_image'])->toArray();
        // Handle multi-genre input
        if (!empty($bookData['genre'])) {
            $bookData['genres'] = $this->splitGenres($bookData['genre']);
            $bookData['genre'] = implode(', ', $bookData['genres']);
        }

        try {
            $book = Book::create($bookData);
            \Log::info('Book created with ID: ' . $book->id);

            if ($request->has('temp_image') && $request->temp_image) {
                \Log::info('Temp image specified: ' . $request->temp_image);
                $tempImageData = json_decode($request->temp_image, true);
                if ($tempImageData && isset($tempImageData['temp_name'])) {
                    $tempPath  = public_path('temp_uploads/' . $tempImageData['temp_name']);
                    $coverPath = public_path('cover');
                    if (file_exists($tempPath)) {
                        $ext      = pathinfo($tempImageData['temp_name'], PATHINFO_EXTENSION);
                        $fileName = 'book-' . $book->id . '-' . time() . '.' . $ext;
                        if (! file_exists($coverPath)) {
                            mkdir($coverPath, 0755, true);
                        }
                        if (rename($tempPath, $coverPath . '/' . $fileName)) {
                            $book->cover_image = 'cover/' . $fileName;
                            $book->save();
                            \Log::info('Temp image moved to cover successfully: ' . $fileName);
                        } else {
                            \Log::error('Failed to move temp image to cover directory');
                        }
                    } else {
                        \Log::error('Temp image file not found: ' . $tempPath);
                    }
                }
            } elseif ($request->hasFile('cover')) {
                \Log::info('Cover file detected');
                $file = $request->file('cover');
                if (! $file->isValid()) {
                    \Log::error('Invalid file upload');
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
                $originalName = $file->getClientOriginalName();
                $ext          = $file->getClientOriginalExtension();
                $fileName     = 'book-' . $book->id . '-' . time() . '.' . $ext;
                $destination  = public_path('cover');
                \Log::info('Attempting to upload: ' . $originalName . ' as ' . $fileName);
                if (! file_exists($destination)) {
                    if (! mkdir($destination, 0755, true)) {
                        \Log::error('Failed to create cover directory');
                        return response()->json(['error' => 'Failed to create upload directory'], 500);
                    }
                    \Log::info('Created cover directory');
                }
                if (! is_writable($destination)) {
                    \Log::error('Cover directory is not writable: ' . $destination);
                    return response()->json(['error' => 'Upload directory is not writable'], 500);
                }
                if ($file->move($destination, $fileName)) {
                    $fullPath = $destination . '/' . $fileName;
                    if (file_exists($fullPath)) {
                        $book->cover_image = 'cover/' . $fileName;
                        if ($book->save()) {
                            \Log::info('Cover uploaded and saved successfully: ' . $fileName);
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

            $this->generateQrFileIfMissing($book);
            $book = $book->fresh();

            SystemLog::log(
                'book_created',
                "Book '{$book->title}' by {$book->author} was added to the library",
                Auth::id(),
                [
                    'book_id'        => $book->id,
                    'book_title'     => $book->title,
                    'book_author'    => $book->author,
                    'book_genre'     => $book->genre,
                    'published_year' => $book->published_year,
                    'availability'   => $book->availability,
                ]
            );

            return response()->json([
                'message' => 'Book added successfully!',
                'book'    => $book,
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Error creating book: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to create book: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        if (! Auth::check() || ! Auth::user()->hasPermission('manage-books')) {
            return response()->json(['error' => 'Unauthorized. You do not have permission to view books.'], 403);
        }

        return response()->json($this->findBookOrFail((string) $id));
    }

    public function update(Request $request, $id)
    {
        if (! Auth::check() || ! Auth::user()->hasPermission('manage-books')) {
            return response()->json(['error' => 'Unauthorized. You do not have permission to update books.'], 403);
        }

        $book = $this->findBookOrFail((string) $id);


        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'genre'          => 'nullable|string|max:255',
            'published_year' => 'required|integer|min:1000|max:3000',
            'availability'   => 'required|integer|min:0',
            'cover'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle multi-genre input
        $updateData = $validated;
        if (!empty($updateData['genre'])) {
            $updateData['genres'] = $this->splitGenres($updateData['genre']);
            $updateData['genre'] = implode(', ', $updateData['genres']);
        }

        if ($request->hasFile('cover')) {
            $file     = $request->file('cover');
            $filename = 'cover-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('cover'), $filename);
            $updateData['cover_image'] = 'cover/' . $filename;
        }

        $oldValues = $book->only(array_keys($validated));
        $book->update($updateData);

        // FIX 3 applied to update too: force-regenerate only on explicit update
        $this->generateQrFile($book);

        SystemLog::log(
            'book_updated',
            "Book '{$book->title}' by {$book->author} was updated",
            Auth::id(),
            [
                'book_id'    => $book->id,
                'book_title' => $book->title,
                'book_author'=> $book->author,
                'old_values' => $oldValues,
                'new_values' => $validated,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Book updated']);
    }

    public function destroy($id)
    {
        if (! Auth::check() || ! Auth::user()->hasPermission('manage-books')) {
            return response()->json(['error' => 'Unauthorized. You do not have permission to delete books.'], 403);
        }

        try {
            $book = $this->findBookOrFail((string) $id);

            $activeTransactions = \DB::table('transactions')
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->count();

            if ($activeTransactions > 0) {
                return response()->json([
                    'error' => 'Cannot delete book: It is currently borrowed by ' . $activeTransactions . ' member(s).',
                ], 400);
            }

            $bookData = [
                'book_id'    => $book->id,
                'book_title' => $book->title,
                'book_author'=> $book->author,
            ];

            \DB::table('returns')->whereIn('transaction_id', function ($query) use ($book) {
                $query->select('id')->from('transactions')->where('book_id', $book->id);
            })->delete();

            \DB::table('transactions')->where('book_id', $book->id)->delete();

            $book->delete();

            try {
                SystemLog::log(
                    'book_deleted',
                    "Book '{$bookData['book_title']}' by {$bookData['book_author']} was deleted from the library",
                    Auth::id()
                );
            } catch (\Exception $e) {
                \Log::warning('Failed to log book deletion: ' . $e->getMessage());
            }

            return response()->json(['success' => true, 'message' => 'Book deleted']);

        } catch (\Exception $e) {
            \Log::error('Error deleting book: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to delete book: ' . $e->getMessage()], 500);
        }
    }

    public function uploadTempImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file    = $request->file('image');
            $tempDir = public_path('temp_uploads');
            if (! file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            $filename = 'temp_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($tempDir, $filename);
            $tempPath = $tempDir . '/' . $filename;

            return response()->json([
                'success' => true,
                'image'   => [
                    'name'      => $file->getClientOriginalName(),
                    'temp_name' => $filename,
                    'path'      => 'temp_uploads/' . $filename,
                    'url'       => asset('temp_uploads/' . $filename),
                    'size'      => filesize($tempPath),
                    'modified'  => date('Y-m-d H:i:s', filemtime($tempPath)),
                    'is_temp'   => true,
                ],
            ]);
        }

        return response()->json(['success' => false, 'error' => 'No image uploaded'], 400);
    }

    public function getMediaImages()
    {
        $imageDirectories = [
            public_path('images'),
            public_path('cover'),
            public_path('qrcode/books'),
            public_path('resource/member_images'),
            public_path('temp_uploads'),
        ];

        $images = [];

        foreach ($imageDirectories as $directory) {
            if (file_exists($directory) && is_dir($directory)) {
                $files = scandir($directory);
                foreach ($files as $file) {
                    $filePath  = $directory . '/' . $file;
                    $fileName  = basename($file);
                    if (is_file($filePath) && ! str_starts_with($fileName, '.')) {
                        $extension       = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if (in_array($extension, $imageExtensions)) {
                            $isTemp   = strpos($directory, 'temp_uploads') !== false;
                            $images[] = [
                                'name'      => $isTemp ? str_replace('temp_' . preg_replace('/^temp_\d+_/', '', $fileName), '', $fileName) : $fileName,
                                'temp_name' => $isTemp ? $fileName : null,
                                'path'      => str_replace(public_path(), '', $filePath),
                                'url'       => asset(ltrim(str_replace(public_path(), '', $filePath), '/')),
                                'size'      => filesize($filePath),
                                'modified'  => date('Y-m-d H:i:s', filemtime($filePath)),
                                'is_temp'   => $isTemp,
                            ];
                        }
                    }
                }
            }
        }

        usort($images, function ($a, $b) {
            return strtotime($b['modified']) - strtotime($a['modified']);
        });

        return response()->json($images);
    }

    public function cleanupTempImages()
    {
        $tempDir = public_path('temp_uploads');
        if (! file_exists($tempDir)) {
            return response()->json(['message' => 'No temp directory found']);
        }

        $files       = scandir($tempDir);
        $deletedCount = 0;
        $cutoffTime  = time() - (24 * 60 * 60);

        foreach ($files as $file) {
            $filePath = $tempDir . '/' . $file;
            if (is_file($filePath) && ! str_starts_with($file, '.')) {
                if (filemtime($filePath) < $cutoffTime) {
                    if (unlink($filePath)) {
                        $deletedCount++;
                    }
                }
            }
        }

        return response()->json(['message' => "Cleaned up {$deletedCount} old temp files"]);
    }

    /**
     * FIX 3: Only regenerate the QR file if it doesn't exist yet.
     * Call generateQrFile() directly when you need to force a regeneration (e.g. on update).
     */
    private function generateQrFileIfMissing(Book $book): void
    {
        $qrFileName = 'book-' . $book->id . '.png';
        $qrPath     = public_path('qrcode/books/' . $qrFileName);

        if (file_exists($qrPath)) {
            // File already exists — nothing to do on a plain page load
            return;
        }

        $this->generateQrFile($book);
    }

    /**
     * Always regenerates the QR file (used on store/update).
     */
    private function generateQrFile(Book $book): void
    {
        $qrFileName = 'book-' . $book->id . '.png';
        $qrPath     = public_path('qrcode/books/' . $qrFileName);

        if (! file_exists(dirname($qrPath))) {
            mkdir(dirname($qrPath), 0755, true);
        }

        if (file_exists($qrPath)) {
            unlink($qrPath);
        }

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_H,
            'scale'      => 10,
        ]);

        $qrData = route('books.show', ['book' => $book->uuid]);
        (new QRCode($options))->render($qrData, $qrPath);

        $book->qr_url = asset('qrcode/books/' . $qrFileName);
        $book->save();
    }

    /**
     * Split a multi-genre input string by common separators and normalize values.
     */
    private function splitGenres(?string $value): array
    {
        if (!is_string($value) || trim($value) === '') {
            return [];
        }

        $parts = preg_split('/\s*[,\/&;|\\\\]+\s*/', $value) ?: [];

        return collect($parts)
            ->map(fn ($g) => trim($g))
            ->filter(fn ($g) => $g !== '')
            ->unique()
            ->values()
            ->all();
    }
}