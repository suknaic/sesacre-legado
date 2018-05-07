<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/class/lib/mpdf/vendor/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/compras/gcon/imprimir/imprimirTodos.load.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();