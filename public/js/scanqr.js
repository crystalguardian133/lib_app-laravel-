let qrScanner;

document.addEventListener('DOMContentLoaded', function() {
  const startBtn = document.getElementById('startScannerBtn');
  const stopBtn = document.getElementById('stopScannerBtn');
  const qrReader = document.getElementById('qr-reader');
  const instruction = document.getElementById('qr-instruction');

  if (startBtn && stopBtn && qrReader) {
    startBtn.addEventListener('click', startScanner);
    stopBtn.addEventListener('click', stopScanner);

    // Autostart the scanner
    startScanner();
  }

  function startScanner() {
    if (qrScanner) {
      qrScanner.stop().catch(err => console.error("Stop existing scanner error:", err));
    }

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
          qrScanner = null;
          startBtn.style.display = 'inline-flex';
          stopBtn.style.display = 'none';
          instruction.textContent = 'Point your camera at a QR code to scan';

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
    ).then(() => {
      startBtn.style.display = 'none';
      stopBtn.style.display = 'inline-flex';
      instruction.textContent = 'Scanning... Point your camera at a QR code';
    }).catch(err => {
      console.error("Start scanner error:", err);
      alert("❌ Error starting scanner. Please check camera permissions.");
    });
  }

  function stopScanner() {
    if (qrScanner) {
      qrScanner.stop().then(() => {
        qrScanner = null;
        startBtn.style.display = 'inline-flex';
        stopBtn.style.display = 'none';
        instruction.textContent = 'Point your camera at a QR code to scan';
      }).catch(err => console.error("Stop scanner error:", err));
    }
  }
});