// Handle modal open/close
  document.getElementById('registerBtn').addEventListener('click', openRegisterModal);

function openRegisterModal() {
  document.getElementById('registerModal').style.display = 'flex';

  // Set today's date for "Member Since"
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('memberdate').value = today;
}

function closeRegisterModal() {
  document.getElementById('registerModal').style.display = 'none';
}

function submitRegister() {
  const formData = new FormData();
  const name = document.getElementById("name").value;
  const age = document.getElementById("age").value;
  const address = document.getElementById("address").value;
  const contactnumber = document.getElementById("contactnumber").value;
  const school = document.getElementById("school").value;
  const memberdate = new Date().toISOString().split("T")[0]; // YYYY-MM-DD
  const member_time = 60; // default time in minutes

  // Basic validation
  if (!name || !age || !address || !contactnumber || !school) {
    alert("Please fill in all required fields.");
    return;
  }

  formData.append("name", name);
  formData.append("age", age);
  formData.append("address", address);
  formData.append("contactnumber", contactnumber);
  formData.append("school", school);
  formData.append("memberdate", memberdate);
  formData.append("member_time", member_time);

  fetch("/members", {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: formData
  })
  .then(response => {
    if (!response.ok) throw new Error("Server error");
    const contentType = response.headers.get("content-type");
    if (contentType && contentType.includes("application/json")) {
      return response.json();
    } else {
      return response.text().then(text => {
        throw new Error("Unexpected response: " + text);
      });
    }
  })
  .then(data => {
    alert(data.message || "✅ Member registered.");
    location.reload();
  })
  .catch(err => {
    console.error("Upload error:", err);
    alert("🚫 Something went wrong. Check console for details.");
  });
}


// (Optional) Photo preview setup
const photoInput = document.getElementById("photo");
const photoPreview = document.getElementById("photo-preview");

if (photoInput && photoPreview) {
  photoInput.addEventListener("change", () => {
    const file = photoInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        photoPreview.src = e.target.result;
        photoPreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      photoPreview.src = "";
      photoPreview.style.display = "none";
    }
  });
}

document.addEventListener('keydown', function(e) {
  if (e.key === "Escape") {
    closeRegisterModal();
  }
  if (e.key === "Enter"){
    submitRegister();
  }
});
