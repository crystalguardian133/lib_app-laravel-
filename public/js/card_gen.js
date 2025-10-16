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
            img.style.cssText = `
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center center;
                display: block;
            `;
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
        const modal = document.getElementById("cardModal");
        modal.classList.add("show");
        modal.style.display = "flex";

    } catch (err) {
        console.error("Failed to load member:", err);
        alert("Could not load member data.");
    }
}

// ✅ Export both cards as PNG in ZIP
async function downloadCard() {
    const frontCard = document.getElementById("card-front");
    const backCard = document.getElementById("card-back");

    try {
        // Show loading state
        const downloadBtn = event.target;
        const originalText = downloadBtn.innerHTML;
        downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing...';
        downloadBtn.disabled = true;

        // Capture both cards
        const frontCanvas = await html2canvas(frontCard, {
            scale: 3,
            backgroundColor: null,
            useCORS: true
        });

        const backCanvas = await html2canvas(backCard, {
            scale: 3,
            backgroundColor: null,
            useCORS: true
        });

        // Create ZIP file
        const zip = new JSZip();

        // Add front card as PNG
        const frontDataURL = frontCanvas.toDataURL("image/png");
        zip.file("membership-card-front.png", frontDataURL.split(',')[1], {base64: true});

        // Add back card as PNG
        const backDataURL = backCanvas.toDataURL("image/png");
        zip.file("membership-card-back.png", backDataURL.split(',')[1], {base64: true});

        // Generate ZIP
        const zipBlob = await zip.generateAsync({type: "blob"});

        // Create download link
        const link = document.createElement("a");
        link.href = URL.createObjectURL(zipBlob);
        link.download = "membership-cards.zip";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Clean up
        URL.revokeObjectURL(link.href);

        // Restore button
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;

        alert("✅ Membership cards downloaded as ZIP file!");

    } catch (error) {
        console.error("Download error:", error);
        alert("❌ Error creating download. Please try again.");

        // Restore button
        const downloadBtn = event.target;
        downloadBtn.innerHTML = '<i class="fas fa-download"></i> Download PNG';
        downloadBtn.disabled = false;
    }
}

// Close modal
function closeCardModal() {
    const modal = document.getElementById("cardModal");
    modal.classList.remove("show");
    modal.style.display = "none";
}

// Click outside modal to close
document.addEventListener('click', function(e) {
    const modal = document.getElementById("cardModal");
    if (e.target === modal && modal.classList.contains("show")) {
        closeCardModal();
    }
});