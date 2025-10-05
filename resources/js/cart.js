function updateQuantity(id, quantity) {
    if (quantity < 1) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/cart/update/${id}`,
    {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            response.json().then(data => {
                const errorContainer = document.getElementById('cart-error-container');
                const errorMessage = document.getElementById('cart-error-message');
                if (errorContainer && errorMessage && data.message) {
                    errorMessage.textContent = data.message;
                    errorContainer.classList.remove('hidden');
                    setTimeout(() => {
                        errorContainer.classList.add('hidden');
                    }, 5000);
                } else {
                    alert('An unexpected error occurred. Please try again.');
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred. Please try again.');
    });
}

window.updateQuantity = updateQuantity;
