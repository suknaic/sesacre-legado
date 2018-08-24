<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoFiscal.class.php";

class DocFiscalPesquisa {

    private $nrDocFiscal = null;
    private $anoDocFiscal = null;
    private $contratado = null;
    private $nrProtocolo = null;
    private $nrContrato = null;
    private $nrPedido = null;
    private $nrEmpenho = null;
    private $tpGasto = null;
    private $sitDocFiscal = null;
    private $tramitacao = null;
    private $destinatario = null;
    

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
    public function getTramitacao() {
        return $this->tramitacao;
    }

    /**
     * @param mixed $tramitacao
     *
     * @return self
     */
    public function setTramitacao($tramitacao) {
        $this->tramitacao = $tramitacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestinatario() {
        return $this->destinatario;
    }

    /**
     * @param mixed $destinatario
     *
     * @return self
     */
    public function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;

        return $this;
    }

    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            
//            var_dump($this->montaFiltroSQL());
//            return;

            $daoFinDocumentoFiscal->retornaTrDocumentosFiscais($pdo, $this->montaFiltroSQL());

            if ($daoFinDocumentoFiscal->sucesso()) {

                foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='" . json_encode($linha) . "'>"
                            . "<td class='text-center'>" . $linha['nr_documento_fiscal'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_pedido'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_empenho'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['competencia'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_lotacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['vl_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_tramitacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_situacao'] . "</td>"
                            . "<td class='text-center'>
                                    <button type='button' title='Ver documento fiscal' class='ver_documento' value='" . $linha['id_documento_fiscal'] . "'>
                                    <i class='fa fa-file-text-o text-info' aria-hidden='true'></i>
                                    </button>
                               </td>"
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
            $filtroSql .= " and  protoc.id_protocolo = " . $this->getNrProtocolo();
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

        if ($this->getTramitacao()) {
             $filtroSql .= " and tramitacao.id_tipo_tramitacao = " . $this->getTramitacao();
        }
        
        if ($this->getDestinatario()) {
            $encaminhado = "tramitacao.id_tipo_tramitacao = 3"; //Quando tramitação for de 'Encaminhado', deve usar como parametro o ID_DOC_DESTINO
            $outros      = "tramitacao.id_tipo_tramitacao <> 3"; //Quando for DIFERENTE de 'Encaminhado', deve usar como parametro o ID_DOC_ORIGEM
            $filtroSql .= " and ((tramitacao.id_doc_destino = " . $this->getDestinatario() . " and ".$encaminhado.") or (tramitacao.id_doc_origem = ". $this->getDestinatario() ." and ".$outros."))";
        }
//            if($this->getTramitacao() == '1'){ //Aguardando Tramitação
//                $filtroSql .= " and tramitacao.id_tipo_tramitacao = " . $this->getTramitacao();
//            }
//            if ($this->getTramitacao() == '3') { //Encaminhado
//                $filtroSql .= " and tramitacao.id_tipo_tramitacao = " . $this->getTramitacao();
//
//                if ($this->getDestinatario()) {
//                    $filtroSql .= " and docLotacaoDestino.id_lotacao = " . $this->getDestinatario();
//                }
//            }
//
//            if ($this->getTramitacao() == '5') { //Recebido
//                $filtroSql .= " and tramitacao.id_tipo_tramitacao = " . $this->getTramitacao();
//
//                if ($this->getDestinatario()) {
//                    $filtroSql .= " and docLotacaoOrigem.id_lotacao = " . $this->getDestinatario();
//                }
//            }
//       
//
//            if ($this->getDestinatario()) {
//                $filtroSql .= " and docLotacaoOrigem.id_lotacao = " . $this->getDestinatario();
//            }
      



        return $filtroSql;
    }

}
