<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoFiscal.class.php";

class DocFiscalRecebimento {

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
    private $destinatario = null;
    private $id_usuario = null;
    
    function getIdDocumentoFiscal() {
        return $this->idDocumentoFiscal;
    }

    function setIdDocumentoFiscal($idDocumentoFiscal) {
        $this->idDocumentoFiscal = $idDocumentoFiscal;
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
    public function getDestinatario() {
        return $this->destinatario;
    }

    /**
     * @param mixed $remetente
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

            $daoFinDocumentoFiscal->retornaDocumentoFiscaisRecebe($pdo, $this->montaFiltroSQL(), $this->id_usuario);

            if ($daoFinDocumentoFiscal->sucesso()) {

                foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='" . json_encode($linha) . "'>"
                            . "<td class='text-center'>" . $linha['nr_documento_fiscal'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_pedido'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_empenho'] . "</td>"
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
                                    
                                    
                                    <button title='Receber documento fiscal' type='button' class='receberDocumento'  data-toggle='modal' data-target='#acao' value='" . $linha['id_documento_fiscal'] . "'>
                                    <i class='fa fa-download fa-lg text-info' aria-hidden='true'></i>
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

        if ($this->getDestinatario()) {
            $filtroSql .= " and docLotacaoDestino.id_lotacao = " . $this->getDestinatario();
        } else {
            $docVincRecebimento = new DocVincRecebimento();
            $docVincRecebimento->setIdPessoa($this->id_usuario);
            $idLotacoesDestino = [];

            if ($docVincRecebimento->retornaIdLotacaoUsuarioRecebimento()) {
                foreach ($docVincRecebimento->retornaIdLotacaoUsuarioRecebimento() as $dados) {
                    $idLotacoesOrigem[] = $dados["id_lotacao"];
                }
            }
            
            if (!empty($idLotacoesDestino)) {
                $filtroSql .= " and docLotacaoDestino.id_lotacao in (" . implode(' , ', $idLotacoesOrigem) . ") ";
            }
            
        }


        return $filtroSql;
    }

    public function retornaOptionsTipoRemetenteUsuario() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $options = '';
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->retornaTipoLotacaoParaRecebimento($pdo, $this->id_usuario);
        if ($daoFinDocumentoFiscal->sucesso()) {
            foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $dados) {
                $options .= '<option value = "' . $dados["id_doc_tipo_lotacao"] . '">' . $dados["nm_doc_tipo_lotacao"] . '</option>';
            }
        }
        return $options;
    }

    public function retornaRemetentePorTipo(int $tipo = 0) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->retornaRemetentePorTipo($pdo, $tipo);
        $options = '<option value="0" selected="true">Selecione um Remetente</option>';

        if ($daoFinDocumentoFiscal->sucesso()) {
            foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $dados) {
                $options .= '<option value = "' . $dados["id_doc_lotacao"] . '">' . $dados["nm_lotacao"] . '</option>';
            }
        }
        return $options;
    }

    public function cadastrarRecebimento() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pdo->beginTransaction();
        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->getIdDocumentoFiscal());
        
//        $daoFinDocumentoFiscal->retornaUltimaOrigemDocumento($pdo);
//        $recebedor = $daoFinDocumentoFiscal->getMsgRetorno()['id_doc_origem'];
        
        //Retorna o Ultimo Encaminhamento para registrar o recebimento
        $daoFinDocumentoFiscal->retornaOrigemDestinoUltimaTramitacao($pdo);
        if (!$daoFinDocumentoFiscal->sucesso()) {
            return Metodos::retornoAjax("Erro", "alert", "Erro retornar os dados da última tramitação.");
        }

        //Aqui a busca as informações da tramitação que encaminhou o documento para definir o novo destinatario
        //O 'origem' será o recebedor do GDOF e o 'destino' será o remetente do GDOF, ambos serão baseado na última tramitação
        //
        //A 'origem' será o receptor do documento fiscal que no caso é o destinatário da tramitação anterior
        $origem = $daoFinDocumentoFiscal->getMsgRetorno()["id_doc_destino"];
        $tipo_remetente = $daoFinDocumentoFiscal->getMsgRetorno()["tipo_destinatario"];
        //O 'destino' faz referência a quem encaminhou o documento fiscal da tramitação anterior
        $destino = $daoFinDocumentoFiscal->getMsgRetorno()["id_doc_origem"];
        $tipo_destinatario = $daoFinDocumentoFiscal->getMsgRetorno()["tipo_remetente"];   
        
        
        $daoFinDocumentoFiscal->retornaSituacaoDocumentoParametro($pdo, $tipo_remetente,$tipo_destinatario, '2'); //Ultimo parametro indica que é Recebimento

        if (!$daoFinDocumentoFiscal->sucesso()) {
            return Metodos::retornoAjax("Erro", "alert", "O parâmetro da vinculação da tramitação não está cadastrado para este tipo de remetente/ tipo de destinatário");
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

        //codigo abaixo cadastra a tramitacao recebido
        $docTramitacao = new DocTramitacao();
        $docTramitacao->setIdPessoa($this->id_usuario);
        $docTramitacao->setIdDocOrigem($origem);
        $docTramitacao->setIdDocDestino($destino);
        $docTramitacao->setIdDocumentoSituacao($situacao);
        $docTramitacao->setIdTipoTramitacao(5);
        $docTramitacao->setIdDocumentoFiscal($this->getIdDocumentoFiscal());
        $docTramitacao->setFlPesquisa(1);
        if (!$docTramitacao->cadastraTramitacao($pdo)) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
        }

        //codigo abaixo cadastra a tramitacao aguardando encaminhamento
        $docTramitacao->setIdDocOrigem($origem);
        $docTramitacao->setIdDocDestino(null);
        $docTramitacao->setFlPesquisa(0);
        $docTramitacao->setIdTipoTramitacao(2);
        if (!$docTramitacao->cadastraTramitacao($pdo)) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
        }
        
        $pdo->commit();
        return Metodos::retornoAjax("ok", "html", "Documento recebido com sucesso");
    }
    
//    public function optionsLotacaoEncaminhamentoPorUsuarioETipo(int $idLotacao = 0) {
//        try {
//            $conexao = new Conexao();
//            $pdo = $conexao->connect();
//            $options = '';
//
//            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
//            $daoFinDocVincEncaminhamento->setIdPessoa($this->idPessoa);
//            $daoFinDocVincEncaminhamento->retornaLotacaoTipoEncaminhamentoPorUsuario($pdo);
//            if ($daoFinDocVincEncaminhamento->getSucesso()) {
//                foreach ($daoFinDocVincEncaminhamento->getMsgRetorno() as $linha) {
//
//                    if ($linha["id_doc_lotacao"] == $idLotacao) {
//                        $options .= '<option value="' . $linha["id_lotacao"] . '" selected="true" id_doc_lotacao ="' . $linha["id_doc_lotacao"] . '" >'
//                                . $linha["nm_doc_tipo_lotacao"] . ' / ' . $linha["nm_lotacao"] . '</option>';
//                    } else {
//                        $options .= '<option value="' . $linha["id_lotacao"] . '"  id_doc_lotacao ="' . $linha["id_doc_lotacao"] . '" >'
//                                . $linha["nm_doc_tipo_lotacao"] . ' / ' . $linha["nm_lotacao"] . '</option>';
//                    }
//                }
//            }
//            return $options;
//        } catch (Exception $ex) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }
//    
//    
//    public function retornaIdLotacaoUsuarioEncaminhamento() {
//        try {
//            $conexao = new Conexao();
//            $pdo = $conexao->connect();
//
//            $daoFinDocVincEncaminhamento = new DaoFinDocVincEncaminhamento();
//            $daoFinDocVincEncaminhamento->setIdPessoa($this->idPessoa);
//            $daoFinDocVincEncaminhamento->retornaLotacaoTipoEncaminhamentoPorUsuario($pdo);
//            return $daoFinDocVincEncaminhamento->getMsgRetorno();
//        } catch (Exception $ex) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }

}
