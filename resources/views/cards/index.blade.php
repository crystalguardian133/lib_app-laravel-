<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Overdue Book Notifications</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            color: #333;
            padding: 20px;
        }

        h2 {
            color: #d32f2f;
            border-bottom: 2px solid #d32f2f;
            padding-bottom: 5px;
        }

        .notification-card {
            background: white;
            border-left: 4px solid #d32f2f;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 15px 0;
            padding: 15px;
            border-radius: 6px;
        }

        .book-title {
            font-weight: bold;
            color: #1976d2;
        }

        .member-name {
            font-size: 1.1em;
        }

        .due-date {
            color: #d32f2f;
            font-weight: bold;
        }

        .days-overdue {
            background: #d32f2f;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .empty {
            color: #777;
            font-style: italic;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #d32f2f;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .refresh-btn {
            background: #1976d2;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 1em;
        }

        .refresh-btn:hover {
            background: #0d5ba3;
        }
    </style>
</head>
<body>

    <h2>📚 Overdue Book Notifications</h2>
    <button class="refresh-btn" id="refreshBtn">Refresh Notifications</button>
    <div id="overdueContainer">
        <div class="loader" id="loader"></div>
    </div>

    <script>
        const container = document.getElementById('overdueContainer');
        const refreshBtn = document.getElementById('refreshBtn');

        // Function to fetch overdue books
        async function fetchOverdueBooks() {
            container.innerHTML = '<div class="loader"></div>';

            try {
                const response = await fetch('/transactions/overdue');

                if (!response.ok) {
                    throw new Error('Failed to load data');
                }

                const data = await response.json();
                renderOverdueBooks(data.books);
            } catch (error) {
                container.innerHTML = `
                    <p style="color: red;">
                        Error loading overdue books: ${error.message}
                    </p>
                    <small>Check if the route is accessible or user is logged in.</small>
                `;
            }
        }

        // Render the books
        function renderOverdueBooks(books) {
            if (books.length === 0) {
                container.innerHTML = '<p class="empty">🎉 No overdue books found.</p>';
                return;
            }

            const now = new Date();
            let html = '';

            books.forEach(book => {
                const dueDate = new Date(book.due_date);
                const diffTime = now - dueDate;
                const daysOverdue = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                html += `
                <div class="notification-card">
                    <div><span class="book-title">${book.title}</span></div>
                    <div class="member-name">Borrowed by: ${book.member}</div>
                    <div>Due on: <span class="due-date">${book.due_date}</span></div>
                    <div>
                        Overdue: <span class="days-overdue">${daysOverdue} day(s)</span>
                    </div>
                </div>`;
            });

            container.innerHTML = html;
        }

        // Initial load
        fetchOverdueBooks();

        // Refresh on button click
        refreshBtn.addEventListener('click', fetchOverdueBooks);
    </script>

</body>
</html>