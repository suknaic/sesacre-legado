<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForMaterialPermanente.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 17:23
 */

class DaoMaterialPermanente {
    public function retornaMaterialPermanente($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_material_permanente, nm_material_permanente 
                                    FROM for_material_permanente 
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