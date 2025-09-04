document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('addBookForm');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('/books', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: formData,
      });

      if (!response.ok) {
        const errorText = await response.text();
        console.error('Error Response:', errorText);
        showCornerPopup('Failed to add book. Check the console for details.');
        return;
      }

      const result = await response.json();
      showCornerPopup(result.message || 'Book added successfully!');
      closeAddBookModal();
      form.reset();

      setTimeout(() => location.reload(), 1000); // optional: refresh after 1 sec
    } catch (error) {
      console.error('Error:', error);
      showCornerPopup('Error occurred while adding book.');
    }
  });
});

function openAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.style.display = 'block';
    modal.classList.add('show');
  }
}

function closeAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.style.display = 'none';
    modal.classList.remove('show');
  }
}

function showCornerPopup(message) {
  let popup = document.getElementById('corner-popup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'corner-popup';
    popup.className = 'corner-popup';
    popup.style.position = 'fixed';
    popup.style.bottom = '20px';
    popup.style.right = '20px';
    popup.style.background = '#333';
    popup.style.color = '#fff';
    popup.style.padding = '10px 15px';
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

function previewCover(event) {
  const file = event.target.files[0];
  const previewBox = document.getElementById('coverPreview');
  previewBox.innerHTML = ''; // clear previous preview

  if (file) {
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.maxWidth = '150px';
    img.style.marginTop = '10px';
    img.alt = 'Cover Preview';
    previewBox.appendChild(img);
  }
}
let qrScanner;

function startQRScan(type) {
  document.getElementById('qrScannerModal').style.display = 'block';
  qrScanner = new Html5Qrcode("qr-reader");

  qrScanner.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    async (decodedText) => {
      stopQRScan();

      if (type === 'member') {
        const res = await fetch(`/api/lookup-member?qr=${encodeURIComponent(decodedText)}`);
        const data = await res.json();
        if (data && data.name) {
          document.querySelector('#member_name').value = data.name;
        } else {
          showCornerPopup("Member not found");
        }
      } else if (type === 'book') {
        const checkbox = document.querySelector(`input[data-qr="${decodedText}"]`);
        if (checkbox && !checkbox.disabled) {
          checkbox.checked = true;
          showCornerPopup("Book selected via QR");
        } else {
          showCornerPopup("Book not found or unavailable");
        }
      }
    },
    error => console.warn(`QR scan error: ${error}`)
  );
}

function stopQRScan() {
  if (qrScanner) {
    qrScanner.stop().then(() => {
      document.getElementById('qrScannerModal').style.display = 'none';
    }).catch(console.error);
  }
}
