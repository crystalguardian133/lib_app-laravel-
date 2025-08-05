let borrowQrScanner = null;
let currentBorrowScanType = null;

// Open QR Scanner Modal
function startQRScan(type) {
  currentBorrowScanType = type;
  const modal = document.getElementById('qrScannerModal');
  modal.style.display = 'flex';

  if (!borrowQrScanner) {
    borrowQrScanner = new Html5Qrcode("qr-reader");
  }

  borrowQrScanner.start(
    { facingMode: "environment" },
    {
      fps: 10,
      qrbox: { width: 250, height: 250 },
    },
    (decodedText) => {
      stopQRScan();

      if (type === 'member') {
        handleMemberQR(decodedText);
      } else if (type === 'book') {
        handleBookQR(decodedText);
      }
    },
    (error) => {
      // optional logging
    }
  ).catch(err => {
    console.error("Camera error:", err);
    alert("❌ Unable to access camera.");
    modal.style.display = 'none';
  });
}

// Stop QR Scanner
function stopQRScan() {
  if (borrowQrScanner) {
    borrowQrScanner.stop().then(() => {
      borrowQrScanner.clear();
      document.getElementById('qrScannerModal').style.display = 'none';
    }).catch(err => console.error("Scanner stop error:", err));
  }
}

// Handle Scanned Member QR Code (using web route)
function handleMemberQR(data) {
  let memberId = null;

  try {
    const url = new URL(data);
    const parts = url.pathname.split('/');
    if (parts[1] === 'members') {
      memberId = parts[2];
    }
  } catch {
    memberId = data.split('/').pop(); // fallback
  }

  if (!memberId || isNaN(memberId)) {
    showCornerPopup("❌ Invalid Member QR Code");
    return;
  }

  fetch(`/members/${memberId}`)
    .then(res => {
      if (!res.ok) throw new Error('Not Found');
      return res.json();
    })
    .then(data => {
      const nameParts = [
        data.first_name,
        (data.middle_name !== "null" && data.middle_name) ? data.middle_name : null,
        (data.last_name !== "null" && data.last_name) ? data.last_name : null
      ].filter(Boolean); // removes null/empty values

      const fullName = nameParts.join(" ");

      // Set full name in input (readonly)
      document.getElementById('memberName').value = fullName;
      document.getElementById('memberName').setAttribute('readonly', 'true');
      document.getElementById('memberName').classList.add('readonly');

      // Store member ID separately (to send in payload)
      document.getElementById('memberId').value = data.id;

      // Hide suggestion box (if open)
      document.getElementById('suggestionBox').innerHTML = '';
      document.getElementById('suggestionBox').style.display = 'none';

      showCornerPopup(`👤 Member: ${fullName}`);
    })
    .catch(err => {
      console.error("Fetch member error:", err);
      showCornerPopup("❌ Error fetching member");
    });
}


// Handle Scanned Book QR Code
function handleBookQR(data) {
  let bookId = null;

  try {
    const url = new URL(data);
    const parts = url.pathname.split('/');
    if (parts[1] === 'books') {
      bookId = parts[2];
    }
  } catch {
    const match = data.match(/book-(\d+)\.png/);
    if (match) bookId = match[1];
    else bookId = data.split('/').pop();
  }

  if (!bookId || isNaN(bookId)) {
    showCornerPopup("❌ Invalid Book QR Code");
    return;
  }

  const checkbox = document.querySelector(`input[type="checkbox"][value="${bookId}"]`);

  if (checkbox && !checkbox.checked && !checkbox.disabled) {
    checkbox.checked = true;

    const row = checkbox.closest('tr');
    const title = row.querySelector('td:nth-child(2)').textContent;

    const alreadyAdded = [...document.querySelectorAll('#selectedBooksList li')]
      .some(li => li.textContent.includes(title));
    if (alreadyAdded) {
      return showCornerPopup('⚠️ Book already selected');
    }

    const listItem = document.createElement('li');
    listItem.textContent = title;
    document.getElementById('selectedBooksList').appendChild(listItem);

    showCornerPopup(`📚 Book added: ${title}`);
  } else if (checkbox && checkbox.disabled) {
    showCornerPopup("⚠️ No copies available.");
  } else {
    showCornerPopup("❌ Book not found or already selected.");
  }
}

// Popup Notification (bottom-right)
function showCornerPopup(message) {
  let popup = document.getElementById('corner-popup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'corner-popup';
    popup.className = 'corner-popup';
    popup.style.position = 'fixed';
    popup.style.bottom = '20px';
    popup.style.right = '20px';
    popup.style.background = '#222';
    popup.style.color = '#fff';
    popup.style.padding = '10px 20px';
    popup.style.borderRadius = '5px';
    popup.style.zIndex = '9999';
    document.body.appendChild(popup);
  }

  popup.innerText = message;
  popup.style.display = 'block';
  setTimeout(() => {
    popup.style.display = 'none';
  }, 3000);
}
