<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="ml-64">
        <div class="container mt-5">
            <h1 class="mb-4 font-bold text-2xl">Manage Books</h1>
            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addBookModal">Add Book</button>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Year</th>
                        <th>Author</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection parameters
                    include '../config.php';
                    // Query to get books
                    $sql = "SELECT id, title, description, image, year, author, rating FROM books";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["title"] . "</td>
                                <td>" . $row["description"] . "</td>
                                <td><img src='uploads/" . $row["image"] . "' alt='Book Image' width='100'></td>
                                <td>" . $row["year"] . "</td>
                                <td>" . $row["author"] . "</td>
                                <td>" . $row["rating"] . "</td>
                                <td>
                                    <a href='#' class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#editBookModal'
                                        data-id='" . $row["id"] . "'
                                        data-title='" . htmlspecialchars($row["title"]) . "'
                                        data-description='" . htmlspecialchars($row["description"]) . "'
                                        data-image='" . $row["image"] . "'
                                        data-year='" . $row["year"] . "'
                                        data-author='" . htmlspecialchars($row["author"]) . "'
                                        data-rating='" . $row["rating"] . "'
                                    >Edit</a>
                                    <a href='../controller/delete_book.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this book?\");'>Delete</a>
                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk menambahkan buku baru -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addBookForm" action="../controller/add_book.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" class="form-control" id="year" name="year" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <input type="number" step="0.1" class="form-control" id="rating" name="rating" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit buku -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBookForm" action="../controller/edit_book.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <input type="hidden" id="edit_existing_image" name="existing_image">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <input type="text" class="form-control" id="edit_description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                            <img src="" id="edit_image_preview" alt="Book Image" width="100">
                        </div>
                        <div class="form-group">
                            <label for="edit_year">Year</label>
                            <input type="number" class="form-control" id="edit_year" name="year" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_author">Author</label>
                            <input type="text" class="form-control" id="edit_author" name="author" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_rating">Rating</label>
                            <input type="number" step="0.1" class="form-control" id="edit_rating" name="rating" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mengatur nilai formulir edit ketika tombol Edit diklik
            $('.edit-btn').click(function() {
                $('#edit_id').val($(this).data('id'));
                $('#edit_title').val($(this).data('title'));
                $('#edit_description').val($(this).data('description'));
                $('#edit_image_preview').attr('src', 'uploads/' +
                    $(this).data('image'));
                $('#edit_existing_image').val($(this).data('image'));
                $('#edit_year').val($(this).data('year'));
                $('#edit_author').val($(this).data('author'));
                $('#edit_rating').val($(this).data('rating'));
            });

            // Reset formulir edit setelah modal ditutup
            $('#editBookModal').on('hidden.bs.modal', function() {
                $('#editBookForm')[0].reset();
                $('#edit_image_preview').attr('src', ''); // Hapus preview gambar
            });
        });
    </script>

</body>

</html>