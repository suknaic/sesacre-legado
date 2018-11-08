<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForFornecedorMaterialConsumo.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 11:23
 */

class DaoFornecedorMaterialConsumo extends ForFornecedorMaterialConsumo{
    public function cadastrarFornecedorMaterialConsumo($pdo) {
        try {
            $sql = $pdo->prepare("INSERT 
                                    INTO for_fornecedor_material_consumo (id_fornecedor, id_material_consumo)
                                      VALUES (:idFornecedor, :idMaterialConsumo)");

            $sql->bindValue(":idMaterialConsumo", $this->getIdMaterialConsumo(), PDO::PARAM_INT);
            $sql->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}