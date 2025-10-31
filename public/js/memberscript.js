// Fixed Register Modal Functions
function openRegisterModal() {
  // Close any other open modals first
  closeAllModals();

  const confirmJulita = confirm("Are you a Julita resident?\nClick OK for Yes, Cancel for No.");

  if (confirmJulita) {
    const modal = document.getElementById("julitaRegisterModal");
    modal.classList.add("active");
    modal.style.display = "flex";
    document.body.classList.add("modal-open");
  } else {
    const modal = document.getElementById("registerModal");
    modal.classList.add("active");
    modal.style.display = "flex";
    document.body.classList.add("modal-open");
  }
}

function closeRegisterModal() {
  const registerModal = document.getElementById("registerModal");
  const julitaModal = document.getElementById("julitaRegisterModal");

  registerModal.classList.remove("active");
  registerModal.style.display = "none";

  julitaModal.classList.remove("active");
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
  const allModals = document.querySelectorAll(".modal-overlay");
  allModals.forEach(modal => {
    modal.classList.remove("active");
    modal.style.display = "none";
  });
  document.body.classList.remove("modal-open");
}

// Add name formatting function
function formatName(name) {
 if (!name) return '';
 
 // Handle hyphenated names and apostrophes
 return name.toLowerCase()
   .split(/[\s-]/)
   .map(part => {
     // Special cases for prefixes and particles
     const prefixes = ['de', 'del', 'dela', 'san', 'santa', 'das', 'dos', 'van', 'von', 'la'];
     if (prefixes.includes(part.toLowerCase())) {
       return part.toLowerCase();
     }
     return part.charAt(0).toUpperCase() + part.slice(1);
   })
   .join(' ')
   .replace(/\s-\s/g, '-'); // Fix spacing around hyphens
}

// Submit member registration form - Updated to handle modal closing properly
function submitRegister() {
 const julitaModal = document.getElementById("julitaRegisterModal");
 const registerModal = document.getElementById("registerModal");
 
 const isJulitaOpen = julitaModal.classList.contains("active") || julitaModal.style.display === "flex";
 const modal = isJulitaOpen ? julitaModal : registerModal;

 const getTrimmedValue = (selectors) => {
   if (typeof selectors === 'string') selectors = [selectors];
   for (const selector of selectors) {
     const element = modal.querySelector(selector);
     if (element) return element.value.trim();
   }
   return '';
 };

 // Get form values
 const formData = new FormData();
 
 // Required fields with name formatting
 formData.append("firstName", formatName(getTrimmedValue(['#julitaFirstName', '#firstName'])));
 formData.append("lastName", formatName(getTrimmedValue(['#julitaLastName', '#lastName'])));
 formData.append("middleName", formatName(getTrimmedValue(['#julitaMiddleName', '#middleName'])) || "null");
 formData.append("age", getTrimmedValue(['#julitaAge', '#age']));
 formData.append("barangay", formatName(getTrimmedValue(['#julitaBarangay', '#barangay'])));
 formData.append("municipality", formatName(getTrimmedValue(['#julitaMunicipality', '#municipality'])));
 formData.append("province", formatName(getTrimmedValue(['#julitaProvince', '#province'])));
 formData.append("contactNumber", getTrimmedValue(['#julitaContactNumber', '#contactNumber']));

 // Optional fields - explicitly set to null if empty
 formData.append("houseNumber", getTrimmedValue(['#julitaHouseNumber', '#houseNumber']) || "null");
 formData.append("street", formatName(getTrimmedValue(['#julitaStreet', '#street'])) || "null");
 formData.append("school", formatName(getTrimmedValue(['#julitaSchool', '#school'])) || "null");

 // Additional fields
 formData.append("memberdate", new Date().toISOString().split("T")[0]);
 formData.append("member_time", "60");

 // Handle photo
 const photoInput = modal.querySelector('#photo') || modal.querySelector('#julitaPhoto');
 if (photoInput?.files[0]) {
   formData.append("photo", photoInput.files[0]);
 }

 // Show loading state
 const submitBtn = modal.querySelector('button[onclick="submitRegister()"]');
 const originalText = submitBtn.innerHTML;
 submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';
 submitBtn.disabled = true;

 // Submit the form
 fetch("/members", {
   method: "POST",
   headers: {
     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
     'Accept': 'application/json'
   },
   body: formData
 })
 .then(async response => {
   const data = await response.json();
   
   if (!response.ok) {
     // Format validation errors nicely
     if (data.errors) {
       const errorMessages = Object.values(data.errors)
         .flat()
         .join('\n');
       throw new Error(errorMessages);
     }
     throw new Error(data.message || 'Registration failed');
   }
   
   return data;
 })
 .then(data => {
   alert("✅ Member registered successfully!");
   closeRegisterModal();
   location.reload();
 })
 .catch(error => {
   console.error("Registration error:", error);
   alert("🚫 " + error.message);
 })
 .finally(() => {
   submitBtn.innerHTML = originalText;
   submitBtn.disabled = false;
 });
}

