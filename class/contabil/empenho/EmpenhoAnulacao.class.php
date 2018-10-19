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
//            $pdo->rollBack();
//            return;
            
            $daoEmpenhoAnulacaoItens = new DaoConEmpenhoAnulacaoItem();
            $daoEmpenhoAnulacaoItens->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            
            foreach ($ItensPreOrdem as $key => $value) {
                $kI = array_search($value['id_pre_ordem'], array_column($this->itens, "id"));                
                if($kI === false){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Não foi possível fazer a Anulação do Item de Número ".$value['nr_item']." ".STR_ERROR." ");
                }
                                                
                $valorInformado = $value['vl_itens_pre'];
                $quantidadeInformado = round($this->itens[$kI]['quantidade'], 4);
                                
                $valorTotalParaAnular = $quantidadeInformado;
                
                if($value['tp_material'] == "S" || $value['fl_valor_variavel'] == 1){
                    $valorTotalParaAnular = round( ($valorInformado * $quantidadeInformado), 4);
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
    
    
    
    
    
    
    public function atualizaValoresFinPreOrdem(PDO $pdo = null) {
        try {
            if(empty($pdo)){
                $this->sucesso = false;
                $this->msgRetorno = "Não possui conexão ativa.";
                return;
            }
            if (empty($this->idEmpenhoAnulacao)) {
                $this->sucesso = false;
                $this->msgRetorno = "É Necessário informar a Anulação do Empenho";
                return;
            }
                      
            $daoEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoEmpenhoAnulacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoEmpenhoAnulacao->retorna($pdo);
            if(!$daoEmpenhoAnulacao->getSucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar a Anulação do Empenho";
                return;
            }
            
            $dadosEmpenhoAnulacao = $daoEmpenhoAnulacao->getMsgRetorno();
            
            
            $daoEmpenhoAnulacaoItem = new DaoConEmpenhoAnulacaoItem();
            $daoEmpenhoAnulacaoItem->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoEmpenhoAnulacaoItem->retornaItensComPreOrdem($pdo);
            if(!$daoEmpenhoAnulacaoItem->getSucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar os Itens da Anulação do Empenho.";
                return;
            }
           
            $itensAnulacao = $daoEmpenhoAnulacaoItem->getMsgRetorno();
            
//            echo "<pre>";
//            print_r($itensAnulacao);
//            echo "</pre>";
                                
            $itensArray = array();
            
            foreach ($itensAnulacao as $key => $value) {
                $itensArray[] = $value['id_pre_ordem'];
            }
            
            
            $finOrdemModel = new FinOrdemModel();
            $ItensPreOrdem = $finOrdemModel->retornaItensParaAnulacaoEmpenhoPorItens($itensArray, $pdo);
            if(!$ItensPreOrdem){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Localizar os Itens do Pedido de Necessidade.";       
                return;
            }
//            echo "<pre>";
//            print_r($ItensPreOrdem);
//            echo "</pre>";
                                    
            $daoEmpenhoAnulacaoItens = new DaoConEmpenhoAnulacaoItem();
            $daoEmpenhoAnulacaoItens->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            
            foreach ($ItensPreOrdem as $key => $value) {
                $kI = array_search($value['id_pre_ordem'], array_column($itensAnulacao, "id_pre_ordem"));                
                if($kI === false){
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível fazer a Anulação do Item de Número ".$value['nr_item']." ".STR_ERROR;       
                    return;                    
                }
                                                
                $valorInformado = $value['vl_itens_pre'];
                $quantidadeInformado = round($itensAnulacao[$kI]['qt_anulado'], 4);
                                
                $valorTotalParaAnular = $quantidadeInformado;
                
                if($value['tp_material'] == "S" || $value['fl_valor_variavel'] == 1){
                    $valorTotalParaAnular = round( ($valorInformado * $quantidadeInformado), 4);
                }
                
                //echo " \n ".$valorInformado." - ".$quantidadeInformado." - ".$valorTotalParaAnular." \n";
                
                if(round($value['saldo'], 4) < $valorTotalParaAnular){
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível fazer a Anulação do Item "
                            . "de Número ".$value['nr_item']." Pois o Valor Informado Para Anulação "
                            . "ficará menor que o Saldo Disponível para Anualação.";       
                    return;                                      
                }
                
                if($value['qt_itens_pre'] < $quantidadeInformado){
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível fazer a Anulação do Item "
                            . "de Número ".$value['nr_item']." Pois a Quantidade Informado Para Anulação "
                            . "ficará zerado";       
                    return; 
                }
                
                $quantidadeNovo = round(($value['qt_itens_pre'] - $quantidadeInformado), 4);
                if($quantidadeNovo <= 0){
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível fazer a Anulação do Item "
                            . "de Número ".$value['nr_item']." Pois a Quantidade Informado Para Anulação "
                            . "ficará zerado";       
                    return; 
                }
                
                $preOrdem = new PreOrdem();
                $preOrdem->setIdPreOrdem($value['id_pre_ordem']);
                //$preOrdem->setVlItensPre($valorInformado);
                $preOrdem->setQtItensPre($quantidadeNovo);
                $preOrdem->editarPreOrdemAnulacaoEmpenho($pdo);
                if(!$preOrdem->Sucesso()){
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível fazer a Anulação do Item "
                            . "de Número ".$value['nr_item']." Pois não foi possível Atualizar os Itens da Pre Ordem.";
                    return; 
                }                                        
            }
            
            $pedido = new Pedido();
            $pedido->setIdPedido($dadosEmpenhoAnulacao['id_pedido']);
            $dadosPedido = $pedido->retornaDadosPedido($pdo);
            if(!is_array($dadosPedido)){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Localizar o Pedido.";       
                return; 
            }
            
            $valorPedidoEmpenhoAntigo = $dadosPedido['vl_pedido'];
            
//            echo "<pre>";
//            print_r($dadosPedido);
//            echo "</pre>";
            
            $empenho = new FinEmpenhoModel();
            $empenho->setIdPedido($dadosPedido['id_pedido']);
            $dadosEmpenho = $empenho->retornaDadosEmpenhoPorPedido($pdo);
            if(!is_array($dadosEmpenho)){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Localizar o Empenho.";       
                return; 
            }
            
//            echo "<pre>";
//            print_r($dadosEmpenho);
//            echo "</pre>";
            
            
            $preOrdem = new PreOrdem();
            $preOrdem->setIdPedido($dadosEmpenhoAnulacao['id_pedido']);
            if (!$preOrdem->atualizaValorPedido($pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Atualizar o Valor do Pedido.";
                return;                
            }
                                                            
            $pedidoAux = new Pedido();
            $pedidoAux->setIdPedido($dadosEmpenhoAnulacao['id_pedido']);
            $dadosPedido = $pedidoAux->retornaDadosPedido($pdo);
            
//            echo "<pre>";
//            print_r($dadosPedido);
//            echo "</pre>";
            
            $empenho->setVlEmpenho($dadosPedido['vl_pedido']);
            $empenho->setIdEmpenho($dadosEmpenho['id_empenho']);
            
            $empenho->atualizaValorEmpenhoAtualizaQDD($valorPedidoEmpenhoAntigo, $pdo);
            if(!$empenho->sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível atualizar o Valor do Empenho e nem o QDD.";       
                return; 
            }
            
            
//            $dadosEmpenho = $empenho->retornaDadosEmpenhoPorPedido($pdo);
//            if(!is_array($dadosEmpenho)){
//                $this->sucesso = false;
//                $this->msgRetorno = "Não foi possível Localizar o Empenho.";       
//                return; 
//            }
            
//            echo "<pre>";
//            print_r($dadosEmpenho);
//            echo "</pre>";
            
//            $finOrdemModel = new FinOrdemModel();
//            $ItensPreOrdem = $finOrdemModel->retornaItensParaAnulacaoEmpenhoPorItens($itensArray, $pdo);
//            if(!$ItensPreOrdem){
//                $this->sucesso = false;
//                $this->msgRetorno = "Não foi possível Localizar os Itens do Pedido de Necessidade.";       
//                return;
//            }
//            echo "<pre>";
//            print_r($ItensPreOrdem);
//            echo "</pre>";
            
            
           
            
            
//            echo " \n E";
//            $pdo->commit();
//            return;
            
            $this->sucesso = true;
            $this->msgRetorno = "Atualização do Empenho/QDD Realizado com Sucesso";
          
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    
    
    
    
    
    
    
    public function retornaDadosDaAnulacaoDoEmpenho() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacao->retornaDadosDaAnulacaoDoEmpenho($pdo);
            return $daoConEmpenhoAnulacao->getMsgRetorno();

        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }
    
    public function retornaDadosEmpenhoDaAnulacao() {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dadosEmpenho = '';
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacao->retornaDadosEmpenhoDaAnulacao($pdo);

            if ($daoConEmpenhoAnulacao->getSucesso()) {
                $campos = $daoConEmpenhoAnulacao->getMsgRetorno();
                
                $dadosEmpenho .= '<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree"
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span>
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Data do Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos["dt_empenho"] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo de Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos["nm_tipo_empenho"] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos['vl_empenho_antigo'] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do Empenho após a Anulação:</b></div>
                                                        <div class="col-sm-3">' . $campos['vl_empenho_atual'] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>

                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosEmpenho;
            }
            return $dadosEmpenho;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }
    
    public function retornaDadosContratoDaAnulacao() {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dadosContrato = '';
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacao->retornaDadosContratoDaAnulacao($pdo);
            if ($daoConEmpenhoAnulacao->getSucesso()) {
                $campos = $daoConEmpenhoAnulacao->getMsgRetorno();

                $dadosContrato .= '<div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" 
                                                        aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Contrato: </b><span style="color:#758697"> Nº ' . $campos["nr_contrato"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false">
                                                <div class="panel-body">
                                                
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Licitação:</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_pregao"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo de Gasto:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_tipo_gasto"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Objeto:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_objeto"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Modalidade:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_modalidade"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Fornecedor:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_pessoa"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>CPF/CNPJ do Fornecedor:</b></div>
                                                        <div class="col-sm-10">' . Metodos::formataCnpj($campos["cpfcnpj"]) . '</div>
                                                    </div>
                                                    
                                                     <div class="form-group">
                                                        <div class="col-sm-2"><b>Nº do Processo Administrativo da Despesa Publica:</b></div>
                                                        <div class="col-sm-10"></div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosContrato;
            }
            return $dadosContrato;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }
    
    public function retornaDadosPedidoDaAnulacao() {
        try {

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dadosPedido = '';
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacao->retornaDadosPedidoDaAnulacao($pdo);

            if ($daoConEmpenhoAnulacao->getSucesso()) {
                $campos = $daoConEmpenhoAnulacao->getMsgRetorno();

                $dadosPedido .= '<div class="panel-group" id="accordionTwo" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTwo" 
                                                        aria-expanded="false" aria-controls="collapseTwo" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Pedido de Necessidade: </b><span style="color:#758697"> Nº ' . $campos["nr_pedido"].'/'.$campos['ano']. '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input type="hidden" id="id_pedido" value=' . $campos['id_pedido'] . ' data-tipo-solicitacao=' . $campos['id_tipo_solicitacao'] . ' />
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Descrição:</b></div>
                                                        <div class="col-sm-10">' . $campos["ds_pedido"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Fonte:</b></div>
                                                        <div class="col-sm-10">' . $campos["nr_fonte"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>' . STR_FUNCIONAL_PROGRAMATICA . ':</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_programa_trabalho"] . '- ' . $campos["ds_programa_trabalho"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Despesa:</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_despesa"] . '- ' . $campos["ds_despesa"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo da Solicitação:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_tipo_solicitacao"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do Pedido:</b></div>
                                                        <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["vl_pedido"], 4) . '</div>
                                                    </div>
                                                                                                        
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosPedido;
            }
            return $dadosPedido;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }
    
    public function retornaItensDaAnulacaoDoEmpenho() {
        try {
            $tabela = '';

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacao->retornaItensDaAnulacaoDoEmpenho($pdo);

            if ($daoConEmpenhoAnulacao->getSucesso()) {
                foreach ($daoConEmpenhoAnulacao->getMsgRetorno() as $linha) {
                    $total_anulado = $linha['qt_anulado'] * $linha['vl_anulado'];
                    $total_geral = $linha['qt_item'] * $linha['vl_item'];
                    $tabela .= '<tr>
                                    <td class="text-center">' . $linha["nr_item"] . '</td>
                                    <td class="text-center">' . $linha["nm_material"] . '</td>
                                    <td class="text-center">' . $linha["nm_desc_material"] . '</td>                                                                                                                        
                                    <td class="text-center">' . $linha["tp_material"] . '</td>
                                    <td class="text-center">' . $linha["nr_lote"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["qt_item"], 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_item"], 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($total_geral, 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_saldo"], 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["qt_anulado"], 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($total_anulado, 4) . '</td>
                                </tr>';
                }
            }
            return $tabela;
        } catch (Exception $exc) {
            return $ex->getMessage();
        }
    }
    
    public function retornaAnotacoesDaAnulacaoDoEmpenho(){
        try {
            $anotacoes = '';

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConEmpenhoAnulacaoAnotacao = new DaoConEmpenhoAnulacaoAnotacao();
            $daoConEmpenhoAnulacaoAnotacao->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacaoAnotacao->lista($pdo);
            
            if ($daoConEmpenhoAnulacaoAnotacao->getSucesso()) {
                foreach ($daoConEmpenhoAnulacaoAnotacao->getMsgRetorno() as $linha) {
                    $anotacoes .=  $linha['anotacao'] . "\n";
                }
            }
            return $anotacoes;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function retornaHistoricoDaAnulacaoDoEmpenho(){
        try {
            $historico = '';
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoConEmpenhoAnulacaoHistorico = new DaoConEmpenhoAnulacaoHistorico();
            $daoConEmpenhoAnulacaoHistorico->setIdEmpenhoAnulacao($this->idEmpenhoAnulacao);
            $daoConEmpenhoAnulacaoHistorico->lista($pdo);
            
            if ($daoConEmpenhoAnulacaoHistorico->getSucesso()) {
                foreach ($daoConEmpenhoAnulacaoHistorico->getMsgRetorno() as $linha) {
                    $historico .= $linha['historico'] . "\n";
                }
            }
            return $historico;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}

