<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesPessoa.class.php";

class DaoSesPessoa extends SesPessoa {

    function insert($pdo) {
        try {
            $sql = "INSERT INTO ses_pessoa (nm_pessoa, id_naturalidade, ds_logradouro, ds_bairro, ds_complemento, nr_cep, id_cidade, nr_telefone_residencial, nr_telefone_celular, nm_email, nm_senha, ds_observacao, nr_numero) 
                    VALUES (:nm_pessoa, :id_naturalidade, :ds_logradouro, :ds_bairro, :ds_complemento, :nr_cep, :id_cidade, :nr_telefone_residencial, :nr_telefone_celular, :nm_email, :nm_senha, :ds_observacao, :nr_numero)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":nm_pessoa", $this->getNmPessoa() === '' ? null : $this->getNmPessoa(), PDO::PARAM_STR);
            $result->bindValue(":id_naturalidade", $this->getIdNaturalidade(), PDO::PARAM_INT);
            $result->bindValue(":ds_logradouro", $this->getDsLogradouro() === '' ? null : $this->getDsLogradouro(), PDO::PARAM_STR);
            $result->bindValue(":ds_bairro", $this->getDsBairro() === '' ? null : $this->getDsBairro(), PDO::PARAM_STR);
            $result->bindValue(":ds_complemento", $this->getDsComplemento() === '' ? null : $this->getDsComplemento(), PDO::PARAM_STR);
            $result->bindValue(":nr_cep", $this->getNrCep() === '' ? null : $this->getNrCep(), PDO::PARAM_STR);
            $result->bindValue(":nr_numero", $this->getNrNumero(), PDO::PARAM_INT);
            $result->bindValue(":id_cidade", $this->getIdCidade(), PDO::PARAM_INT);
            $result->bindValue(":nr_telefone_residencial", $this->getNrTelefoneResidencial() === '' ? null : $this->getNrTelefoneResidencial(), PDO::PARAM_STR);
            $result->bindValue(":nr_telefone_celular", $this->getNrTelefoneCelular() === '' ? null : $this->getNrTelefoneCelular(), PDO::PARAM_STR);
            $result->bindValue(":nm_email", $this->getNmEmail() === '' ? null : $this->getNmEmail(), PDO::PARAM_STR);
            $result->bindValue(":nm_senha", $this->getNmSenha() === '' ? null : $this->getNmSenha(), PDO::PARAM_STR);
            $result->bindValue(":ds_observacao", $this->getDsObservacao() === '' ? null : $this->getDsObservacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * atualiza pessoa
     * @param type $pdo
     * @return string
     */

    function update($pdo) {
        try {
            $sql = "UPDATE ses_pessoa 
                        set 
                            nm_pessoa = :nm_pessoa, 
                            id_naturalidade = :id_naturalidade, 
                            ds_logradouro = :ds_logradouro, 
                            ds_bairro = :ds_bairro, 
                            ds_complemento = :ds_complemento, 
                            nr_cep = :nr_cep, 
                            id_cidade = :id_cidade, 
                            nr_telefone_residencial = :nr_telefone_residencial, 
                            nr_telefone_celular = :nr_telefone_celular, 
                            nm_email = :nm_email, 
                            ds_observacao = :ds_observacao 
                    where id_pessoa = :id_pessoa";
            $result = $pdo->prepare($sql);
            $result->bindValue(":nm_pessoa", $this->getNmPessoa() === '' ? null : $this->getNmPessoa(), PDO::PARAM_STR);
            $result->bindValue(":id_naturalidade", $this->getIdNaturalidade(), PDO::PARAM_INT);
            $result->bindValue(":ds_logradouro", $this->getDsLogradouro() === '' ? null : $this->getDsLogradouro(), PDO::PARAM_STR);
            $result->bindValue(":ds_bairro", $this->getDsBairro() === '' ? null : $this->getDsBairro(), PDO::PARAM_STR);
            $result->bindValue(":ds_complemento", $this->getDsComplemento() === '' ? null : $this->getDsComplemento(), PDO::PARAM_STR);
            $result->bindValue(":nr_cep", $this->getNrCep() === '' ? null : $this->getNrCep(), PDO::PARAM_STR);
            $result->bindValue(":id_cidade", $this->getIdCidade(), PDO::PARAM_INT);
            $result->bindValue(":nr_telefone_residencial", $this->getNrTelefoneResidencial() === '' ? null : $this->getNrTelefoneResidencial(), PDO::PARAM_STR);
            $result->bindValue(":nr_telefone_celular", $this->getNrTelefoneCelular() === '' ? null : $this->getNrTelefoneCelular(), PDO::PARAM_STR);
            $result->bindValue(":nm_email", $this->getNmEmail() === '' ? null : $this->getNmEmail(), PDO::PARAM_STR);
            $result->bindValue(":ds_observacao", $this->getDsObservacao() === '' ? null : $this->getDsObservacao(), PDO::PARAM_STR);
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * desativa pessoa fisica
     * @param type $pdo
     * @return string
     */

    function upadateStatusPessoa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_pessoa SET st_ativo = :st_ativo 
                                     WHERE id_pessoa = :idPessoa");
            $result->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }
    //***************************************
    function deletePessoa($pdo) {
        try {
            $result = $pdo->prepare("delete from ses_pessoa 
                                     WHERE id_pessoa = :idPessoa");
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
            //return false;
        }
    }

    /**
     * Retorna todos os dados da Pessoa
     * @param type $pdo
     * @return boolean/Array
     */
    function retornaPessoa($pdo) {

        $retorno = FALSE;

        $sql = "SELECT p.id_pessoa, p.nm_pessoa, p.ds_logradouro, p.ds_bairro, p.ds_complemento, p.nr_cep, p.nr_telefone_residencial, p.nr_telefone_celular, p.nm_email, p.ds_observacao, p.nm_senha, p.dh_login, 
                    p.st_login, p.st_ativo, 
                    p.id_naturalidade, en.id_estado id_estado_naturalidade, pn.id_pais id_pais_naturalidade,
                    p.id_cidade id_cidade_endereco, c.id_estado id_estado_endereco, pc.id_pais id_pais_endereco
                FROM ses_pessoa p 
                    left join ses_cidade cn on p.id_naturalidade = cn.id_cidade
                    left join ses_estado en on cn.id_estado = en.id_estado
                    left join ses_pais pn on en.id_pais = pn.id_pais
                    left join ses_cidade c on p.id_cidade = c.id_cidade
                    left join ses_estado ec on c.id_estado = ec.id_estado
                    left join ses_pais pc on ec.id_pais = pc.id_pais
                WHERE id_pessoa = :idPessoa";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
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
     * Através de um e-mail, ele retorna alguns dados da Pessoa
     * @param type $pdo
     * @return boolean/Array
     */
    function logar($pdo) {

        $retorno = FALSE;

        $sql = " SELECT "
                . " id_pessoa, nm_pessoa, st_ativo, nm_senha"
                . " FROM ses_pessoa"
                . " WHERE nm_email = :nmEmail and st_login = '1'";
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
     * Retornar todos os dados do funcionário, cpf matricula e etc.
     * Ainda aguardando o modulo de RH para melhorar isso.
     */

    function retornaTodosFuncionarios($pdo) {

        $retorno = FALSE;

        $sql = " SELECT P.id_pessoa, P.nm_pessoa, P.nm_email"
                . " FROM ses_pessoa P"
                . " where p.id_pessoa in (select id_pessoa from ses_pessoa_fisica)"
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
            echo $e->getMessage();
            return $retorno;
        }
    }

    /**
     * Validar o email da pessoa a cadastar
     * @param type $pdo
     * @return string
     */
    function validarEmail($pdo, $email) {
        $retorno = FALSE;
        $sql = "";
        $idPessoa = $this->getIdPessoa();
        if (empty($this->getIdPessoa())) {
            $sql = " SELECT id_pessoa FROM ses_pessoa  WHERE nm_email = :email and st_ativo = '1'";
        } else {
            $sql = "SELECT id_pessoa FROM ses_pessoa  WHERE nm_email = :email and st_ativo = '1' and id_pessoa <> $idPessoa";
        }

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":email", $email, PDO::PARAM_STR);
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
     * Retorna todos os dados de pessoa 
     * @param type $pdo
     * @return boolean/Array
     */
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

