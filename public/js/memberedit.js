/**
 * Edit Modal Handler for Members Management
 * Handles opening, closing, populating, and submitting the edit modal
 */

class EditModalHandler {
    constructor() {
        this.modal = document.getElementById('editModal');
        this.form = document.getElementById('editForm');
        this.membersTableBody = document.getElementById('membersTableBody');
        
        this.initializeEventListeners();
    }

    /**
     * Initialize all event listeners
     */
    initializeEventListeners() {
        // Edit button click events (delegated)
        this.membersTableBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('editBtn') || e.target.closest('.editBtn')) {
                const button = e.target.classList.contains('editBtn') ? e.target : e.target.closest('.editBtn');
                const memberId = button.getAttribute('data-id');
                this.openEditModal(memberId);
            }
        });

        // Form submission
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitEdit();
        });

        // Close modal on backdrop click
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeEditModal();
            }
        });

        // Escape key to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.classList.contains('show')) {
                this.closeEditModal();
            }
        });
    }

    /**
     * Open edit modal and populate with member data
     * @param {string} memberId - The ID of the member to edit
     */
    async openEditModal(memberId) {
        try {
            console.log('Opening edit modal for member ID:', memberId);
            
            // Close any other open modals first
            this.closeAllOtherModals();
            
            this.showLoading(true);
            const memberData = await this.fetchMemberData(memberId);
            this.populateForm(memberData);
            this.showModal();
        } catch (error) {
            console.error('Error opening edit modal:', error);
            // Show more specific error message
            const errorMessage = error.message.includes('HTTP error') 
                ? `Server error: ${error.message}. Please check if the member exists and try again.`
                : 'Failed to load member data. Please try again.';
            this.showError(errorMessage);
        } finally {
            this.showLoading(false);
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.warn('CSRF token not found in meta tag');
        }
        
        const url = `/members/${memberId}`; // Remove /edit if your route doesn't use it
        console.log('Request URL:', url);
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken.getAttribute('content') })
            }
        });

        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response error text:', errorText);
            throw new Error(`HTTP error! status: ${response.status} - ${errorText}`);
        }

        const data = await response.json();
        console.log('Received member data:', data);
        return data;
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
        } else {
            console.warn('editMemberId field not found');
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
     * Close all other modals before opening edit modal
     */
    closeAllOtherModals() {
        const registerModal = document.getElementById("registerModal");
        const julitaModal = document.getElementById("julitaRegisterModal");
        
        if (registerModal) {
            registerModal.classList.remove("show");
            registerModal.style.display = "none";
        }
        
        if (julitaModal) {
            julitaModal.classList.remove("show");
            julitaModal.style.display = "none";
        }
        
        document.body.classList.remove("modal-open");
    }

    /**
     * Show the modal
     */
    showModal() {
        console.log('Attempting to show modal...');
        console.log('Modal element:', this.modal);
        console.log('Modal classes before:', this.modal?.className);
        
        if (!this.modal) {
            console.error('Modal element not found! Make sure element with ID "editModal" exists.');
            return;
        }
        
        this.modal.classList.add('show');
        this.modal.style.display = 'flex';
        console.log('Modal classes after:', this.modal.className);
        document.body.classList.add('modal-open');
        
        // Focus on first input
        const firstInput = this.form.querySelector('input:not([type="hidden"])');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
        
        console.log('Modal should now be visible');
    }

    /**
     * Close the modal
     */
    closeEditModal() {
        this.modal.classList.remove('show');
        this.modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        this.form.reset();
        this.clearErrors();
    }

    /**
     * Submit the edit form
     */
    async submitEdit() {
        try {
            this.showLoading(true);
            this.clearErrors();

            const formData = this.collectFormData();
            const response = await this.sendUpdateRequest(formData);
            
            if (response.success) {
                this.showSuccess('Member updated successfully!');
                this.updateTableRow(response.member);
                setTimeout(() => this.closeEditModal(), 1500);
            } else {
                this.showError(response.message || 'Failed to update member');
                if (response.errors) {
                    this.displayValidationErrors(response.errors);
                }
            }
        } catch (error) {
            console.error('Error updating member:', error);
            this.showError('An error occurred while updating the member. Please try again.');
        } finally {
            this.showLoading(false);
        }
    }

    /**
     * Collect form data
     * @returns {Object} Form data
     */
    collectFormData() {
        const formData = new FormData(this.form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value.trim();
        }
        
        return data;
    }

    /**
     * Send update request to server
     * @param {Object} data - Form data
     * @returns {Promise<Object>} Response data
     */
async sendUpdateRequest(data) {
    const memberId = data.memberId;
    delete data.memberId;

    const formData = new FormData(this.form); // picks up all inputs + file

    // add method override for Laravel
    formData.append('_method', 'PUT');

    const response = await fetch(`/members/${memberId}`, {
        method: 'POST', // Laravel will treat as PUT
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    });

    return await response.json();
}

    /**
     * Update the table row with new data
     * @param {Object} member - Updated member data
     */
    updateTableRow(member) {
        const row = document.querySelector(`tr button[data-id="${member.id}"]`).closest('tr');
        if (!row) return;

        // Format full name
        const fullName = [
            member.last_name,
            member.first_name,
            member.middle_name
        ].filter(name => name && name !== 'null').join(', ');

        // Format address
        const address = [
            member.house_number,
            member.street,
            member.barangay,
            member.municipality,
            member.province
        ].filter(addr => addr && addr !== 'null').join(', ');

        // Format date
        const memberDate = member.memberdate ? 
            new Date(member.memberdate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) : '';

        // Update table cells
        const cells = row.querySelectorAll('td');
        cells[0].textContent = fullName;
        cells[1].textContent = member.age || '';
        cells[2].textContent = address;
        cells[3].textContent = member.contactnumber || '';
        cells[4].textContent = member.school || '';
        cells[5].textContent = memberDate;
        cells[6].textContent = member.member_time ? `${member.member_time} min` : '';

        // Add success animation
        row.classList.add('success-flash');
        setTimeout(() => row.classList.remove('success-flash'), 500);
    }

    /**
     * Delete member function
     */
    async deleteMember() {
        const memberId = document.getElementById('editMemberId').value;
        
        if (!confirm('Are you sure you want to delete this member? This action cannot be undone.')) {
            return;
        }

        try {
            this.showLoading(true);
            
            const response = await fetch(`/members/${memberId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showSuccess('Member deleted successfully!');
                this.removeTableRow(memberId);
                setTimeout(() => this.closeEditModal(), 1500);
            } else {
                this.showError(data.message || 'Failed to delete member');
            }
        } catch (error) {
            console.error('Error deleting member:', error);
            this.showError('An error occurred while deleting the member. Please try again.');
        } finally {
            this.showLoading(false);
        }
    }

    /**
     * Remove table row
     * @param {string} memberId - Member ID
     */
    removeTableRow(memberId) {
        const row = document.querySelector(`tr button[data-id="${memberId}"]`).closest('tr');
        if (row) {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            setTimeout(() => row.remove(), 300);
        }
    }

    /**
     * Display validation errors
     * @param {Object} errors - Validation errors object
     */
    displayValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const fieldElement = document.getElementById(`edit${this.capitalize(field)}`);
            if (fieldElement) {
                fieldElement.style.borderColor = '#ef4444';
                
                // Create or update error message
                let errorMsg = fieldElement.parentNode.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.style.color = '#ef4444';
                    errorMsg.style.fontSize = '0.875rem';
                    errorMsg.style.marginTop = '0.25rem';
                    fieldElement.parentNode.appendChild(errorMsg);
                }
                errorMsg.textContent = errors[field][0];
            }
        });
    }

    /**
     * Clear validation errors
     */
    clearErrors() {
        const errorMessages = this.form.querySelectorAll('.error-message');
        errorMessages.forEach(msg => msg.remove());
        
        const inputs = this.form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.style.borderColor = '';
        });
    }

    /**
     * Show loading state
     * @param {boolean} loading - Loading state
     */
    showLoading(loading) {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        const deleteBtn = this.form.querySelector('.btn-danger');
        
        if (loading) {
            this.form.classList.add('loading');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }
            if (deleteBtn) deleteBtn.disabled = true;
        } else {
            this.form.classList.remove('loading');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
            }
            if (deleteBtn) deleteBtn.disabled = false;
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
        
        // Toast styles
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '16px 20px',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '600',
            zIndex: '3000',
            animation: 'slideInRight 0.3s ease-out',
            boxShadow: '0 10px 25px rgba(0,0,0,0.2)',
            minWidth: '300px',
            background: type === 'success' ? 
                'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 
                'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'
        });

        document.body.appendChild(toast);

        // Auto remove after 4 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    /**
     * Capitalize first letter of string
     * @param {string} str - String to capitalize
     * @returns {string} Capitalized string
     */
    capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
}

// Global functions for backward compatibility
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

// CSS for toast animations (add to your CSS)
const toastStyles = `
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

.toast-notification {
    display: flex;
    align-items: center;
    gap: 12px;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 12px;
}
`;

// Add styles to head
if (!document.querySelector('#toast-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'toast-styles';
    styleSheet.textContent = toastStyles;
    document.head.appendChild(styleSheet);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.editModalHandler = new EditModalHandler();
});