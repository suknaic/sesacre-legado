<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/empenho/DaoFinEmpenhoHistorico.class.php";

class FinEmpenhoHistorico {
    
    private $idEmpenhoHistorico = null;
    private $idEmpenho = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $idEmpenhoSituacao = null;
    private $idEmpenhoStatus = null;
    private $dhEmpenhoHistorico = null;
    private $dsEmpenhoHistorico = null;
    
    private $msgRetorno = null;
    private $sucesso = null;
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function getSucesso() {
        return $this->sucesso;
    }
    
    function getIdEmpenhoHistorico() {
        return $this->idEmpenhoHistorico;
    }

    function getIdEmpenho() {
        return $this->idEmpenho;
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

    function getIdEmpenhoSituacao() {
        return $this->idEmpenhoSituacao;
    }

    function getIdEmpenhoStatus() {
        return $this->idEmpenhoStatus;
    }

    function getDhEmpenhoHistorico() {
        return $this->dhEmpenhoHistorico;
    }

    function getDsEmpenhoHistorico() {
        return $this->dsEmpenhoHistorico;
    }

    function setIdEmpenhoHistorico($idEmpenhoHistorico) {
        $this->idEmpenhoHistorico = $idEmpenhoHistorico;
        return $this;
    }

    function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
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

    function setIdEmpenhoSituacao($idEmpenhoSituacao) {
        $this->idEmpenhoSituacao = $idEmpenhoSituacao;
        return $this;
    }

    function setIdEmpenhoStatus($idEmpenhoStatus) {
        $this->idEmpenhoStatus = $idEmpenhoStatus;
        return $this;
    }

    function setDhEmpenhoHistorico($dhEmpenhoHistorico) {
        $this->dhEmpenhoHistorico = $dhEmpenhoHistorico;
        return $this;
    }

    function setDsEmpenhoHistorico($dsEmpenhoHistorico) {
        $this->dsEmpenhoHistorico = $dsEmpenhoHistorico;
        return $this;
    }

    function salvarEmpenhoHistorico(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        try {
            if (!empty($pdo)) {
                
                $daoFinEmpenhoHistorico = new DaoFinEmpenhoHistorico();
                $daoFinEmpenhoHistorico->setIdPessoa($this->getIdPessoa())
                                       ->setIdEmpenho($this->getIdEmpenho())
                                       ->setIdLotacao($this->getIdLotacao())
                                       ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                                       ->setIdEmpenhoSituacao($this->getIdEmpenhoSituacao())
                                       ->setIdEmpenhoStatus($this->getIdEmpenhoStatus())
                                       ->setDsEmpenhoHistorico($this->getDsEmpenhoHistorico());
                
                $daoFinEmpenhoHistorico->insert($pdo);
                
                if ($daoFinEmpenhoHistorico->Sucesso()) {
                    $idEmpenhoHistorico = $pdo->lastInsertId('fin_empenho_historico_id_empenho_historico_seq');
                    if (!Log::SalvaLogI('fin_empenho_historico', $idEmpenhoHistorico, $pdo)) {
                        $this->msgRetorno = "Erro ao salvar o Histórico do Empenho no LOG. Operação Cadastro.";
                        return;
                    }
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = $daoFinEmpenhoHistorico->getMsgRetorno();
                }
                
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function retornaHistorico() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinEmpenhoHistorico = new DaoFinEmpenhoHistorico();
            $daoFinEmpenhoHistorico->setIdEmpenho($this->getIdEmpenho());

            $daoFinEmpenhoHistorico->historico($pdo);

            if ($daoFinEmpenhoHistorico->Sucesso()) {
                foreach ($daoFinEmpenhoHistorico->getMsgRetorno() as $linha) {
                    $retorno .= $linha['historico'] . "\n";
                }
            } else {
                $retorno = $daoFinEmpenhoHistorico->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
}