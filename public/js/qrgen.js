window.generateQr = generateQr;

function generateQr(bookId) {
  const row = document.querySelector(`tr[data-id="${bookId}"]`);
  if (!row) {
    showToast('Book not found', 'error');
    return;
  }

  const token = document.querySelector('meta[name="csrf-token"]').content;
  if (!token) {
    showToast('CSRF token missing', 'error');
    return;
  }

  // Show loading state
  const button = row.querySelector('.btn[onclick*="generateQr"]');
  const originalText = button.innerHTML;
  button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Gen';
  button.disabled = true;

  fetch(`/books/${bookId}/generate-qr`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': token,
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    if (!response.ok) throw new Error('Failed to generate QR');
    return response.json();
  })
  .then(data => {
    if (data.qr_url) {
      // Update the row data
      row.dataset.qrUrl = data.qr_url;

      // Update the button to show QR instead of Gen
      const qrButton = row.querySelector('.btn[onclick*="generateQr"]');
      if (qrButton) {
        qrButton.innerHTML = '<i class="fas fa-qrcode"></i>';
        qrButton.setAttribute('onclick', `showQRModal('${row.dataset.title}', '${data.qr_url}')`);
        qrButton.title = 'View QR Code';
      }

      showToast('QR code generated successfully', 'success');
    } else {
      throw new Error('No QR URL received');
    }
  })
  .catch(error => {
    console.error('QR generation error:', error);
    showToast('Failed to generate QR code', 'error');
  })
  .finally(() => {
    // Reset button state
    button.innerHTML = originalText;
    button.disabled = false;
  });
}
