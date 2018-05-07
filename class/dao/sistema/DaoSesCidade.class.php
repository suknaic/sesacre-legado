<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesCidade.class.php";

class DaoSesCidade extends SesCidade {

    function insert(SesCidade $cid, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_cidade (id_estado, id_regional_saude, id_regional_geo, nm_cidade) 
                                                     VALUES (:id_estado, :id_regional_saude, :id_regional_geo, :nm_cidade)");
            $result->bindValue(":id_estado", $cid->getId_estado(), PDO::PARAM_INT);
            $result->bindValue(":id_regional_saude", $cid->getId_regional_saude(), PDO::PARAM_INT);
            $result->bindValue(":id_regional_geo", $cid->getId_regional_geo(), PDO::PARAM_INT);
            $result->bindValue(":nm_cidade", $cid->getNm_cidade(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update(SesCidade $cid, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_cidade 
                                            SET id_estado = :id_estado,
                                                id_regional_saude = :id_regional_saude, 
                                                id_regional_geo = :id_regional_geo,
                                                nm_cidade = :nm_cidade
                                     WHERE id_cidade = :idCidade ");
            $result->bindValue(":id_estado", $cid->getId_estado(), PDO::PARAM_INT);
            $result->bindValue(":id_regional_saude", $cid->getId_regional_saude(), PDO::PARAM_INT);
            $result->bindValue(":id_regional_geo", $cid->getId_regional_geo(), PDO::PARAM_INT);
            $result->bindValue(":nm_cidade", $cid->getNm_cidade(), PDO::PARAM_STR);
            $result->bindValue(":id_cidade", $cid->getId_cidade(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete(SesCidade $cid, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_cidade WHERE id_cidade = :idCidade");
            $result->bindValue(":idCidade", $cid->getIdCidade(), PDO::PARAM_INT);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa(SesCidade $cid, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_cidade SET st_ativo = 0 "
                    . "WHERE id_cidade = :idCidade ");
            $result->bindValue(":idCidade", $cid->getIdCidade(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaCidade($pdo) {

        $retorno = FALSE;

        $sql = "select c.id_cidade, c.nm_cidade, c.id_estado, e.nm_estado, c.id_regional_geo, rg.nm_regional_geo, c.id_regional_saude, 
                       rs.nm_regional_saude, p.id_pais, p.nm_pais, c.st_ativo 
                from ses_cidade c
                inner join ses_estado e on c.id_estado=e.id_estado
                left join ses_regional_geo rg on c.id_regional_geo=rg.id_regional_geo
                left join ses_regional_saude rs on c.id_regional_saude=rs.id_regional_saude
                left join ses_pais p on e.id_pais=p.id_pais
                where id_cidade = :idCidade
                order by rg.nm_regional_geo, e.nm_estado, c.nm_cidade";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idCidade", $this->getIdCidade(), PDO::PARAM_INT);
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
    function listaCidade($pdo) {

        $retorno = FALSE;
        $idEstado = $this->getId_estado();
//         $sql = "select *
//                from ses_cidade 
//                where id_estado = $idEstado
//                order by nm_cidade";
        $sql = "select c.id_cidade, c.nm_cidade, c.id_estado, e.nm_estado, c.id_regional_geo, rg.nm_regional_geo, c.id_regional_saude, 
                       rs.nm_regional_saude, p.id_pais, p.nm_pais, c.st_ativo 
                from ses_cidade c
                inner join ses_estado e on c.id_estado=e.id_estado
                left join ses_regional_geo rg on c.id_regional_geo=rg.id_regional_geo
                left join ses_regional_saude rs on c.id_regional_saude=rs.id_regional_saude
                left join ses_pais p on e.id_pais=p.id_pais
                where e.id_estado = $idEstado
                order by c.nm_cidade, rg.nm_regional_geo, e.nm_estado ";
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
    //***************************************
     
    function buscaCidadeUf($pdo) {
        $retorno = false;
        
        $sql = "select * from ses_estado where nm_sigla= :uf " ;
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":uf", $this->getNm_uf(), PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $exc) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    //********************************
    function listaTodasCidades($pdo) {
        $retorno = false;
        
        $sql = "select cid.id_cidade,cid.nm_cidade,est.nm_sigla "
                . "from ses_cidade cid, ses_estado est "
                . "where cid.id_estado = est.id_estado" ;
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $exc) {
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
    
    function buscaCidadePorNome(SesCidade $cid, $pdo) {
        $retorno = false;
        $semCidade = "";
        if ($cid->getIdCidade() != NULL || $cid->getIdCidade() != "") {
            $Cidade = " AND id_cidade <> :idCidade";
        }
        $sql = "select c.id_cidade, c.nm_cidade, c.id_estado, e.nm_estado, c.id_regional_geo, rg.nm_regional_geo, c.id_regional_saude, 
                       rs.nm_regional_saude, p.id_pais, p.nm_pais, c.st_ativo 
                from ses_cidade c
                inner join ses_estado e on c.id_estado=e.id_estado
                left join ses_regional_geo rg on c.id_regional_geo=rg.id_regional_geo
                left join ses_regional_saude rs on c.id_regional_saude=rs.id_regional_saude
                left join ses_pais p on e.id_pais=p.id_pais
                where nm_cidade = :nmCidade
                $Cidade
                order by rg.nm_regional_geo, e.nm_estado, c.nm_cidade";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmCidade", $cid->getNmCidade(), PDO::PARAM_STR);
            if ($cid->getIdCidade() != NULL || $cid->getIdCidade() != "") {
                $sth->bindValue(":idCidade", $cid->getIdPais(), PDO::PARAM_INT);
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
    
    function cidadePorNomeEstado(PDO $pdo = null) {
        $retorno = false;
        
        $sql = "select cid.id_cidade as id_cidade, pais.nm_pais as pais, est.nm_estado as estado , cid.nm_cidade as cidade, est.nm_sigla as estado_sigla 
                from ses_cidade cid, ses_estado est, ses_pais pais 
                where cid.id_estado = est.id_estado 
                and est.id_pais = pais.id_pais
                and (unaccent(cid.nm_cidade) ilike unaccent('". $this->getNm_cidade() ."') or unaccent(est.nm_sigla) like unaccent('" . $this->getNm_cidade() . "'))";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

}
