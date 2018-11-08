<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForFornecedorMedicamento.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 09:19
 */

class DaoFornecedorMedicamento extends ForFornecedorMedicamento {

    public function cadastrarFornecedorMedicamento($pdo) {
        try {
            $sql = $pdo->prepare("INSERT 
                                    INTO for_fornecedor_medicamento (id_fornecedor, id_medicamento)
                                      VALUES (:idFornecedor, :idMedicamento)");

            $sql->bindValue(":idMedicamento", $this->getIdMedicamento(), PDO::PARAM_INT);
            $sql->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}