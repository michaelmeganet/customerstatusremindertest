<?php
session_start();
if ($_POST){
    $tempName = $_POST['tempName'];
    #$_SESSION['tempname'] = $tempName;
}
require 'vendor/autoload.php'; //required, this is to autoload composer.
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
ob_start();
require('./formReport.php');
$dompdf->set_option('isHtml5ParserEnabled', true);
$html = ob_get_contents();
ob_get_clean();
#$html = file_get_contents("./formReport.php");
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("download1",array('Attachment' => 0));


/*
#include "./assets/phpwkhtmltopdf/src/Pdf.php";
use assets\phpwkhtmltopdf\src\Pdf;

// Create a new Pdf object with some global PDF options
$pdf = new Pdf(array(
    'no-outline',         // Make Chrome not complain
    'margin-top'    => 0,
    'margin-right'  => 0,
    'margin-bottom' => 0,
    'margin-left'   => 0,

    // Default page options
    'disable-smart-shrinking',
    'user-style-sheet' => '/path/to/pdf.css',
));

// Add a page. To override above page defaults, you could add
// another $options array as second argument.
$pdf->addPage('http://www.google.com');

if (!$pdf->send()) {
    $error = $pdf->getError();
    // ... handle error here
}
 * 
 */
?>
