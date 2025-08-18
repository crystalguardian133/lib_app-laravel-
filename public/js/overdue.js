(function () {
    // Create toast container if it doesn’t exist
    let container = document.getElementById("toast-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "toast-container";
        document.body.appendChild(container);

        // Enhanced styling
        const style = document.createElement("style");
        style.innerHTML = `
            #toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            .toast {
                min-width: 300px;
                max-width: 400px;
                padding: 16px 20px;
                border-radius: 12px;
                font-family: "Inter", sans-serif;
                font-size: 14px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                display: flex;
                justify-content: space-between;
                align-items: center;
                animation: slideIn 0.4s ease;
                transition: all 0.3s ease;
            }
            .toast.error { 
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                color: #fff;
            }
            .toast.success { 
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: #fff;
            }
            .toast.warning { 
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                color: #fff;
            }
            .toast.info { 
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: #fff;
            }
            
            .toast.hide { 
                opacity: 0;
                transform: translateX(100%);
            }

            .toast button {
                background: rgba(255,255,255,0.2);
                border: none;
                color: white;
                font-size: 16px;
                cursor: pointer;
                margin-left: 12px;
                padding: 4px 8px;
                border-radius: 6px;
                transition: background 0.2s ease;
            }

            .toast button:hover {
                background: rgba(255,255,255,0.3);
            }

            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            body.dark-mode .toast {
                box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            }

            .overdue-notice {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                color: #fff;
                padding: 20px;
                border-radius: 12px;
                font-family: "Inter", sans-serif;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                max-width: 400px;
                margin-bottom: 10px;
            }
            .overdue-notice h3 {
                margin: 0 0 10px 0;
                font-size: 16px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .overdue-list {
                margin: 0;
                padding: 0;
                list-style: none;
            }
            .overdue-list li {
                padding: 8px 0;
                border-bottom: 1px solid rgba(255,255,255,0.2);
                font-size: 14px;
            }
            .overdue-list li:last-child {
                border-bottom: none;
            }
            .close-notice {
                position: absolute;
                top: 10px;
                right: 10px;
                background: rgba(255,255,255,0.2);
                border: none;
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                cursor: pointer;
            }
            .close-notice:hover {
                background: rgba(255,255,255,0.3);
            }
        `;
        document.head.appendChild(style);
    }

    // Global notification function
    window.Notify = function (message, type = "info", duration = 4000) {
        if (!message) return;

        const toast = document.createElement("div");
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button>&times;</button>
        `;

        // Dismiss handler
        toast.querySelector("button").addEventListener("click", () => {
            dismissToast(toast);
        });

        container.appendChild(toast);

        // Auto dismiss
        if (duration !== 0) {
            setTimeout(() => {
                dismissToast(toast);
            }, duration);
        }

        return toast;
    };

    function dismissToast(toast) {
        toast.classList.add("hide");
        setTimeout(() => toast.remove(), 300);
    }

    // Public API
    return {
        success: (msg, duration) => Notify(msg, "success", duration),
        error: (msg, duration) => Notify(msg, "error", duration),
        warning: (msg, duration) => Notify(msg, "warning", duration),
        info: (msg, duration) => Notify(msg, "info", duration)
    };

    // Function to check and display overdue books
    window.checkOverdueBooks = function() {
        fetch('/check-overdue')
            .then(response => response.json())
            .then(data => {
                if (data.overdueMembers && data.overdueMembers.length > 0) {
                    showOverdueNotice(data.overdueMembers);
                }
            });
    };

    function showOverdueNotice(members) {
        const notice = document.createElement('div');
        notice.className = 'overdue-notice';
        
        let html = `
            <h3>⚠️ Overdue Books Alert</h3>
            <button class="close-notice">&times;</button>
            <ul class="overdue-list">
        `;

        members.forEach(member => {
            html += `
                <li>
                    <strong>${member.name}</strong><br>
                    Books: ${member.books.join(', ')}<br>
                    Due: ${member.dueDate}
                </li>
            `;
        });

        html += '</ul>';
        notice.innerHTML = html;

        // Add close button handler
        notice.querySelector('.close-notice').addEventListener('click', () => {
            notice.remove();
        });

        container.appendChild(notice);
    }

    // Check for overdue books when page loads
    document.addEventListener('DOMContentLoaded', checkOverdueBooks);
})();
