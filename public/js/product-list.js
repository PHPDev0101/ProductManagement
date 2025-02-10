document.addEventListener("DOMContentLoaded", function () {
	const productTableBody = document.getElementById("productTableBody");

	const paginationControls = document.getElementById("paginationControls");
    let currentPage = 1;

    function fetchProducts(page = 1) {
        fetch(`http://127.0.0.1:8000/api/products?page=${page}`)
            .then(response => response.json())
            .then(data => {
                productTableBody.innerHTML = "";
                data.data.data.forEach(product => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${product.name}</td>
                        <td>${product.description}</td>
    					<td>${product.price}</td>
                        <td>
                            <a href="view-product.html?id=${product.id}" class="btn">View</a>
                            <button class="btn-delete" data-id="${product.id}">Delete</button>
                        </td>`;
                    productTableBody.appendChild(row);
                });
                setupPagination(data);
            })
            .catch(error => console.error("Error fetching products:", error));
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

    productTableBody.addEventListener("click", function (event) {
        if (event.target.classList.contains("btn-delete")) {
            const productId = event.target.getAttribute("data-id");
            if (confirm("Are you sure you want to delete this product?")) {
                fetch(`http://127.0.0.1:8000/api/products/${productId}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => {
          			if (!response.ok) {
                        throw new Error("Failed to delete product");
                    }
                    return response.json();
                })
             	.then(() => {
                    fetchProducts(currentPage);
                })
                .catch(error => console.error("Error deleting product:", error));
            }
        }

});

    fetchProducts();
});
