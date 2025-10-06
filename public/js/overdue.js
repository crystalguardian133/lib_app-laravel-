document.addEventListener('DOMContentLoaded', async () => {
     const overdueToast = document.getElementById('overdueToast');
     const dueSoonToast = document.getElementById('dueSoonToast');
     const connectionStatus = document.getElementById('connection-status');
     const closeOverdue = document.getElementById('closeOverdue');
     const closeDueSoon = document.getElementById('closeDueSoon');

     if (!overdueToast || !dueSoonToast) {
         console.warn('Toast elements not found. Skipping.');
         return;
     }

     // Hide initially
     overdueToast.classList.add('toast-hidden');
     dueSoonToast.classList.add('toast-hidden');

     // Helper function to show connection status for overdue notifications
     function showOverdueStatus(message, isOverdue = true) {
         if (connectionStatus) {
             connectionStatus.textContent = message;
             connectionStatus.className = isOverdue ? 'connected' : 'connected';
             connectionStatus.style.display = 'block';

             // Add specific class for overdue styling
             if (isOverdue) {
                 connectionStatus.classList.add('overdue-alert');
             } else {
                 connectionStatus.classList.add('due-soon-alert');
             }

             // Auto-hide after 8 seconds
             setTimeout(() => {
                 connectionStatus.style.display = 'none';
                 connectionStatus.className = '';
             }, 8000);
         }
     }

    try {
        const response = await fetch('/api/notifications/overdue', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        });

        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        const data = await response.json();
        const overdueList = Array.isArray(data.overdue) ? data.overdue : [];
        const dueSoonList = Array.isArray(data.dueSoon) ? data.dueSoon : [];

        // Group by member (only relevant books)
        const groupByMember = (books) =>
            books.reduce((acc, { member, title }) => {
                acc[member] = acc[member] || [];
                acc[member].push(title);
                return acc;
            }, {});

        const overdueByMember = groupByMember(overdueList);
        const dueSoonByMember = groupByMember(dueSoonList);

        // Helper: Build summary message
        const buildSummary = (grouped, isOverdue) => {
            const count = Object.keys(grouped).length;

            if (count === 1) {
                const member = Object.keys(grouped)[0];
                const books = grouped[member];
                const verb = isOverdue ? 'overdue' : 'due soon';
                const bookText = books.length === 1
                    ? 'a book'
                    : `<strong>${books.length}</strong> books`;
                return `<strong>${member}</strong> has ${bookText} ${verb}.`;
            } else {
                const type = isOverdue ? 'overdue' : 'due soon';
                return `<strong>${count} member${count > 1 ? 's' : ''}</strong> have books ${type}.`;
            }
        };

        // Helper: Format full details
        const formatDetails = (grouped) => {
            return Object.entries(grouped)
                .map(([member, titles]) => `
                    <div>
                        <strong>${member}:</strong>
                        <ul style="margin:4px 0; padding-left:18px; font-size:0.9rem;">
                            ${titles.map(t => `<li>${t}</li>`).join('')}
                        </ul>
                    </div>
                `)
                .join('');
        };

        // === Show Overdue Notifications ===
        if (overdueList.length > 0) {
            const overdueSummary = buildSummary(overdueByMember, true);

            // Show in connection status area with urgent styling
            showOverdueStatus(`🔴 ${overdueSummary}`, true);

            // Also show in toast for detailed view
            document.getElementById('overdueSummary').innerHTML = overdueSummary;
            document.getElementById('overdueDetails').innerHTML = formatDetails(overdueByMember);

            overdueToast.querySelector('.toast-text').onclick = (e) => {
                if (e.target.closest('.toast-close')) return;
                const d = document.getElementById('overdueDetails');
                d.style.display = d.style.display === 'none' ? 'block' : 'none';
            };

            overdueToast.classList.remove('toast-hidden', 'show');
            overdueToast.classList.add('toast-overdue', 'show');
        }

        // === Show Due Soon Notifications ===
        if (dueSoonList.length > 0) {
            const dueSoonSummary = buildSummary(dueSoonByMember, false);

            // Show in connection status area with warning styling
            showOverdueStatus(`🟡 ${dueSoonSummary}`, false);

            // Also show in toast for detailed view
            document.getElementById('dueSoonSummary').innerHTML = dueSoonSummary;
            document.getElementById('dueSoonDetails').innerHTML = formatDetails(dueSoonByMember);

            dueSoonToast.querySelector('.toast-text').onclick = (e) => {
                if (e.target.closest('.toast-close')) return;
                const d = document.getElementById('dueSoonDetails');
                d.style.display = d.style.display === 'none' ? 'block' : 'none';
            };

            dueSoonToast.classList.remove('toast-hidden', 'show');
            dueSoonToast.classList.add('toast-warning', 'show');
        }

        // Close buttons
        closeOverdue?.addEventListener('click', (e) => {
            e.stopPropagation();
            overdueToast.classList.remove('show');
            setTimeout(() => overdueToast.classList.add('toast-hidden'), 300);
        });

        closeDueSoon?.addEventListener('click', (e) => {
            e.stopPropagation();
            dueSoonToast.classList.remove('show');
            setTimeout(() => dueSoonToast.classList.add('toast-hidden'), 300);
        });

        // Auto-dismiss after 12 seconds
        if (!overdueToast.classList.contains('toast-hidden')) {
            setTimeout(() => {
                overdueToast.classList.remove('show');
                setTimeout(() => overdueToast.classList.add('toast-hidden'), 300);
            }, 12000);
        }

        if (!dueSoonToast.classList.contains('toast-hidden')) {
            setTimeout(() => {
                dueSoonToast.classList.remove('show');
                setTimeout(() => dueSoonToast.classList.add('toast-hidden'), 300);
            }, 12000);
        }

    } catch (err) {
        console.error('[Toast] Error:', err.message);
    }
});