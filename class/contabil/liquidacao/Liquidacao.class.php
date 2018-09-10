<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacao.class.php";

class Liquidacao {

    private $idLiquidacao = null;
    private $nrLiquidacao = null;
    private $idEmpenho = null;
    private $idLiquidacaoSituacao = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $dtLiquidacao = null;
    private $vlLiquidacao = null;
    private $dsLiquidacao = null;
    private $stAtivo = null;
    
    private $documentos = null;
    
    private $usuario = null;
    private $mensagens = null;
    private $sucesso = null;
    
    private $motivoCancelamento = null;
    
    private $sitLiquidado = 1;
    private $sitPagoParcial = 2;
    private $sitPago = 3;
    private $sitCancelado = 4;
    
    function getMotivoCancelamento() {
        return $this->motivoCancelamento;
    }

    function setMotivoCancelamento($motivoCancelamento) {
        $this->motivoCancelamento = $motivoCancelamento;
        return $this;
    }

    function getSitLiquidado() {
        return $this->sitLiquidado;
    }

    function getSitPagoParcial() {
        return $this->sitPagoParcial;
    }

    function getSitPago() {
        return $this->sitPago;
    }

    function getSitCancelado() {
        return $this->sitCancelado;
    }
    
    function getMensagens() {
        return $this->mensagens;
    }

