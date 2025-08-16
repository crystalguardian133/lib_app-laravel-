function openEditModal(memberId) {
  fetch(`/members/${memberId}`)
    .then(res => res.json())
    .then(data => {
      // Fill form fields
      document.getElementById('editMemberId').value = data.id;
      document.getElementById('editFirstName').value = data.first_name || '';
      document.getElementById('editMiddleName').value = data.middle_name || '';
      document.getElementById('editLastName').value = data.last_name || '';
      document.getElementById('editAge').value = data.age || '';
      document.getElementById('editHouseNumber').value = data.house_number || '';
      document.getElementById('editStreet').value = data.street || '';
      document.getElementById('editBarangay').value = data.barangay || '';
      document.getElementById('editMunicipality').value = data.municipality || '';
      document.getElementById('editProvince').value = data.province || '';
      document.getElementById('editContactNumber').value = data.contactnumber || '';
      document.getElementById('editSchool').value = data.school || '';

      // Show modal
      document.getElementById('editModal').style.display = 'block';
    })
    .catch(err => alert("Could not load member info"));
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

function deleteMember() {
  const id = document.getElementById('editMemberId').value;
  if (!id) return;

  if (confirm("Are you sure you want to delete this member?")) {
    fetch(`/members/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(res => {
      if (res.ok) {
        alert("Member deleted");
        closeEditModal();
        location.reload();
      }
    });
  }
}
function openEditModal(memberId) {
  fetch(`/members/${memberId}`)
    .then(res => res.json())
    .then(data => {
      // Fill form fields
      document.getElementById('editMemberId').value = data.id;
      document.getElementById('editFirstName').value = data.first_name || '';
      document.getElementById('editMiddleName').value = data.middle_name || '';
      document.getElementById('editLastName').value = data.last_name || '';
      document.getElementById('editAge').value = data.age || '';
      document.getElementById('editHouseNumber').value = data.house_number || '';
      document.getElementById('editStreet').value = data.street || '';
      document.getElementById('editBarangay').value = data.barangay || '';
      document.getElementById('editMunicipality').value = data.municipality || '';
      document.getElementById('editProvince').value = data.province || '';
      document.getElementById('editContactNumber').value = data.contactnumber || '';
      document.getElementById('editSchool').value = data.school || '';

      // Show modal
      document.getElementById('editModal').style.display = 'block';
    })
    .catch(err => alert("Could not load member info"));
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

function deleteMember() {
  const id = document.getElementById('editMemberId').value;
  if (!id) return;

  if (confirm("Are you sure you want to delete this member?")) {
    fetch(`/members/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(res => {
      if (res.ok) {
        alert("Member deleted");
        closeEditModal();
        location.reload();
      }
    });
  }
}
function openEditModal(memberId) {
  fetch(`/members/${memberId}`)
    .then(res => res.json())
    .then(data => {
      // Fill form fields
      document.getElementById('editMemberId').value = data.id;
      document.getElementById('editFirstName').value = data.first_name || '';
      document.getElementById('editMiddleName').value = data.middle_name || '';
      document.getElementById('editLastName').value = data.last_name || '';
      document.getElementById('editAge').value = data.age || '';
      document.getElementById('editHouseNumber').value = data.house_number || '';
      document.getElementById('editStreet').value = data.street || '';
      document.getElementById('editBarangay').value = data.barangay || '';
      document.getElementById('editMunicipality').value = data.municipality || '';
      document.getElementById('editProvince').value = data.province || '';
      document.getElementById('editContactNumber').value = data.contactnumber || '';
      document.getElementById('editSchool').value = data.school || '';

      // Show modal
      document.getElementById('editModal').style.display = 'block';
    })
    .catch(err => alert("Could not load member info"));
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

function deleteMember() {
  const id = document.getElementById('editMemberId').value;
  if (!id) return;

  if (confirm("Are you sure you want to delete this member?")) {
    fetch(`/members/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(res => {
      if (res.ok) {
        alert("Member deleted");
        closeEditModal();
        location.reload();
      }
    });
  }
}
function openEditModal(memberId) {
  fetch(`/members/${memberId}`)
    .then(res => res.json())
    .then(data => {
      // Fill form fields
      document.getElementById('editMemberId').value = data.id;
      document.getElementById('editFirstName').value = data.first_name || '';
      document.getElementById('editMiddleName').value = data.middle_name || '';
      document.getElementById('editLastName').value = data.last_name || '';
      document.getElementById('editAge').value = data.age || '';
      document.getElementById('editHouseNumber').value = data.house_number || '';
      document.getElementById('editStreet').value = data.street || '';
      document.getElementById('editBarangay').value = data.barangay || '';
      document.getElementById('editMunicipality').value = data.municipality || '';
      document.getElementById('editProvince').value = data.province || '';
      document.getElementById('editContactNumber').value = data.contactnumber || '';
      document.getElementById('editSchool').value = data.school || '';

      // Show modal
      document.getElementById('editModal').style.display = 'block';
    })
    .catch(err => alert("Could not load member info"));
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

function deleteMember() {
  const id = document.getElementById('editMemberId').value;
  if (!id) return;

  if (confirm("Are you sure you want to delete this member?")) {
    fetch(`/members/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(res => {
      if (res.ok) {
        alert("Member deleted");
        closeEditModal();
        location.reload();
      }
    });
  }
}
