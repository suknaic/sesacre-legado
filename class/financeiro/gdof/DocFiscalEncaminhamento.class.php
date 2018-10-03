<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoFiscal.class.php";

class DocFiscalEncaminhamento {

    private $nrDocFiscal = null;
    private $anoDocFiscal = null;
    private $contratado = null;
    private $nrProtocolo = null;
    private $nrContrato = null;
    private $nrPedido = null;
    private $nrEmpenho = null;
    private $tpGasto = null;
    private $sitDocFiscal = null;
    private $remetente = null;
    private $id_usuario = null;
    
    private $tramitacao = null;
    
    function getTramitacao() {
        return $this->tramitacao;
    }

    function setTramitacao($tramitacao) {
        $this->tramitacao = $tramitacao;
        return $this;
    }
    
    public function getIdUsuario() {
        return $this->id_usuario;
    }

    /**
     * @param mixed $nrDocFiscal
     *
     * @return self
     */
    public function setIdUsuario($idUsuario) {
        $this->id_usuario = $idUsuario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrDocFiscal() {
        return $this->nrDocFiscal;
    }

    /**
     * @param mixed $nrDocFiscal
     *
     * @return self
     */
    public function setNrDocFiscal($nrDocFiscal) {
        $this->nrDocFiscal = $nrDocFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnoDocFiscal() {
        return $this->anoDocFiscal;
    }

    /**
     * @param mixed $anoDocFiscal
     *
     * @return self
     */
    public function setAnoDocFiscal($anoDocFiscal) {
        $this->anoDocFiscal = $anoDocFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContratado() {
        return $this->contratado;
    }

    /**
     * @param mixed $contratado
     *
     * @return self
     */
    public function setContratado($contratado) {
        $this->contratado = $contratado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrProtocolo() {
        return $this->nrProtocolo;
    }

    /**
     * @param mixed $nrProtocolo
     *
     * @return self
     */
    public function setNrProtocolo($nrProtocolo) {
        $this->nrProtocolo = $nrProtocolo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrContrato() {
        return $this->nrContrato;
    }

    /**
     * @param mixed $nrContrato
     *
     * @return self
     */
    public function setNrContrato($nrContrato) {
        $this->nrContrato = $nrContrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPedido() {
        return $this->nrPedido;
    }

    /**
     * @param mixed $nrPedido
     *
     * @return self
     */
    public function setNrPedido($nrPedido) {
        $this->nrPedido = $nrPedido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrEmpenho() {
        return $this->nrEmpenho;
    }

    /**
     * @param mixed $nrEmpenho
     *
     * @return self
     */
    public function setNrEmpenho($nrEmpenho) {
        $this->nrEmpenho = $nrEmpenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpGasto() {
        return $this->tpGasto;
    }

    /**
     * @param mixed $tpGasto
     *
     * @return self
     */
    public function setTpGasto($tpGasto) {
        $this->tpGasto = $tpGasto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitDocFiscal() {
        return $this->sitDocFiscal;
    }

    /**
     * @param mixed $sitDocFiscal
     *
     * @return self
     */
    public function setSitDocFiscal($sitDocFiscal) {
        $this->sitDocFiscal = $sitDocFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemetente() {
        return $this->remetente;
    }

    /**
     * @param mixed $remetente
     *
     * @return self
     */
    public function setRemetente($remetente) {
        $this->remetente = $remetente;

        return $this;
    }

    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();

            $daoFinDocumentoFiscal->retornaDocumentoFiscaisEncaminha($pdo, $this->montaFiltroSQL(), $this->id_usuario);

            if ($daoFinDocumentoFiscal->sucesso()) {
                //Verifica se a Situação é Cadastro, para assim mostrar os Botões de Editar e Remover
                $finDoc = new FinDocumentoFiscal();
                foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $linha) {

                    $retorno .= "<tr data-objeto='" . json_encode($linha) . "'>"
                            . "<td class='text-center'>" . $linha['nr_documento_fiscal'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_pedido'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_empenho'] . "</td>"
                            . "<td class='text-center'>" . $linha['cpf_cnpj_fornecedor'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['competencia'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_lotacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['dt_emissao'] . "</td>"
                            . "<td class='text-center'>" . $linha['vl_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_tramitacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_situacao'] . "</td>"
                            . "<td class='text-center'>
                                    <button type='button' title='Ver documento fiscal' class='ver_documento' value='" . $linha['id_documento_fiscal'] . "'>
                                    <i class='fa fa-file-text-o text-info' aria-hidden='true'></i>
                                    </button>
                                    
                                    
                                    <button title='Encaminha documento fiscal' type='button' class='enviarDoCumento'  data-toggle='modal' data-target='#acao' value='" . $linha['id_documento_fiscal'] . "'>
                                    <i class='fa fa-share-square fa-lg text-warning' aria-hidden='true'></i>
                                    </button>";  
                                     
                    if($linha['id_documento_situacao'] == $finDoc->getDocSitALiquidar()){
                        $retorno .= "<button title='Cadastrar Liquidação' type='button' class='enviarLiquidacao' value='" . $linha['nr_empenho'] . "'>
                                        <i class='fa fa-hand-o-right fa-lg text-warning' aria-hidden='true'></i>
                                    </button>";
                    }
                    
                    if($linha['id_documento_situacao'] == $finDoc->getDocSitCadastrado()){
                    $retorno .= "  <button type='button' title='editar' class='editar' value='" . $linha['id_documento_fiscal'] . "'>
                                     <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>
                                    </button>
                                    
                                    <button type='button' title='Excluir documento fiscal' class='excluir text-danger' value='" . $linha['id_documento_fiscal'] . "'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                    </button>";
                    }
                    
                    $retorno .= "</td>"
                            . "</tr>";
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function montaFiltroSQL() {
        //Verifica os atributos que serão filtrados

        $filtroSql = "";
        if ($this->getNrDocFiscal()) {
            $filtroSql .= " and  doc.nr_documento_fiscal ilike '%" . $this->getNrDocFiscal() . "%' ";
        }

        if ($this->getAnoDocFiscal()) {
            $filtroSql .= " and doc.aa_competencia = " . $this->getAnoDocFiscal();
        }

        if ($this->getContratado()) {
            $filtroSql .= " and fornecedor.id_pessoa = " . $this->getContratado();
        }

        if ($this->getNrProtocolo()) {
            $filtroSql .= " and  doc.nr_processo_administrativo ilike '%" . $this->getNrProtocolo() . "%' ";
        }

        if ($this->getNrContrato()) {
            $filtroSql .= " and contrato.nr_contrato ilike '%" . $this->getNrContrato() . "%' ";
        }

        if ($this->getNrPedido()) {
            $filtroSql .= " and pedido.nr_pedido ilike '%" . $this->getNrPedido() . "%' ";
        }

        if ($this->getNrEmpenho()) {
            $filtroSql .= " and emp.nr_empenho ilike '%" . $this->getNrEmpenho() . "%' ";
        }

        if ($this->getTpGasto()) {
            $filtroSql .= " and tipoGasto.id_tipo_gasto = " . $this->getTpGasto();
        }

        if ($this->getSitDocFiscal()) {
            $filtroSql .= " and tramitacao.id_documento_situacao = " . $this->getSitDocFiscal();
        }
        
        if ($this->getRemetente()) {
            $filtroSql .= " and lotacaoOrigem.id_lotacao = ". $this->getRemetente() ;
        }

        return $filtroSql;
    }

    public function retornaOptionsTipoDestinatarioUsuario() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $options = '';
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->retornaTipoLotacaoParaEncaminhamento($pdo, $this->id_usuario);
        if ($daoFinDocumentoFiscal->sucesso()) {
            foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $dados) {
                $options .= '<option value = "' . $dados["id_doc_tipo_lotacao"] . '">' . $dados["nm_doc_tipo_lotacao"] . '</option>';
            }
        }
        return $options;
    }

    public function retornaDestinatiroPorTipo(int $tipo = 0) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->retornaDestinatarioPorTipo($pdo, $tipo);
        $options = '<option value="0" selected="true">Selecione um Destinatário</option>';

        if ($daoFinDocumentoFiscal->sucesso()) {
            foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $dados) {
                $options .= '<option value = "' . $dados["id_doc_lotacao"] . '">' . $dados["nm_lotacao"] . '</option>';
            }
        }
        return $options;
    }

    public function cadastrarEncaminhamento($dados) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pdo->beginTransaction();
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->setIdDocumentoFiscal($dados["id"]);
        
//        $daoFinDocumentoFiscal->retornaUltimaOrigemDocumento($pdo);
        
        //Aqui irá retornar o último tipo do remetente
        $daoFinDocumentoFiscal->retornaUltimoTipoRemetenteTramitacao($pdo);
       
        if (!$daoFinDocumentoFiscal->sucesso()) {
            return Metodos::retornoAjax("Erro", "alert", "Erro ao retornar o tipo de Remetente da última tramitação.");
        }
        $tipo_remetente = $daoFinDocumentoFiscal->getMsgRetorno()["tipo_remetente"];
        
        $origem = $daoFinDocumentoFiscal->getMsgRetorno()["id_doc_origem"];
        
        //verifica se usuário pode efetuar o encaminhamento deste documento 
        $daoFinDocumentoFiscal->verificaPermissaoEncaminhar($pdo, $this->getIdUsuario(),$origem);
        if (!$daoFinDocumentoFiscal->sucesso()) {
            return Metodos::retornoAjax("Erro", "alert", "Usuário não possui permissão para tramitar este documento.");
        }

//        $daoFinDocumentoFiscal->retornaSituacaoDoParametro($pdo, $origem, $dados["tipoDestinatario"]);
        $daoFinDocumentoFiscal->retornaSituacaoDocumentoParametro($pdo,$tipo_remetente, $dados["tipoDestinatario"], '1'); //Ultimo parametro indica que é um encaminhamento
        if (!$daoFinDocumentoFiscal->sucesso()) {
            return Metodos::retornoAjax("Erro", "alert", "Esta tramitação não está cadastrada nos parâmetros da Vinculação da Tramitação");
        }

        $situacao = $daoFinDocumentoFiscal->getMsgRetorno()["id_documento_situacao"];
        
        
        //-------------Atualiza a situação do Documento Fiscal--------------------------------
        $daoFinDocumentoFiscal->setIdDocumentoSituacao($situacao);
        $daoFinDocumentoFiscal->atualizaSituacaoDocumentoFiscal($pdo);
        
        
        if (!$daoFinDocumentoFiscal->sucesso()) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao atualizar a situação do Documento Fiscal, por favor entre em contato com o Administrador do sistema.");
        }
        //-------------FIM Atualiza a situação do Documento Fiscal----------------------------
        

        //codigo abaixo cadastra a tramitacao encaminhado
        $docTramitacao = new DocTramitacao();
        $docTramitacao->setIdPessoa($this->id_usuario);
        $docTramitacao->setIdDocOrigem($origem);
        $docTramitacao->setIdDocDestino($dados["destinatario"]);
        $docTramitacao->setIdDocumentoSituacao($situacao);
        $docTramitacao->setDsDocTramitacao($dados["motivo"]);
        $docTramitacao->setIdTipoTramitacao(3);
        $docTramitacao->setIdDocumentoFiscal($dados["id"]);
        $docTramitacao->setFlPesquisa(1);
        if (!$docTramitacao->cadastraTramitacao($pdo)) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
        }

        //codigo abaixo cadastra a tramitacao aguardando recebimento
        $docTramitacao->setFlPesquisa(0);
        $docTramitacao->setIdTipoTramitacao(4);
        
        //Ao ser encaminhado, a origem do documento passa a ser o local para onde foi enviado
        $docTramitacao->setIdDocOrigem($dados["destinatario"]);
        $docTramitacao->setDsDocTramitacao(null);
        $docTramitacao->setIdDocDestino(null);
        if (!$docTramitacao->cadastraTramitacao($pdo)) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
        }

        $pdo->commit();
        return Metodos::retornoAjax("ok", "html", "Documento encaminhado com sucesso");
    }

}

