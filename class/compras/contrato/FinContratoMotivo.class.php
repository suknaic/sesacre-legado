<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoMotivo.class.php";

class FinContratoMotivo{
    
    private $idContratoMotivo = null;
    private $nmContratoMotivo = null;
    
    function getIdContratoMotivo() {
        return $this->idContratoMotivo;
    }

    function getNmContratoMotivo() {
        return $this->nmContratoMotivo;
    }

    function setIdContratoMotivo($idContratoMotivo) {
        $this->idContratoMotivo = $idContratoMotivo;
    }

    function setNmContratoMotivo($nmContratoMotivo) {
        $this->nmContratoMotivo = $nmContratoMotivo;
    }
    
    
    public function getMotivoAditamentoTexto(){
        return "Aditivo Por ".$this->nmContratoMotivo;
    }

        
    
    public function retornaOption() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoMotivo();
            $retorno = '';
            //fim de variaveis
            $daoContrato->retornaTodos($pdo);
            foreach ($daoContrato->getMsgRetorno() as $value) {
                $retorno .= '<option value=' . $value["id_contrato_motivo"] . '>' . $value["nm_contrato_motivo"] . '</option>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function carregaDados(PDO $pdo) {
        try {
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoContrato = new DaoFinContratoMotivo();
            $daoContrato->setIdContratoMotivo($this->idContratoMotivo);
            $daoContrato->retorna($pdo);
            if($daoContrato->Sucesso()){
                $this->idContratoMotivo = $daoContrato->getMsgRetorno()['id_contrato_motivo'];
                $this->nmContratoMotivo = $daoContrato->getMsgRetorno()['nm_contrato_motivo'];
            }else{
                $this->idContratoMotivo = null;
                $this->nmContratoMotivo = null;
            }                        
        } catch (Exception $e) {
            //return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}
