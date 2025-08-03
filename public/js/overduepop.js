document.addEventListener('DOMContentLoaded', () => {
    const overdueNames = json($overdueMembers);

    if (overdueNames.length > 0) {
      const popup = document.getElementById('overduePopup');
      const list = document.getElementById('overdueList');

      overdueNames.forEach(name => {
        const li = document.createElement('li');
        li.textContent = name;
        list.appendChild(li);
      });

      popup.classList.remove('hidden');

      setTimeout(() => {
        popup.classList.add('hidden');
      }, 8000);
    }
  });