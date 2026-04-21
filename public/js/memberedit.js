/**
 * Edit Modal Handler for Members Management
 * Simplified and reliable modal handling
 */

class EditModalHandler {
    constructor() {
        this.modal = document.getElementById('editModal');
        this.form = document.getElementById('editForm');
        this.currentMemberId = null;

        if (this.modal && this.form) {
            this.initializeEventListeners();
        } else {
            console.error('Modal or form elements not found');
        }
    }

    /**
      * Initialize all event listeners
      */
     initializeEventListeners() {
         // Add table event listener for edit buttons
         const tableBody = document.getElementById('membersTableBody');
         if (tableBody) {
             tableBody.addEventListener('click', (e) => {
                 if (e.target.classList.contains('editBtn') || e.target.closest('.editBtn')) {
                     const button = e.target.classList.contains('editBtn') ? e.target : e.target.closest('.editBtn');
                     const memberId = button.getAttribute('data-id');
                     this.openEditModal(memberId);
                 }
             });
         } else {
             console.warn('Members table body not found during initialization');
         }

         // Form submission
         if (this.form) {
             this.form.addEventListener('submit', (e) => {
                 e.preventDefault();
                 this.submitEdit();
             });
         }

         // Close modal on backdrop click
         if (this.modal) {
             this.modal.addEventListener('click', (e) => {
                 if (e.target === this.modal) {
                     this.closeEditModal();
                 }
             });
         }

         // Escape key to close modal
         document.addEventListener('keydown', (e) => {
             if (e.key === 'Escape' && this.modal && this.modal.classList.contains('show')) {
                 this.closeEditModal();
             } else if (e.key === 'Enter' && this.modal && this.modal.classList.contains('show')) {
                 const tagName = (e.target && e.target.tagName) ? e.target.tagName.toLowerCase() : '';
                 if (tagName !== 'textarea' && tagName !== 'button' && this.form) {
                     e.preventDefault();
                     if (typeof this.form.requestSubmit === 'function') {
                         this.form.requestSubmit();
                     } else {
                         this.submitEdit();
                     }
                 }
             }
         });
     }

    /**
      * Open edit modal and populate with member data
      * @param {string} memberId - The ID of the member to edit
      */
     async openEditModal(memberId) {
         try {
             this.currentMemberId = memberId;

             // Show modal immediately
             this.showModal();

             // Fetch member data in background
             try {
                 const memberData = await this.fetchMemberData(memberId);
                 this.populateForm(memberData);
             } catch (fetchError) {
                 console.error('Error fetching member data:', fetchError);
                 this.showError('Failed to load member data. Please try again.');
             }

         } catch (error) {
             console.error('Error opening edit modal:', error);
             this.showError('Failed to open edit modal. Please try again.');
         }
     }

