<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoPagamentoAnotacoes.class.php";

class ConPagamentoAnotacoes {

    private $id_pagamento_anotacao = null;
    private $id_pessoa = null;
    private $id_pagamento = null;
    private $dh_pagamento_anotacao = null;
    private $ds_pagamento_anotacao = null;
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function getIdPagamentoAnotacao() {
        return $this->id_pagamento_anotacao;
    }

    public function setIdPagamentoAnotacao($id_pagamento_anotacao) {
        $this->id_pagamento_anotacao = $id_pagamento_anotacao;

        return $this;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getDhPagamentoAnotacao() {
        return $this->dh_pagamento_anotacao;
    }

    public function setDhPagamentoAnotacao($dh_pagamento_anotacao) {
        $this->dh_pagamento_anotacao = $dh_pagamento_anotacao;

        return $this;
    }

    public function getDsPagamentoAnotacao() {
        return $this->ds_pagamento_anotacao;
    }

    public function setDsPagamentoAnotacao($ds_pagamento_anotacao) {
        $this->ds_pagamento_anotacao = $ds_pagamento_anotacao;

        return $this;
    }

    public function salvaAnotacaoPagamento(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $this->sucesso = false;

            $daoAnotacoes = new DaoPagamentoAnotacoes();
            $daoAnotacoes->setIdPagamento($this->id_pagamento);
            $daoAnotacoes->setIdPessoa($this->id_pessoa);
            $daoAnotacoes->setDsPagamentoAnotacao($this->ds_pagamento_anotacao);
            $daoAnotacoes->salvaAnotacoes($pdo);

            if ($daoAnotacoes->Sucesso()) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = "erro no cadastramento da anotação";
        }
    }

    public function retornaAnotacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoAnotacoes = new DaoPagamentoAnotacoes();
            $retorno = '';
            $daoAnotacoes->setIdPagamento($this->id_pagamento);
            $daoAnotacoes->retornaAnotacao($pdo);
            
             if($daoAnotacoes->sucesso()){
                foreach ($daoAnotacoes->getMsgRetorno() as $linha){
                    $retorno .= $linha['dh_pagamento_anotacao'] ." - ". $linha['nm_pessoa'] .": ".$linha['ds_pagamento_anotacao']. "\n";
                }
            }
            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $ex) {
            
        }
    }

}
