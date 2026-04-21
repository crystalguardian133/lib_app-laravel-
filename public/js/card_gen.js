/**
 * Unified Card Generation System
 * Ensures preview and export use identical positioning and sizing
 * 
 * Card dimensions: 380x240 logical units (matches 1012x638px at 300 DPI)
 * DPI scaling: 2.666x (1012/380, 638/240)
 */

// ============================================================================
// CARD LAYOUT CONFIGURATION - Single source of truth for all positioning
// ============================================================================

const CARD_CONFIG = {
    // Logical canvas dimensions (used for all calculations)
    LOGICAL_WIDTH: 380,
    LOGICAL_HEIGHT: 240,
    
    // Export dimensions (physical pixels at 300 DPI)
    EXPORT_WIDTH: 1012,
    EXPORT_HEIGHT: 638,
    
    // Border radius
    BORDER_RADIUS: 16,
    
    // FRONT CARD LAYOUT
    FRONT: {
        // Name positioning (goes after "MEMBER" label in middle area)
        name: {
            x: 46,
            y: 118,
            maxWidth: 200,
            fontSize: 10,
            lineHeight: 12,
            fontWeight: 'bold',
            color: '#FFFFFF',
            uppercase: true
        },
        
        // Address text VALUE (goes after "Address:" label in lower section)
        address: {
            x: 78,
            y: 195.5,
            maxWidth: 130,
            fontSize: 7,
            lineHeight: 8,
            fontWeight: 'normal',
            color: '#FFFFFF'
        },
        
        // Membership date VALUE (goes after "Membership Date:" label at bottom)
        memberdate: {
            x: 128,
            y: 224,
            fontSize: 10,
            fontWeight: 'bold',
            color: '#FFFFFF'
        },
        
        // Photo positioning
        photo: {
            x: 265,
            y: 81,
            size: 59,
            borderRadius: 0
        }
    },
    
    // BACK CARD LAYOUT
    BACK: {
        // Contact number VALUE (goes after "Contact Number:" label on left)
        contactNumber: {
            x: 20,
            y: 232,
            fontSize: 10,
            fontWeight: 'bold',
            color: '#FFFFFF'
        },
        
        // QR code positioning (right side, centered vertically)
        qr: {
            x: 250,
            y: 38,
            width: 113,
            height: 130
        }
    }
};

// ============================================================================
// OPEN CARD MODAL - Data Loading and Preview Setup
// ============================================================================

async function openCardModal(memberId) {
    try {
        const res = await fetch(`/api/members/${encodeURIComponent(memberId)}`, {
            credentials: 'include',
            headers: {
                'Accept': 'application/json',
            },
        });
        if (!res.ok) {
            if (res.status === 401 || res.status === 403) {
                throw new Error('You do not have permission to view this member.');
            }
            throw new Error("Failed to fetch member data");
        }
        const member = await res.json();
        const row = document.querySelector(`tr[data-id="${String(memberId).trim()}"]`) ||
            document.querySelector(`tr[data-legacy-id="${String(memberId).trim()}"]`);
        const rowFullName = row?.dataset.fullName || '';
        const rowMemberdate = row?.dataset.memberdate || '';
        const rowPhotoUrl = row?.dataset.photoUrl || '';
        const rowUuid = row?.dataset.uuid || row?.dataset.id || String(memberId).trim();

        const fullName = (member.full_name || member.fullName || rowFullName || [member.lastName || member.last_name, member.firstName || member.first_name, member.middleName || member.middle_name]
            .filter(part => part && part !== 'null')
            .join(' ')).trim();

        // Format address - filter out null strings
        const houseNumber = (member.house_number || member.houseNumber || row?.dataset.houseNumber || '').trim();
        const street = (member.street || row?.dataset.street || '').trim();
        const barangay = (member.barangay || row?.dataset.barangay || '').trim();
        const municipality = (member.municipality || row?.dataset.municipality || '').trim();
        const province = (member.province || row?.dataset.province || '').trim();
        const contact = member.contactnumber || member.contactNumber || row?.dataset.contactnumber || '';

        // Build address, filtering out empty parts and 'null' strings
        const addressParts = [
            houseNumber && houseNumber !== 'null' ? houseNumber : '',
            street && street !== 'null' ? street : '',
            barangay && barangay !== 'null' ? barangay : '',
            municipality && municipality !== 'null' ? municipality : '',
            province && province !== 'null' ? province : ''
        ].filter(part => part && part !== 'null');
        const address = addressParts.join(', ');

        // Format membership date - remove timestamp, show only date
        let formattedDate = "";
        if (member.memberdate || rowMemberdate) {
            try {
                const rawDate = member.memberdate || rowMemberdate;
                const dateObj = new Date(rawDate);
                if (!isNaN(dateObj)) {
                    formattedDate = dateObj.toISOString().split('T')[0]; // Returns YYYY-MM-DD
                } else {
                    formattedDate = rawDate;
                }
            } catch (e) {
                formattedDate = member.memberdate || rowMemberdate;
            }
        }

        // Store member data globally for download
        window.currentMemberData = {
            fullName: fullName,
            memberdate: formattedDate || rowMemberdate,
            photo: member.photo_url || member.photo || rowPhotoUrl || null,
            qrKey: member.uuid || rowUuid || null,
            address: address,
            contact: contact
        };

        // === FRONT CARD PREVIEW ===
        updateFrontCardPreview(window.currentMemberData);

        // === BACK CARD PREVIEW ===
        updateBackCardPreview(window.currentMemberData);

        // Show modal
        const modal = document.getElementById("cardModal");
        modal.classList.add("show");
        modal.style.display = "flex";

    } catch (err) {
        console.error("Failed to load member:", err);
        alert("Could not load member data.");
    }
}

