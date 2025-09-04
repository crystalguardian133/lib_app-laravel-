  window.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('toggleSidebar');

    // Apply stored sidebar state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
      sidebar?.classList.add('collapsed');
      mainContent?.classList.add('full');
    }

    // Restore dark mode (optional)
    const dark = localStorage.getItem('darkMode') === 'true';
    if (dark) {
      document.body.classList.add('dark-mode');
      const darkToggle = document.getElementById('darkModeToggle');
      if (darkToggle) darkToggle.checked = true;
    }

    // Listen for toggle click
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        sidebar?.classList.toggle('collapsed');
        mainContent?.classList.toggle('full');
        localStorage.setItem('sidebarCollapsed', sidebar?.classList.contains('collapsed'));
      });
    }
  });