<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacaoAnotacao.class.php";

class LiquidacaoAnotacao {

    private $id_liquidacao_anotacao = null;
    private $id_pessoa = null;
    private $id_liquidacao = null;
    private $dh_liquidacao_anotacao = null;
    private $ds_liquidacao_anotacao = null;
    
    private $msg_erros = null;
    
    function getMsgErros() {
        return $this->msg_erros;
    }

        
    function getIdLiquidacaoAnotacao() {
        return $this->id_liquidacao_anotacao;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getIdLiquidacao() {
        return $this->id_liquidacao;
    }

    function getDhLiquidacaoAnotacao() {
        return $this->dh_liquidacao_anotacao;
    }

    function getDsLiquidacaoAnotacao() {
        return $this->ds_liquidacao_anotacao;
    }

    function setIdLiquidacaoAnotacao($id_liquidacao_anotacao) {
        $this->id_liquidacao_anotacoa = $id_liquidacao_anotacao;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    function setIdLiquidacao($id_liquidacao) {
        $this->id_liquidacao = $id_liquidacao;
        return $this;
    }

    function setDhLiquidacaoAnotacao($dh_liquidacao_anotacao) {
        $this->dh_liquidacao_anotacao = $dh_liquidacao_anotacao;
        return $this;
    }

    function setDsLiquidacaoAnotacao($ds_liquidacao_anotacao) {
        $this->ds_liquidacao_anotacao = $ds_liquidacao_anotacao;
        return $this;
    }

    public function salvar(PDO $pdo = null) {
        try {
            if (empty($this->id_liquidacao) or empty($this->ds_liquidacao_anotacao) or empty($this->id_pessoa)) {
                $this->msg_erros = "Não foi possível salvar a anotação, alguma informação obrigatória não foi informada.";
                return false;
            }

            $daoConLiquidacaoAnotacao = new DaoConLiquidacaoAnotacao();
            $daoConLiquidacaoAnotacao->setIdLiquidacao($this->id_liquidacao)
                    ->setIdPessoa($this->id_pessoa)
                    ->setDsLiquidacaoAnotacao($this->ds_liquidacao_anotacao);

            $daoConLiquidacaoAnotacao->insert($pdo);


            if (!$daoConLiquidacaoAnotacao->sucesso()) {
                $this->msg_erros = $daoConLiquidacaoAnotacao->getMsgRetorno();
                return false;
            }

            $this->id_liquidacao_anotacao = ($pdo->lastInsertId('con_liquidacao_anotacao_id_liquidacao_anotacao_seq'));

            if (!Log::SalvaLogI('con_liquidacao_anotacao', $this->id_liquidacao_anotacao, $pdo)) {
                $this->msg_erros = 'Erro ao salvar a anotação no LOG';
                return false;
            }
            return true;
        } catch (Exception $exc) {
             $this->msg_erros = $exc->getMessage();
             return false;
        }
    }
    
    public function salvarComRetorno() {
        try {
            if (empty($this->id_liquidacao) or empty($this->ds_liquidacao_anotacao) or empty($this->id_pessoa)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível salvar a anotação, alguma informação obrigatória não foi informada.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoConLiquidacaoAnotacao = new DaoConLiquidacaoAnotacao();
            $daoConLiquidacaoAnotacao->setIdLiquidacao($this->id_liquidacao)
                    ->setIdPessoa($this->id_pessoa)
                    ->setDsLiquidacaoAnotacao($this->ds_liquidacao_anotacao);

            $daoConLiquidacaoAnotacao->insert($pdo);


            if (!$daoConLiquidacaoAnotacao->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salvar a anotação para a Liquidação.");
            }

            $this->id_liquidacao_anotacao = ($pdo->lastInsertId('con_liquidacao_anotacao_id_liquidacao_anotacao_seq'));

            if (!Log::SalvaLogI('con_liquidacao_anotacao', $this->id_liquidacao_anotacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao inserir a Anotação no LOG.");
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Anotação salva com sucesso.");
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }
    
    public function listaAnotacoes(){
        try {
            if (empty($this->id_liquidacao)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível listar as anotações, alguma informação obrigatória não foi informada.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConLiquidacaoAnotacao = new DaoConLiquidacaoAnotacao();
            $daoConLiquidacaoAnotacao->setIdLiquidacao($this->id_liquidacao);
            $retorno = '';        
            $daoConLiquidacaoAnotacao->lista($pdo);
            
            if($daoConLiquidacaoAnotacao->sucesso()){
                foreach ($daoConLiquidacaoAnotacao->getMsgRetorno() as $linha){
                    $retorno .= $linha['dh_liquidacao_anotacao'] ." - ". $linha['nm_pessoa'] .": ".$linha['ds_liquidacao_anotacao']. "\n";
                }
            }

            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }

}