// ============================================================================
// PREVIEW OVERLAY UPDATE FUNCTIONS
// ============================================================================

function updateFrontCardPreview(memberData) {
    // Update name
    const nameEl = document.getElementById("card-name");
    nameEl.innerText = memberData.fullName || "";

    // Update membership date VALUE
    const dateEl = document.getElementById("card-memberdate");
    dateEl.innerText = memberData.memberdate || "";

    // Update address VALUE
    const addressEl = document.getElementById("card-address");
    addressEl.innerText = memberData.address;

    // Update photo
    const photoDiv = document.getElementById("card-photo");
    photoDiv.innerHTML = "";
    photoDiv.style.cssText = `
        width: 70px !important;
        height: 70px !important;
        border-radius: 1px !important;
        overflow: hidden !important;
        position: absolute !important;
        top: 96px !important;
        right: 67px !important;
        z-index: 3 !important;
    `;
    
    if (memberData.photo) {
        const img = document.createElement("img");
        img.src = memberData.photo;
        img.style.cssText = `
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        `;
        photoDiv.appendChild(img);
    }
}

function updateBackCardPreview(memberData) {
    // Update contact number VALUE
    const contactEl = document.getElementById("card-contact");
    contactEl.innerText = memberData.contact || "";

    // Update QR code
    const qrDiv = document.getElementById("card-qr");
    qrDiv.innerHTML = "";
    qrDiv.style.cssText = `
        top: 52px !important;
        right: 25px !important;
        width: 119px !important;
        height: 138px !important;
        position: absolute !important;
        z-index: 3 !important;
    `;
    
    if (memberData.qrKey) {
        const qrImg = document.createElement("img");
        qrImg.src = `/qrcode/members/member-${memberData.qrKey}.png`;
        qrImg.style.cssText = `
            width: 100%;
            height: 100%;
            object-fit: contain;
        `;
        qrDiv.appendChild(qrImg);
    }
}

// ============================================================================
// UTILITY FUNCTIONS
// ============================================================================

/**
 * Load image asynchronously
 */
function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        try {
            let url;
            if (src.startsWith('http://') || src.startsWith('https://')) {
                url = new URL(src);
            } else {
                url = new URL(src, window.location.origin);
            }
            if (url.origin !== window.location.origin) {
                img.crossOrigin = "anonymous";
            }
        } catch (e) {
            console.warn('Could not parse image URL:', src, e);
        }
        img.onload = () => resolve(img);
        img.onerror = (error) => {
            console.error('Failed to load image:', src, error);
            reject(new Error(`Failed to load image: ${src}`));
        };
        img.src = src;
    });
}

/**
 * Wrap text to fit within specified width
 */
function wrapText(text, maxWidth, fontSize, fontFamily = 'Inter, Arial, sans-serif', fontWeight = 'normal') {
    // Create a temporary canvas to measure text
    const tempCanvas = document.createElement('canvas');
    const tempCtx = tempCanvas.getContext('2d');
    tempCtx.font = `${fontWeight} ${fontSize}px ${fontFamily}`;
    
    const words = text.split(' ');
    const lines = [];
    let currentLine = words[0] || '';

    for (let i = 1; i < words.length; i++) {
        const testLine = currentLine + ' ' + words[i];
        const metrics = tempCtx.measureText(testLine);
        
        if (metrics.width < maxWidth) {
            currentLine = testLine;
        } else {
            if (currentLine) lines.push(currentLine);
            currentLine = words[i];
        }
    }
    if (currentLine) lines.push(currentLine);
    
    return lines;
}

