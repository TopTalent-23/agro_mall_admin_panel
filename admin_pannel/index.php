<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Admin Login</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if there is a login error notification in the session
                        if (isset($_SESSION['login_error'])) {
                            // Display SweetAlert modal
                            echo "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Login Error',
                                        text: '{$_SESSION['login_error']}',
                                    });
                                  </script>";
                            unset($_SESSION['login_error']);
                        }
                        ?>
                        
                        <form action="partials/admin_login_process.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
