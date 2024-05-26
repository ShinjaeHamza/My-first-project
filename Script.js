// Get reference to the select element
const sortSelect = document.getElementById('sort');
// Get reference to the container of product items
const productsContainer = document.querySelector('.products');

// Add event listener to the select element for sorting
sortSelect.addEventListener('change', () => {
    // Get the selected sorting option
    const sortBy = sortSelect.value;

    // Get all product items
    const products = Array.from(productsContainer.children);

    // Sort the product items based on the selected option
    if (sortBy === 'name') {
        products.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
    } else if (sortBy === 'price') {
        products.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
    }

    // Clear the products container
    productsContainer.innerHTML = '';

    // Append the sorted product items back to the container
    products.forEach(product => productsContainer.appendChild(product));
});

// Get reference to the filter checkboxes
const categoryCheckboxes = document.querySelectorAll('input[name="category"]');

// Add event listener to each checkbox
categoryCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        // Get the selected categories
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Get all product items
        const products = Array.from(document.querySelectorAll('.product'));

        // Show or hide product items based on selected categories
        products.forEach(product => {
            const productCategory = product.dataset.category;
            if (selectedCategories.length === 0 || selectedCategories.includes(productCategory)) {
                product.style.display = 'block'; // Show product
            } else {
                product.style.display = 'none'; // Hide product
            }
        });
    });
});
