<?php
require('./fpdf186/fpdf.php');

class PDFInvoice extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Awesome Smartshop - Invoice', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Invoice details
    function AddInvoiceDetails($userName, $userEmail, $billingAddress, $cartItems)
    {
        $this->SetFont('Arial', '', 12);
        
        $this->Cell(0, 10, "Customer Name: $userName", 0, 1);
        $this->Cell(0, 10, "Email: $userEmail", 0, 1);
        $this->Cell(0, 10, "Billing Address: $billingAddress", 0, 1);
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 10, 'Product', 1);
        $this->Cell(30, 10, 'Quantity', 1);
        $this->Cell(30, 10, 'Price', 1);
        $this->Cell(30, 10, 'Total', 1);
        $this->Ln();

        $this->SetFont('Arial', '', 12);
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $this->Cell(100, 10, $item['name'], 1);
            $this->Cell(30, 10, $item['quantity'], 1);
            $this->Cell(30, 10, "$" . number_format($item['price'], 2), 1);
            $itemTotal = $item['quantity'] * $item['price'];
            $totalPrice += $itemTotal;
            $this->Cell(30, 10, "$" . number_format($itemTotal, 2), 1);
            $this->Ln();
        }

        $this->Ln(10);
        $this->Cell(0, 10, "Total: $" . number_format($totalPrice, 2), 0, 1, 'R');
    }
}
?>
