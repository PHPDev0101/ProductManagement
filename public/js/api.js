const apiUrl = 'http://127.0.0.1:8000/api/products'; // Replace with your API URL

// Create a product
async function createProduct(productData) {
    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(productData)
        });
        const result = await response.json();
        console.log('Product created:', result);
        alert('Product created successfully!');
        window.location.href = 'product-list.html';
    } catch (error) {
        console.error('Error creating product:', error);
    }
}

// Fetch all products
async function getProducts() {
    try {
        const response = await fetch(apiUrl);
        const products = await response.json();
        displayProducts(products);
    } catch (error) {
        console.error('Error fetching products:', error);
    }
}

// Display all products in the table
function displayProducts(products) {
    const tableBody = document.querySelector('#product-table tbody');
    tableBody.innerHTML = ''; // Clear any existing rows
    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name}</td>
            <td>${product.description}</td>
            <td>${product.price}</td>
            <td><a href="view-product.html?id=${product.id}">View</a></td>
        `;
        tableBody.appendChild(row);
    });
}

// Fetch single product by ID
async function getProductById(id) {
    try {
        const response = await fetch(`${apiUrl}/${id}`);
        const product = await response.json();
        populateProductForm(product);
    } catch (error) {
        console.error('Error fetching product:', error);
    }
}

// Populate the product form with fetched data
function populateProductForm(product) {
    document.getElementById('name').value = product.name;
    document.getElementById('description').value = product.description;
    document.getElementById('price').value = product.price;
}
