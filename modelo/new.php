

<?php
// include autoloader
require_once 'C:\xampp\htdocs\protoassistance\dompdf\autoload.inc.php';

// instantiate and use the dompdf class
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();