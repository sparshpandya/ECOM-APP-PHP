<?php
session_start();
$_SESSION['userInfo'] ? "Welcome {$_SESSION['userInfo']}!" : header("Location: login.php");

// Include the PDFInvoice class
require_once './class/PDFInvoice.php';

// Generate PDF Invoice
$pdf = new PDFInvoice();
$pdf->AddPage();
$pdf->AddInvoiceDetails($_SESSION['fullName'], $_SESSION['email_id'], $_SESSION['billing_address'], $_SESSION['cartItems']);

// Ensure the 'user invoices' directory exists
$invoiceDir = 'user invoices';
if (!is_dir($invoiceDir)) {
    mkdir($invoiceDir, 0777, true);
}

$pdfOutput = $invoiceDir . '/invoice_' . time() . '.pdf';
$pdf->Output('F', $pdfOutput);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Office Decor</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Thank You for Your Order!</h1>
        <p class="text-center">Your order has been successfully placed.</p>
        <div class="text-center">
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
            <a href="<?php echo $pdfOutput; ?>" target="_blank" class="btn btn-secondary">Your Invoice</a>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>
</body>
</html>
