// Fixed Register Modal Functions
function openRegisterModal() {
  // Close any other open modals first
  closeAllModals();
  
  const confirmJulita = confirm("Are you a Julita resident?\nClick OK for Yes, Cancel for No.");

  if (confirmJulita) {
    const modal = document.getElementById("julitaRegisterModal");
    modal.classList.add("show");
    modal.style.display = "flex";
    document.body.classList.add("modal-open");
  } else {
    const modal = document.getElementById("registerModal");
    modal.classList.add("show");
    modal.style.display = "flex";
    document.body.classList.add("modal-open");
  }
}

function closeRegisterModal() {
  const registerModal = document.getElementById("registerModal");
  const julitaModal = document.getElementById("julitaRegisterModal");
  
  registerModal.classList.remove("show");
  registerModal.style.display = "none";
  
  julitaModal.classList.remove("show");
  julitaModal.style.display = "none";
  
  document.body.classList.remove("modal-open");
  
  // Clear forms
  const registerForm = document.getElementById("registerForm");
  const julitaForm = document.getElementById("julitaRegisterForm");
  if (registerForm) registerForm.reset();
  if (julitaForm) julitaForm.reset();
  
  // Clear photo previews
  const previews = document.querySelectorAll("#photoPreview");
  previews.forEach(preview => {
    preview.src = "";
    preview.style.display = "none";
  });
}

function closeJulitaRegisterModal() {
  closeRegisterModal(); // Use the same close function
}

// Close all modals function
function closeAllModals() {
  const allModals = document.querySelectorAll(".modal");
  allModals.forEach(modal => {
    modal.classList.remove("show");
    modal.style.display = "none";
  });
  document.body.classList.remove("modal-open");
}

// Submit member registration form - Updated to handle modal closing properly
function submitRegister() {
  const julitaModal = document.getElementById("julitaRegisterModal");
  const registerModal = document.getElementById("registerModal");
  
  // Determine which modal is open
  const isJulitaOpen = julitaModal.classList.contains("show") || julitaModal.style.display === "flex";
  const modal = isJulitaOpen ? julitaModal : registerModal;

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

  // Validation
  if (
    firstName === '' || lastName === '' ||
    age === '' || isNaN(age) ||
    barangay === '' || municipality === '' ||
    province === '' || contactNumber === ''
  ) {
    alert("Please fill in all required fields.");
    return;
  }

  // Show loading state
  const submitBtn = modal.querySelector('button[onclick="submitRegister()"]');
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';
  submitBtn.disabled = true;

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
      closeRegisterModal();
      location.reload();
    })
    .catch(err => {
      console.error("Registration failed:", err);
      alert("🚫 Registration failed: " + err.message);
    })
    .finally(() => {
      // Restore button state
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    });
}

// Setup photo preview
document.addEventListener('change', function (e) {
  if (e.target && e.target.matches("#photo")) {
    const modal = e.target.closest(".modal");
    const preview = modal?.querySelector("#photoPreview");
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
  if (!table) return;

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

// SEARCH FUNCTION
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll("#membersTable tbody tr");

      rows.forEach(row => {
        const nameCell = row.cells[0];
        const addressCell = row.cells[2];
        const contactCell = row.cells[3];
        
        const name = nameCell ? nameCell.textContent.toLowerCase() : '';
        const address = addressCell ? addressCell.textContent.toLowerCase() : '';
        const contact = contactCell ? contactCell.textContent.toLowerCase() : '';
        
        const shouldShow = name.includes(filter) || address.includes(filter) || contact.includes(filter);
        row.style.display = shouldShow ? "" : "none";
      });
    });
  }
});

// Enhanced Modal listeners
document.addEventListener('DOMContentLoaded', function () {
  // Register button click handler
  const registerBtn = document.querySelector('button[onclick="openRegisterModal()"]');
  if (registerBtn) {
    registerBtn.addEventListener('click', function(e) {
      e.preventDefault();
      openRegisterModal();
    });
  }

  // Global key listeners
  document.addEventListener('keydown', function (e) {
    const openModals = document.querySelectorAll('.modal.show');
    
    if (openModals.length === 0) return;

    if (e.key === "Escape") {
      e.preventDefault();
      closeAllModals();
    } else if (e.key === "Enter" && e.ctrlKey) {
      e.preventDefault();
      // Only submit if it's a register modal that's open
      const isRegisterOpen = document.getElementById("registerModal").classList.contains("show");
      const isJulitaOpen = document.getElementById("julitaRegisterModal").classList.contains("show");
      
      if (isRegisterOpen || isJulitaOpen) {
        submitRegister();
      }
    }
  });

  // Click outside modal to close
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
      if (e.target.id === 'registerModal' || e.target.id === 'julitaRegisterModal') {
        closeRegisterModal();
      }
    }
  });
});

// Optional export for testing
window.testSubmit = submitRegister;