    /**
      * Fetch member data from server
      * @param {string} memberId - The ID of the member
      * @returns {Promise<Object>} Member data
      */
     async fetchMemberData(memberId) {
         // Check if CSRF token exists
         const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

        const url = `/api/members/${encodeURIComponent(memberId)}`;

         try {
             const response = await fetch(url, {
                 method: 'GET',
                 credentials: 'include',
                 headers: {
                     'Accept': 'application/json',
                     'Content-Type': 'application/json',
                     ...(csrfTokenMeta && { 'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content') })
                 }
             });

             if (!response.ok) {
                 if (response.status === 419) {
                     throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                 } else if (response.status === 401 || response.status === 403) {
                     throw new Error('You do not have permission to view this member.');
                 } else if (response.status === 404) {
                     throw new Error('Member not found. The member may have been deleted.');
                 } else {
                     const errorText = await response.text();
                     console.error('Response error text:', errorText);
                     throw new Error(`Server error (${response.status}): ${errorText}`);
                 }
             }

             // Check if response is JSON
             const contentType = response.headers.get('content-type');
             if (!contentType || !contentType.includes('application/json')) {
                 const errorText = await response.text();
                 console.error('Non-JSON response:', errorText);
                 throw new Error('Server returned invalid response format. Please check if the route is properly configured.');
             }

             const data = await response.json();

             // Handle different response formats
             if (data.error) {
                 throw new Error(data.error);
             }

             return data;

         } catch (error) {
             if (error.name === 'TypeError' && error.message.includes('fetch')) {
                 throw new Error('Network error. Please check your internet connection.');
             }
             throw error;
         }
     }

    /**
      * Get fallback member data from the table row.
      * @param {string} memberId
      * @returns {Object|null}
      */
     getMemberRowData(memberId) {
         const normalizedId = String(memberId ?? '').trim();
         const row = document.querySelector(`tr[data-id="${normalizedId}"]`) ||
             document.querySelector(`tr[data-legacy-id="${normalizedId}"]`);

         if (!row) {
             return null;
         }

         return {
             uuid: row.dataset.id || normalizedId,
             first_name: row.dataset.firstName || '',
             middle_name: row.dataset.middleName || '',
             last_name: row.dataset.lastName || '',
             age: row.dataset.age || '',
             house_number: row.dataset.houseNumber || '',
             street: row.dataset.street || '',
             barangay: row.dataset.barangay || '',
             municipality: row.dataset.municipality || '',
             province: row.dataset.province || '',
             contactnumber: row.dataset.contactnumber || '',
             email: row.dataset.email || '',
             school: row.dataset.school || '',
             memberdate: row.dataset.memberdate || '',
             photo_url: row.dataset.photoUrl || ''
         };
     }

    /**
      * Populate the form with member data
      * @param {Object} member - Member data object
      */
     populateForm(member) {
         const fallbackMember = this.getMemberRowData(member.uuid || member.id || this.currentMemberId) || {};
         const resolvedMember = { ...fallbackMember, ...member };

         // Set member ID
         const memberIdField = document.getElementById('editMemberId');
         if (memberIdField) {
             memberIdField.value = resolvedMember.uuid || resolvedMember.id || this.currentMemberId;
         }

         // Personal Information
         this.setFieldValue('editFirstName', resolvedMember.first_name);
         this.setFieldValue('editMiddleName', resolvedMember.middle_name);
         this.setFieldValue('editLastName', resolvedMember.last_name);
         this.setFieldValue('editAge', resolvedMember.age);

         // Address Information
         this.setFieldValue('editHouseNumber', resolvedMember.house_number);
         this.setFieldValue('editStreet', resolvedMember.street);
         this.setFieldValue('editBarangay', resolvedMember.barangay);
         this.setFieldValue('editMunicipality', resolvedMember.municipality);
         this.setFieldValue('editProvince', resolvedMember.province);

         // Contact Information
         this.setFieldValue('editContactNumber', resolvedMember.contactnumber);
         this.setFieldValue('editEmail', resolvedMember.email);
         this.setFieldValue('editSchool', resolvedMember.school);

         // Photo preview in edit modal
         const photoSource = resolvedMember.photo_url || resolvedMember.photo
             ? (String(resolvedMember.photo_url || resolvedMember.photo).startsWith('http') || String(resolvedMember.photo_url || resolvedMember.photo).startsWith('/')
                 ? (resolvedMember.photo_url || resolvedMember.photo)
                 : `/resource/member_images/${resolvedMember.photo_url || resolvedMember.photo}`)
             : '';

         if (typeof window.setPhotoPreviewFromUrl === 'function') {
             window.setPhotoPreviewFromUrl('editPhoto', photoSource);
         }

         // Restore form from loading state
         this.restoreFromLoading();
     }

     /**
       * Show loading state in modal
       */
      showLoadingState() {
          if (this.modal && this.form) {
              // Show loading in modal title
              const modalHeader = this.modal.querySelector('.edit-modal-header h3');
              if (modalHeader) {
                  const originalText = modalHeader.innerHTML;
                  modalHeader.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading member data...';
 
                  // Store original text for later restoration
                  this.originalTitle = originalText;
              }
 
              // Disable form inputs while loading
              const inputs = this.form.querySelectorAll('input, select, button');
              inputs.forEach(input => {
                  input.disabled = true;
                  input.dataset.originalDisabled = input.disabled;
              });
          }
      }
 
      /**
       * Restore form from loading state
       */
      restoreFromLoading() {
          if (this.modal && this.form) {
              // Restore modal title
              const modalHeader = this.modal.querySelector('.edit-modal-header h3');
              if (modalHeader && this.originalTitle) {
                  modalHeader.innerHTML = this.originalTitle;
                  this.originalTitle = null;
              }
 
              // Re-enable form inputs
              const inputs = this.form.querySelectorAll('input, select, button');
              inputs.forEach(input => {
                  if (input.dataset.originalDisabled === 'false') {
                      input.disabled = false;
                  }
              });
          }
      }

     /**
      * Clear validation errors
      */
     clearErrors() {
         const errorMessages = this.form.querySelectorAll('.error-message');
         errorMessages.forEach(msg => msg.remove());

         const inputs = this.form.querySelectorAll('input');
         inputs.forEach(input => {
             input.style.borderColor = '';
         });
     }

    /**
     * Set field value, handling null/undefined values
     * @param {string} fieldId - The ID of the field
     * @param {*} value - The value to set
     */
    setFieldValue(fieldId, value) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.value = (value && value !== 'null') ? value : '';
        } else {
            console.warn(`Field with ID '${fieldId}' not found`);
        }
    }


    /**
      * Show the modal immediately
      */
     showModal() {

         if (!this.modal) {
             console.error('Modal element not found!');
             return;
         }

         // Show modal immediately with animation
         this.modal.style.display = 'flex';
         this.modal.classList.add('show');

         // Focus on first input if form exists
         if (this.form) {
             const firstInput = this.form.querySelector('input:not([type="hidden"])');
             if (firstInput) {
                 // Use shorter delay for faster focus
                 setTimeout(() => firstInput.focus(), 50);
             }
         }

     }

     /**
      * Close the modal
      */
     closeEditModal() {
         if (typeof window.toggleInlineCamera === 'function') {
             window.toggleInlineCamera('editPhoto', false);
         }

         if (this.modal) {
             this.modal.classList.remove('show');
             setTimeout(() => {
                 if (this.modal) {
                     this.modal.style.display = 'none';
                 }
             }, 300); // Wait for animation to complete
         }

         if (this.form) {
             this.form.reset();
         }

         const editPreview = document.getElementById('editPhotoPreview');
         if (editPreview) {
             editPreview.src = '#';
             editPreview.style.display = 'none';

             const uploadArea = editPreview.previousElementSibling;
             if (uploadArea && uploadArea.classList.contains('photo-upload')) {
                 uploadArea.classList.remove('hidden');
             }

             const removeBtn = editPreview.parentNode ? editPreview.parentNode.querySelector('.remove-photo') : null;
             if (removeBtn) {
                 removeBtn.remove();
             }
         }

         this.currentMemberId = null;
         this.clearErrors();
     }

    /**
      * Submit the edit form
      */
     async submitEdit() {
         let submitBtn;

         try {
             this.clearErrors();

             if (!this.form) {
                 this.showError('Form not found');
                 return;
             }

             const formData = new FormData(this.form);
             const memberId = formData.get('memberId');

             if (!memberId) {
                 this.showError('Member ID not found');
                 return;
             }

             // Show loading in button
             submitBtn = this.form.querySelector('button[type="submit"]');
             if (submitBtn) {
                 submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                 submitBtn.disabled = true;
             }

             // Add method override for Laravel
             formData.append('_method', 'PUT');

             // Get CSRF token
             const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
             if (!csrfTokenMeta) {
                 throw new Error('CSRF token not found. Please refresh the page.');
             }

             const response = await fetch(`/members/${memberId}`, {
                 method: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                     'Accept': 'application/json'
                 },
                 body: formData
             });

             if (!response.ok) {
                 if (response.status === 419) {
                     throw new Error('CSRF token expired. Please refresh the page and try again.');
                 } else if (response.status === 422) {
                     const errorData = await response.json();
                     throw new Error(errorData.message || 'Validation failed');
                 } else {
                     const errorText = await response.text();
                     throw new Error(`Server error (${response.status}): ${errorText}`);
                 }
             }

             // Check if response is JSON
             const contentType = response.headers.get('content-type');
             if (!contentType || !contentType.includes('application/json')) {
                 const errorText = await response.text();
                 console.error('Non-JSON response:', errorText);
                 throw new Error('Server returned invalid response format.');
             }

             const data = await response.json();

             if (data.success) {
                 this.showSuccess('Member updated successfully!');
                 this.updateTableRow(data.member);
                 setTimeout(() => {
                     this.closeEditModal();
                     location.reload();
                 }, 1500);
             } else {
                 this.showError(data.message || 'Failed to update member');
             }

         } catch (error) {
             console.error('Error updating member:', error);

             if (error.message.includes('CSRF token')) {
                 this.showError('Session expired. Please refresh the page and try again.');
             } else if (error.message.includes('Validation failed')) {
                 this.showError('Please check your input and try again.');
             } else if (error.message.includes('Network')) {
                 this.showError('Network error. Please check your connection and try again.');
             } else {
                 this.showError(error.message || 'An error occurred while updating the member.');
             }
         } finally {
             // Restore button
             if (submitBtn) {
                 submitBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                 submitBtn.disabled = false;
             }
         }
     }


    /**
      * Update the table row with new data
      * @param {Object} member - Updated member data
      */
     updateTableRow(member) {
         // Find the table row that contains the edit button with this member ID
         const editButton = document.querySelector(`button[data-id="${member.id}"]`);
         if (!editButton) {
             console.warn('Could not find edit button for member ID:', member.id);
             return;
         }

         const row = editButton.closest('tr');
         if (!row) {
             return;
         }

         // Format full name
         const fullName = [
             member.last_name,
             member.first_name,
             member.middle_name
         ].filter(name => name && name !== 'null').join(' ');

         // Format address
         const address = [
             member.house_number,
             member.street,
             member.barangay,
             member.municipality,
             member.province
         ].filter(addr => addr && addr !== 'null').join(', ');

         // Update table cells (Name, Age, Address, Contact, School, Date)
         const cells = row.querySelectorAll('td');
         if (cells[0]) cells[0].textContent = fullName;
         if (cells[1]) cells[1].textContent = member.age || '-';
         if (cells[2]) cells[2].textContent = address;
         if (cells[3]) cells[3].textContent = member.contactnumber || '-';
         if (cells[4]) cells[4].textContent = member.school || '-';

         // Format and update date
         if (cells[5] && member.memberdate) {
             const date = new Date(member.memberdate);
             cells[5].textContent = date.toLocaleDateString('en-US', {
                 year: 'numeric',
                 month: 'short',
                 day: 'numeric'
             });
         }
     }

    /**
      * Delete member function
      */
     async deleteMember() {
         const memberId = document.getElementById('editMemberId').value;

         if (!memberId) {
             this.showError('Member ID not found');
             return;
         }

         if (!confirm('Are you sure you want to delete this member? This action cannot be undone.')) {
             return;
         }

         let deleteBtn;

         try {
             // Show loading in delete button
             deleteBtn = this.form.querySelector('.btn-danger');
             if (deleteBtn) {
                 deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
                 deleteBtn.disabled = true;
             }

             // Get CSRF token
             const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
             if (!csrfTokenMeta) {
                 throw new Error('CSRF token not found. Please refresh the page.');
             }

             const response = await fetch(`/members/${memberId}`, {
                 method: 'DELETE',
                 headers: {
                     'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                     'Accept': 'application/json'
                 }
             });

             if (!response.ok) {
                 if (response.status === 419) {
                     throw new Error('CSRF token expired. Please refresh the page and try again.');
                 } else if (response.status === 404) {
                     throw new Error('Member not found. It may have already been deleted.');
                 } else {
                     const errorText = await response.text();
                     throw new Error(`Server error (${response.status}): ${errorText}`);
                 }
             }

             // Check if response is JSON
             const contentType = response.headers.get('content-type');
             if (!contentType || !contentType.includes('application/json')) {
                 const errorText = await response.text();
                 console.error('Non-JSON response:', errorText);
                 throw new Error('Server returned invalid response format.');
             }

             const data = await response.json();

             if (data.success) {
                 this.showSuccess('Member deleted successfully!');
                 // Close modal and reload page to reflect changes
                 setTimeout(() => {
                     this.closeEditModal();
                     location.reload();
                 }, 1500);
             } else {
                 this.showError(data.message || 'Failed to delete member');
             }

         } catch (error) {
             console.error('Error deleting member:', error);

             if (error.message.includes('CSRF token')) {
                 this.showError('Session expired. Please refresh the page and try again.');
             } else if (error.message.includes('Member not found')) {
                 this.showError('Member not found. It may have already been deleted.');
             } else {
                 this.showError(error.message || 'An error occurred while deleting the member.');
             }
         } finally {
             // Restore delete button
             if (deleteBtn) {
                 deleteBtn.innerHTML = '<i class="fas fa-trash"></i> Delete';
                 deleteBtn.disabled = false;
             }
         }
     }


    /**
      * Show success message
      * @param {string} message - Success message
      */
     showSuccess(message) {
         this.showToast(message, 'success');
     }

     /**
      * Show error message
      * @param {string} message - Error message
      */
     showError(message) {
         this.showToast(message, 'error');
     }

    /**
      * Show toast notification
      * @param {string} message - Message to show
      * @param {string} type - Type of toast (success/error)
      */
     showToast(message, type = 'info') {
         // Remove existing toasts
         const existingToasts = document.querySelectorAll('.toast-notification');
         existingToasts.forEach(toast => toast.remove());

         const toast = document.createElement('div');
         toast.className = `toast-notification toast-${type}`;
         toast.innerHTML = `
             <div class="toast-content">
                 <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                 <span>${message}</span>
             </div>
         `;

         // Simple toast styling
         toast.style.cssText = `
             position: fixed;
             top: 20px;
             right: 20px;
             padding: 16px 20px;
             border-radius: 12px;
             color: white;
             font-weight: 600;
             z-index: 3000;
             box-shadow: 0 10px 25px rgba(0,0,0,0.2);
             min-width: 300px;
             background: ${type === 'success' ?
                 'linear-gradient(135deg, #10b981 0%, #059669 100%)' :
                 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'};
             animation: slideInRight 0.3s ease-out;
         `;

         document.body.appendChild(toast);

         // Auto remove after 4 seconds
         setTimeout(() => {
             toast.remove();
         }, 4000);
     }

    /**
     * Set field value with null checking
     * @param {string} fieldId - Field ID
     * @param {string} value - Value to set
     */
    setFieldValue(fieldId, value) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.value = (value && value !== 'null') ? value : '';
        }
    }

    /**
     * Clear validation errors
     */
    clearErrors() {
        if (this.form) {
            const errorMessages = this.form.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const inputs = this.form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.style.borderColor = '';
            });
        }
    }
}

// Global functions for backward compatibility
function editMember(memberId) {
    if (window.editModalHandler) {
        window.editModalHandler.openEditModal(memberId);
    } else {
        // Try to initialize if not already done
        if (document.getElementById('editModal') && document.getElementById('editForm')) {
            window.editModalHandler = new EditModalHandler();
            if (window.editModalHandler) {
                window.editModalHandler.openEditModal(memberId);
            }
        } else {
            alert('Edit functionality is not available. Please refresh the page and try again.');
        }
    }
}

function closeEditModal() {
    if (window.editModalHandler) {
        window.editModalHandler.closeEditModal();
    }
}

function deleteMember() {
    if (window.editModalHandler) {
        window.editModalHandler.deleteMember();
    }
}

// Simple initialization
// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if required elements exist
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');

    if (modal && form) {
        window.editModalHandler = new EditModalHandler();
    }
});