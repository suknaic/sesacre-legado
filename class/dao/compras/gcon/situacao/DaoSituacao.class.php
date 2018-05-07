<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/situacao/situacaoExtd.class.php";

class DaoSituacao extends SituacaoExtd {
    /*
     * Cadastra situação.
     */

    function cadastrarSituacao($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO gco_situacao (nm_situacao) VALUES (:Nova_Situacao)");
            $result->bindValue(":Nova_Situacao", $this->getNova_Situacao() === '' ? null : $this->getNova_Situacao(), PDO::PARAM_STR);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Lista situação.
     */

    function listarSituacao($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_situacao, nm_situacao FROM gco_situacao WHERE nm_situacao=:situacao AND st_ativo='1'");
            $list->bindValue(":situacao", $this->getPesq_Situacao(), PDO::PARAM_STR);
            $list->execute();
            if ($list->rowCount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Listar todas as situações.
     */

    function listarTodasSituacoes($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_situacao, nm_situacao FROM gco_situacao WHERE st_ativo=:status");
            $list->bindValue(":status", 1, PDO::PARAM_STR);
            $list->execute();
            if ($list->rowCount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Verifica se a situação já existe na hora do cadastro e edição da situação.
     */

    function verificarSituacao($pdo) {
        try {
            $ret = $pdo->prepare("SELECT nm_situacao FROM gco_situacao WHERE nm_situacao=:Nova_Situacao");
            $ret->bindValue(":Nova_Situacao", $this->getNova_Situacao(), PDO::PARAM_STR);
            $ret->execute();
            if ($ret->rowCount() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Edita a situação.
     */

    function editarSituacao($pdo) {
        try {
            $edit = $pdo->prepare("UPDATE gco_situacao SET nm_situacao = :Pesq_Situacao WHERE id_situacao = :idSituacao");
            $edit->bindValue(":Pesq_Situacao", $this->getNova_Situacao(), PDO::PARAM_STR);
            $edit->bindValue(":idSituacao", $this->getIdSituacao(), PDO::PARAM_INT);
            $edit->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Desativa a situação (OBS: Não pode ser deletado).
     */

    function desativarSituacao($pdo) {
        try {
            $del = $pdo->prepare("UPDATE gco_situacao SET st_ativo=:status WHERE id_situacao =:idSituacao");
            $del->bindValue(":idSituacao", $this->getIdSituacao(), PDO::PARAM_INT);
            $del->bindValue(":status", 0, PDO::PARAM_STR);
            $del->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Litas as situações desativadas.
     */

    function situacoesDesativadas($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_situacao, nm_situacao FROM gco_situacao WHERE st_ativo='0'");
            $list->execute();
            if ($list->rowcount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Ativa situação.
     */

    function ativarSituacao($pdo) {
        try {
            $sit = $pdo->prepare("UPDATE gco_situacao SET st_ativo=:status WHERE id_situacao=:id_situacao");
            $sit->bindValue(":id_situacao", $this->getIdSituacao(), PDO::PARAM_INT);
            $sit->bindValue(":status", 1, PDO::PARAM_STR);
            $sit->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Retorna situacao para o log.
     */

    function retornaSituacao($pdo) {
        try {
            $sql = $pdo->prepare('SELECT * 
                                        FROM gco_situacao
                                            WHERE id_situacao=:idSituacao');
            $sql->bindValue(':idSituacao', $this->getIdSituacao(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
