<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForFornecedorMaterialPermanente.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 11:53
 */

class DaoFornecedorMaterialPermanente extends ForFornecedorMaterialPermanente {
    public function cadastrarFornecedorMaterialPermanente($pdo) {
        try {
            $sql = $pdo->prepare("INSERT 
                                    INTO for_fornecedor_material_permanente (id_fornecedor, id_material_permanente)
                                      VALUES (:idFornecedor, :idMaterialPermanente)");

            $sql->bindValue(":idMaterialPermanente", $this->getIdMaterialPermanente(), PDO::PARAM_INT);
            $sql->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}