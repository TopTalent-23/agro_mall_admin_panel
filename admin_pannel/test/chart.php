<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #chart-container {
            width: 80%;
            margin: auto;
        }
    </style>
</head>
<body>
    <div id="chart-container">
        <select id="chartTypeDropdown" onchange="updateChart()">
            <option value="pie">Pie Chart</option>
            <option value="line">Line Graph</option>
        </select>
        <select id="yearDropdown" onchange="updateChart()">
            <!-- Dynamically populated with years -->
        </select>
        <canvas id="myChart"></canvas>
    </div>

    <script>
        // Fetch years from the PHP file
        fetch('getData.php')
            .then(response => response.json())
            .then(data => {
                // Extract unique years from the retrieved data
                const years = [...new Set(data.map(item => item.year))];

                // Populate the year dropdown
                const yearDropdown = document.getElementById('yearDropdown');
                years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.text = year;
                    yearDropdown.add(option);
                });

                // Initial chart rendering
                updateChart();
            })
            .catch(error => console.error('Error fetching data:', error));

        // Function to update the chart based on the selected year and chart type
        function updateChart() {
            const selectedYear = document.getElementById("yearDropdown").value;
            const selectedChartType = document.getElementById("chartTypeDropdown").value;

            // Fetch data for the selected year
            fetch('getData.php')
                .then(response => response.json())
                .then(data => {
                    // Filter data for the selected year
                    const filteredData = data.filter(item => item.year === parseInt(selectedYear));

                    // Extract necessary information from the retrieved data
                    const labels = filteredData.map(item => item.year);
                    const values = filteredData.map(item => item.total_amount);

                    // Create a chart using the retrieved data
                    const ctx = document.getElementById("myChart").getContext("2d");

                    const myChart = new Chart(ctx, {
                        type: selectedChartType,
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Amount',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
</body>
</html>
