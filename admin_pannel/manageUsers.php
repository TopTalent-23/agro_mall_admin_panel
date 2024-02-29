<?php
session_start();
if (!isset($_SESSION['admin_logedin']))  {
    // Display an alert using JavaScript
    echo "<script>alert('You do not have access to this page. Please go back.')</script>";
  
    // Redirect the user to the previous page
    echo "<script>window.history.back();</script>";
  
    // Exit the script to prevent further execution
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
include("../db_config.php");
include("navbar.php");
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3><strong>Manage Users</strong></h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
    </div>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <th>Created at</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch the categories from the database
        $show = "SELECT * FROM `admin_users`";
        $result = mysqli_query($conn, $show);
        $num = mysqli_num_rows($result);
        
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $phone = $row['phone'];
                $email = $row['email'];
                $username = $row['username'];
                $password = $row['password'];
                $role = $row['role'];
                $date = $row['created_at'];
                $id = $row['id'];
                $status = $row['status'];
               
        ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $phone; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $username; ?></td>
            <td><?php echo $role; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $status; ?></td>
            <td>
                <button class="btn  btn-info" data-bs-toggle="modal"
                        data-bs-target="#editUserModal<?php echo $username; ?>"><i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="btn  btn-danger delete-user"
                        data-id="<?php echo $id; ?>"><i class="fa-solid fa-trash"></i>  
                </button>
                <button class="btn <?php echo $status === 'blocked' ? 'btn-success unblock-user' : 'btn-warning block-user'; ?>"
                    data-id="<?php echo $id; ?>">
                <?php echo $status === 'blocked' ? 'Unblock' : 'Block'; ?>
            </button>
                
            </td>
        </tr>

      <div class="modal fade" id="editUserModal<?php echo $username; ?>" tabindex="-1" aria-labelledby="edituseryModalLabel<?php echo $username; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel<?php echo $username; ?>">Update user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm<?php echo $username; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" hidden id="id" name="id" value="<?php echo $id; ?>" required>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
                    </div>
                    <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
        <button type="button" class="btn btn-outline-secondary toggle-password">
            <i class="fa-regular fa-eye" id="eye-icon"></i>
        </button>
    </div>
</div>
                    <div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-control" id="role" name="role" required>
        <option value="admin" <?php echo ($role === 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="deliveryBoy" <?php echo ($role === 'deliveryBoy') ? 'selected' : ''; ?>>Delivery Boy</option>
        <option value="salesman" <?php echo ($role === 'salesman') ? 'selected' : ''; ?>>Salesman</option>
        <option value="manager" <?php echo ($role === 'manager') ? 'selected' : ''; ?>>Manager</option>
        <option value="executiveOfficer" <?php echo ($role === 'executiveOfficer') ? 'selected' : ''; ?>>Executive Officer</option>
    </select>
</div>

                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary editUserBtn" data-modalid="<?php echo $username; ?>">Update</button>
            </div>
        </div>
    </div>
</div>


        <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modals for editing and deleting categories -->
<!-- Replace these modals with your actual modals -->

<!-- Add New Category Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"  required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email"  required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"  required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password"  required>
                    </div>
                    <div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-control" id="role" name="role" required>
        <option value="admin" <?php echo ($role === 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="deliveryBoy" <?php echo ($role === 'deliveryBoy') ? 'selected' : ''; ?>>Delivery Boy</option>
        <option value="salesman" <?php echo ($role === 'salesman') ? 'selected' : ''; ?>>Salesman</option>
        <option value="manager" <?php echo ($role === 'manager') ? 'selected' : ''; ?>>Manager</option>
        <option value="executiveOfficer" <?php echo ($role === 'executiveOfficer') ? 'selected' : ''; ?>>Executive Officer</option>
    </select>
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addUserBtn">Add Category</button>
            </div>
        </div>
    </div>
</div>

<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script>
    
   $(document).ready(function () {

    
    $(".toggle-password").click(function () {
    // Store the reference to 'this'
    var toggleButton = $(this);

    // Prompt for admin password
    var adminPassword = prompt("Enter Admin Password:");

    // Check if admin password is entered
    if (adminPassword) {
        // Make an AJAX request to validate the admin password
        $.ajax({
            type: "POST",
            url: "security/validate_admin_password.php", // Replace with the actual path to your server-side validation script
            data: { adminPassword: adminPassword },
            success: function (response) {
                if (response === "valid") {
                    // Password is valid, toggle password visibility
                    var passwordInput = toggleButton.siblings('.form-control[type="password"]');
                    var eyeIcon = toggleButton.find('.fa-eye');

                    // Toggle between 'password' and 'text' types immediately
                    var newType = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                    passwordInput.attr('type', newType);

                    // Toggle eye icon classes
                    eyeIcon.toggleClass('fa-eye fa-eye-slash');
                } else {
                    alert("Incorrect Admin Password!");
                }
            },
            error: function () {
                alert("Error validating admin password.");
            }
        });
    }
});

 // Block User
 $(".block-user").click(function () {
        const userId = $(this).data("id");
        updateStatus(userId, 'blocked');
    });

    // Unblock User
    $(".unblock-user").click(function () {
        const userId = $(this).data("id");
        updateStatus(userId, 'unblocked');
    });

    function updateStatus(userId, newStatus) {
        // Prompt for admin password
        var adminPassword = prompt("Enter Admin Password:");

        // Check if admin password is entered
        if (adminPassword) {
            // Make an AJAX request to validate the admin password
            $.ajax({
                type: "POST",
                url: "security/validate_admin_password.php",
                data: { adminPassword: adminPassword },
                success: function (response) {
                    if (response === "valid") {
                        // Admin password is valid, proceed with updating the user status
                        $.ajax({
                            type: "POST",
                            url: "partials/update_user_status.php",
                            data: { userId: userId, newStatus: newStatus },
                            success: function (updateResponse) {
                                console.log(updateResponse);
                                if (updateResponse) {
                                    Swal.fire("Success", "User status updated successfully", "success").then(function () {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error", "An error occurred while updating the user status.", "error");
                                }
                            },
                            error: function () {
                                Swal.fire("Error", "An error occurred while updating the user status.", "error");
                            }
                        });
                    } else {
                        // Incorrect admin password
                        Swal.fire("Error", "Incorrect Admin Password!", "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Error validating admin password.", "error");
                }
            });
        }
    }




    $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
        $("#content").toggleClass("active");
        $(".custom-navbar").toggleClass("active");
    });

    $(".delete-user").click(function () {
    const userId = $(this).data("id");

    // Prompt for admin password
    var adminPassword = prompt("Enter Admin Password:");

    // Check if admin password is entered
    if (adminPassword) {
        // Make an AJAX request to validate the admin password
        $.ajax({
            type: "POST",
            url: "security/validate_admin_password.php", // Replace with the actual path to your server-side validation script
            data: { adminPassword: adminPassword },
            success: function (response) {
                if (response === "valid") {
                    // Admin password is valid, proceed with user deletion
                    $.ajax({
                        type: "POST",
                        url: "partials/delete_user.php",
                        data: { userId: userId },
                        success: function (deleteResponse) {
                            console.log(deleteResponse); // Log the response to the console
                            if (deleteResponse) {
                                Swal.fire("Deleted!", "The user has been deleted.", "success").then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire("Error", "An error occurred while deleting the user.", "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire("Error", "An error occurred while deleting the user: " + error, "error");
                        }
                    });
                } else {
                    // Incorrect admin password
                    Swal.fire("Error", "Incorrect Admin Password!", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Error validating admin password.", "error");
            }
        });
    }
});



    $(".editUserBtn").click(function () {
    var modalId = $(this).data("modalid");
    var modal = $("#editUserModal" + modalId);
    var form = modal.find("#editUserForm" + modalId);

    // Prompt for admin password
    var adminPassword = prompt("Enter Admin Password:");

    // Check if admin password is entered
    if (adminPassword) {
        // Make an AJAX request to validate the admin password
        $.ajax({
            type: "POST",
            url: "security/validate_admin_password.php", // Replace with the actual path to your server-side validation script
            data: { adminPassword: adminPassword },
            success: function (response) {
                if (response === "valid") {
                    // Password is valid, proceed with the user update
                    $.ajax({
                        type: "POST",
                        url: "partials/update_user.php",
                        data: new FormData(form[0]),
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response) {
                                modal.modal("hide");

                                // Update the user information within the specific modal
                                modal.find("#id").text(form.find("[id=id]").val());
                                modal.find("#name").text(form.find("[name=name]").val());
                                modal.find("#phone").text(form.find("[name=phone]").val());
                                modal.find("#email").text(form.find("[name=email]").val());
                                modal.find("#username").text(form.find("[name=username]").val());
                                modal.find("#password").text(form.find("[name=password]").val());
                                modal.find("#role").text(form.find("[name=role]").val());

                                Swal.fire("Success", "User updated successfully", "success").then(function () {
                                    location.reload(); // Reload the page
                                });
                            } else {
                                Swal.fire("Error", "An error occurred while updating the user.", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error", "An error occurred while updating the user.", "error");
                        }
                    });
                } else {
                    // Incorrect admin password
                    Swal.fire("Error", "Incorrect Admin Password!", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Error validating admin password.", "error");
            }
        });
    }
});


    // Add New Category
    $("#addUserBtn").click(function () {
    var modal = $("#addUserModal");
    var form = modal.find("#addUserForm");

    // Prompt for admin password
    var adminPassword = prompt("Enter Admin Password:");

    // Check if admin password is entered
    if (adminPassword) {
        // Make an AJAX request to validate the admin password
        $.ajax({
            type: "POST",
            url: "security/validate_admin_password.php", // Replace with the actual path to your server-side validation script
            data: { adminPassword: adminPassword },
            success: function (response) {
                if (response === "valid") {
                    // Admin password is valid, proceed with adding the user
                    $.ajax({
                        type: "POST",
                        url: "partials/add_user.php", // Replace with the actual path to your server-side add_user script
                        data: new FormData(form[0]),
                        processData: false,
                        contentType: false,
                        success: function (addUserResponse) {
                            console.log(addUserResponse); // Log the response to the console
                            if (addUserResponse) {
                                Swal.fire("Success", "User added successfully", "success").then(function () {
                                    location.reload(); // Reload the page
                                });
                            } else {
                                Swal.fire("Error", "An error occurred while adding the user.", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error", "An error occurred while adding the user.", "error");
                        }
                    });
                } else {
                    // Incorrect admin password
                    Swal.fire("Error", "Incorrect Admin Password!", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Error validating admin password.", "error");
            }
        });
    }
});

});

</script>
</body>
</html>
