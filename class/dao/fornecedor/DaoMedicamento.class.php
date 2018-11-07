<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForMedicamento.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:28
 */

class DaoMedicamento extends ForMedicamento {
    public function retornaMedicamento($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_medicamento, nm_medicamento 
                                    FROM for_medicamento 
                                      WHERE st_ativo = '1'");

            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}