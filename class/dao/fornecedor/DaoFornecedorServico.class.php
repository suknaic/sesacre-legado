<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForFornecedorServico.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 10:45
 */

class DaoFornecedorServico extends ForFornecedorServico {
    public function cadastrarFornecedorServico($pdo) {
        try {
            $sql = $pdo->prepare("INSERT 
                                    INTO for_fornecedor_servico (id_fornecedor, id_servico)
                                      VALUES (:idFornecedor, :idServico)");

            $sql->bindValue(":idServico", $this->getIdServico(), PDO::PARAM_INT);
            $sql->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}