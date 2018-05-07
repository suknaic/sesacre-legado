<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/objeto/objeto_exd.class.php";

class DaoObjeto extends ObjetoExtd {

    function cadastraObjeto($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO gco_objeto (nm_objeto) VALUES (:objeto)");
            $result->bindValue(":objeto", $this->getObjeto() === '' ? null : $this->getObjeto(), PDO::PARAM_STR);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function pesquisarObjeto($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_objeto, nm_objeto FROM gco_objeto WHERE nm_objeto ILIKE :objeto AND st_ativo='1'");
            $list->bindValue(":objeto", $this->getObjeto().'%', PDO::PARAM_STR);
            $list->execute();
            if ($list->rowCount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //verifica se o objeto já existe  
    function verificarObjeto($pdo) {
        try {
            $verifica = $pdo->prepare("SELECT nm_objeto FROM gco_objeto WHERE nm_objeto=:objeto");
            $verifica->bindValue(":objeto", $this->getObjeto(), PDO::PARAM_STR);
            $verifica->execute();
            if ($verifica->rowCount() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //edita um objeto cadastrado
    function editarObjeto($pdo) {
        try {
            $edit = $pdo->prepare("UPDATE gco_objeto SET nm_objeto=:objeto WHERE id_objeto=:idObjeto");
            $edit->bindValue(":objeto", $this->getObjeto(), PDO::PARAM_STR);
            $edit->bindValue(":idObjeto", $this->getIdObjeto(), PDO::PARAM_INT);
            $edit->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //retorna um objeto para o log
    public function retornarObjeto($pdo) {
        try {
            $list = $pdo->prepare("SELECT * FROM gco_objeto WHERE id_objeto=:idObjeto");
            $list->bindValue(":idObjeto", $this->getIdObjeto(), PDO::PARAM_INT);
            $list->execute();
            if ($list->rowCount() > 0) {
                return $list->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    //desativa um objeto
    function desativarObjeto($pdo) {
        try {
            $del = $pdo->prepare("UPDATE gco_objeto SET st_ativo='0' WHERE id_objeto=:idObjeto");
            $del->bindValue(":idObjeto", $this->getIdObjeto(), PDO::PARAM_INT);
            $del->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //lista objetos desativados
    function objetosDesativados($pdo) {
        try {
            $objetos = $pdo->prepare("SELECT id_objeto, nm_objeto 
                                        FROM gco_objeto 
                                      WHERE st_ativo=:status");
            $objetos->bindValue(':status', 0, PDO::PARAM_STR);
            $objetos->execute();
            if ($objetos->rowcount() >= 0) {
                return $objetos->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //ativando objeto
    function ativarObjeto($pdo) {
        try {
            $ativar = $pdo->prepare("UPDATE gco_objeto SET st_ativo=:status WHERE id_objeto=:id_objeto");
            $ativar->bindValue(":status", 1, PDO::PARAM_STR);
            $ativar->bindValue(":id_objeto", $this->getIdObjeto(), PDO::PARAM_INT);
            $ativar->execute();
            return TRUE;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //Método que lista todas os objetos no select option
    function retornaTodosObjetos($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_objeto,nm_objeto "
                                    . "FROM gco_objeto "
                                    . "WHERE st_ativo=:status "
                                    . "ORDER BY nm_objeto");
            $sql->bindValue(":status", 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
