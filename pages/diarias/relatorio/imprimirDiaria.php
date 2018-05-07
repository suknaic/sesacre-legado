<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/class/lib/mpdf/vendor/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/diarias/relatorio/imprimir/imprimir.load.php';

$mpdf = new \Mpdf\Mpdf(['debug' => true,
    'allow_output_buffering' => true]);
$mpdf->WriteHTML($html);
//$mpdf->debug = true;
$mpdf->Output();
exit();

