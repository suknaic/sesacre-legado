<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesContrato.class.php";

class DaoSesContrato extends SesContrato {

    function insert($pdo) {
        try {
            $sql = "INSERT INTO ses_contrato (nr_matricula, dt_admissao, nr_carga_horaria, dt_demissao, id_pessoa_fisica, id_vinculo, id_pessoa_juridica, id_cargo, st_ativo) 
                    VALUES (:nr_matricula, :dt_admissao, :nr_carga_horaria, :dt_demissao, :id_pessoa_fisica, :id_vinculo, :id_pessoa_juridica, :id_cargo, :st_ativo)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":nr_matricula", $this->getNr_matricula() === '' ? null : $this->getNr_matricula(), PDO::PARAM_STR);
            $result->bindValue(":dt_admissao", $this->getDt_admissao() === '' ? null : $this->getDt_admissao(), PDO::PARAM_STR);
            $result->bindValue(":nr_carga_horaria", $this->getNr_carga_horaria() === '' ? null : $this->getNr_carga_horaria(), PDO::PARAM_INT);
            $result->bindValue(":dt_demissao", $this->getDt_demissao() === '' ? null : $this->getDt_demissao(), PDO::PARAM_STR);
            $result->bindValue(":id_pessoa_fisica", $this->getId_pessoa_fisica() === '' ? null : $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->bindValue(":id_vinculo", $this->getId_vinculo() === '' ? null : $this->getId_vinculo(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa_juridica", $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->bindValue(":id_cargo", $this->getId_cargo(), PDO::PARAM_INT);
            $result->bindValue(":st_ativo", $this->getSt_ativo() === '' ? null : $this->getSt_ativo(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $sql = "update ses_contrato 
                           set 
                                nr_matricula = :nr_matricula, 
                                dt_admissao = :dt_admissao, 
                                nr_carga_horaria = :nr_carga_horaria, 
                                dt_demissao = :dt_demissao, 
                                id_pessoa_fisica = :id_pessoa_fisica, 
                                id_vinculo = :id_vinculo, 
                                id_pessoa_juridica = :id_pessoa_juridica, 
                                id_cargo = :id_cargo,
                                st_ativo = :st_ativo
                    where id_contrato = :idContrato";
            $result = $pdo->prepare($sql);
            $result->bindValue(":nr_matricula", $this->getNr_matricula() === '' ? null : $this->getNr_matricula(), PDO::PARAM_STR);
            $result->bindValue(":dt_admissao", $this->getDt_admissao() === '' ? null : $this->getDt_admissao(), PDO::PARAM_STR);
            $result->bindValue(":nr_carga_horaria", $this->getNr_carga_horaria() === '' ? null : $this->getNr_carga_horaria(), PDO::PARAM_INT);
            $result->bindValue(":dt_demissao", $this->getDt_demissao() === '' ? null : $this->getDt_demissao(), PDO::PARAM_STR);
            $result->bindValue(":id_pessoa_fisica", $this->getId_pessoa_fisica() === '' ? null : $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->bindValue(":id_vinculo", $this->getId_vinculo() === '' ? null : $this->getId_vinculo(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa_juridica", $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->bindValue(":id_cargo", $this->getId_cargo(), PDO::PARAM_INT);
            $result->bindValue(":idContrato", $this->getId_contrato(), PDO::PARAM_INT);
            $result->bindValue(":st_ativo", $this->getSt_ativo() === '' ? null : $this->getSt_ativo(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

//*******************************************************************************************************************************************************************
    function removeContrato($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_contrato SET st_ativo = '2' 
                                     WHERE id_contrato = :idContrato");
            $result->bindValue(":idContrato", $this->getId_contrato(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

//*******************************************************************************************************************************************************************
    function insertContratoLotacao($pdo) {

        try {
            $sql = "INSERT INTO ses_contrato_lotacao (carga_horaria_lotacao, id_lotacao, id_funcao, id_contrato, dt_inicio, dt_fim) 
                    VALUES (:carga_horaria_lotacao, :id_lotacao, :id_funcao, :id_contrato, :dt_inicio, :dt_fim)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":carga_horaria_lotacao", $this->getCarga_horaria_lotacao(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $result->bindValue(":id_funcao", $this->getId_funcao(), PDO::PARAM_INT);
            $result->bindValue(":id_contrato", $this->getId_contrato(), PDO::PARAM_INT);
            $result->bindValue(":dt_inicio", $this->getDt_inicio() === '' ? null : $this->getDt_inicio(), PDO::PARAM_STR);
            $result->bindValue(":dt_fim", $this->getDt_fim() === '' ? null : $this->getDt_fim(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

//*******************************************************************************************************************************************************************
    function updateContratoHistorico($pdo) {

        try {
            $sql = "update ses_contrato_historico 
                                            SET 
                                                id_contrato = :id_contrato, 
                                                id_contrato_situacao = :id_contrato_situacao,
                                                dt_inicio = :dt_inicio, 
                                                dt_fim = :dt_fim 
                     where id_contrato_historico = :id";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_contrato", $this->getId_contrato(), PDO::PARAM_INT);
            $result->bindValue(":id_contrato_situacao", $this->getId_contrato_situacao(), PDO::PARAM_INT);
            $result->bindValue(":dt_inicio", $this->getDt_inicio() === '' ? null : $this->getDt_inicio(), PDO::PARAM_STR);
            $result->bindValue(":dt_fim", $this->getDt_fim() === '' ? null : $this->getDt_fim(), PDO::PARAM_STR);
            $result->bindValue(":id", $this->getId_contrato_historico(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

//*******************************************************************************************************************************************************************
    function updateContratoLotacao($pdo) {

        try {
            $sql = "update ses_contrato_lotacao 
                                            SET carga_horaria_lotacao = :carga_horaria_lotacao, 
                                                dt_inicio = :dt_inicio, 
                                                dt_fim = :dt_fim 
                     where id_contrato_lotacao = :id";
            $result = $pdo->prepare($sql);
            $result->bindValue(":carga_horaria_lotacao", $this->getCarga_horaria_lotacao(), PDO::PARAM_INT);
            $result->bindValue(":dt_inicio", $this->getDt_inicio() === '' ? null : $this->getDt_inicio(), PDO::PARAM_STR);
            $result->bindValue(":dt_fim", $this->getDt_fim() === '' ? null : $this->getDt_fim(), PDO::PARAM_STR);
            $result->bindValue(":id", $this->getId_contrato_lotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function insertContratoHistorico($pdo) {

        try {
            $sql = "INSERT INTO ses_contrato_historico (nr_carga_horaria_lotacao, id_lotacao, id_funcao, id_contrato, dt_inicio, dt_fim, ds_observacao, id_contrato_situacao, dt_historico) 
                    VALUES (:carga_horaria_lotacao, :id_lotacao, :id_funcao, :id_contrato, :dt_inicio, :dt_fim, :ds_observacao, :id_contrato_situacao, :data)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":carga_horaria_lotacao", $this->getCarga_horaria_lotacao(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $result->bindValue(":id_funcao", $this->getId_funcao(), PDO::PARAM_INT);
            $result->bindValue(":id_contrato", $this->getId_contrato(), PDO::PARAM_INT);
            $result->bindValue(":dt_inicio", $this->getDt_inicio() === '' ? null : $this->getDt_inicio(), PDO::PARAM_STR);
            $result->bindValue(":dt_fim", $this->getDt_fim() === '' ? null : $this->getDt_fim(), PDO::PARAM_STR);
            $result->bindValue(":ds_observacao", $this->getDs_observacao() === '' ? null : $this->getDs_observacao(), PDO::PARAM_STR);
            $result->bindValue(":id_contrato_situacao", $this->getId_contrato_situacao(), PDO::PARAM_INT);
            $result->bindValue(":data", $this->getDt_historico() === '' ? null : $this->getDt_historico(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*     * falta
     * Retorna todos os dados da Pessoa
     * @param type $pdo
     * @return boolean/Array
     */

    function retornaContratosPessoaFisica($pdo) {

        $sql = "SELECT c.id_contrato, c.nr_matricula, to_char(c.dt_admissao, 'dd/mm/YYYY')dt_admissao, c.nr_carga_horaria, to_char(c.dt_demissao, 'dd/mm/YYYY')dt_demissao, c.id_vinculo, c.id_pessoa_juridica, c.id_cargo
                FROM ses_pessoa p 
                inner join ses_pessoa_fisica pf on P.id_pessoa = pf.id_pessoa
                left join ses_contrato c on pf.id_pessoa_fisica = c.id_pessoa_fisica
                left join ses_contrato_lotacao cl on c.id_contrato = cl.id_contrato
                left join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                where P.st_ativo = '1' and PF.st_ativo = '1'
                and PF.id_pessoa_fisica = :idPessoaFisica";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPessoaFisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
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

    //****************************************************************************************************************************
    function retornaContrato($pdo) {
        $retorno = FALSE;
        if (empty($this->getId_contrato())) {
            $sql = "SELECT *
                    FROM ses_contrato  
                    where id_pessoa_fisica = :id_pessoa_fisica
                    and st_ativo = '1' ";
        } else {
            $sql = "SELECT *
                FROM ses_contrato  
                where id_contrato = :idContrato";
        }

        try {
            $sth = $pdo->prepare($sql);
            if (empty($this->getId_contrato())) {
                $sth->bindValue(":id_pessoa_fisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
                $sth->execute();
                if ($sth->rowCount() >= 1) {
                    return $sth->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return FALSE;
                }
            } else {
                $sth->bindValue(":idContrato", $this->getId_contrato(), PDO::PARAM_INT);
                $sth->execute();
                if ($sth->rowCount() >= 1) {
                    return $sth->fetch(PDO::FETCH_ASSOC);
                } else {
                    return FALSE;
                }
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    //****************************************************************************************************************************
    function buscaCargoPorPessoa($pdo) {
        $retorno = FALSE;
        $idPessoaFisica = $this->getId_pessoa_fisica();
        if ($this->getId_pessoa_fisica() == 0) {
            $sql = "SELECT id_cargo, nm_cargo
                 FROM ses_cargo
                 WHERE st_ativo = '1'";
        } else {
            $sql = "SELECT ca.id_cargo, ca.nm_cargo
                 FROM ses_contrato c 
                 INNER JOIN ses_pessoa_fisica AS pf ON c.id_pessoa_fisica = pf.id_pessoa_fisica
                 INNER JOIN ses_cargo AS ca ON c.id_cargo = ca.id_cargo
                 WHERE pf.id_pessoa = $idPessoaFisica
                 AND c.st_ativo = '1'";
        }
        try {
            $sth = $pdo->prepare($sql);
            //$sth->bindValue(":idPessoa", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
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

    //****************************************************************************************************************************
    function buscaFuncaoPorPessoa($pdo) {
        $retorno = FALSE;
        $idPessoaFisica = $this->getId_pessoa_fisica();
        if ($this->getId_pessoa_fisica() == 0) {
            $sql = "SELECT id_funcao, nm_funcao 
                        FROM ses_funcao
                        WHERE st_ativo = '1'";
        } else {
            $sql = "SELECT f.id_funcao, f.nm_funcao
                 FROM ses_contrato c
                 INNER JOIN ses_pessoa_fisica AS pf ON c.id_pessoa_fisica = pf.id_pessoa_fisica
                 INNER JOIN ses_contrato_lotacao AS cl ON c.id_contrato = cl.id_contrato
                 INNER JOIN ses_funcao AS f ON cl.id_funcao = f.id_funcao
                 WHERE pf.id_pessoa = $idPessoaFisica
                 AND c.st_ativo = '1'";
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

    function buscaVinculoPorPessoa($pdo) {
        $retorno = FALSE;
        $idPessoaFisica = $this->getId_pessoa_fisica();
        if ($this->getId_pessoa_fisica() == 0) {
            $sql = "SELECT id_vinculo, nm_vinculo 
                        FROM ses_vinculo
                        WHERE st_ativo = '1'";
        } else {
            $sql = "SELECT v.id_vinculo, v.nm_vinculo
                 FROM ses_contrato c 
                 inner join ses_pessoa_fisica AS pf ON c.id_pessoa_fisica = pf.id_pessoa_fisica
                 inner join ses_vinculo AS v ON c.id_vinculo = v.id_vinculo
                 WHERE pf.id_pessoa = $idPessoaFisica
                 and c.st_ativo = '1'";
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

//****************************************************************************************************************************
    function retornaContratoHistorico($pdo) {
        $retorno = FALSE;
        $sql = "SELECT *
                    FROM ses_contrato_historico  
                    where id_contrato_historico = :id";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id", $this->getId_contrato_historico(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    //****************************************************************************************************************************
    function retornaContratoLotacao($pdo) {
        $retorno = FALSE;
        $sql = "SELECT *
                    FROM ses_contrato_lotacao  
                    where id_contrato_lotacao = :id";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id", $this->getId_contrato_lotacao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    //*****************************************************************************************************************************
    function retornaTodosFuncionarios($pdo, $filtro, $ferias) {
        $retorno = FALSE;
        $ativo = "";
        if ($ferias) {
            $ativo = "and c.st_ativo = '1'";
        } else {
            $ativo = "and (c.st_ativo = '1' or c.st_ativo = '0')";
        }
        $sql = "SELECT c.id_contrato, c.nr_matricula, c.id_cargo, c.st_ativo, cg.nm_cargo, v.id_vinculo, v.nm_vinculo, 
                       PF.nr_cpf, P.id_pessoa, PF.id_pessoa_fisica, P.nm_pessoa, P.nm_email, P.nr_telefone_residencial, P.nr_telefone_celular, 
                       array_to_string(array_agg(distinct l.nm_lotacao), ', ') as nm_lotacao,
                       array_to_string(array_agg(t.nr_telefone), ', ') as nr_telefone_funcional
                FROM ses_pessoa P 
                    inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                    inner join ses_contrato c on PF.id_pessoa_fisica = c.id_pessoa_fisica
                    inner join ses_contrato_lotacao cl on c.id_contrato = cl.id_contrato
                    inner join ses_vinculo v on c.id_vinculo = v.id_vinculo
                    inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                    inner join ses_cargo cg on c.id_cargo = cg.id_cargo
                    left join ses_telefone t on l.id_lotacao = t.id_lotacao
                where P.st_ativo = '1' and PF.st_ativo = '1'
                $ativo
                $filtro
		group by c.id_contrato, cg.nm_cargo, P.id_pessoa, PF.id_pessoa_fisica, PF.nm_civil, v.id_vinculo
                ORDER BY P.nm_pessoa, c.nr_matricula";

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
    function retornaGrafico($pdo, $filtro, $tipo) {
        $retorno = FALSE;
        $select = "";
        $ativo = "";
        $ordem = "";
        switch ($tipo) {
            case '1':
                $select = "SELECT v.id_vinculo, v.nm_vinculo, count(v.id_vinculo)total_vinculo";
                $agrupar = "group by v.id_vinculo, v.nm_vinculo";
                $ordem = "ORDER BY v.nm_vinculo";
                break;
            case '2':
                $select = "SELECT l.id_lotacao, l.nm_lotacao, count(l.id_lotacao)total_lotacao";
                $agrupar = "group by l.id_lotacao, l.nm_lotacao";
                $ordem = "ORDER BY l.nm_lotacao";
                break;
            case '3':
                $select = "SELECT c.id_contrato, c.id_cargo, cg.nm_cargo, P.id_pessoa, PF.id_pessoa_fisica, P.nm_pessoa, 
                           f.id_funcao, f.nm_funcao, cl.carga_horaria_lotacao";
                $agrupar = "";
                $ordem = "ORDER BY P.nm_pessoa";
                break;
            case '4':
                //  $ordem = "ORDER BY l.nm_lotacao, v.nm_vinculo, cg.nm_cargo, P.nm_pessoa";
                break;
            case '5':
                //  $ordem = "ORDER BY v.nm_vinculo, l.nm_lotacao,cg.nm_cargo, P.nm_pessoa";
                break;
        }
        $sql = "$select
                FROM ses_pessoa P 
                    inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                    inner join ses_contrato c on PF.id_pessoa_fisica = c.id_pessoa_fisica
                    inner join ses_pessoa_juridica PJ on c.id_pessoa_juridica = PJ.id_pessoa_juridica
                    inner join ses_contrato_lotacao cl on c.id_contrato = cl.id_contrato
                    inner join ses_vinculo v on c.id_vinculo = v.id_vinculo
                    inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                    inner join ses_cargo cg on c.id_cargo = cg.id_cargo
                    left join ses_funcao f on cl.id_funcao = f.id_funcao
                where c.st_ativo = '1' and P.st_ativo = '1' and PF.st_ativo = '1'
                $filtro
                $agrupar
                $ordem";
        //print_r($sql);

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
    function retornaRelatorioVinculos($pdo, $filtro, $tipo) {
        $retorno = FALSE;
        $ativo = "";
        $ordem = "";
        switch ($tipo) {
            case '1':
                $ordem = "ORDER BY cg.nm_cargo, l.nm_lotacao, v.nm_vinculo, P.nm_pessoa";
                break;
            case '2':
                $ordem = "ORDER BY PJ.nm_fantasia, l.nm_lotacao, v.nm_vinculo, cg.nm_cargo, P.nm_pessoa";
                break;
            case '3':
                $ordem = "ORDER BY f.nm_funcao, l.nm_lotacao, v.nm_vinculo, P.nm_pessoa";
                break;
            case '4':
                $ordem = "ORDER BY l.nm_lotacao, v.nm_vinculo, cg.nm_cargo, P.nm_pessoa";
                break;
            case '5':
                $ordem = "ORDER BY v.nm_vinculo, l.nm_lotacao,cg.nm_cargo, P.nm_pessoa";
                break;
        }
        $sql = "SELECT c.id_contrato, c.nr_matricula, c.id_cargo, cg.nm_cargo, v.id_vinculo, v.nm_vinculo, 
                       P.id_pessoa, PF.id_pessoa_fisica, P.nm_pessoa, P.nm_email, l.id_lotacao,
                       l.nm_lotacao, f.id_funcao, f.nm_funcao, cl.carga_horaria_lotacao, PJ.id_pessoa_juridica, PJ.nm_fantasia
                FROM ses_pessoa P 
                    inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                    inner join ses_contrato c on PF.id_pessoa_fisica = c.id_pessoa_fisica
                    inner join ses_pessoa_juridica PJ on c.id_pessoa_juridica = PJ.id_pessoa_juridica
                    inner join ses_contrato_lotacao cl on c.id_contrato = cl.id_contrato
                    inner join ses_vinculo v on c.id_vinculo = v.id_vinculo
                    inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                    inner join ses_cargo cg on c.id_cargo = cg.id_cargo
                    left join ses_funcao f on cl.id_funcao = f.id_funcao
                where P.st_ativo = '1' and PF.st_ativo = '1'
                and c.st_ativo = '1'
                $filtro
                $ordem";
        //print_r($sql);

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
    function retornaRelatorioSituacao($pdo, $filtro, $tipo) {
        $retorno = FALSE;
        $ativo = "";
        $ordem = "";
        switch ($tipo) {
            case '1':
                $ordem = "ORDER BY cs.nm_contrato_situacao, l.nm_lotacao, v.nm_vinculo, c.id_contrato, p.nm_pessoa, dt_inicio";
                break;
            case '2':
                $ordem = "ORDER BY cs.nm_contrato_situacao, v.nm_vinculo, l.nm_lotacao, c.id_contrato, p.nm_pessoa, dt_inicio";
                break;
            
        }
        $sql = "select 
                        c.nr_matricula, c.id_contrato, cs.id_contrato_situacao, cs.nm_contrato_situacao, l.id_lotacao, l.nm_lotacao, v.id_vinculo, v.nm_vinculo, p.nm_pessoa, 
			cg.id_cargo, cg.nm_cargo, to_char(ch.dt_inicio, 'dd/mm/YYYY')dt_inicio, to_char(ch.dt_fim, 'dd/mm/YYYY')dt_fim, (ch.dt_fim-ch.dt_inicio)dias,
                        ch.ds_observacao
                    from ses_contrato_historico ch
                    inner join ses_contrato c on ch.id_contrato = c.id_contrato
                    inner join ses_vinculo v on v.id_vinculo = c.id_vinculo
                    inner join ses_cargo cg on cg.id_cargo = c.id_cargo
                    inner join ses_contrato_situacao cs on cs.id_contrato_situacao = ch.id_contrato_situacao
                    inner join ses_contrato_lotacao cl on c.id_contrato = cl.id_contrato
                    inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                    inner join ses_pessoa_fisica pf on c.id_pessoa_fisica = pf.id_pessoa_fisica
                    inner join ses_pessoa p on pf.id_pessoa = p.id_pessoa
                    where c.st_ativo = '1'
                $filtro
                $ordem";
        //print_r($sql);

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
    //*******************************************************************************
    function retornaRelatorioCompetencia($pdo, $filtro) {
        $retorno = FALSE;

        $sql = "SELECT c.id_contrato, c.nr_matricula, c.id_cargo, cg.nm_cargo, v.id_vinculo, v.nm_vinculo, 
                       P.id_pessoa, PF.id_pessoa_fisica, P.nm_pessoa, P.nm_email, l.id_lotacao,
                       l.nm_lotacao, f.id_funcao, f.nm_funcao, cl.carga_horaria_lotacao, PJ.id_pessoa_juridica, PJ.nm_fantasia, e.nm_escolaridade, ef.nm_escolaridade_formacao
                FROM ses_pessoa P 
                    inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                    inner join ses_contrato c on PF.id_pessoa_fisica = c.id_pessoa_fisica
                    inner join ses_pessoa_juridica PJ on c.id_pessoa_juridica = PJ.id_pessoa_juridica
                    inner join ses_contrato_lotacao cl on c.id_contrato = cl.id_contrato
                    inner join ses_vinculo v on c.id_vinculo = v.id_vinculo
                    inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                    inner join ses_cargo cg on c.id_cargo = cg.id_cargo
                    left join ses_funcao f on cl.id_funcao = f.id_funcao
                    left join ses_competencia co on PF.id_pessoa_fisica = co.id_pessoa_fisica
                    left join ses_escolaridade_formacao ef on co.id_escolaridade_formacao = ef.id_escolaridade_formacao
                    left join ses_escolaridade e on ef.id_escolaridade = e.id_escolaridade
                where P.st_ativo = '1' and PF.st_ativo = '1'
                $filtro
                ORDER BY v.nm_vinculo, l.nm_lotacao, cg.nm_cargo, P.nm_pessoa";
        //print_r($sql);

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
    function retornarHistorico($pdo) {
        $sql = "select 
                        ch.id_contrato_historico, v.id_vinculo, v.nm_vinculo, cg.id_cargo, cg.nm_cargo, to_char(ch.dt_inicio, 'dd/mm/YYYY')dt_inicio, to_char(ch.dt_fim, 'dd/mm/YYYY')dt_fim,
                        ch.ds_observacao, cs.id_contrato_situacao, cs.nm_contrato_situacao
                    from ses_contrato_historico ch
                    inner join ses_contrato c on ch.id_contrato = c.id_contrato
                    inner join ses_vinculo v on v.id_vinculo = c.id_vinculo
                    inner join ses_cargo cg on cg.id_cargo = c.id_cargo
                    inner join ses_contrato_situacao cs on cs.id_contrato_situacao = ch.id_contrato_situacao
                    where c.id_contrato = :idContrato
                    order by dt_inicio asc";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idContrato", $this->getId_contrato(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    //*****************************************************************************************************************************
    function retornaLotacaoFuncao($pdo) {

        $sql = "select 
                    cl.id_contrato_lotacao, cl.id_lotacao, cl.id_funcao, cl.id_contrato, cl.carga_horaria_lotacao, to_char(cl.dt_inicio, 'dd/mm/YYYY')dt_inicio, to_char(cl.dt_fim, 'dd/mm/YYYY')dt_fim,
                    c.id_pessoa_fisica,
                    l.nm_lotacao,
                    f.nm_funcao 
                from ses_contrato_lotacao cl
                inner join ses_contrato c on cl.id_contrato = c.id_contrato
                inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                inner join ses_funcao f on cl.id_funcao = f.id_funcao
                where c.id_contrato = :idContrato
                order by dt_inicio asc";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idContrato", $this->getId_contrato(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    //*******************************************************************************************************************************
    function buscaLotacaoFuncao($pdo) {

        $sql = "select 
                    cl.id_contrato_lotacao, cl.id_lotacao, cl.id_funcao, cl.id_contrato, cl.carga_horaria_lotacao, to_char(cl.dt_inicio, 'dd/mm/YYYY')dt_inicio, to_char(cl.dt_fim, 'dd/mm/YYYY')dt_fim,
                    c.id_pessoa_fisica,
                    l.nm_lotacao,
                    f.nm_funcao 
                from ses_contrato_lotacao cl
                inner join ses_contrato c on cl.id_contrato = c.id_contrato
                inner join ses_lotacao l on cl.id_lotacao = l.id_lotacao
                inner join ses_funcao f on cl.id_funcao = f.id_funcao
                where cl.id_contrato_lotacao = :id_contrato_lotacao";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id_contrato_lotacao", $this->getId_contrato_lotacao(), PDO::PARAM_INT);
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
     * Remove contrato Lotacao
     * @param type $pdo
     * @return string
     */

    function removerContratoHistorico($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_contrato_historico
                                     WHERE id_contrato_historico = :id");
            $result->bindValue(":id", $this->getId_contrato_historico(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /*
     * Remove contrato Lotacao
     * @param type $pdo
     * @return string
     */

    function removerContratoLotacao($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_contrato_lotacao  
                                     WHERE id_contrato_lotacao = :idContratoLotacao");
            $result->bindValue(":idContratoLotacao", $this->getId_contrato_lotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    //******************************************************************************************************************************
    /**
     * Através de um e-mail, ele retorna alguns dados da Pessoa
     * @param type $pdo
     * @return boolean/Array
     */
    function logar($pdo) {

        $retorno = FALSE;

        $sql = " SELECT "
                . " id_pessoa, nm_pessoa, st_ativo, nm_senha"
                . " FROM ses_pessoa"
                . " WHERE nm_email = :nmEmail";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmEmail", $this->getNmEmail(), PDO::PARAM_STR);
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
     * Muda a Senha de uma Pessoa
     * @param type $pdo
     * @return string
     */
    function mudarSenha($pdo) {

        try {

            $result = $pdo->prepare("UPDATE ses_pessoa SET nm_senha = :nmSenha "
                    . " WHERE id_pessoa = :idPessoa ");
            $result->bindValue(":nmSenha", $this->getNmSenha(), PDO::PARAM_STR);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_STR);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /**
     * Atualiza o ultimo horário do login da Pessoa
     * @param type $pdo
     * @return string
     */
    function salvaHorarioLogin($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_pessoa SET dh_login = :dhLogin "
                    . " WHERE id_pessoa = :idPessoa ");
            $result->bindValue(":dhLogin", $this->getDhLogin(), PDO::PARAM_STR);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /**
     * Verifica se a Data do ultimo login é realmente essa que está tentando acessar o sistema
     * @param type $idPessoa
     * @param type $data
     * @param type $pdo
     * @return boolean
     */
    function verificaUltimoLogin($idPessoa, $data, $pdo) {
        $retorno = FALSE;

        $sql = " SELECT id_pessoa"
                . " FROM ses_pessoa"
                . " WHERE id_pessoa = :idPessoa"
                . " AND dh_login = :dhLogin";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPessoa", $idPessoa, PDO::PARAM_INT);
            $sth->bindValue(":dhLogin", $data, PDO::PARAM_STR);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return TRUE;
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return $retorno;
        }
    }

    /*
     * Retornar todos os dados da Situação, 
     */

    function retornaSituacao($pdo) {

        $retorno = FALSE;

        $sql = " SELECT id_contrato_situacao, nm_contrato_situacao, tp_situacao
                 FROM ses_contrato_situacao
                 ORDER BY tp_situacao, nm_contrato_situacao";
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
     * Retorna lotaçoes do usuario por central
     */
    public function retornaLotacaoCentral(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = 'select DISTINCT(l.id_lotacao), l.id_lotacao, nm_lotacao
                        from ses_pessoa as p
                        inner join ses_pessoa_fisica as pf
                        on pf.id_pessoa = p.id_pessoa
                        inner join ses_contrato as ct
                        on ct.id_pessoa_fisica = pf.id_pessoa_fisica
                        inner join ses_contrato_lotacao  as cl
                        on ct.id_contrato = ct.id_contrato
                        inner join fin_central_demanda  as cd
                        on cd.id_lotacao = cl.id_lotacao
                        inner join ses_lotacao as l
                        on l.id_lotacao = cd.id_lotacao
                        where p.id_pessoa = :id';
                $sth = $pdo->prepare($sql);
                $sth->bindValue(":id", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
                $sth->execute();
                if ($sth->rowCount() >= 1) {
                    return $sth->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return false;
                }
            } else {
                return false;
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function retornaTodasPessoas(PDO $pdo = null) {

        $retorno = FALSE;

        $sql = " SELECT DISTINCT P.id_pessoa, P.nm_pessoa, P.nm_email"
                . " FROM ses_contrato C"
                . " INNER JOIN ses_pessoa_fisica PF ON PF.id_pessoa_fisica = C.id_pessoa_fisica"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = PF.id_pessoa"
                . " WHERE P.st_ativo = '1' = C.st_ativo ='1'"
                . " ORDER BY P.nm_pessoa";
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
            //echo $e->getMessage();
            return $retorno;
        }
    }
    //*********************************************************
        function retornaAnoSituacao(PDO $pdo = null) {

        $retorno = FALSE;

        $sql = "select distinct to_char(dt_inicio, 'YYYY')ano from ses_contrato_historico 
                where id_contrato_situacao is not null 
                order by ano desc";
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
            //echo $e->getMessage();
            return $retorno;
        }
    }
//******************************************************
    function retornaPessoaFuncoes(PDO $pdo = null) {
        $retorno = false;

        $sql = "select f.id_funcao, f.nm_funcao "
                . "from ses_contrato_lotacao cl, ses_funcao f, ses_contrato cnt, ses_pessoa_fisica pf "
                . "where pf.id_pessoa = :id_pessoa_fisica "
                . "and cnt.id_pessoa_fisica = pf.id_pessoa_fisica "
                . "and cl.id_contrato = cnt.id_contrato "
                . "and cl.id_funcao = f.id_funcao "
                . "and cl.dt_fim is null";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_pessoa_fisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);

            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            return $retorno;
        }
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

