<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacaoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacaoHistorico.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacaoItem.class.php";

class EmpenhoAnulacao{
    
    private $idEmpenhoAnulacao = null;
    private $idPedido = null;
    private $idEmpenho = null;
    private $nrAnulacao = null;
    private $dtAnulacao = null;
    private $vlAnulacao = null;
    private $idEmpenhoAnulacaoSituacao = null;
    private $idEmpenhoAnulacaoStatus = null;
    private $idPessoa = null;
    private $dsEmpenhoAnulacaoAnotacao = null;
    private $itens = null;
    
    private $situacaoCadastrado = 1;
    private $situacaoDeferido = 2;
    private $situacaoIndeferido = 3;
    private $situacaoCancelado = 4;
    private $statusAguardandoDeferido = 1;
    private $statusFinalizado = 2;    
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    public function getSituacaoCadastrado() {
        return $this->situacaoCadastrado;
    }

    public function getSituacaoDeferido() {
        return $this->situacaoDeferido;
    }

    public function getSituacaoIndeferido() {
        return $this->situacaoIndeferido;
    }

    public function getSituacaoCancelado() {
        return $this->situacaoCancelado;
    }

    public function getStatusAguardandoDeferido() {
        return $this->statusAguardandoDeferido;
    }

    public function getStatusFinalizado() {
        return $this->statusFinalizado;
    }
        
