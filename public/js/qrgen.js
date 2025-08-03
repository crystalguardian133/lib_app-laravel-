function generateQr(bookId) {
  const cell = document.getElementById('qrCell-' + bookId);
  cell.innerHTML = '⏳ Generating...';

  fetch(`/books/${bookId}/generate-qr`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(res => res.json())
  .then(data => {
    cell.innerHTML = `<button onclick="showQRModal('${data.title ?? 'Book'}', '${data.qr_url}')" class="btn btn-secondary">📷 Show QR</button>`;
  })
  .catch(() => {
    cell.innerHTML = '<span style="color:red">❌ Failed</span>';
  });
}