    function getSucesso() {
        return $this->sucesso;
    }
    
    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
        return $this;
    }
    
    function getIdLiquidacao() {
        return $this->idLiquidacao;
    }

    function setIdLiquidacao($idLiquidacao) {
        $this->idLiquidacao = $idLiquidacao;
        return $this;
    }
    
    function getNrLiquidacao() {
        return $this->nrLiquidacao;
    }

    function getIdEmpenho() {
        return $this->idEmpenho;
    }

    function getIdLiquidacaoSituacao() {
        return $this->idLiquidacaoSituacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getDtLiquidacao() {
        return $this->dtLiquidacao;
    }

    function getVlLiquidacao() {
        return $this->vlLiquidacao;
    }

    function getDsLiquidacao() {
        return $this->dsLiquidacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function getDocumentos() {
        return $this->documentos;
    }

    function setNrLiquidacao($nrLiquidacao) {
        $this->nrLiquidacao = $nrLiquidacao;
        return $this;
    }

    function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
        return $this;
    }

    function setIdLiquidacaoSituacao($idLiquidacaoSituacao) {
        $this->idLiquidacaoSituacao = $idLiquidacaoSituacao;
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

    function setDtLiquidacao($dtLiquidacao) {
        $this->dtLiquidacao = $dtLiquidacao;
        return $this;
    }

    function setVlLiquidacao($vlLiquidacao) {
        $this->vlLiquidacao = $vlLiquidacao;
        return $this;
    }

    function setDsLiquidacao($dsLiquidacao) {
        $this->dsLiquidacao = $dsLiquidacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function setDocumentos($documento) {
        $this->documentos = $documento;
        return $this;
    }

    public function retornaDadosLiquidacao(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
            $daoConLiquidacao->retornaDadosLiquidacao($pdo);
            return $daoConLiquidacao->getMsgRetorno();
            
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornaHistorico(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConLiquidacaoHistorico = new DaoConLiquidacaoHistorico();
            $daoConLiquidacaoHistorico->setIdLiquidacao($this->getIdLiquidacao());
            
            $daoConLiquidacaoHistorico->historico($pdo);
            
            if ($daoConLiquidacaoHistorico->Sucesso()) {
                foreach ($daoConLiquidacaoHistorico->getMsgRetorno() as $linha) {
                    $retorno .= $linha['historico'] . "\n";
                }
            } else {
                $retorno = $daoConLiquidacaoHistorico->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }

        
    }
    
    public function montaTabelaDocumentosLiquidacao(bool $edita = true) {
        try {
            $tabela = '';
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
            $daoConLiquidacao->retornaDocumentosPorLiquidacao($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $tabela .= "<tr data-id=".$linha['id_documento_fiscal']." data-objeto='". json_encode($linha)."' class='documentoFiscal'>"
                                . "<td class='text-center'>".$linha['nr_documento_fiscal']."</td>"
                                . "<td class='text-center'>".$linha['nm_tipo_documento']."</td>"
                                . "<td class='text-center'>".$linha['competencia']."</td>"
                                . "<td class='text-center'>".$linha['dt_emissao']."</td>"
                                . "<td class='text-center'>".$linha['dt_atesto']."</td>"
                                . "<td class='text-center'>".$linha['vl_documento']."</td>"
                                . "<td class='text-center'>".$linha['vl_documento']."</td>"
                                . "<td class='text-center'>".$linha['nm_situacao']."</td>"
                                . "<td class='text-center'>"
                                    . "<button type='button' title='Ver Documento Fiscal' class='ver-documento' value=".$linha['id_documento_fiscal'].">"
                                        . "<i class='fa fa-file-text-o text-info' aria-hidden='true'></i>"
                                    . "</button>";
                    if ($edita) {
                        $tabela .=  "<button type='button' title='Remover Documento Fiscal' class='remover-documento'>"
                                        . "<i class='fa fa-trash text-danger' aria-hidden='true'></i>"
                                    . "</button>";
                    }
                        
                     $tabela .= "</td></tr>";
                }
            }
            return $tabela;
        } catch (Exception $exc) {
            return $ex->getMessage();
        }
    }
    
    public function retornaOptionsDocsEmpenho(){
        try {
            $opcoes = "<option value=0>Selecione um Documento Fiscal</option>";
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho());
            $daoConLiquidacao->retornaDocumentosPorEmpenho($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-objeto='". json_encode($linha)."' value=".$linha['id_documento_fiscal'].">".$linha['nr_documento_fiscal']. ' - ' .$linha['competencia']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    
    function verificaDocumentosDiferenteDeALiquidar(PDO $pdo = null){
        $this->sucesso = false;
        try {
            if (!empty($pdo)) {
                $daoConLiquidacao = new DaoConLiquidacao();
                $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
                
                $filtroDocumentos = implode(', ', $this->getDocumentos());
                
                $daoConLiquidacao->retornaDocumentosFiscaisDiferentesDeALiquidar($pdo, $filtroDocumentos);
                
                if ($daoConLiquidacao->Sucesso()) {
                    $this->sucesso = true;
                } else {
                    $this->mensagens = $daoConLiquidacao->getMsgRetorno();
                }
                return $this->sucesso;
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
    
    public function salvarLiquidacao(){
        try {
            
            if (empty($this->getIdEmpenho()) || empty($this->getIdLotacao()) 
                    || empty($this->getIdDocTipoLotacao()) || empty($this->getNrLiquidacao())
                    || empty($this->getDtLiquidacao()) || empty($this->getVlLiquidacao())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho())
                             ->setIdLiquidacaoSituacao($this->getSitLiquidado())
                             ->setIdLotacao($this->getIdLotacao())
                             ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                             ->setNrLiquidacao($this->getNrLiquidacao())
                             ->setDtLiquidacao($this->getDtLiquidacao())
                             ->setVlLiquidacao(Metodos::ConverteValorIng($this->getVlLiquidacao()))
                             ->setDsLiquidacao($this->getDsLiquidacao());
            
            $daoConLiquidacao->insert($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                $idLiquidacao = $pdo->lastInsertId('con_liquidacao_id_liquidacao_seq');
                if (!Log::SalvaLogI('con_liquidacao', $idLiquidacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Liquidação no LOG. Operação Cadastro.");
                }
                $this->setIdLiquidacao($idLiquidacao); //Id da Liquidação
                $this->setIdLiquidacaoSituacao($this->getSitLiquidado()); //Status da Liquidação
                
                //Se a edição da liquidação possuir documentos fiscais, 
                //verifica se os mesmos encontram-se na situação de 'A Liquidar'
                if ($this->getDocumentos()) {
                    if($this->verificaDocumentosDiferenteDeALiquidar($pdo)){
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Há documentos com situação diferente de 'A Liquidar'.");
                    }
                }
                
                //Salva os Documentos Fiscais na Liquidação
                if (!$this->salvarDocumentosLiquidacao($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                }
                
                //Salva Historico da Liquidacao
                if (!$this->salvarLiquidacaoHistorico($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                }
                
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                return Metodos::retornoAjax("Erro", "alert", $daoConLiquidacao->getMsgRetorno());
            }
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }
    
    function salvarDocumentosLiquidacao(PDO $pdo = null){
        try {
            $this->sucesso = true;
            
            if (!empty($pdo)) {
                if ($this->getDocumentos()) {
                    $liquidacaoDoc = new LiquidacaoDoc();

                    $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());

                    foreach ($this->getDocumentos() as $indice => $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento[$indice]);
                        $liquidacaoDoc->salvarLiquidacaoDoc($pdo);

                        if (!$liquidacaoDoc->getSucesso()) { //Retorna o erro se der problema ao salvar o documento fiscal
                            $this->sucesso = false;
                            $this->mensagens = $liquidacaoDoc->getMensagens();
                            return false;
                        }
                    }
                }
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }
            
            return $this->sucesso;
        } catch (Exception $exc) {
             //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
    
    function salvarLiquidacaoHistorico(PDO $pdo = null){
        try {
            $this->sucesso = true;
            if (!empty($pdo)) {
                $liquidacaoHistorico = new LiquidacaoHistorico();
                $liquidacaoHistorico->setIdLotacao($this->getIdLotacao())
                                    ->setIdLiquidacao($this->getIdLiquidacao())
                                    ->setIdPessoa($this->getUsuario())
                                    ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                                    ->setIdLiquidacaoSituacao($this->getIdLiquidacaoSituacao())
                                    ->setDsLiquidacao($this->getDsLiquidacao());
                
                $liquidacaoHistorico->salvarLiquidacaoHistorico($pdo);
                 
                if (!$liquidacaoHistorico->getSucesso()) {
                    $this->sucesso = false;
                    $this->mensagens = $liquidacaoHistorico->getMensagens();
                    return false;
                }
                
                return $this->sucesso;
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
             //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
    
    function alterarLiquidacao(){
        try{
            
            if (empty($this->getIdLiquidacao()) || empty($this->getNrLiquidacao()) 
                    || empty($this->getDtLiquidacao()) || empty($this->getNrLiquidacao())
                    || empty($this->getVlLiquidacao()) || empty($this->getVlLiquidacao())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao())
                             ->setNrLiquidacao($this->getNrLiquidacao())
                             ->setDtLiquidacao($this->getDtLiquidacao())
                             ->setVlLiquidacao(Metodos::ConverteValorIng($this->getVlLiquidacao()))
                             ->setDsLiquidacao($this->getDsLiquidacao());
            
            $daoConLiquidacao->retorna($pdo);
            
            if (!$daoConLiquidacao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoConLiquidacao->getMsgRetorno());
            }
            
            $reg_antigo = $daoConLiquidacao->getMsgRetorno();
            
//            //Guarda a situação da Liquidação para gerar o histórico
//            $this->setIdLiquidacaoSituacao($daoConLiquidacao->getMsgRetorno()['id_liquidacao_situacao']);
            
            //Atualiza a Liquidação
            $daoConLiquidacao->update($pdo);
            
            
            if ($daoConLiquidacao->Sucesso()) {
                                
                
                if (!Log::SalvaLogU('con_liquidacao', $daoConLiquidacao->getIdLiquidacao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                //Se a edição da liquidação possuir documentos fiscais, 
                //verifica se os mesmos encontram-se na situação de 'A Liquidar'
                if ($this->getDocumentos()) {
                    if($this->verificaDocumentosDiferenteDeALiquidar($pdo)){
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Há documentos com situação diferente de 'A Liquidar'.");
                        
                    }
                }
                
                //Atualiza os Documentos Fiscais na Liquidação
                if (!$this->atualizaDocumentosLiquidacao($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                }
                
//                if (!$this->salvarLiquidacaoHistorico($pdo)) {
//                    $pdo->rollBack();
//                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
//                }
              
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
            }
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $daoConLiquidacao->getMsgRetorno());
        }
    }
    
    function atualizaDocumentosLiquidacao(PDO $pdo = null){
        try {
            $this->sucesso = true;
            
            if (!empty($pdo)) {
                
                //Busca os Documentos Fiscais associado a Liquidacao para saber qual foi removido ou inserido
                $liquidacaoDoc = new LiquidacaoDoc();
                $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());
                
                $liquidacaoDoc->retornaDocumentosPorLiquidacao($pdo);
                
                if (!$liquidacaoDoc->getSucesso()) {
                    $this->sucesso = false;
                    $this->mensagens = $liquidacaoDoc->getMensagens() ;
                    return false;
                }
                
                $documentosAntigos = $liquidacaoDoc->getMensagens();//Retorna o resultado da consulta
                
                
                $arrayInsert = array();
                $arrayRemove = array();

                $arrayAux = array();
                foreach ($documentosAntigos as $key => $value) {
                    $arrayAux[$value['id_liquidacao_doc']] = $value['id_documento_fiscal'];
                }
               

                $arrayInsert = array_diff($this->getDocumentos(), $arrayAux);
                $arrayRemove = array_diff($arrayAux, $this->getDocumentos());
                
                //DOCUMENTOS NOVOS QUE SERÃO INSERIDOS
                if ($arrayInsert) {
                    foreach ($arrayInsert as $indice => $documento) {
                        
                        $liquidacaoDoc->setIdDocumentoFiscal($documento);
                        $liquidacaoDoc->salvarLiquidacaoDoc($pdo);

                        if (!$liquidacaoDoc->getSucesso()) { //Retorna o erro se der problema ao salvar o documento fiscal
                            $this->sucesso = false;
                            $this->mensagens = $liquidacaoDoc->getMensagens();
                            return false;
                        }
                    }
                }
                
                //DOCUMENTOS QUE FORAM REMOVIDOS
                if ($arrayRemove) {
                    foreach ($arrayRemove as $indice => $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento);
                        $liquidacaoDoc->setIdLiquidacaoDoc($indice);
                        $liquidacaoDoc->removerLiquidacaoDoc($pdo);

                        if (!$liquidacaoDoc->getSucesso()) { //Retorna o erro se der problema ao salvar o documento fiscal
                            $this->sucesso = false;
                            $this->mensagens = $liquidacaoDoc->getMensagens();
                            return false;
                        }
                    }
                }
                
                
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }
            
            return $this->sucesso;
        } catch (Exception $exc) {
             //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
    
    
    function cancelarLiquidacao(){
        try {
            if (empty($this->getIdLiquidacao()) || empty($this->getMotivoCancelamento())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao())
                             ->setIdLiquidacaoSituacao($this->getSitCancelado());
            
            $daoConLiquidacao->retorna($pdo);
            if (!$daoConLiquidacao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os dados desta Liquidação");
            }
            
            $dadosLiquidacao = $daoConLiquidacao->getMsgRetorno();
            
            $idLiquidacao =$this->getIdLiquidacao();
            if (!Log::SalvaLogU('con_liquidacao', $idLiquidacao,$dadosLiquidacao ,$pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoConLiquidacao->mudaSituacao($pdo);
            if (!$daoConLiquidacao->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $daoConLiquidacao->getMsgRetorno());
            }
            
            //Seta as informações complementares para salvar no histórico
            $this->setIdLiquidacaoSituacao($this->getSitCancelado())
                  ->setIdLotacao($dadosLiquidacao['id_lotacao'])
                  ->setIdDocTipoLotacao($dadosLiquidacao['id_doc_tipo_lotacao']);
            
            
            //Busca os Documentos Fiscais associado a Liquidacao para voltar o status de 'A Liquidar'
            $liquidacaoDoc = new LiquidacaoDoc();
            $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());

            $liquidacaoDoc->retornaDocumentosPorLiquidacao($pdo);

            if (!$liquidacaoDoc->getSucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os Documentos Fiscais desta Liquidação");
            }
            
            $documentos = $liquidacaoDoc->getMensagens();//Retorna o resultado da consulta
            
            if ($documentos) {
                $gdof = new FinDocumentoFiscal();
                foreach ($documentos as $doc) {
                    $gdof->setIdDocumentoFiscal($doc['id_documento_fiscal'])
                         ->setIdDocumentoSituacao($gdof->getDocSitALiquidar());
                    if (!$gdof->atualizaSituacaoDocumentoGDOF($pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $gdof->getMsgErros());
                    }
                }
            }
            
            //Salvar no histórico o cancelamento
            if (!$this->salvarLiquidacaoHistorico($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os Documentos Fiscais desta Liquidação");
            };
            
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Liquidação cancelada com sucesso.");
            
        } catch (Exception $exc) {
             //Se der algum erro, registra o erro no objeto
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
}

