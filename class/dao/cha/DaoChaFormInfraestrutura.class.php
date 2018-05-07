<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaFormInfraestrutura.class.php";

class DaoChaFormInfraestrutura extends ChaFormInfraestrutura {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_form_infraestrutura (id_chamado, tp_liberacao, nm_pessoa, id_cargo, 
                                                    id_funcao, id_lotacao, nm_email, ds_andar, qt_pontos, qt_cabos, nm_app, qt_patch_cord, 
                                                    ds_justificativa, nr_vlan, qt_keystone, qt_rj45, qt_rack, nm_pasta, ds_destino, qt_computador, 
                                                    qt_impressora, qt_telefone, ds_ip_gateway, nr_telefone)
                                                    VALUES (:idChamado, :tpLiberacao, :nmPessoa, :idCargo, :idFuncao, :idLotacao, :nmEmail, :dsAndar,
                                                    :qtPontos,  :qtCabos, :nmApp, :qtPatchCord, :dsJustificativa, :nrVlan, :qtKeystone, :qtRj45, :qtRack,
                                                    :nmPasta, :dsDestino, :qtComputador, :qtImpressora, :qtTelefone, :dsIpGateway, :nrTelefone)");
            $result->bindValue(":idChamado", $this->getIdChamado() === '' ? null : $this->getIdChamado(), PDO::PARAM_INT);
            $result->bindValue(":tpLiberacao", $this->getTpLiberacao() === '' ? null : $this->getTpLiberacao(), PDO::PARAM_STR);
            $result->bindValue(":nmPessoa", $this->getNmPessoa() === '' ? null : $this->getNmPessoa(), PDO::PARAM_STR);
            $result->bindValue(":idCargo", $this->getIdCargo() === '' ? null : $this->getIdCargo(), PDO::PARAM_INT);
            $result->bindValue(":idFuncao", $this->getIdFuncao() === '' ? null : $this->getIdFuncao(), PDO::PARAM_INT);
            $result->bindValue(":nmEmail", $this->getNmEmail() === '' ? null : $this->getNmEmail(), PDO::PARAM_STR);
            $result->bindValue(":dsAndar", $this->getDsAndar() === '' ? null : $this->getDsAndar(), PDO::PARAM_INT);
            $result->bindValue(":qtPontos", $this->getQtPontos() === '' ? null : $this->getQtPontos(), PDO::PARAM_INT);
            $result->bindValue(":qtCabos", $this->getQtCabos() === '' ? null : $this->getQtCabos(), PDO::PARAM_INT);
            $result->bindValue(":nmApp", $this->getNmApp() === '' ? null : $this->getNmApp(), PDO::PARAM_STR);
            $result->bindValue(":qtPatchCord", $this->getQtPatchCord() === '' ? null : $this->getQtPatchCord(), PDO::PARAM_INT);
            $result->bindValue(":dsJustificativa", $this->getDsJustificativa() === '' ? null : $this->getDsJustificativa(), PDO::PARAM_STR);
            $result->bindValue(":nrVlan", $this->getNrVlan() === '' ? null : $this->getNrVlan(), PDO::PARAM_INT);
            $result->bindValue(":qtKeystone", $this->getQtKeystone() === '' ? null : $this->getQtKeystone(), PDO::PARAM_INT);
            $result->bindValue(":qtRj45", $this->getQtRj45() === '' ? null : $this->getQtRj45(), PDO::PARAM_INT);
            $result->bindValue(":qtRack", $this->getQtRack() === '' ? null : $this->getQtRack(), PDO::PARAM_INT);
            $result->bindValue(":nmPasta", $this->getNmPasta() === '' ? null : $this->getNmPasta(), PDO::PARAM_STR);
            $result->bindValue(":dsDestino", $this->getDsDestino() === '' ? null : $this->getDsDestino(), PDO::PARAM_STR);
            $result->bindValue(":qtComputador", $this->getQtComputador() === '' ? null : $this->getQtComputador(), PDO::PARAM_INT);
            $result->bindValue(":qtTelefone", $this->getQtTelefone() === '' ? null : $this->getQtTelefone(), PDO::PARAM_INT);
            $result->bindValue(":dsIpGateway", $this->getDsIpGateway() === '' ? null : $this->getDsIpGateway(), PDO::PARAM_STR);
            $result->bindValue(":nrTelefone", $this->getNrTelefone() === '' ? null : $this->getNrTelefone(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_telefonia SET tp_liberacao = :liberacao "
                    . " , nm_pessoa = :nmPessoa , id_cargo = :cargo"
                    . " , id_funcao = :funcao , id_lotacao = :lotacao, nm_email = :email,  ds_andar = :andar"
                    . " WHERE id_form_infraestrutura = :idFormInfraestrutura ");
            $result->bindValue(":idChamado", $this->getId_chamado(), PDO::PARAM_INT);
            $result->bindValue(":liberacao", $this->getTp_liberacao(), PDO::PARAM_STR);
            $result->bindValue(":nmPessoa", $this->getNm_pessoa(), PDO::PARAM_STR);
            $result->bindValue(":cargo", $this->getId_cargo(), PDO::PARAM_INT);
            $result->bindValue(":funcao", $this->getId_funcao(), PDO::PARAM_INT);
            $result->bindValue(":lotacao", $this->getId_lotacao(), PDO::PARAM_INT);
            $result->bindValue(":email", $this->getNm_email(), PDO::PARAM_STR);
            $result->bindValue(":andar", $this->getDs_andar(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_form_infraestrutura WHERE id_form_infraestrutura = :idFormInfraestrutura");
            $result->bindValue(":idFormInfraestrutura", $this->getId_form_infraestrutura(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_infraesrutura SET st_ativo = 0 "
                    . "WHERE id_form_infraestrutura = :idFormInfraestrutura ");
            $result->bindValue(":idFormInfraestrutura", $this->getId_form_infraestrutura(), PDO::PARAM_INT);
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

    /**
     * Retorna as informações de um Chamado Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaFormInfraestrutura($pdo) {

        $retorno = FALSE;

        $sql = "SELECT *
                FROM cha_form_infraestrutura
                WHERE id_form_infraestrutura = :idFormInfraestrutura";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idFormInfraestrutura", $this->getId_form_infraestrutura(), PDO::PARAM_INT);
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

}
