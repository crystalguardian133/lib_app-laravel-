 document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('transactionsChart').getContext('2d');

    const labels = @json($last7Days->pluck('date')->toArray());
    const dataPoints = @json($last7Days->pluck('count')->toArray());

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Borrowed Books',
          data: dataPoints,
          backgroundColor: 'rgba(59, 130, 246, 0.6)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        }
      }
    });
  });

  new Chart(visitsChart, {
    type: 'bar',
    data: {
      labels: visitsData.map(item => item.date),
      datasets: [{
        label: 'Visits',
        data: visitsData.map(item => item.count),
        backgroundColor: 'rgba(59, 130, 246, 0.7)',
        borderRadius: 4
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });