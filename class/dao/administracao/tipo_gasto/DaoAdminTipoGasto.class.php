<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/administracao/tipo_gasto/AdminPlaTipoGasto.class.php";

/**
 * Description of DaoTipoGasto
 *
 * @author elivelton
 */
class DaoAdminTipoGasto extends AdminPlaTipoGasto {

    public function inserirTipoGastor($pdo) {
        try {
            $sql = $pdo->prepare("INSERT INTO pla_tipo_gasto(nm_tipo_gasto) VALUES (:nmTipoGasto)");
            $sql->bindValue(':nmTipoGasto', $this->getNmTipoGasto(), PDO::PARAM_STR);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function listarTipoGasto($pdo) {
        try {
            $sql = $pdo->query("SELECT id_tipo_gasto, nm_tipo_gasto FROM pla_tipo_gasto WHERE st_ativo = '1' ORDER BY nm_tipo_gasto");
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function editarTipoGasto($pdo) {
        try {
            $sql = $pdo->prepare("UPDATE pla_tipo_gasto SET nm_tipo_gasto = :nmTipoGasto WHERE id_tipo_gasto = :idTipoGasto");
            $sql->bindValue(':nmTipoGasto', $this->getNmTipoGasto(), PDO::PARAM_STR);
            $sql->bindValue(':idTipoGasto', $this->getIdTipoGasto(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException$ex) {
            return $ex->getMessage();
        }
    }

    public function desativarTipoGasto($pdo) {
        try {
            $sql = $pdo->prepare("UPDATE pla_tipo_gasto SET st_ativo = '0' WHERE id_tipo_gasto = :idTipoGasto");
            $sql->bindValue(':idTipoGasto', $this->getIdTipoGasto(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function verificarExistenciaTipoGasto($pdo, $campo, $atributo) {
        try {
            $sql = $pdo->query("SELECT * FROM pla_tipo_gasto WHERE $campo = $atributo");
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return 0;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

}
