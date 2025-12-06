async function openCardModal(memberId) {
    try {
        const res = await fetch(`/members/${memberId}/json`);
        if (!res.ok) throw new Error("Failed to fetch member data");
        const member = await res.json();

        // Format full name: LAST, FIRST M.
        const middleInitial = member.middleName ? member.middleName.charAt(0).toUpperCase() + "." : "";
        const fullName = `${member.lastName.toUpperCase()}, ${member.firstName.toUpperCase()} ${middleInitial}`.trim();

        // Store member data globally for download
        window.currentMemberData = {
            fullName: fullName,
            memberdate: member.memberdate || "",
            photo: member.photo || null,
            id: member.id
        };

        // Fill overlays for preview
        document.getElementById("card-name").innerText = fullName;
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

// Helper function to load image
function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "anonymous";
        img.onload = () => resolve(img);
        img.onerror = reject;
        img.src = src;
    });
}

// Draw circular image - 100% FILL
function drawCircularImage(ctx, img, x, y, radius) {
    ctx.save();
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, Math.PI * 2);
    ctx.closePath();
    ctx.clip();
    
    // Calculate dimensions to FULLY COVER the circle (100% fill)
    const imgAspect = img.width / img.height;
    const circleAspect = 1; // Circle is always 1:1
    
    let drawWidth, drawHeight;
    
    // Scale image to cover entire circle area
    if (imgAspect > circleAspect) {
        // Image is wider - fit to height
        drawHeight = radius * 2;
        drawWidth = drawHeight * imgAspect;
    } else {
        // Image is taller - fit to width
        drawWidth = radius * 2;
        drawHeight = drawWidth / imgAspect;
    }
    
    // Ensure minimum coverage (add 10% buffer for 100% fill guarantee)
    const minDimension = radius * 2;
    if (drawWidth < minDimension) drawWidth = minDimension;
    if (drawHeight < minDimension) drawHeight = minDimension;
    
    ctx.drawImage(
        img,
        x - drawWidth / 2,
        y - drawHeight / 2,
        drawWidth,
        drawHeight
    );
    ctx.restore();
}

// Wrap text to fit within width
function wrapText(ctx, text, maxWidth) {
    const words = text.split(' ');
    const lines = [];
    let currentLine = words[0];

    for (let i = 1; i < words.length; i++) {
        const word = words[i];
        const width = ctx.measureText(currentLine + " " + word).width;
        if (width < maxWidth) {
            currentLine += " " + word;
        } else {
            lines.push(currentLine);
            currentLine = word;
        }
    }
    lines.push(currentLine);
    return lines;
}

// Generate front card on canvas
async function generateFrontCard(memberData) {
    // Philippine Driver's License / CR80 card size
    // 85.6mm × 53.98mm at 300 DPI = 1012px × 638px
    const cardWidth = 1012;  // pixels at 300 DPI
    const cardHeight = 638;  // pixels at 300 DPI
    
    const canvas = document.createElement('canvas');
    canvas.width = cardWidth;
    canvas.height = cardHeight;
    const ctx = canvas.getContext('2d', { alpha: true }); // Enable transparency
    
    // Enable high quality rendering
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    
    // Clear canvas to ensure transparency
    ctx.clearRect(0, 0, cardWidth, cardHeight);
    
    // Calculate scaling factors
    const scaleX = cardWidth / 380;
    const scaleY = cardHeight / 240;
    
    // Scale context to fit card dimensions
    ctx.scale(scaleX, scaleY);
    
    try {
        // Load background image first
        const bgImg = await loadImage('/card_temp/card-1.png');
        
        // Create rounded rectangle path for clipping
        const borderRadius = 16;
        ctx.beginPath();
        ctx.moveTo(borderRadius, 0);
        ctx.lineTo(380 - borderRadius, 0);
        ctx.arcTo(380, 0, 380, borderRadius, borderRadius);
        ctx.lineTo(380, 240 - borderRadius);
        ctx.arcTo(380, 240, 380 - borderRadius, 240, borderRadius);
        ctx.lineTo(borderRadius, 240);
        ctx.arcTo(0, 240, 0, 240 - borderRadius, borderRadius);
        ctx.lineTo(0, borderRadius);
        ctx.arcTo(0, 0, borderRadius, 0, borderRadius);
        ctx.closePath();
        ctx.clip();
        
        // Draw background
        ctx.drawImage(bgImg, 0, 0, 380, 240);
        
        // Draw name text - WHITE COLOR, BOLD, UPPERCASE
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 11px Inter, Arial, sans-serif';
        ctx.textAlign = 'left';
        ctx.letterSpacing = '0.5px';
        
        const nameLines = wrapText(ctx, memberData.fullName, 180);
        const nameX = 45;
        let nameY = 121;
        const lineHeight = 14;
        
        nameLines.forEach((line, index) => {
            ctx.fillText(line, nameX, nameY + (index * lineHeight));
        });
        
        // Draw membership date - WHITE COLOR, BOLD
        ctx.font = 'bold 13px Inter, Arial, sans-serif';
        ctx.fillStyle = '#FFFFFF';
        ctx.letterSpacing = '0.5px';
        ctx.fillText(memberData.memberdate, 140, 189);
        
        // Draw photo if available
        if (memberData.photo) {
            const photoImg = await loadImage(memberData.photo);
            const photoX = 410 - 2.5 - 130;
            const photoY = 125.5;
            const photoRadius = 77.3;
            
            // Draw subtle border circle
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.arc(photoX, photoY, photoRadius, 0, Math.PI * 2);
            ctx.stroke();
            
            // Draw circular photo
            drawCircularImage(ctx, photoImg, photoX, photoY, photoRadius);
        }
        
        return canvas;
    } catch (error) {
        console.error('Error generating front card:', error);
        throw error;
    }
}

