// Delete button confirmation
document.addEventListener("DOMContentLoaded", () => {
    const dialog = document.getElementById("confirmation-dialog");
    const cancelButton = document.getElementById("cancel-button");
    const confirmLink = document.getElementById("confirm-link");
    const deleteType = document.getElementById("delete-type");

    document.querySelectorAll(".delete-btn").forEach((button) => {
        button.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent default link behavior
            
            // Get the data attributes from the clicked button
            const type = button.dataset.type; // e.g., "post", "category", or "user"
            const deleteUrl = button.dataset.url; // The URL to proceed with deletion

            // Update the confirmation dialog dynamically
            deleteType.textContent = type;
            confirmLink.href = deleteUrl;

            // Show the dialog
            dialog.classList.remove("hidden");
        });
    });

    // Close the dialog when the "No" button is clicked
    cancelButton.addEventListener("click", () => {
        dialog.classList.add("hidden");
    });

    // Close the dialog when clicking outside of the dialog content
    window.addEventListener("click", (event) => {
        if (event.target === dialog) {
            dialog.classList.add("hidden");
        }
    });
});