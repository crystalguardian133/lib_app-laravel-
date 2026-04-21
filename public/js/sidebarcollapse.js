// Sidebar Collapse Functionality - External Implementation
window.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const toggleIcon = toggleBtn?.querySelector('i');

  if (!sidebar || !mainContent || !toggleBtn) {
    console.error('Required elements not found for sidebar toggle');
    return;
  }

  // Apply stored sidebar state on load
  const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
  if (isCollapsed) {
    sidebar.classList.add('collapsed');
    mainContent.classList.add('full');
    if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
  }

  // Toggle functionality
  toggleBtn.addEventListener('click', function(e) {
    e.preventDefault();

    const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');

    if (isCurrentlyCollapsed) {
      // Expand sidebar
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('full');
      if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
      localStorage.setItem('sidebarCollapsed', 'false');
    } else {
      // Collapse sidebar
      sidebar.classList.add('collapsed');
      mainContent.classList.add('full');
      if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
      localStorage.setItem('sidebarCollapsed', 'true');
    }
  });

  // Add keyboard shortcut (Ctrl/Cmd + B)
  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
      e.preventDefault();
      toggleBtn.click();
    }
  });

  // Make toggle function globally available for debugging
  window.toggleSidebarDebug = function() {
    toggleBtn.click();
  };
});