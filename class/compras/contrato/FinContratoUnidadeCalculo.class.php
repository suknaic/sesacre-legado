<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoUnidadeCalculo.class.php";

class FinContratoUnidadeCalculo{
    
    public function retornaOption() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoUnidadeCalculo();
            $retorno = '';
            //fim de variaveis
            $daoContrato->retornaTodos($pdo);
            foreach ($daoContrato->getMsgRetorno() as $value) {
                $retorno .= '<option value=' . $value["id_contrato_unidade_calculo"] . '>' . $value["nm_contrato_unidade_calculo"] . '</option>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}
