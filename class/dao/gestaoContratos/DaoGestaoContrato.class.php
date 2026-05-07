<?php
class DaoGestaoContrato{

    function __construct() {

    }

    public function listaGestaoContratos($pdo = null): string {
        if ($pdo != null) {
            try {
                $sql = "SELECT FROM ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return 'Sucesso';
            } catch (Error $e) {
                return 'Erro';
            }
        }
    }
}
?>
