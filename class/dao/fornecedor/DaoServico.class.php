<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForServico.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:56
 */

class DaoServico extends ForServico {

    public function retornaServico($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_servico, nm_servico 
                                    FROM for_servico 
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