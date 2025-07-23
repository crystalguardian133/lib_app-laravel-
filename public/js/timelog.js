const input = document.getElementById("memberInput");
const box = document.getElementById("suggestionBox");
const token = document.querySelector('meta[name="csrf-token"]').content;

input.addEventListener("input", () => {
  const query = input.value.trim();
  box.innerHTML = "";

  if (query.length === 0) return;

  fetch(`/timelog/search?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
      if (data.length === 0) {
        box.innerHTML = "<div>No results found</div>";
        return;
      }
      data.forEach(member => {
  const div = document.createElement("div");
  div.textContent = member.name;
  div.onclick = () => selectMember(member.name);
  box.appendChild(div);
});
    });
});

function selectMember(name) {
  input.value = name;
  box.innerHTML = "";

  fetch("/timelog/time-in", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": token
    },
    body: JSON.stringify({ member_name: name })
  })
  .then(res => res.json())
  .then(data => {
    showPopup(data.message || "⏱️ Time-in successful.");
    if (data.message.includes("✅") || data.message.includes("⚠️")) {
      setTimeout(() => location.reload(), 1000);
    }
  })
  .catch(() => showPopup("❌ Failed to time in."));
}

function timeOut(id, btn) {
  fetch("/timelog/time-out", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": token
    },
    body: JSON.stringify({ id: id })
  })
  .then(res => res.json())
  .then(data => {
    showPopup(data.message || "✅ Time-out recorded.");
    const row = btn.closest("tr");
    row.remove();
  })
  .catch(() => showPopup("❌ Failed to time out."));
}

function showPopup(message) {
  const popup = document.getElementById("popup");
  popup.textContent = message;
  popup.style.display = "block";
  setTimeout(() => popup.style.display = "none", 3000);
}