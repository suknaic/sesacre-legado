<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesFormacao.class.php";

class DaoSesFormacao extends SesFormacao {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_escolaridade_formacao (nm_escolaridade_formacao, id_escolaridade) "
                    . "VALUES (:nmFormacao, :idEscolaridade)");
            $result->bindValue(":nmFormacao", $this->getNm_escolaridade_formacao(), PDO::PARAM_STR);
            $result->bindValue(":idEscolaridade", $this->getId_escolaridade(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_escolaridade_formacao 
                                    SET nm_escolaridade_formacao = :nmFormacao,
                                        id_escolaridade = :idEscolaridade
                                    WHERE id_escolaridade_formacao = :idFormacao ");
            $result->bindValue(":idFormacao", $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $result->bindValue(":idEscolaridade", $this->getId_escolaridade(), PDO::PARAM_INT);
            $result->bindValue(":nmFormacao", $this->getNm_escolaridade_formacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_escolaridade_formacao WHERE Id_escolaridade_formacao = :idFormacao");
            $result->bindValue(":idFormacao", $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativar($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_escolaridade_formacao SET st_ativo = '0' WHERE Id_escolaridade_formacao = :idFormacao");
            $result->bindValue(":idFormacao", $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    function ativar($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_escolaridade_formacao SET st_ativo = '1' WHERE Id_escolaridade_formacao = :idFormacao");
            $result->bindValue(":idFormacao", $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retorna as informações de uma Funçao Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaFormacao($pdo) {

        $retorno = FALSE;
        $sql = "SELECT FORM.id_escolaridade_formacao, FORM.nm_escolaridade_formacao, ESC.id_escolaridade, ESC.nm_escolaridade
                 FROM ses_escolaridade_formacao FORM
                  INNER JOIN ses_escolaridade ESC ON ESC.id_escolaridade = FORM.id_escolaridade
                 WHERE FORM.id_escolaridade_formacao = :idFormacao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idFormacao", $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 0) {
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

    function retornaFormacoes($pdo, $filtro) {

        $retorno = FALSE;

        $sql = "select f.id_escolaridade_formacao, f.nm_escolaridade_formacao, e.id_escolaridade, e.nm_escolaridade, f.st_ativo
                from ses_escolaridade e
                    inner join ses_escolaridade_formacao f on e.id_escolaridade = f.id_escolaridade
                $filtro
                order by f.nm_escolaridade_formacao, e.nm_escolaridade";
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
     * Retorna Informação do Formacao caso o nome seja igual
     * Caso seja passado um ID Formacao, esse ID será desconsiderado na busca 
     * @param type $pdo
     * @return boolean/Object
     */
    function buscaFormacaoPorNome($pdo) {
        $retorno = false;
        $filtro = "";
        if ($this->getId_escolaridade_formacao() != NULL || $this->getId_escolaridade_formacao() != "") {
            $filtro = " AND f.id_escolaridade_formacao <> :idFormacao";
        }
        $sql = "SELECT f.id_escolaridade_formacao, f.nm_escolaridade_formacao, e.id_escolaridade, e.nm_escolaridade
                from ses_escolaridade e
                    inner join ses_escolaridade_formacao f on e.id_escolaridade = f.id_escolaridade
                where e.st_ativo = '1' and f.st_ativo = '1'
                and f.nm_escolaridade_formacao ilike :nmFormacao
                and e.id_escolaridade = :idEscolaridade
                $filtro";
        
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmFormacao", $this->getNm_escolaridade_formacao(), PDO::PARAM_STR);
            $sth->bindValue(":idEscolaridade", $this->getId_escolaridade(), PDO::PARAM_INT);
            
            if ($this->getId_escolaridade_formacao() != NULL || $this->getId_escolaridade_formacao() != "") {
                $sth->bindValue(":idFormacao", $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            }
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

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

