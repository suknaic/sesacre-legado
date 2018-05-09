<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/anexo/GconAnexoExt.class.php";

/**
 * Description of DaoGcoAnexo
 *
 * @author elivelton
 */
class DaoGcoAnexo extends GconAnexoExt {
    //método para salvar dados do anexo
    function cadastrarAnexo($pdo) {
        try {
            $upload = $pdo->prepare("INSERT INTO gco_anexo(ds_anexo, lk_anexo, id_processo) VALUES (:nome, :endereco, :id_processo)");
            $upload->bindValue(":nome", $this->getNomeAnexo() === '' ? null : $this->getNomeAnexo(), PDO::PARAM_STR);
            $upload->bindValue(":endereco", $this->getEndereco() === '' ? null : $this->getEndereco(), PDO::PARAM_STR);
            $upload->bindValue("id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $upload->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    //carrega os anexos de um processo
    function retornarAnexosProcesso($pdo) {
        try {
            $dados = $pdo->prepare(" SELECT id_anexo, ds_anexo 
                                        FROM gco_anexo
                                        WHERE id_processo=:id_processo
                                    GROUP BY id_anexo");
            $dados->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $dados->execute();
            if ($dados->rowCount() >= 0) {
                return $dados->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return "";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    //exclui anexo de um processo
    function excluirAnexo($pdo) {
        try {
            $exclui = $pdo->prepare(" DELETE 
                                        FROM gco_anexo 
                                      WHERE id_anexo=:id_anexo");
            $exclui->bindValue("id_anexo", $this->getIdAnexo(), PDO::PARAM_INT);
            $exclui->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
