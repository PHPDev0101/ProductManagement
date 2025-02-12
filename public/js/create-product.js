document.addEventListener("DOMContentLoaded", function () {
    const createProductForm = document.getElementById("create-product-form");

    createProductForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        const productData = {
            name: event.target.name.value,
            description: event.target.description.value,
            price: parseFloat(event.target.price.value)
        };

        try {
            const response = await fetch("http://127.0.0.1:8000/api/products", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(productData)
            });

            const result = await response.json();

            if (response.ok || response.status === 201) {
                showAlert(result.message, "alert-success");
                setTimeout(() => window.location.href = "list-products.html", 2000);
            } else {
                if (result.errors) {
                    const value = Object.values(result.errors);
                    showAlert(result.message + ': ' + value, "alert-error");
                } else {
                    showAlert(result.message, "alert-error");
                }
            }
        } catch (error) {
            showAlert("An error occurred while creating the product.", "alert-error");
        }
    });

    function showAlert(message, type) {
        const alertBox = document.createElement("div");
        alertBox.className = `alert ${type}`;
        alertBox.textContent = message;
        document.body.prepend(alertBox);
        setTimeout(() => alertBox.remove(), 2000);
    }
});
