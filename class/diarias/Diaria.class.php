<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDecreto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTipo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaAnexo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDiariaDestino.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaClasse.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDecretoValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTransporte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDiaria.class.php";


class Diaria {
    private $idDiaria            = null;
    private $idTipo              = null;
    
    private $idPessoaProponente = null;
    private $idFuncaoProponente = null;
    private $idLotacaoProponente = null;
    
    private $idPessoaProposto   = null;
    private $idFuncaoProposto   = null;
    private $idLotacaoProposto  = null;
    
    private $dsServicoExecutado = null;
    private $dsLocaisExecutado  = null;
    private $dsObs               = null;
    
    private $dtCriacao = null;
    private $dhDiaria  = null;
    
    private $itinerario = null;
    private $anexos = null;
    
    private $erros = true;
    
    private $idPessoaSolicitante = null;
    private $flRetorno            = null;
    private $idPedido             = null;
    private $idDiariaPai         = null;
    private $idRelatorio          = null;
    private $stEstagio            = null;
    private $stAtivo              = null;
    
    private $idDiariaDestino = null;
    private $idCidadeInicio = null;
    private $idCidadeFim = null;
    private $origem = null;
    private $destino = null;
    private $dhInicio = null;
    private $dhFim = null;
    private $idTransporte = null;
    private $idDecreto = null;
    private $idClasse = null;
    private $flPernoite = null;
    private $qtDiariaDestino = null;
    private $vlDiariaDestino = null;
    
    private $idAnexo = null;
    
    function getIdAnexo() {
        return $this->idAnexo;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
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
    
    function getOrigem() {
        return $this->origem;
    }

    function getDestino() {
        return $this->destino;
    }

    function setOrigem($origem) {
        $this->origem = $origem;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }

    function getIdDiariaDestino() {
        return $this->idDiariaDestino;
    }

    function setIdDiariaDestino($idDiariaDestino) {
        $this->idDiariaDestino = $idDiariaDestino;
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

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }
    
    function getIdDecreto() {
        return $this->idDecreto;
    }

    function getIdClasse() {
        return $this->idClasse;
    }

    function setIdDecreto($idDecreto) {
        $this->idDecreto = $idDecreto;
    }

    function setIdClasse($idClasse) {
        $this->idClasse = $idClasse;
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
    
    function getIdCidadeInicio() {
        return $this->idCidadeInicio;
    }

    function getIdCidadeFim() {
        return $this->idCidadeFim;
    }

    function getDhInicio() {
        return $this->dhInicio;
    }

    function getDhFim() {
        return $this->dhFim;
    }

    function getIdTransporte() {
        return $this->idTransporte;
    }

    function getFlPernoite() {
        return $this->flPernoite;
    }

    function getQtDiariaDestino() {
        return $this->qtDiariaDestino;
    }

    function getVlDiariaDestino() {
        return $this->vlDiariaDestino;
    }

    function setIdCidadeInicio($idCidadeInicio) {
        $this->idCidadeInicio = $idCidadeInicio;
    }

    function setIdCidadeFim($idCidadeFim) {
        $this->idCidadeFim = $idCidadeFim;
    }

    function setDhInicio($dhInicio) {
        $this->dhInicio = $dhInicio;
    }

    function setDhFim($dhFim) {
        $this->dhFim = $dhFim;
    }

    function setIdTransporte($idTransporte) {
        $this->idTransporte = $idTransporte;
    }

    function setFlPernoite($flPernoite) {
        $this->flPernoite = $flPernoite;
    }

    function setQtDiariaDestino($qtDiariaDestino) {
        $this->qtDiariaDestino = $qtDiariaDestino;
    }

    function setVlDiariaDestino($vlDiariaDestino) {
        $this->vlDiariaDestino = $vlDiariaDestino;
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
                            $retorno .= "<option value = '" . $linha['id_diaria'] . "' selected>Data criação: " . $linha['dt_criacao'] . " / Proponente: " . $linha['nm_proponente'] . " / Proposto: " . $linha['nm_proposto'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $linha['id_diaria'] . "'>Data criação: " . $linha['dt_criacao'] . " / Proponente: " . $linha['nm_proponente'] . " / Proposto: " . $linha['nm_proposto'] ."</option>";
                        }
                    }
                }
            }
            
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
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
            $retorno = "";
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
            //Um destino específico
            if ($this->getIdDiariaDestino() > 0) {
                $daoDiaDiariaDestino->setIdDiariaDestino($this->getIdDiariaDestino());
            }
            $daoDiaDiariaDestino->select($pdo);
            
