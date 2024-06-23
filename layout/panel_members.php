<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="ml-64">
        <div class="container mt-5">
            <h1 class="mb-4 font-bold text-2xl">Manage Members</h1>
            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addMemberModal">Add Member</button>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../config.php';

                    // Mengambil data anggota dari tabel members
                    $query = "SELECT * FROM members";
                    $result = mysqli_query($conn, $query);
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["username"] . "</td>
                                <td>" . $row["password"] . "</td>
                                <td>" . $row["name"] . "</td>
                                <td>
                                    <a href='#' class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#editMemberModal'
                                        data-id='" . $row["id"] . "'
                                        data-username='" . htmlspecialchars($row["username"]) . "'
                                        data-password='" . htmlspecialchars($row["password"]) . "'
                                        data-name='" . htmlspecialchars($row["name"]) . "'
                                    >Edit</a>
                                    <a href='../controller/delete_member.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this member?\");'>Delete</a>
                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk menambahkan anggota baru -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addMemberForm" action="../controller/add_member.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit anggota -->
    <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editMemberForm" action="../controller/edit_member.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_username">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_password">Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Member</button>
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
                $('#edit_username').val($(this).data('username'));
                $('#edit_password').val($(this).data('password'));
                $('#edit_name').val($(this).data('name'));
            });

            // Reset formulir edit setelah modal ditutup
            $('#editMemberModal').on('hidden.bs.modal', function() {
                $('#editMemberForm')[0].reset();
            });
        });
    </script>

</body>

</html>