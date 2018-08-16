<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocTipoLotacao.class.php";

class DocTipoLotacao {
    private $idDocTipoLotacao = null;
    private $nmDocTipoLotacao = null;
    
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
        $retorno = '<option value="0">Selecione o Tipo do Destinatário/Remetente</option>';
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocTipoLotacao = new DaoFinDocTipoLotacao();
            $daoFinDocTipoLotacao->select($pdo);
            
            if ($daoFinDocTipoLotacao->getSucesso()) {
                foreach ($daoFinDocTipoLotacao->getMsgRetorno() as $linha) {
                    $retorno .= '<option value='.$linha['id_doc_tipo_lotacao'].'>'.$linha['nm_doc_tipo_lotacao'].'</option>';
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
            
            $idDocTipoLotacao = $daoDocTipoLotacao->getIdDocTipoLotacao();
            if (!Log::SalvaLogD('fin_doc_tipo_lotacao', $idDocTipoLotacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDocTipoLotacao->delete($pdo);
            if ($daoDocTipoLotacao->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoLotacao->getMsgRetorno());
                $pdo->rollBack();
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
                                    . "<td>".$linha['nm_doc_tipo_lotacao']."</td>"
                                    . "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-alterar'><i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden=true></i></button>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-excluir'><i class='fa fa-trash fa-lg text-danger' aria-hidden=true></i></button>"
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
