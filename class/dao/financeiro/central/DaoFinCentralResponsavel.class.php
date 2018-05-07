<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinCentralResponsavel.class.php";

class DaoFinCentralResponsavel extends FinCentralResponsavel {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO fin_central_responsavel (id_pessoa"
                    . " , id_lotacao) "
                    . " VALUES (:idPessoa, :idLotacao)");
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM fin_central_responsavel WHERE id_central_responsavel = :idCentralResponsavel");
            $result->bindValue(":idCentralResponsavel", $this->getIdCentralResponsavel(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_central_responsavel, id_pessoa, id_lotacao"
                . " FROM fin_central_responsavel"
                . " WHERE id_central_responsavel = :idCentralResponsavel";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idCentralResponsavel", $this->getIdCentralResponsavel(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /**
     * Retorna as informações de um Registro Especifico Por Uma Pessoa
     * @param type $pdo
     * @return boolean
     */
    function retornaPorPessoa($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_central_responsavel, id_pessoa, id_lotacao"
                . " FROM fin_central_responsavel"
                . " WHERE id_pessoa = :idPessoa";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function verificaPessoaCentral($pdo) {

        if ($pdo == null) {
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
        }

        $this->sucesso = false;

        $sql = " SELECT id_central_responsavel"
                . " FROM fin_central_responsavel"
                . " WHERE id_pessoa = :idPessoa AND id_lotacao = :idLotacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = false;
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaTodos($pdo) {

        if ($pdo == null) {
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
        }

        $this->sucesso = false;

        $sql = " SELECT CR.id_central_responsavel"
                . " , P.id_pessoa, P.nm_pessoa"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM fin_central_responsavel CR"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = CR.id_pessoa"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = CR.id_lotacao"
                . " ORDER BY P.nm_pessoa, L.nm_lotacao";
        try {
            $result = $pdo->prepare($sql);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = false;
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaLotacaoPorPessoa($pdo) {

        if ($pdo == null) {
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
        }

        $this->sucesso = false;

        $sql = " SELECT CR.id_central_responsavel"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM fin_central_responsavel CR"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = CR.id_lotacao"
                . " WHERE CR.id_pessoa = :idPessoa"
                . " ORDER BY L.nm_lotacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = false;
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaIdsLotacao(PDO $pdo) {
        $this->sucesso = false;
        try {
            $sql = "select id_lotacao
                    from fin_central_responsavel as cr
                    where cr.id_pessoa  = :idPessoa
                    group by id_lotacao";
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = false;
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