// Photo preview is now handled by photoprev.js

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
   const openModals = document.querySelectorAll('.modal-overlay.active');

   if (openModals.length === 0) return;

   if (e.key === "Escape") {
     e.preventDefault();
     closeAllModals();
   } else if (e.key === "Enter" && e.ctrlKey) {
     e.preventDefault();
     // Only submit if it's a register modal that's open
     const isRegisterOpen = document.getElementById("registerModal").classList.contains("active");
     const isJulitaOpen = document.getElementById("julitaRegisterModal").classList.contains("active");
     
     if (isRegisterOpen || isJulitaOpen) {
       submitRegister();
     }
   }
 });

 // Click outside modal to close
 document.addEventListener('click', function(e) {
   if (e.target.classList.contains('modal-overlay') && e.target.classList.contains('active')) {
     if (e.target.id === 'registerModal' || e.target.id === 'julitaRegisterModal') {
       closeRegisterModal();
     }
   }
 });
});

// Submit Julita member registration form with validation
function submitJulitaRegister() {
 const julitaModal = document.getElementById("julitaRegisterModal");

 // Validate required fields
 const requiredFields = [
   { selector: '#julitaFirstName', label: 'First Name' },
   { selector: '#julitaLastName', label: 'Last Name' },
   { selector: '#julitaAge', label: 'Age' },
   { selector: '#julitaBarangay', label: 'Barangay' },
   { selector: '#julitaMunicipality', label: 'Municipality' },
   { selector: '#julitaProvince', label: 'Province' },
   { selector: '#julitaContactNumber', label: 'Contact Number' }
 ];

 for (const field of requiredFields) {
   const element = julitaModal.querySelector(field.selector);
   if (!element || !element.value.trim()) {
     alert(`❌ Please fill in all required fields.`);
     if (element) {
       element.focus();
       element.scrollIntoView({ behavior: 'smooth', block: 'center' });
     }
     return;
   }
 }

 // Validate contact number format (11 digits)
 const contactInput = julitaModal.querySelector('#julitaContactNumber');
 if (contactInput && contactInput.value.trim()) {
   const contactValue = contactInput.value.trim();
   if (!/^[0-9]{11}$/.test(contactValue)) {
     alert("❌ Contact number must be exactly 11 digits.");
     contactInput.focus();
     return;
   }
 }

 // If validation passes, call the main submit function
 submitRegister();
}

