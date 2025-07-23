document.addEventListener('DOMContentLoaded', () => {
  const checkboxes = document.querySelectorAll('.member-checkbox');
  const editButton = document.getElementById('editBtn');

  // Disable other checkboxes if one is checked
  checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      const anyChecked = Array.from(checkboxes).some(c => c.checked);
      checkboxes.forEach(c => {
        if (!c.checked) c.disabled = anyChecked;
      });
    });
  });

  editButton.addEventListener('click', () => {
    const selected = Array.from(checkboxes).filter(cb => cb.checked);

    if (selected.length === 0) {
      alert('⚠️ Please select a member to manage.');
      return;
    }

    if (selected.length > 1) {
      alert('⚠️ Please select only one member to manage at a time.');
      return;
    }

    const row = selected[0].closest('tr');

    const id = row.dataset.id;
    const name = row.dataset.name;
    const age = row.dataset.age;
    const address = row.dataset.address;
    const contact = row.dataset.contact;
    const school = row.dataset.school;

    // Fill modal fields
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-age').value = age;
    document.getElementById('edit-address').value = address;
    document.getElementById('edit-contact').value = contact;
    document.getElementById('edit-school').value = school;

    document.getElementById('editModal').style.display = 'flex';
  });
});

// Update Member
function updateMember() {
  const id = document.getElementById('edit-id').value;
  const name = document.getElementById('edit-name').value;
  const age = document.getElementById('edit-age').value;
  const address = document.getElementById('edit-address').value;
  const contact = document.getElementById('edit-contact').value;
  const school = document.getElementById('edit-school').value;
  const token = document.querySelector('meta[name="csrf-token"]').content;

  if (!name || !age || !address || !contact) {
    alert("⚠️ Please fill in all required fields.");
    return;
  }

  fetch(`/members/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({
      name: name,
      age: age,
      address: address,
      contactnumber: contact,
      school: school
    })
  })
  .then(res => {
    if (!res.ok) throw new Error("Server error");
    return res.json();
  })
  .then(data => {
    if (data.success) {
      alert("✅ Member updated successfully.");
      location.reload();
    } else {
      alert("⚠️ Update failed.");
    }
  })
  .catch(err => {
    console.error("Error:", err);
    alert("🚫 Server error. See console.");
  });
}

// Delete Member
function deleteMember() {
  const id = document.getElementById('edit-id').value;
  const token = document.querySelector('meta[name="csrf-token"]').content;

  if (!confirm("🗑️ Are you sure you want to delete this member?")) return;

  fetch(`/members/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': token
    }
  })
  .then(res => {
    if (!res.ok) throw new Error("Failed to delete member.");
    return res.json();
  })
  .then(data => {
    alert("🗑️ Member deleted successfully.");
    location.reload();
  })
  .catch(err => {
    console.error("Error:", err);
    alert("🚫 Failed to delete member. Check console.");
  });
}

// Close modal
function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

document.addEventListener('keydown', function(e) {
  if (e.key === "Escape") closeEditModal();
  if (e.key === "Enter") updateMember();
});
