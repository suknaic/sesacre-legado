<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoAditivo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/centrais/FinCentraisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestor/FinGestorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/fiscais/FinFiscaisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/sub_fiscal/SubFiscalModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";


class FinContratoAditivo {
            
    private $idContratoAditivo = null;
    private $idContrato = null;
    private $idMotivo = null;
    private $numeroNovoAditivo = null;
    private $idBaseCalculo = null;
    private $dtPublicacao = null;
    private $idFinalidade = null;
    private $idUnidadeCalculo = null;
    private $indiceCorrecao = null;
    private $idInstrumento = null;
    private $percentual = null;
    private $dtPeriodoInicial = null;
    private $dtPeriodoFinal = null;
    private $idTipoAquisicao = null;
    private $dtAssinatura = null;
    private $dsJustificativa = null;
    private $gestorTitular = null;
    private $gestorSubstituto = null;
    private $fiscal = null;
    private $fiscalSubstituto = null;
    private $subFiscal = null;
    private $subFiscalSubstituto = null;
    private $itens = null;
    private $idFornecedor = null;
    private $idContratoAditivoPai = null;
    private $dtVigenciaInicial = null;
    private $dtVigenciaFinal = null;
    
    private $motivoPorValor = 1;
    private $motivoPorPrazo = 2;
    private $motivoPorValorePrazo = 3;
    
    private $finalidadeAdicao = 1;
    private $finalidadeSupressao = 2;
    
    private $instrumentoRevisao = 1;
    private $instrumentoReajuste = 2;
    
    private $baseCalculoGlobal = 1;
    private $baseCalculoUnitario = 2;
    
    private $unidadeCalculoPercentual = 1;
    private $unidadeCalculoIndice = 2;
    private $unidadeCalculoMoeda = 3;
    private $unidadeCalculoQuantidade = 4;
    
    private $tipoAquisicaoObras = 1;
    private $tipoAquisicaoReforma = 2;
            
    private $sucesso = null;
    private $msgRetorno = null;    
    
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    public function Sucesso(){
        return $this->sucesso;
    }
    
    public function getIdContrato() {
        return $this->idContrato;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }       
    
    public function getIdMotivo() {
        return $this->idMotivo;
    }

    public function getNumeroNovoAditivo() {
        return $this->numeroNovoAditivo;
    }

    public function getIdBaseCalculo() {
        return $this->idBaseCalculo;
    }

    public function getDtPublicacao() {
        return $this->dtPublicacao;
    }

    public function getIdFinalidade() {
        return $this->idFinalidade;
    }

    public function getIndiceCorrecao() {
        return $this->indiceCorrecao;
    }

    public function getIdInstrumento() {
        return $this->idInstrumento;
    }

    public function getPercentual() {
        return $this->percentual;
    }

    public function getDtPeriodoInicial() {
        return $this->dtPeriodoInicial;
    }

    public function getDtPeriodoFinal() {
        return $this->dtPeriodoFinal;
    }

    public function getIdTipoAquisicao() {
        return $this->idTipoAquisicao;
    }

    public function setIdMotivo($idMotivo) {
        $this->idMotivo = $idMotivo;
    }

    public function setNumeroNovoAditivo($numeroNovoAditivo) {
        $this->numeroNovoAditivo = $numeroNovoAditivo;
    }

    public function setIdBaseCalculo($idBaseCalculo) {
        $this->idBaseCalculo = $idBaseCalculo;
    }

    public function setDtPublicacao($dtPublicacao) {
        $this->dtPublicacao = $dtPublicacao;
    }

    public function setIdFinalidade($idFinalidade) {
        $this->idFinalidade = $idFinalidade;
    }

    public function setIndiceCorrecao($indiceCorrecao) {
        $this->indiceCorrecao = $indiceCorrecao;
    }

    public function setIdInstrumento($idInstrumento) {
        $this->idInstrumento = $idInstrumento;
    }

    public function setPercentual($percentual) {
        $this->percentual = $percentual;
    }

    public function setDtPeriodoInicial($dtPeriodoInicial) {
        $this->dtPeriodoInicial = $dtPeriodoInicial;
    }

    public function setDtPeriodoFinal($dtPeriodoFinal) {
        $this->dtPeriodoFinal = $dtPeriodoFinal;
    }

    public function setIdTipoAquisicao($idTipoAquisicao) {
        $this->idTipoAquisicao = $idTipoAquisicao;
    }

    public function getDtAssinatura() {
        return $this->dtAssinatura;
    }

    public function setDtAssinatura($dtAssinatura) {
        $this->dtAssinatura = $dtAssinatura;
    }        
            
    public function getIdUnidadeCalculo() {
        return $this->idUnidadeCalculo;
    }
    
