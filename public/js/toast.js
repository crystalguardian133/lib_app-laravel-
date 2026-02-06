// Toast Notification System
class Toast {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Create container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('toast-container');
        }
    }

    show(options) {
        const {
            title = '',
            message = '',
            type = 'info',
            duration = 3000,
            reloadAfter = null
        } = options;

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        // Icon based on type
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-times-circle"></i>',
            warning: '<i class="fas fa-exclamation-circle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };

        toast.innerHTML = `
            <div class="toast-icon">${icons[type] || icons.info}</div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="toast.close(this.parentElement)">
                <i class="fas fa-times"></i>
            </button>
            <div class="toast-progress">
                <div class="toast-progress-bar"></div>
            </div>
        `;

        this.container.appendChild(toast);

        // Close button functionality
        toast.querySelector('.toast-close').addEventListener('click', () => {
            this.close(toast);
        });

        // Auto close
        if (duration > 0) {
            setTimeout(() => {
                this.close(toast);
            }, duration);
        }

        // Reload after specified time
        if (reloadAfter) {
            setTimeout(() => {
                window.location.reload();
            }, reloadAfter);
        }

        return toast;
    }

    close(toast) {
        if (!toast) return;
        toast.classList.add('hiding');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    success(message, title = 'Success') {
        return this.show({ title, message, type: 'success' });
    }

    error(message, title = 'Error') {
        return this.show({ title, message, type: 'error' });
    }

    warning(message, title = 'Warning') {
        return this.show({ title, message, type: 'warning' });
    }

    info(message, title = 'Info') {
        return this.show({ title, message, type: 'info' });
    }

    // Show access denied toast
    accessDenied(feature = 'this feature') {
        return this.show({
            title: 'Access Denied',
            message: `You don't have permission to access ${feature}. Please contact your administrator.`,
            type: 'warning',
            duration: 4000,
            reloadAfter: 4000
        });
    }

    // Show role restriction toast
    roleRestriction(role = 'this feature') {
        return this.show({
            title: 'Restricted Access',
            message: `Only ${role} can access this feature. Redirecting...`,
            type: 'info',
            duration: 3000,
            reloadAfter: 3000
        });
    }
}

// Global toast instance
window.toast = new Toast();

// Check for toast data in session and show
document.addEventListener('DOMContentLoaded', function() {
    // Check for toast data in sessionStorage (set by server)
    const toastData = sessionStorage.getItem('toast');
    if (toastData) {
        try {
            const data = JSON.parse(toastData);
            window.toast[data.type](data.message, data.title);
            sessionStorage.removeItem('toast');
        } catch (e) {
            console.error('Error parsing toast data:', e);
        }
    }

    // Check for toast data in body data attributes
    const body = document.body;
    if (body.dataset.toastType && body.dataset.toastMessage) {
        window.toast.show({
            title: body.dataset.toastTitle || '',
            message: body.dataset.toastMessage,
            type: body.dataset.toastType,
            duration: parseInt(body.dataset.toastDuration) || 3000
        });
        // Clear the data attributes
        delete body.dataset.toastType;
        delete body.dataset.toastMessage;
        delete body.dataset.toastTitle;
        delete body.dataset.toastDuration;
    }
});

// Function to set toast from server-side (Laravel)
function setToast(type, message, title = '') {
    sessionStorage.setItem('toast', JSON.stringify({ type, message, title }));
}

// Helper functions for common toast scenarios
function accessDeniedToast(feature) {
    toast.accessDenied(feature);
}

function showReloadToast(message, duration = 3000) {
    toast.show({
        title: 'Notice',
        message: message,
        type: 'info',
        duration: duration,
        reloadAfter: duration
    });
}
