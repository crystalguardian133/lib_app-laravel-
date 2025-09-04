async function openCardModal(memberId) {
    try {
        const res = await fetch(`/members/${memberId}/json`);
        if (!res.ok) throw new Error("Failed to fetch member data");
        const member = await res.json();

        // Format full name: Last, First M.
        const middleInitial = member.middleName ? member.middleName.charAt(0).toUpperCase() + "." : "";
        const fullName = `${member.lastName}, ${member.firstName} ${middleInitial}`.trim();

        // Fill overlays
        document.getElementById("card-name").innerText = member.fullName || "";
        document.getElementById("card-memberdate").innerText = member.memberdate || "";

        // Photo
        const photoDiv = document.getElementById("card-photo");
photoDiv.innerHTML = "";
if (member.photo) {
    const img = document.createElement("img");
    img.src = member.photo;
    photoDiv.appendChild(img);
}

        // QR Code
        const qrDiv = document.getElementById("card-qr");
        qrDiv.innerHTML = "";
        if (member.id) {
            const qrImg = document.createElement("img");
            qrImg.src = `/qrcode/members/member-${member.id}.png`;
            qrDiv.appendChild(qrImg);
        }

        // Show modal
        document.getElementById("cardModal").style.display = "block";

    } catch (err) {
        console.error("Failed to load member:", err);
        alert("Could not load member data.");
    }
}

// ✅ Export downscaled PNG but crisp
function downloadCard() {
    const card = document.getElementById("card-front"); // or wrap front+back

    html2canvas(card, { scale: 3 }).then(canvas => {
        const link = document.createElement("a");
        link.download = "membership-card.png";
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}

// Close modal
function closeCardModal() {
    document.getElementById("cardModal").style.display = "none";
}