// Generate back card on canvas
async function generateBackCard(memberData) {
    // Philippine Driver's License / CR80 card size
    // 85.6mm × 53.98mm at 300 DPI = 1012px × 638px
    const cardWidth = 1012;
    const cardHeight = 638;
    
    const canvas = document.createElement('canvas');
    canvas.width = cardWidth;
    canvas.height = cardHeight;
    const ctx = canvas.getContext('2d', { alpha: true }); // Enable transparency
    
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    
    // Clear canvas to ensure transparency
    ctx.clearRect(0, 0, cardWidth, cardHeight);
    
    // Calculate scaling factors
    const scaleX = cardWidth / 380;
    const scaleY = cardHeight / 240;
    
    // Scale context to fit card dimensions
    ctx.scale(scaleX, scaleY);
    
    try {
        // Load background image first
        const bgImg = await loadImage('/card_temp/card-2.png');
        
        // Create rounded rectangle path for clipping
        const borderRadius = 16;
        ctx.beginPath();
        ctx.moveTo(borderRadius, 0);
        ctx.lineTo(380 - borderRadius, 0);
        ctx.arcTo(380, 0, 380, borderRadius, borderRadius);
        ctx.lineTo(380, 240 - borderRadius);
        ctx.arcTo(380, 240, 380 - borderRadius, 240, borderRadius);
        ctx.lineTo(borderRadius, 240);
        ctx.arcTo(0, 240, 0, 240 - borderRadius, borderRadius);
        ctx.lineTo(0, borderRadius);
        ctx.arcTo(0, 0, borderRadius, 0, borderRadius);
        ctx.closePath();
        ctx.clip();
        
        // Draw background
        ctx.drawImage(bgImg, 0, 0, 380, 240);
        
        // Draw QR code
        if (memberData.id) {
            const qrImg = await loadImage(`/qrcode/members/member-${memberData.id}.png`);
            const qrSize = 130;
            const qrX = (380 - qrSize) / 2; // center
            const qrY = (240 - qrSize) / 2; // center
            ctx.drawImage(qrImg, qrX, qrY, qrSize, qrSize);
        }
        
        return canvas;
    } catch (error) {
        console.error('Error generating back card:', error);
        throw error;
    }
}

// ✅ Export both cards as PNG in ZIP - CANVAS METHOD
async function downloadCard() {
    try {
        // Show loading state
        const downloadBtn = event.target;
        const originalText = downloadBtn.innerHTML;
        downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing...';
        downloadBtn.disabled = true;

        const memberData = window.currentMemberData;
        if (!memberData) {
            throw new Error("Member data not found");
        }

        // Generate both cards using canvas
        const frontCanvas = await generateFrontCard(memberData);
        const backCanvas = await generateBackCard(memberData);

        // Create ZIP file
        const zip = new JSZip();

        // Add front card as PNG
        const frontDataURL = frontCanvas.toDataURL("image/png", 1.0);
        zip.file("membership-card-front.png", frontDataURL.split(',')[1], {base64: true});

        // Add back card as PNG
        const backDataURL = backCanvas.toDataURL("image/png", 1.0);
        zip.file("membership-card-back.png", backDataURL.split(',')[1], {base64: true});

        // Generate ZIP
        const zipBlob = await zip.generateAsync({type: "blob"});

        // Create download link
        const link = document.createElement("a");
        link.href = URL.createObjectURL(zipBlob);
        
        const memberName = memberData.fullName.replace(/[^a-z0-9]/gi, '_').toLowerCase();
        link.download = `membership-card-${memberName}.zip`;
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Clean up
        URL.revokeObjectURL(link.href);

        // Restore button
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;

        // Show success message
        alert("✅ Membership cards downloaded successfully!");

    } catch (error) {
        console.error("Download error:", error);
        alert("❌ Error creating download: " + error.message);

        // Restore button
        const downloadBtn = event.target;
        downloadBtn.innerHTML = '<i class="fas fa-download"></i> Download Cards (ZIP)';
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