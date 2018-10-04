<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesVincularTramitacao.class.php";

class VincularTramitacao {

    private $idVincularTramitacao = null;
    private $idTramitacao = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $sucesso = false;
    private $msgRetorno = null;
   
    function Sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function getIdVincularTramitacao() {
        return $this->idVincularTramitacao;
    }

    function getIdTramitacao() {
        return $this->idTramitacao;
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

    function setIdVincularTramitacao($idVincularTramitacao) {
        $this->idVincularTramitacao = $idVincularTramitacao;
        return $this;
    }

    function setIdTramitacao($idTramitacao) {
        $this->idTramitacao = $idTramitacao;
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


    public function cadastrar(){
        try {  
            
            if (empty($this->getIdTramitacao()) or empty($this->getIdPessoa()) or empty($this->getIdLotacao()) or empty($this->getIdDocTipoLotacao())){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->setIdTramitacao($this->getIdTramitacao())
                                     ->setIdPessoa($this->getIdPessoa())
                                     ->setIdLotacao($this->getIdLotacao())
                                     ->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            
            $daoSesVincularTramitacao->insert($pdo);
            
            if ($daoSesVincularTramitacao->getSucesso()) {
                
                $idVincularTramitacao = $pdo->lastInsertId('ses_vincular_tramitacao_id_vincular_tramitacao_seq');
                if (!Log::SalvaLogI('ses_vincular_tramitacao', $idVincularTramitacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $this->setIdVincularTramitacao($idVincularTramitacao);
                $pdo->commit();
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincEncaminhamento->getMsgRetorno());
            }

            return $retorno;                                                                                                        
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    function excluir(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->setIdVincularTramitacao($this->getIdVincularTramitacao());
            
            $idVincularTramitacao = $daoSesVincularTramitacao->getIdVincularTramitacao();
            if (!Log::SalvaLogD('ses_vincular_tramitacao', $idVincularTramitacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoSesVincularTramitacao->delete($pdo);
            if ($daoSesVincularTramitacao->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoSesVincularTramitacao->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function listaTodos(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->selectTodosComDescritivos($pdo);
            
            if ($daoSesVincularTramitacao->getSucesso()) {
                foreach ($daoSesVincularTramitacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                . "<td class='text-center'>".$linha['nm_pessoa']."</td>"
                                . "<td class='text-center'>".$linha['nm_tramitacao']."</td>"
                                . "<td class='text-center'>".$linha['nm_lotacao']."</td>"
                                . "<td class='text-center'>".$linha['nm_doc_tipo_lotacao']."</td>"
                                . "<td class='text-center'>"
                                    . "<button type='button' title='Remover Registro' class='remover-vinculo'>"
                                        . "<i class='fa fa-trash text-danger' aria-hidden='true'></i>"
                                    . "</button>"
                                . "</td>"
                              . "</tr>";
                }
            } 
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    function listaLotacaoTipoPorUsuario(){
        $opcoes = "<option value=0>Selecione o Tipo de Remetente/Remetente</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->setIdPessoa($this->getIdPessoa());
            
            $daoSesVincularTramitacao->retornaLotacaoTipoLiquidacaoPorUsuario($pdo);
            
            if ($daoSesVincularTramitacao->getSucesso()) {
                foreach ($daoSesVincularTramitacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-tipo-lotacao=".$linha['id_doc_tipo_lotacao']." data-lotacao=".$linha['id_lotacao'].">".$linha['nm_doc_tipo_lotacao']." - ".$linha['nm_lotacao']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
        function listaLotacaoTipoPorUsuarioPagamento(){
        $opcoes = "<option value=0>Selecione o Tipo de Remetente/Remetente</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->setIdPessoa($this->getIdPessoa());
            
            $daoSesVincularTramitacao->retornaLotacaoTipoPagamentoPorUsuario($pdo);
            
            if ($daoSesVincularTramitacao->getSucesso()) {
                foreach ($daoSesVincularTramitacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-tipo-lotacao=".$linha['id_doc_tipo_lotacao']." data-lotacao=".$linha['id_lotacao'].">".$linha['nm_doc_tipo_lotacao']." - ".$linha['nm_lotacao']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function listaLotacaoTipoPorLotacaoETipo(){
       $opcoes = "<option value=0>Selecione o Tipo de Remetente/Remetente</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                                     ->setIdLotacao($this->getIdLotacao());
            
            $daoSesVincularTramitacao->retornaLotacaoTipoLiquidacaoPorTipoELotacao($pdo);
            
            if ($daoSesVincularTramitacao->getSucesso()) {
                foreach ($daoSesVincularTramitacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-tipo-lotacao=".$linha['id_doc_tipo_lotacao']." data-lotacao=".$linha['id_lotacao']." selected>".$linha['nm_doc_tipo_lotacao']." - ".$linha['nm_lotacao']."</option>";
                }
            } else {
                $opcoes .= "<option>Teste</option>";
            }
            return $opcoes;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        } 
    }
    
    public function retornaLiquidacaoPorUsuario(PDO $pdo){
        try {
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoSesVincularTramitacao = new DaoSesVincularTramitacao();
            $daoSesVincularTramitacao->setIdPessoa($this->idPessoa);                                     
            
            $daoSesVincularTramitacao->retornaLotacaoTipoLiquidacaoPorUsuario($pdo);
            
            if ($daoSesVincularTramitacao->getSucesso()) {
                $this->sucesso = true;
                $this->msgRetorno = $daoSesVincularTramitacao->getMsgRetorno();
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não possui registro";
            }                                               
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }  
    }
   
}

