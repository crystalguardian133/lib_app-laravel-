// Open the edit modal and load member info
function openEditModal(memberId = null) {
  if (!memberId) {
    const selected = document.querySelector('input[name="memberCheckbox"]:checked');
    if (!selected) {
      alert("Please select a member to edit.");
      return;
    }
    memberId = selected.value;
  }

  fetch(`/members/${memberId}`)
    .then(response => {
      if (!response.ok) throw new Error("Failed to load member info");
      return response.json();
    })
    .then(data => {
      document.getElementById("editMemberId").value = data.id;
      document.getElementById("editFirstName").value = data.first_name || '';
      document.getElementById("editMiddleName").value = data.middle_name || '';
      document.getElementById("editLastName").value = data.last_name || '';
      document.getElementById("editAge").value = data.age || '';
      document.getElementById("editHouseNumber").value = data.house_number || '';
      document.getElementById("editStreet").value = data.street || '';
      document.getElementById("editBarangay").value = data.barangay || '';
      document.getElementById("editMunicipality").value = data.municipality || '';
      document.getElementById("editProvince").value = data.province || '';
      document.getElementById("editContactNumber").value = data.contactnumber || '';
      document.getElementById("editSchool").value = data.school || '';

      // Show modal
      document.getElementById("editModal").style.display = "flex";
    })
    .catch(err => {
      console.error("Edit modal error:", err);
      alert("❌ Failed to load member info.");
    });
}

// Close the edit modal
function closeEditModal() {
  document.getElementById("editModal").style.display = "none";
}

// Handle form submit (update member)
document.getElementById("editForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const memberId = document.getElementById("editMemberId").value;

  const formData = {
    firstName: document.getElementById("editFirstName").value.trim(),
    middleName: document.getElementById("editMiddleName").value.trim() || null,
    lastName: document.getElementById("editLastName").value.trim(),
    age: document.getElementById("editAge").value.trim(),
    houseNumber: document.getElementById("editHouseNumber").value.trim() || null,
    street: document.getElementById("editStreet").value.trim() || null,
    barangay: document.getElementById("editBarangay").value.trim(),
    municipality: document.getElementById("editMunicipality").value.trim(),
    province: document.getElementById("editProvince").value.trim(),
    contactNumber: document.getElementById("editContactNumber").value.trim(),
    school: document.getElementById("editSchool").value.trim() || null
  };

  fetch(`/members/${memberId}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(formData)
  })
    .then(response => {
      if (!response.ok) throw new Error("Update failed");
      return response.json();
    })
    .then(data => {
      alert("✅ Member updated successfully.");
      closeEditModal();
      location.reload();
    })
    .catch(error => {
      console.error("Edit error:", error);
      alert("🚫 Update failed. Check console for details.");
    });
});

// Delete a member
function deleteMember(id = null) {
  if (!id) {
    id = document.getElementById("editMemberId").value;
  }

  if (!confirm("Are you sure you want to delete this member?")) return;

  fetch(`/members/${id}`, {
    method: "DELETE",
    headers: {
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
      "Accept": "application/json"
    }
  })
    .then(response => {
      if (!response.ok) throw new Error("Failed to delete member");
      return response.json();
    })
    .then(data => {
      alert(data.message || "Member deleted successfully.");
      closeEditModal();
      location.reload();
    })
    .catch(error => {
      console.error("Delete error:", error);
      alert("🚫 Failed to delete member. Check console for details.");
    });
}
