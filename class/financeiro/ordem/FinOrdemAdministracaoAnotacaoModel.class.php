<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/DaoFinOrdemAdministracaoAnotacao.php";

class FinOrdemAdministracaoAnotacaoModel {

    private $id_ordem_administracao_anotacao = null;
    private $id_ordem_administracao = null;
    private $ds_ordem_administracao_anotacao = null;
    private $dh_ordem_administracao_anotacao = null;
    private $id_pessoa = null;
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function getIdOrdemAdministracaoAnotacao() {
        return $this->id_ordem_administracao_anotacao;
    }

    public function setIdOrdemAdministracaoAnotacao($id_ordem_administracao_anotacao) {
        $this->id_ordem_administracao_anotacao = $id_ordem_administracao_anotacao;

        return $this;
    }

    public function getIdOrdemAdministracao() {
        return $this->id_ordem_administracao;
    }

    public function setIdOrdemAdministracao($id_ordem_administracao) {
        $this->id_ordem_administracao = $id_ordem_administracao;

        return $this;
    }

    public function getDsOrdemAdministracaoAnotacao() {
        return $this->ds_ordem_administracao_anotacao;
    }

    public function setDsOrdemAdministracaoAnotacao($ds_ordem_administracao_anotacao) {
        $this->ds_ordem_administracao_anotacao = $ds_ordem_administracao_anotacao;

        return $this;
    }

    public function getDhOrdemAdministracaoAnotacao() {
        return $this->dh_ordem_administracao_anotacao;
    }

    public function setDhOrdemAdministracaoAnotacao($dh_ordem_administracao_anotacao) {
        $this->dh_ordem_administracao_anotacao = $dh_ordem_administracao_anotacao;

        return $this;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    public function cadastrarAnotacao(PDO $pdo = null) {

        $this->sucesso = false;
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinOrdemAdministracaoAnotacao = new DaoFinOrdemAdministracaoAnotacao();
            $daoFinOrdemAdministracaoAnotacao->setIdOrdemAdministracao($this->id_ordem_administracao);
            $daoFinOrdemAdministracaoAnotacao->setDsOrdemAdministracaoAnotacao($this->ds_ordem_administracao_anotacao);
            $daoFinOrdemAdministracaoAnotacao->setIdPessoa($this->id_pessoa);
            $daoFinOrdemAdministracaoAnotacao->cadastrarAnotacao($pdo);

            if (!$daoFinOrdemAdministracaoAnotacao->Sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinOrdemAdministracaoAnotacao->getMsgRetorno();
            } else {
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaAnotacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinOrdemAdministracaoAnotacao = new DaoFinOrdemAdministracaoAnotacao();
            $retorno = '';
            $daoFinOrdemAdministracaoAnotacao->setIdOrdemAdministracao($this->id_ordem_administracao);
            
            $daoFinOrdemAdministracaoAnotacao->retornaAnotacao($pdo);

            if ($daoFinOrdemAdministracaoAnotacao->sucesso()) {
                foreach ($daoFinOrdemAdministracaoAnotacao->getMsgRetorno() as $linha) {
                    $retorno .= $linha['dh_ordem_administracao_anotacao'] . " - " . $linha['nm_pessoa'] . ": " . $linha['ds_ordem_administracao_anotacao'] . "\n";
                }
            }
            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $ex) {
            
        }
    }

}
