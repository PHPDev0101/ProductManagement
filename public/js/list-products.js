document.addEventListener("DOMContentLoaded", function () {
    const productTableBody = document.getElementById("productTableBody");
    const paginationControls = document.getElementById("paginationControls");
    let currentPage = 1;

    function showAlert(message, type) {
        const alertBox = document.createElement("div");
        alertBox.className = `alert ${type}`;
        alertBox.textContent = message;
        document.body.prepend(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }

    async function fetchProducts(page = 1) {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products?page=${page}`);
            const data = await response.json();

            productTableBody.innerHTML = "";
            data.data.data.forEach(product => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${product.name}</td>
                    <td>${product.description}</td>
                    <td>${product.price}</td>
                    <td class="back-button-container">
                        <a href="view-product.html?id=${product.id}" class="button-link">View</a>
                        <button class="btn-delete" data-id="${product.id}">Delete</button>
                    </td>`;
                productTableBody.appendChild(row);
            });
            setupPagination(data);
        } catch (error) {
            showAlert("Error fetching products.", "alert-error");
        }
    }

    function setupPagination(data) {
        paginationControls.innerHTML = "";
        if (data.data.prev_page_url) {
            const prevButton = document.createElement("button");
            prevButton.innerText = "Previous";
            prevButton.addEventListener("click", () => fetchProducts(data.data.current_page - 1));
            paginationControls.appendChild(prevButton);
        }
        if (data.data.next_page_url) {
            const nextButton = document.createElement("button");
            nextButton.innerText = "Next";
            nextButton.addEventListener("click", () => fetchProducts(data.data.current_page + 1));
            paginationControls.appendChild(nextButton);
        }
    }

    productTableBody.addEventListener("click", async function (event) {
        if (event.target.classList.contains("btn-delete")) {
            const productId = event.target.getAttribute("data-id");
            if (confirm("Are you sure you want to delete this product?")) {
                try {
                    const response = await fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json" }
                    });

					const result = await response.json();
					
                    if (response.ok) {
                        showAlert(result.message || "Product deleted successfully!", "alert-success");
                        fetchProducts(currentPage);
                    } else {
                        showAlert(result.message || "Failed to delete product.", "alert-error");
                    }
                } catch (error) {
                    showAlert("An error occurred while deleting the product.", "alert-error");
                }
            }
        }
    });

    fetchProducts();
});
