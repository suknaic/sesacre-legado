<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesCidade.class.php";

class DaoSesCidade extends SesCidade {

    function insert(SesCidade $cid, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_cidade (id_estado, id_regional_saude, id_regional_geo, nm_cidade) 
                                                     VALUES (:id_estado, :id_regional_saude, :id_regional_geo, :nm_cidade)");
            $result->bindValue(":id_estado", $cid->getId_estado(), PDO::PARAM_INT);
            $result->bindValue(":id_regional_saude", $cid->getId_regional_saude() === '' ? NULL : $cid->getId_regional_saude(), PDO::PARAM_INT);
            $result->bindValue(":id_regional_geo", $cid->getId_regional_geo() === '' ? NULL : $cid->getId_regional_geo(), PDO::PARAM_INT);
            $result->bindValue(":nm_cidade", $cid->getNm_cidade() === '' ? NULL : $cid->getNm_cidade(), PDO::PARAM_STR);
            $result->execute();
            return True;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_cidade 
                                            SET id_estado = :idEstado,
                                                id_regional_saude = :idRegionalSaude, 
                                                id_regional_geo = :idRegionalGeo,
                                                nm_cidade = :nmCidade
                                     WHERE id_cidade = :idCidade ");
            $result->bindValue(":idEstado", $this->getId_estado(), PDO::PARAM_INT);
            $result->bindValue(":idRegionalSaude", $this->getId_regional_saude(), PDO::PARAM_INT);
            $result->bindValue(":idRegionalGeo", $this->getId_regional_geo(), PDO::PARAM_INT);
            $result->bindValue(":nmCidade", $this->getNm_cidade(), PDO::PARAM_STR);
            $result->bindValue(":idCidade", $this->getId_cidade(), PDO::PARAM_INT);
            $result->execute();
            return True;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_cidade WHERE id_cidade = :idCidade");
            $result->bindValue(":idCidade", $this->getId_cidade(), PDO::PARAM_INT);
            $result->execute();

            $this->setSucess(true);
        } catch (PDOException $e) {
            $this->setSucess(false);
            return $e;
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
        try {
            $sth = $pdo->prepare("select *
                                    from ses_cidade c
                                        where c.id_cidade = :idCidade");
            $sth->bindValue(":idCidade", $this->getId_cidade(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return False;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    function listaCidade($pdo) {

        $retorno = FALSE;
        $idEstado = $this->getId_estado();

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
            echo $exc->getMessage();
            return $retorno;
        }
    }
    //********************************
    function listaTodasCidades($pdo) {
        $retorno = false;

        $sql = "select cid.id_cidade,cid.nm_cidade,est.nm_sigla,est.id_pais "
                . "from ses_cidade cid, ses_estado est"
                . " where cid.id_estado = est.id_estado" ;
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
            echo $exc->getMessage();
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
    
    function buscaCidadePorNomeAndEstado($pdo) {
        try {
            $sql = $pdo->prepare("select c.id_cidade, c.nm_cidade
                                    from ses_cidade c
                                      inner join ses_estado e on c.id_estado=e.id_estado
                                      left join ses_regional_geo rg on c.id_regional_geo=rg.id_regional_geo
                                      left join ses_regional_saude rs on c.id_regional_saude=rs.id_regional_saude
                                      left join ses_pais p on e.id_pais=p.id_pais
                                        where c.nm_cidade = :nmCidade and e.id_estado = :estado");

            $sql->bindValue(":nmCidade", $this->getNm_cidade(), PDO::PARAM_STR);
            $sql->bindValue(":estado", $this->getId_estado(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 1) {
                return True;
            } else {
                return False;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
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

    function buscarCidade($pdo, $filtro) {
        try {
            $sql = $pdo->prepare("SELECT CID.id_cidade, CID.nm_cidade, EST.nm_sigla as ESTADO, GEO.nm_regional_geo as GEO, SAU.nm_regional_saude as SAU, PAI.nm_sigla as PAIS 
	                                              FROM ses_cidade CID
                                                        INNER JOIN ses_estado EST ON EST.id_estado = CID.id_estado
                                                        LEFT JOIN ses_regional_geo GEO ON GEO.id_regional_geo = CID.id_regional_geo
                                                        LEFT JOIN ses_regional_saude SAU ON SAU.id_regional_saude = CID.id_regional_saude
                                                        INNER JOIN ses_pais PAI ON PAI.id_pais = EST.id_pais 
                                                            WHERE CID.st_ativo = '1'".$filtro);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function carregaDadosCidade($pdo) {
        try {
            $sql = $pdo->prepare("SELECT CID.id_cidade, CID.nm_cidade, CID.id_regional_geo, CID.id_regional_saude, CID.id_estado
                                        FROM ses_cidade CID
                                               INNER JOIN ses_estado EST ON EST.id_estado = CID.id_estado
                                               LEFT JOIN ses_regional_geo GEO ON GEO.id_regional_geo = CID.id_regional_geo
                                               LEFT JOIN ses_regional_saude SAU ON SAU.id_regional_saude = CID.id_regional_saude
                                               INNER JOIN ses_pais PAI ON PAI.id_pais = EST.id_pais
                                                    WHERE CID.st_ativo = '1'
                                                          AND CID.id_cidade = :idCidade");
            $sql->bindValue(':idCidade', $this->getId_cidade(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function buscaRegiosnaiSaude($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_regional_saude, nm_regional_saude 
                                        FROM ses_regional_saude 
                                              WHERE st_ativo = :stAtivo");
            $sql->bindValue(':stAtivo', '1', PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function buscaRegiosnaisGeo($pdo) {
        try {
            $sql = $pdo->prepare("SELECT id_regional_geo, nm_regional_geo 
                                        FROM ses_regional_geo 
                                              WHERE st_ativo = :stAtivo");
            $sql->bindValue(':stAtivo', '1', PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
