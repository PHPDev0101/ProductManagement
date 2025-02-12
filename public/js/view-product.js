document.addEventListener("DOMContentLoaded", async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get("id");

    if (!productId) {
        showAlert("No product ID provided!", "alert-error");
        setTimeout(() => window.location.href = "list-products.html", 2000);
        return;
    }

    function showAlert(message, type) {
        const alertBox = document.createElement("div");
        alertBox.className = `alert ${type}`;
        alertBox.textContent = message;
        document.body.prepend(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }

    async function fetchProductDetails() {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`);
            const product = await response.json();

            if (response.ok) {
                populateForm(product.data);
            } else {
                showAlert(product.message, "alert-error");
                setTimeout(() => window.location.href = "list-products.html", 2000);
            }
        } catch (error) {
            showAlert("An error occurred while fetching the product details.", "alert-error");
        }
    }

    function populateForm(product) {
        document.getElementById("name").value = product.name;
        document.getElementById("description").value = product.description;
        document.getElementById("price").value = product.price;
    }

    async function updateProduct(event) {
        event.preventDefault();

        const updatedProduct = {
            name: document.getElementById("name").value,
            description: document.getElementById("description").value,
            price: parseFloat(document.getElementById("price").value)
        };

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(updatedProduct)
            });
			
			const result = await response.json();
			
            if (response.ok) {
                showAlert(result.message, "alert-success");
            } else {
                if (result.errors) {
                    const value = Object.values(result.errors);
                    showAlert(result.message + ': ' + value, "alert-error");
                } else {
                    showAlert(result.message, "alert-error");
                }
            }
        } catch (error) {
            showAlert("An error occurred while updating the product.", "alert-error");
        }
    }

    async function deleteProduct() {
        if (!confirm("Are you sure you want to delete this product?")) return;

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                method: "DELETE",
                headers: { "Content-Type": "application/json" }
            });

            if (response.ok || response.status === 204) {
                showAlert('Product deleted successfully.', "alert-success");
                setTimeout(() => window.location.href = "list-products.html", 2000);
            } else if (response.status === 404) {
                showAlert('The product has already been deleted or does not exist.', "alert-error");
            } else {
                showAlert('Failed to delete', "alert-error");
            }
        } catch (error) {
            showAlert("An error occurred while deleting the product.", "alert-error");
        }
    }

    document.getElementById("view-product-form").addEventListener("submit", updateProduct);
    document.getElementById("delete-button").addEventListener("click", deleteProduct);

    fetchProductDetails();
});
