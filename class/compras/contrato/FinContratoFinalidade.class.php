<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoFinalidade.class.php";

class FinContratoFinalidade{
    
    public function retornaOption() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoFinalidade();
            $retorno = '';
            //fim de variaveis
            $daoContrato->retornaTodos($pdo);
            foreach ($daoContrato->getMsgRetorno() as $value) {
                $retorno .= '<option value=' . $value["id_contrato_finalidade"] . '>' . $value["nm_contrato_finalidade"] . '</option>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}
