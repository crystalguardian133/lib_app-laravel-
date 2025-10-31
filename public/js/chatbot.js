document.addEventListener("DOMContentLoaded", () => {
  const chatBtn = document.getElementById("chatbot-button");
  const chatWindow = document.getElementById("chatbot-window");
  const closeBtn = document.getElementById("chatbot-close");
  const sendBtn = document.getElementById("chatbot-send");
  const userInput = document.getElementById("chatbot-user-input");
  const chatMessages = document.getElementById("chatbot-messages");
  const statusBox = document.getElementById("connection-status");

  // Track chatbot state
  let isChatbotOpen = false;

  // Show/hide chatbot
  chatBtn.onclick = () => {
    if (isChatbotOpen) {
      // Close chatbot
      chatWindow.style.display = "none";
      isChatbotOpen = false;
    } else {
      // Open chatbot
      chatWindow.style.display = "flex";
      isChatbotOpen = true;
      appendGreetingMessage();
    }
  };
  closeBtn.onclick = () => {
    chatWindow.style.display = "none";
    isChatbotOpen = false;
  };

  // Keyboard shortcuts
  document.addEventListener('keydown', (e) => {
    // Close chatbot with Escape key
    if (e.key === 'Escape' && chatWindow.style.display === 'flex') {
      chatWindow.style.display = 'none';
    }

    // Send message with Enter key (when chatbot is open and input is focused)
    if (e.key === 'Enter' && chatWindow.style.display === 'flex' && document.activeElement === userInput) {
      e.preventDefault(); // Prevent default form submission
      sendBtn.click();
    }
  });

  // Handle placeholder text switching on hover (only on input field)
  let placeholderTimeout;
  const inputField = document.getElementById('chatbot-user-input');
  const geminiBranding = document.getElementById('gemini-branding');
  if (inputField && geminiBranding) {
    // Hide Gemini branding when user starts typing
    inputField.addEventListener('input', () => {
      if (inputField.value.trim() !== '') {
        geminiBranding.style.display = 'none';
        inputField.placeholder = '';
      } else {
        // Show branding when input becomes empty again
        geminiBranding.style.display = 'block';
        inputField.placeholder = '';
      }
    });

    // Show Gemini branding when input is empty and not focused
    inputField.addEventListener('blur', () => {
      if (inputField.value.trim() === '') {
        geminiBranding.style.display = 'block';
        inputField.placeholder = '';
      }
    });

    inputField.addEventListener('mouseenter', () => {
      if (inputField.value.trim() === '') {
        clearTimeout(placeholderTimeout);
        // Immediate visual effects
        inputField.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        inputField.style.boxShadow = '0 0 20px rgba(99, 102, 241, 0.3), 0 0 40px rgba(99, 102, 241, 0.1)';
        inputField.style.borderColor = 'var(--primary)';
        inputField.style.transform = 'translateY(-1px)';

        // Text change with smooth animation
        inputField.style.opacity = '0.7';
        geminiBranding.style.opacity = '0';
        placeholderTimeout = setTimeout(() => {
          inputField.placeholder = '';
          geminiBranding.style.display = 'block';
          geminiBranding.style.opacity = '1';
          inputField.style.opacity = '1';
        }, 80);
      }
    });

    inputField.addEventListener('mouseleave', () => {
      if (inputField.value.trim() === '') {
        clearTimeout(placeholderTimeout);
        // Immediate removal of visual effects
        inputField.style.boxShadow = '';
        inputField.style.borderColor = '';
        inputField.style.transform = 'translateY(0)';

        // Text change with smooth animation
        inputField.style.opacity = '0.8';
        geminiBranding.style.opacity = '0';
        placeholderTimeout = setTimeout(() => {
          inputField.placeholder = 'Ask me anything...';
          geminiBranding.style.display = 'none';
          inputField.style.opacity = '1';
        }, 80);
      }
    });
  }

  sendBtn.onclick = async () => {
    const message = userInput.value.trim();
    if (!message) return;

    appendMessage("user", message);
    userInput.value = "";
    userInput.classList.add('thinking');
    appendTypingIndicator();

    try {
      const response = await fetch("/chatbot/message", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message })
      });

      const data = await response.json();

      userInput.classList.remove('thinking');
      if (data.reply) {
        updateLastBotMessage(data.reply);
      } else {
        updateLastBotMessage("No reply received.");
      }
    } catch (err) {
      userInput.classList.remove('thinking');
      updateLastBotMessage("❌ Could not connect.");
    }
  };

  function appendMessage(sender, text) {
    const messageContainer = document.createElement("div");
    messageContainer.className = `message-container ${sender}`;

    const icon = document.createElement("i");
    icon.className = sender === "user" ? "fas fa-user" : "fas fa-robot";

    const div = document.createElement("div");
    div.className = `msg ${sender}`;
    div.textContent = text;

    messageContainer.appendChild(icon);
    messageContainer.appendChild(div);
    chatMessages.appendChild(messageContainer);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function appendGreetingMessage() {
    const messageContainer = document.createElement("div");
    messageContainer.className = "message-container bot";

    const icon = document.createElement("i");
    icon.className = "fas fa-robot";

    const div = document.createElement("div");
    div.className = "msg bot";
    div.textContent = "👋 Hello! Welcome to Julita Public Library! I'm here to help you with any questions about our books, borrowing, or library services. How can I assist you today?";

    messageContainer.appendChild(icon);
    messageContainer.appendChild(div);
    chatMessages.appendChild(messageContainer);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function appendTypingIndicator() {
    const messageContainer = document.createElement("div");
    messageContainer.className = "message-container bot";

    const typingDiv = document.createElement("div");
    typingDiv.className = "msg bot typing-indicator";

    const rippleContainer = document.createElement("div");
    rippleContainer.className = "ripple-container";

    for (let i = 0; i < 3; i++) {
      const circle = document.createElement("div");
      circle.className = "ripple-circle";
      circle.style.animationDelay = `${i * 0.2}s`;
      rippleContainer.appendChild(circle);
    }

    typingDiv.appendChild(rippleContainer);
    messageContainer.appendChild(typingDiv);
    chatMessages.appendChild(messageContainer);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function updateLastBotMessage(text) {
    const messages = document.querySelectorAll(".bot");
    if (messages.length > 0) {
      const lastMessage = messages[messages.length - 1];
      // Clear existing content but preserve the icon
      lastMessage.innerHTML = '';
      const icon = document.createElement("i");
      icon.className = "fas fa-robot";
      lastMessage.appendChild(icon);
      lastMessage.appendChild(document.createTextNode(" " + text));
      lastMessage.classList.remove("typing-indicator");
    }
  }

  // 🔌 Connection popup
  function showStatus(message, connected = false) {
    if (statusBox) {
      statusBox.textContent = message;
      statusBox.classList.toggle("connected", connected);
      statusBox.style.display = "block";
      setTimeout(() => statusBox.style.display = "none", 3000);
    }
  }

  function updateConnectionStatus() {
    if (navigator.onLine) {
      showStatus("✅ Connected to internet", true);
    } else {
      showStatus("❌ Offline", false);
    }
  }

  window.addEventListener("load", updateConnectionStatus);
  window.addEventListener("online", () => showStatus("✅ Reconnected", true));
  window.addEventListener("offline", () => showStatus("❌ You are offline", false));
});
