<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>📚 Borrow History | Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* Colors */
            --primary: #2fb9eb;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            
            /* Neutrals */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Theme */
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-hover: #f3f4f6;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            
            /* Transitions */
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--text-primary);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: var(--spacing-xl);
        }

        /* Header */
        .page-header {
            margin-bottom: var(--spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            gap: var(--spacing-md);
        }

        .btn {
            padding: 10px 20px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn:hover {
            background: var(--bg-hover);
            border-color: var(--gray-300);
        }

        /* Filters Section */
        .filters-section {
            background: var(--bg-primary);
            border-radius: 12px;
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-md);
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }

        .filter-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-label i {
            font-size: 12px;
        }

        .filter-input,
        .filter-select {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 14px;
            transition: var(--transition);
        }

        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-input-wrapper input {
            width: 100%;
        }

        /* Table Container */
        .table-container {
            background: var(--bg-primary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border);
        }

        th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }

        tbody tr:hover {
            background: var(--bg-hover);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 16px;
            font-size: 14px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        .transaction-number {
            font-weight: 600;
            color: var(--text-secondary);
        }

        .member-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .member-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 13px;
        }

        .member-name {
            font-weight: 600;
        }

        .book-title {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .status-borrowed {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .status-returned {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-badge i {
            font-size: 12px;
        }

        .date-text {
            color: var(--text-secondary);
            font-size: 13px;
            white-space: nowrap;
        }

        /* Footer Pagination */
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            background: var(--bg-secondary);
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pagination-button {
            padding: 8px 12px;
            border: 1px solid var(--border);
            background: var(--bg-primary);
            color: var(--text-primary);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .pagination-button:hover:not(:disabled) {
            background: var(--bg-hover);
            border-color: var(--gray-300);
        }

        .pagination-button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .pagination-number {
            min-width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .pagination-number:hover {
            background: var(--bg-hover);
        }

        .pagination-number.active {
            background: var(--primary);
            color: white;
        }

        .pagination-dots {
            padding: 0 4px;
            color: var(--text-secondary);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: var(--gray-300);
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: var(--spacing-md);
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-md);
            }

            .header-actions {
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .table-wrapper {
                overflow-x: scroll;
            }

            table {
                min-width: 800px;
            }

            .table-footer {
                flex-direction: column;
                gap: var(--spacing-md);
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-history"></i>
                Borrow History
            </h1>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-calendar-alt"></i>
                        Filter by Year
                    </label>
                    <select class="filter-select" id="yearFilter">
                        <option value="">All Years</option>
                        @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}">{{ $yearOption }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-calendar"></i>
                        Filter by Month
                    </label>
                    <select class="filter-select" id="monthFilter" onchange="applyFilters()">
                        <option value="">All Months</option>
                        <option value="01" {{ $selectedMonth == '01' ? 'selected' : '' }}>January</option>
                        <option value="02" {{ $selectedMonth == '02' ? 'selected' : '' }}>February</option>
                        <option value="03" {{ $selectedMonth == '03' ? 'selected' : '' }}>March</option>
                        <option value="04" {{ $selectedMonth == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ $selectedMonth == '05' ? 'selected' : '' }}>May</option>
                        <option value="06" {{ $selectedMonth == '06' ? 'selected' : '' }}>June</option>
                        <option value="07" {{ $selectedMonth == '07' ? 'selected' : '' }}>July</option>
                        <option value="08" {{ $selectedMonth == '08' ? 'selected' : '' }}>August</option>
                        <option value="09" {{ $selectedMonth == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $selectedMonth == '10' ? 'selected' : '' }}>October</option>
                        <option value="11" {{ $selectedMonth == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $selectedMonth == '12' ? 'selected' : '' }}>December</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-filter"></i>
                        Filter by Status
                    </label>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="borrowed">Borrowed</option>
                        <option value="returned">Returned</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-list"></i>
                        Show Entries
                    </label>
                    <select class="filter-select" id="perPageSelect" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-search"></i>
                        Search
                    </label>
                    <div class="search-input-wrapper">
                        <input type="text" class="filter-input" placeholder="Search transactions..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-wrapper">
                @if($transactions->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Borrowed At</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Returned At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                        <tr>
                            <td class="transaction-number">{{ $transactions->firstItem() + $index }}</td>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar">
                                        {{ $transaction->member ? strtoupper(substr($transaction->member->first_name, 0, 1)) : '?' }}
                                    </div>
                                    <span class="member-name">
                                        {{ $transaction->member ? $transaction->member->first_name . ' ' . $transaction->member->last_name : 'Unknown Member' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="book-title">
                                    {{ $transaction->book ? $transaction->book->title : 'Unknown Book' }}
                                </div>
                            </td>
                            <td>
                                <div class="date-text">
                                    {{ $transaction->borrowed_at ? $transaction->borrowed_at->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </td>
                            <td>
                                <div class="date-text">
                                    {{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $transaction->status }}">
                                    <i class="fas fa-{{ $transaction->status == 'borrowed' ? 'book-open' : 'undo' }}"></i>
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="date-text">
                                    {{ $transaction->returned_at ? $transaction->returned_at->format('M d, Y H:i') : '—' }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <h3>No Borrow History Found</h3>
                    <p>No borrow transactions found in the system.</p>
                </div>
                @endif
            </div>

            @if($transactions->count() > 0)
            <div class="table-footer">
                <div class="pagination-info">
                    Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} entries
                </div>
                <div class="pagination-controls">
                    @if($transactions->onFirstPage())
                        <button class="pagination-button" disabled>
                            <i class="fas fa-chevron-left"></i>
                            Prev
                        </button>
                    @else
                        <a href="{{ $transactions->previousPageUrl() }}" class="pagination-button">
                            <i class="fas fa-chevron-left"></i>
                            Prev
                        </a>
                    @endif

                    @foreach(range(1, $transactions->lastPage()) as $page)
                        @if($page == $transactions->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @elseif($page == 1 || $page == $transactions->lastPage() || abs($page - $transactions->currentPage()) <= 1)
                            <a href="{{ $transactions->url($page) }}" class="pagination-number">{{ $page }}</a>
                        @elseif($page == 2 || $page == $transactions->lastPage() - 1)
                            <span class="pagination-dots">...</span>
                        @endif
                    @endforeach

                    @if($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="pagination-button">
                            Next
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <button class="pagination-button" disabled>
                            Next
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function changePerPage(perPage) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        // Client-side filtering
        document.getElementById('yearFilter').addEventListener('change', filterTable);
        document.getElementById('monthFilter').addEventListener('change', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('searchInput').addEventListener('input', filterTable);

        function filterTable() {
            const yearFilter = document.getElementById('yearFilter').value;
            const monthFilter = document.getElementById('monthFilter').value;
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            let visibleCount = 0;

            rows.forEach(row => {
                const year = row.dataset.year;
                const month = row.dataset.month;
                const status = row.dataset.status;
                const text = row.textContent.toLowerCase();
                
                const matchesYear = !yearFilter || year === yearFilter;
                const matchesMonth = !monthFilter || month === monthFilter;
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesSearch = !searchText || text.includes(searchText);
                
                const shouldShow = matchesYear && matchesMonth && matchesStatus && matchesSearch;
                row.style.display = shouldShow ? '' : 'none';
                
                if (shouldShow) visibleCount++;
            });

            updateFilteredCount(visibleCount);
        }

        function updateFilteredCount(count) {
            const paginationInfo = document.querySelector('.pagination-info');
            if (paginationInfo && count > 0) {
                const totalEntries = document.querySelectorAll('tbody tr').length;
                if (count < totalEntries) {
                    paginationInfo.innerHTML = `Showing ${count} of ${totalEntries} entries (filtered)`;
                }
            }
        }
    </script>
</body>
</html>