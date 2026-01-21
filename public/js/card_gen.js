async function openCardModal(memberId) {
    try {
        const res = await fetch(`/members/${memberId}/json`);
        if (!res.ok) throw new Error("Failed to fetch member data");
        const member = await res.json();

        // Format full name: LAST, FIRST M.
        const middleInitial = member.middleName ? member.middleName.charAt(0).toUpperCase() + "." : "";
        const fullName = `${member.lastName.toUpperCase()}, ${member.firstName.toUpperCase()} ${middleInitial}`.trim();

        // Store member data globally for download
        const address = `${member.house_number || ""} ${member.street || ""}, ${member.barangay || ""}, ${member.municipality || ""}, ${member.province || ""}`.replace(/, ,/g, ',').trim();
        window.currentMemberData = {
            fullName: fullName,
            memberdate: member.memberdate || "",
            photo: member.photo || null,
            id: member.id,
            address: address,
            contact: member.contactnumber || ""
        };

        // Fill overlays for preview
        document.getElementById("card-name").innerText = fullName;
        document.getElementById("card-memberdate").innerText = member.memberdate || "";

        // Photo
        const photoDiv = document.getElementById("card-photo");
        photoDiv.innerHTML = "";
        photoDiv.style.cssText += 'border-radius: 0 !important; aspect-ratio: 1 !important; width: 80px !important; height: 80px !important;';
        if (member.photo) {
            const img = document.createElement("img");
            img.src = member.photo;
            img.style.cssText = `
                width: 100%;
                height: 100%;
                object-fit: fill;
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
        // Only set crossOrigin for external images (different origin)
        // For same-origin images, don't set crossOrigin to avoid CORS issues
        try {
            // Handle both absolute and relative URLs
            let url;
            if (src.startsWith('http://') || src.startsWith('https://')) {
                url = new URL(src);
            } else {
                // Relative URL - resolve against current origin
                url = new URL(src, window.location.origin);
            }
            // Only set crossOrigin if image is from different origin
            if (url.origin !== window.location.origin) {
                img.crossOrigin = "anonymous";
            }
        } catch (e) {
            // If URL parsing fails, assume same-origin and don't set crossOrigin
            console.warn('Could not parse image URL, assuming same-origin:', src, e);
        }
        img.onload = () => resolve(img);
        img.onerror = (error) => {
            console.error('Failed to load image:', src, error);
            reject(new Error(`Failed to load image: ${src}`));
        };
        img.src = src;
    });
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
    const cardWidth = 1012;
    const cardHeight = 638;
    
    const canvas = document.createElement('canvas');
    canvas.width = cardWidth;
    canvas.height = cardHeight;
    const ctx = canvas.getContext('2d', { alpha: true });
    
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.clearRect(0, 0, cardWidth, cardHeight);
    
    // Calculate scaling factors
    const scaleX = cardWidth / 380;
    const scaleY = cardHeight / 240;
    ctx.scale(scaleX, scaleY);
    
    try {
        // Load background image first
        let bgImg;
        try {
            bgImg = await loadImage('/card_temp/card-1.png');
        } catch (bgError) {
            throw new Error(`Failed to load front card background image: ${bgError.message || bgError}`);
        }
        
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

        // Draw address - WHITE COLOR, smaller font
        ctx.font = '10px Inter, Arial, sans-serif';
        ctx.fillStyle = '#FFFFFF';
        ctx.letterSpacing = '0.5px';
        const addressLines = wrapText(ctx, memberData.address, 180);
        let addressY = 210;
        addressLines.forEach((line, index) => {
            ctx.fillText(line, 45, addressY + (index * 12));
        });

        // Draw 1:1 square photo if available (ID picture style)
        if (memberData.photo) {
            try {
                const photoImg = await loadImage(memberData.photo);
                const photoX = 410 - 2.5 - 130; // Right side position
                const photoY = 125.5; // Center vertically
                const photoSize = 70; // Further reduced square size for 1:1 ratio

                // Draw square photo with 1:1 aspect ratio
                ctx.save();
                ctx.beginPath();
                ctx.rect(photoX - photoSize/2, photoY - photoSize/2, photoSize, photoSize);
                ctx.clip();

                // Force resize to exact square dimensions
                const drawWidth = photoSize;
                const drawHeight = photoSize;

                ctx.drawImage(photoImg, photoX - drawWidth/2, photoY - drawHeight/2, drawWidth, drawHeight);
                ctx.restore();
            } catch (photoError) {
                console.warn('Could not load member photo, continuing without photo:', photoError);
                // Continue without photo - card will still be generated
            }
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
    const cardWidth = 1012;
    const cardHeight = 638;
    
    const canvas = document.createElement('canvas');
    canvas.width = cardWidth;
    canvas.height = cardHeight;
    const ctx = canvas.getContext('2d', { alpha: true });
    
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.clearRect(0, 0, cardWidth, cardHeight);
    
    // Calculate scaling factors
    const scaleX = cardWidth / 380;
    const scaleY = cardHeight / 240;
    ctx.scale(scaleX, scaleY);
    
    try {
        // Load background image
        let bgImg;
        try {
            bgImg = await loadImage('/card_temp/card-2.png');
        } catch (bgError) {
            throw new Error(`Failed to load back card background image: ${bgError.message || bgError}`);
        }
        
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
        
        // Draw QR code shifted to the right
        if (memberData.id) {
            try {
                const qrImg = await loadImage(`/qrcode/members/member-${memberData.id}.png`);
                const qrSize = 90;
                const qrX = 380 - qrSize - 10; // Shifted to the right with reduced margin
                const qrY = (240 - qrSize) / 2; // Center vertically
                ctx.drawImage(qrImg, qrX, qrY, qrSize, qrSize);
            } catch (qrError) {
                console.warn('Could not load QR code, continuing without QR:', qrError);
                // Continue without QR code - card will still be generated
            }
        }

        // Draw contact number on the LEFT side
        ctx.font = 'bold 12px Inter, Arial, sans-serif';
        ctx.fillStyle = '#FFFFFF';
        ctx.textAlign = 'left';
        ctx.fillText(`Contact: ${memberData.contact}`, 20, 200);
        
        return canvas;
    } catch (error) {
        console.error('Error generating back card:', error);
        throw new Error(`Failed to generate back card: ${error.message || error}`);
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
