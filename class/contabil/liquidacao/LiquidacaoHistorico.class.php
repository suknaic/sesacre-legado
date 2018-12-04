<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacaoHistorico.class.php";

class LiquidacaoHistorico {

    private $idLiquidacaoHistorico = null;
    private $idLiquidacao = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $idLiquidacaoSituacao = null;
    private $idLiquidacaoStatus = null;
    private $dhLiquidacaoHistorico = null;
    private $dsLiquidacao = null;
    
    private $mensagens = null;
    private $sucesso = null;
    
    function getIdLiquidacaoStatus() {
        return $this->idLiquidacaoStatus;
    }

    function setIdLiquidacaoStatus($idLiquidacaoStatus) {
        $this->idLiquidacaoStatus = $idLiquidacaoStatus;
        return $this;
    }
    
    function getIdLiquidacao() {
        return $this->idLiquidacao;
    }

    function setIdLiquidacao($idLiquidacao) {
        $this->idLiquidacao = $idLiquidacao;
        return $this;
    }
    
    function getMensagens() {
        return $this->mensagens;
    }

    function getSucesso() {
        return $this->sucesso;
    }
    
    function getIdLiquidacaoHistorico() {
        return $this->idLiquidacaoHistorico;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getIdLiquidacaoSituacao() {
        return $this->idLiquidacaoSituacao;
    }

    function getDhLiquidacaoHistorico() {
        return $this->dhLiquidacaoHistorico;
    }

    function getDsLiquidacao() {
        return $this->dsLiquidacao;
    }

    function setIdLiquidacaoHistorico($idLiquidacaoHistorico) {
        $this->idLiquidacaoHistorico = $idLiquidacaoHistorico;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setIdLiquidacaoSituacao($idLiquidacaoSituacao) {
        $this->idLiquidacaoSituacao = $idLiquidacaoSituacao;
        return $this;
    }

    function setDhLiquidacaoHistorico($dhLiquidacaoHistorico) {
        $this->dhLiquidacaoHistorico = $dhLiquidacaoHistorico;
        return $this;
    }

    function setDsLiquidacao($dsLiquidacao) {
        $this->dsLiquidacao = $dsLiquidacao;
        return $this;
    }


    function salvarLiquidacaoHistorico(PDO $pdo = null){
        $this->sucesso = false;
        $this->mensagens = null;
        try {
            if (!empty($pdo)) {
                
                $daoConLiquidacaoHistorico = new DaoConLiquidacaoHistorico();
                $daoConLiquidacaoHistorico->setIdPessoa($this->getIdPessoa())
                                          ->setIdLiquidacao($this->getIdLiquidacao())
                                          ->setIdLotacao($this->getIdLotacao())
                                          ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                                          ->setIdLiquidacaoSituacao($this->getIdLiquidacaoSituacao())
                                          ->setIdLiquidacaoStatus($this->getIdLiquidacaoStatus())
                                          ->setDsLiquidacao($this->getDsLiquidacao());
                
                $daoConLiquidacaoHistorico->insert($pdo);
            
                if ($daoConLiquidacaoHistorico->Sucesso()) {
                    $idLiquidacaoHistorico = $pdo->lastInsertId('con_liquidacao_historico_id_liquidacao_historico_seq');
                    if (!Log::SalvaLogI('con_liquidacao_historico', $idLiquidacaoHistorico, $pdo)) {
                        $this->mensagens = "Erro ao salvar o Histórico da Liquidação no LOG. Operação Cadastro.";
                        return false;
                    }
                    $this->sucesso = true;
                } else {
                    $this->mensagens = $daoConLiquidacaoHistorico->getMsgRetorno();
                }
                
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
            }
        } catch (Exception $exc) {
            $this->mensagens = $exc->getMessage();
        }
    }
    
    function retornaHistorico() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConLiquidacaoHistorico = new DaoConLiquidacaoHistorico();
            $daoConLiquidacaoHistorico->setIdLiquidacao($this->getIdLiquidacao());

            $daoConLiquidacaoHistorico->historico($pdo);

            if ($daoConLiquidacaoHistorico->Sucesso()) {
                foreach ($daoConLiquidacaoHistorico->getMsgRetorno() as $linha) {
                    $retorno .= $linha['historico'] . "\n";
                }
            } else {
                $retorno = $daoConLiquidacaoHistorico->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }

}

