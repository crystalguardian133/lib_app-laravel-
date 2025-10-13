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
            console.log('EditModalHandler initialized successfully');
        } else {o
            console.error('Modal or form elements not found');
        }
    }

    /**
      * Initialize all event listeners
      */
     initializeEventListeners() {
         console.log('Initializing event listeners...');

         // Add table event listener for edit buttons
         const tableBody = document.getElementById('membersTableBody');
         if (tableBody) {
             console.log('Adding table click event listener');
             tableBody.addEventListener('click', (e) => {
                 if (e.target.classList.contains('editBtn') || e.target.closest('.editBtn')) {
                     const button = e.target.classList.contains('editBtn') ? e.target : e.target.closest('.editBtn');
                     const memberId = button.getAttribute('data-id');
                     console.log('Edit button clicked for member ID:', memberId);
                     this.openEditModal(memberId);
                 }
             });
         } else {
             console.warn('Members table body not found during initialization');
         }

         // Form submission
         if (this.form) {
             console.log('Adding form submit event listener');
             this.form.addEventListener('submit', (e) => {
                 e.preventDefault();
                 this.submitEdit();
             });
         }

         // Close modal on backdrop click
         if (this.modal) {
             console.log('Adding modal click event listener');
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
             }
         });

         console.log('Event listeners initialized');
     }

    /**
      * Open edit modal and populate with member data
      * @param {string} memberId - The ID of the member to edit
      */
     async openEditModal(memberId) {
         try {
             console.log('Opening edit modal for member ID:', memberId);
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
         console.log('Fetching member data for ID:', memberId);

         // Check if CSRF token exists
         const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
         if (!csrfTokenMeta) {
             console.warn('CSRF token not found in meta tag');
         }

         const url = `/members/${memberId}`;
         console.log('Request URL:', url);

         try {
             const response = await fetch(url, {
                 method: 'GET',
                 headers: {
                     'Accept': 'application/json',
                     'Content-Type': 'application/json',
                     ...(csrfTokenMeta && { 'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content') })
                 }
             });

             console.log('Response status:', response.status);
             console.log('Response content-type:', response.headers.get('content-type'));

             if (!response.ok) {
                 const errorText = await response.text();
                 console.error('Response error text:', errorText);

                 if (response.status === 419) {
                     throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                 } else if (response.status === 404) {
                     throw new Error('Member not found. The member may have been deleted.');
                 } else {
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
             console.log('Received member data:', data);

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
      * Populate the form with member data
      * @param {Object} member - Member data object
      */
     populateForm(member) {
         console.log('Populating form with member data:', member);

         // Set member ID
         const memberIdField = document.getElementById('editMemberId');
         if (memberIdField) {
             memberIdField.value = member.id;
         }

         // Personal Information
         this.setFieldValue('editFirstName', member.first_name);
         this.setFieldValue('editMiddleName', member.middle_name);
         this.setFieldValue('editLastName', member.last_name);
         this.setFieldValue('editAge', member.age);

         // Address Information
         this.setFieldValue('editHouseNumber', member.house_number);
         this.setFieldValue('editStreet', member.street);
         this.setFieldValue('editBarangay', member.barangay);
         this.setFieldValue('editMunicipality', member.municipality);
         this.setFieldValue('editProvince', member.province);

         // Contact Information
         this.setFieldValue('editContactNumber', member.contactnumber);
         this.setFieldValue('editSchool', member.school);

         // Restore form from loading state
         this.restoreFromLoading();

         console.log('Form populated and loading state cleared');
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
         console.log('Showing edit modal immediately...');

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

         console.log('Edit modal displayed immediately');
     }

     /**
      * Close the modal
      */
     closeEditModal() {
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

             console.log('Update response status:', response.status);

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
             console.log('Update response data:', data);

             if (data.success) {
                 this.showSuccess('Member updated successfully!');
                 this.updateTableRow(data.member);
                 setTimeout(() => this.closeEditModal(), 1500);
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
             console.warn('Could not find table row for member ID:', member.id);
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

         console.log('Table row updated successfully for member:', member.id);
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

             console.log('Delete response status:', response.status);

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
             console.log('Delete response data:', data);

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
    console.log('editMember called with ID:', memberId);

    if (window.editModalHandler) {
        console.log('EditModalHandler found, opening modal...');
        window.editModalHandler.openEditModal(memberId);
    } else {
        console.error('EditModalHandler not initialized. Make sure memberedit.js is loaded after the modal HTML.');

        // Try to initialize if not already done
        if (document.getElementById('editModal') && document.getElementById('editForm')) {
            console.log('Attempting to initialize EditModalHandler...');
            window.editModalHandler = new EditModalHandler();
            if (window.editModalHandler) {
                console.log('EditModalHandler initialized successfully, opening modal...');
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
 console.log('EditModalHandler loaded and ready');

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing EditModalHandler...');

    // Check if required elements exist
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');

    console.log('Modal element found:', !!modal);
    console.log('Form element found:', !!form);

    if (modal && form) {
        window.editModalHandler = new EditModalHandler();
        console.log('EditModalHandler initialized successfully');
    } else {
        console.error('Required elements not found:', {
            modal: !!modal,
            form: !!form
        });
    }
});