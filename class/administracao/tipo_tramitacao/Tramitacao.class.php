<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesTramitacao.class.php";

class Tramitacao {

    private $idTramitacao = null;
    private $nmTramitacao = null;
    private $stAtivo = null;
    
    function getIdTramitacao() {
        return $this->idTramitacao;
    }

    function getNmTramitacao() {
        return $this->nmTramitacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdTramitacao($idTramitacao) {
        $this->idTramitacao = $idTramitacao;
        return $this;
    }

    function setNmTramitacao($nmTramitacao) {
        $this->nmTramitacao = $nmTramitacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function optionsTramitacao(){
        $opcoes = "<option value=0>Selecione o Tipo da Tramitação</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesTramitacao = new DaoSesTramitacao();
            $daoSesTramitacao->retornaTodos($pdo);
            
            if ($daoSesTramitacao->getSucesso()) {
                foreach ($daoSesTramitacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option value=".$linha['id_tramitacao'].">".$linha['nm_tramitacao']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    function listaTramitacoes(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesTramitacao = new DaoSesTramitacao();
            $daoSesTramitacao->retornaTodos($pdo);
            
            if ($daoSesTramitacao->getSucesso()) {
                foreach ($daoSesTramitacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-id=".$linha['id_tramitacao'].">"
                                . "<td>".$linha['id_tramitacao']."</td>"
                                . "<td>".$linha['nm_tramitacao']."</td>"
                                . "<td style='text-align: center;'>";
                    
                        if ($linha['st_ativo'] == 0 ) {
                            $retorno .= "<button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' >"
                                        . "<i class='fa fa-check fa-lg text-success' aria-hidden='true'></i>"
                                    . "</button>";
                        } else {
                            $retorno .=  "<button type='button' class='btn btn-default btn-remover btn-xs' title='Desativar' >"
                                        . "<i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>"
                                    . "</button>"
                                    . "<button type='button' class='btn btn-default btn-edit btn-xs' title='Alterar' >"
                                        . "<i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>"
                                    . "</button>";
                        }
                    $retorno .=  "</td>"
                            . "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function salvarTipoTramitacao(){
        $retorno = "";
        try {
            if (empty($this->getNmTramitacao())) {
                return Metodos::retornoAjax("Erro", "alert",STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoSesTramitacao = new DaoSesTramitacao();
            $daoSesTramitacao->setNmTramitacao($this->nmTramitacao);
            $daoSesTramitacao->insert($pdo);
            
            if ($daoSesTramitacao->getSucesso()) {
                $idTramitacao = $pdo->lastInsertId('ses_tramitacao_id_tramitacao_seq');
                if (!Log::SalvaLogI('ses_tramitacao', $idTramitacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdTramitacao($idTramitacao);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console",$daoSesTramitacao->getMsgRetorno());
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function desativarTipoTramitacao(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoSesTramitacao = new DaoSesTramitacao();
            $daoSesTramitacao->setIdTramitacao($this->getIdTramitacao());
            
            $daoSesTramitacao->retorna($pdo);
            if (!$daoSesTramitacao->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoSesTramitacao->getMsgRetorno());
            } 
            
           //Se não der erro na seleção da tramitação, atribui à variável
            $reg_antigo = $daoSesTramitacao->getMsgRetorno();

            //Atualiza os registros
            $daoSesTramitacao->desativa($pdo);
 
            if ($daoSesTramitacao->getSucesso()) {

                if (!Log::SalvaLogU('ses_tramitacao', $daoSesTramitacao->getIdTramitacao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console",$daoSesTramitacao->getMsgRetorno());
            }
           
            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function ativarTipoTramitacao(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoSesTramitacao = new DaoSesTramitacao();
            $daoSesTramitacao->setIdTramitacao($this->getIdTramitacao());
            
            $daoSesTramitacao->retorna($pdo);
            if (!$daoSesTramitacao->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoSesTramitacao->getMsgRetorno());
            } 
            
           //Se não der erro na seleção da tramitação, atribui à variável
            $reg_antigo = $daoSesTramitacao->getMsgRetorno();

            //Atualiza os registros
            $daoSesTramitacao->ativa($pdo);
 
            if ($daoSesTramitacao->getSucesso()) {

                if (!Log::SalvaLogU('ses_tramitacao', $daoSesTramitacao->getIdTramitacao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console",$daoSesTramitacao->getMsgRetorno());
            }
           
            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

}

