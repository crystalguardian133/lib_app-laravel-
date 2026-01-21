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
  const darkModeLabel = document.getElementById('darkModeLabel');

  if (isDark) {
    document.body.classList.add('dark-mode');
    darkToggle.checked = true;
    darkModeLabel.textContent = 'Dark Mode';
  } else {
    darkModeLabel.textContent = 'Light Mode';
  }

  // Dark mode toggle listener
  darkToggle?.addEventListener('change', function () {
    document.body.classList.toggle('dark-mode');
    const isCurrentlyDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isCurrentlyDark);
    darkModeLabel.textContent = isCurrentlyDark ? 'Dark Mode' : 'Light Mode';

    // Add visual feedback for testing
    console.log('Dark mode toggled:', isCurrentlyDark ? 'ON' : 'OFF');
    console.log('Label updated to:', darkModeLabel.textContent);
    console.log('Body class list:', document.body.classList.toString());
  });

  // Make dark mode functions globally available for testing
  window.testDarkMode = function() {
    console.log('=== DARK MODE TEST ===');
    console.log('Current dark mode state:', document.body.classList.contains('dark-mode'));
    console.log('Toggle element:', darkToggle);
    console.log('Label element:', darkModeLabel);
    console.log('LocalStorage value:', localStorage.getItem('darkMode'));
    console.log('Toggle checked:', darkToggle?.checked);
    console.log('Label text:', darkModeLabel?.textContent);
  };

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
        indexAxis: 'x', // Vertical bars
        responsive: true,
        maintainAspectRatio: false,
        maxBarThickness: 45, // Moderate bar width
        categoryPercentage: 0.75, // Moderate category width
        barPercentage: 0.85, // Moderate bar width within category
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
            ticks: {
              stepSize: 1,
              callback: function(value) {
                return Number.isInteger(value) ? value : '';
              },
              color: 'var(--text-secondary)',
              font: { size: 12 }
            },
            title: {
              display: true,
              text: 'Count',
              color: 'var(--text-primary)',
              font: {
                weight: 'bold',
                size: 14
              },
              padding: { bottom: 10 }
            },
            grid: {
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            }
          },
          x: {
            ticks: {
              maxRotation: 45,
              minRotation: 0,
              autoSkip: false,
              color: 'var(--text-secondary)',
              font: { size: 11 }
            },
            title: {
              display: true,
              text: 'Month',
              color: 'var(--text-primary)',
              font: {
                weight: 'bold',
                size: 14
              },
              padding: { top: 10 }
            },
            grid: { display: false }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 12,
                weight: '600'
              },
              color: 'var(--text-primary)'
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.9)',
            titleColor: '#ffffff',
            bodyColor: '#ffffff',
            borderColor: 'rgba(99, 102, 241, 0.5)',
            borderWidth: 1,
            cornerRadius: 8,
            padding: 12,
            displayColors: true,
            callbacks: {
              title: function(context) {
                return `📊 ${context[0].label}`;
              },
              label: function(context) {
                return `${context.dataset.label}: ${context.parsed.y}`;
              }
            }
          }
        },
        animation: {
          duration: 1200,
          easing: 'easeInOutQuart',
          delay: function(context) {
            return context.dataIndex * 50;
          }
        },
        interaction: {
          intersect: false,
          mode: 'index'
        },
        onHover: function(event, elements) {
          event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
        }
      }
    });
  }
});
