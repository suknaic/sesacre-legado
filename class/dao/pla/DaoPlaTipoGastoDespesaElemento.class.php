<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaTipoGastoDespesaElementoTb.class.php";

class DaoPlaTipoGastoDespesaElemento extends PlatipoGastoDespesaElementoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * [sucesso e responsavel ]
     * @return [type]
     */
    public function sucesso() {
        return $this->sucesso;
    }

    public function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_tipo_gasto_despesa_elemento (id_tipo_gasto, id_despesa_elemento) VALUES (:tipoGasto, :despesa)");
            $result->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $result->bindValue(":despesa", $this->getIdDespesaElemento(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            return $e->getMessage();
        }
    }

    public function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_unidade_medida SET nm_unidade_medida = :nmUnidadeMedida "
                    . " WHERE id_unidade_medida = :idUnidadeMedida");
            $result->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
            $result->bindValue(":nmUnidadeMedida", $this->getNmUnidadeMedida(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_unidade_medida WHERE id_unidade_medida = :idUnidadeMedida");
            $result->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function listaPlaTipoDespesaelemento(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select tipoDespesa.id_tipo_gasto_despesa_elemento, tpGasto.nm_tipo_gasto, desp.cd_despesa_elemento, desp.ds_despesa_elemento
                        from pla_tipo_gasto_despesa_elemento as tipoDespesa
                        inner join pla_tipo_gasto as tpGasto
                        on tpGasto.id_tipo_gasto = tipoDespesa.id_tipo_gasto
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = tipoDespesa.id_despesa_elemento";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
