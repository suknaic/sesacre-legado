<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaChamado.class.php";

class DaoChaChamado extends ChaChamado {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_chamado (id_categoria_secundaria, id_pessoa_solicitante, id_pessoa_servico,
                                                    dh_abertura, ds_chamado, nr_telefone_solicitante, ds_finalizado, dh_finalizado, nr_avaliacao,
                                                    dh_avaliacao, ds_avaliacao, vl_chamado,  id_status, dh_agendamento, id_prioridade, dh_cancelamento,
                                                    ds_cancelamento, dt_prazo)
                                                    VALUES (:idCategoriaSecundaria, :idPessoaSolicitante, :idPessoaServico, :data, :dsChamado, :nrTelefoneSolicitante, :dsFinalizado, :data, :nrAvaliacao,
                                                    :data, :dsAvaliacao, :vlChamado, :idStatus, :dhAgendamento, :idPrioridade, :data, :dsCancelamento, :dtPrazo)");
            $result->bindValue(":idCategoriaSecundaria", $this->getIdCategoriaSecundaria() === '' ? null : $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $result->bindValue(":idPessoaSolicitante", $this->getIdPessoaSolicitante() === '' ? null : $this->getIdPessoaSolicitante(), PDO::PARAM_INT);
            $result->bindValue(":idPessoaServico", $this->getIdPessoaServico() === '' ? null : $this->getIdPessoaServico(), PDO::PARAM_INT);
            $result->bindValue(":data", $this->getDhAbertura() === '' ? null : $this->getDhAbertura(), PDO::PARAM_STR);
            $result->bindValue(":dsChamado", $this->getDsChamado() === '' ? null : $this->getDsChamado(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefoneSolicitante", $this->getNrTelefoneSolicitante() === '' ? null : $this->getNrTelefoneSolicitante(), PDO::PARAM_STR);
            $result->bindValue(":dsFinalizado", $this->getDsFinalizado() === '' ? null : $this->getDsFinalizado(), PDO::PARAM_STR);
            $result->bindValue(":data", $this->getDhFinalizado() === '' ? null : $this->getDhFinalizado(), PDO::PARAM_STR);
            $result->bindValue(":nrAvaliacao", $this->getNrAvaliacao() === '' ? null : $this->getNrAvaliacao(), PDO::PARAM_INT);
            $result->bindValue(":data", $this->getDhAvaliacao() === '' ? null : $this->getDhAvaliacao(), PDO::PARAM_STR);
            $result->bindValue(":dsAvaliacao", $this->getDsAvaliacao() === '' ? null : $this->getDsAvaliacao(), PDO::PARAM_STR);
            $result->bindValue(":vlChamado", $this->getVlChamado() === '' ? null : $this->getVlChamado(), PDO::PARAM_INT);
            $result->bindValue(":idStatus", $this->getIdStatus() === '' ? null : $this->getIdStatus(), PDO::PARAM_INT);
            $result->bindValue(":dhAgendamento", $this->getDhAgendamento() === '' ? null : $this->getDhAgendamento(), PDO::PARAM_STR);
            $result->bindValue(":idPrioridade", $this->getIdPrioridade() === '' ? null : $this->getIdPrioridade(), PDO::PARAM_INT);
            $result->bindValue(":data", $this->getDhCancelamento() === '' ? null : $this->getDhCancelamento(), PDO::PARAM_STR);
            $result->bindValue(":dsCancelamento", $this->getDsCancelamento() === '' ? null : $this->getDsCancelamento(), PDO::PARAM_STR);
            $result->bindValue(":dtPrazo", $this->getDtPrazo() === '' ? null : $this->getDtPrazo(), PDO::PARAM_STR);

            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_chamado SET id_categoria_secundaria = :idCategoriaSecundaria "
                    . " , id_pessoa_servico = :idPessoaServico , ds_chamado = :dsChamado"
                    . " , nr_telefone_solicitante = :nrTelefoneSolicitante , id_status = :idStatus, dh_agendamento = :dhAgendamento, id_prioridade = :idPrioridade, dt_prazo = :dtPrazo "
                    . " WHERE id_chamado = :idChamado ");
            $result->bindValue(":idChamado", $this->getIdChamado() === '' ? null : $this->getIdChamado(), PDO::PARAM_INT);
            $result->bindValue(":idCategoriaSecundaria", $this->getIdCategoriaSecundaria() === '' ? null : $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $result->bindValue(":idPessoaServico", $this->getIdPessoaServico() === '' ? null : $this->getIdPessoaServico(), PDO::PARAM_INT);
            $result->bindValue(":dsChamado", $this->getDsChamado() === '' ? null : $this->getDsChamado(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefoneSolicitante", $this->getNrTelefoneSolicitante() === '' ? null : $this->getNrTelefoneSolicitante(), PDO::PARAM_STR);
            $result->bindValue(":idStatus", $this->getIdStatus() === '' ? null : $this->getIdStatus(), PDO::PARAM_INT);
            $result->bindValue(":dhAgendamento", $this->getDhAgendamento() === '' ? null : $this->getDhAgendamento(), PDO::PARAM_STR);
            $result->bindValue(":idPrioridade", $this->getIdPrioridade() === '' ? null : $this->getIdPrioridade(), PDO::PARAM_INT);
            $result->bindValue(":dtPrazo", $this->getDtPrazo() === '' ? null : $this->getDtPrazo(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_chamado WHERE id_chamado = :idChamado");
            $result->bindValue(":idChamado", $this->getIdChamado(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_chamado SET st_ativo = 0 "
                    . "WHERE id_chamado = :idChamado ");
            $result->bindValue(":idChamado", $this->getIdChamado(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function cancela($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_chamado 
                                                        SET id_status = 2
                                                        WHERE id_chamado = :idChamado ");
            $result->bindValue(":idChamado", $this->getIdChamado(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaChamados($pdo) {

        $sql = "SELECT c.id_chamado, c.nr_matricula, to_char(c.dt_admissao, 'dd/mm/YYYY')dt_admissao, c.nr_carga_horaria, to_char(c.dt_demissao, 'dd/mm/YYYY')dt_demissao, c.id_vinculo, c.id_pessoa_juridica, c.id_cargo
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

    /**
     * Retorna todas as Informações dos Chamados
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosChamados($pdo, $filtro) {

        $retorno = FALSE;
        $sql = "SELECT cha.id_chamado, fs.id_form_sistema, ps.nm_pessoa as nm_solicitante, t.id_categoria_tipo, t.nm_categoria_tipo, l.nm_lotacao, cp.nm_categoria_primaria, cs.nm_categoria_secundaria,
        pa.nm_pessoa as nm_atendimento, cha.dh_abertura, cha.dh_agendamento, s.nm_status
        FROM cha_chamado AS cha
        INNER JOIN cha_categoria_secundaria AS cs ON cs.id_categoria_secundaria = cha.id_categoria_secundaria
        INNER JOIN cha_categoria_primaria AS cp ON cs.id_categoria_primaria = cp.id_categoria_primaria
        INNER JOIN cha_categoria_tipo AS t ON cp.id_categoria_tipo = t.id_categoria_tipo
        INNER JOIN cha_categoria_principal AS cpri ON t.id_categoria_principal = cpri.id_categoria_principal
        INNER JOIN ses_pessoa AS ps ON cha.id_pessoa_solicitante = ps.id_pessoa
        LEFT JOIN cha_pessoa_atendimento AS chpa ON cha.id_chamado = chpa.id_chamado
        LEFT JOIN ses_pessoa AS pa ON chpa.id_pessoa = pa.id_pessoa
        INNER JOIN cha_status AS s ON cha.id_status = s.id_status
        INNER JOIN cha_form_sistema AS fs ON cha.id_chamado = fs.id_chamado
        INNER JOIN ses_lotacao AS l ON fs.id_lotacao = l.id_lotacao
        WHERE cha.id_pessoa_solicitante = :id
        $filtro
        ORDER BY cha.dh_abertura";
        
        $result = $pdo->prepare($sql);
        print_r($sql);
        $result->bindValue(":id", $this->getIdPessoaSolicitante(), PDO::PARAM_INT);
        $result->execute();
        if ($result->rowCount() >= 1) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return FALSE;
        }
    }

//    /**
//     * Retorna todas as Informações dos Chamados
//     * @param type $pdo
//     * @return boolean
//     */
//    function retornaTodosChamados($pdo) {
//
//        $retorno = FALSE;
//
//        $result = $pdo->prepare("SELECT cha.id_chamado, ps.nm_pessoa as nm_solicitante, t.id_categoria_tipo, t.nm_categoria_tipo, l.nm_lotacao, cp.nm_categoria_primaria, cs.nm_categoria_secundaria,
//        pa.nm_pessoa as nm_atendimento, cha.dh_abertura, cha.dh_agendamento, s.nm_status
//        FROM cha_chamado AS cha
//	INNER JOIN cha_categoria_secundaria AS cs ON cs.id_categoria_secundaria = cha.id_categoria_secundaria
//	INNER JOIN cha_categoria_primaria AS cp ON cs.id_categoria_primaria = cp.id_categoria_primaria
//	INNER JOIN cha_categoria_tipo AS t ON cp.id_categoria_tipo = t.id_categoria_tipo
//	INNER JOIN cha_categoria_principal AS cpri ON t.id_categoria_principal = cpri.id_categoria_principal
//	INNER JOIN ses_pessoa AS ps ON cha.id_pessoa_solicitante = ps.id_pessoa
//	LEFT JOIN cha_pessoa_atendimento AS chpa ON cha.id_chamado = chpa.id_chamado
//	LEFT JOIN ses_pessoa AS pa ON chpa.id_pessoa = pa.id_pessoa
//	INNER JOIN cha_status AS s ON cha.id_status = s.id_status
//	INNER JOIN cha_form_sistema AS fs ON cha.id_chamado = fs.id_chamado
//	INNER JOIN ses_lotacao AS l ON fs.id_lotacao = l.id_lotacao
//        WHERE cha.id_pessoa_solicitante = :id
//        ORDER BY cha.id_chamado");
//
//        $result->bindValue(":id", $this->getId_pessoa_solicitante(), PDO::PARAM_INT);
//        $result->execute();
//        if ($result->rowCount() >= 1) {
//            return $result->fetchAll(PDO::FETCH_ASSOC);
//        } else {
//            return FALSE;
//        }
//    }
//
    /**
     * Retorna as informações de um Chamado Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaChamado($pdo) {

        $retorno = FALSE;

        $sql = "SELECT *
                FROM cha_chamado
                WHERE id_chamado = :idChamado";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idChamado", $this->getIdChamado(), PDO::PARAM_INT);
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
    
    function verificaChamado($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_chamado
                                  FROM cha_chamado
                                  WHERE id_chamado = :idChamado');
            $sql->bindValue(':idChamado', $this->getIdChamado(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->setSucesso(TRUE);
            } else {
                $this->setSucesso( FALSE);
            }
        } catch (Exception $ex) {
            $this->setSucesso(FALSE);
            $this->setMensagem( 'Erro ao verificar o chamado');
        }
    }

}
