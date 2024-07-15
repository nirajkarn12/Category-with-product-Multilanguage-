<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Categories and Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert 2 -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">DemoNav</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            @foreach($categories as $category)
                                <li class="dropdown-item d-flex justify-content-between align-items-center">
                                    <a href="#" data-category="{{ $category->id }}" class="category-link">{{ $category->name }}</a>
                                    <div>
                                        <button class="btn btn-primary btn-sm edit-category" data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">Edit</button>
                                        <button class="btn btn-danger btn-sm delete-category" data-category-id="{{ $category->id }}">Delete</button>
                                    </div>
                                </li>
                            @endforeach
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu" id="productsMenu" aria-labelledby="productDropdown">
                            <!-- Products loaded dynamically -->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal for adding a new category -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing a category -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId" name="categoryId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" name="categoryName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a.category-link').forEach(function (categoryLink) {
                categoryLink.addEventListener('click', function () {
                    const categoryId = this.getAttribute('data-category');
                    const productsMenu = document.getElementById('productsMenu');
                    productsMenu.innerHTML = '';

                    fetch(`/categories/${categoryId}/products`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(product => {
                                const productItem = document.createElement('li');
                                productItem.innerHTML = `<a class="dropdown-item" href="#">${product.name}</a>`;
                                productsMenu.appendChild(productItem);
                            });
                        });
                });
            });

            document.querySelectorAll('.delete-category').forEach(function (deleteButton) {
                deleteButton.addEventListener('click', function () {
                    const categoryId = this.getAttribute('data-category-id');

                    if (confirm('Are you sure you want to delete this category?')) {
                        axios.delete(`/categories/${categoryId}`)
                            .then(response => {
                                if (response.status === 200) {
                                    location.reload();
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting category:', error);
                            });
                    }
                });
            });

            document.querySelectorAll('.edit-category').forEach(function (editButton) {
                editButton.addEventListener('click', function () {
                    const categoryId = this.getAttribute('data-category-id');
                    const categoryName = this.getAttribute('data-category-name');

                    document.getElementById('editCategoryId').value = categoryId;
                    document.getElementById('editCategoryName').value = categoryName;

                    const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                    editModal.show();
                });
            });

            // Event listener for clicking "Add Category" link in dropdown menu
            document.querySelector('.dropdown-item[data-bs-toggle="modal"]').addEventListener('click', function () {
                const targetModal = this.getAttribute('data-bs-target');
                const modal = new bootstrap.Modal(document.querySelector(targetModal));
                modal.show();
            });

            // Event listener for handling form submission to add a new category
            const addCategoryForm = document.getElementById('addCategoryForm');
            addCategoryForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const categoryName = document.getElementById('categoryName').value;

                axios.post('/categories', {
                    name: categoryName
                })
                .then(response => {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Added Successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        addCategoryForm.reset(); // Reset form fields
                        setTimeout(() => {
                            location.reload(); // Reload the page
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error adding category:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.',
                    });
                });
            });

            // Event listener for handling form submission to edit a category
            const editCategoryForm = document.getElementById('editCategoryForm');
            editCategoryForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const categoryId = document.getElementById('editCategoryId').value;
                const categoryName = document.getElementById('editCategoryName').value;

                axios.put(`/categories/${categoryId}`, {
                    name: categoryName
                })
                .then(response => {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Updated Successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            location.reload(); // Reload the page
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error updating category:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.',
                    });
                });
            });
        });
    </script>
</body>
</html>
