document.addEventListener('DOMContentLoaded', function() {
    // Example for form submission (Creating product)
    if (document.getElementById('create-product-form')) {
        document.getElementById('create-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const productData = {
                name: event.target.name.value,
                description: event.target.description.value,
                price: event.target.price.value
            };
            createProduct(productData);
        });
    }
});
