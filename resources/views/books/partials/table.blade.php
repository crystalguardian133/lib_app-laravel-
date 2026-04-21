@php
    $activeSortBy = request('sort_by');
    $activeSortDir = request('sort_dir', 'asc');
@endphp

<div class="table-container">
    <div class="table-wrapper">
        <table class="data-table" id="booksTable">
        <thead>
            <tr>
                <th>Cover</th>
                <th>
                    <button type="button" class="sort-trigger{{ $activeSortBy === 'title' ? ' active' : '' }}" data-sort-by="title" data-sort-dir="{{ $activeSortBy === 'title' ? $activeSortDir : 'asc' }}" aria-label="Sort by title">
                        <span>Title</span>
                        <i class="fas {{ $activeSortBy === 'title' ? ($activeSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up') : 'fa-sort' }} sort-icon"></i>
                    </button>
                </th>
                <th>Author</th>
                <th>Genre</th>
                <th>
                    <button type="button" class="sort-trigger{{ $activeSortBy === 'published_year' ? ' active' : '' }}" data-sort-by="published_year" data-sort-dir="{{ $activeSortBy === 'published_year' ? $activeSortDir : 'asc' }}" aria-label="Sort by year">
                        <span>Year</span>
                        <i class="fas {{ $activeSortBy === 'published_year' ? ($activeSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up') : 'fa-sort' }} sort-icon"></i>
                    </button>
                </th>
                <th>
                    <button type="button" class="sort-trigger{{ $activeSortBy === 'status' ? ' active' : '' }}" data-sort-by="status" data-sort-dir="{{ $activeSortBy === 'status' ? $activeSortDir : 'asc' }}" aria-label="Sort by status">
                        <span>Status</span>
                        <i class="fas {{ $activeSortBy === 'status' ? ($activeSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up') : 'fa-sort' }} sort-icon"></i>
                    </button>
                </th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="booksTableBody">
            @forelse($books as $book)
            @php
                $title = $book->title ?? '';
                $author = $book->author ?? '';
                $publishedYear = $book->published_year ?? '';
                $availability = $book->availability;
                $hasAvailability = !is_null($availability);
                $statusLabel = $hasAvailability ? ($availability > 0 ? 'Available' : 'Out of Stock') : '';
                $availabilityText = $hasAvailability ? $availability . ' copies' : '';
                $genresList = $book->genres_list ?? [];
            @endphp
            <tr data-id="{{ $book->uuid ?? $book->id }}"
                data-legacy-id="{{ $book->id }}"
                data-title="{{ $title }}"
                data-author="{{ $author }}"
                data-genre="{{ implode(', ', $genresList) }}"
                data-published-year="{{ $publishedYear }}"
                data-availability="{{ $hasAvailability ? $availability : '' }}"
                data-cover-image="{{ $book->cover_image ?? '' }}"
                data-qr-url="{{ $book->qr_url ?? '' }}">
                <td>
                    <img src="{{ $book->cover_image ?? '/images/no-cover.jpg' }}" alt="Cover" class="book-cover-small">
                </td>
                <td style="font-weight: 600; color: var(--text-primary);" title="{{ $title }}">{{ $title }}</td>
                <td title="{{ $author }}">{{ $author }}</td>
                <td title="{{ implode(', ', $genresList) }}">
                    @foreach($genresList as $genre)
                        <span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500; margin-right: 4px; display: inline-block;">
                            {{ $genre }}
                        </span>
                    @endforeach
                </td>
                <td title="{{ $publishedYear }}">{{ $publishedYear }}</td>
                <td title="{{ $statusLabel }}">
                    @if($hasAvailability)
                        <span class="status-badge {{ $availability > 0 ? 'status-available' : 'status-unavailable' }}">
                            {{ $statusLabel }}
                        </span>
                    @endif
                </td>
                <td title="{{ $availabilityText }}">
                    @if($hasAvailability)
                        <strong style="color: var(--text-primary);">{{ $availability }}</strong> copies
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        @if(!empty($book->qr_url))
                            <button class="btn btn-outline btn-sm" onclick="showQRModal('{{ $book->title }}', '{{ $book->qr_url }}')" title="View QR Code">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        @else
                            <button class="btn btn-outline btn-sm" onclick="window.generateQr('{{ $book->uuid ?? $book->id }}')" title="Generate QR Code">
                                <i class="fas fa-qrcode"></i> Gen
                            </button>
                        @endif
                        <button class="btn btn-success btn-sm" onclick="window.borrowOne('{{ $book->uuid ?? $book->id }}')" title="Borrow Book" {{ !$hasAvailability || $availability <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-hand-holding"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="window.editBook('{{ $book->uuid ?? $book->id }}')" title="Edit Book">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="window.deleteBook('{{ $book->uuid ?? $book->id }}')" title="Delete Book">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <h3>No books found</h3>
                        <p>Add your first book to get started!</p>
                        <button class="btn btn-primary" onclick="openAddBookModal()" style="margin-top: 15px;">
                            <i class="fas fa-plus"></i> Add Book
                        </button>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
