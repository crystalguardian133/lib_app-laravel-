function showQRModal(title, qrUrl) {
    const modal = document.getElementById('qrModal');
    const modalTitle = document.getElementById('qrBookTitle');
    const qrImage = document.getElementById('qrImage');
    const downloadLink = document.getElementById('downloadLink');

    // Clear previous image
    qrImage.src = '';
    qrImage.alt = '';

    // Slight delay to force repaint
    setTimeout(() => {
        qrImage.src = qrUrl + '?v=' + new Date().getTime(); // force refresh
        qrImage.alt = `${title} QR Code`;

        modalTitle.textContent = `${title} - QR Code`;

        // Setup download
        const fileName = title.toLowerCase().replace(/\s+/g, '_') + '_qr.png';
        downloadLink.href = qrUrl;
        downloadLink.download = fileName;

        modal.style.display = 'flex';
    }, 100); // small delay helps the browser repaint
}
function closeQRModal() {
    document.getElementById('qrModal').style.display = 'none';
}
function showMemberQRModal(name, url) {
  const modal = document.getElementById('memberQrModal');
  document.getElementById('qrMemberTitle').textContent = `${name} - QR Code`;
  document.getElementById('qrMemberImage').src = url + '?v=' + Date.now(); // cache bust
  document.getElementById('memberDownloadLink').href = url;
  document.getElementById('memberDownloadLink').download = `${name.replace(/\s+/g, '_').toLowerCase()}_qr.png`;
  modal.style.display = 'flex';
}

function closeMemberQRModal() {
  document.getElementById('memberQrModal').style.display = 'none';
}