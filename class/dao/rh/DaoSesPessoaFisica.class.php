<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesPessoaFisica.class.php";

class DaoSesPessoaFisica extends SesPessoaFisica {

    /**
     * insert tabela Competencia
     * @param type $pdo
     * @return "sucesso"
     */
    function insertCompetencia($pdo) {
        try {
            $sql = "INSERT INTO ses_competencia (id_pessoa_fisica, id_escolaridade_formacao) 
                    VALUES (:id_pessoa_fisica, :id_escolaridade_formacao)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pessoa_fisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->bindValue(":id_escolaridade_formacao", $this->getId_escolaridade_formacao_competencia(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * insert tabela ses_pessoa_fisica
     * @param type $pdo
     * @return "sucesso"
     */
    function insert($pdo) {

        try {
            $sql = "INSERT INTO ses_pessoa_fisica (id_pessoa, tp_sexo, nm_civil, nr_cpf, nr_rg, ds_orgao_expedidor, ds_habilidade, id_estado_orgao_expedidor,
                                id_estado_civil, nm_pai, nm_mae, dt_nascimento, nr_cns, id_escolaridade) 
                    VALUES (:id_pessoa, :tp_sexo, :nm_civil, :nr_cpf, :nr_rg, :ds_orgao_expedidor, :ds_habilidade, :id_estado_orgao_expedidor,
                            :id_estado_civil, :nm_pai, :nm_mae, :dt_nascimento, :nr_cns, :id_escolaridade)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pessoa", $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":tp_sexo", $this->getTp_sexo(), PDO::PARAM_STR);
            $result->bindValue(":nm_civil", $this->getNm_civil() === '' ? null : $this->getNm_civil(), PDO::PARAM_STR);
            $result->bindValue(":nr_cpf", $this->getNr_cpf() === '' ? null : $this->getNr_cpf(), PDO::PARAM_STR);
            $result->bindValue(":nr_rg", $this->getNr_rg() === '' ? null : $this->getNr_rg(), PDO::PARAM_STR);
            $result->bindValue(":ds_orgao_expedidor", $this->getDs_orgao_expedidor() === '' ? null : $this->getDs_orgao_expedidor(), PDO::PARAM_STR);
            $result->bindValue(":ds_habilidade", $this->getDs_habilidade() === '' ? null : $this->getDs_habilidade(), PDO::PARAM_STR);
            $result->bindValue(":id_estado_orgao_expedidor", $this->getId_estado_expedidor(), PDO::PARAM_INT);
            $result->bindValue(":id_estado_civil", $this->getId_estado_civil() === '0' ? null : $this->getId_estado_civil(), PDO::PARAM_INT);
            $result->bindValue(":nm_pai", $this->getNm_pai() === '' ? null : $this->getNm_pai(), PDO::PARAM_STR);
            $result->bindValue(":nm_mae", $this->getNm_mae() === '' ? null : $this->getNm_mae(), PDO::PARAM_STR);
            $result->bindValue(":dt_nascimento", $this->getDt_nascimento() === '' ? null : $this->getDt_nascimento(), PDO::PARAM_STR);
            $result->bindValue(":nr_cns", $this->getNr_cns() === '' ? null : $this->getNr_cns(), PDO::PARAM_STR);
            $result->bindValue(":id_escolaridade", $this->getId_escolaridade_formacao() === '0' ? null : $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * update tabela ses_pessoa_fisica
     * @param type $pdo
     * @return "sucesso"
     */
    function update($pdo) {

        try {
            $sql = "UPDATE ses_pessoa_fisica 
                    SET
                        id_pessoa = :id_pessoa, 
                        tp_sexo = :tp_sexo, 
                        nm_civil = :nm_civil, 
                        nr_cpf = :nr_cpf, 
                        nr_rg = :nr_rg, 
                        ds_orgao_expedidor = :ds_orgao_expedidor, 
                        ds_habilidade = :ds_habilidade, 
                        id_estado_orgao_expedidor = :id_estado_orgao_expedidor,
                        id_estado_civil = :id_estado_civil, 
                        nm_pai = :nm_pai, 
                        nm_mae = :nm_mae, 
                        dt_nascimento = :dt_nascimento, 
                        nr_cns = :nr_cns, 
                        id_escolaridade = :id_escolaridade
                    WHERE id_pessoa_fisica = :id_pessoa_fisica";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pessoa", $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":tp_sexo", $this->getTp_sexo(), PDO::PARAM_STR);
            $result->bindValue(":nm_civil", $this->getNm_civil() === '' ? null : $this->getNm_civil(), PDO::PARAM_STR);
            $result->bindValue(":nr_cpf", $this->getNr_cpf() === '' ? null : $this->getNr_cpf(), PDO::PARAM_STR);
            $result->bindValue(":nr_rg", $this->getNr_rg() === '' ? null : $this->getNr_rg(), PDO::PARAM_STR);
            $result->bindValue(":ds_orgao_expedidor", $this->getDs_orgao_expedidor() === '' ? null : $this->getDs_orgao_expedidor(), PDO::PARAM_STR);
            $result->bindValue(":ds_habilidade", $this->getDs_habilidade() === '' ? null : $this->getDs_habilidade(), PDO::PARAM_STR);
            $result->bindValue(":id_estado_orgao_expedidor", $this->getId_estado_expedidor(), PDO::PARAM_INT);
            $result->bindValue(":id_estado_civil", $this->getId_estado_civil() === '0' ? null : $this->getId_estado_civil(), PDO::PARAM_INT);
            $result->bindValue(":nm_pai", $this->getNm_pai() === '' ? null : $this->getNm_pai(), PDO::PARAM_STR);
            $result->bindValue(":nm_mae", $this->getNm_mae() === '' ? null : $this->getNm_mae(), PDO::PARAM_STR);
            $result->bindValue(":dt_nascimento", $this->getDt_nascimento() === '' ? null : $this->getDt_nascimento(), PDO::PARAM_STR);
            $result->bindValue(":nr_cns", $this->getNr_cns() === '' ? null : $this->getNr_cns(), PDO::PARAM_STR);
            $result->bindValue(":id_escolaridade", $this->getId_escolaridade_formacao() === '0' ? null : $this->getId_escolaridade_formacao(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa_fisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Validar o cpf da pessoa a cadastar
     * @param type $pdo
     * @return true/false
     */
    function validarCpf($pdo, $cpf) {
        $retorno = FALSE;
        $sql = "";
        $idPessoaFisica = $this->getId_pessoa_fisica();
        if (empty($this->getId_pessoa_fisica())) {
            $sql = " SELECT id_pessoa FROM ses_pessoa_fisica  WHERE nr_cpf = :cpf ";
        } else {
            $sql = "SELECT id_pessoa FROM ses_pessoa_fisica  WHERE nr_cpf = :cpf and id_pessoa_fisica <> $idPessoaFisica";
        }

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":cpf", $cpf, PDO::PARAM_STR);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return TRUE;
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return true;
        }
    }
    /**
     * Valida aniversario
     * @param type $pdo
     * @return true/false
     */
    function buscaAniversario($pdo) {
        $retorno = FALSE;
        $sql = "";
        $idPessoaFisica = $this->getId_pessoa_fisica();
        $data = $this->getDt_nascimento();
        
            $sql = "SELECT id_pessoa FROM ses_pessoa_fisica 
                    WHERE id_pessoa_fisica = :idPessoaFisica
                    and to_char(dt_nascimento, 'MM-DD') = :data";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPessoaFisica", $idPessoaFisica, PDO::PARAM_INT);
            $sth->bindValue(":data", $data, PDO::PARAM_STR);
            $sth->execute();
            if ($sth->rowCount() > 0) {
                return TRUE;
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return true;
        }
    }

    /**
     * Retorna todos os dados da Pessoa
     * @param type $pdo
     * @return boolean/Array
     */
    function retornaPessoaFisica($pdo) {

        $retorno = FALSE;
        $valor = "";
        try {

            if (empty($this->getId_pessoa_fisica())) {
                $sql = "select *
                FROM ses_pessoa_fisica 
                WHERE nr_cpf  = :cpf";
            } else {
                $sql = "select *
                FROM ses_pessoa_fisica 
                WHERE id_pessoa_fisica  = :id";
            }

            $sth = $pdo->prepare($sql);
            if (empty($this->getId_pessoa_fisica())) {
                $sth->bindValue(":cpf", $this->getNr_cpf(), PDO::PARAM_STR);
            } else {
                $sth->bindValue(":id", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            }


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

    function BuscaPf($pdo) {
        try {

            $sql = "select *
                    FROM ses_pessoa_fisica 
                    WHERE id_pessoa  = :id";

            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id", $this->getId_pessoa(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    /**
     * Retorna todos os dados de competencia de uma pessoa fisica
     * @param type $pdo
     * @return boolean/Array
     */
    function buscaCompetencia($pdo) {

        $sql = "select c.id_competencia, c.id_pessoa_fisica, pf.nm_civil, c.id_escolaridade_formacao, ef.nm_escolaridade_formacao, e.nm_escolaridade
                FROM ses_competencia c
                inner join ses_escolaridade_formacao ef on c.id_escolaridade_formacao = ef.id_escolaridade_formacao
                inner join ses_escolaridade e on ef.id_escolaridade = e.id_escolaridade
                inner join ses_pessoa_fisica pf on c.id_pessoa_fisica = pf.id_pessoa_fisica
                WHERE c.id_competencia  = :idCompetencia";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idCompetencia", $this->getId_competencia(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
            //  return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    /**
     * Retorna todos os dados de competencia de uma pessoa fisica
     * @param type $pdo
     * @return boolean/Array
     */
    function retornaCompetencia($pdo) {

        //$retorno = FALSE;
        $sql = "select c.id_competencia, c.id_pessoa_fisica, c.id_escolaridade_formacao, ef.nm_escolaridade_formacao, e.nm_escolaridade
                FROM ses_competencia c
                inner join ses_escolaridade_formacao ef on c.id_escolaridade_formacao = ef.id_escolaridade_formacao
                inner join ses_escolaridade e on ef.id_escolaridade = e.id_escolaridade
                WHERE c.id_pessoa_fisica  = :idPessoaFisica
                order by 4 ";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPessoaFisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
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
     * Remove Competencia
     * @param type $pdo
     * @return string
     */

    function removerCompetencia($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_competencia  
                                     WHERE id_competencia = :idCompetencia");
            $result->bindValue(":idCompetencia", $this->getId_competencia(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /* Remove Competencias
     * @param type $pdo
     * @return string
     */

    function removerCompetencias($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_competencia  
                                     WHERE id_pessoa_fisica = :idPEssoaFisica");
            $result->bindValue(":idPEssoaFisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /*
     * desativa pessoa fisica
     * @param type $pdo
     * @return string
     */

    function updateStatusPessoaFisica($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_pessoa_fisica SET st_ativo = :st_ativo 
                                     WHERE id_pessoa_fisica = :idPessoaFisica");
            $result->bindValue(":st_ativo", $this->getSt_ativo(), PDO::PARAM_STR);
            $result->bindValue(":idPessoaFisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /*
     * remove pessoa fisica
     * @param type $pdo
     * @return string
     */

    function deletePessoaFisica($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_pessoa_fisica 
                                     WHERE id_pessoa_fisica = :idPessoaFisica");
            $result->bindValue(":idPessoaFisica", $this->getId_pessoa_fisica(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

//*************************************
    function listaEstadocivil($pdo) {

        $retorno = FALSE;

        $sql = "select id_estado_civil,nm_estado_civil from ses_estado_civil";
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

//************************************************************************************************************************
    function retornaTrPessoaFisica($pdo, $filtro) {
        $retorno = FALSE;
        $sql = "select PF.nr_cpf, P.id_pessoa, PF.id_pessoa_fisica, 
                P.nm_pessoa, P.nm_email, P.nr_telefone_residencial, P.nr_telefone_celular, P.ds_logradouro, P.ds_bairro,  P.st_ativo,
                p.id_cidade, ci.nm_cidade, e.nm_sigla
                from ses_pessoa P
                inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                left join ses_cidade ci on p.id_cidade = ci.id_cidade
                left join ses_estado e on ci.id_estado = e.id_estado
                where PF.id_pessoa_fisica in (select id_pessoa_fisica from ses_contrato where st_ativo = '1')
                $filtro
                order by P.nm_pessoa";
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

//************************************************************************************************************************
    function retornaTrPessoaFisicaAtivos($pdo, $filtro) {
        $retorno = FALSE;
        $sql = "select PF.nr_cpf, P.id_pessoa, PF.id_pessoa_fisica, 
                P.nm_pessoa, P.nm_email, P.nr_telefone_residencial, P.nr_telefone_celular, P.ds_logradouro, P.ds_bairro,  P.st_ativo,
                p.id_cidade, ci.nm_cidade, e.nm_sigla
                from ses_pessoa P
                inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                left join ses_cidade ci on p.id_cidade = ci.id_cidade
                left join ses_estado e on ci.id_estado = e.id_estado
                where P.st_ativo = '1' and PF.st_ativo = '1'
                $filtro
                order by P.nm_pessoa";
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

    function buscaEstadoCivilPorPessoa($pdo) {
        $retorno = FALSE;
        $idPessoaFisica = $this->getId_pessoa_fisica();
        if ($this->getId_pessoa_fisica() == 0) {
            $sql = "SELECT id_estado_civil, nm_estado_civil
                        FROM ses_estado_civil
                        WHERE st_ativo = '1'";
        } else {
            $sql = "SELECT ec.id_estado_civil, ec.nm_estado_civil
                 FROM ses_estado_civil ec 
                 INNER JOIN ses_pessoa_fisica AS pf ON ec.id_estado_civil = pf.id_estado_civil
                 WHERE pf.id_pessoa = $idPessoaFisica
                 AND ec.st_ativo = '1'";
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

//************************** temporario ate ser criado a classe de pessoa juridica**************************************
    function listaPessoaJuridica($pdo) {

        $retorno = FALSE;

        $sql = "select pj.id_pessoa_juridica, p.nm_pessoa, pj.nm_fantasia 
                from ses_pessoa p
                inner join ses_pessoa_juridica pj on p.id_pessoa = pj.id_pessoa
                order by p.nm_pessoa";
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

//************************************************************************************************************************
    function retornaPessoaFisicaOption($pdo) {
        $retorno = FALSE;
        $sql = "select PF.*, P.nm_pessoa
                from ses_pessoa P 
                inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                where PF.id_pessoa_fisica in (select id_pessoa_fisica from ses_contrato where st_ativo = '1')
                and P.st_ativo = '1' and PF.st_ativo = '1'
                order by P.nm_pessoa";
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

    function retornaPFOption($pdo) {
        $retorno = FALSE;
        $sql = "select P.id_pessoa, P.nm_pessoa
                from ses_pessoa P 
                inner join ses_pessoa_fisica PF on P.id_pessoa = PF.id_pessoa
                where PF.id_pessoa_fisica in (select id_pessoa_fisica from ses_contrato where st_ativo = '1')
                and P.st_ativo = '1' and PF.st_ativo = '1'
                order by P.nm_pessoa";
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
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

