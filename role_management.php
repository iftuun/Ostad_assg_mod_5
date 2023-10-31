<?php
include 'settings.php';
include 'functions.php';


if ($_SESSION['loged_in'] != true) {
    header('Location: login.php');
}
$userData = $_SESSION['user'];
if ($userData['role'] != "admin") {
    header('Location: index.php');
}
$allUsers = getAllUser($file_path);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ostad Module 5</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="role_management.php">Role Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <!-- User Name on the Right -->
            <span class="navbar-text">
                <?php
            echo $_SESSION['user']['username'];
            ?>
            </span>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Role Management</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Role Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($allUsers as $user) {
                        if ($user['role'] != "admin") {
                            ?>
                    <tr>
                        <td>
                            <?= $user['username'] ?>
                        </td>
                        <td>
                            <?= $user['email'] ?>
                        </td>
                        <td>
                            <?= $user['role'] ?>
                        </td>
                        <td>
                            <?= $user['role'] == '' ? '<button class="btn btn-success btn-sm create-role-btn" data-user="'.$user['email'].'">Create</button>' : '' ?>
                            <?= $user['role'] != '' ? '<button data-user="' . $user['email'] . '" class="btn btn-warning btn-sm edit-role-btn">Edit Role</button>' : '' ?>
                            <?= $user['role'] != '' ? '<button data-user="' . $user['email'] . '" class="btn btn-danger btn-sm delete-role-btn">Delete Role</button>' : '' ?>
                        </td>
                    </tr>
                    <?php }
                    } ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="create-role-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="role_assign.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Role </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select name="role" class=" form-select" required>
                            <option>Select a Role</option>
                            <?= getRolesList() ?>
                        </select>
                    </div>
                    <input type="hidden" name="user" value="" id="role-add-user">

                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-role-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="role_assign.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title-edit-role">Edit Role </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select name="role" class=" form-select" required>
                            <option>Select a Role</option>
                            <?= getRolesList() ?>
                        </select>
                    </div>
                    <input type="hidden" name="user" value="" id="role-edit-user">
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="delete-role-model" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="role_assign.php" method="post">
                <input type="hidden" name="user" id="role-delete-user">
                <input type="hidden" name="role" value="">
                <div class=" modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user's role?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        $(document).on('click', '.create-role-btn', function() {
            $('#role-add-user').val($(this).data('user'));
            $('#create-role-model').modal('show');
        });
        $(document).on('click', '.edit-role-btn', function() {
            $('#role-edit-user').val($(this).data('user'));
            $('#edit-role-model').modal('show');
        });
        $(document).on('click', '.delete-role-btn', function() {
            $('#role-delete-user').val($(this).data('user'));
            $('#delete-role-model').modal('show');
        });

    });
    </script>
</body>

</html>