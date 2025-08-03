let returnId = null;

function openReturnModal(button) {
  const row = button.closest('tr');
  returnId = row.dataset.id;
  document.getElementById('modalBook').innerText = row.dataset.book;
  document.getElementById('modalMember').innerText = row.dataset.member;
  document.getElementById('returnModal').style.display = 'flex';
}

function closeReturnModal() {
  document.getElementById('returnModal').style.display = 'none';
  returnId = null;
}

function confirmReturn() {
  if (!returnId) return;

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/transactions/${returnId}/return`;

  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const csrf = document.createElement('input');
  csrf.type = 'hidden';
  csrf.name = '_token';
  csrf.value = token;

  form.appendChild(csrf);
  document.body.appendChild(form);
  form.submit();
}
