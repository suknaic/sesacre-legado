<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinTipoAdministracao.class.php";

class TipoAdministracao {
    
    private $idTipoAdministracao = null;
    private $nmTipoadministracao = null;
    
    function getIdTipoAdministracao() {
        return $this->idTipoAdministracao;
    }

    function getNmTipoadministracao() {
        return $this->nmTipoadministracao;
    }

    function setIdTipoAdministracao($idTipoAdministracao) {
        $this->idTipoAdministracao = $idTipoAdministracao;
        return $this;
    }

    function setNmTipoadministracao($nmTipoadministracao) {
        $this->nmTipoadministracao = $nmTipoadministracao;
        return $this;
    }

    function tipoAdministracaoOptions(){
        $retorno = "<option>Selecione o tipo de administração</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoAdministracao = new DaoFinTipoAdministracao();
            $daoFinTipoAdministracao->select($pdo);
            
            if ($daoFinTipoAdministracao->getSucesso()) {
                foreach ($daoFinTipoAdministracao->getMsgRetorno() as $linha) {
                    
                    $retorno .= "<option value='".$linha['id_tipo_administracao']."'>".$linha['nm_tipo_administracao']."</option>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
}

