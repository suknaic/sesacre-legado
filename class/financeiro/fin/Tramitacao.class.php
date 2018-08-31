<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinTramitacao.class.php";

class Tramitacao {

    private $idTramitacao = null;
    private $nmTramitacao = null;
    private $stAtivo = null;
    
    function getIdTramitacao() {
        return $this->idTramitacao;
    }

    function getNmTramitacao() {
        return $this->nmTramitacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdTramitacao($idTramitacao) {
        $this->idTramitacao = $idTramitacao;
        return $this;
    }

    function setNmTramitacao($nmTramitacao) {
        $this->nmTramitacao = $nmTramitacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function retornaOptionsTramitacao(){
        $opcoes = "<option value=0>Selecione o Tipo da Tramitação</option>";
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTramitacao = new DaoFinTramitacao();
            $daoFinTramitacao->select($pdo);
            
             if ($daoFinTramitacao->getSucesso()) {
                foreach ($daoFinTramitacao->getMsgRetorno() as $linha) {
                    
                    $opcoes .= "<option value='".$linha['id_tramitacao']."'>".$linha['nm_tramitacao']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}

