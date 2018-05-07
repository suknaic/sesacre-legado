<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesFuncao.class.php";

class DaoSesFuncao extends SesFuncao {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_funcao (nm_funcao) "
                    . "VALUES (:nmFuncao)");
            $result->bindValue(":nmFuncao", $this->getNm_funcao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_funcao SET nm_funcao = :nmFuncao "
                    . "WHERE id_funcao = :idFuncao ");
            $result->bindValue(":idFuncao", $this->getId_funcao(), PDO::PARAM_INT);
            $result->bindValue(":nmFuncao", $this->getNm_funcao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_funcao WHERE Id_funcao = :idFuncao");
            $result->bindValue(":idFuncao", $this->getId_funcao(), PDO::PARAM_INT);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_funcao SET st_ativo = 0 "
                    . "WHERE Id_funcao = :idFuncao ");
            $result->bindValue(":idFuncao", $this->getId_funcao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    /**
     * Retorna as informações de uma Funçao Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaFuncao($pdo) {

        $retorno = FALSE;
        $sql = "SELECT id_funcao, nm_funcao
                 FROM ses_funcao
                 WHERE id_funcao = :idFuncao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idFuncao", $this->getId_funcao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    /*
     * Retornar todas os dados das Funções
     */

    function retornaFuncoes($pdo) {

        $retorno = FALSE;

        $sql = "SELECT id_funcao, nm_funcao"
                . " FROM ses_funcao"
                . " ORDER BY nm_funcao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    /**
     * Retorna Informação do Funcao caso o nome seja igual
     * Caso seja passado um ID Funcao, esse ID será desconsiderado na busca 
     * @param type $pdo
     * @return boolean/Object
     */
    function buscaFuncaoPorNome($pdo) {
        $retorno = false;
        $filtro = "";
        if ($this->getId_funcao() != NULL || $this->getId_funcao() != "") {
            $filtro = " AND id_funcao <> :idFuncao";
        }
        $sql = " SELECT "
                . " id_funcao, nm_funcao"
                . " FROM ses_funcao"
                . " WHERE nm_funcao = :nmFuncao"
                . $filtro
                . "";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmFuncao", $this->getNm_funcao(), PDO::PARAM_STR);
            if ($this->getId_funcao() != NULL || $this->getId_funcao() != "") {
                $sth->bindValue(":idFuncao", $this->getId_funcao(), PDO::PARAM_INT);
            }
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return $retorno;
        }
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

