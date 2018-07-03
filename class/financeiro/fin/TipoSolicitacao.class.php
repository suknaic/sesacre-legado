<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinTipoSolicitacao.class.php";


class TipoSolicitacao {
    
    private $idTipoSolicitacao = null;
    private $nmTipoSolicitacao = null;
    
    function getIdTipoSolicitacao() {
        return $this->idTipoSolicitacao;
    }

    function getNmTipoSolicitacao() {
        return $this->nmTipoSolicitacao;
    }

    function setIdTipoSolicitacao($idTipoSolicitacao) {
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }

    function setNmTipoSolicitacao($nmTipoSolicitacao) {
        $this->nmTipoSolicitacao = $nmTipoSolicitacao;
    }
    
    function descritivoGestor($idSolicitacao){
        switch ($idSolicitacao) {
            case 1:
                return "Gestor Compras (Administrativa)";
            case 2:
                return "Gestor Contratos (Administrativa por Licitação)";
            case 3:
                return "Gestor de Diárias (Diárias)";
            case 4:
                return "Gestor TFD (Ajuda de Custo)";

        }
    }

    function tipoSolicitacaoOptions(){
        $retorno = "<option>Selecione o tipo de solicitação</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoSolicitacao = new DaoFinTipoSolicitacao();
            $daoFinTipoSolicitacao->select($pdo);
            
            if ($daoFinTipoSolicitacao->getSucesso()) {
                foreach ($daoFinTipoSolicitacao->getMsgRetorno() as $linha) {
                    
                    $retorno .= "<option value='".$linha['id_tipo_solicitacao']."'>".$this->descritivoGestor($linha['id_tipo_solicitacao'])."</option>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
}

