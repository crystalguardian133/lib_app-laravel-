document.addEventListener("DOMContentLoaded", () => {
  const chatBtn = document.getElementById("chatbot-button");
  const chatWindow = document.getElementById("chatbot-window");
  const closeBtn = document.getElementById("chatbot-close");
  const sendBtn = document.getElementById("chatbot-send");
  const userInput = document.getElementById("chatbot-user-input");
  const chatMessages = document.getElementById("chatbot-messages");
  const statusBox = document.getElementById("connection-status");

  // Show chatbot
  chatBtn.onclick = () => chatWindow.style.display = "flex";
  closeBtn.onclick = () => chatWindow.style.display = "none";

  sendBtn.onclick = async () => {
    const message = userInput.value.trim();
    if (!message) return;

    appendMessage("user", message);
    userInput.value = "";
    appendMessage("bot", "Typing...");

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

      if (data.reply) {
        updateLastBotMessage(data.reply);
      } else {
        updateLastBotMessage("No reply received.");
      }
    } catch (err) {
      updateLastBotMessage("❌ Could not connect.");
    }
  };

  function appendMessage(sender, text) {
    const div = document.createElement("div");
    div.className = `msg ${sender}`;
    div.textContent = text;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function updateLastBotMessage(text) {
    const messages = document.querySelectorAll(".bot");
    if (messages.length > 0) {
      messages[messages.length - 1].textContent = text;
    }
  }

  // 🔌 Connection popup
  function showStatus(message, connected = false) {
    statusBox.textContent = message;
    statusBox.classList.toggle("connected", connected);
    statusBox.style.display = "block";
    setTimeout(() => statusBox.style.display = "none", 3000);
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
