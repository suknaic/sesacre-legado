<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDecreto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTipo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaAnexo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDiariaDestino.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaClasse.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDecretoValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTransporte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDiaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDiariaHistorico.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/central/DaoFinCentralResponsavel.class.php";


class Diaria {
    private $idDiaria            = null;
    private $idTipo              = null;
    
    private $idPessoaProponente = null;
    private $idFuncaoProponente = null;
    private $idLotacaoProponente = null;
    
    private $idPessoaProposto   = null;
    private $idFuncaoProposto   = null;
    private $idLotacaoProposto  = null;
    
    private $idPessoaSolicitante = null;
    private $idLotacaoSolicitante = null;
    private $idCentralSolicitante = null;
    
    private $dsServicoExecutado = null;
    private $dsLocaisExecutado  = null;
    private $dsObs               = null;
    
    private $dtCriacao = null;
    private $dhDiaria  = null;
    
    private $itinerario = null;
    private $anexos = null;
    private $historico = null;

    private $erros = true;
    

    private $flRetorno            = null;
    private $idPedido             = null;
    private $anoPedido           = null;
    private $idDiariaPai         = null;
    private $idRelatorio          = null;
    private $nrProtocolo          = null;
    private $stEstagio            = null;
    // 1 - CRIADA
    // 2 - ENVIADA PARA DEFERIMENTO
    // 3 - INDEFERIDO
    // 4 - DEFERIDO

    private $stAtivo = null;
    
    private $usuarioPedido = null;
    private $msgErros = null;
    
    private $usuarioSessao = null;

    
    function getUsuarioPedido() {
        return $this->usuarioPedido;
    }

    function setUsuarioPedido($usuarioPedido) {
        $this->usuarioPedido = $usuarioPedido;
    }

        
    function getIdPessoaHistorico() {
        return $this->idPessoaHistorico;
    }

    function setIdPessoaHistorico($idPessoaHistorico) {
        $this->idPessoaHistorico = $idPessoaHistorico;
    }

    function getHistorico() {
        return $this->historico;
    }

    function setHistorico($historico) {
        $this->historico = $historico;
    }

            
    function getDsHistorico() {
        return $this->dsHistorico;
    }

    function setDsHistorico($dsHistorico) {
        $this->dsHistorico = $dsHistorico;
    }
    
    function getAnexos() {
        return $this->anexos;
    }

    function setAnexos($anexos) {
        $this->anexos = $anexos;
    }

        
    function getItinerario() {
        return $this->itinerario;
    }

    function setItinerario($itinerario) {
        $this->itinerario = $itinerario;
    }
    
    function getIdDiaria() {
        return $this->idDiaria;
    }

    function getIdTipo() {
        return $this->idTipo;
    }

    function getIdPessoaProponente() {
        return $this->idPessoaProponente;
    }

    function getIdFuncaoProponente() {
        return $this->idFuncaoProponente;
    }

    function getIdLotacaoProponente() {
        return $this->idLotacaoProponente;
    }

    function getIdPessoaProposto() {
        return $this->idPessoaProposto;
    }

    function getIdFuncaoProposto() {
        return $this->idFuncaoProposto;
    }

    function getIdLotacaoProposto() {
        return $this->idLotacaoProposto;
    }

    function getDsServicoExecutado() {
        return $this->dsServicoExecutado;
    }

    function getDsLocaisExecutado() {
        return $this->dsLocaisExecutado;
    }

    function getDsObs() {
        return $this->dsObs;
    }

    function getDtCriacao() {
        return $this->dtCriacao;
    }

