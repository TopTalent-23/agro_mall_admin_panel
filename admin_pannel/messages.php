<?php
session_start();
if (!isset($_SESSION['admin_logedin']) || !$_SESSION['admin_logedin']) {
    header("Location: partials/admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messages</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php
include("../db_config.php");
include("navbar.php");

$i = 0;

// Set the number of messages per page
$messagesPerPage = 10;

// Get the current page number from the URL
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting message index for the current page
$start = ($page - 1) * $messagesPerPage;

// Fetch the total number of messages
$totalMessages = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `messages1`"));

// Calculate the total number of pages
$totalPages = ceil($totalMessages / $messagesPerPage);
$show = "SELECT * FROM `messages1` ORDER BY `timestamp` DESC LIMIT $start, $messagesPerPage";

$result = mysqli_query($conn, $show);
$num = mysqli_num_rows($result);
?>

<section class="veg_section layout_paddingn mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-left">Messages</h2>
    </div>

    <?php
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Sr.no</th><th>Message ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Timestamp</th><th>Address</th></tr></thead>';
    echo '<tbody id="orders-table-body">';

    while ($row = $result->fetch_assoc()) {
        $i++;
        echo '<tr>';
        echo '<td style="width: 50px;">' . $i . '</td>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td><a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a></td>';
        echo '<td><a href="mailto:' . $row['email'] . '">' . $row['email'] . '</a></td>';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td><a class="btn btn-success" data-bs-toggle="collapse" href="#collapseExample' . $i . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $i . '">
        View Message
      </a></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="7" class="p-0">
            <div class="collapse" id="collapseExample' . $i . '">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-5"><strong>Message</strong></div>
                        <div class="col-md-1"><strong>:</strong></div>
                        <div class="col-md-6">' . $row['message'] . '</div>
                    </div>
                </div>
            </div>
        </td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    ?>

    <section class="veg_section layout_paddingn mt-4">
        <!-- Pagination links -->
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </section>

</section>

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
        $("#sidebarCollapse").on("click", function () {
            $("#sidebar").toggleClass("active");
            $("#content").toggleClass("active");
            $(".custom-navbar").toggleClass("active");
        });
    });
</script>

</body>
</html>
