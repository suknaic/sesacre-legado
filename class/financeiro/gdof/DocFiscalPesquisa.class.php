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
    private $destinatario = null;

    function getNrDocFiscal() {
        return $this->nrDocFiscal;
    }

    function getAnoDocFiscal() {
        return $this->anoDocFiscal;
    }

    function getContratado() {
        return $this->contratado;
    }

    function getNrProtocolo() {
        return $this->nrProtocolo;
    }

    function getNrContrato() {
        return $this->nrContrato;
    }

    function getNrPedido() {
        return $this->nrPedido;
    }

    function getNrEmpenho() {
        return $this->nrEmpenho;
    }

    function getTpGasto() {
        return $this->tpGasto;
    }

    function getSitDocFiscal() {
        return $this->sitDocFiscal;
    }

    function getDestinatario() {
        return $this->destinatario;
    }

    function setNrDocFiscal($nrDocFiscal) {
        $this->nrDocFiscal = $nrDocFiscal;
        return $this;
    }

    function setAnoDocFiscal($anoDocFiscal) {
        $this->anoDocFiscal = $anoDocFiscal;
        return $this;
    }

    function setContratado($contratado) {
        $this->contratado = $contratado;
        return $this;
    }

    function setNrProtocolo($nrProtocolo) {
        $this->nrProtocolo = $nrProtocolo;
        return $this;
    }

    function setNrContrato($nrContrato) {
        $this->nrContrato = $nrContrato;
        return $this;
    }

    function setNrPedido($nrPedido) {
        $this->nrPedido = $nrPedido;
        return $this;
    }

    function setNrEmpenho($nrEmpenho) {
        $this->nrEmpenho = $nrEmpenho;
        return $this;
    }

    function setTpGasto($tpGasto) {
        $this->tpGasto = $tpGasto;
        return $this;
    }

    function setSitDocFiscal($sitDocFiscal) {
        $this->sitDocFiscal = $sitDocFiscal;
        return $this;
    }

    function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;
        return $this;
    }

    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();


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
                                    <button type='button' title='Ver documento fiscal' class='ver_documento' value='".$linha['id_documento_fiscal']."'>
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
            $filtroSql .= " and  doc.nr_documento_fiscal ilike \'%" . $this->getNrDocFiscal() . "%\' ";
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
            $filtroSql .= " and contrato.nr_contrato ilike \'%" . $this->getNrContrato() . "%\' ";
        }

        if ($this->getNrPedido()) {
            $filtroSql .= " and pedido.nr_pedido ilike \'%" . $this->getNrPedido() . "%\' ";
        }

        if ($this->getNrEmpenho()) {
            $filtroSql .= " and emp.nr_empenho ilike \'%" . $this->getNrEmpenho() . "%\' ";
        }

        if ($this->getTpGasto()) {
            $filtroSql .= " and tipoGasto.id_tipo_gasto = " . $this->getTpGasto();
        }

        if ($this->getSitDocFiscal()) {
            $filtroSql .= " and tramit.id_documento_situacao = " . $this->getSitDocFiscal();
        }

        if ($this->getDestinatario()) {
            $filtroSql .= " and tramitacao.id_tipo_tramitacao = " . $this->getDestinatario();
        }

        return $filtroSql;
    }

}
