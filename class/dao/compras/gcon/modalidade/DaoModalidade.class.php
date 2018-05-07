<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/modalidade/modalidadeExtd.class.php";

class DaoModalidade extends modalidade_extd {

    //cadastra modalidade
    function cadastraModalidade($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO gco_modalidade (nm_modalidade) VALUES (:Nova_Modalidade)");
            $result->bindValue(":Nova_Modalidade", $this->getModalidade() === '' ? null : $this->getModalidade(), PDO::PARAM_STR);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //lista a modalidade pesquisada
    function listaModalidade($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_modalidade, nm_modalidade FROM gco_modalidade WHERE nm_modalidade ILIKE :modalidade AND st_ativo='1'");
            $list->bindValue(":modalidade", $this->getModalidade() . '%', PDO::PARAM_STR);
            $list->execute();
            if ($list->rowCount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //lista a modalidade para o log
    function retornaModalidade($pdo) {
        try {
            $sql = $pdo->prepare('SELECT * FROM gco_modalidade WHERE id_modalidade=:idModalidade');
            $sql->bindValue(':idModalidade', $this->getIdModalidade(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //lista todas as modalidades
    function retornaTodasModalidades($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_modalidade, nm_modalidade 
                                   FROM gco_modalidade 
                                   WHERE st_ativo=:status
                                   ORDER BY nm_modalidade");
            $sql->bindValue(":status", 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //verifica se a modalidade já existe no cadastro na hora do cadastro de modalidade 
    function verificaModalidade($pdo) {
        try {
            $ret = $pdo->prepare("SELECT nm_modalidade FROM gco_modalidade WHERE nm_modalidade=:modalidade");
            $ret->bindValue(":modalidade", $this->getModalidade(), PDO::PARAM_STR);
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

    //edita modalidade
    function editarModalidade($pdo) {
        try {
            $edit = $pdo->prepare("UPDATE gco_modalidade SET nm_modalidade =:modalidade WHERE id_modalidade =:idModalidade");
            $edit->bindValue(":modalidade", $this->getModalidade(), PDO::PARAM_STR);
            $edit->bindValue(":idModalidade", $this->getIdModalidade(), PDO::PARAM_INT);
            $edit->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //desativa modalidade
    function desativarModalidade($pdo) {
        try {
            $del = $pdo->prepare("UPDATE gco_modalidade SET st_ativo=:status WHERE id_modalidade=:idModalidade");
            $del->bindValue(":idModalidade", $this->getIdModalidade(), PDO::PARAM_INT);
            $del->bindValue(":status", 0, PDO::PARAM_STR);
            $del->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //litas as modalidades desativadas
    function modalidadesDesativadas($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_modalidade, nm_modalidade FROM gco_modalidade WHERE st_ativo='0'");
            $list->execute();
            if ($list->rowcount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //ativa modalidade
    function ativarModalidade($pdo) {
        try {
            $sit = $pdo->prepare("UPDATE gco_modalidade SET st_ativo=:status WHERE id_modalidade=:id_modalidade");
            $sit->bindValue(":id_modalidade", $this->getIdModalidade(), PDO::PARAM_INT);
            $sit->bindValue(":status", 1, PDO::PARAM_STR);
            $sit->execute();
            return TRUE;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
