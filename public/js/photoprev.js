// public/js/photoPreview.js

document.getElementById("photo").addEventListener("change", function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        const preview = document.getElementById("photoPreview");
        preview.src = e.target.result;
        preview.style.display = "block";
    };

    if (file) {
        reader.readAsDataURL(file);
    }
});