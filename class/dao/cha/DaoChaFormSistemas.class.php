<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaFormSistemas.class.php";

class DaoChaFormSistemas extends ChaFormSistemas {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_form_sistema (id_chamado, nm_pessoa,
                                                 ds_email, nr_telefone, nr_cartao_sus, nr_cpf, nr_rg, nr_telefone_setor, nr_matricula, nm_modulo,
                                                 nr_portaria, nm_setor, cd_setor, nm_responsavel, nr_participante, ds_senha_desejada, nm_exame, 
                                                 ds_exame_parametro, nm_permissao, nm_conselho, nr_conselho, dt_inicial, dt_fim, dt_nascimento, 
                                                 id_cargo, id_funcao, id_lotacao, id_vinculo)
                                        VALUES (:idChamado, :nmPessoa, :dsEmail, :nrTelefone, :nrCartaoSus, :nrCpf, :nrRg, :nrTelefoneSetor, :nrMatricula, 
                                        :nmModulo, :nrPortaria, :nmSetor, :cdSetor, :nmResponsavel, :nrParticipante, :dsSenhaDesejada, :nmExame, :dsExameParametro, 
                                        :nmPermissao, :nmConselho, :nrConselho, :dtInicial, :dtFim, :dtNascimento, :idCargo, :idFuncao, :idLotacao, :idVinculo)");
            $result->bindValue(":idChamado", $this->getIdChamado() === '' ? null : $this->getIdChamado(), PDO::PARAM_INT);
            $result->bindValue(":nmPessoa", $this->getNmPessoa() === '' ? null : $this->getNmPessoa(), PDO::PARAM_STR);
            $result->bindValue(":dsEmail", $this->getDsEmail() === '' ? null : $this->getDsEmail(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefone", $this->getNrTelefone() === '' ? null : $this->getNrTelefone(), PDO::PARAM_STR);
            $result->bindValue(":nrCartaoSus", $this->getNrCartaoSus() === '' ? null : $this->getNrCartaoSus(), PDO::PARAM_STR);
            $result->bindValue(":nrCpf", $this->getNrCpf() === '' ? null : $this->getNrCpf(), PDO::PARAM_STR);
            $result->bindValue(":nrRg", $this->getNrRg() === '' ? null : $this->getNrRg(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefoneSetor", $this->getNrTelefoneSetor() === '' ? null : $this->getNrTelefoneSetor(), PDO::PARAM_STR);
            $result->bindValue(":nrMatricula", $this->getNrMatricula() === '' ? null : $this->getNrMatricula(), PDO::PARAM_STR);
            $result->bindValue(":nmModulo", $this->getNmModulo() === '' ? null : $this->getNmModulo(), PDO::PARAM_STR);
            $result->bindValue(":nrPortaria", $this->getNrPortaria() === '' ? null : $this->getNrPortaria(), PDO::PARAM_STR);
            $result->bindValue(":nmSetor", $this->getNmSetor() === '' ? null : $this->getNmSetor(), PDO::PARAM_STR);
            $result->bindValue(":cdSetor", $this->getCdSetor() === '' ? null : $this->getCdSetor(), PDO::PARAM_STR);
            $result->bindValue(":nmResponsavel", $this->getNmResponsavel() === '' ? null : $this->getNmResponsavel(), PDO::PARAM_STR);
            $result->bindValue(":nrParticipante", $this->getNrParticipantes() === '' ? null : $this->getNrParticipantes(), PDO::PARAM_INT);
            $result->bindValue(":dsSenhaDesejada", $this->getDsSenhaDesejada() === '' ? null : $this->getDsSenhaDesejada(), PDO::PARAM_STR);
            $result->bindValue(":nmExame", $this->getNmExame() === '' ? null : $this->getNmExame(), PDO::PARAM_STR);
            $result->bindValue(":dsExameParametro", $this->getDsExameParametro() === '' ? null : $this->getDsExameParametro(), PDO::PARAM_STR);
            $result->bindValue(":nmPermissao", $this->getNmPermissao() === '' ? null : $this->getNmPermissao(), PDO::PARAM_STR);
            $result->bindValue(":nmConselho", $this->getNmConselho() === '' ? null : $this->getNmConselho(), PDO::PARAM_STR);
            $result->bindValue(":nrConselho", $this->getNrConselho() === '' ? null : $this->getNrConselho(), PDO::PARAM_STR);
            $result->bindValue(":dtInicial", $this->getDtInicial() === '' ? null : $this->getDtInicial(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFim() === '' ? null : $this->getDtFim(), PDO::PARAM_STR);
            $result->bindValue(":dtNascimento", $this->getDtNascimento() === '' ? null : $this->getDtNascimento(), PDO::PARAM_STR);
            $result->bindValue(":idCargo", $this->getIdCargo() === '' ? null : $this->getIdCargo(), PDO::PARAM_INT);
            $result->bindValue(":idFuncao", $this->getIdFuncao() === '' ? null : $this->getIdFuncao(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao() === '' ? null : $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":idVinculo", $this->getIdVinculo() === '' ? null : $this->getIdVinculo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_sistemas SET nm_pessoa = :nmPessoa "
                    . " , ds_email = :dsEmail , nr_telefone = :nrTelefone"
                    . " , nr_cartao_sus = :nrCartaoSus , nr_cpf = :nrCpf, nr_rg = :nrRg, nr_telefone_setor = :nrTelefoneSetor, nr_matricula = :nrMatricula, "
                    . "nm_modulo = :nmModulo,  nr_portaria = :nrPortaria, nm_setor = :nmSetor, cd_setor = :cdSetor, nm_responsavel = :nmResponsavel, "
                    . "nr_participantes = :nrParticipantes, ds_senha_desejada = :dsSenhaDesejada, nm_exame = :nmExame, ds_exame_parametro = :dsParametroExame,"
                    . "nm_permissao = :nmPermissao, nm_conselho = :nmConselho, nr_conselho = :nrConselho, dt_inicial = :dtInicial, dt_fim = :dtFim, "
                    . "dt_nascimento = :dtNascimento, id_cargo = :idCargo, id_funcao = :idFuncao, id_lotacao = :idLotacao, id_vinculo = :idVinculo"
                    . " WHERE id_form_sistemas = :idFormSistemas ");
            $result->bindValue(":idFormSistemas", $this->getIdFormSistemas() === '' ? null : $this->getIdFormSistemas(), PDO::PARAM_INT);
            $result->bindValue(":idChamado", $this->getIdChamado() === '' ? null : $this->getIdChamado(), PDO::PARAM_INT);
            $result->bindValue(":nmPessoa", $this->getNmPessoa() === '' ? null : $this->getNmPessoa(), PDO::PARAM_STR);
            $result->bindValue(":dsEmail", $this->getDsEmail() === '' ? null : $this->getDsEmail(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefone", $this->getNrTelefone() === '' ? null : $this->getNrTelefone(), PDO::PARAM_STR);
            $result->bindValue(":nrCartaoSus", $this->getNrCartaoSus() === '' ? null : $this->getNrCartaoSus(), PDO::PARAM_STR);
            $result->bindValue(":nrCpf", $this->getNrCpf() === '' ? null : $this->getNrCpf(), PDO::PARAM_STR);
            $result->bindValue(":nrRg", $this->getNrRg() === '' ? null : $this->getNrRg(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefoneSetor", $this->getNrTelefoneSetor() === '' ? null : $this->getNrTelefoneSetor(), PDO::PARAM_STR);
            $result->bindValue(":nrMatricula", $this->getNrMatricula() === '' ? null : $this->getNrMatricula(), PDO::PARAM_STR);
            $result->bindValue(":nmModulo", $this->getNmModulo() === '' ? null : $this->getNmModulo(), PDO::PARAM_STR);
            $result->bindValue(":nrPortaria", $this->getNrPortaria() === '' ? null : $this->getNrPortaria(), PDO::PARAM_STR);
            $result->bindValue(":nmSetor", $this->getNmSetor() === '' ? null : $this->getNmSetor(), PDO::PARAM_STR);
            $result->bindValue(":cdSetor", $this->getCdSetor() === '' ? null : $this->getCdSetor(), PDO::PARAM_STR);
            $result->bindValue(":nmResponsavel", $this->getNmResponsavel() === '' ? null : $this->getNmResponsavel(), PDO::PARAM_STR);
            $result->bindValue(":nrParticipantes", $this->getNrParticipantes() === '' ? null : $this->getNrParticipantes(), PDO::PARAM_STR);
            $result->bindValue(":dsSenhaDesejada", $this->getDsSenhaDesejada() === '' ? null : $this->getDsSenhaDesejada(), PDO::PARAM_STR);
            $result->bindValue(":nmExame", $this->getNmExame() === '' ? null : $this->getNmExame(), PDO::PARAM_STR);
            $result->bindValue(":dsExameParametro", $this->getDsExameParametro() === '' ? null : $this->getDsExameParametro(), PDO::PARAM_STR);
            $result->bindValue(":nmPermissao", $this->getNmPermissao() === '' ? null : $this->getNmPermissao(), PDO::PARAM_STR);
            $result->bindValue(":nmConselho", $this->getNmConselho() === '' ? null : $this->getNmConselho(), PDO::PARAM_STR);
            $result->bindValue(":nrConselho", $this->getNrConselho() === '' ? null : $this->getNrConselho(), PDO::PARAM_STR);
            $result->bindValue(":dtInicial", $this->getDtInicial() === '' ? null : $this->getDtInicial(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFim() === '' ? null : $this->getDtFim(), PDO::PARAM_STR);
            $result->bindValue(":dtNascimento", $this->getDtNascimento() === '' ? null : $this->getDtNascimento(), PDO::PARAM_STR);
            $result->bindValue(":idCargo", $this->getIdCargo() === '' ? null : $this->getIdCargo(), PDO::PARAM_INT);
            $result->bindValue(":idFuncao", $this->getIdFuncao() === '' ? null : $this->getIdFuncao(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao() === '' ? null : $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":idVinculo", $this->getIdVinculo() === '' ? null : $this->getIdVinculo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_form_sistema WHERE id_form_sistema = :idFormSistema");
            $result->bindValue(":idFormSistema", $this->getIdFormSistemas(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_sistema SET st_ativo = 0 "
                    . "WHERE id_form_sistema = :idFormSistema ");
            $result->bindValue(":idFormSistema", $this->getIdFormSistemas(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retorna todas as Informações dos Chamados
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosFormSistemas($pdo) {

        $retorno = FALSE;

        $result = $pdo->prepare("SELECT cha.id_chamado, ps.nm_pessoa as nm_solicitante, t.id_categoria_tipo, t.nm_categoria_tipo, l.nm_lotacao, cp.nm_categoria_primaria, cs.nm_categoria_secundaria,
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
        WHERE cha.id_pessoa_solicitante = :idPessoaSolicitante
        ORDER BY cha.id_chamado");

        $result->bindValue(":idPessoaSolicitante", $this->getIdPessoaSolicitante(), PDO::PARAM_INT);
        $result->execute();
        if ($result->rowCount() >= 1) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna as informações de um Chamado Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaFormSistemas($pdo) {

        $retorno = FALSE;

        $result = $pdo->prepare("SELECT *
                FROM cha_form_sistema
                WHERE id_form_sistema = :idFormSistema");
        try {
            $result->bindValue(":idFormSistema", $this->getIdFormSistemas(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                return $result->fetchall(PDO::FETCH_ASSOC);
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