    public function getDsJustificativa() {
        return $this->dsJustificativa;
    }

    public function setDsJustificativa($dsJustificativa) {
        $this->dsJustificativa = $dsJustificativa;
    }

    
    public function setIdUnidadeCalculo($idUnidadeCalculo) {
        $this->idUnidadeCalculo = $idUnidadeCalculo;
    }
    
    public function getMotivoPorValor() {
        return $this->motivoPorValor;
    }

    public function getMotivoPorPrazo() {
        return $this->motivoPorPrazo;
    }

    public function getMotivoPorValorePrazo() {
        return $this->motivoPorValorePrazo;
    }
    
    public function getFinalidadeAdicao() {
        return $this->finalidadeAdicao;
    }

    public function getFinalidadeSupressao() {
        return $this->finalidadeSupressao;
    }

    public function getInstrumentoRevisao() {
        return $this->instrumentoRevisao;
    }

    public function getInstrumentoReajuste() {
        return $this->instrumentoReajuste;
    }

    public function getBaseCalculoGlobal() {
        return $this->baseCalculoGlobal;
    }

    public function getBaseCalculoUnitario() {
        return $this->baseCalculoUnitario;
    }

    public function getUnidadeCalculoPercentual() {
        return $this->unidadeCalculoPercentual;
    }

    public function getUnidadeCalculoIndice() {
        return $this->unidadeCalculoIndice;
    }

    public function getUnidadeCalculoMoeda() {
        return $this->unidadeCalculoMoeda;
    }

    public function getUnidadeCalculoQuantidade() {
        return $this->unidadeCalculoQuantidade;
    }

    public function getTipoAquisicaoObras() {
        return $this->tipoAquisicaoObras;
    }

    public function getTipoAquisicaoReforma() {
        return $this->tipoAquisicaoReforma;
    }
    
    public function getIdContratoAditivo() {
        return $this->idContratoAditivo;
    }

    public function setIdContratoAditivo($idContratoAditivo) {
        $this->idContratoAditivo = $idContratoAditivo;
    }
    
    public function getGestorTitular() {
        return $this->gestorTitular;
    }

    public function getGestorSubstituto() {
        return $this->gestorSubstituto;
    }

    public function getFiscal() {
        return $this->fiscal;
    }

    public function getFiscalSubstituto() {
        return $this->fiscalSubstituto;
    }

    public function getSubFiscal() {
        return $this->subFiscal;
    }

    public function getSubFiscalSubstituto() {
        return $this->subFiscalSubstituto;
    }

    public function setGestorTitular($gestorTitular) {
        $this->gestorTitular = $gestorTitular;
    }

    public function setGestorSubstituto($gestorSubstituto) {
        $this->gestorSubstituto = $gestorSubstituto;
    }

    public function setFiscal($fiscal) {
        $this->fiscal = $fiscal;
    }

    public function setFiscalSubstituto($fiscalSubstituto) {
        $this->fiscalSubstituto = $fiscalSubstituto;
    }

    public function setSubFiscal($subFiscal) {
        $this->subFiscal = $subFiscal;
    }

    public function setSubFiscalSubstituto($subFiscalSubstituto) {
        $this->subFiscalSubstituto = $subFiscalSubstituto;
    }
    
    public function getItens() {
        return $this->itens;
    }

    public function setItens($itens) {
        $this->itens = $itens;
    }
    
    public function getIdFornecedor() {
        return $this->idFornecedor;
    }

