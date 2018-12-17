<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoFiscal.class.php";

class DocFiscalEncaminhamento {

    private $idDocumentoFiscal = null;
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
    private $idUsuario = null;

    private function getSitCadastrado(){
        return 1;
    }
    
    private function getSitALiquidar(){
        return 2;
    }
    
    private function getSitLiquidado(){
        return 3;
    }
    
    private function getSitAPagar(){
        return 4;
    }
    
    private function getSitPagoParcial(){
        return 5;
    }
    
    private function getSitPago(){
        return 6;
    }
    
    private function getSitCancelado(){
        return 7;
    }
    
    function getIdDocumentoFiscal() {
        return $this->idDocumentoFiscal;
    }

    function setIdDocumentoFiscal($idDocumentoFiscal) {
        $this->idDocumentoFiscal = $idDocumentoFiscal;
        return $this;
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * @param mixed $nrDocFiscal
     *
     * @return self
     */
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;

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
            $daoFinDocumentoFiscal->retornaDocumentoFiscaisEncaminha($pdo, $this->condicoes());
            if ($daoFinDocumentoFiscal->sucesso()) {
                //Verifica se a Situação é Cadastro, para assim mostrar os Botões de Editar e Remover
                $finDoc = new FinDocumentoFiscal();
                foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $linha) {
                    
                    $fornecedor = '-';
                    if (!empty($linha['nr_cnpj']) and !empty($linha['nm_fantasia'])){
                        $fornecedor = Metodos::formataCnpj($linha['nr_cnpj']) .' - '. $linha['nm_fantasia'];
                    } else if(!empty($linha['nr_cpf']) and !empty($linha['nm_civil'])){
                        $fornecedor = Metodos::formataCnpj($linha['nr_cpf']) .' - '. $linha['nm_civil'];
                    }
                    
                    $retorno .= "<tr data-objeto='" . json_encode($linha,JSON_HEX_APOS) . "'>"
                            . "<td class='text-center'>" . $linha['nr_documento_fiscal'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_pedido'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_empenho'] . "</td>"
                            . "<td class='text-center'>" . $fornecedor . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['competencia'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_lotacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['dt_emissao'] . "</td>"
                            . "<td class='text-center'>" . Metodos::ConverteValorBr($linha['vl_documento'],4) . "</td>"
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
                        $retorno .= " <button title='Cadastrar Liquidação' type='button' class='enviarLiquidacao' value='" . $linha['empenho_sm'] . "'>
                                        <i class='fa fa-calculator fa-lg text-purple' aria-hidden='true'></i>
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
  
    private function condicoes() {
        try {                                           
            $condicoes[] = array('DF.nr_documento_fiscal','string',$this->getNrDocFiscal());
            $condicoes[] = array('DF.nr_processo_administrativo','string',$this->getNrProtocolo());
            $condicoes[] = array('DF.dt_emissao','ano',$this->getAnoDocFiscal());
            $condicoes[] = array('F.id_pessoa','string',$this->getContratado());
            $condicoes[] = array('C.nr_contratol','string',$this->getNrContrato());
            $condicoes[] = array('P.nr_pedido', 'string',$this->getNrPedido());
            $condicoes[] = array('E.nr_empenho', 'string',str_replace("/", "", $this->getNrEmpenho()));
            $condicoes[] = array('P.id_tipo_gasto', 'int',$this->getTpGasto());
            $condicoes[] = array('DF.id_documento_situacao', 'int',$this->getSitDocFiscal());
            $condicoes[] = array('LOT.id_lotacao', 'int',$this->getRemetente());
            $condicoes[] = array('ENC.id_pessoa','int',$this->getIdUsuario());
            $condicoes[] = array('TRM.id_tipo_tramitacao','int',2); //Aguardando Encaminhamento
            return Metodos::montaFiltroSQL($condicoes);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function retornaOptionsTipoDestinatarioUsuario() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $options = '';
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->retornaTipoLotacaoParaEncaminhamento($pdo, $this->idUsuario);
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
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->getIdDocumentoFiscal());

            //Aqui irá retornar a ultima tramitação do documento para registrar o Encaminhamento
            $daoFinDocumentoFiscal->retornaDadosTramitacaoEncaminhar($pdo,(int)$dados["destinatario"]);
            if (!$daoFinDocumentoFiscal->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao encaminhar o documento fiscal, parâmetro para encaminhar o mesmo não foi encontrado.");
            }
            $tramitacao = $daoFinDocumentoFiscal->getMsgRetorno();

            //verifica se usuário pode efetuar o encaminhamento deste documento 
            $daoFinDocumentoFiscal->verificaPermissaoEncaminhar($pdo, $this->getIdUsuario(),$tramitacao['tipo_origem']);
            if (!$daoFinDocumentoFiscal->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Usuário não possui permissão para tramitar este documento.");
            }
            
            //-----------------------------Validação para encaminhar-----------------------------
            if (($tramitacao['situacao_nova'] < $this->getSitLiquidado() and $tramitacao['liquidacao'] == 'S') or 
                    ($tramitacao['situacao_nova'] < $this->getSitPagoParcial() and $tramitacao['pagamento'] == 'S')) {
                return Metodos::retornoAjax("Erro", "alert", "Encaminhamento não permitido para o Destinatário informado pois há Liquidação ou Pagamento para este documento.");
            }
            //-----------------------------------------------------------------------------------

            //-----------------------Atualiza a situação do Documento Fiscal---------------------
            $documentoFiscal = new FinDocumentoFiscal();
            $documentoFiscal->setIdDocumentoFiscal($this->getIdDocumentoFiscal());
            $documentoFiscal->setIdDocumentoSituacao($tramitacao['situacao_nova']);

            if (!$documentoFiscal->atualizaSituacaoDocumentoGDOF($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $documentoFiscal->getMsgErros());
            }
            //-------------FIM Atualiza a situação do Documento Fiscal---------------------------

            //codigo abaixo cadastra a tramitacao encaminhado
            $docTramitacao = new DocTramitacao();
            $docTramitacao->setIdPessoa($this->idUsuario);
            $docTramitacao->setIdDocOrigem($tramitacao['origem']);
            $docTramitacao->setIdDocDestino($dados["destinatario"]);
            $docTramitacao->setIdDocumentoSituacao($tramitacao['situacao_nova']);
            $docTramitacao->setDsDocTramitacao($dados["motivo"]);
            $docTramitacao->setIdTipoTramitacao(3);
            $docTramitacao->setIdDocumentoFiscal($this->getIdDocumentoFiscal());
            $docTramitacao->setFlPesquisa(1);
            if (!$docTramitacao->cadastraTramitacao($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salvar a tramitaçao.");
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
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}

