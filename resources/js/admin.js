// Notification handler
Livewire.on('notify', ({ type, message }) => {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: type === 'success' ? '#10B981' : '#EF4444',
        stopOnFocus: true,
    }).showToast();
});

// Confirm dialog handler
window.confirmAction = (message, callback, params = null) => {
    Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1a3a8f',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, proceed!'
    }).then((result) => {
        if (result.isConfirmed) {
            callback(params);
        }
    });
};