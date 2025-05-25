<?php
require_once('../vendor/fpdf/fpdf.php'); // Adjust the path to where you placed fpdf.php
include('../../config/connection.php'); // Ensure this path is correct

// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Add a title
$pdf->Cell(0, 10, 'Product List', 0, 1, 'C');
$pdf->Ln(10);

// Add table headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(80, 10, 'Name', 1);
$pdf->Cell(40, 10, 'Price', 1);
$pdf->Cell(30, 10, 'Stock', 1);
$pdf->Ln();

// Fetch product data
$result = $conn->query("SELECT id, name, price, stock FROM products");
if ($result && $result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(20, 10, $row['id'], 1);
        $pdf->Cell(80, 10, $row['name'], 1);
        $pdf->Cell(40, 10, number_format($row['price'], 2), 1);
        $pdf->Cell(30, 10, $row['stock'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No products found', 1, 1, 'C');
}

// Output the PDF
$pdf->Output('D', 'product_list.pdf');
?>