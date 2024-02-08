<?php
require_once('tcpdf/tcpdf.php');

// Retrieve the order details
$orderID = $_GET['orderID'];
$name = $_GET['name'];
$phone = $_GET['phone'];
$email = $_GET['email'];
$quantity = $_GET['quantity'];
$address = $_GET['address'];
$pincode = $_GET['pincode'];
$pr_id = $_GET['pr_id'];
$product = $_GET['product_name'];
$price = $_GET['price'];
$date = $_GET['date'];
$payment_status = $_GET['payment_status'];
$payment_mode = $_GET['payment_mode'];
$payid = $_GET['payid'];

// Create a new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Agro Mall');
$pdf->SetTitle('Order Bill');
$pdf->SetSubject('Order Bill');
$pdf->SetKeywords('Order, Bill');

// Set default header and footer data
$pdf->SetHeaderData('logo.png', 10, $orderID, '', array(10, 10, 10), array(10, 10, 10));
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Set font for the company name
$pdf->SetFont('times', 'B', 24);
$pdf->Cell(0, 15, 'Agro Mall', 0, 1, 'C');

// Set font for the bill details
$pdf->SetFont('times', '', 12);
$pdf->Cell(0, 10, '', 0, 1); // Add space between company name and bill details

// Output the order details
$pdf->Cell(40, 10, 'Order ID:', 0, 0, 'B');
$pdf->Cell(40, 10, $orderID, 0, 1);
$pdf->Cell(40, 10, 'Payment ID:', 0, 0, 'B');
$pdf->Cell(40, 10, $payid, 0, 1);
$pdf->Cell(40, 10, 'Payment Status:', 0, 0, 'B');
$pdf->Cell(40, 10, $payment_status, 0, 1);
$pdf->Cell(40, 10, 'Payment Mode:', 0, 0, 'B');
$pdf->Cell(40, 10, $payment_mode, 0, 1);
$pdf->Cell(40, 10, 'Name:', 0, 0, 'B');
$pdf->Cell(40, 10, $name, 0, 1);
$pdf->Cell(40, 10, 'Phone:', 0, 0, 'B');
$pdf->Cell(40, 10, $phone, 0, 1);
$pdf->Cell(40, 10, 'Email:', 0, 0, 'B');
$pdf->Cell(40, 10, $email, 0, 1);

$pdf->Ln(10); // Add space between details

// Set font for the table headings
$pdf->SetFont('times', 'B', 12);

// Create table headers
$pdf->SetFillColor(240, 240, 240); // Set header background color
$pdf->SetTextColor(0); // Set text color
$pdf->Cell(50, 10, 'Product Name', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Price', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Quantity', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C', 1);

// Set font for the table content
$pdf->SetFont('times', '', 12);

// Calculate subtotal
$subtotal = $price * $quantity;

// Output the order item
$pdf->SetFillColor(255); // Set content background color
$pdf->Cell(50, 10, $product, 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Rs.'.$price.'/-', 1, 0, 'C', 1);
$pdf->Cell(30, 10, $quantity, 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Rs.'. $subtotal.'/-', 1, 1, 'C', 1);

$pdf->Ln(10); // Add space after the table

$pdf->Cell(40, 10, 'Address:', 0, 0, 'B');
$pdf->Cell(40, 10, $address, 0, 1);
$pdf->Cell(40, 10, 'Pincode:', 0, 0, 'B');
$pdf->Cell(40, 10, $pincode, 0, 1);
$pdf->Cell(40, 10, 'Product ID:', 0, 0, 'B');
$pdf->Cell(40, 10, $pr_id, 0, 1);
$pdf->Cell(40, 10, 'Date:', 0, 0, 'B');
$pdf->Cell(40, 10, $date, 0, 1);

// Set font for the company details
$pdf->SetFont('times', '', 10);
$pdf->Cell(0, 20, '', 0, 1); // Add space between bill details and company details
$pdf->Cell(0, 10, 'Company Address:', 0, 1);
$pdf->Cell(0, 10, 'Company GSTIN:', 0, 1);

// Output the "This is a computer-generated bill. No signature is required" line
$pdf->Ln(10);
$pdf->SetFont('times', 'I', 12);
$pdf->Cell(0, 10, 'This is a computer-generated bill. No signature is required.', 0, 1, 'C');

// Add CSS
$pdf->writeHTML('<style>table {width: 100%; border-collapse: collapse; margin-top: 10px;} th, td {border: 1px solid #000; padding: 8px; font-weight: bold;} .heading {font-size: 18px; font-weight: bold; margin-bottom: 10px;} </style>', true, false, false, false, '');

// Output the PDF as a file
$pdf->Output('order_bill.pdf', 'D');
?>
