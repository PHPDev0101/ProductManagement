document.addEventListener('DOMContentLoaded', async function() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    if (!productId) {
        alert('No product ID provided!');
        window.location.href = 'product-list.html'; // Redirect back to product list
        return;
    }

    async function fetchProductDetails(id) {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products/${id}`);
            const product = await response.json();

            if (response.ok) {
                populateForm(product);
            } else {
                console.error('Failed to fetch product:', product);
                alert('Error retrieving product details.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the product details.');
        }
    }

    function populateForm(product) {
        document.getElementById('name').value = product.name;
        document.getElementById('description').value = product.description;
        document.getElementById('price').value = product.price;
    }

    async function updateProduct(event) {
        event.preventDefault(); // Prevent form submission reload

        const updatedProduct = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            price: parseFloat(document.getElementById('price').value)
        };

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedProduct)
            });

            const result = await response.json();

            if (response.ok) {
                alert('Product updated successfully!');
                window.location.href = 'product-list.html'; // Redirect after update
            } else {
                console.error('Update failed:', result);
                alert('Failed to update product.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating the product.');
        }
    }

    async function deleteProduct() {
        if (!confirm('Are you sure you want to delete this product?')) return;

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                alert('Product deleted successfully!');
                window.location.href = 'product-list.html'; // Redirect after deletion
            } else {
                const errorData = await response.json();
                console.error('Delete failed:', errorData);
                alert('Failed to delete product.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the product.');
        }
    }

    document.getElementById('view-product-form').addEventListener('submit', updateProduct);
    document.getElementById('delete-button').addEventListener('click', deleteProduct);

    fetchProductDetails(productId);
});