/**
 * Draw rounded rectangle clipping path
 */
function drawRoundedRectangles(ctx, width, height, radius) {
    ctx.beginPath();
    ctx.moveTo(radius, 0);
    ctx.lineTo(width - radius, 0);
    ctx.arcTo(width, 0, width, radius, radius);
    ctx.lineTo(width, height - radius);
    ctx.arcTo(width, height, width - radius, height, radius);
    ctx.lineTo(radius, height);
    ctx.arcTo(0, height, 0, height - radius, radius);
    ctx.lineTo(0, radius);
    ctx.arcTo(0, 0, radius, 0, radius);
    ctx.closePath();
    ctx.clip();
}

// ============================================================================
// CANVAS RENDERING - FRONT CARD
// ============================================================================

async function generateFrontCard(memberData) {
    const canvas = document.createElement('canvas');
    canvas.width = CARD_CONFIG.EXPORT_WIDTH;
    canvas.height = CARD_CONFIG.EXPORT_HEIGHT;
    
    const ctx = canvas.getContext('2d', { alpha: true });
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Scale context to work with logical coordinates
    const scaleX = CARD_CONFIG.EXPORT_WIDTH / CARD_CONFIG.LOGICAL_WIDTH;
    const scaleY = CARD_CONFIG.EXPORT_HEIGHT / CARD_CONFIG.LOGICAL_HEIGHT;
    ctx.scale(scaleX, scaleY);

    try {
        // Load and draw background
        const bgImg = await loadImage('/card_temp/card-1.png');
        
        // Draw rounded rectangle with clipping
        drawRoundedRectangles(ctx, CARD_CONFIG.LOGICAL_WIDTH, CARD_CONFIG.LOGICAL_HEIGHT, CARD_CONFIG.BORDER_RADIUS);
        ctx.drawImage(bgImg, 0, 0, CARD_CONFIG.LOGICAL_WIDTH, CARD_CONFIG.LOGICAL_HEIGHT);
        
        // Draw name
        ctx.fillStyle = CARD_CONFIG.FRONT.name.color;
        ctx.font = `${CARD_CONFIG.FRONT.name.fontWeight} ${CARD_CONFIG.FRONT.name.fontSize}px Inter, Arial, sans-serif`;
        ctx.textAlign = 'left';
        
        const nameLines = wrapText(memberData.fullName, CARD_CONFIG.FRONT.name.maxWidth, CARD_CONFIG.FRONT.name.fontSize);
        nameLines.forEach((line, index) => {
            ctx.fillText(line.toUpperCase(), CARD_CONFIG.FRONT.name.x, CARD_CONFIG.FRONT.name.y + (index * CARD_CONFIG.FRONT.name.lineHeight));
        });

        // Draw membership date
        ctx.fillStyle = CARD_CONFIG.FRONT.memberdate.color;
        ctx.font = `${CARD_CONFIG.FRONT.memberdate.fontWeight} ${CARD_CONFIG.FRONT.memberdate.fontSize}px Inter, Arial, sans-serif`;
        ctx.fillText(memberData.memberdate, CARD_CONFIG.FRONT.memberdate.x, CARD_CONFIG.FRONT.memberdate.y);

        // Draw address (value only - label is in template)
        ctx.fillStyle = CARD_CONFIG.FRONT.address.color;
        ctx.font = `${CARD_CONFIG.FRONT.address.fontWeight} ${CARD_CONFIG.FRONT.address.fontSize}px Inter, Arial, sans-serif`;
        const addressLines = wrapText(memberData.address, CARD_CONFIG.FRONT.address.maxWidth, CARD_CONFIG.FRONT.address.fontSize);
        addressLines.forEach((line, index) => {
            ctx.fillText(line, CARD_CONFIG.FRONT.address.x, CARD_CONFIG.FRONT.address.y + (index * CARD_CONFIG.FRONT.address.lineHeight));
        });

        // Draw photo
        if (memberData.photo) {
            const photoSrc = String(memberData.photo).startsWith('http://') || String(memberData.photo).startsWith('https://')
                ? memberData.photo
                : `/resource/member_images/${memberData.photo}`;
            const photoImg = await loadImage(photoSrc);
            ctx.save();
            ctx.beginPath();
            ctx.rect(CARD_CONFIG.FRONT.photo.x, CARD_CONFIG.FRONT.photo.y, CARD_CONFIG.FRONT.photo.size, CARD_CONFIG.FRONT.photo.size);
            ctx.clip();
            ctx.drawImage(photoImg, CARD_CONFIG.FRONT.photo.x, CARD_CONFIG.FRONT.photo.y, CARD_CONFIG.FRONT.photo.size, CARD_CONFIG.FRONT.photo.size);
            ctx.restore();
        }

        return canvas;
    } catch (error) {
        console.error('Error generating front card:', error);
        throw error;
    }
}

