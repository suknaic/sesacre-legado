<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinDocTipoDestinatario.class.php";

class DocTipoDestinatario {
    private $idDocTipoDestinatario = null;
    private $nmDocTipoDestinatario = null;
    
    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getNmDocTipoDestinatario() {
        return $this->nmDocTipoDestinatario;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setNmDocTipoDestinatario($nmDocTipoDestinatario) {
        $this->nmDocTipoDestinatario = $nmDocTipoDestinatario;
        return $this;
    }

    public function cadastrar(){
        try {  
            
            if (empty($this->getNmDocTipoDestinatario())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoDocTipoDestinatario = new DaoFinDocTipoDestinatario();
            $daoDocTipoDestinatario->setNmDocTipoDestinatario($this->getNmDocTipoDestinatario());
            $daoDocTipoDestinatario->insert($pdo);
            
            if ($daoDocTipoDestinatario->getSucesso()) {
                $idDocTipoDestinatario = $pdo->lastInsertId('fin_doc_tipo_destinatario_id_doc_tipo_destinatario_seq');
                if (!Log::SalvaLogI('fin_doc_tipo_destinatario', $idDocTipoDestinatario, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdDocTipoDestinatario($idDocTipoDestinatario);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Valor incluído com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoDestinatario->getMsgRetorno());
            }
            return $retorno;                                                                                                        
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    function alterar(){
        try {
            
            if (empty($this->getNmDocTipoDestinatario())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $retorno = "";

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoDocTipoDestinatario = new DaoFinDocTipoDestinatario();
            $daoDocTipoDestinatario->setNmDocTipoDestinatario($this->getNmDocTipoDestinatario());
            $daoDocTipoDestinatario->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario());
           

            //Retorna os dados antes da alteração
            $daoDocTipoDestinatario->selectLinha($pdo);

            if (!$daoDocTipoDestinatario->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoDocTipoDestinatario->getMsgRetorno());
            }
            
            //Se não der erro na seleção do registro do decreto valor, atribui à variável
            $reg_antigo = $daoDocTipoDestinatario->getMsgRetorno();
            
            $daoDocTipoDestinatario->update($pdo);

            if ($daoDocTipoDestinatario->getSucesso()) {

                //Registra no log
                if (!Log::SalvaLogU('fin_doc_tipo_destinatario', $daoDocTipoDestinatario->getIdDocTipoDestinatario(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Alteração realizada com sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoDestinatario->getMsgRetorno());
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
            
            $daoDocTipoDestinatario = new DaoFinDocTipoDestinatario();
            $daoDocTipoDestinatario->setIdDocTipoDestinatario($this->getIdDocTipoDestinatario());
            
            $idDocTipoDestinatario = $daoDocTipoDestinatario->getIdDocTipoDestinatario();
            if (!Log::SalvaLogD('fin_doc_tipo_destinatario', $idDocTipoDestinatario, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDocTipoDestinatario->delete($pdo);
            if ($daoDocTipoDestinatario->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDocTipoDestinatario->getMsgRetorno());
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
            
            $daoDocTipoDestinatario = new DaoFinDocTipoDestinatario();
            $daoDocTipoDestinatario->select($pdo);
            
            if ($daoDocTipoDestinatario->getSucesso()) {
                foreach ($daoDocTipoDestinatario->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_doc_tipo_destinatario']."</td>"
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
