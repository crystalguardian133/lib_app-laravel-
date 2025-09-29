// Sidebar Collapse Functionality - External Implementation
window.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const toggleIcon = toggleBtn?.querySelector('i');

  console.log('External sidebar script loaded');
  console.log('Elements found:', { sidebar: !!sidebar, mainContent: !!mainContent, toggleBtn: !!toggleBtn });

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
    console.log('Applied saved collapsed state');
  }

  // Toggle functionality
  toggleBtn.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Toggle button clicked');
    
    const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
    console.log('Current state before toggle:', isCurrentlyCollapsed ? 'collapsed' : 'expanded');
    
    if (isCurrentlyCollapsed) {
      // Expand sidebar
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('full');
      if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
      localStorage.setItem('sidebarCollapsed', 'false');
      console.log('Sidebar expanded');
    } else {
      // Collapse sidebar
      sidebar.classList.add('collapsed');
      mainContent.classList.add('full');
      if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
      localStorage.setItem('sidebarCollapsed', 'true');
      console.log('Sidebar collapsed');
    }
    
    // Verify final state
    const finalState = sidebar.classList.contains('collapsed');
    console.log('Final state after toggle:', finalState ? 'collapsed' : 'expanded');
  });

  // Add keyboard shortcut (Ctrl/Cmd + B)
  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
      e.preventDefault();
      console.log('Keyboard shortcut triggered');
      toggleBtn.click();
    }
  });

  // Make toggle function globally available for debugging
  window.toggleSidebarDebug = function() {
    console.log('Manual toggle triggered');
    toggleBtn.click();
  };

  console.log('External sidebar toggle functionality initialized');
});