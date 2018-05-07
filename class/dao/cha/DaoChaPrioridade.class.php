<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaPrioridade.class.php";

class DaoChaPrioridade extends ChaPrioridade {
    /* ===================================== */

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /* ====================================== */
    /* Cadastra prioridade no banco */

    function cadastrarPrioridade($pdo) {
        try {
            $sql = $pdo->prepare('INSERT INTO cha_prioridade(nm_prioridade, cs_prioridade)
                                             VALUES(:nmPrioridade, :csPrioridade)');
            $sql->bindValue(':nmPrioridade', $this->getNmPrioridade() === '' ? null : $this->getNmPrioridade(), PDO::PARAM_STR);
            $sql->bindValue(':csPrioridade', $this->getCsPrioridade() === '' ? null : $this->getCsPrioridade(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /* Edita prioridade no banco */

    function editarPrioridade($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_prioridade
                                        SET nm_prioridade=:nmPrioridade, cs_prioridade=:csPrioridade
                                           WHERE id_prioridade =:idPrioridade');
            $sql->bindValue(':idPrioridade', $this->getIdPrioridade(), PDO::PARAM_STR);
            $sql->bindValue(':nmPrioridade', $this->getNmPrioridade(), PDO::PARAM_INT);
            $sql->bindValue(':csPrioridade', $this->getCsPrioridade(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /* Lista todas as prioridades do banco ativadas e desativadas */

    function listarPrioridades($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_prioridade, nm_prioridade, cs_prioridade, st_ativo
                                        FROM cha_prioridade
                                            WHERE st_ativo IN (:ativado, :desativado)');
            $sql->bindValue(':ativado', 1, PDO::PARAM_STR);
            $sql->bindValue(':desativado', 0, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /* Desativa prioridade ativada */

    function desativarPrioridade($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_prioridade
                                        SET st_ativo = 0
                                           WHERE id_prioridade =:idPrioridade');
            $sql->bindValue(':idPrioridade', $this->getIdPrioridade(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /* Ativa uma prioridade desativada */

    function ativarPrioridade($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_prioridade
                                        SET st_ativo= 1
                                           WHERE id_prioridade =:idPrioridade');
            $sql->bindValue(':idPrioridade', $this->getIdPrioridade(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /* Verifica a existencia da prioridade pelo nome. (OBS: Realizado na acao de cadastro) */

    function verificaPrioridadeNome($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_prioridade
                                        FROM cha_prioridade
                                            WHERE nm_prioridade=:nmPrioridade');
            $sql->bindValue(':nmPrioridade', $this->getNmPrioridade(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
            } else {
                $this->sucesso = FALSE;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* Verifica e existencia de uma prioridade pelo nome e classificacao. */

    function verificaPrioridadeNomeCs($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_prioridade
                                        FROM cha_prioridade
                                            WHERE nm_prioridade=:nmPrioridade 
                                                 AND cs_prioridade=:csPrioridade');
            $sql->bindValue(':nmPrioridade', $this->getNmPrioridade(), PDO::PARAM_STR);
            $sql->bindValue(':csPrioridade', $this->getCsPrioridade(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $this->sucesso;
            } else {
                $this->sucesso = FALSE;
                $this->msgRetorno = $this->sucesso;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* Verifica e existencia de uma prioridade pelo id. */

    function verificaPrioridadeId($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_prioridade
                                        FROM cha_prioridade
                                            WHERE id_prioridade=:idPrioridade');
            $sql->bindValue(':idPrioridade', $this->getIdPrioridade(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
            } else {
                $this->sucesso = FALSE;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* Retorna a prioridade para o log */

    public function retornaPrioridade($pdo) {
        try {
            $sql = $pdo->prepare("SELECT * 
                                        FROM cha_prioridade
                                            WHERE id_prioridade=:idPrioridade");
            $sql->bindValue(':idPrioridade', $this->getIdPrioridade(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /* Delete uma prioridade */

    function deletarPrioridade($pdo) {
        try {
            $sql = $pdo->prepare("DELETE 
                                        FROM cha_prioridade 
                                            WHERE id_prioridade=:idPrioridade");
            $sql->bindValue(":idPrioridade", $this->getIdPrioridade(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
