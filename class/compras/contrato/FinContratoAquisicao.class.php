<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoAquisicao.class.php";

class FinContratoAquisicao{
    
    public function retornaOption() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoAquisicao();
            $retorno = '';
            //fim de variaveis
            $daoContrato->retornaTodos($pdo);
            foreach ($daoContrato->getMsgRetorno() as $value) {
                $retorno .= '<option value=' . $value["id_contrato_aquisicao"] . '>' . $value["nm_contrato_aquisicao"] . '</option>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}
