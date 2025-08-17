(function () {
    // Create toast container if it doesn’t exist
    let container = document.getElementById("toast-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "toast-container";
        document.body.appendChild(container);

        // Add styling
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
                min-width: 250px;
                max-width: 350px;
                background: #f44336; /* red for overdue */
                color: #fff;
                padding: 14px 18px;
                border-radius: 8px;
                font-family: "Inter", sans-serif;
                font-size: 14px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                display: flex;
                justify-content: space-between;
                align-items: center;
                animation: slideIn 0.4s ease, fadeOut 0.5s ease forwards;
            }
            .toast.success { background: #4caf50; }
            .toast.warning { background: #ff9800; }
            .toast.info { background: #2196f3; }
            
            .toast.hide { opacity: 0; transform: translateX(100%); }

            .toast button {
                background: none;
                border: none;
                color: white;
                font-size: 16px;
                cursor: pointer;
                margin-left: 12px;
            }

            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }

    // Main function
    window.showToast = function (message, type = "error", duration = 4000) {
        const toast = document.createElement("div");
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button>&times;</button>
        `;

        // Manual dismiss
        toast.querySelector("button").addEventListener("click", () => {
            dismissToast(toast);
        });

        container.appendChild(toast);

        // Auto dismiss
        setTimeout(() => {
            dismissToast(toast);
        }, duration);
    };

    function dismissToast(toast) {
        toast.classList.add("hide");
        setTimeout(() => {
            toast.remove();
        }, 500);
    }
})();
