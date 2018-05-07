<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaFormMaterial.class.php";

class DaoChaFormMaterial extends ChaFormMaterial {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_form_material (id_condicao, nm_form_material, 
                                                ds_marca, ds_modelo, nr_patrimonio, ds_localizacao, 
                                                nm_serie, tp_estado, id_unidade_medida, ds_destino)
                                    VALUES (:condicao, :nmMaterial, :marca, :modelo, :patrimonio, 
                                            :localizacao, :serie, :estado, :unidadeMedida, :destino)");
            $result->bindValue(":condicao", $this->getId_condicao(), PDO::PARAM_INT);
            $result->bindValue(":nmMaterial", $this->getNm_form_material(), PDO::PARAM_STR);
            $result->bindValue(":marca", $this->getDs_marca(), PDO::PARAM_STR);
            $result->bindValue(":modelo", $this->getDs_modelo(), PDO::PARAM_STR);
            $result->bindValue(":patrimonio", $this->getNr_patrimonio(), PDO::PARAM_STR);
            $result->bindValue(":localizacao", $this->getDs_localizacao(), PDO::PARAM_STR);
            $result->bindValue(":serie", $this->getNm_serie(), PDO::PARAM_INT);
            $result->bindValue(":estado", $this->getTp_estado(), PDO::PARAM_STR);
            $result->bindValue(":unidadeMedida", $this->getId_unidade_medida(), PDO::PARAM_INT);
            $result->bindValue(":destino", $this->getDs_destino(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_from_material SET id_condicao = :condicao "
                    . " , nm_form_material = :nmMaterial , ds_marca = :marca"
                    . " , ds_modelo = :modelo , nr_patrimonio = :patrimonio, ds_localizacao = :localizacao,  "
                    . "nm_serie = :serie, tp_estado = :estado, id_unidade_medida = :unidadeMedida, ds_destino = :destino"
                    . " WHERE id_form_material = :idFormMaterial ");
            $result->bindValue(":condicao", $this->getId_condicao(), PDO::PARAM_INT);
            $result->bindValue(":nmMaterial", $this->getNm_form_material(), PDO::PARAM_STR);
            $result->bindValue(":marca", $this->getDs_marca(), PDO::PARAM_STR);
            $result->bindValue(":modelo", $this->getDs_modelo(), PDO::PARAM_STR);
            $result->bindValue(":patrimonio", $this->getNr_patrimonio(), PDO::PARAM_STR);
            $result->bindValue(":localizacao", $this->getDs_localizacao(), PDO::PARAM_STR);
            $result->bindValue(":serie", $this->getNm_serie(), PDO::PARAM_STR);
            $result->bindValue(":estado", $this->getTp_estado(), PDO::PARAM_STR);
            $result->bindValue(":unidadeMedida", $this->getId_unidade_medida(), PDO::PARAM_INT);
            $result->bindValue(":destino", $this->getDs_destino(), PDO::PARAM_STR);

            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_form_material WHERE id_form_material = :idFormMaterial");
            $result->bindValue(":idFormMaterial", $this->getId_form_material(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_form_material SET st_ativo = 0 "
                    . "WHERE id_form_material = :idFormMaterial ");
            $result->bindValue(":idFormMaterial", $this->getId_form_material(), PDO::PARAM_INT);
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
    function retornaFormMaterial($pdo) {

        $retorno = FALSE;

        $sql = "SELECT *
                FROM cha_form_material
                WHERE id_form_material = :idFormMaterial";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idFormMaterial", $this->getId_form_material(), PDO::PARAM_INT);
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