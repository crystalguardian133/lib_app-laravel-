document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const darkToggle = document.getElementById('darkModeToggle');

  // Sidebar toggle
  toggleBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('full');
  });

  // Dark mode setup
  const isDark = localStorage.getItem('darkMode') === 'true';
  if (isDark) {
    document.body.classList.add('dark-mode');
    darkToggle.checked = true;
  }

  // Dark mode toggle listener
  darkToggle?.addEventListener('change', function () {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', this.checked);
  });

  // Chart Data
  const transactionCtx = document.getElementById('transactionsChart')?.getContext('2d');
  const visitsCtx = document.getElementById('visitsChart')?.getContext('2d');

  if (typeof chartData !== 'undefined' && transactionCtx) {
    new Chart(transactionCtx, {
      type: 'bar',
      data: {
        labels: chartData.map(item => item.date),
        datasets: [{
          label: 'Transactions',
          data: chartData.map(item => item.count),
          backgroundColor: '#3b82f6'
        }]
      },
      options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
      }
    });
  }

  if (typeof visitsData !== 'undefined' && visitsCtx) {
    new Chart(visitsCtx, {
      type: 'bar',
      data: {
        labels: visitsData.map(item => item.date),
        datasets: [{
          label: 'Visits',
          data: visitsData.map(item => item.count),
          backgroundColor: '#10b981'
        }]
      },
      options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
      }
    });
  }
});
