<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaTipoGasto.class.php";

class DaoPlaTipoGasto extends PlaTipoGasto {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_tipo_gasto (id_tipo_gasto, nm_tipo_gasto) "
                    . " VALUES (:idTipoGasto, :nmTipoGasto)");
            $result->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $result->bindValue(":nmTipoGasto", $this->getNmTipoGasto(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_tipo_gasto SET nm_tipo_gasto = :nmTipoGasto "
                    . " WHERE id_tipo_gasto = :idTipoGasto ");
            $result->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $result->bindValue(":nmTipoGasto", $this->getNmTipoGasto(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_tipo_gasto WHERE id_tipo_gasto = :idTipoGasto");
            $result->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaPlaTipoGasto($pdo) {

        $retorno = FALSE;

        $sql = " SELECT id_tipo_gasto, nm_tipo_gasto"
                . " FROM pla_tipo_gasto"
                . " WHERE id_tipo_gasto = :idTipoGasto";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
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
     * Retorna todas as Informações de Todos os Tipo de Gastos
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPlaTipoGasto($pdo) {

        $retorno = FALSE;

        $sql = " SELECT id_tipo_gasto, nm_tipo_gasto"
                . " FROM pla_tipo_gasto"
                . " ORDER BY nm_tipo_gasto";
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

    public function retornaElementoTipoGasto($pdo) {

        $sql = "select elemento.id_despesa_elemento, elemento.cd_despesa_elemento, elemento.ds_despesa_elemento
                from pla_tipo_gasto_despesa_elemento as gastoElemento
                inner join pla_tipo_gasto as gasto
                on gasto.id_tipo_gasto = gastoElemento.id_tipo_gasto
                inner join view_despesa_elemento as elemento
                on elemento.id_despesa_elemento = gastoElemento.id_despesa_elemento
                where gastoElemento.id_tipo_gasto = :tipoGasto";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
