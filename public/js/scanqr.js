let qrScanner;

  function openScanQRModal() {
    document.getElementById('scanQRModal').style.display = 'flex';

    const qrRegion = document.getElementById("qr-reader");
    qrScanner = new Html5Qrcode("qr-reader");

    qrScanner.start(
      { facingMode: "environment" },
      {
        fps: 10,
        qrbox: { width: 250, height: 250 },
      },
      (decodedText, decodedResult) => {
        // On QR code success
        qrScanner.stop().then(() => {
          document.getElementById('scanQRModal').style.display = 'none';

          // Auto-post to time-log endpoint (assumes route exists)
          const memberId = decodedText.split("/").pop(); // extract ID from route
          fetch(`/time-log/scan/${memberId}`, {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
              "Content-Type": "application/json"
            }
          })
          .then(res => res.json())
          .then(data => {
            alert(data.message || "Successfully scanned!");
            location.reload(); // Refresh table or UI
          })
          .catch(err => {
            console.error("Scan error:", err);
            alert("❌ Error logging time.");
          });
        });
      },
      (errorMessage) => {
        // Optional debug logs
        // console.log(`Scan error: ${errorMessage}`);
      }
    );
  }

  function closeScanQRModal() {
    document.getElementById('scanQRModal').style.display = 'none';
    if (qrScanner) {
      qrScanner.stop().catch(err => console.error("Stop scanner error:", err));
    }
  }