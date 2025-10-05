let searchTimeout;
function debounce(form, delay = 200) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        form.submit();
    }, delay);
}

document.addEventListener('DOMContentLoaded', function () {
    // Edit Customer
    document.querySelectorAll('.edit-customer').forEach(button => {
        button.addEventListener('click', function () {
            const customerId = this.dataset.id;
            fetch(`/api/customers/${customerId}`) // Assuming /api/users/{id} endpoint for customer details
                .then(response => response.json())
                .then(customer => {
                    const form = document.getElementById('edit-customer-form');
                    form.action = `/admin/customers/${customerId}`; // Assuming /admin/customers/{id} for update
                    document.getElementById('edit_customer_name').value = customer.name;
                    document.getElementById('edit_customer_email').value = customer.email;
                    document.getElementById('edit_customer_role').value = customer.role;

                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-customer-modal' }));
                });
        });
    });

    // Delete Customer
    document.querySelectorAll('.delete-customer').forEach(button => {
        button.addEventListener('click', function () {
            const customerId = this.dataset.id;
            const form = document.getElementById('delete-customer-form');
            form.action = `/admin/customers/${customerId}`; // Assuming /admin/customers/{id} for delete
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-customer-modal' }));
        });
    });
});