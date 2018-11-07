<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForMetarialConsumo.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 17:06
 */

class DaoMaterialConsumo extends ForMetarialConsumo {
    public function retornaMaterialConsumo($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_material_consumo, nm_material_consumo 
                                    FROM for_material_consumo 
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