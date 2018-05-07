<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinFonte.class.php";

class DaoFinFonte extends FinFonte {

    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaFonte($pdo) {

        $retorno = FALSE;

        $sql = " SELECT id_fonte, nr_fonte"
                . " FROM fin_fonte"
                . " WHERE id_fonte = :idFonte";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);
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
     * Retorna todas as Fontes
     * @param type $pdo
     * @return boolean
     */
    function retornaTodasFontes($pdo) {

        $retorno = FALSE;

        $sql = " SELECT id_fonte, nr_fonte"
                . " FROM fin_fonte"
                . " ORDER BY nr_fonte";
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
     * Retorna todas as Fontes que foram liberadas para as unidades formularem seu PTA 
     * de acorda com a lotação e o Ano 
     * @param int $idLotacao
     * @param int $ano
     * @param PDO $pdo
     * @return boolean
     */
    function retornaLotLiberUnidadeValorAno(int $idLotacao, int $ano, PDO $pdo) {

        $retorno = FALSE;

        $sql = " SELECT F.id_fonte, F.nr_fonte"
                . " FROM fin_fonte F"
                . " INNER JOIN pla_liberacao_unidade_valor LU ON LU.id_fonte = F.id_fonte"
                . " WHERE LU.id_lotacao = :idLotacao "
                . " AND LU.aa_liberacao_unidade_valor = :aaLiberacaUnidadeValor"
                . " ORDER BY F.nr_fonte";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);
            $sth->bindValue(":aaLiberacaUnidadeValor", $ano, PDO::PARAM_INT);
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

    public function retornaFonteAta(int $idAta, PDO $pdo) {
        $retorno = FALSE;

        $sql = "select id_fonte from fin_ata where id_ata = :ata";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":ata", $idAta, PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 0) {
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

    public function retornaFonteContrato(int $idContrato, PDO $pdo) {
        $retorno = FALSE;

        $sql = "select id_fonte from fin_contrato where id_contrato = :contrato";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":contrato", $idContrato, PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 0) {
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
