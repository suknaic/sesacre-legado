<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoInstrumento.class.php";

class FinContratoInstrumento{
    
    public function retornaOption() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoInstrumento();
            $retorno = '';
            //fim de variaveis
            $daoContrato->retornaTodos($pdo);
            foreach ($daoContrato->getMsgRetorno() as $value) {
                $retorno .= '<option value=' . $value["id_contrato_instrumento"] . '>' . $value["nm_contrato_instrumento"] . '</option>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}
