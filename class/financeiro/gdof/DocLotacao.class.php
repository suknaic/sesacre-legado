<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocLotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincEncaminhamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincRecebimento.class.php";

class DocLotacao {

    private $idDocLotacao = null;
    private $idDocTipoLotacao = null;
    private $idLotacao = null;
    
    function getIdDocLotacao() {
        return $this->idDocLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdDocLotacao($idDocLotacao) {
        $this->idDocLotacao = $idDocLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getIdLotacao()) or empty($this->getIdDocTipoLotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->setIdLotacao($this->getIdLotacao())
                                  ->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            $daoFinDocLotacao->insert($pdo);
            
            if ($daoFinDocLotacao->getSucesso()) {
                $idDocLotacao = $pdo->lastInsertId('fin_doc_lotacao_id_doc_lotacao_seq');
                if (!Log::SalvaLogI('fin_doc_lotacao', $idDocLotacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdDocLotacao($idDocLotacao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());
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
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->setIdDocLotacao($this->getIdDocLotacao());
            
            $daoFinDocLotacao->selectLinha($pdo);
            if(!$daoFinDocLotacao->getSucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }                        
            
            $busca = $daoFinDocLotacao->getMsgRetorno();
                        
            /**
             * Se o Doc Lotação tiver alguma dependencia, então não poderá ser excluido
             */
            
            
            /**
             * Exclui todas as Pessoas que estão com autorização para encaminar
             * ou receber
             */          
            
            $docEncaminha = new DocVincEncaminhamento();
            $docEncaminha->setIdDocLotacao($daoFinDocLotacao->getIdDocLotacao());
            $docEncaminha->excluirTodosDocLotacao($pdo);
            if(!$docEncaminha->getSucesso()){
                return Metodos::retornoAjax("Erro", "console", $docEncaminha->getMsgRetorno());
            }
            
            
            $docRecebe = new DocVincRecebimento();
            $docRecebe->setIdDocLotacao($daoFinDocLotacao->getIdDocLotacao());
            $docRecebe->excluirTodosDocLotacao($pdo);
            if(!$docRecebe->getSucesso()){
                return Metodos::retornoAjax("Erro", "console", $docRecebe->getMsgRetorno());
            }
                        
            /*
             * Verifica se o Doc Lotação está sendo utilizado 
             * em alguma tramitação
             */
            $daoFinDocLotacao->verificaTramitacaoExiste($pdo);
            /*
             * Se o retorno for True, então existe alguma Tramitação com o Doc Lotação
             * então teremos que desativar o Doc Lotação
             */            
            if($daoFinDocLotacao->getSucesso()){
                                                                
                $daoFinDocLotacao->desativa($pdo);
                if(!$daoFinDocLotacao->getSucesso()){                
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());
                }

                if (!Log::SalvaLogU('fin_doc_lotacao', $daoFinDocLotacao->getIdDocLotacao(), $busca, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());                                                            
                }      
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Por Já existir um Tipo de Remetente/Destinatário Tramitado, então o "
                        . "registro foi desativado.");
                
            //Se não existe tramitação, então podemos Excluir o Doc Lotação da Base
            }else{              
                if (!Log::SalvaLogD('fin_doc_lotacao', $daoFinDocLotacao->getIdDocLotacao(), $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $daoFinDocLotacao->delete($pdo);
                if ($daoFinDocLotacao->getSucesso()) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());
                    
                }                                
            }
            
                                    
            
            $pdo->rollBack();
            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
            return $retorno;                                                                                   
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function ativar(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->setIdDocLotacao($this->getIdDocLotacao());
            
            $daoFinDocLotacao->selectLinha($pdo);
            if(!$daoFinDocLotacao->getSucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }                        
            
            $busca = $daoFinDocLotacao->getMsgRetorno();
                                    
            if($daoFinDocLotacao->getSucesso()){
                                                                
                $daoFinDocLotacao->ativar($pdo);
                if(!$daoFinDocLotacao->getSucesso()){                
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());
                }

                if (!Log::SalvaLogU('fin_doc_lotacao', $daoFinDocLotacao->getIdDocLotacao(), $busca, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocLotacao->getMsgRetorno());                                                            
                }      
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Registro Ativado Com Sucesso.");                            
            }
                                                            
            $pdo->rollBack();
            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
            return $retorno;                                                                                   
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function optionsTipoLotacao(){
        try {
            $retorno = "<option value=0>Selecione um Destinatário/Remetente</option>";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            
            if ($this->getIdDocTipoLotacao()) {
                $daoFinDocLotacao->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            }
            $daoFinDocLotacao->select($pdo);
            
            if ($daoFinDocLotacao->getSucesso()) {
                foreach ($daoFinDocLotacao->getMsgRetorno() as $linha) {
                    $retorno .= "<option data-objeto='". json_encode($linha)."' value=".$linha['id_doc_lotacao'].">". $linha['nm_doc_tipo_lotacao'] ." / ".$linha['nm_lotacao']."</option>";
                }
            } else {
                $retorno = $daoFinDocLotacao->getMsgRetorno();
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocLotacao = new DaoFinDocLotacao();
            $daoFinDocLotacao->select($pdo);
            
            if ($daoFinDocLotacao->getSucesso()) {
                foreach ($daoFinDocLotacao->getMsgRetorno() as $linha) {
                    
                    $icone = "fa-trash";
                    $nomeBtn = "btn-excluir";
                    $corBtn = "text-danger";
                    $title = "Remover";
                    if($linha['st_ativo'] == 0){
                        $icone = "fa-check";
                        $nomeBtn = "btn-ativar";
                        $corBtn = "text-success";
                        $title = "Ativar";
                    }
                    
                    
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_doc_tipo_lotacao']."</td>"
                                    . "<td>".$linha['nm_lotacao']."</td>"
                                    . "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs ".$nomeBtn."' title='".$title."'>"
                                        . "<i class='fa ".$icone." fa-lg ".$corBtn."' aria-hidden=true></i></button>"
                                    . "</td>"
                             . "</tr>";
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
}