// Submit regular member registration form with validation
function submitRegister() {
 const julitaModal = document.getElementById("julitaRegisterModal");
 const registerModal = document.getElementById("registerModal");

 const isJulitaOpen = julitaModal.classList.contains("active") || julitaModal.style.display === "flex";
 const modal = isJulitaOpen ? julitaModal : registerModal;

 // Validate required fields based on which modal is open
 let requiredFields = [];
 if (isJulitaOpen) {
   requiredFields = [
     { selector: '#julitaFirstName', label: 'First Name' },
     { selector: '#julitaLastName', label: 'Last Name' },
     { selector: '#julitaAge', label: 'Age' },
     { selector: '#julitaBarangay', label: 'Barangay' },
     { selector: '#julitaMunicipality', label: 'Municipality' },
     { selector: '#julitaProvince', label: 'Province' },
     { selector: '#julitaContactNumber', label: 'Contact Number' }
   ];
 } else {
   requiredFields = [
     { selector: '#firstName', label: 'First Name' },
     { selector: '#lastName', label: 'Last Name' },
     { selector: '#age', label: 'Age' },
     { selector: '#barangay', label: 'Barangay' },
     { selector: '#municipality', label: 'Municipality' },
     { selector: '#province', label: 'Province' },
     { selector: '#contactNumber', label: 'Contact Number' }
   ];
 }

 // Check required fields
 for (const field of requiredFields) {
   const element = modal.querySelector(field.selector);
   if (!element || !element.value.trim()) {
     alert(`❌ Please fill in all required fields.`);
     if (element) {
       element.focus();
       element.scrollIntoView({ behavior: 'smooth', block: 'center' });
     }
     return;
   }
 }

 // Validate contact number format (11 digits)
 const contactSelector = isJulitaOpen ? '#julitaContactNumber' : '#contactNumber';
 const contactInput = modal.querySelector(contactSelector);
 if (contactInput && contactInput.value.trim()) {
   const contactValue = contactInput.value.trim();
   if (!/^[0-9]{11}$/.test(contactValue)) {
     alert("❌ Contact number must be exactly 11 digits.");
     contactInput.focus();
     return;
   }
 }

 const getTrimmedValue = (selectors) => {
   if (typeof selectors === 'string') selectors = [selectors];
   for (const selector of selectors) {
     const element = modal.querySelector(selector);
     if (element) return element.value.trim();
   }
   return '';
 };

 // Get form values
 const formData = new FormData();

 // Required fields with name formatting
 formData.append("firstName", formatName(getTrimmedValue(['#julitaFirstName', '#firstName'])));
 formData.append("lastName", formatName(getTrimmedValue(['#julitaLastName', '#lastName'])));
 formData.append("middleName", formatName(getTrimmedValue(['#julitaMiddleName', '#middleName'])) || "null");
 formData.append("age", getTrimmedValue(['#julitaAge', '#age']));
 formData.append("barangay", formatName(getTrimmedValue(['#julitaBarangay', '#barangay'])));
 formData.append("municipality", formatName(getTrimmedValue(['#julitaMunicipality', '#municipality'])));
 formData.append("province", formatName(getTrimmedValue(['#julitaProvince', '#province'])));
 formData.append("contactNumber", getTrimmedValue(['#julitaContactNumber', '#contactNumber']));

 // Optional fields - explicitly set to null if empty
 formData.append("houseNumber", getTrimmedValue(['#julitaHouseNumber', '#houseNumber']) || "null");
 formData.append("street", formatName(getTrimmedValue(['#julitaStreet', '#street'])) || "null");
 formData.append("school", formatName(getTrimmedValue(['#julitaSchool', '#school'])) || "null");

 // Additional fields
 formData.append("memberdate", new Date().toISOString().split("T")[0]);
 formData.append("member_time", "60");

 // Handle photo
 const photoInput = modal.querySelector('#photo') || modal.querySelector('#julitaPhoto');
 if (photoInput?.files[0]) {
   formData.append("photo", photoInput.files[0]);
 }

 // Show loading state
 const submitBtn = modal.querySelector('button[onclick*="submitRegister"]') || modal.querySelector('button[onclick*="submitJulitaRegister"]');
 const originalText = submitBtn.innerHTML;
 submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';
 submitBtn.disabled = true;

 // Submit the form
 fetch("/members", {
   method: "POST",
   headers: {
     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
     'Accept': 'application/json'
   },
   body: formData
 })
 .then(async response => {
   const data = await response.json();

   if (!response.ok) {
     // Format validation errors nicely
     if (data.errors) {
       const errorMessages = Object.values(data.errors)
         .flat()
         .join('\n');
       throw new Error(errorMessages);
     }
     throw new Error(data.message || 'Registration failed');
   }

   return data;
 })
 .then(data => {
   alert("✅ Member registered successfully!");
   closeRegisterModal();
   location.reload();
 })
 .catch(error => {
   console.error("Registration error:", error);
   alert("🚫 " + error.message);
 })
 .finally(() => {
   submitBtn.innerHTML = originalText;
   submitBtn.disabled = false;
 });
}

// Optional export for testing
window.testSubmit = submitRegister;