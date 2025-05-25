function toggleCustomerFields(role) {
    const customerFields = document.getElementById('customer-fields');
    if (role === 'customer') {
        customerFields.style.display = 'block';
    } else {
        customerFields.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const role = document.getElementById('role').value;
    toggleCustomerFields(role);
});

document.addEventListener('DOMContentLoaded', function () {
    const profileImageInput = document.getElementById('profile_image');
    profileImageInput.addEventListener('change', function () {
        const fileName = this.files[0]?.name || 'Choose file';
        const label = this.nextElementSibling;
        label.textContent = fileName;
    });
});