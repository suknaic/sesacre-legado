<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesEscolaridade.class.php";

class DaoSesEscolaridade extends SesEscolaridade {

    function insert(SesEscolaridade $esc, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_escolaridade (nm_escolaridade) "
                    . "VALUES (:nmEscolaridade)");
            $result->bindValue(":nmEscolaridade", $esc->getNmEscolaridade(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update(SesEscolaridade $esc, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_escolaridade SET nm_escolaridade = :nmEscolaridade "
                    . "WHERE id_escolaridade = :idEscolaridade ");
            $result->bindValue(":idEscolaridade", $esc->getIdEscolaridade(), PDO::PARAM_INT);
            $result->bindValue(":nmEscolaridade", $esc->getNmEscolaridade(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_escolaridade WHERE id_escolaridade = :idEscolaridade");
            $result->bindValue(":idEscolaridade", $this->getIdEscolaridade(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativar($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_escolaridade SET st_ativo = 0 "
                    . "WHERE id_escolaridade = :idEscolaridade ");
            $result->bindValue(":idEscolaridade", $this->getIdEscolaridade(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    function ativar($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_escolaridade SET st_ativo = '1' 
                                        WHERE id_escolaridade = :idEscolaridade ");
            $result->bindValue(":idEscolaridade", $this->getIdEscolaridade(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaEscolaridadeFormacao($pdo) {

        $retorno = FALSE;

        $sql = "select ef.id_escolaridade_formacao, ef.nm_escolaridade_formacao, e.id_escolaridade, e.nm_escolaridade
                from ses_escolaridade_formacao ef
                inner join ses_escolaridade e on ef.id_escolaridade = e.id_escolaridade
                where ef.st_ativo = '1'
                order by ef.nm_escolaridade_formacao";
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
    function listaEscolaridade($pdo) {

        $retorno = FALSE;

        $sql = "select *
                from ses_escolaridade 
                order by nm_escolaridade";
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
    function retornaEscolaridade($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM ses_escolaridade"
                . " WHERE id_escolaridade = :idEscolaridade";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idEscolaridade", $this->getIdEscolaridade(), PDO::PARAM_INT);
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

    /**
     * Retorna Informação do Vinculo caso o nome seja igual
     * Caso seja passado um ID Vinculo, esse ID será desconsiderado na busca 
     * @param SesVinculo $vinculo
     * @param type $pdo
     * @return boolean/Object
     */
    function buscaEscolaridade(SesEscolaridade $esc, $pdo) {
        $retorno = false;
        $semEscolaridade = "";
        if ($esc->getIdEscolaridade() != NULL || $esc->getIdEscolaridade() != "") {
            $semEscolaridade = " AND id_escolaridade <> :idEscolaridade";
        }
        $sql = " SELECT "
                . " id_escolaridade, nm_escolaridade"
                . " FROM ses_escolaridade"
                . " WHERE nm_escolaridade = :nmEscolaridade"
                . $semEscolaridade
                . "";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmEscolaridade", $esc->getNmEscolaridade(), PDO::PARAM_STR);
            if ($esc->getIdEscolaridade() != NULL || $esc->getIdEscolaridade() != "") {
                $sth->bindValue(":idEscolaridade", $esc->getIdEscolaridade(), PDO::PARAM_INT);
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
    
    function buscaEscolaridadePorPessoa($pdo) {
        $retorno = FALSE;
        $idPessoaFisica = $this->getId_pessoa_fisica();
        if ($this->getId_pessoa_fisica() == 0) {
            $sql = "SELECT id_escolaridade, nm_escolaridade
                        FROM ses_escolaridade
                        WHERE st_ativo = '1'";
        } else {
             $sql = "SELECT e.id_escolaridade, e.nm_escolaridade
                 FROM ses_escolaridade e 
                 INNER JOIN ses_pessoa_fisica AS pf ON e.id_escolaridade = pf.id_escolaridade
                 WHERE pf.id_pessoa = $idPessoaFisica
                 AND e.st_ativo = '1'";
        }       
        try {
            $sth = $pdo->prepare($sql);
//            $sth->bindValue(":idPessoa", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
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
