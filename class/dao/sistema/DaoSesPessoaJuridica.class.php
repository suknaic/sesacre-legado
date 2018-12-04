<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesPessoaJuridica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

class DaoSesPessoaJuridica extends SesPessoaJuridica {

    /**
     * insert tabela ses_pessoa_Juridica
     * @param type $pdo
     * @return "sucesso"
     */
    function insert($pdo) {

        try {
            $sql = "INSERT INTO ses_pessoa_juridica (id_pessoa, id_natureza, nm_fantasia, nr_cnae, nr_safira, nr_cnpj, ds_insc_estadual, ds_insc_municipal,
                                                     dt_fundacao) 
                    VALUES (:id_pessoa, :id_natureza, :nm_fantasia, :nr_cnae, :nr_safira, :nr_cnpj, :ds_insc_estadual, :ds_insc_municipal,
                            :dt_fundacao)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pessoa", $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_natureza", $this->getId_natureza(), PDO::PARAM_INT);
            $result->bindValue(":nm_fantasia", $this->getNm_fantasia() === '' ? null : $this->getNm_fantasia(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnae", $this->getNr_cnae() === '' ? null : $this->getNr_cnae(), PDO::PARAM_STR);
            $result->bindValue(":nr_safira", $this->getNr_safira() === '' ? null : $this->getNr_safira(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnpj", $this->getNr_cnpj() === '' ? null : $this->getNr_cnpj(), PDO::PARAM_STR);
            $result->bindValue(":ds_insc_estadual", $this->getDs_insc_estadual() === '' ? null : $this->getDs_insc_estadual(), PDO::PARAM_STR);
            $result->bindValue(":ds_insc_municipal", $this->getDs_insc_municipal() === '' ? null : $this->getDs_insc_municipal(), PDO::PARAM_STR);
            $result->bindValue(":dt_fundacao", $this->getDt_fundacao() === '' ? null : $this->getDt_fundacao(), PDO::PARAM_STR);
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
            $sql = "UPDATE ses_pessoa_juridica 
                    SET
                        id_pessoa = :id_pessoa, 
                        id_natureza = :id_natureza, 
                        nm_fantasia = :nm_fantasia, 
                        nr_cnae = :nr_cnae, 
                        nr_safira = :nr_safira, 
                        nr_cnpj = :nr_cnpj, 
                        ds_insc_estadual = :ds_insc_estadual, 
                        ds_insc_municipal = :ds_insc_municipal,
                        dt_fundacao = :dt_fundacao
                    WHERE id_pessoa_juridica = :id_pessoa_juridica";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pessoa_juridica", $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa", $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_natureza", $this->getId_natureza(), PDO::PARAM_INT);
            $result->bindValue(":nm_fantasia", $this->getNm_fantasia() === '' ? null : $this->getNm_fantasia(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnae", $this->getNr_cnae() === '' ? null : $this->getNr_cnae(), PDO::PARAM_STR);
            $result->bindValue(":nr_safira", $this->getNr_safira() === '' ? null : $this->getNr_safira(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnpj", $this->getNr_cnpj() === '' ? null : $this->getNr_cnpj(), PDO::PARAM_STR);
            $result->bindValue(":ds_insc_estadual", $this->getDs_insc_estadual() === '' ? null : $this->getDs_insc_estadual(), PDO::PARAM_STR);
            $result->bindValue(":ds_insc_municipal", $this->getDs_insc_municipal() === '' ? null : $this->getDs_insc_municipal(), PDO::PARAM_STR);
            $result->bindValue(":dt_fundacao", $this->getDt_fundacao() === '' ? null : $this->getDt_fundacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function listaPessoaJuridica($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "SELECT * FROM ses_pessoa_juridica";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return "Não foi encontrado Pessoa juridica";
                }
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return "ErroPDO";
        }
    }

    public function retornaCnpj($pdo = null, SesPessoaJuridica $dados) {
        if ($pdo != null) {
            try {
                $sql = "SELECT nr_cnpj FROM ses_pessoa_juridica WHERE id_pessoa = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id", $dados->getId_pessoa_juridica(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return "Não foi encontrado Pessoa juridica";
                }
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return "ErroPDO";
        }
    }

    //esse metodo e temporario ate criar o da pessoa fisica
    public function retornaPessoaFisica($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT p.id_pessoa, p.nm_pessoa
                        FROM ses_pessoa as p
                        INNER JOIN ses_pessoa_fisica as pf
                        on pf.id_pessoa = p.id_pessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return "Não foi encontrado Pessoa fisica";
                }
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function retornaPessoaJuridicaCadastrada($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select DISTINCT ON (p.id_pessoa) p.id_pessoa, p.nm_pessoa, pj.nr_cnpj, f.id_fornecedor 
                        from ses_pessoa as p
                        inner join ses_pessoa_juridica as pj
                        on pj.id_pessoa = p.id_pessoa
                        inner join fin_fornecedor  as f
                        on f.id_pessoa = p .id_pessoa ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return "Não foi encontrado Pessoa fisica";
                }
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * desativa pessoa juridica
     * @param type $pdo
     * @return string
     */

    //************************************************************************************************************************
    function retornaTrPessoaJuridica($pdo, $filtro) {

        $retorno = FALSE;
        $sql = "select PJ.nr_cnpj, P.id_pessoa, PJ.id_pessoa_juridica,
                P.nm_pessoa, P.nm_email, P.nr_telefone_residencial, P.nr_telefone_celular, P.ds_logradouro, P.ds_bairro,  P.st_ativo,
                p.id_cidade, ci.nm_cidade, e.nm_sigla
                from ses_pessoa P
                inner join ses_pessoa_juridica PJ on P.id_pessoa = PJ.id_pessoa
                left join ses_cidade ci on p.id_cidade = ci.id_cidade
                left join ses_estado e on ci.id_estado = e.id_estado
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
    function retornaTrPessoaJuridicaAtivos($pdo, $filtro) {

        $retorno = FALSE;
        $sql = "select PJ.nr_cnpj, PJ.id_natureza,  PJ.id_pessoa_juridica, PJ.nm_fantasia, PJ.nr_cnae, PJ.dt_fundacao,n.ds_natureza,P.id_pessoa, P.nm_pessoa, 
                  P.nm_email, P.nr_telefone_residencial, P.nr_telefone_celular, P.ds_logradouro, P.ds_bairro, P.id_cidade, P.st_ativo, ci.nm_cidade, e.nm_sigla
                from ses_pessoa P
                inner join ses_pessoa_juridica PJ on P.id_pessoa = PJ.id_pessoa
                inner join ses_natureza n on PJ.id_natureza = n.id_natureza
                left join ses_cidade ci on p.id_cidade = ci.id_cidade
                left join ses_estado e on ci.id_estado = e.id_estado
                $filtro
                and P.st_ativo = '1'
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
    //*********************************************************************************************************
    public function listaNatureza($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select  id_natureza, ds_natureza, st_ativo
                        from ses_natureza
                        where st_ativo = '1'
                        order by ds_natureza";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Validar o cnpj da pessoa a cadastar
     * @param type $pdo
     * @return true/false
     */
    function validarCnpj($pdo) {
        $retorno = FALSE;
        $sql = "";
        $idPessoaJuridica = $this->getId_pessoa_juridica();
        if (empty($this->getId_pessoa_juridica())) {
            $sql = "SELECT id_pessoa FROM ses_pessoa_juridica  WHERE nr_cnpj = :cnpj ";
        } else {
            $sql = "SELECT id_pessoa FROM ses_pessoa_juridica  WHERE nr_cnpj = :cnpj and id_pessoa_juridica <> $idPessoaJuridica";
        }

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":cnpj", $this->getNr_cnpj(), PDO::PARAM_STR);
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

    /*
     * remove pessoa Jurídica
     * @param type $pdo
     * @return string
     */

    function deletePessoaJuridica($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_pessoa_juridica 
                                     WHERE id_pessoa_juridica = :idPessoaJuridica");
            $result->bindValue(":idPessoaJuridica", $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e;
            //return false;
        }
    }

    /**
     * Retorna todos os dados da Pessoa
     * @param type $pdo
     * @return boolean/Array
     */
    function retornaPessoaJuridica($pdo) {

        $retorno = FALSE;
        $valor = "";
        try {
            $sql = "select *
                FROM ses_pessoa_juridica 
                WHERE id_pessoa_juridica  = :id";

            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id", $this->getId_pessoa_juridica(), PDO::PARAM_INT);

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

    function retornaPJ($pdo) {
        $retorno = FALSE;
        try {
            $sql = "select id_pessoa_juridica
                     FROM ses_pessoa_juridica 
                      WHERE id_pessoa  = :id";

            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id", $this->getId_pessoa(), PDO::PARAM_INT);

            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

}