// ============================================================================
// CANVAS RENDERING - BACK CARD
// ============================================================================

async function generateBackCard(memberData) {
    const canvas = document.createElement('canvas');
    canvas.width = CARD_CONFIG.EXPORT_WIDTH;
    canvas.height = CARD_CONFIG.EXPORT_HEIGHT;
    
    const ctx = canvas.getContext('2d', { alpha: true });
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Scale context to work with logical coordinates
    const scaleX = CARD_CONFIG.EXPORT_WIDTH / CARD_CONFIG.LOGICAL_WIDTH;
    const scaleY = CARD_CONFIG.EXPORT_HEIGHT / CARD_CONFIG.LOGICAL_HEIGHT;
    ctx.scale(scaleX, scaleY);

    try {
        // Load and draw background
        const bgImg = await loadImage('/card_temp/card-2.png');
        
        // Draw rounded rectangle with clipping
        drawRoundedRectangles(ctx, CARD_CONFIG.LOGICAL_WIDTH, CARD_CONFIG.LOGICAL_HEIGHT, CARD_CONFIG.BORDER_RADIUS);
        ctx.drawImage(bgImg, 0, 0, CARD_CONFIG.LOGICAL_WIDTH, CARD_CONFIG.LOGICAL_HEIGHT);
        
        // Draw contact number VALUE (template has "Contact Number:" label)
        ctx.fillStyle = CARD_CONFIG.BACK.contactNumber.color;
        ctx.font = `${CARD_CONFIG.BACK.contactNumber.fontWeight} ${CARD_CONFIG.BACK.contactNumber.fontSize}px Inter, Arial, sans-serif`;
        ctx.textAlign = 'left';
        ctx.fillText(memberData.contact || '', CARD_CONFIG.BACK.contactNumber.x, CARD_CONFIG.BACK.contactNumber.y);

        // Draw QR code
        if (memberData.qrKey) {
            try {
                const qrImg = await loadImage(`/qrcode/members/member-${memberData.qrKey}.png`);
                ctx.drawImage(qrImg, CARD_CONFIG.BACK.qr.x, CARD_CONFIG.BACK.qr.y, CARD_CONFIG.BACK.qr.width, CARD_CONFIG.BACK.qr.height);
            } catch (qrError) {
                console.warn('Could not load QR code:', qrError);
            }
        }

        return canvas;
    } catch (error) {
        console.error('Error generating back card:', error);
        throw error;
    }
}

// ============================================================================
// DOWNLOAD FUNCTIONALITY
// ============================================================================

async function downloadCard() {
    try {
        const downloadBtn = event.target;
        const originalText = downloadBtn.innerHTML;
        downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing...';
        downloadBtn.disabled = true;

        const memberData = window.currentMemberData;
        if (!memberData) {
            throw new Error("Member data not found");
        }

        // Generate both cards
        const frontCanvas = await generateFrontCard(memberData);
        const backCanvas = await generateBackCard(memberData);

        // Create ZIP file
        const zip = new JSZip();

        // Add front card
        const frontDataURL = frontCanvas.toDataURL("image/png", 1.0);
        zip.file("membership-card-front.png", frontDataURL.split(',')[1], { base64: true });

        // Add back card
        const backDataURL = backCanvas.toDataURL("image/png", 1.0);
        zip.file("membership-card-back.png", backDataURL.split(',')[1], { base64: true });

        // Generate and download ZIP
        const zipBlob = await zip.generateAsync({ type: "blob" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(zipBlob);
        const memberName = memberData.fullName.replace(/[^a-z0-9]/gi, '_').toLowerCase();
        link.download = `membership-card-${memberName}.zip`;
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);

        // Restore button
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;
        alert("✅ Membership cards downloaded successfully!");

    } catch (error) {
        console.error("Download error:", error);
        alert("❌ Error creating download: " + error.message);

        const downloadBtn = event.target;
        downloadBtn.innerHTML = '<i class="fas fa-download"></i> Download Cards (ZIP)';
        downloadBtn.disabled = false;
    }
}

// ============================================================================
// MODAL MANAGEMENT
// ============================================================================

function closeCardModal() {
    const modal = document.getElementById("cardModal");
    modal.classList.remove("show");
    modal.style.display = "none";
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById("cardModal");
    if (e.target === modal && modal.classList.contains("show")) {
        closeCardModal();
    }
});
