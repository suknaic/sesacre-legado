<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesEstado.class.php";

class DaoSesEstado extends SesEstado{


    function insert(SesEstado $est, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_estado (nm_estado, nm_sigla, id_pais) "
                    . "VALUES (:nmEstado, :nmSigla, :idPais)");
            $result->bindValue(":nmSigla", $est->getNmSigla(), PDO::PARAM_STR);
            $result->bindValue(":nmEstado", $est->getNmEstado(), PDO::PARAM_STR);
            $result->bindValue(":idPais", $est->getIdPais(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update(SesEstado $est, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_estado SET nm_estado = :nmEstado, nm_sigla = :nmSigla, id_pais = :idPais "
                    . "WHERE id_estado = :idEstado ");
            $result->bindValue(":idEstado", $est->getIdEstado(), PDO::PARAM_INT);
            $result->bindValue(":nmEstado", $est->getNmEstado(), PDO::PARAM_STR);
            $result->bindValue(":nmSigla", $est->getNmSigla(), PDO::PARAM_STR);
            $result->bindValue(":idPais", $est->getIdPais(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete(SesEstado $est, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_estado WHERE id_estado = :idEstado");
            $result->bindValue(":idEstado", $est->getIdEstado(), PDO::PARAM_INT);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e;
        }
    }

    function desativa(SesEstado $est, $pdo){
        try {
            $result = $pdo->prepare("UPDATE ses_estado SET st_ativo = 0 "
                    . "WHERE id_estado = :idEstado ");
            $result->bindValue(":idEstado", $est->getIdEstado(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaEstados($pdo){
        
        $retorno = FALSE;
        try {
            if (empty($this->getIdPais())){
                $sql = " SELECT E.*,P.nm_pais "
                . " FROM ses_estado E"
                . " INNER JOIN ses_pais P"
                . " ON E.id_pais = P.id_pais  "
                . " ORDER BY E.nm_estado";
            } else {
                $idPais = $this->getIdPais();
                $sql = " SELECT E.*,P.nm_pais "
                . " FROM ses_estado E"
                . " INNER JOIN ses_pais P"
                . " ON E.id_pais = P.id_pais "
                . " where P.id_pais =  $idPais "
                . " ORDER BY E.nm_estado ";
            }
            $sth = $pdo->prepare($sql);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    function retornaEstado($pdo){

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM ses_estado"
                . " WHERE id_estado = :idEstado";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idEstado", $this->getIdEstado(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    /**
     * Retorna Informação do Vinculo caso o nome seja igual
     * Caso seja passado um ID Vinculo, esse ID será desconsiderado na busca
     * @param SesVinculo $vinculo
     * @param type $pdo
     * @return boolean/Object
     */
    function buscaEstadoPorNome(SesEstado $est, $pdo) {
        $retorno = false;
        $semEstado = "";
        if($est->getIdEstado() != NULL || $est->getIdEstado() != ""){
            $semEstado = " AND id_estado <> :idEstado";
        }
        $sql = " SELECT "
                . " id_estado, nm_estado"
                . " FROM ses_estado"
                . " WHERE nm_estado = :nmEstado"
                . $semEstado
                . "";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmEstado", $est->getNmEstado(), PDO::PARAM_STR);
             if($est->getIdEstado() != NULL || $est->getIdEstado() != ""){
                $sth->bindValue(":idEstado", $est->getIdPais(), PDO::PARAM_INT);
            }
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return $retorno;
        }

    }

}
