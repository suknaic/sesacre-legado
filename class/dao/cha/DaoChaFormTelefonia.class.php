<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaFormTelefonia.class.php";

class DaoChaFormTelefonia extends ChaFormTelefonia {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_form_telefonia (id_chamado, nr_ramal, ds_tipo, ds_destino, 
                                                    nr_patrimonio, ds_marca, ds_modelo, ds_localizacao)
                                        VALUES (:idChamado, :nrRamal, :tipo, :destino, :nrPatrimonio, :marca, :modelo, :localizacao)");
            $result->bindValue(":idChamado", $this->getId_chamado(), PDO::PARAM_INT);
            $result->bindValue(":nrRamal", $this->getNr_ramal(), PDO::PARAM_STR);
            $result->bindValue(":tipo", $this->getDs_tipo(), PDO::PARAM_STR);
            $result->bindValue(":destino", $this->getDs_destino(), PDO::PARAM_STR);
            $result->bindValue(":nrPatrimonio", $this->getNr_patrimonio(), PDO::PARAM_STR);
            $result->bindValue(":marca", $this->getDs_marca(), PDO::PARAM_STR);
            $result->bindValue(":modelo", $this->getDs_modelo(), PDO::PARAM_STR);
            $result->bindValue(":localizacao", $this->getDs_localizacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_telefonia SET nr_ramal = :nrRamal "
                    . " , ds_tipo = :dsTipo , ds_destino = :dsDestino"
                    . " , nr_patrimonio = :nrPatrimonio , ds_marca = :dsMarca, ds_modelo = :modelo,  ds_localizacao = :localizacao"
                    . " WHERE id_form_telefonia = :idFormTelefonia ");
            $result->bindValue(":idChamado", $this->getId_chamado(), PDO::PARAM_INT);
            $result->bindValue(":nrRamal", $this->getNm_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":tipo", $this->getDs_email(), PDO::PARAM_STR);
            $result->bindValue(":destino", $this->getNr_telefone(), PDO::PARAM_STR);
            $result->bindValue(":nrPatrimonio", $this->getNr_cartao_sus(), PDO::PARAM_STR);
            $result->bindValue(":marca", $this->getNr_cpf(), PDO::PARAM_STR);
            $result->bindValue(":modelo", $this->getNr_rg(), PDO::PARAM_STR);
            $result->bindValue(":localizacao", $this->getNr_telefone_setor(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_form_telefonia WHERE id_form_telefonia = :idFormTelefonia");
            $result->bindValue(":idFormTelefonia", $this->getId_form_telefonia(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_telefonia SET st_ativo = 0 "
                    . "WHERE id_form_telefonia = :idFormTelefonia ");
            $result->bindValue(":idFormTelefonia", $this->getId_form_telefonia(), PDO::PARAM_INT);
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
    function retornaFormTelefonia($pdo) {

        $retorno = FALSE;

        $sql = "SELECT *
                FROM cha_form_telefonia
                WHERE id_form_telefonia = :idFormTelefonia";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idFormTelefonia", $this->getId_form_telefonia(), PDO::PARAM_INT);
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
