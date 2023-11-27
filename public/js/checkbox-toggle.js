document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.form-check-input');

    toggleButton.addEventListener('click', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = !checkbox.checked; // Toggle the checkbox state
        });
    });
});
