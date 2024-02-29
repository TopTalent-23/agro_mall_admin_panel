<?php
session_start();
if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin']) )  {
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
    <title>Expences</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php
include("../db_config.php");
include("navbar.php");
?>
<section>

        
<div class="container mt-4 text-center">
  <div class="row">
    <div class="col">
    <div class="mt-4 text-center">
    <h4>Expense Line Graph</h4>
    <label for="year">Select Year:</label>
    <select id="year" class="form-control">
        <!-- Add options dynamically using JavaScript for available years -->
    </select>

    <div class="m-auto" >
        <canvas id="expenseChart" style="max-width: 600px; max-height: 800px;"></canvas>
    </div>
</div>
    </div>
    <div class="col">
     
    <div class="mt-4">
    <h4>Add Expense</h4>
    <form id="addExpenseForm">
        <div class="form">
            <div class="form-group ">
                <label for="expenseDate">Date</label>
                <input type="date" class="form-control" id="expenseDate" required>
            </div>
            <div class="form-group">
                <label for="expenseAmount">Amount</label>
                <input type="number" class="form-control" id="expenseAmount" required>
            </div>
            <div class="form-group">
                <label for="expenseDescription">Description</label>
                <input type="text" class="form-control" id="expenseDescription" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Expense</button>
    </form>
</div>

    </div>
  </div>
  <div class="row">
    <div class="col">
     
<div class="mt-4">
    <h4>Expenses Table</h4>
    <table class="table table-bordered">
        <thead>
          
        </thead>
        <tbody id="expensesTableBody">
            <!-- Display expenses dynamically using JavaScript -->
        </tbody>
    </table>
</div>
    </div>
    
  </div>
</div>

       
 

   



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
        
// Call a function to populate the year dropdown with available years
populateYearDropdown();

// Fetch and display initial chart data
fetchChartData($('#year').val()); // Use the selected year from the dropdown as the default

// Add your other JavaScript functionalities here

// Function to populate the year dropdown
function populateYearDropdown() {
    var currentYear = new Date().getFullYear();
    for (var year = currentYear; year >= 2020; year--) {
        $('#year').append('<option value="' + year + '">' + year + '</option>');
    }

    // Add onchange event to the year dropdown
    $('#year').on('change', function () {
        console.log('Year changed:', $(this).val());
        var selectedYear = $(this).val();
        fetchChartData(selectedYear);
        fetchExpenses(selectedYear);
    });
}
function fetchChartData(selectedYear) {
    $.ajax({
        url: 'partials/fetch_expense_and_sales_data.php',
        type: 'GET',
        data: { selectedYear: selectedYear },
        dataType: 'json',
        success: function (response) {
            console.log('Fetched Expense and Sales Data:', response);
            updateChart(response);
        },
        error: function (error) {
            console.error('Error fetching expense and sales data:', error.responseText);
            Swal.fire('Error', 'Failed to fetch expense and sales data', 'error');
        }
    });

    // Fetch and display expenses for the selected year
    fetchExpenses(selectedYear);
}

    // Function to fetch and display expenses for the selected year
    function fetchExpenses(selectedYear) {
        $.ajax({
            url: 'partials/fetch_expenses.php',
            type: 'GET',
            data: { selectedYear: selectedYear },
            success: function (response) {
                // Update the expenses table with fetched data
                $('#expensesTableBody').html(response);
            },
            error: function (error) {
                console.error('Error fetching expenses:', error.responseText);
            }
        });
    }

// Function to update the chart with fetched data
function updateChart(data) {
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    // Extract expense and sales data from the fetched data
    var expenseData = data.expenses;
    var salesData = data.sales;

    // Map fetched data to match the expected structure
    var formattedExpenseData = months.map(function (month) {
        // Find the sum of expenses for each month
        var totalAmount = expenseData.reduce(function (accumulator, expense) {
            var expenseMonth = new Date(expense.date).toLocaleString('en-US', { month: 'long' });
            return expenseMonth === month ? accumulator + parseFloat(expense.amount) : accumulator;
        }, 0);

        return totalAmount; // Return numeric totalAmount for each month
    });

    var formattedSalesData = months.map(function (month) {
    // Find the sum of sales for each month
    var totalAmount = salesData.reduce(function (accumulator, sale) {
        var saleMonth = new Date(sale.date_time).getMonth(); // Extract month as a number (0-11)
        return saleMonth === months.indexOf(month) ? accumulator + parseFloat(sale.amount) : accumulator;
    }, 0);
   console.log(totalAmount);
    return totalAmount; // Return numeric totalAmount for each month
});

    // Get the canvas element
    var ctx = document.getElementById('expenseChart').getContext('2d');

    // Check if a chart instance already exists
    if (window.myLineChart) {
        // Destroy the existing chart instance
        window.myLineChart.destroy();
    }

    // Create a new chart instance
    var data = {
        labels: months,
        datasets: [{
            label: 'Monthly Expenses',
            data: formattedExpenseData,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Monthly Sales',
            data: formattedSalesData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    window.myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
}

        $('#addExpenseForm').submit(function (e) {
    e.preventDefault();

    var expenseDate = $('#expenseDate').val();
    var expenseAmount = $('#expenseAmount').val();
    var expenseDescription = $('#expenseDescription').val();

    // Perform AJAX request to add expense to the database
    $.ajax({
        url: 'partials/add_expense.php', // Change to your actual file
        type: 'POST',
        data: {
            date: expenseDate,
            amount: expenseAmount,
            description: expenseDescription
        },
        success: function (response) {
            // Handle success, e.g., show a success message
            console.log('Expense added successfully:', response);

            // Show success message using SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Expense Added',
                text: 'The expense has been added successfully.',
            });

            // Fetch and display updated chart and table data
            fetchChartData($('#year').val());
            fetchExpenses();
        },
        error: function (error) {
            // Handle error, e.g., show an error message
            console.error('Error adding expense:', error.responseText);

            // Show error message using SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding the expense. Please try again.',
            });
        }
    });
});


    // Fetch and display expenses on page load
    fetchExpenses();

    function fetchExpenses() {
        // Replace this with the logic to fetch expenses from your database
        $.ajax({
            url: 'partials/fetch_expenses.php', // Change to your actual file
            type: 'GET',
            success: function (response) {
                // Update the expenses table with fetched data
                $('#expensesTableBody').html(response);
            },
            error: function (error) {
                console.error('Error fetching expenses:', error.responseText);
            }
        });
    }
});
  
</script>

</body>
</html>
