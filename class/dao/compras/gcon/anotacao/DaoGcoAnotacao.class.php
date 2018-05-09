<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/anotacao/GconAnotacaoExtd.class.php";

/**
 * Description of DaoGcoAnotacao
 *
 * @author elivelton
 */
class DaoGcoAnotacao extends GcoAnotacaoExtd {
    
    //Método para cadastrar Anotação do processo
    function cadastrarAnotacao($pdo) {
        try {
            $cadanota = $pdo->prepare("INSERT INTO gco_anotacao(ds_anotacao, id_processo, id_situacao, id_pessoa, id_usuario)
                                       VALUES(:anotacoes_process, :id_processo, :id_situacao, :id_tecnico, :id_usuario)");

            $cadanota->bindValue(":anotacoes_process", $this->getAnotacao() === '' ? null : $this->getAnotacao(), PDO::PARAM_STR);
            $cadanota->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $cadanota->bindValue(":id_situacao", $this->getSituacao(), PDO::PARAM_INT);
            $cadanota->bindValue(":id_usuario", $this->getUser(), PDO::PARAM_INT);
            $cadanota->bindValue(":id_tecnico", $this->getTecnico(), PDO::PARAM_INT);
            $cadanota->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function carregaAnotacao($pdo) {
        try {
            $sql = $pdo->prepare('SELECT anotacao.id_anotacao, pessoa.id_pessoa, anotacao.id_situacao
                                    FROM gco_anotacao as anotacao 
                                    INNER JOIN ses_pessoa as pessoa ON pessoa.id_pessoa = anotacao.id_pessoa
                                  WHERE anotacao.id_processo = :idProcesso 
                                  ORDER BY anotacao.id_anotacao DESC');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    function retornarAnotacoes($pdo) {
        try {
            $sql = $pdo->prepare('SELECT anotacao.ds_anotacao, anotacao.dh_anotacao, pessoa.nm_pessoa
                                        FROM gco_anotacao as anotacao 
                                            INNER JOIN ses_pessoa as pessoa ON pessoa.id_pessoa=anotacao.id_usuario
                                                 WHERE anotacao.id_processo=:idProcesso
                                                      ORDER BY anotacao.id_anotacao');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
