function generateQr(bookId) {
  const cell = document.getElementById('qrCell-' + bookId);
  cell.innerHTML = '⏳ Generating...';

  fetch(`/books/${bookId}/generate-qr`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json', // ✅ Ensure Laravel returns JSON
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ book_id: bookId }) // ✅ send payload
  })
  .then(async res => {
    if (!res.ok) {
      let text = await res.text();
      throw new Error(text || 'Failed to generate QR');
    }
    return res.json();
  })
  .then(data => {
    if (data.qr_url) {
      cell.innerHTML = `
        <button onclick="showQRModal('${data.title ?? 'Book'}', '${data.qr_url}')" 
                class="btn btn-secondary">📷 Show QR</button>`;
    } else {
      cell.innerHTML = '<span style="color:red">⚠️ QR not generated</span>';
    }
  })
  .catch(err => {
    console.error("QR generation error:", err);
    cell.innerHTML = '<span style="color:red">❌ Failed</span>';
  });
}