    function getDhDiaria() {
        return $this->dhDiaria;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function getFlRetorno() {
        return $this->flRetorno;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function getIdDiariaPai() {
        return $this->idDiariaPai;
    }

    function getIdRelatorio() {
        return $this->idRelatorio;
    }

    function getStEstagio() {
        return $this->stEstagio;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }
    
    function getIdCentralSolicitante() {
        return $this->idCentralSolicitante;
    }

    function getUsuarioSessao() {
        return $this->usuarioSessao;
    }

    function setUsuarioSessao(Session $usuarioSessao) {
        $this->usuarioSessao = $usuarioSessao;
    }
    
    function setIdCentralSolicitante($idCentralSolicitante) {
        $this->idCentralSolicitante = $idCentralSolicitante;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }
    
    function getNrProtocolo() {
        return $this->nrProtocolo;
    }

    function setNrProtocolo($nrProtocolo) {
        $this->nrProtocolo = $nrProtocolo;
    }

    function getIdLotacaoSolicitante() {
        return $this->idLotacaoSolicitante;
    }
    
    function getAnoPedido() {
        return $this->anoPedido;
    }

    function setAnoPedido($anoPedido) {
        $this->anoPedido = $anoPedido;
    }
        
    function setIdLotacaoSolicitante($idLotacaoSolicitante) {
        $this->idLotacaoSolicitante = $idLotacaoSolicitante;
    }
        
    function setIdPessoaProponente($idPessoaProponente) {
        $this->idPessoaProponente = $idPessoaProponente;
    }

    function setIdFuncaoProponente($idFuncaoProponente) {
        $this->idFuncaoProponente = $idFuncaoProponente;
    }

    function setIdLotacaoProponente($idLotacaoProponente) {
        $this->idLotacaoProponente = $idLotacaoProponente;
    }

    function setIdPessoaProposto($idPessoaProposto) {
        $this->idPessoaProposto = $idPessoaProposto;
    }

    function setIdFuncaoProposto($idFuncaoProposto) {
        $this->idFuncaoProposto = $idFuncaoProposto;
    }

    function setIdLotacaoProposto($idLotacaoProposto) {
        $this->idLotacaoProposto = $idLotacaoProposto;
    }

    function setDsServicoExecutado($dsServicoExecutado) {
        $this->dsServicoExecutado = $dsServicoExecutado;
    }

    function setDsLocaisExecutado($dsLocaisExecutado) {
        $this->dsLocaisExecutado = $dsLocaisExecutado;
    }

    function setDsObs($dsObs) {
        $this->dsObs = $dsObs;
    }

    function setDtCriacao($dtCriacao) {
        $this->dtCriacao = $dtCriacao;
    }

    function setDhDiaria($dhDiaria) {
        $this->dhDiaria = $dhDiaria;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

    function setFlRetorno($flRetorno) {
        $this->flRetorno = $flRetorno;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setIdDiariaPai($idDiariaPai) {
        $this->idDiariaPai = $idDiariaPai;
    }

    function setIdRelatorio($idRelatorio) {
        $this->idRelatorio = $idRelatorio;
    }

    function setStEstagio($stEstagio) {
        $this->stEstagio = $stEstagio;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }
    
    public function retornaStEstagioOptions() {
        $retorno  = "<option value='0'>Selecione a situação</option>";
        
        foreach ($this->tiposStEstagios() as $indice => $valor) {
            $retorno .= "<option value='".$indice."'>".$valor."</option>";
        }
        return $retorno;
    }
    
    public function tiposStEstagios() {
        //O atributo "lotacao" indica se na tabela que irá gravar a autorização existe 
        //a informação de lotação(id_lotacao)
        $stEstagios = array(
            1 => "Aguardando envio",
            2 => "Aguardando deferimento",
            3 => "Indeferida",            
            4 => "Deferida",
            5 => "Vinculado com pedido de necessidade",
            6 => "Com pedido de necessidade cancelado",
            9 => "Todas"
        );
        return $stEstagios;
    }
    
    function retornaSituacaoDiaria(int $st_estagio = 0, int $id_pedido = 0, int $ano_pedido = 0){
        $retorno = "";
        try {
            switch ($st_estagio) {
                case 1: //Criada
                    $retorno = '<span class="label label-primary">Aguardando envio</span>';
                    break;
                case 2: //Enviada para deferimento
                    $retorno = '<span class="label label-warning">Aguardando deferimento</span>';
                    break;
                case 3: //Indeferida
                    $retorno = '<span class="label label-danger">Aguardando revisão</span>';
                    break;
                case 4: //Deferida
                    $retorno = '<span class="label label-primary">Aguardando pedido de necessidade</span>';
                    break;
                case 5:
                    $retorno = '<span class="label label-primary">Vinculado ao pedido de necessidade nº '.$id_pedido .'/'.$ano_pedido.'</span>';
                    break;
                case 6:
                    $retorno = '<span class="label label-danger">Pedido de necessidade cancelado</span>';
                default:
                    break;
            }
            return $retorno;
        } catch (Exception $exc) {
            return "";
        }
    }

    function retornaHistorico(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoDiaDiariaHistorico = new DaoDiaDiariaHistorico();
            $daoDiaDiariaHistorico->setIdDiaria($this->getIdDiaria());
            
            $daoDiaDiariaHistorico->historico($pdo);
            
            if ($daoDiaDiariaHistorico->getSucesso()) {
                foreach ($daoDiaDiariaHistorico->getMsgRetorno() as $linha) {
                    $retorno .= date('d/m/Y H:i:s', strtotime($linha['dh_diaria_historico'])) . ' - ' . $linha['nm_pessoa'] . ': ' . $linha['ds_diaria_historico'] . "\n";
                }
            } else {
                $retorno = $daoDiaDiariaHistorico->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }

        
    }
    
    function retornaPedidoDiariaOption(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdCentralSolicitante($this->getIdCentralSolicitante());
            
            $daoDiaDiaria->selectDiariaPedidoOption($pdo);
            if ($daoDiaDiaria->getSucesso()) {
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    $retorno .= "<option data-valor='".$linha['vl_total_sm']."' value = '" . $linha['id_diaria'] . "'>Nº: ". $linha['id_diaria']." / Data criação: " . $linha['dt_criacao'] . " / Proponente: " . $linha['nm_proponente'] . " / Proposto: " . $linha['nm_proposto'] . " / Valor total: R$ " .$linha['vl_total']. "</option>";
                }
            } 
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
            
    function retornaDecretosOption(PDO $pdo = null, int $idDecreto = 0){
        $retorno = "<option value = '0'>Selecione um Decreto</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDecreto = new DaoDiaDecreto();
        
            $daoDiaDecreto->select($pdo);
            
            
            if($daoDiaDecreto->getSucesso()){
                foreach ($daoDiaDecreto->getMsgRetorno() as $linha){
                    if ($idDecreto == $linha['id_decreto']) {
                      $retorno .= "<option value = '" . $linha['id_decreto'] . "' selected>" . $linha['nm_decreto'] . "</option>";  
                    } else {
                      $retorno .= "<option value = '" . $linha['id_decreto'] . "'>" . $linha['nm_decreto'] . "</option>";
                    }
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaTransporteOption(PDO $pdo = null, int $idTransporte = 0) {
        $retorno = "<option value = '0'>Selecione o meio de locomoção</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaTransporte = new DaoDiaTransporte();
        
            $daoDiaTransporte->select($pdo);
            
            if($daoDiaTransporte->getSucesso()){
                foreach ($daoDiaTransporte->getMsgRetorno() as $linha){
                    if ($idTransporte == $linha['id_transporte']) {
                        $retorno .= "<option value = '" . $linha['id_transporte'] . "'selected>" . $linha['nm_transporte'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $linha['id_transporte'] . "'>" . $linha['nm_transporte'] . "</option>";
                    }
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
        
    }
    
    function retornaTipoDiariaOption(PDO $pdo = null, int $idTipo = 0) {
        $retorno = "<option value = '0'>Selecione a categoria da Diária</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaTipo = new DaoDiaTipo();
        
            $daoDiaTipo->select($pdo);
            
            if($daoDiaTipo->getSucesso()){
                foreach ($daoDiaTipo->getMsgRetorno() as $linha){
                    if ($idTipo == $linha['id_tipo']) {
                        $retorno .= "<option value = '" . $linha['id_tipo'] . "' selected>" . $linha['nm_tipo'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $linha['id_tipo'] . "'>" . $linha['nm_tipo'] . "</option>";
                    }
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaDiariaPaiOption(PDO $pdo = null){
        $retorno = "<option value = '0'>Selecione a diária principal</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
        
            $daoDiaDiaria->select($pdo);
            
            if ($daoDiaDiaria->getSucesso()) {
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    if ($linha['id_diaria'] != $this->getIdDiaria()) {
                        if ($this->getIdDiariaPai() == $linha['id_diaria']) {
                            $retorno .= "<option value = '" . $linha['id_diaria'] . "' selected>Nº: ". $linha['id_diaria']." / Data criação: " . $linha['dt_criacao'] . " / Proponente: " . $linha['nm_proponente'] . " / Proposto: " . $linha['nm_proposto'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $linha['id_diaria'] . "'>Nº: ". $linha['id_diaria']." / Data criação: " . $linha['dt_criacao'] . " / Proponente: " . $linha['nm_proponente'] . " / Proposto: " . $linha['nm_proposto'] ."</option>";
                        }
                    }
                }
            }
            
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaCentraisOption(int $idUsuario = 0,int $idCentral = 0){
        $retorno = "<option value='0'>Selecione uma Central</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdPessoaSolicitante($idUsuario);
            $daoDiaDiaria->centraisDiaria($pdo);
            
            if ($daoDiaDiaria->getSucesso()) {
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    if ($linha['id_lotacao'] == $idCentral) {
                        $retorno .= "<option value='".$linha['id_lotacao']."' selected>".$linha['nm_lotacao']."</option>";
                    } else {
                        $retorno .= "<option value='".$linha['id_lotacao']."'>".$linha['nm_lotacao']."</option>";
                    }
                }
            } 
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function retornaClasseOption(PDO $pdo = null, int $idDecreto = 0, int $idClasse = 0) {
        $retorno = "<option value='0'>Selecione a classe</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDecretoValor = new DaoDiaDecretoValor();
            $daoDiaDecretoValor->setIdDecreto($idDecreto);
            $daoDiaDecretoValor->select($pdo);
            
            
            if($daoDiaDecretoValor->getSucesso()){
                foreach ($daoDiaDecretoValor->getMsgRetorno() as $linha){
                    if ($idClasse == $linha['id_classe']) {
                        $retorno .= "<option value='" . $linha['id_classe'] . "' selected>" . $linha['cd_classe'] . " - " . $linha['nm_classe'] . "</option>";
                    } else {
                        $retorno .= "<option value='" . $linha['id_classe'] . "'>" . $linha['cd_classe'] . " - " . $linha['nm_classe'] . "</option>";
                    }
                }
            }
            return $retorno;
            
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function retornaDadosDiaria(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->retornaDiaria($pdo);
            if ($daoDiaDiaria->getSucesso()) {
                return json_encode($daoDiaDiaria->getMsgRetorno());
            } else {
                return $retorno;
            }
            
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function checaUsuarioDiaria(int $id_diaria = 0){
        
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($id_diaria);
            $daoDiaDiaria->verificaDiariasUsuario($pdo, $this->getUsuarioSessao()->getIdUser());
            
            return $daoDiaDiaria->getSucesso();
        } catch (Exception $exc) {
            return false;
        }
    }
    
    function retornaFormDiaria(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->infoDiariaPedido($pdo);
            
            if ($daoDiaDiaria->getSucesso()) {
                $linhaItinerario = "";
                
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    $linhaItinerario .= "<tr><td>".$linha['origem']."</td><td>".$linha['destino']."</td><td>".$linha['dh_inicio']."</td><td>".$linha['dh_fim']."</td><td>".$linha['vl_total']."</td></tr>";
                }
                
                $retorno = '<form class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="nr_protocolo">Protocolo:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nr_protocolo" value="'.$daoDiaDiaria->getMsgRetorno()[0]['nr_protocolo'].'" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="tp_diaria">Tipo da Diária:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="tp_diaria" value="'.$daoDiaDiaria->getMsgRetorno()[0]['nm_tipo'].'" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="id_proposto">Nome Proposto:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="id_proposto" value="'.$daoDiaDiaria->getMsgRetorno()[0]['nm_proposto'].'" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="lt_proposto">Lotação Proposto:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="lt_proposto" value="'.$daoDiaDiaria->getMsgRetorno()[0]['lt_proposto'].'" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="fn_proposto">Função Proposto:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="fn_proposto" value="'.$daoDiaDiaria->getMsgRetorno()[0]['fn_proposto'].'" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="id_proponente">Nome Proponente:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="id_proponente" value="'.$daoDiaDiaria->getMsgRetorno()[0]['nm_proponente'].'" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="lt_proponente">Lotação Proponente:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="lt_proponente" value="'.$daoDiaDiaria->getMsgRetorno()[0]['lt_proponente'].'" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="fn_proponente">Função Proponente:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="fn_proponente" value="'.$daoDiaDiaria->getMsgRetorno()[0]['fn_proponente'].'" disabled>
                                    </div>
                                </div>
                                <br>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="ds_servico_executado">Descrição dos serviços:</label>
                                    <div class="col-sm-9">
                                        <textarea name="ds_servico_executado" class="form-control" disabled rows="4">'.$daoDiaDiaria->getMsgRetorno()[0]['ds_servico_executado'].'</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="ds_locais_executado">Descrição dos locais:</label>
                                    <div class="col-sm-9">
                                        <textarea name="ds_locais_executado" class="form-control" disabled rows="4">'.$daoDiaDiaria->getMsgRetorno()[0]['ds_locais_executado'].'</textarea>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <th>Origem</th>
                                        <th>Destino</th>
                                        <th>Horário da Partida</th>
                                        <th>Horário da Chegada</th>
                                        <th>Valor Total</th>
                                    </thead>
                                    <tbody>'.$linhaItinerario.'</tbody>
                                </table>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="dt_criacao">Data da criação:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="dt_criacao" value="'.$daoDiaDiaria->getMsgRetorno()[0]['dt_criacao'].'" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="nm_solicitante">Nome Solicitante:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nm_solicitante" value="'.$daoDiaDiaria->getMsgRetorno()[0]['nm_solicitante'].'" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="central_solicitante">Central de Demanda do Solicitante:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="central_solicitante" value="'.$daoDiaDiaria->getMsgRetorno()[0]['central_demanda'].'e" disabled>
                                    </div>
                                </div>
                            </form>
                            <div class="row text-center">
                                <a href="/pages/diarias/diaria/imprimir.php?id=' . $daoDiaDiaria->getMsgRetorno()[0]['id_diaria'] . '" target="_blank">
                                    <button class="btn btn-dark" title="Imprimir proposta e concessão da Diária" type="button" >
                                        Imprimir proposta e concessão da Diária
                                    </button>
                                </a>
                            </div>'
                            ;
            } else {
                $retorno = $daoDiaDiaria->getMsgRetorno();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function retornaInfoDiariaPedido(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->infoDiariaPedido($pdo);
            if ($daoDiaDiaria->getSucesso()) {
                return $daoDiaDiaria->getMsgRetorno();
            } else {
                return $retorno;
            }
            
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
  
    function retornaTrsItinerario(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            //Uma diária específica
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            if ($this->getIdDiaria() > 0) {
                $daoDiaDiariaDestino->setIdDiaria($this->getIdDiaria());
            }

            $daoDiaDiariaDestino->select($pdo);
            
            $altera = $this->getUsuarioSessao()->vPDiariasSolicitacao();
            
            if ($daoDiaDiariaDestino->getSucesso()) {
                foreach ($daoDiaDiariaDestino->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-itinerario='" . json_encode($linha) . "' >"
                                    . "<td>".$linha['ds_cidade_inicio']."</td>"
                                    . "<td>".$linha['ds_cidade_fim']."</td>"
                                    . "<td>".$linha['dh_inicio']."</td>"
                                    . "<td>".$linha['dh_fim']."</td>"
                                    . "<td>".number_format($linha['vl_total'], 2,',','.')."</td>";
                                    
                                    if ($linha['st_estagio'] == '2' || $linha['st_estagio'] == '4' || $linha['st_estagio'] == '5' || $linha['st_estagio'] == '6') {
                                       $retorno .= "<td></td>";
                                    } elseif ($altera) {
                                       $retorno .=  "<td><span role='button' class='remove-itinerario'>Remover</span> | <span role='button' class='edit-itinerario'>Alterar</span></td>"; 
                                    }
                      $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage() ;
        }
    }
    
    function retornaTrDiariasTodas(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->listaTodasDiarias($pdo);
            
            $retorno = $this->montaTrDiárias($daoDiaDiaria);
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
            
    function retornaTrDiariasSolicitacao(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            //Checa as centrais do usuário
            $centrais = [0];
            $daoFinCentralResponsavel = new DaoFinCentralResponsavel();
            $daoFinCentralResponsavel->setIdPessoa($this->getUsuarioSessao()->getIdUser());
            $daoFinCentralResponsavel->retornaLotacaoAdministracaoDoUsuario($pdo);
            if ($daoFinCentralResponsavel->Sucesso()) {
                foreach ($daoFinCentralResponsavel->getMsgRetorno() as $linha) {
                    if ($linha['id_tipo_administracao'] == 3) { //Somente as centrais do tipo DIARIA: 3
                        $centrais[] = $linha['id_lotacao'];
                    }
                }
            }
            $filtroCentral = implode(",", $centrais); //Centrais do usuário referente a Diária
            //------------------------------------------------
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->listaDiarias($pdo, $this->getUsuarioSessao()->getIdUser(), $filtroCentral);
            $retorno = $this->montaTrDiárias($daoDiaDiaria);
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function montaTrDiárias(DaoDiaDiaria $daoDiaDiaria){
        $retorno = "";
        $altera = $this->getUsuarioSessao()->vPDiariasSolicitacao();
        
        $data_hoje = new DateTime();
        try {
            $estagios = $this->tiposStEstagios();
            
            if ($daoDiaDiaria->getSucesso()) {
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    $estagio = $linha['st_estagio'];
                    $pedido = is_null($linha['id_pedido']) ? 0 : $linha['id_pedido'];
                    $ano_pedido = is_null($linha['ano_pedido']) ? 0 : $linha['ano_pedido'];
                    
                    //Pega a data atual e a data final do último itinerario ,para verificação posterior do cadastro do relatório de viagem
                    $data_fim_itinerario = date_create_from_format('d/m/Y H:i', $linha['dh_fim']);
                    
                    $retorno .= "<tr data-diaria='". json_encode($linha) ."'>"
                                . "<td>" . $linha['id_diaria'] . "</td>"
                                . "<td>" . $linha['nr_protocolo'] . "</td>"
                                . "<td>" . $linha['nm_proponente'] . "</td>"
                                . "<td>" . $linha['nm_proposto'] . "</td>"
                                . "<td>" . $linha['lt_proposto'] . "</td>"
                                . "<td>" . $linha['central_demanda'] . "</td>"
                                . "<td>" . $linha['destino'] . "</td>"
                                . "<td class='text-center'>" . $this->retornaSituacaoDiaria($estagio, $pedido,$ano_pedido). "</td>"
                                . "<td class = 'text-center'>";
                    

                        if (($estagio == '3' or $estagio == '1') and $altera) { //Indeferida e Criada permite a exclusão
                            $retorno .= '<a href="./diaria/index.php?id=' . $linha['id_diaria'] .'">'
                                        . '<button title="Editar" type="button">'
                                            . '<i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>'
                                        . '</button>'
                                      . '</a>';

                            $retorno .= '<button title="Excluir" type="button" class="text-danger excluirDiaria">'
                                        . '<i class="fa fa-trash fa-lg" aria-hidden="true"></i>'
                                      . '</button>';
                            $retorno .= '<button title="Enviar p/ Deferimento" type="button" class="enviarDiaria" data-toggle="modal" data-target="#acao">'
                                        . '<i class="fa fa-share-square fa-lg text-warning" aria-hidden="true"></i>'
                                    . '</button>';
                        }
                                

                        if ($estagio == '2' or $estagio == '4' or $estagio == '5' or $estagio == '6' or  !$altera ) { //Deferida só permite visualização
                            $retorno .= '<a href="./diaria/index.php?id=' . $linha['id_diaria'] .'">'
                                        . '<button type="button" title="Visualizar">'
                                            . '<i class="fa fa-search fa-lg text-primary" aria-hidden="true"></i>'
                                        . '</button>'
                                      . '</a>';
                        }
                        if ($estagio == '5' and $data_hoje > $data_fim_itinerario) { //Só permitir editar o relatório de viagem quando a diária estiver vinculada a um pedido e deferida
                            $retorno .= '<a href="./relatorio/index.php?id=' . $linha['id_diaria'] . '">'
                                        . '<button title="Relatório de Viagem" type="button">'
                                             . '<i class="fa fa-book fa-lg text-info" aria-hidden="true"></i>'
                                        . '</button>'
                                      . '</a>';
                        }
                        $retorno .= '<a href="./diaria/imprimir.php?id=' . $linha['id_diaria'] . '" target="_blank">'
                                        . '<button title="Imprimir proposta e concessão da Diária" type="button" >'
                                            . '<i class="fa fa-print fa-lg" aria-hidden="true"></i>'
                                        . '</button>'
                                    . '</a>';
                    $retorno .=   "</td>"
                             . "</tr>";                    
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
   
    
    function excluirDiaria() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            
            $idDiaria = $daoDiaDiaria->getIdDiaria();
            if (!Log::SalvaLogD('dia_diaria', $idDiaria, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            //Percorre todos os destinos para exlcuir
            $daoDiaDiaria->selectDestinos($pdo);
            if ($daoDiaDiaria->getSucesso()) {
                $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
                foreach ($daoDiaDiaria->getMsgRetorno() as $destino) {
                    $daoDiaDiariaDestino->setIdDiariaDestino($destino['id_diaria_destino']);
                    $retorno .= $this->excluirDiariaDestino($pdo,$daoDiaDiariaDestino);
                }
            } 
            
            //Percorre todos os anexos para excluir
            $daoDiaDiaria->selectAnexos($pdo);
            if ($daoDiaDiaria->getSucesso()) {
                $daoDiaAnexo = new DaoDiaAnexo();
                foreach ($daoDiaDiaria->getMsgRetorno() as $anexo) {
                    $daoDiaAnexo->setIdAnexo($anexo['id_anexo']);
                    $retorno .= $this->excluirDiariaAnexo($pdo,$daoDiaAnexo);
                }
                
            }
            
            //Percorre todos os históricos da diária
            $daoDiaDiaria->selectHistorico($pdo);
            if($daoDiaDiaria->getSucesso()){
                $daoDiaDiariaHistorico = new DaoDiaDiariaHistorico();
                foreach ($daoDiaDiaria->getMsgRetorno() as $historico) {
                    $daoDiaDiariaHistorico->setIdDiariaHistorico($historico['id_diaria_historico']);
                    $retorno .= $this->excluirDiariaHistorico($pdo, $daoDiaDiariaHistorico);
                }
            }
            
            //Se não ocorrer erro a variavel $retorno estará vazia
            if ($retorno == "") {
                $daoDiaDiaria->delete($pdo);
                if ($daoDiaDiaria->getSucesso()) {
                    $pdo->commit();
                    $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
                } else {
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDiaria->getMsgRetorno());
                    $pdo->rollBack();
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
       
    
    function validaDiariaDestino($novoDestino){
        $retorno = "";
        $msgErro = "";
        try {
            $destino = json_decode($novoDestino);

            $data_inicio = date_create_from_format('d/m/Y H:i', $destino->dh_inicio);
            $data_fim = date_create_from_format('d/m/Y H:i', $destino->dh_fim);

            if (!Metodos::ValidaData($destino->dh_inicio,'d/m/Y H:i') || !Metodos::ValidaData($destino->dh_fim,'d/m/Y H:i')) {
                $msgErro .= "Data e hora de saída ou chegada inválida. "; 
            }
            
            if ($data_inicio->getTimeStamp() >= $data_fim->getTimeStamp()) {
                $msgErro .= "Data e hora de chegada não pode ser menor ou igual a data e hora de saída. ";
            }
            
            //Verifica se há período concomitante
            $itinerario = json_decode($this->getItinerario());
//            var_dump($itinerario);
            foreach ($itinerario as $linha) {
                $dt_ini = date_create_from_format('d/m/Y H:i', $linha->dh_inicio);
                $dt_fim = date_create_from_format('d/m/Y H:i', $linha->dh_fim);
                
                //verifica se o novo destino está em um período concomitante com os demais destinos
                if (($data_inicio->getTimeStamp() >= $dt_ini->getTimeStamp() and $data_inicio->getTimeStamp() <= $dt_fim->getTimeStamp()) OR
                    ($data_fim->getTimeStamp() >=  $dt_ini->getTimeStamp() and $data_fim->getTimeStamp() <= $dt_fim->getTimeStamp()) OR
                    ($data_inicio->getTimeStamp() <= $dt_ini->getTimeStamp() and $data_fim->getTimeStamp() >= $dt_fim->getTimeStamp()) OR
                    ($data_inicio->getTimeStamp() >= $dt_ini->getTimeStamp() and $data_fim->getTimeStamp() <= $dt_fim->getTimeStamp())) {
                        $msgErro .= "Data e hora dos itinerários não podem coincidir";
                        break;
                }
                
            }
            
            if(empty($msgErro)){
                return Metodos::retornoAjax("ok", "console", $data_fim->format('d/m/Y H:i'));
            } else {
                return Metodos::retornoAjax("Erro", "alert", $msgErro);
            }
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    function validaDados(){
        if ( empty($this->getDsLocaisExecutado()) or empty($this->getDsServicoExecutado()) or empty($this->getIdCentralSolicitante()) or 
                empty($this->getIdPessoaProponente()) or empty($this->getIdFuncaoProponente()) or empty($this->getIdLotacaoProponente()) or 
                empty($this->getIdPessoaProposto()) or empty($this->getIdFuncaoProposto()) or empty($this->getIdLotacaoProposto()) or 
                empty($this->getDsLocaisExecutado()) or empty($this->getDsServicoExecutado()) or empty($this->getDtCriacao()) or 
                empty($this->getIdPessoaSolicitante()) or empty($this->getNrProtocolo()) or empty($this->getIdTipo()) ) {
            $this->msgErros .= 'Por favor preencha os campos obrigatórios.';
            return false;
        }
        $dataCriacao = date_create_from_format('d/m/Y H:i', $this->getDtCriacao() .' 00:00' );
        try {
            foreach ($this->getItinerario() as $linha) {
                $dataPartida = date_create_from_format('d/m/Y H:i',$linha['dh_inicio']);
                if ($dataCriacao->getTimeStamp() > $dataPartida->getTimeStamp()) {
                    $this->msgErros .= 'Data de criação não pode ser maior que a data da partida' ;
                    return false;
                    break;
                }
            }
            
           return true;
        } catch (Exception $exc) {
            $this->msgErros = $exc->getMessage();
            return false;
        }
    }
    
 
    
    function salvarDiaria() {
        try {
            $retorno = "";
            //****************************Valida data de criação*************************************
            if (!$this->validaDados()){
                return Metodos::retornoAjax("Erro", "alert", $this->msgErros);
            } else {
                
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                
                //****************************DiaDiaria INICIO********************************************
                $daoDiaDiaria = new DaoDiaDiaria();
                $daoDiaDiaria->setIdTipo($this->getIdTipo());

                if ($this->getIdDiariaPai()) {
                    $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
                }
                
                $daoDiaDiaria->setNrProtocolo($this->getNrProtocolo());

                $daoDiaDiaria->setIdPessoaProponente($this->getIdPessoaProponente());
                $daoDiaDiaria->setIdLotacaoProponente($this->getIdLotacaoProponente());
                $daoDiaDiaria->setIdFuncaoProponente($this->getIdFuncaoProponente());

                $daoDiaDiaria->setIdPessoaProposto($this->getIdPessoaProposto());
                $daoDiaDiaria->setIdLotacaoProposto($this->getIdLotacaoProposto());
                $daoDiaDiaria->setIdFuncaoProposto($this->getIdFuncaoProposto());

                $daoDiaDiaria->setDsServicoExecutado($this->getDsServicoExecutado());
                $daoDiaDiaria->setDsLocaisExecutado($this->getDsLocaisExecutado());

                $daoDiaDiaria->setDtCriacao(Metodos::ConverteDataING($this->getDtCriacao()));

                $daoDiaDiaria->setIdPessoaSolicitante($this->getIdPessoaSolicitante());
                $daoDiaDiaria->setIdCentralSolicitante($this->getIdCentralSolicitante());
                $daoDiaDiaria->setIdPedido($this->getIdPedido());

                if($this->getIdDiariaPai()){
                    $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
                }

                $daoDiaDiaria->setStEstagio($this->getStEstagio());
//                $daoDiaDiaria->setFlRetorno($this->getFlRetorno());

                $daoDiaDiaria->setDsObs($this->getDsObs());

                $daoDiaDiaria->insert($pdo);
                if($daoDiaDiaria->getSucesso()){

                    $idDiaria = $pdo->lastInsertId('dia_diaria_id_diaria_seq');
                    if (!Log::SalvaLogI('dia_diaria', $idDiaria, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                    $this->setIdDiaria($idDiaria);

                    $retorno .= $this->percorreDiariaDestinos($pdo);
                    $retorno .= $this->percorreDiariaAnexos($pdo);

                    if (!$this->erros) {
                        $pdo->commit();
                        $retorno = Metodos::retornoAjax("ok", "html", "Diária cadastrada com sucesso.");
                    }

                } else {
                    $pdo->rollBack();
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDiaria->getMsgRetorno());
                }
                //**********************************DiaDiaria FIM***********************************************
                return $retorno;
            }
            
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    function atualizarDiaria() {
        try {
                        
            $retorno = "";
            
            //****************************Valida data de criação*************************************
            if (!$this->validaDados()){
                return Metodos::retornoAjax("Erro", "alert", $this->msgErros);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                
                //****************************DiaDiaria INICIO********************************************
                $daoDiaDiaria = new DaoDiaDiaria();
                $daoDiaDiaria->setIdTipo($this->getIdTipo());

                if ($this->getIdDiariaPai()) {
                    $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
                }
                
                $daoDiaDiaria->setNrProtocolo($this->getNrProtocolo());

                $daoDiaDiaria->setIdPessoaProponente($this->getIdPessoaProponente());
                $daoDiaDiaria->setIdLotacaoProponente($this->getIdLotacaoProponente());
                $daoDiaDiaria->setIdFuncaoProponente($this->getIdFuncaoProponente());

                $daoDiaDiaria->setIdPessoaProposto($this->getIdPessoaProposto());
                $daoDiaDiaria->setIdLotacaoProposto($this->getIdLotacaoProposto());
                $daoDiaDiaria->setIdFuncaoProposto($this->getIdFuncaoProposto());

                $daoDiaDiaria->setDsServicoExecutado($this->getDsServicoExecutado());
                $daoDiaDiaria->setDsLocaisExecutado($this->getDsLocaisExecutado());

                $daoDiaDiaria->setDtCriacao(Metodos::ConverteDataING($this->getDtCriacao()));

                $daoDiaDiaria->setIdPessoaSolicitante($this->getIdPessoaSolicitante());
                $daoDiaDiaria->setIdCentralSolicitante($this->getIdCentralSolicitante());
                $daoDiaDiaria->setIdPedido($this->getIdPedido());

                if($this->getIdDiariaPai()){
                    $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
                }

                $daoDiaDiaria->setStEstagio($this->getStEstagio());
//                $daoDiaDiaria->setFlRetorno($this->getFlRetorno());

                $daoDiaDiaria->setDsObs($this->getDsObs());
                //Retorna os dados antes da alteração
                $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
                $daoDiaDiaria->selectLinha($pdo);

                if (!$daoDiaDiaria->getSucesso()) {
                    return Metodos::retornoAjax("Erro", "console", $daoDiaDiaria->getMsgRetorno());
                }

                //Se não der erro na seleção da diaria, atribui à variável
                $reg_antigo = $daoDiaDiaria->getMsgRetorno();

                //Atualiza os registros
                $daoDiaDiaria->update($pdo);
                if ($daoDiaDiaria->getSucesso()) {


                    if (!Log::SalvaLogU('dia_diaria', $daoDiaDiaria->getIdDiaria(), $reg_antigo, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                    $retorno .= $this->percorreDiariaDestinos($pdo);
                    $retorno .= $this->percorreDiariaAnexos($pdo);


                    if (empty($retorno)) { //Não deu nenhum erro
                        $pdo->commit();
                        $retorno = Metodos::retornoAjax("ok", "html", "Diária atualizada com sucesso.");
                    } else {
                        $retorno = Metodos::retornoAjax("Erro", "console", $retorno);
                    }
                } else {
                    $pdo->rollBack();
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDiaria->getMsgRetorno());
                }
                //**********************************DiaDiaria FIM***********************************************
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    //****************************************** DIA_DIARIA_DESTINO ************************************************
    function percorreDiariaDestinos(PDO $pdo = null) {
        $retorno = "";
        try {
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            $daoDiaDiariaDestino->setIdDiaria($this->getIdDiaria());
            
            //registros do banco
            $daoDiaDiariaDestino->select($pdo);
            $arrayAuxiliar = $daoDiaDiariaDestino->getMsgRetorno();

            foreach ($this->getItinerario() as $indiceAplicacao => $linhaAplicacao) {
                
                $daoDiaDiariaDestino->setIdDiariaDestino($linhaAplicacao['id_diaria_destino']);
                $daoDiaDiariaDestino->setIdCidadeInicio($linhaAplicacao['id_cidade_inicio']);
                $daoDiaDiariaDestino->setIdCidadeFim($linhaAplicacao['id_cidade_fim']);
                $daoDiaDiariaDestino->setDhInicio($linhaAplicacao['dh_inicio']);
                $daoDiaDiariaDestino->setDhFim($linhaAplicacao['dh_fim']);
                $daoDiaDiariaDestino->setIdTransporte($linhaAplicacao['id_transporte']);
                $daoDiaDiariaDestino->setIdDecreto($linhaAplicacao['id_decreto']);
                $daoDiaDiariaDestino->setIdClasse($linhaAplicacao['id_classe']);
                $daoDiaDiariaDestino->setFlPernoite($linhaAplicacao['fl_pernoite']);
                $daoDiaDiariaDestino->setQtDiariaDestino($linhaAplicacao['qt_diaria_destino']);
                $daoDiaDiariaDestino->setVlDiariaDestino($linhaAplicacao['vl_diaria_destino']);
                
                //se o indice for 0, é um cadastro
                if ((int)$linhaAplicacao['id_diaria_destino'] === 0) {
                    //insert
                    $retorno .= $this->insereDiariaDestino($pdo,$daoDiaDiariaDestino);
                } else {
                    //Percorre os registros persistidos no banco
                    foreach ($daoDiaDiariaDestino->getMsgRetorno() as $indiceBd => $linhaBd) {
                        if($linhaAplicacao['id_diaria_destino'] == $linhaBd['id_diaria_destino']){
                            $diferenca = array_diff_assoc($linhaAplicacao, $linhaBd);
                            if ($diferenca) {
                                //Update
                                $retorno .= $this->atualizaDiariaDestino($pdo,$daoDiaDiariaDestino);
                            }
                            //remove o indice para permanecer no array apenas os registros que deverão ser removidos
                            unset($arrayAuxiliar[$indiceBd]);
                        }
                    }
                }
                //Se ocorrer erro sai do laço e retorna o erro
                if (!empty($retorno)) {
                    return $retorno;
                    break;
                }
                
            }
            
            if ($arrayAuxiliar) {
                //registros que foram excluídos
                foreach ($arrayAuxiliar as $linhaAremover) {
                    $daoDiaDiariaDestino->setIdDiariaDestino($linhaAremover['id_diaria_destino']);
                    $retorno .= $this->excluirDiariaDestino($pdo,$daoDiaDiariaDestino);
                }
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function insereDiariaDestino(PDO $pdo = null,DaoDiaDiariaDestino $daoDiaDiariaDestino){
        $retorno = "";
        try {

            $daoDiaDiariaDestino->insert($pdo);
            if ($daoDiaDiariaDestino->getSucesso()){

                $idDiariaDestino = $pdo->lastInsertId('dia_diaria_destino_id_diaria_destino_seq');
                if (!Log::SalvaLogI('dia_diaria_destino', $idDiariaDestino, $pdo)) {
                    $pdo->rollBack();
                    $retorno = STR_ERROR;
                }

                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaDiariaDestino->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function atualizaDiariaDestino(PDO $pdo = null,DaoDiaDiariaDestino $daoDiaDiariaDestino){
        $retorno = "";
        try {
            
            //Retorna os dados antes da alteração
            $daoDiaDiariaDestino->selectLinha($pdo);

            if (!$daoDiaDiariaDestino->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoDiaDiariaDestino->getMsgRetorno());
            }

            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaDiariaDestino->getMsgRetorno();
            
            //Atualiza os registros
            $daoDiaDiariaDestino->update($pdo);
            
            if ($daoDiaDiariaDestino->getSucesso()) {

                if (!Log::SalvaLogU('dia_diaria_destino', $daoDiaDiariaDestino->getIdDiariaDestino(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    $retorno = STR_ERROR;
                }
                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaDiariaDestino->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirDiariaDestino(PDO $pdo, DaoDiaDiariaDestino $daoDiaDiariaDestino) {
        try {
            
            if (!Log::SalvaLogD('dia_diaria_destino', $daoDiaDiariaDestino->getIdDiariaDestino(), $pdo)) {
                $pdo->rollBack();
                return STR_ERROR;
            }
            
            $daoDiaDiariaDestino->delete($pdo);
            
            if ($daoDiaDiariaDestino->getSucesso()) {
                return "";
            } else {
                return $daoDiaDiariaDestino->getMsgRetorno();
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    //************************************************ FIM *******************************************************
    
    
    //******************************************** DIA_ANEXO *****************************************************
    function percorreDiariaAnexos(PDO $pdo = null) {
        $retorno = "";
        try {
            $daoDiaAnexo = new DaoDiaAnexo();
            $daoDiaAnexo->setIdDiaria($this->getIdDiaria());
            
            //registros do banco
            $daoDiaAnexo->select($pdo);
            $arrayAuxiliar = $daoDiaAnexo->getMsgRetorno();

            if ($this->getAnexos()) {
                foreach ($this->getAnexos() as $indiceAplicacao => $linhaAplicacao) {

                    $daoDiaAnexo->setIdAnexo($linhaAplicacao['id_anexo']);
                    $daoDiaAnexo->setNmAnexo($linhaAplicacao['nm_anexo']);
                    $daoDiaAnexo->setNmMimeType($linhaAplicacao['nm_mime_type']);
                    $path_arquivo = $linhaAplicacao['path_anexo'];

                    //se o indice for 0, é um cadastro
                    if ((int)$linhaAplicacao['id_anexo'] === 0) {
                        //insert
                        $retorno .= $this->insereDiariaAnexo($pdo,$daoDiaAnexo,$path_arquivo);
                    } else {
                        //Percorre os registros persistidos no banco
                        foreach ($daoDiaAnexo->getMsgRetorno() as $indiceBd => $linhaBd) {
                            if($linhaAplicacao['id_anexo'] == $linhaBd['id_anexo']){
                                $diferenca = array_diff_assoc($linhaAplicacao, $linhaBd);
                                if ($diferenca) {
                                    //Update - Por enquanto sem tratamento
                                }
                                //remove o indice para permanecer no array apenas os registros que deverão ser removidos
                                unset($arrayAuxiliar[$indiceBd]);
                            }
                        }
                    }

                    //Se ocorrer erro sai do laço e retorna o erro
                    if (!empty($retorno)) {
                        return $retorno;
                        break;
                    }

                }   
            }
            
            if ($arrayAuxiliar) {
                //registros que foram excluídos
                foreach ($arrayAuxiliar as $linhaAremover) {
                    $daoDiaAnexo->setIdAnexo($linhaAremover['id_anexo']);
                    $retorno .= $this->excluirDiariaAnexo($pdo,$daoDiaAnexo);
                }
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function insereDiariaAnexo(PDO $pdo = null,DaoDiaAnexo $daoDiaAnexo,string $arquivoPath = ''){
        $retorno = "";
        try {
            //tenta abrir o arquivo pra ver ser existe
            $fp = fopen($arquivoPath, "rb");

            if (!$fp) {
                return "erro ao localizar o arquivo";
            } 
            $daoDiaAnexo->setAqAnexo($fp);

            $daoDiaAnexo->insert($pdo);
            
            if ($daoDiaAnexo->getSucesso()){
                $idDiaAnexo = $pdo->lastInsertId('dia_anexo_id_anexo_seq');
                if (!Log::SalvaLogIBinario('dia_anexo', $idDiaAnexo, $pdo)) {;
                    $pdo->rollBack();
                    return STR_ERROR;
                }
                 unlink($arquivoPath);                
                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function atualizaDiariaAnexo(PDO $pdo = null,DaoDiaAnexo $daoDiaAnexo, string $arquivoPath = ''){
        $retorno = "";
        try {
            $fp = fopen($arquivoPath, "rb");

            if (!$fp) {
                return "erro ao localizar o arquivo";
            } 
            $daoDiaAnexo->setAqAnexo($fp);

            //Atualiza os registros
            $daoDiaAnexo->update($pdo);
            
            if ($daoDiaAnexo->getSucesso()) {
                unlink($arquivoPath);
                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirDiariaAnexo(PDO $pdo, DaoDiaAnexo $daoDiaAnexo) {
        try {
            
            if (!Log::SalvaLogDBinario('dia_anexo', $daoDiaAnexo->getIdAnexo(), $pdo)) {
                $pdo->rollBack();
                return STR_ERROR;
            }
            
            $daoDiaAnexo->delete($pdo);
            
            if ($daoDiaAnexo->getSucesso()) {
                return "";
            } else {
                return $daoDiaAnexo->getMsgRetorno();
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    //****************************************************** FIM *********************************************************
    
    //***********************************************DIARIA HISTORICO*****************************************************
    function excluirDiariaHistorico(PDO $pdo, DaoDiaDiariaHistorico $daoDiaDiariaHistorico) {
        try {
            
            if (!Log::SalvaLogD('dia_diaria_historico', $daoDiaDiariaHistorico->getIdDiariaHistorico(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDiaDiariaHistorico->delete($pdo);
            
            if ($daoDiaDiariaHistorico->getSucesso()) {
                return "";
            } else {
                return $daoDiaDiariaHistorico->getMsgRetorno();
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    //***********************************************FIM DIARIA HISTORICO*************************************************
    
    function retornaDadosRelatorio(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->selectDiariaImpressao($pdo);
            
            if ($daoDiaDiaria->getSucesso()) {
                $retorno = $daoDiaDiaria->getMsgRetorno();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaTrsRelatorio(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            $daoDiaDiariaDestino->setIdDiaria($this->getIdDiaria());
            $daoDiaDiariaDestino->selectDiariaDestinos($pdo);
            
            if ($daoDiaDiariaDestino->getSucesso()) {
                foreach ($daoDiaDiariaDestino->getMsgRetorno() as $linha){
                    $retorno .= "<tr><td>".number_format($linha['qt_diaria_destino'],2,",",".")."</td><td>".number_format($linha['vl_diaria_destino'],2,",",".")."</td><td>".number_format($linha['vl_total'],2,",",".")."</td></tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaInfoResumidaRelatorio(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            $daoDiaDiariaDestino->setIdDiaria($this->getIdDiaria());
            $daoDiaDiariaDestino->selectDestinosResumo($pdo);
            
            if ($daoDiaDiariaDestino->getSucesso()) {
                $retorno = $daoDiaDiariaDestino->getMsgRetorno();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaAnexos(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaAnexo = new DaoDiaAnexo();
            $daoDiaAnexo->setIdDiaria($this->getIdDiaria());
            $daoDiaAnexo->select($pdo);
            if ($daoDiaAnexo->getSucesso()) {
                foreach ($daoDiaAnexo->getMsgRetorno() as $linha) {
                    $array_anexo = array('id_anexo' => $linha['id_anexo'],'path_anexo' => '', 'nm_anexo' => $linha['nm_anexo'] , 'nm_mime_type' => $linha['nm_mime_type']);
                    $retorno .= "<div class='form-group' data-anexo='". json_encode($array_anexo) ."'><div class='col-sm-5'><input type='text' value='". $linha['nm_anexo'] ."' class='form-control' disabled></div><div class='col-sm-3'><a target='_blank' href='../diaria/baixarAnexo.php?id=" . $linha['id_anexo'] . "' class='ver-anexo btn btn-info'>Ver</a><a href='#' class='remove-anexo btn btn-danger'>X</a></div><br/><br/></div>";
                }
            } else {
                $retorno = $daoDiaAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    function baixarAnexo(PDO $pdo = null, int $idAnexo = 0) {
        $retorno = "";
        try {
            
            if ($idAnexo == 0) {
                $retorno = 'Arquivo não informado.';
                return $retorno;
            }
            
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaAnexo = new DaoDiaAnexo();
            $daoDiaAnexo->setIdAnexo($idAnexo);
            $daoDiaAnexo->select($pdo);
            
            if ($daoDiaAnexo->getSucesso()) {
                $retorno = $daoDiaAnexo->getMsgRetorno()[0];
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function atualizaEstagioDiaria(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setStEstagio($this->getStEstagio());
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            
            $daoDiaDiaria->selectLinha($pdo);

            
            if (!$daoDiaDiaria->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoDiaDiaria->getMsgRetorno());
            }

            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaDiaria->getMsgRetorno();
            
            $idDiaria = $daoDiaDiaria->getIdDiaria();
            if (!Log::SalvaLogU('dia_diaria', $idDiaria,$reg_antigo ,$pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDiaDiaria->updateEstagio($pdo);
            
            if ($this->insereHistorico($pdo) && $daoDiaDiaria->getSucesso()){ // se executou com sucesso
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Diária atualizada com Sucesso.");
            } else {
                $msgRetorno = $daoDiaDiaria->getMsgRetorno() . $this->erros;
                $retorno = Metodos::retornoAjax("Erro", "console", $msgRetorno );
                $pdo->rollBack();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function insereHistorico(PDO $pdo) {
        $retorno = false;
        try {
             //insere historico da diaria
            $daoDiaDiariaHistorico = new DaoDiaDiariaHistorico();
            $daoDiaDiariaHistorico->setDsDiariaHistorico($this->getHistorico()['ds_diaria_historico']);
            $daoDiaDiariaHistorico->setIdDiaria($this->getIdDiaria());
            $daoDiaDiariaHistorico->setIdPessoa($this->getHistorico()['id_pessoa']);
            
            $daoDiaDiariaHistorico->insert($pdo);
            
            if ($daoDiaDiariaHistorico->getSucesso()) {
                $idDiariaHistorico = $pdo->lastInsertId('dia_diaria_historico_id_diaria_historico_seq');
                if (!Log::SalvaLogI('dia_diaria_historico', $idDiariaHistorico, $pdo)) {
//                    $pdo->rollBack();
                    $this->erros = STR_ERROR;
                    return false;
                }
                $retorno = true;
            } else {
                $this->erros = $daoDiaDiariaHistorico->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return false;
        }
    }
    
    
    function retornaTrDiariasAutorizacao(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setStEstagio($this->getStEstagio());
            $daoDiaDiaria->listaDiariasAutorizacao($pdo);
            $estagios = $this->tiposStEstagios(); //Retorna os estágios e descritivos
            if ($daoDiaDiaria->getSucesso()) {
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    $estagio = $linha['st_estagio'];
                    $pedido = is_null($linha['id_pedido']) ? 0 : $linha['id_pedido'];
                    $ano_pedido = is_null($linha['ano_pedido']) ? 0 : $linha['ano_pedido'];
                    
                    
                    $retorno .= "<tr data-diaria='". json_encode($linha) ."'>"
                                . "<td>" . $linha['id_diaria'] . "</td>"
                                . "<td>". $linha['nr_protocolo']."</td>"
                                . "<td>" . $linha['nm_proponente'] . "</td>"
                                . "<td>" . $linha['nm_proposto'] . "</td>"
                                . "<td>" . $linha['lt_proposto'] . "</td>"
                                . "<td>" . $linha['demanda_central'] . "</td>"
                                . "<td>" . $linha['destino'] . "</td>"
                                . "<td class='text-center'>" . $this->retornaSituacaoDiaria($estagio, $pedido,$ano_pedido) . "</td>"
                                . "<td class='text-center'>";
                        if ($estagio == '2') { //Enviado para deferimento/indeferimento
                            $retorno .= "<button title='Deferir' type='button' class='acao' data-tipo='Deferir' data-toggle='modal' data-target='#acao'>"
                                            . '<i class="fa fa-thumbs-o-up fa-lg text-success" aria-hidden="true"></i>'
                                    . "</button>"
                                      . "<button title='Indeferir' type='button' class='acao' data-tipo='Indeferir' data-toggle='modal' data-target='#acao'>"
                                            . '<i class="fa fa-thumbs-o-down fa-lg text-danger" aria-hidden="true"></i>'
                                    . "</button>";
                        }
                        if ($estagio == '4' || $estagio == '6') { //Deferido
                            $retorno .= "<button title='Indeferir' type='button' class='acao' data-tipo='Indeferir' data-toggle='modal' data-target='#acao'>"
                                            . '<i class="fa fa-thumbs-o-down fa-lg text-danger" aria-hidden="true"></i>'
                                    . "</button>";
                        }
                        
                        if ($estagio != '3') {
                            $retorno .= '<a href="/pages/diarias/diaria/imprimir.php?id=' . $linha['id_diaria'] . '" target="_blank">'
                                        . '<button title="Imprimir proposta e concessão da Diária" type="button" >'
                                            . '<i class="fa fa-print fa-lg" aria-hidden="true"></i>'
                                        . '</button>'
                                    . '</a>';
                        }
                        
                    $retorno .=  "</td>"
                             . "</tr>";  
                }
            }
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    //****************************************MÉTODOS ESTÁTICOS****************************************
    public static function verificaDiariaPedido(int $idPedido = 0){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdPedido($idPedido);
            $daoDiaDiaria->selectDiariaPedido($pdo);
            
            if ($daoDiaDiaria->getSucesso()) {
                return $daoDiaDiaria->getMsgRetorno()['id_diaria'];
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return false;
        }
    }
    //****************************************FIM MÉTODOS ESTÁTICOS*************************************
    
    public function desvinculaPedidoDiaria(PDO $pdo = null) {
        $retorno = "";
        try {
            $observacao = 'Cancelado pedido de necessidade nº '. $this->getIdPedido(). ' vinculado a esta diária.';
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->setIdPedido($this->getIdPedido());
            
            $daoDiaDiaria->selectLinha($pdo);
            
            if (!$daoDiaDiaria->getSucesso()) {
                return $daoDiaDiaria->getMsgRetorno();
            }

            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaDiaria->getMsgRetorno();
            //Atualiza a diária com o nº do pedido
            $daoDiaDiaria->desvinculaDiariaPedido($pdo);
            
            //insere o evento no historico da diaria
            $this->setHistorico(array('ds_diaria_historico' => $observacao, 'id_pessoa' => $this->getUsuarioPedido()));
            
            if ($daoDiaDiaria->getSucesso()) {
                if ($this->insereHistorico($pdo)) {
                    if (!Log::SalvaLogU('dia_diaria', $daoDiaDiaria->getIdDiaria(), $reg_antigo, $pdo)) {
                        $pdo->rollBack();
                        return  STR_ERROR;
                    }
                } else {
                    $retorno = $this->erros;
                }
                return $retorno;
            } else {
                return $daoDiaDiaria->getMsgRetorno();
            }
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    public function vinculaPedidoDiaria(PDO $pdo = null){
        $retorno = "";
        try {
            $observacao  = 'Diária vinculada ao Pedido de necessidade nº '.$this->getIdPedido().'/'.$this->getAnoPedido().'.' ;
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->setIdPedido($this->getIdPedido());
            
            $daoDiaDiaria->selectLinha($pdo);
            
            if (!$daoDiaDiaria->getSucesso()) {
                return $daoDiaDiaria->getMsgRetorno();
            }

            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaDiaria->getMsgRetorno();
            //Atualiza a diária com o nº do pedido
            $daoDiaDiaria->vinculaDiariaPedido($pdo);
            
            //insere o evento no historico da diaria
            $this->setHistorico(array('ds_diaria_historico' => $observacao, 'id_pessoa' => $this->getUsuarioPedido()));

            
            if ($daoDiaDiaria->getSucesso()) {
                if ($this->insereHistorico($pdo)) {
                    if (!Log::SalvaLogU('dia_diaria', $daoDiaDiaria->getIdDiaria(), $reg_antigo, $pdo)) {
                        $pdo->rollBack();
                        return  STR_ERROR;
                    }
                } else {
                    $retorno = $this->erros; //Informação é preenchida pela função 'insereHistorico'
                }
                return $retorno; //Se o retorno for vazio, ocorreu tudo bem
            } else {
                return $daoDiaDiaria->getMsgRetorno();
            }
            
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

}