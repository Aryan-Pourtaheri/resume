// Update the file input label with the selected file name
document.addEventListener('DOMContentLoaded', function () {
    const profileImageInput = document.getElementById('profile_image');
    profileImageInput.addEventListener('change', function () {
        const fileName = this.files[0]?.name || 'Choose file';
        const label = this.nextElementSibling;
        label.textContent = fileName;
    });
});