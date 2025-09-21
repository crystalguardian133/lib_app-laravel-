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
  const weeklyCtx = document.getElementById('weeklyChart')?.getContext('2d');
  const visitsCtx = document.getElementById('visitsChart')?.getContext('2d');

  if (typeof weeklyData !== 'undefined' && weeklyCtx) {
    window.weeklyChart = new Chart(weeklyCtx, {
      type: 'bar',
      data: {
        labels: weeklyData.map(item => item.week),
        datasets: [{
          label: 'Weekly Transactions',
          data: weeklyData.map(item => item.count),
          backgroundColor: '#3b82f6',
          borderColor: '#1d4ed8',
          borderWidth: 2,
          borderRadius: 6,
          borderSkipped: false,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
          y: { 
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.1)',
              drawBorder: false,
            },
            ticks: {
              color: '#6b7280',
              font: {
                size: 10,
                weight: '500'
              }
            }
          },
          x: {
            grid: {
              display: false,
            },
            ticks: {
              color: '#6b7280',
              font: {
                size: 9,
                weight: '500'
              }
            }
          }
        },
        plugins: { 
          legend: { 
            display: false 
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: '#3b82f6',
            borderWidth: 1,
            cornerRadius: 8,
            displayColors: false,
            callbacks: {
              title: function(context) {
                return 'Week: ' + context[0].label;
              },
              label: function(context) {
                return 'Transactions: ' + context.parsed.y;
              }
            }
          }
        },
        animation: {
          duration: 1000,
          easing: 'easeInOutQuart'
        }
      }
    });
  }

  // Stats Chart (Line Chart)
  const statsCtx = document.getElementById('statsChart')?.getContext('2d');
  if (statsCtx) {
    window.statsChart = new Chart(statsCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Books',
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
          borderColor: '#3b82f6',
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#3b82f6',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 6,
          pointHoverRadius: 8
        }, {
          label: 'Members',
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
          borderColor: '#10b981',
          backgroundColor: 'rgba(16, 185, 129, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#10b981',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 6,
          pointHoverRadius: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
          y: { 
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.1)',
              drawBorder: false,
            },
            ticks: {
              color: '#6b7280',
              font: {
                size: 12,
                weight: '500'
              }
            }
          },
          x: {
            grid: {
              display: false,
            },
            ticks: {
              color: '#6b7280',
              font: {
                size: 11,
                weight: '500'
              }
            }
          }
        },
        plugins: { 
          legend: { 
            display: true,
            position: 'top',
            labels: {
              usePointStyle: true,
              pointStyle: 'circle',
              padding: 20,
              font: {
                size: 12,
                weight: '600'
              },
              color: '#374151'
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: '#e5e7eb',
            borderWidth: 1,
            cornerRadius: 8,
            displayColors: true,
            callbacks: {
              title: function(context) {
                return context[0].label;
              },
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.y;
              }
            }
          }
        },
        animation: {
          duration: 1000,
          easing: 'easeInOutQuart'
        },
        interaction: {
          intersect: false,
          mode: 'index'
        }
      }
    });
  }
});
