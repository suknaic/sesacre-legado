<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesLotacao.class.php";

class DaoSesLotacao extends SesLotacao {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    //**************************************************************************
    /*
     * imputar dados na tabelaLotações
     */

    function insert($pdo) {
        try {
            $sql = "INSERT INTO ses_lotacao (id_pai, id_lotacao_categoria, nm_lotacao, ds_logradouro, ds_bairro, nr_cnpj, nr_cep, id_cidade, nm_email, mp_latitude, mp_longitude, id_pessoa, id_pessoa_juridica) 
                                     VALUES (:id_pai, :id_lotacao_categoria, :nm_lotacao, :ds_logradouro, :ds_bairro, :nr_cnpj, :nr_cep, :id_cidade, :nm_email, :mp_latitude, :mp_longitude, :id_pessoa, :id_pessoa_juridica)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pai", $this->getId_pai() === '' ? null : $this->getId_pai(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao_categoria", $this->getId_lotacao_categoria(), PDO::PARAM_INT);
            $result->bindValue(":nm_lotacao", $this->getNm_lotacao() === '' ? null : $this->getNm_lotacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_logradouro", $this->getDs_logradouro() === '' ? null : $this->getDs_logradouro(), PDO::PARAM_STR);
            $result->bindValue(":ds_bairro", $this->getDs_bairro() === '' ? null : $this->getDs_bairro(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnpj", $this->getNr_cnpj() === '' ? null : $this->getNr_cnpj(), PDO::PARAM_STR);
            $result->bindValue(":nr_cep", $this->getNr_cep() === '' ? null : $this->getNr_cep(), PDO::PARAM_INT);
            $result->bindValue(":id_cidade", $this->getId_cidade() === '' ? null : $this->getId_cidade(), PDO::PARAM_INT);
            $result->bindValue(":nm_email", $this->getNm_email() === '' ? null : $this->getNm_email(), PDO::PARAM_STR);
            $result->bindValue(":mp_latitude", $this->getMp_latitude() === '' ? null : $this->getMp_latitude(), PDO::PARAM_STR);
            $result->bindValue(":mp_longitude", $this->getMp_longitute() === '' ? null : $this->getMp_longitute(), PDO::PARAM_STR);
            $result->bindValue(":id_pessoa", $this->getId_pessoa() === '' ? null : $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa_juridica", $this->getId_pessoa_juridica() === '' ? null : $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * update tabela ses_lotacao
     * @param type $pdo
     * @return "sucesso"
     */
    function update($pdo) {
        try {
            $sql = "UPDATE ses_lotacao 
                    SET
                        id_pai = :id_pai, 
                        id_lotacao_categoria = :id_lotacao_categoria, 
                        nm_lotacao = :nm_lotacao, 
                        ds_logradouro = :ds_logradouro, 
                        ds_bairro = :ds_bairro, 
                        nr_cnpj = :nr_cnpj, 
                        nr_cep = :nr_cep, 
                        id_cidade = :id_cidade,
                        nm_email = :nm_email, 
                        mp_latitude = :mp_latitude, 
                        mp_longitude = :mp_longitude, 
                        id_pessoa = :id_pessoa, 
                        id_pessoa_juridica = :id_pessoa_juridica
                    WHERE id_lotacao = :id_lotacao";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pai", $this->getId_pai() === '' ? null : $this->getId_pai(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao_categoria", $this->getId_lotacao_categoria(), PDO::PARAM_INT);
            $result->bindValue(":nm_lotacao", $this->getNm_lotacao() === '' ? null : $this->getNm_lotacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_logradouro", $this->getDs_logradouro() === '' ? null : $this->getDs_logradouro(), PDO::PARAM_STR);
            $result->bindValue(":ds_bairro", $this->getDs_bairro() === '' ? null : $this->getDs_bairro(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnpj", $this->getNr_cnpj() === '' ? null : $this->getNr_cnpj(), PDO::PARAM_STR);
            $result->bindValue(":nr_cep", $this->getNr_cep() === '' ? null : $this->getNr_cep(), PDO::PARAM_INT);
            $result->bindValue(":id_cidade", $this->getId_cidade() === '' ? null : $this->getId_cidade(), PDO::PARAM_INT);
            $result->bindValue(":nm_email", $this->getNm_email() === '' ? null : $this->getNm_email(), PDO::PARAM_STR);
            $result->bindValue(":mp_latitude", $this->getMp_latitude() === '' ? null : $this->getMp_latitude(), PDO::PARAM_STR);
            $result->bindValue(":mp_longitude", $this->getMp_longitute() === '' ? null : $this->getMp_longitute(), PDO::PARAM_STR);
            $result->bindValue(":id_pessoa", $this->getId_pessoa() === '' ? null : $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa_juridica", $this->getId_pessoa_juridica() === '' ? null : $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getId_lotacao() === '' ? null : $this->getId_lotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //*********************************************************************************************************
    function desativarLotacao($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_lotacao SET st_ativo = '0' 
                                     WHERE id_lotacao = :idLotacao");
            $result->bindValue(":idLotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }
    //*********************************************************************************************************
    function ativarLotacao($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_lotacao SET st_ativo = '1' 
                                     WHERE id_lotacao = :idLotacao");
            $result->bindValue(":idLotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }
//*******************************************************************************************************************************************************************
    /*
     * Retornar todas os dados das Lotações
     * Ainda aguardando o modulo de RH para melhorar isso.
     */

    public function cadastrarTelefone($pdo) {
        try {
            $sql = "INSERT INTO ses_telefone (nr_telefone, st_principal, id_lotacao) 
                                     VALUES (:nr_telefone, :st_principal, :id_lotacao)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":nr_telefone", $this->getNr_telefone() === '' ? null : $this->getNr_telefone(), PDO::PARAM_INT);
            $result->bindValue(":st_principal", $this->getSt_principal() === '' ? null : $this->getSt_principal(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getId_lotacao() === '' ? null : $this->getId_lotacao(), PDO::PARAM_INT);

            $result->execute();
            return "Sucesso";

            return $result;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * Retorna todos os dados de competencia de uma pessoa fisica
     * @param type $pdo
     * @return boolean/Array
     */
    function listaTelefones($pdo) {

        //$retorno = FALSE;
        $sql = "select *
                FROM ses_telefone
                WHERE id_lotacao  = :idLotacao
                order by st_principal desc";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idLotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            //  return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    //*******************************************************************************************************************************
    function buscaTelefone($pdo) {

        $sql = "select *
                from ses_telefone
                where id_telefone = :idTelefone";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idTelefone", $this->getId_telefone(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    function buscaTelefonePorLotacao($pdo) {

        $sql = "select *
                FROM ses_telefone
                WHERE id_lotacao  = :idLotacao
                AND st_principal = '1'";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idLotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    /*
     * Remove telefone
     * @param type $pdo
     * @return string
     */

    function removerTelefone($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_telefone  
                                     WHERE id_telefone = :idTelefone");
            $result->bindValue(":idTelefone", $this->getId_telefone(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /*
     * Retornar todas os dados das Categoria lotação
     * Ainda aguardando o modulo de RH para melhorar isso.
     */

    function retornaCategoriasLotacao($pdo) {

        $retorno = FALSE;

        $sql = "SELECT * "
                . " FROM ses_lotacao_categoria "
                . " ORDER BY nm_lotacao_categoria";
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

    //*****************************************************************************************************************************
    function retornaTodasLotacoes($pdo) {

        $retorno = FALSE;

        $sql = "SELECT id_lotacao, nm_lotacao
                  FROM ses_lotacao 
                  where st_ativo = '1'
                  ORDER BY nm_lotacao";
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
     * Retorna as todas Lotações
     * @param type $pdo
     * @return boolean
     */
    function retornaLotacoes($pdo, $filtro) {
        $retorno = FALSE;
        $sql = "SELECT l.id_lotacao, l.nm_lotacao, l.id_pai, pa.nm_lotacao pai, lc.id_lotacao_categoria, lc.nm_lotacao_categoria, l.nr_cnpj, l.ds_logradouro, l.ds_bairro, l.nr_cep, l.nm_email, l.mp_latitude, l.mp_longitude, l.st_ativo,
                       l.id_pessoa, p.nm_pessoa responsavel, l.id_pessoa_juridica, pj.id_pessoa_juridica, ppj.nm_pessoa juridica,
                       l.id_cidade, ci.nm_cidade, e.nm_sigla,
                       array_to_string(array_agg(t.nr_telefone), ', ') as nr_telefone                                      
                FROM ses_lotacao l 
                    left join ses_lotacao pa on l.id_pai = pa.id_lotacao
                    left join ses_lotacao_categoria  lc on l.id_lotacao_categoria = lc.id_lotacao_categoria
                    left join ses_pessoa p on l.id_pessoa = p.id_pessoa
                    left join ses_pessoa_juridica pj on l.id_pessoa_juridica = pj.id_pessoa_juridica
                    left join ses_pessoa ppj on pj.id_pessoa = ppj.id_pessoa
                    left join ses_cidade ci on l.id_cidade = ci.id_cidade
                    left join ses_estado e on ci.id_estado = e.id_estado
                    left join ses_telefone t on l.id_lotacao = t.id_lotacao
                
                $filtro
		group by l.id_lotacao, lc.id_lotacao_categoria, p.id_pessoa, pj.id_pessoa_juridica, lc.nm_lotacao_categoria, l.nm_lotacao, pai, juridica, ci.nm_cidade, e.nm_sigla
                ORDER BY lc.nm_lotacao_categoria, l.nm_lotacao";
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
     * Retorna as informações de uma Lotação Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaLotacao($pdo) {
        $retorno = FALSE;
        $sql = " SELECT l.*, p.id_pais, e.id_estado, pe.nm_pessoa, p2.nm_pessoa nm_pessoa_juridica
                 FROM ses_lotacao l 
                 inner join ses_cidade c on l.id_cidade = c.id_cidade
                 inner join ses_estado e on c.id_estado = e.id_estado
                 inner join ses_pais p on e.id_pais = p.id_pais
                 left join ses_pessoa pe on l.id_pessoa = pe.id_pessoa
                 left join ses_pessoa_juridica pj on l.id_pessoa_juridica = pj.id_pessoa_juridica
                 left join ses_pessoa p2 on pj.id_pessoa = p2.id_pessoa
                 WHERE l.id_lotacao = :idLotacao
                 ";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idLotacao", $this->getId_lotacao(), PDO::PARAM_INT);
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
     * Retorna as informações de uma Lotação Especifico
     * @param type $pdo
     * @return boolean
     */
    function buscaLotacaoPorPessoa($pdo) {
        $retorno = FALSE;
        $idPessoaFisica = $this->getId_pessoa();
        if ($this->getId_pessoa() == 0) {
            $sql = "SELECT id_lotacao, nm_lotacao
            FROM ses_lotacao
            WHERE st_ativo = '1'";
        } else {
            $sql = "SELECT l.id_lotacao, l.nm_lotacao, ca.nm_cargo
                 FROM ses_lotacao l 
                 inner join ses_contrato_lotacao AS cl ON l.id_lotacao = cl.id_lotacao
                 inner join ses_contrato as con ON cl.id_contrato = con.id_contrato
                 inner join ses_pessoa_fisica AS pf ON con.id_pessoa_fisica = pf.id_pessoa_fisica
                 inner join ses_cargo AS ca ON con.id_cargo = ca.id_cargo
                 WHERE pf.id_pessoa = $idPessoaFisica
                 AND l.st_ativo = '1'
                 AND con.st_ativo = '1'";
        }
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

    function retornaNomeCidadeResponsavel($pdo) {

        $this->sucesso = false;

        $sql = " SELECT L.id_lotacao, L.nm_lotacao, C.nm_cidade, P.nm_pessoa"
                . " FROM ses_lotacao L"
                . " INNER JOIN ses_cidade C ON C.id_cidade = L.id_cidade"
                . " left JOIN ses_pessoa P ON P.id_pessoa = L.id_pessoa"
                . " WHERE L.id_lotacao = :idLotacao";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idLotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaPasExiste($pdo) {

        $this->sucesso = false;

        $sql = "SELECT DISTINCT L.id_lotacao, L.nm_lotacao"
                . " FROM ses_lotacao L"
                . " INNER JOIN pla_pas P ON P.id_lotacao = L.id_lotacao"
                . " ORDER BY L.nm_lotacao";

        try {
            $sth = $pdo->prepare($sql);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaLotacaoPeloIdUsuarioCentral(PDO $pdo = null, $id = null) {
        $sql = "select l.id_lotacao, l.nm_lotacao from ses_pessoa as p
				inner join ses_lotacao as l
				on l.id_lotacao = p.id_pessoa
				inner join fin_central_demanda as cd
				on cd.id_lotacao = l.id_lotacao
				where p.id_pessoa = :id";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            $this->sucesso = true;
            $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $this->sucesso = false;
            $this->msgRetorno = "Não encontrou Registros";
        }
    }
    
    public function verificarExistenciaLotacao($pdo) {
        try {
            $sql = $pdo->prepare('  SELECT id_pai, id_lotacao_categoria, nm_lotacao 
                                        FROM ses_lotacao
                                            WHERE id_pai =:idPai AND id_lotacao_categoria =:idLotCat AND nm_lotacao =:nmLotacao');
            $sql->bindValue(':idPai', $this->getId_pai(), PDO::PARAM_INT);
            $sql->bindValue(':idLotCat', $this->getId_lotacao_categoria(), PDO::PARAM_INT);
            $sql->bindValue(':nmLotacao', $this->getNm_lotacao(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
