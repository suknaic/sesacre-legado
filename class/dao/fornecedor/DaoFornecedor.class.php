<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForFornecedor.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 06/11/18
 * Time: 17:35
 */

class DaoFornecedor extends ForFornecedor {
    public function cadastrarFornecedor($pdo) {
        try {
            $sql = $pdo->prepare("INSERT 
                                    INTO for_fornecedor (id_pessoa, fl_distribuidora, fl_exclusivo)
                                      VALUES (:idPessoa, :flDistribuidora, :flExclusivo)");

            $sql->bindValue(":flDistribuidora", $this->getFlDistribuidora()  === '' ? NULL : $this->getFlDistribuidora(), PDO::PARAM_STR);
            $sql->bindValue(":flExclusivo", $this->getFlExclusiva() === '' ? NULL : $this->getFlExclusiva(), PDO::PARAM_STR);
            $sql->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return Metodos::retornoAjax('Erro', 'console', $e->getMessage());
        }
    }
}