// Select the form element
const createProductForm = document.getElementById('create-product-form');

// Listen for form submission
createProductForm.addEventListener('submit', async function(event) {
    event.preventDefault();

    // Collect form data
    const productData = {
        name: event.target.name.value,
        description: event.target.description.value,
        price: parseFloat(event.target.price.value)
    };

    // Call the API to create the product
    try {
        const response = await fetch('http://127.0.0.1:8000/api/products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
        });

        const result = await response.json();

        if (response.ok) {
            console.log('Product created successfully:', result);
            alert('Product created successfully!');
            window.location.href = 'product-list.html';
        } else {
            console.error('Error creating product:', result);
            alert('Failed to create product. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating the product. Please try again.');
    }
});
