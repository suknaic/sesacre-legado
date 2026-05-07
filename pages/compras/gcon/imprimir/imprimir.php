<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/class/lib/mpdf/vendor/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/compras/gcon/imprimir/imprimir.load.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->SetTitle($dados['cd_ada_cpr']);
$mpdf->Output($dados['cd_ada_cpr'].'.pdf', 'I');
exit();