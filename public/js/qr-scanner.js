
// QR Code Scanner using html5-qrcode
let html5QrCode;
let qrScannerRunning = false;

function startQRScan(type) {
  const scannerModal = document.getElementById('qrScannerModal');
  scannerModal.style.display = 'block';

  if (!html5QrCode) {
    html5QrCode = new Html5Qrcode("qr-reader");
  }

  Html5Qrcode.getCameras().then(cameras => {
    if (cameras && cameras.length) {
      html5QrCode.start(
        { facingMode: "environment" },
        {
          fps: 10,
          qrbox: 250
        },
        (decodedText, decodedResult) => {
          stopQRScan();
          handleQRScan(decodedText, type);
        },
        errorMessage => {
          // console.log(`QR Code no match: ${errorMessage}`);
        }
      ).then(() => {
        qrScannerRunning = true;
      }).catch(err => {
        console.error("Failed to start QR scanner:", err);
      });
    }
  }).catch(err => {
    console.error("Error getting camera:", err);
  });
}

function stopQRScan() {
  const scannerModal = document.getElementById('qrScannerModal');
  scannerModal.style.display = 'none';

  if (html5QrCode && qrScannerRunning) {
    html5QrCode.stop().then(() => {
      html5QrCode.clear();
      qrScannerRunning = false;
    }).catch(err => {
      console.error("Failed to stop scanner:", err);
    });
  }
}

function handleQRScan(data, type) {
  const bookIdMatch = data.match(/book-(\d+)\.png$/);
  const memberIdMatch = data.match(/\/members\/(\d+)/);

  if (type === 'book' && bookIdMatch) {
    const bookId = bookIdMatch[1];
    const checkbox = document.querySelector('input[type="checkbox"][value="' + bookId + '"]');

    if (checkbox && !checkbox.disabled && !checkbox.checked) {
      checkbox.checked = true;
      const titleCell = checkbox.closest('tr').querySelector('td:nth-child(2)');
      const title = titleCell ? titleCell.textContent : "Unknown Title";

      const ul = document.getElementById('selectedBooksList');
      const li = document.createElement('li');
      li.textContent = title;
      li.setAttribute('data-id', bookId);
      ul.appendChild(li);
    } else {
      showCornerPopup("Book is already selected or not available.");
    }
  }

  if (type === 'member' && memberIdMatch) {
  const memberId = memberIdMatch[1];

  fetch(`/members/${memberId}`)
    .then(res => {
      if (!res.ok) throw new Error("Member not found.");
      return res.json();
    })
    .then(data => {
      if (!data.name) throw new Error("Invalid member data.");
      document.getElementById('memberName').value = data.name;
    })
    .catch(err => {
      console.error("Error fetching member data", err);
      showCornerPopup("❌ " + err.message);
    });
}

}
