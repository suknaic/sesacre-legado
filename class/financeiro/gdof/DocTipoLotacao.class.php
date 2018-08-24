<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocTipoLotacao.class.php";

class DocTipoLotacao {
    private $idDocTipoLotacao = null;
    private $nmDocTipoLotacao = null;
    private $sucesso = false;
    private $mensagens = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMensagens() {
        return $this->mensagens;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
        return $this;
    }

    function setMensagens($mensagens) {
        $this->mensagens = $mensagens;
        return $this;
    }
    
    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getNmDocTipoLotacao() {
        return $this->nmDocTipoLotacao;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setNmDocTipoLotacao($nmDocTipoLotacao) {
        $this->nmDocTipoLotacao = $nmDocTipoLotacao;
        return $this;
    }

        
    public function optionsTipoLotacao(){
        $retorno = '<option value="0">Selecione o Tipo do Remetente/Destinatário</option>';
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoFinDocTipoLotacao->select($pdo);
            
            if ($daoFinDocTipoLotacao->getSucesso()) {
                foreach ($daoFinDocTipoLotacao->getMsgRetorno() as $linha) {
                    if ($linha['st_ativo'] == '1') {
                        $retorno .= '<option value='.$linha['id_doc_tipo_lotacao'].'>'.$linha['nm_doc_tipo_lotacao'].'</option>';
                    }
                }
            } else {
                $retorno = $daoFinDocTipoLotacao->getMsgRetorno();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getNmDocTipoLotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoDocTipoLotacao->setNmDocTipoLotacao($this->getNmDocTipoLotacao());
            $daoDocTipoLotacao->insert($pdo);
            
            if ($daoDocTipoLotacao->getSucesso()) {
                $idDocTipoLotacao = $pdo->lastInsertId('fin_doc_tipo_lotacao_id_doc_tipo_lotacao_seq');
                if (!Log::SalvaLogI('fin_doc_tipo_lotacao', $idDocTipoLotacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdDocTipoLotacao($idDocTipoLotacao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoLotacao->getMsgRetorno());
            }
            return $retorno;                                                                                                        
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    function alterar(){
        try {
            
            if (empty($this->getNmDocTipoLotacao())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $retorno = "";

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoDocTipoLotacao->setNmDocTipoLotacao($this->getNmDocTipoLotacao());
            $daoDocTipoLotacao->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
           

            //Retorna os dados antes da alteração
            $daoDocTipoLotacao->selectLinha($pdo);

            if (!$daoDocTipoLotacao->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoDocTipoLotacao->getMsgRetorno());
            }
            
            //Se não der erro na seleção do registro do decreto valor, atribui à variável
            $reg_antigo = $daoDocTipoLotacao->getMsgRetorno();
            
            $daoDocTipoLotacao->update($pdo);

            if ($daoDocTipoLotacao->getSucesso()) {

                //Registra no log
                if (!Log::SalvaLogU('fin_doc_tipo_lotacao', $daoDocTipoLotacao->getIdDocTipoLotacao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoLotacao->getMsgRetorno());
            }

            return $retorno;

        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function excluir(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
           
            $daoDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoDocTipoLotacao->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            
            
            $daoDocTipoLotacao->selectLinha($pdo);
            if(!$daoDocTipoLotacao->getSucesso()){    
                $this->sucesso = false;
                $this->mensagens = STR_ERROR;
                return true;
                
            }                        
            
            $busca = $daoDocTipoLotacao->getMsgRetorno();       
            
            
            //Neste trecho irá  eliminar os parâmetros que possuem este tipo de remetente/destinatário
            $parmTramitacao = new DocParmTramitacao();
            $parmTramitacao->setIdDocTipoRemetente($this->getIdDocTipoLotacao());
            $parmTramitacao->setIdDocTipoDestinatario($this->getIdDocTipoLotacao());
            $parmTramitacao->excluirTodosParmTramitacao($pdo);          
            if(!$parmTramitacao->getSucesso()){
                $this->sucesso = false;
                $this->mensagens = $parmTramitacao->getMsgRetorno();
                return true;                
            }
            //****************************************************************************************
            
            //Neste trecho irá desativar ou excluir os registros da Fin_doc_lotacao que possuem o ID Doc Tipo Lotacao
            $daoDocTipoLotacao->selectDocLotacaoTodosPorTipo($pdo);
            $arrayAuxiliar = null;

            if ($daoDocTipoLotacao->getSucesso()) {

                $arrayAuxiliar = $daoDocTipoLotacao->getMsgRetorno();
                $docLotacao = new DocLotacao();
                
                foreach ($daoDocTipoLotacao->getMsgRetorno() as $key => $linha) {
                    
                    //irá executar a exclusão apenas para os ativos
                    if ($linha["st_ativo"] == '1') {
                        $docLotacao->setIdDocLotacao($linha['id_doc_lotacao']);
                        $docLotacao->excluirDocLotacaoCompleto($pdo);

                        if(!$docLotacao->getSucesso()){            
                            return Metodos::retornoAjax("Erro", "console", $docLotacao->getMsgRetorno());      
                        }
                        
                        //remove do array o registro que for excluido de fato
                        if($docLotacao->getExcluido()){
                            unset($arrayAuxiliar[$key]);
                        }
                    }
                    
                }
            }
            //*******************************************************************************************************
            
            //Verifica se ainda existe algum registro vinculado para definir se irá desativar o registro ou excluir
            //se houver outros registros vinculados, será feito a desativação
            if (!empty($arrayAuxiliar)) {
                $daoDocTipoLotacao->desativa($pdo);
                if ($daoDocTipoLotacao->getSucesso()) {
                    
                    if (!Log::SalvaLogU('fin_doc_tipo_lotacao', $daoDocTipoLotacao->getIdDocTipoLotacao(), $busca, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);                                                     
                    }    
                    
                    $pdo->commit();
                    $retorno = Metodos::retornoAjax("ok", "html", "Por existir outras informações vinculadas a este registro, será feito a desativação deste.");
                } else {
                    $pdo->rollBack();
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoLotacao->getMsgRetorno());
                }
            } else {
                if (!Log::SalvaLogD('fin_doc_tipo_lotacao', $daoDocTipoLotacao->getIdDocTipoLotacao(), $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $daoDocTipoLotacao->delete($pdo);
                if ($daoDocTipoLotacao->getSucesso()) {
                    $pdo->commit();
                    $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                } else {
                    $pdo->rollBack();
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoLotacao->getMsgRetorno());
                }
            }
            
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoDocTipoLotacao->select($pdo);
            
            if ($daoDocTipoLotacao->getSucesso()) {
                foreach ($daoDocTipoLotacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_doc_tipo_lotacao']."</td>";
                    
                    if($linha['st_ativo'] == '1'){
                        $retorno .=  "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-alterar' title='Editar'><i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden=true></i></button>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-excluir' title='Excluir'><i class='fa fa-trash fa-lg text-danger' aria-hidden=true></i></button>"
                                    . "</td>";
                    } else {
                        $retorno .=  "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-ativar' title='Ativar'><i class='fa fa-check fa-lg text-success' aria-hidden=true></i></button>"
                                    . "</td>";
                    }
                    $retorno .= "</tr>";
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    
    function ativar(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoFinDocTipoLotacao->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            
            $daoFinDocTipoLotacao->selectLinha($pdo);
            if(!$daoFinDocTipoLotacao->getSucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }                        
            
            $busca = $daoFinDocTipoLotacao->getMsgRetorno();
                                    
            if($daoFinDocTipoLotacao->getSucesso()){
                                                                
                $daoFinDocTipoLotacao->ativa($pdo);
                if(!$daoFinDocTipoLotacao->getSucesso()){                
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocTipoLotacao->getMsgRetorno());
                }

                if (!Log::SalvaLogU('fin_doc_tipo_lotacao', $daoFinDocTipoLotacao->getIdDocTipoLotacao(), $busca, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $daoFinDocTipoLotacao->getMsgRetorno());                                                            
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
}