    public function getSucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }
        
    public function getIdPedido() {
        return $this->idPedido;
    }

    public function getIdEmpenho() {
        return $this->idEmpenho;
    }

    public function getNrAnulacao() {
        return $this->nrAnulacao;
    }

    public function getDtAnulacao() {
        return $this->dtAnulacao;
    }

    public function getVlAnulacao() {
        return $this->vlAnulacao;
    }

    public function getIdEmpenhoAnulacaoSituacao() {
        return $this->idEmpenhoAnulacaoSituacao;
    }

    public function getIdEmpenhoAnulacaoStatus() {
        return $this->idEmpenhoAnulacaoStatus;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getDsEmpenhoAnulacaoAnotacao() {
        return $this->dsEmpenhoAnulacaoAnotacao;
    }

    public function getItens() {
        return $this->itens;
    }

    public function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
        return $this;
    }

    public function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
        return $this;
    }

    public function setNrAnulacao($nrAnulacao) {
        $this->nrAnulacao = $nrAnulacao;
        return $this;
    }

    public function setDtAnulacao($dtAnulacao) {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    public function setVlAnulacao($vlAnulacao) {
        $this->vlAnulacao = $vlAnulacao;
        return $this;
    }

    public function setIdEmpenhoAnulacaoSituacao($idEmpenhoAnulacaoSituacao) {
        $this->idEmpenhoAnulacaoSituacao = $idEmpenhoAnulacaoSituacao;
        return $this;
    }

    public function setIdEmpenhoAnulacaoStatus($idEmpenhoAnulacaoStatus) {
        $this->idEmpenhoAnulacaoStatus = $idEmpenhoAnulacaoStatus;
        return $this;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    public function setDsEmpenhoAnulacaoAnotacao($dsEmpenhoAnulacaoAnotacao) {
        $this->dsEmpenhoAnulacaoAnotacao = $dsEmpenhoAnulacaoAnotacao;
        return $this;
    }

    public function setItens($itens) {
        $this->itens = $itens;
        return $this;
    }
    
    public function getIdEmpenhoAnulacao() {
        return $this->idEmpenhoAnulacao;
    }

    public function setIdEmpenhoAnulacao($idEmpenhoAnulacao) {
        $this->idEmpenhoAnulacao = $idEmpenhoAnulacao;
        return $this;
    }

    

    
    /**
     * Cadastra a Anulação
     * @param bool $perfilTI
     * @return type
     */
    public function salvarAnulacao(bool $perfilTI) {
        try {

            if (empty($this->getIdEmpenho()) || empty($this->getIdPessoa()) 
                    || empty($this->getNrAnulacao()) || empty($this->getDtAnulacao()) 
                    || empty($this->getVlAnulacao()) || empty($this->getItens())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            if(!is_array($this->getItens())){
                return Metodos::retornoAjax("Erro", "alert", "Nenhum Item do Pedido foi Selecionado para Anulação.");
            }
            
            $this->vlAnulacao = Metodos::ConverteValorIng($this->vlAnulacao);            
            if( $this->vlAnulacao == "0" || $this->vlAnulacao == "0.0"
                || $this->vlAnulacao == "0.0000" || $this->vlAnulacao == "0.00"
                || $this->vlAnulacao <= 0){
                return Metodos::retornoAjax("Erro", "alert", "Valor da Anulação não pode ser Zero ou menor que zero.");
            }
            
            $this->dtAnulacao = Metodos::validaConverteDataING($this->dtAnulacao);
            if(empty($this->dtAnulacao)){
                return Metodos::retornoAjax("Erro", "alert", 'Informe uma Data Para Anulação.');
            }else{
                $this->dtAnulacao = new DateTime($this->dtAnulacao);
            }
                        
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
                        
            $finEmpenho = new FinEmpenhoModel();
            $finEmpenho->setIdEmpenho($this->idEmpenho);            
            $dadosEmpenho = $finEmpenho->retornaDadosEmpenho($pdo);            
          
            if (empty($dadosEmpenho)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o Empenho.");                
            }            
            
            
            //Busca dados do Pedido
            $pedido = new Pedido();
            $pedido->setIdPedido($dadosEmpenho['id_pedido']);
            $dadosPedido = $pedido->retornaDadosPedido();
            if(empty($dadosPedido)){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar os Dados do Pedido.");
            }                       
            $this->idPedido = $dadosEmpenho['id_pedido'];
            //Verifica se o Empenho já está cancelado
            if($dadosEmpenho['sit_empenho'] == $finEmpenho->getSitCancelado()){
                return Metodos::retornoAjax("Erro", "alert", "Ação não realizado, pois o Empenho já foi Cancelado.");
            }
                  
            
            if(!$perfilTI){
                $CentralResponsavel = new CentralResponsavel();
                $CentralResponsavel->setIdPessoa($this->idPessoa);
                $CentralResponsavel->setIdLotacao($dadosPedido['id_lotacao']);
                $CentralResponsavel->verificaPermissao($pdo);
                if(!$CentralResponsavel->Sucesso()){
                    return Metodos::retornoAjax("Erro", "alert", "Você não possui permissão para Cancelar o Empenho/Pedido Dessa Central"
                            . ". Somente poderá Anular Empenho/Pedido Da sua Central de Demanda");
                }
            }
            
            
            
            $daoEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoEmpenhoAnulacao->setIdPedido($this->idPedido);
            $daoEmpenhoAnulacao->setNrEmpenhoAnulacao($this->nrAnulacao);
            $daoEmpenhoAnulacao->setDtEmpenhoAnulacao($this->dtAnulacao->format("Y-m-d"));
            $daoEmpenhoAnulacao->setVlEmpenhoAnulacao($this->vlAnulacao);
            $daoEmpenhoAnulacao->setVlEmpenhoAntigo($dadosEmpenho['vl_empenho']);
            $daoEmpenhoAnulacao->setIdEmpenhoAnulacaoSituacao($this->situacaoCadastrado);
            $daoEmpenhoAnulacao->setIdEmpenhoAnulacaoStatus($this->statusAguardandoDeferido);
            $daoEmpenhoAnulacao->setIdPessoa($this->idPessoa);
            $daoEmpenhoAnulacao->insert($pdo);
            if(!$daoEmpenhoAnulacao->getSucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Criar a Anulação do Empenho.");
            }
            
            $this->idEmpenhoAnulacao = $pdo->lastInsertId('con_empenho_anulacao_id_empenho_anulacao_seq');
            if (!Log::SalvaLogI('con_empenho_anulacao', $this->idEmpenhoAnulacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Anulação no LOG. Operação Cadastro.");
            }
                
            
//            echo "<pre>";
//            print_r($this->itens);
//            echo "</pre>";
           
            /*
             * Verifica os Itens da Pre Ordem que o usuário deseja anular
             * Irá retornar os Valores de Cada Item e o Saldo do Pedido
             * O Valor anulado não pode ser Maior que o Saldo de Cada Item
             */
            $itensArray = array();
            foreach ($this->itens as $key => $value) {
                $itensArray[] = $value['id'];
            }                                   
            
            $finOrdemModel = new FinOrdemModel();
            $ItensPreOrdem = $finOrdemModel->retornaItensParaAnulacaoEmpenhoPorItens($itensArray, $pdo);
            if(!$ItensPreOrdem){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar os Itens do Pedido de Necessidade.");
            }
//            echo "<pre>";
//            print_r($ItensPreOrdem);
//            echo "</pre>";
            
            $daoEmpenhoAnulacaoItens = new DaoConEmpenhoAnulacaoItem();
            $daoEmpenhoAnulacaoItens->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            
            foreach ($ItensPreOrdem as $key => $value) {
                $kI = array_search($value['id_pre_ordem'], array_column($this->itens, "id"));                
                if($kI === false){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Não foi possível fazer a Anulação do Item de Número ".$value['nr_item']." ".STR_ERROR." ");
                }
                                                
                $valorInformado = round($this->itens[$kI]['valor'], 4);
                $quantidadeInformado = round($this->itens[$kI]['quantidade'], 4);
                                
                $valorTotalParaAnular = $quantidadeInformado;
                
                if($value['tp_material'] == "S" || $value['fl_valor_variavel'] == 1){
                    $valorTotalParaAnular = round( ($valorInformado * $quantidadeInformado), 4);
                }else{
                    $valorInformado = $value['vl_itens_pre'];
                }
                
                //echo " \n ".$valorInformado." - ".$quantidadeInformado." - ".$valorTotalParaAnular." \n";
                
                if(round($value['saldo'], 4) < $valorTotalParaAnular){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Não foi possível fazer a Anulação do Item "
                            . "de Número ".$value['nr_item']." Pois o Valor Informado Para Anulação "
                            . "ficará menor que o Saldo Disponível para Anualação.");
                }
                
                $daoEmpenhoAnulacaoItens->setIdPreOrdem($value['id_pre_ordem']);
                $daoEmpenhoAnulacaoItens->setQtItem($value['qt_itens_pre']);
                $daoEmpenhoAnulacaoItens->setVlItem($value['vl_itens_pre']);
                $daoEmpenhoAnulacaoItens->setQtAnulacao($quantidadeInformado);
                $daoEmpenhoAnulacaoItens->setVlAnulado($valorInformado);
                $daoEmpenhoAnulacaoItens->setVlSaldo(round($value['saldo'], 4));
                $daoEmpenhoAnulacaoItens->insert($pdo);
                if(!$daoEmpenhoAnulacaoItens->getSucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Não foi possível fazer a Anulação do Item "
                            . "de Número ".$value['nr_item']."".STR_ERROR);
                }
                
                
                
                //echo round($value['saldo'], 4)." ".round($this->itens[$kI][''])
                
                
            }
            
            
//            echo " \n E";
//            $pdo->rollBack();
//                    return;
            
            //Salva o Histórico da Anulação
            $daoEmpenhoAnulacaoHistorico = new DaoConEmpenhoAnulacaoHistorico();
            $daoEmpenhoAnulacaoHistorico->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoEmpenhoAnulacaoHistorico->setIdEmpenhoAnulacaoSituacao($this->situacaoCadastrado);
            $daoEmpenhoAnulacaoHistorico->setIdEmpenhoAnulacaoStatus($this->statusAguardandoDeferido);
            $daoEmpenhoAnulacaoHistorico->setIdPessoa($this->idPessoa);
            $daoEmpenhoAnulacaoHistorico->setDsEmpenhoAnulacaoHistorico("");
            $daoEmpenhoAnulacaoHistorico->insert($pdo);
            if(!$daoEmpenhoAnulacaoHistorico->getSucesso()){                
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Criar o Histórico da Anulação do Empenho.");
            }
            
            $idEmpenhoHistorico = $pdo->lastInsertId('con_empenho_anulacao_historic_id_empenho_anulacao_historico_seq');
            if (!Log::SalvaLogI('con_empenho_anulacao_historico', $idEmpenhoHistorico, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar o Histórico da Anulação no LOG. Operação Cadastro.");
            }
            
            
            //Salva a Anotação da Anulação
            if(!empty($this->dsEmpenhoAnulacaoAnotacao)){                
                $daoEmpenhoAnulacaoAnotacao = new DaoConEmpenhoAnulacaoAnotacao();
                $daoEmpenhoAnulacaoAnotacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
                $daoEmpenhoAnulacaoAnotacao->setIdPessoa($this->idPessoa);
                $daoEmpenhoAnulacaoAnotacao->setDsEmpenhoAnulacaoAnotacao($this->dsEmpenhoAnulacaoAnotacao);
                $daoEmpenhoAnulacaoAnotacao->insert($pdo);
                if(!$daoEmpenhoAnulacaoAnotacao->getSucesso()){                    
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Anotação da Anulação. Operação Cadastro."); 
                }
                
                $idEmpenhoAnotacao = $pdo->lastInsertId('con_empenho_anulacao_anotacao_id_empenho_anulacao_anotacao_seq');
                if (!Log::SalvaLogI('con_empenho_anulacao_anotacao', $idEmpenhoAnotacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Anotação da Anulação no LOG. Operação Cadastro.");
                }
                
            }
            
            
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
          
        } catch (Exception $exc) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }
    
    
    
    
    
    
}

