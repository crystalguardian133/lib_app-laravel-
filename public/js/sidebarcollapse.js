  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const darkToggle = document.getElementById('darkModeToggle');

  // Load preferences on DOM load
  window.addEventListener('DOMContentLoaded', () => {
    // Apply dark mode if saved
    const dark = localStorage.getItem('darkMode') === 'true';
    if (dark) {
      document.body.classList.add('dark-mode');
      darkToggle.checked = true;
    }

    // Apply collapsed sidebar if saved
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
      sidebar.classList.add('collapsed');
      mainContent.classList.add('full');
    }
  });

  // Toggle sidebar on click and save state
  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('full');
    const collapsed = sidebar.classList.contains('collapsed');
    localStorage.setItem('sidebarCollapsed', collapsed);
  });

  // Toggle dark mode and save state
  darkToggle.addEventListener('change', function () {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', this.checked);
  });
