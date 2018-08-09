<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocumentoFiscalTb.class.php";

class DaoFinDocumentoFiscal extends FinDocumentoFiscalTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadasTraDocumentoFiscal(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }

            $sql = "insert into fin_documento_fiscal (nr_processo_administrativo, nr_documento_fiscal, mm_competencia, aa_competencia, dt_emissao, dt_atesto, 
                    vl_documento, fl_encontro_contas, fl_grp, nr_grp_numero, id_lotacao, id_documento_situacao, id_tipo_documento) values(:processo, :nrDocumento, 
                    :mmCompetencia, :aaCompetencia, :dtEmissao, :dtAtesto, :vlDocumento, :flContas, :flGrp, :nrGrp, :idLotacao, :idDocumentoSituacao, :idTipoDocumento)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":processo", $this->getNrProcessoAdministrativo(), PDO::PARAM_STR);
            $stmt->bindValue(":nrDocumento", $this->getNrDocumentoFiscal(), PDO::PARAM_STR);
            $stmt->bindValue(":mmCompetencia", $this->getMmCompetencia(), PDO::PARAM_INT);
            $stmt->bindValue(":aaCompetencia", $this->getAaCompetencia(), PDO::PARAM_INT);
            $stmt->bindValue(":dtEmissao", $this->getDtEmissao(), PDO::PARAM_STR);
            $stmt->bindValue(":dtAtesto", $this->getDtAtesto(), PDO::PARAM_STR);
            $stmt->bindValue(":vlDocumento", $this->getVlDocumento(), PDO::PARAM_STR);
            $stmt->bindValue(":flContas", $this->getFlEncontroContas(), PDO::PARAM_INT);
            $stmt->bindValue(":flGrp", $this->getFlGrp(), PDO::PARAM_INT);
            $stmt->bindValue(":nrGrp", $this->getNrGrpNumero(), PDO::PARAM_INT);
            $stmt->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $stmt->bindValue(":idDocumentoSituacao", $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
            $stmt->bindValue(":idTipoDocumento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
          
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
