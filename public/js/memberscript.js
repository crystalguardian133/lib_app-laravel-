// Open modal and auto-fill today's date
function openRegisterModal() {
  const confirmJulita = confirm("Are you a Julita resident?\nClick OK for Yes, Cancel for No.");

  if (confirmJulita) {
    document.getElementById("julitaRegisterModal").style.display = "block";
  } else {
    document.getElementById("registerModal").style.display = "block";
  }
}

function closeRegisterModal() {
  document.getElementById("registerModal").style.display = "none";
}

function closeJulitaRegisterModal() {
  document.getElementById("julitaRegisterModal").style.display = "none";
}

// Submit member registration form
function submitRegister() {
  const modal = document.getElementById("julitaRegisterModal").style.display === "block"
    ? document.getElementById("julitaRegisterModal")
    : document.getElementById("registerModal");

  const getTrimmedValue = (selector) => modal.querySelector(selector)?.value?.trim() || '';

  const firstName = getTrimmedValue("#firstName");
  const middleName = getTrimmedValue("#middleName") || null;
  const lastName = getTrimmedValue("#lastName");
  const age = modal.querySelector("#age")?.value || '';
  const houseNumber = getTrimmedValue("#houseNumber") || null;
  const street = getTrimmedValue("#street") || null;
  const barangay = getTrimmedValue("#barangay");
  const municipality = getTrimmedValue("#municipality");
  const province = getTrimmedValue("#province");
  const contactNumber = getTrimmedValue("#contactNumber");
  const school = getTrimmedValue("#school") || null;
  const photoInput = modal.querySelector("#photo");

  const memberdate = new Date().toISOString().split("T")[0];
  const member_time = 60;

  if (
    firstName === '' || lastName === '' ||
    age === '' || isNaN(age) ||
    barangay === '' || municipality === '' ||
    province === '' || contactNumber === ''
  ) {
    alert("Please fill in all required fields.");
    return;
  }

  const formData = new FormData();
  formData.append("firstName", firstName);
  formData.append("middleName", middleName);
  formData.append("lastName", lastName);
  formData.append("age", age);
  formData.append("houseNumber", houseNumber);
  formData.append("street", street);
  formData.append("barangay", barangay);
  formData.append("municipality", municipality);
  formData.append("province", province);
  formData.append("contactNumber", contactNumber);
  formData.append("school", school);
  formData.append("memberdate", memberdate);
  formData.append("member_time", member_time);

  if (photoInput && photoInput.files.length > 0) {
    formData.append("photo", photoInput.files[0]);
  }

  fetch("/members", {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: formData
  })
    .then(async response => {
      const contentType = response.headers.get("content-type");
      const text = await response.text();

      if (!response.ok) {
        throw new Error(`Server error (${response.status}): ${text}`);
      }

      if (contentType && contentType.includes("application/json")) {
        return JSON.parse(text);
      } else {
        throw new Error("Unexpected response: " + text);
      }
    })
    .then(data => {
      alert(data.message || "✅ Member registered successfully.");
      location.reload();
    })
    .catch(err => {
      console.error("Registration failed:", err);
      alert("🚫 Registration failed: " + err.message);
    });
}

// Setup photo preview
document.addEventListener('change', function (e) {
  if (e.target && e.target.matches("#photo")) {
    const modal = e.target.closest(".modal");
    const preview = modal?.querySelector("#photo-preview");
    const file = e.target.files[0];
    if (preview) {
      if (file) {
        const reader = new FileReader();
        reader.onload = evt => {
          preview.src = evt.target.result;
          preview.style.display = "block";
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = "";
        preview.style.display = "none";
      }
    }
  }
});

// SORT FUNCTION
document.addEventListener("DOMContentLoaded", function () {
  const table = document.getElementById("membersTable");
  if (!table) return; // Guard clause

  const headers = table.querySelectorAll("th");
  const tableBody = table.querySelector("tbody");
  let sortDirection = true;

  headers.forEach((header, columnIndex) => {
    header.addEventListener("click", () => {
      const rowsArray = Array.from(tableBody.querySelectorAll("tr"));

      rowsArray.sort((a, b) => {
        const aText = a.children[columnIndex].textContent.trim();
        const bText = b.children[columnIndex].textContent.trim();

        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);

        if (!isNaN(aNum) && !isNaN(bNum)) {
          return sortDirection ? aNum - bNum : bNum - aNum;
        } else {
          return sortDirection
            ? aText.localeCompare(bText)
            : bText.localeCompare(aText);
        }
      });

      sortDirection = !sortDirection;
      rowsArray.forEach(row => tableBody.appendChild(row));
    });
  });
});

// SEARCH FUNCTION - Fixed ID to match HTML
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById("searchInput"); // Corrected ID
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll("#membersTable tbody tr");

      rows.forEach(row => {
        const nameCell = row.cells[0]; // Name column (adjusted for new table structure)
        const addressCell = row.cells[2]; // Address column  
        const contactCell = row.cells[3]; // Contact column
        
        const name = nameCell ? nameCell.textContent.toLowerCase() : '';
        const address = addressCell ? addressCell.textContent.toLowerCase() : '';
        const contact = contactCell ? contactCell.textContent.toLowerCase() : '';
        
        const shouldShow = name.includes(filter) || address.includes(filter) || contact.includes(filter);
        row.style.display = shouldShow ? "" : "none";
      });
    });
  }
});

// Modal open listener and key listeners
document.addEventListener('DOMContentLoaded', function () {
  const registerBtn = document.getElementById('registerBtn');
  if (registerBtn) {
    registerBtn.addEventListener('click', openRegisterModal);
  }

  document.addEventListener('keydown', function (e) {
    const isRegisterOpen = document.getElementById("registerModal")?.style.display === "block";
    const isJulitaOpen = document.getElementById("julitaRegisterModal")?.style.display === "block";

    if (!isRegisterOpen && !isJulitaOpen) return;

    if (e.key === "Escape") {
      closeRegisterModal();
      closeJulitaRegisterModal();
    } else if (e.key === "Enter") {
      e.preventDefault();
      submitRegister();
    }
  });
});

// Optional export for testing
window.testSubmit = submitRegister;