    public function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
        return $this;
    }
    
    public function getIdContratoAditivoPai() {
        return $this->idContratoAditivoPai;
    }

    public function setIdContratoAditivoPai($idContratoAditivoPai) {
        $this->idContratoAditivoPai = $idContratoAditivoPai;
        return $this;
    }
    
    public function getDtVigenciaInicial() {
        return $this->dtVigenciaInicial;
    }

    public function getDtVigenciaFinal() {
        return $this->dtVigenciaFinal;
    }

    public function setDtVigenciaInicial($dtVigenciaInicial) {
        $this->dtVigenciaInicial = $dtVigenciaInicial;
        return $this;
    }

    public function setDtVigenciaFinal($dtVigenciaFinal) {
        $this->dtVigenciaFinal = $dtVigenciaFinal;
        return $this;
    }
                
    public function textoAditivoPor($texto){
        return "Aditivo Por ".$texto;
    }

                
    
    public function salvar($dados){

        try{

            if(!is_array($dados)){
                return Metodos::retornoAjax("Erro", "console", "Não foi possível validar esses dados como array.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $this->idContrato = (int) $dados['dados']['contrato'];
            $this->numeroNovoAditivo = (int)$dados['dados']['numero_novo_aditivo'];
            $this->idBaseCalculo = (int)$dados['dados']['base_calculo'];
            $this->idFinalidade = (int)$dados['dados']['finalidade'];
            $this->idUnidadeCalculo = (int)$dados['dados']['unidade_calculo'];
            $this->indiceCorrecao = trim($dados['dados']['indice_correcao']);
            $this->idInstrumento = (int)$dados['dados']['instrumento'];
            $this->idMotivo = (int)$dados['dados']['motivo'];
            $this->percentual = trim($dados['dados']['percentual']);
            $this->idTipoAquisicao = (int)$dados['dados']['tipo_aquisicao']; 
            $this->dsJustificativa = trim($dados['dados']['justificativa']);
            $this->dtPeriodoInicial = $dados['dados']['periodo_inicial'];            
            $this->dtPeriodoInicial = Metodos::validaConverteDataING($this->dtPeriodoInicial);
            if(empty($this->dtPeriodoInicial)){
                $this->dtPeriodoInicial = NULL;
            }            
            $this->dtPeriodoFinal = $dados['dados']['periodo_final'];            
            $this->dtPeriodoFinal = Metodos::validaConverteDataING($this->dtPeriodoFinal);
            if(empty($this->dtPeriodoFinal)){
                $this->dtPeriodoFinal = NULL;
            }            
            $this->dtPublicacao = $dados['dados']['data_publicacao'];
            $this->dtPublicacao = Metodos::validaConverteDataING($this->dtPublicacao);
            if(empty($this->dtPublicacao)){
                $this->dtPublicacao = NULL;
            }  
            $this->dtAssinatura = $dados['dados']['data_assinatura'];
            $this->dtAssinatura = Metodos::validaConverteDataING($this->dtAssinatura);
            if(empty($this->dtAssinatura)){
                $this->dtAssinatura = NULL;
            }                          
            
            $this->gestorTitular = $dados['gestor_titular'];
            if(!is_array($this->gestorTitular) || empty($this->gestorTitular)){
                $this->gestorTitular = NULL;
            }
            $this->gestorTitular = array_unique($this->gestorTitular);
            
            $this->gestorSubstituto = $dados['gestor_substituto'];
            if(!is_array($this->gestorSubstituto) || empty($this->gestorSubstituto)){
                $this->gestorSubstituto = NULL;
            }
            $this->gestorSubstituto = array_unique($this->gestorSubstituto);
            
            $this->fiscal = $dados['fiscal'];
            if(!is_array($this->fiscal) || empty($this->fiscal)){
                $this->fiscal = NULL;
            }
            $this->fiscal = array_unique($this->fiscal);
            
            $this->fiscalSubstituto = $dados['fiscal_substituto'];
            if(!is_array($this->fiscalSubstituto) || empty($this->fiscalSubstituto)){
                $this->fiscalSubstituto = NULL;
            }
            $this->fiscalSubstituto = array_unique($this->fiscalSubstituto);
            
            $this->subFiscal = $dados['sub_fiscal'];
            if(!is_array($this->subFiscal) || empty($this->subFiscal)){
                $this->subFiscal = NULL;
            }
            $this->subFiscal = array_unique($this->subFiscal);
            
            $this->subFiscalSubstituto = $dados['sub_fiscal_substituto'];
            if(!is_array($this->subFiscalSubstituto) || empty($this->subFiscalSubstituto)){
                $this->subFiscalSubstituto = NULL;
            }
            $this->subFiscalSubstituto = array_unique($this->subFiscalSubstituto);
            
            if(array_key_exists("itens", $dados)){
                $this->itens = $dados['itens'];
            }
                                                                                    
            //Faz a Validação dos Campos Obrigatorios de acordo com o Motivo, Valor, Prazo ou Valor e Prazo
            if(!$this->validaCamposObrigatorio()){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);                                                
            }
            //Faz a Validação das Regras de Preenchimento do Formulário de acordo com o Motivo, Valor, Prazo ou Valor e Prazo
            $this->validaRegrasDePreenchimento();
            if(!$this->sucesso){
                return Metodos::retornoAjax("Erro", "alert", $this->getMsgRetorno());       
            }
            
            $contrato = new FinContratoModel();
            $contrato->setIdContrato($this->idContrato);            
            
            //Verifica a Quantidade de Aditivos
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoAditivo->setIdContrato($contrato->getIdContrato());
            $daoContratoAditivo->retornaNumeroUltimoAditivo($pdo);                                  
            if(!$daoContratoAditivo->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", "Não foi possível saber a quantidade de Aditivo.");
            }
            //Adiciona em 1 a quantidade do Aditivo, que será o próximo aditivo            
            $proximoAditivo = (int)$daoContratoAditivo->getMsgRetorno()['numero_ultimo_aditivo'] + 1;
            $idContratoUltimo = (int)$daoContratoAditivo->getMsgRetorno()['id_contrato_ultimo'];
            $numeroContrato = $daoContratoAditivo->getMsgRetorno()['nr_contrato'];
            
            //Valida se o novo aditivo informado realmente é o mesmo que será gerado.
            if($proximoAditivo != $this->numeroNovoAditivo){
                return Metodos::retornoAjax("Erro", "alert", "O Número do Aditivo informado parece que já está cadastrado, por favor verifique se o Aditivo já está cadastrado.");
            }
            
            //Faz a busca do próximo campo sequencial do Contrato
            $daoContratoAditivo->retornaProximoSequencialAditivo($pdo);
            if(!$daoContratoAditivo->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", $daoContratoAditivo->getMsgRetorno());
            }
            $proximoSequencial = $daoContratoAditivo->getMsgRetorno();
            
            
            //Carregar Todos os Dados do Contrato, Cont Itens, Fornecedor
            //Se for o primeiro contrato, então será do contrato.
            //Se já tiver algum Aditivo cadastrado, então será pego o ultimo Aditivo para pegar os Dados dele
            $this->idContratoAditivoPai = $this->idContrato;
            if((int)$proximoAditivo > 1){
                $this->idContrato = $idContratoUltimo;
            }
            
            $contratoRef = new FinContratoModel();
            $contratoRef->setIdContrato($this->idContrato);
            $contratoRef->retornaDadosContratoCompleto($pdo);
            if(!$contratoRef->sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar os Dados do Último Contrato/Aditivo.");
            }                
            $contRef = $contratoRef->getMsgRetorno();
            
            //Carrega todos os itens do Contrato(Fornecedor)
            $finContItens = "";
            $itemModel = new ItemModel();
            $itemModel->setIdFornecedor($contRef->getFornecedor()->getIdFornecedor());
            $itemModel->retornaItensPorFornecedor($pdo);
            if($itemModel->Sucesso()){
                $finContItens = $itemModel->getMsgRetorno();
            }
            
            echo "<pre>";
            print_r($this->itens);
            echo "</pre>";
            
            echo "<pre>";
            print_r($finContItens);
            echo "</pre>";
            
            exit();
            
                                                                                                                     
            //Preparar Dados Para Inserir no Banco            
            //Do Fin contrato, Fin Fornecedor, Fin Cont Central, Fin Cont Itens e Todos os 
            //gestores, fiscais e subfiscais            
                                    
            //Adiciona os Dados na classe que representa a tabela Fin Contrato
            $finContratoTb = new FinContratoTb();
            //Nome do Numero do contrato
            $nomeDoContrato = $proximoAditivo."º Termo Aditivo ao contrato ".$numeroContrato;                           
            $finContratoTb->setNrContrato($nomeDoContrato);
            //Dados que serão duplicados
            $finContratoTb->setNrPrazoEntrega($contRef->getNrPrazoEntrega());
            $finContratoTb->setIdProcesso($contRef->getIdProcesso());
            $finContratoTb->setIdPessoa($contRef->getIdPessoa());
            $finContratoTb->setDsObjeto($contRef->getDsObjeto());            
            $finContratoTb->setFlServicoContinuado($contRef->getFlServicoContinuado());
            $finContratoTb->setDsObsContrato($contRef->getDsObsContrato());
            $finContratoTb->setIdModalidade($contRef->getIdModalidade());
            $finContratoTb->setDsAreaAbrangencia($contRef->getDsAreaAbrangencia());
            $finContratoTb->setDsUnidadeContemplada($contRef->getDsUnidadeContemplada());
            $finContratoTb->setIdOrgaoGerenciador($contRef->getIdOrgaoGerenciador());
            $finContratoTb->setIdTipoGasto($contRef->getIdTipoGasto());
            $finContratoTb->setVlContrato($contRef->getVlContrato());
            $finContratoTb->setTpContrato($contRef->getTpContrato());
            
            //Se o Aditivo for Por Prazo ou Valor e Prazo
            //Então a Vigência do Contrato será diferente do Ultimo Aditivo ou Contrato
            $finContratoTb->setDtIniVigenciaContrato($contRef->getDtIniVigenciaContrato());
            $finContratoTb->setDtFimVigenciaContrato($contRef->getDtFimVigenciaContrato());
            
            
            $finContratoTb->setDtAssinatura($this->dtAssinatura);
            $finContratoTb->setDtPublicacao($this->dtPublicacao);        
            $finContratoTb->setSqContrato($proximoSequencial);
            $finContratoTb->setIdContratoAditivoPai($this->idContratoAditivoPai);                 
            
            
            //Adiciona os Dados na classe que representa a tabela Fin Fornecedor
            $finFornecedorTb = new FinFornecedoresTb();      
            $finFornecedorTb->setIdPessoa($contRef->getFornecedor()->getIdPessoa());
            
            
            //Busca os Dados do Fin Cont Central
            //Centrais do Contrato
            $finCentraisModel = new FinCentraisModel();
            $finCentraisModel->setIdContrato($this->idContrato);
            $finCentraisModel->retornaCentraisPorContrato($pdo);
            $centraisDoContrato = array();
            if($finCentraisModel->sucesso()){
                $centraisDoContrato = $finCentraisModel->getMsgRetorno();
            }
            
            
            //Busca os Dados do Fin Cont Itens
            //Somente os itens que serão duplicados
            $itens = "";
            foreach ($finContItens as $key => $value){
                $finItens = new FinItensTb();
                $finItens->setNrItem($value['nr_item']);
                $finItens->setNrLote($value['nr_lote']);
                $finItens->setNmMarca($value['nm_marca']);
                $finItens->setNmModelo($value['nm_modelo']);
                $finItens->setQtItens($value['qt_itens']);
                $finItens->setVlItens($value['vl_itens']);
                $finItens->setPcDesconto($value['pc_desconto']);
                $finItens->setFlValorVariavel($value['fl_valor_variavel']);
                $finItens->setDescItem($value['ds_itens']);
                $finItens->setIdMaterial($value['id_material']);
                $finItens->setIdContItens(NULL);
                $finItens->setIdUnidadeMedida($value['id_unidade_medida']);
                $itens[] = $finItens;
            }                        
                      
            
            $finContratoAdtivoTb = new FinContratoAditivoTb();
            $finContratoAdtivoTb->setIdContratoMotivo($this->idMotivo)
                    ->setIdContratoFinalidade($this->idFinalidade)
                    ->setIdContratoInstrumento($this->idInstrumento)
                    ->setIdContratoBaseCalculo($this->idBaseCalculo)
                    ->setIdContratoUnidadeCalculo($this->idUnidadeCalculo)
                    ->setIdContratoAquisicao($this->idTipoAquisicao)
                    ->setDsJustificativa($this->dsJustificativa)
                    ->setNrAditivo($this->numeroNovoAditivo)
                    ->setDtInicial($this->dtPeriodoInicial)
                    ->setDtFinal($this->dtPeriodoInicial)
                    ->setNrPercentualIndice($this->percentual);                                                   
                      
            $contrato->cadastrarContratoComAditivo($finContratoTb, $finFornecedorTb
                    , $finContratoAdtivoTb, $centraisDoContrato
                    , $this->gestorTitular, $this->gestorSubstituto
                    , $this->fiscal, $this->fiscalSubstituto
                    , $this->subFiscal, $this->subFiscalSubstituto
                    , $itens
                    , $pdo);
            if(!$contrato->sucesso()){ 
                return Metodos::retornoAjax("Erro", "console", $contrato->getMsgRetorno());
            }
            
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);                                    
            
            //$pdo->rollBack();
            echo "<pre>";
            print_r($contrato->getMsgRetorno());
            echo "</pre>";
            
            echo "<pre>";
            print_r($finContratoTb);
            echo "</pre>";
            return;
           
            //Adicionar os Itens nesse Objeto da Tabela, fazer isso com todas as outras tabelas
            //E somente posterior iniciar o objeto do contrato model e mandar via parametro os objetos para serem salvos
            
            
            $daoContrato->setNrContrato($nomeDoContrato);
            $daoContrato->setNrPrazoEntrega($contRef->getNrPrazoEntrega());
            $daoContrato->setIdProcesso($contRef->getIdProcesso());
            $daoContrato->setIdPessoa($contRef->getIdPessoa());
            $daoContrato->setDsObjeto($contRef->getDsObjeto());            
            $daoContrato->setFlServicoContinuado($contRef->getFlServicoContinuado());
            $daoContrato->setDtIniVigenciaContrato($contRef->getDtIniVigenciaContrato());
            $daoContrato->setDtFimVigenciaContrato($contRef->getDtFimVigenciaContrato());
            $daoContrato->setDtAssinatura($contRef->getDtAssinatura());
            $daoContrato->setDtPublicacao($contRef->getDtPublicacao());
            $daoContrato->setDsObsContrato($contRef->getDsObsContrato());
            $daoContrato->setIdModalidade($contRef->getIdModalidade());
            $daoContrato->setDsAreaAbrangencia($contRef->getDsAreaAbrangencia());
            $daoContrato->setDsUnidadeContemplada($contRef->getDsUnidadeContemplada());
            $daoContrato->setIdOrgaoGerenciador($contRef->getIdOrgaoGerenciador());
            $daoContrato->setIdTipoGasto($contRef->getIdTipoGasto());
            $daoContrato->setVlContrato($contRef->getVlContrato());
            $daoContrato->setTpContrato($contRef->getTpContrato());
            $daoContrato->setSqContrato($contrato->getSqContrato());
            $daoContrato->setIdContratoAditivoPai($this->idContrato);
            $contRef = new FinContratoModel();
            
            $a = new FinFornecedoresModel();
            $a->getIdPessoa();
            
            $daoContrato->setIdPessoaFornecedor($contRef->getFornecedor()->getIdPessoa());
            
            
            echo "<pre>";
            print_r($daoContrato);
            echo "</pre>";
            
                    
            //$daoContrato->cadastrarContratoComAditivo();
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoFornecedor = new DaoFinFornecedores();
            $daoContratoContItens = new DaoFinItens();
            
            
            





        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }                          
    }
    
    
    public function remover(){
        
        try{
                                                
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();           
            
            $this->retornaDadosParaRemover($pdo);
            if(!$this->sucesso){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $this->msgRetorno);
            }
            //$this->idFornecedor;
            //$this->idContratoAditivo;
            
            //Verifica se o Aditivo é o ultimo cadastrado            
            $finContratoModel = new FinContratoModel();
            $finContratoModel->setIdContrato($this->idContrato);            
            $finContratoModel->carregaDados($pdo);
            
            if(!$finContratoModel->sucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $finContratoModel->getMsgRetorno());
            }
            
            //Pega o Contrato Pai e verifico qual é o ultimo Aditivo para verifica se esse que está tentando
            //ser removido seja o último, para não quebrar as regras dos calculos do próximo aditivo
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoAditivo->setIdContrato($finContratoModel->getIdContratoAditivoPai());
            $daoContratoAditivo->retornaNumeroUltimoAditivo($pdo);
            if(!$daoContratoAditivo->Sucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $daoContratoAditivo->getMsgRetorno());
            }            
            $ultimoAditivo = $daoContratoAditivo->getMsgRetorno()['numero_ultimo_aditivo'];
                                               
            if($ultimoAditivo != $this->numeroNovoAditivo){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não é possível remover esse "
                        . "Aditivo, pois ele não é o último aditivo cadastrado. Para excluir esse Aditivo, é necessário"
                        . " que se exclua os Aditivos posterior a esse.");
            }
       
           
            $finContratoModel->removeContratoAditivo((int)$this->idContrato
                    , (int)$this->idFornecedor
                    , (int)$this->idContratoAditivo                    
                    , $pdo);
            if(!$finContratoModel->sucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            }
            
            $pdo->commit();            
            return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            
        } catch (Exception $ex) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
        
    }
    
    public function retornaDadosParaRemover(PDO $pdo){
        
        try{
            
            if(empty($this->idContrato)){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar o Contrato";
                return;
            }
            
            $dao = new DaoFinContratoAditivo();
            $dao->setIdContrato($this->idContrato);
            $dao->retornaIdsDoContratoPraRemover($pdo);
            if($dao->Sucesso()){    
                $this->idFornecedor = $dao->getMsgRetorno()['id_fornecedor'];
                $this->idContratoAditivo = $dao->getMsgRetorno()['id_contrato_aditivo'];
                $this->numeroNovoAditivo = $dao->getMsgRetorno()['nr_aditivo'];
                $this->sucesso = true;
                return;
            }
                                               
            $this->sucesso = false;
            $this->msgRetorno = "Não foi possível Localizar os Daods do Contrato Para Remover";
            
            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();

        }                
    }
    
    
    /**
     * Retorna Os Aditivos em formato de Tabela de um Contrato
     * @return string
     */
    public function retornaAditivosDoContrato() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoAditivo();
            $daoContrato->setIdContrato($this->idContrato);
            
            //Precisa Verifica se o Contrato possui algum aditivo vinculado a ele e listar.
            //Esperando definição do Banco de Dados Ainda
            $daoContrato->buscaTodosAditivosPorcontrato($pdo);

            if(!$daoContrato->Sucesso()){
                $retorno = '<div class="alert alert-warning aditivo_quantidade" quantidade=0>'
                        . '<strong>Alerta!</strong> Este Contrato Não Possui Aditivo.'
                    . '</div>';
                return $retorno;
            }
                        
            if(empty($daoContrato->getMsgRetorno())){
                $retorno = '<div class="alert alert-warning aditivo_quantidade" quantidade=0>'
                        . '<strong>Alerta!</strong> Este Contrato Não Possui Aditivo.'
                    . '</div>';
                return $retorno;
            }
            
            $tbody = "";
            foreach ($daoContrato->getMsgRetorno() as $key => $value) {
                $tbody .= "<tr>";
                    $tbody .= "<td>".$value['nr_contrato']."</td>";
                    $tbody .= "<td>". $this->textoAditivoPor($value['nm_contrato_motivo'])."</td>";
                    $tbody .= "<td style='text-align: center;'>".$value['dt_ini_vigencia_contrato']." - ".$value['dt_fim_vigencia_contrato']."</td>";
                    $tbody .= "<td style='text-align: center;'>".$value['dt_publicacao']."</td>";
                    $tbody .= "<td style='text-align: center;'>R$ ".$value['valor']."</td>";
                    $tbody .= '<td style="text-align: center;">'                                                       
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$value['nr_contrato'].'" '                               
                                . ' value=' . $value['id_contrato'] . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $value['id_contrato'] . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>';                                
                $tbody .= "</tr>";
            }
            
            
            
            $daoContrato->retornaNumeroUltimoAditivo($pdo);
            if(!$daoContrato->Sucesso()){
                $retorno = '<div class="alert alert-warning">'
                        . '<strong>Alerta!</strong> '.STR_ERROR.' '
                    . '</div>';
                return $retorno;
            }
            $quantidade = $daoContrato->getMsgRetorno()['numero_ultimo_aditivo'];
            
            $retorno = '<table class="table table-striped table-bordered table-condensed aditivo_quantidade" quantidade='.$quantidade.'>
                    <thead>
                        <tr>
                            <th>Número do Aditivo</th>
                            <th>Motivo do Aditamento</th>
                            <th style="text-align: center;">Vigência</th>
                            <th style="text-align: center;">Publicação</th>
                            <th style="text-align: center;">Valor do Aditivo</th>
                            <th style="text-align: center;">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                    '.$tbody.'
                    </tbody>
                </table>';  
            return $retorno;                                  
            
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    
    /**
     * Valida se os Campos Obrigatórios estão correto de acordo com o tipo de requisição     
     */
    private function validaCamposObrigatorio() : Bool{
        
        if(empty($this->idMotivo)){
            return false;
        }
        
        //Se o Motivo é por Valor, então essa será a validação
        if($this->idMotivo == $this->getMotivoPorValor()){         
            if(empty($this->numeroNovoAditivo) || empty($this->idFinalidade)
                || empty($this->idInstrumento) || empty($this->idBaseCalculo)                                    
                || empty($this->idUnidadeCalculo) || empty($this->dtPublicacao) 
                || empty($this->dtAssinatura)){
                return false;
            }                        
        }
                        
        return true;
    }
    
    /**
     * Valida se os Campos enviado estão de acordo com as regras da tela
     * Ex: Se quando For Valor Global em Bas ede Cálculo, somente poderá ser Percentual em Unidade de Cálculo          
     */
    private function validaRegrasDePreenchimento(){ 
        
        if(empty($this->idMotivo)){
            $this->sucesso = false;
            $this->msgRetorno = "Motivo Não Encontrado";
            return;
        }
        
        //Se o Motivo é por Valor, então essa será a validação
        if($this->idMotivo == $this->getMotivoPorValor()){      
                        
            //Se o Instrumento de equilibrio for Revisão, então é obrigatorio que seja informado
            //um tipo de aquisição
            if($this->idInstrumento == $this->getInstrumentoRevisao() 
                    && empty($this->idTipoAquisicao)){
                $this->sucesso = false;
                $this->msgRetorno = "Se a Base de Cálculo for Global, a Unidade de Cálculo deverá ser Percentual ou Ínidice de Correção.";
                return;
            }
            
            //Se o instrumento de equilibrio for Revisão, então é obrigatório a Unidade de Cálculo ser
            //Percentual, Moeda ou Quantidade
            if( $this->idInstrumento == $this->getInstrumentoRevisao()
                && !(
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual())
                        xor
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda())
                        xor
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade())                        
                    )                    
            ){
                $this->sucesso = false;
                $this->msgRetorno = "Se o Instrumento de Equilíbrio for Revisão, a Unidade de Cálculo deverá ser Percentual, Moeda ou Quantidade.";
                return; 
            //Se o instrumento de  equilibrio for Reajuste, então é obrigatório a Unidade de Cálculo ser
            //Indice de Correção ou Moeda
            }else if($this->idInstrumento == $this->getInstrumentoReajuste() 
                && !(
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoIndice())
                        xor
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda())                                        
                    )                    
            ){
                $this->sucesso = false;
                $this->msgRetorno = "Se o Instrumento de Equilíbrio for Reajuste, a Unidade de Cálculo deverá ser Ínidice de Correção ou Moeda.";
                return;
            }                                                
            
            
            //Se a Base de Calculo for Global, somente poderá ser Percentual ou Indice de Correção na Unidade de Cálculo
            if( $this->idBaseCalculo == $this->getBaseCalculoGlobal() 
                &&  !(
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual()) 
                        xor 
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoIndice())
                    )
            ){
                $this->sucesso = false;
                $this->msgRetorno = "Se a Base de Cálculo for Valor Global, a Unidade de Cálculo deverá ser Percentual ou Ínidice de Correção.";
                return;                
            //Se a Base de Calculo for Unitário, somente poderá ser Moeda ou Quantidade na Unidade de Cálculo
            }else if($this->idBaseCalculo == $this->getBaseCalculoUnitario()
                && !(
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda()) 
                        xor 
                        ($this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade())                                                            
                    )                    
            ){
                $this->sucesso = false;
                $this->msgRetorno = "Se a Base de Cálculo for Valor Unitário, a Unidade de Cálculo deverá ser Moeda ou Quantidade.";
                return;  
            }  
            
            //Motivo Por Valor, é necessário o preenchimento de algum item
            if(empty($this->itens)){
                $this->sucesso = false;
                $this->msgRetorno = "No Aditivo Por Valor, é necessário o Preenchimento dos Valores Por Cada Item que será aditivado.";
                return; 
            }
            
        }                                        
        $this->sucesso = true;
        $this->msgRetorno = "ok";
    }
    
    public function inserirAditivo(FinContratoAditivoTb $finContratoAditivo, PDO $pdo){
                      
        try{
         
            $dao = new DaoFinContratoAditivo();
            $dao->setIdContrato($finContratoAditivo->getIdContrato());
            $dao->setIdContratoMotivo($finContratoAditivo->getIdContratoMotivo());
            $dao->setIdContratoFinalidade($finContratoAditivo->getIdContratoFinalidade());
            $dao->setIdContratoInstrumento($finContratoAditivo->getIdContratoInstrumento());
            $dao->setIdContratoBaseCalculo($finContratoAditivo->getIdContratoBaseCalculo());
            $dao->setIdContratoUnidadeCalculo($finContratoAditivo->getIdContratoUnidadeCalculo());
            $dao->setIdContratoAquisicao($finContratoAditivo->getIdContratoAquisicao());
            $dao->setDsJustificativa($finContratoAditivo->getDsJustificativa());
            $dao->setNrAditivo($finContratoAditivo->getNrAditivo());
            $dao->setDtInicial($finContratoAditivo->getDtInicial());
            $dao->setDtFinal($finContratoAditivo->getDtFinal());
            $dao->setNrPercentualIndice($finContratoAditivo->getNrPercentualIndice());
            $dao->insert($pdo);
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
            }
            $dao->setIdContratoAditivo($pdo->lastInsertId('fin_contrato_aditivo_id_contrato_aditivo_seq'));
            if (!Log::SalvaLogI('fin_contrato_aditivo', $dao->getIdContratoAditivo(), $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Erro no Log dos Aditivos";
                return;
            }
            
            $this->sucesso = true;        
            $this->msgRetorno = "Dados do Aditivo salvo com Sucesso";
            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            
        }                        
    }
    
    public function removerAditivoPorContratoAditivo(PDO $pdo = null){
        try {
                                    
            if(empty($this->idContratoAditivo)){
                $this->sucesso = false;
                $this->msgRetorno = "É Necessário o Contrato Aditivo";
                return;
            }
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            
            //Seta os Campos
            $dao = new DaoFinContratoAditivo();            
            $dao->setIdContratoAditivo($this->idContratoAditivo);                   
            $dao->retorna($pdo);
            if($dao->Sucesso()){
                if (!Log::SalvaLogD('fin_contrato_aditivo', $dao->getIdContratoAditivo(), $pdo)){
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro no Log do Contrato Aditivo";
                    return;
                }
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar o Contrato Aditivo.";
                return;   
            }
                                    
            $dao->delete($pdo);
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
            }
            
            $this->sucesso = true;
            $this->msgRetorno = "ok";
                            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    public function retornaNumeroUltimoAditivo(PDO $pdo = null){
        try{
            
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            
            if(empty($this->idContrato)){
                $this->sucesso = false;
                $this->msgRetorno = "Id Contrato não encontrado";
                return;
            }
            
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoAditivo->setIdContrato($this->idContrato);
            $daoContratoAditivo->retornaNumeroUltimoAditivo($pdo);
            if(!$daoContratoAditivo->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $daoContratoAditivo->getMsgRetorno();
                return;                
            }
            $this->sucesso = true;
            $this->msgRetorno = $daoContratoAditivo->getMsgRetorno();                                                            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            
        }
    }
    
    
    
}