            if ($daoDiaDiariaDestino->getSucesso()) {
                foreach ($daoDiaDiariaDestino->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-itinerario='" . json_encode($linha) . "' >"
                                    . "<td>".$linha['ds_cidade_inicio']."</td>"
                                    . "<td>".$linha['dh_inicio']."</td>"
                                    . "<td>".$linha['ds_cidade_fim']."</td>"
                                    . "<td>".$linha['dh_fim']."</td>"
                                    . "<td>".number_format($linha['vl_total'], 2,',','.')."</td>"
                                    . "<td><span role='button' class='remove-itinerario'>Remover</span> | <span role='button' class='edit-itinerario'>Alterar</span></td>"
                              . "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaTrDiarias(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->listaDiarias($pdo);
            if ($daoDiaDiaria->getSucesso()) {
                $idDiaria = 0;
                foreach ($daoDiaDiaria->getMsgRetorno() as $linha) {
                    if ($idDiaria != (int)$linha['id_diaria']) {
                        $idDiaria = $linha['id_diaria'];
                        $retorno .= "<tr data-diaria='". json_encode($linha) ."'>"
                                        . "<td>" . $linha['id_diaria'] . "</td>"
                                        . "<td></td>"
                                        . "<td>" . $linha['nm_proponente'] . "</td>"
                                        . "<td>" . $linha['nm_proposto'] . "</td>"
                                        . "<td>" . $linha['nm_lotacao_proposto'] . "</td>"
                                        . "<td>" . $linha['origem_destino'] . "</td>"
                                        . "<td>".number_format($linha['qt_diaria_destino'], 2, ',', '.'). " X R$ ". number_format($linha['vl_diaria_destino'], 2, ',', '.') . " = R$ " . number_format($linha['valor'], 2, ',', '.') . "</td>"
                                        . "<td>"
                                            . "<a href='./diaria/diaria.php?id=" . $linha['id_diaria'] ."'>Editar</a> | "
                                            . "<a href='#' class='excluirDiaria'>Excluir</a> | "
                                            . "<a href='./relatorio/relatorio.php?id=" . $linha['id_diaria'] . "'>Relatório de Viagem</a> | "
                                            . "<a href='./relatorio/imprimirDiaria.php?id=" . $linha['id_diaria'] . "'>Imprimir</a>"
                                        . "</td>"
                                     . "</tr>";
                    } else {
                        $retorno .= "<tr>"
                                    . "<td></td>"
                                    . "<td></td>"
                                    . "<td></td>"
                                    . "<td></td>"
                                    . "<td></td>"   
                                    . "<td>" . $linha['origem_destino'] . "</td>"
                                    . "<td>" .number_format($linha['qt_diaria_destino'], 2, ',', '.'). " X R$ ". number_format($linha['vl_diaria_destino'], 2, ',', '.') . " = R$ " . number_format($linha['valor'], 2, ',', '.') .  "</td>"
                                    . "<td></td>"
                                 . "</tr>";
                    }
                }
            }
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
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
                foreach ($daoDiaDiaria->getMsgRetorno() as $destino) {
                    $retorno = $this->excluirDiariaDestino($pdo,$destino['id_diaria_destino']);
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
    
    function excluirDiariaDestino(PDO $pdo, int $idDestino = 0) {
        try {
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            $daoDiaDiariaDestino->setIdDiaria($this->getIdDiaria());
            $daoDiaDiariaDestino->setIdDiariaDestino($idDestino);
            if (!Log::SalvaLogD('dia_diaria_destino', $idDestino, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
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
    
    function excluirDiariaDestinoIndividual(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            $daoDiaDiariaDestino->setIdDiariaDestino($this->getIdDiariaDestino());
            
            $idDiariaDestino = $daoDiaDiariaDestino->getIdDiariaDestino();
            if (!Log::SalvaLogD('dia_diaria_destino', $idDiariaDestino, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDiaDiariaDestino->delete($pdo);
            if ($daoDiaDiariaDestino->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDiariaDestino->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirDiariaAnexoIndividual(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            $daoDiaAnexo = new DaoDiaAnexo();
            $daoDiaAnexo->setIdAnexo($this->getIdAnexo());
            
            
            $daoDiaDiariaDestino->delete($pdo);
            if ($daoDiaDiariaDestino->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDiariaDestino->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function validaDiariaDestino(){
        $retorno = "";
        $msgErro = "";
        try {
            $destino = json_decode($this->getItinerario());

            $data_inicio = date_create_from_format('d/m/Y H:i', $destino->dh_inicio);
            $data_fim = date_create_from_format('d/m/Y H:i', $destino->dh_fim);

            if (!Metodos::ValidaData($destino->dh_inicio,'d/m/Y H:i') || !Metodos::ValidaData($destino->dh_fim,'d/m/Y H:i')) {
                $msgErro .= 'Data e hora de saída ou chegada inválida.'; 
            }
            
            if ($data_inicio->getTimeStamp() >= $data_fim->getTimeStamp()) {
                $msgErro .= ' Data e hora de chegada não pode ser menor ou igual a data e hora de saída.';
            }
            
            if(empty($msgErro)){
                return Metodos::retornoAjax("ok", "console", $data_fim->format('d/m/Y H:i'));
            } else {
                return Metodos::retornoAjax("Erro", "console", $msgErro);
            }
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
 
    
    function salvarDiaria() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            //****************************DiaDiaria INICIO********************************************
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdTipo($this->getIdTipo());
            
            if ($this->getIdDiariaPai()) {
                $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
            }
            
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
            $daoDiaDiaria->setIdPedido($this->getIdPedido());
            
            if($this->getIdDiariaPai()){
                $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
            }
            
            if($this->getIdRelatorio()){
                $daoDiaDiaria->setIdRelatorio($this->getIdRelatorio());
            }
            
            $daoDiaDiaria->setStEstagio($this->getStEstagio());
            $daoDiaDiaria->setFlRetorno($this->getFlRetorno());
            
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
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    function atualizarDiaria() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            //****************************DiaDiaria INICIO********************************************
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdTipo($this->getIdTipo());
            
            if ($this->getIdDiariaPai()) {
                $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
            }
            
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
            $daoDiaDiaria->setIdPedido($this->getIdPedido());
            
            if($this->getIdDiariaPai()){
                $daoDiaDiaria->setIdDiariaPai($this->getIdDiariaPai());
            }
            
            if($this->getIdRelatorio()){
                $daoDiaDiaria->setIdRelatorio($this->getIdRelatorio());
            }
            
            $daoDiaDiaria->setStEstagio($this->getStEstagio());
            $daoDiaDiaria->setFlRetorno($this->getFlRetorno());
            
            $daoDiaDiaria->setDsObs($this->getDsObs());
            //Retorna os dados antes da alteração
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->select($pdo);

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
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    
    function percorreDiariaDestinos(PDO $pdo = null) {
        $retorno = "";
        try {
            $daoDiaDiariaDestino = new DaoDiaDiariaDestino();
            foreach ($this->getItinerario() as $destino) {
                $daoDiaDiariaDestino->setIdDiaria($this->getIdDiaria());
                $daoDiaDiariaDestino->setIdDiariaDestino($destino['id_diaria_destino']);
                $daoDiaDiariaDestino->setIdCidadeInicio($destino['id_cidade_inicio']);
                $daoDiaDiariaDestino->setIdCidadeFim($destino['id_cidade_fim']);
                $daoDiaDiariaDestino->setDhInicio($destino['dh_inicio']);
                $daoDiaDiariaDestino->setDhFim($destino['dh_fim']);
                $daoDiaDiariaDestino->setIdTransporte($destino['id_transporte']);
                $daoDiaDiariaDestino->setIdDecreto($destino['id_decreto']);
                $daoDiaDiariaDestino->setIdClasse($destino['id_classe']);
                $daoDiaDiariaDestino->setFlPernoite($destino['fl_pernoite']);
                $daoDiaDiariaDestino->setQtDiariaDestino($destino['qt_diaria_destino']);
                $daoDiaDiariaDestino->setVlDiariaDestino($destino['vl_diaria_destino']);
                
                
                if((int)$destino['id_diaria_destino'] === 0){ //CADASTRO
                    $retorno .= $this->insereDiariaDestino($pdo,$daoDiaDiariaDestino);
                } else { //ALTERAÇÃO
                    $daoDiaDiariaDestino->select($pdo);
                    //Verifica se o registro foi alterado para atualizar de fato no banco de dados
                    $diferenca = array_diff_assoc($daoDiaDiariaDestino->getMsgRetorno()[0], $destino);
                    if (!empty($diferenca)) {
                        $retorno .= $this->atualizaDiariaDestino($pdo,$daoDiaDiariaDestino);
                    }
                }
                if (!empty($retorno)) {
                    return $retorno;
                    break;
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
            $daoDiaDiariaDestino->select($pdo);

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
    
    function percorreDiariaAnexos(PDO $pdo = null) {
        $retorno = "";
        try {
            $daoDiaAnexo = new DaoDiaAnexo();
            if ($this->getAnexos()) {
                foreach ($this->getAnexos() as $anexo) {
                    $daoDiaAnexo->setIdDiaria($this->getIdDiaria());
                    $daoDiaAnexo->setIdAnexo((int)$anexo['id_anexo']);
                    $daoDiaAnexo->setNmAnexo($anexo['nm_anexo']);
                    $daoDiaAnexo->setNmMimeType($anexo['nm_mime_type']);
                    
                    if (array_key_exists('path_anexo', $anexo)) {
                        $arquivoPath = $anexo['path_anexo'];
                    }

                    if((int)$anexo['id_anexo'] === 0){ //CADASTRO
                        $retorno .= $this->insereDiariaAnexo($pdo,$daoDiaAnexo,$arquivoPath);
                    } else { //ALTERAÇÃO
                        $daoDiaAnexo->select($pdo);
                        //Verifica se o registro foi alterado para atualizar de fato no banco de dados
                        $diferenca = array_diff_assoc($daoDiaAnexo->getMsgRetorno()[0], $anexo);
                        if (!empty($diferenca)) {
                            $retorno .= $this->atualizaDiariaAnexo($pdo,$daoDiaAnexo,$arquivoPath);
                        }
                    }
                    if (!empty($retorno)) {
                        return $retorno;
                        break;
                    }
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
                    $retorno .= "<div class='form-group' data-anexo='". json_encode($array_anexo) ."'><div class='col-sm-5'><input type='text' value='". $linha['nm_anexo'] ."' class='form-control' disabled></div><div class='col-sm-3'><a href='../diaria/baixarAnexo.php?id=" . $linha['id_anexo'] . "' class='ver-anexo btn btn-info'>Ver</a><a href='#' class='remove-anexo btn btn-danger'>X</a></div><br/><br/></div>";
                }
            } else {
                $retorno = $daoDiaAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    function baixarAnexo(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaAnexo = new DaoDiaAnexo();
            $daoDiaAnexo->setIdAnexo($this->getIdAnexo());
            $daoDiaAnexo->select($pdo);
            
            if ($daoDiaAnexo->getSucesso()) {
                $retorno = $daoDiaAnexo->getMsgRetorno()[0];
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }

}