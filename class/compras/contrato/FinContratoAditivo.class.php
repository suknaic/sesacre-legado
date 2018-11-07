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
    private $flServicoContinuado = null;
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
    
    function getFlServicoContinuado() {
        return $this->flServicoContinuado;
    }

    function setFlServicoContinuado($flServicoContinuado) {
        $this->flServicoContinuado = $flServicoContinuado;
        return $this;
    }
                    
    public function textoAditivoPor($texto){
        return "Aditivo Por ".$texto;
    }
    
    public function porcentagemLimitePorAquisicao(){
        if($this->idTipoAquisicao == $this->getTipoAquisicaoObras()){
            return 25;
        }elseif($this->idTipoAquisicao == $this->getTipoAquisicaoReforma()){
            return 50;
        }else{
            return 0;
        }
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
            if(empty($this->idBaseCalculo)){
                $this->idBaseCalculo = NULL;
            }            
            $this->idFinalidade = (int)$dados['dados']['finalidade'];
            if(empty($this->idFinalidade)){
                $this->idFinalidade = NULL;
            }
            $this->idUnidadeCalculo = (int)$dados['dados']['unidade_calculo'];
            if(empty($this->idUnidadeCalculo)){
                $this->idUnidadeCalculo = NULL;
            }
            $this->indiceCorrecao = Metodos::ConverteValorIng(trim($dados['dados']['indice_correcao']));
            $this->idInstrumento = (int)$dados['dados']['instrumento'];
            if(empty($this->idInstrumento)){
                $this->idInstrumento = NULL;
            }
            $this->idMotivo = (int)$dados['dados']['motivo'];
            if(empty($this->idMotivo)){
                $this->idMotivo = NULL;
            }
            $this->percentual = Metodos::ConverteValorIng(trim($dados['dados']['percentual']));
            $this->idTipoAquisicao = (int)$dados['dados']['tipo_aquisicao']; 
            if(empty($this->idTipoAquisicao)){
                $this->idTipoAquisicao = NULL;
            }
            $this->dsJustificativa = trim($dados['dados']['justificativa']);
            $this->dtPeriodoInicial = $dados['dados']['periodo_inicial'];            
            $this->dtPeriodoInicial = Metodos::validaConverteDataING($this->dtPeriodoInicial);
            if(empty($this->dtPeriodoInicial)){
                $this->dtPeriodoInicial = NULL;
            }else{
                $this->dtPeriodoInicial = new DateTime($this->dtPeriodoInicial);
            }
            $this->dtPeriodoFinal = $dados['dados']['periodo_final'];            
            $this->dtPeriodoFinal = Metodos::validaConverteDataING($this->dtPeriodoFinal);
            if(empty($this->dtPeriodoFinal)){
                $this->dtPeriodoFinal = NULL;
            }else{
                $this->dtPeriodoFinal = new DateTime($this->dtPeriodoFinal);
            }
            $this->dtPublicacao = $dados['dados']['data_publicacao'];
            $this->dtPublicacao = Metodos::validaConverteDataING($this->dtPublicacao);
            if(empty($this->dtPublicacao)){
                $this->dtPublicacao = NULL;
            }else{
                $this->dtPublicacao = new DateTime($this->dtPublicacao);
            }
            $this->dtAssinatura = $dados['dados']['data_assinatura'];
            $this->dtAssinatura = Metodos::validaConverteDataING($this->dtAssinatura);
            if(empty($this->dtAssinatura)){
                $this->dtAssinatura = NULL;
            }else{
                $this->dtAssinatura = new DateTime($this->dtAssinatura);
            }                                                                   
            
            $this->dtVigenciaInicial = $dados['dados']['data_vigencia_inicial'];
            $this->dtVigenciaInicial = Metodos::validaConverteDataING($this->dtVigenciaInicial);
            if(empty($this->dtVigenciaInicial)){
                $this->dtVigenciaInicial = NULL;
            }else{
                $this->dtVigenciaInicial = new DateTime($this->dtVigenciaInicial);
            }
            
            $this->dtVigenciaFinal = $dados['dados']['data_vigencia_final'];
            $this->dtVigenciaFinal = Metodos::validaConverteDataING($this->dtVigenciaFinal);
            if(empty($this->dtVigenciaFinal)){
                $this->dtVigenciaFinal = NULL;
            }else{
                $this->dtVigenciaFinal = new DateTime($this->dtVigenciaFinal);
            }
            
            if(array_key_exists('gestor_titular', $dados)){
                $this->gestorTitular = $dados['gestor_titular'];
                if(!is_array($this->gestorTitular) || empty($this->gestorTitular)){
                    $this->gestorTitular = NULL;
                }
                $this->gestorTitular = array_unique($this->gestorTitular);     
            }else{
                $this->gestorTitular = NULL;
            }
            if(array_key_exists('gestor_substituto', $dados)){
                $this->gestorSubstituto = $dados['gestor_substituto'];
                if(!is_array($this->gestorSubstituto) || empty($this->gestorSubstituto)){
                    $this->gestorSubstituto = NULL;
                }
                $this->gestorSubstituto = array_unique($this->gestorSubstituto);
            }else{
                $this->gestorSubstituto = NULL;
            }
            if(array_key_exists('fiscal', $dados)){
                $this->fiscal = $dados['fiscal'];
                if(!is_array($this->fiscal) || empty($this->fiscal)){
                    $this->fiscal = NULL;
                }
                $this->fiscal = array_unique($this->fiscal);
            }else{
                $this->fiscal = NULL;
            }
            if(array_key_exists('fiscal_substituto', $dados)){
                $this->fiscalSubstituto = $dados['fiscal_substituto'];
                if(!is_array($this->fiscalSubstituto) || empty($this->fiscalSubstituto)){
                    $this->fiscalSubstituto = NULL;
                }
                $this->fiscalSubstituto = array_unique($this->fiscalSubstituto);
            }else{
                $this->fiscalSubstituto = NULL;
            }
            if(array_key_exists('sub_fiscal', $dados)){
                $this->subFiscal = $dados['sub_fiscal'];
                if(!is_array($this->subFiscal) || empty($this->subFiscal)){
                    $this->subFiscal = NULL;
                }
                $this->subFiscal = array_unique($this->subFiscal);
            }else{
                $this->subFiscal = NULL;
            }
            if(array_key_exists('sub_fiscal_substituto', $dados)){
                $this->subFiscalSubstituto = $dados['sub_fiscal_substituto'];
                if(!is_array($this->subFiscalSubstituto) || empty($this->subFiscalSubstituto)){
                    $this->subFiscalSubstituto = NULL;
                }
                $this->subFiscalSubstituto = array_unique($this->subFiscalSubstituto);
            }else{
                $this->subFiscalSubstituto = NULL;
            }
            
            //Para Dentro do sistema, mesmo tendo indice de correção e percentual, basta ter somente um campo 
            //Com os dados da %
            if(empty((float)$this->indiceCorrecao)){
                $this->indiceCorrecao = NULL;
            }            
            if(empty((float)$this->percentual)){
                $this->percentual = $this->indiceCorrecao;
            }
                                                                        
            
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
            $contrato->carregaDados($pdo);
            if(!$contrato->sucesso()){
                return Metodos::retornoAjax("Erro", "console", $contrato->getMsgRetorno());       
            }
            
            //Verifica a Quantidade de Aditivos
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoAditivo->setIdContrato($contrato->getIdContrato());
            $daoContratoAditivo->retornaNumeroUltimoAditivo($pdo);                                  
            if(!$daoContratoAditivo->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível saber a quantidade de Aditivo.");
            }
            //Adiciona em 1 a quantidade do Aditivo, que será o próximo aditivo            
            $proximoAditivo = (int)$daoContratoAditivo->getMsgRetorno()['numero_ultimo_aditivo'] + 1;
            $idContratoUltimo = (int)$daoContratoAditivo->getMsgRetorno()['id_contrato_ultimo'];                                    
            
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
            
            
            //Carregar Todos os Dados do Contrato, Cont Itens, Fornecedor.class
            $contratoRef = new FinContratoModel();
            $contratoRef->setIdContrato($this->idContrato);
            $contratoRef->retornaDadosContratoCompleto($pdo);
            if(!$contratoRef->sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar os Dados do Contrato.");
            }
            $contRef = $contratoRef->getMsgRetorno();
            
            $this->idContratoAditivoPai = $this->idContrato;
            if((int)$proximoAditivo > 1 && !empty($idContratoUltimo)){
                $contratoAditivoRef = new FinContratoModel();
                $contratoAditivoRef->setIdContrato($idContratoUltimo);
                $contratoAditivoRef->retornaDadosContratoCompleto($pdo);
                if(!$contratoAditivoRef->sucesso()){
                    return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar os Dados do Último Contrato/Aditivo.");
                }
                $contAditivoRef = $contratoAditivoRef->getMsgRetorno();    
                $contRef->setDtIniVigenciaContrato($contAditivoRef->getDtIniVigenciaContrato());
                $contRef->setDtFimVigenciaContrato($contAditivoRef->getDtFimVigenciaContrato());
                                             
            }
                            
            $this->flServicoContinuado = $contRef->getFlServicoContinuado();
            
            /*
             * Motivo de Prazo e Valor e Prazo não pode ser para 
             * Serviço Não Continuado
             */                       
            if($this->flServicoContinuado != "S" 
                && ($this->idMotivo == $this->motivoPorPrazo
                    || $this->idMotivo == $this->motivoPorValorePrazo
                    )
                ){
                return Metodos::retornoAjax("Erro", "alert", "Contrato de Serviço Não Continuado não pode ser Aditivado Por Valor ou Valor e Prazo.");
            }
            
            
            //Valida se as Data de Assinatura e Publicação do Aditivo são menores que a Data
            //da Vigência Inicial e Final            
            $dtVigIni = new DateTime($contRef->getDtIniVigenciaContrato());           
            if($this->dtPublicacao < $dtVigIni
                    || $this->dtAssinatura < $dtVigIni){
                return Metodos::retornoAjax("Erro", "alert", "Data de Publicação ou Assinatura não pode ser menor que a"
                        . " Data da Vigência Inicial do Contrato/Último Aditivo.");
            }
            
            //Se Motivo for por Prazo ou Prazo e valor
            //Então data da Vigência Final do Contrato ou Ultimo Aditivo não pode ser Menor que a Data 
            //Da Vigência Inicial informada
            if($this->idMotivo == $this->getMotivoPorPrazo() 
                    || $this->idMotivo == $this->getMotivoPorValorePrazo()){
                $dtVigFinal = new DateTime($contRef->getDtFimVigenciaContrato());
                if($this->dtVigenciaInicial < $dtVigFinal){
                    return Metodos::retornoAjax("Erro", "alert", "Data da Vigência Inicial Informada para o novo Aditivo"
                        . " não pode ser Menor que a data Data da Vigência Final do Contrato/Último Aditivo.");
                }
                $contRef->setDtIniVigenciaContrato($this->dtVigenciaInicial->format("Y-m-d"));
                $contRef->setDtFimVigenciaContrato($this->dtVigenciaFinal->format("Y-m-d"));
            }
                        
            $finContItens = $contRef->getItems();
            if(empty($finContItens)
                    || !is_array($finContItens)){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar os Itens do Contrato Registrado.");
            } 
            
            
            $this->retornaTodosItensComExecutado($pdo);
            if(!$this->sucesso){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar todos os Itens do Contrato "
                        . "e Últimos Aditivos.". STR_ERROR);                        
            }

            $todosItens = $this->msgRetorno;
            
            //Valida se no Caso de Instrumento de Equilíbrio do tipo Revisão 
            //o usuário está selecionando o mesmo Tipo de 
            //Aquisição dos Aditivos anteriores, se existir.
            if(($this->idMotivo == $this->getMotivoPorValor()
                    || $this->idMotivo == $this->getMotivoPorValorePrazo())
                    &&
                    $this->idInstrumento == $this->getInstrumentoRevisao()
                    &&
                    !empty($this->idTipoAquisicao)){
                for ($index = count($todosItens)-1; $index >= 0; $index--) {
                    if(!empty($todosItens[$index]['id_contrato_aquisicao'])
                        &&
                        $todosItens[$index]['id_contrato_aquisicao'] != $this->idTipoAquisicao){
                        return Metodos::retornoAjax("Erro", "alert", "Tipo de Aquisição não é o "
                                . "mesmo do Último Aditivo Cadastrado.");  
                    }elseif(!empty($todosItens[$index]['id_contrato_aquisicao'])
                        &&
                        $todosItens[$index]['id_contrato_aquisicao'] == $this->idTipoAquisicao){
                        break;
                    }
                }
            }
            
            
            
            
            /*
             * 
             * 
             * Dados Para Teste
             * 
             * 
             */
            
            //$this->flServicoContinuado = "N";
            
            $valorExecutado = array();
            //contrato
            $valorExecutado[] = array("id_cont_itens", 16861, "qtd_executado", 5000.0000);
            $valorExecutado[] = array("id_cont_itens", 16862, "qtd_executado", 4000.0000);
            
            //1 Aditivo
            $valorExecutado[] = array("id_cont_itens", 20694, "qtd_executado", 25.0000);
            $valorExecutado[] = array("id_cont_itens", 20693, "qtd_executado", 50.0000);
                        
            $valorExecutado[] = array("id_cont_itens", 20732, "qtd_executado", 2000.0000);                                  
            
            //$valorExecutado[] = array("id_cont_itens", 20723, "qtd_executado", 500.0000);
            //$valorExecutado[] = array("id_cont_itens", 20724, "qtd_executado", 100.0000);
            
            foreach ($valorExecutado as $key => $value) {
                $a = array_search($value[1], array_column($todosItens, $value[0]));
                $todosItens[$a][$value[2]] = $value[3];
            }           
            
            
       
            //echo "<pre>";print_r($todosItens);echo "</pre>";return;
            
            /**
             * 
             * 
             * FinalizaExecutado
             */
            
            
            
            
            /*############################PRAZO#############################*/
            //Quando Motivo for por Prazo e o Serviço For Continuado.
            //Iremos Somar todas as Quantidades 
            //então precisa buscar todos os Itens do Contrato e Aditivos para fazer
            //A Somatoria das Quantidades dos Itens
            //No caso do Valor será utilizado o ultimo Valor dos Aditivos/Contrato que não seja 0
            if($this->idMotivo == $this->getMotivoPorPrazo()){
                $arrayIdsContItens = array();
                foreach ($finContItens as $key => $value){
                    $flagValor = false;                    
                    $valorTotalDaQuantidade = 0.0000;
                    $valorTotalDaQuantidadeExecutado = 0.0000;
                    //SERVIÇO CONTINUADO
                    if($this->flServicoContinuado == "S"){
                        foreach ($todosItens as $k => $v){                                                              
                            if( ($v['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v['tipo'] == "aditivo")
                                ||
                                ($v['id_cont_itens'] == $value->getIdContItens()
                                    && $v['tipo'] == "contrato")
                                ){
                                //Seta o Ultimo Valor Unitário Valido
                                if( !$flagValor && $v['vl_itens'] != "0" && $v['vl_itens'] != "0.0"
                                        && $v['vl_itens'] != "0.0000" && $v['vl_itens'] != "0.00"
                                        && $v['vl_itens'] > 0){
                                    $finContItens[$key]->setVlItens($v['vl_itens']);
                                    /*
                                     * Com essa Flag Setada como True, iremos garantir que esse é o último 
                                     * valor Válido
                                     */                                    
                                    $flagValor = true;
                                }
                                
                                //Se a Unidade de Calculo for Indice ou Moeda, então devo ignorar essa quantidade
                                //para a somatoria
                                if($v['id_contrato_unidade_calculo'] == $this->unidadeCalculoIndice
                                        || $v['id_contrato_unidade_calculo'] == $this->unidadeCalculoMoeda){
                                    continue;
                                }
                                
                                //Faz a somatoria das Quantidades dos Itens
                                //Serviço Continuado, deverá somar todos os Itens
//                                if($v['id_contrato_finalidade'] == $this->getFinalidadeSupressao()){
//                                    $valorTotalDaQuantidade -= $v['qt_itens'];
//                                }else{
//                                    $valorTotalDaQuantidade += $v['qt_itens'];   
//                                }
                                $valorTotalDaQuantidade += $v['qt_itens'];  
                                //Se o Retorno for, um Item no qual o Aditivo for Por Prazo
                                //Então não precisa continuar correndo os Itens pois esse Valor já 
                                //está somando os demais aditivos anteriores
                                if($v['id_contrato_motivo'] == $this->motivoPorPrazo
                                        || $v['id_contrato_motivo'] == $this->motivoPorValorePrazo){
                                    break;
                                }
                            }
                        }
                        $finContItens[$key]->setQtItens($valorTotalDaQuantidade);
                        $finContItens[$key]->setQtItensAux($valorTotalDaQuantidade);
                        if($finContItens[$key]->getQtItens() < 0){
                            return Metodos::retornoAjax("Erro", "alert", "Cadastro Do Aditivo Não pode ser finalizado"
                                . " pois o Item ".$finContItens[$key]->getNrItem()." - ".$finContItens[$key]->getDescItem()
                                . " ficará com sua quantidade Negativa");
                        }
                    //SERVIÇO NÃO CONTINUADO
                    }else{
                        foreach ($todosItens as $k => $v){                                                                     
                            if( ($v['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v['tipo'] == "aditivo")
                                ||
                                ($v['id_cont_itens'] == $value->getIdContItens()
                                    && $v['tipo'] == "contrato")
                                ){
                                //Seta o Ultimo Valor Unitário Valido
                                if( !$flagValor && $v['vl_itens'] != "0" && $v['vl_itens'] != "0.0"
                                        && $v['vl_itens'] != "0.0000" && $v['vl_itens'] != "0.00"
                                        && $v['vl_itens'] > 0){                                
                                    $finContItens[$key]->setVlItens($v['vl_itens']);
                                    /*
                                     * Com essa Flag Setada como True, iremos garantir que esse é o último 
                                     * valor Válido
                                     */   
                                    $flagValor = true;
                                }
                                                                
                                $valorTotalDaQuantidadeExecutado += $v['qtd_executado'];
                                                                                                
                                if($v['id_contrato_motivo'] != $this->motivoPorPrazo
                                    && 
                                    !(   $v['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoMoeda()
                                        || $v['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoIndice()
                                        )    
                                    ){
//                                    if($v['id_contrato_finalidade'] == $this->getFinalidadeSupressao()){
//                                        $valorTotalDaQuantidade -= $v['qt_itens'];
//                                    }else{
//                                        $valorTotalDaQuantidade += $v['qt_itens'];
//                                    }
                                    $valorTotalDaQuantidade += $v['qt_itens'];
                                }                                
                            }
                        }
                        $finContItens[$key]->setQtItens(($valorTotalDaQuantidade - $valorTotalDaQuantidadeExecutado));
                        $finContItens[$key]->setQtItensAux(($valorTotalDaQuantidade - $valorTotalDaQuantidadeExecutado));
                        if($finContItens[$key]->getQtItens() < 0){
                            return Metodos::retornoAjax("Erro", "alert", "Cadastro Do Aditivo Não pode ser finalizado"
                                . " pois o Item ".$finContItens[$key]->getNrItem()." - ".$finContItens[$key]->getDescItem()
                                . " ficará com sua quantidade Negativa");
                        }
                    }
                }                                                              
            }
                                 
            
            //Ajusta os Valores dos Itens que serão duplicados no sistema
            /*############################VALOR#############################*/            
            if(!empty($this->itens) && $this->idMotivo == $this->getMotivoPorValor()){
                                             
                foreach ($finContItens as $k => $value){    
                    $key = array_search($value->getIdContItens(), array_column($this->itens, "id"));                   
                    //Se a aplicação não enviou o Id do Item, então esse item terá seu valor zerado
                    if($key === false && $this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade()){
                        $finContItens[$k]->setQtItens(0);
                        $finContItens[$k]->setQtItensAux(0);
                        $finContItens[$k]->setVlItens(0);                     
                        continue;
                    }                    
                                        
                    
                    //Se a unidade de Cálculo for Moeda ou Indice de Correção
                    //Então o Campo preenchido que veio do formulário será para alterar os itens do vl_itens
                    if($this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda()
                            || $this->idUnidadeCalculo == $this->getUnidadeCalculoIndice()){
                        //Se a unidade de calculo for indice de correção, então iremos fazer o calculo do percentual
                        //e verificar se ele está batendo com o valor informado pelo usuário na tela.
                        if($this->idUnidadeCalculo == $this->getUnidadeCalculoIndice()){
                            $valorNovo = round((($finContItens[$k]->getVlItens()/100) * $this->percentual), 4);
                            if($valorNovo != $this->itens[$key]['valor_aditivado']){
                                return Metodos::retornoAjax("Erro", "alert", "Os Valores dos Itens estão diferente do Informado pelo usuário. \n".STR_ERROR);
                            }else{
                                $this->itens[$key]['valor_aditivado'] = $valorNovo;
                            } 
                        }           
                        //Se O Valor Não foi informado, então ele deverá ser o ultimo valor valido
                        if($key === false && $this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda()){
                            foreach ($todosItens as $k1 => $v1){                             
                                if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                        && $v1['tipo'] == "aditivo")
                                    ||
                                    ($v1['id_cont_itens'] == $value->getIdContItens()
                                        && $v1['tipo'] == "contrato")
                                    ){
                                        //Seta o Ultimo Valor Unitário Valido
                                        if( $v1['vl_itens'] != "0" && $v1['vl_itens'] != "0.0"
                                            && $v1['vl_itens'] != "0.0000" && $v1['vl_itens'] != "0.00"
                                            && $v1['vl_itens'] > 0){                                        
                                            $finContItens[$k]->setVlItens($v1['vl_itens']);
                                            break;
                                        }
                                    }
                            }                                                                                  
                        }else{                                                           
                            $finContItens[$k]->setVlItens($this->itens[$key]['valor_aditivado']);   
                        }
                        //No Caso de Mudança de Valor Unitário, A Quantidade será alterado de acordo com 
                        //a execução, Assim sempre que houver um Aditivo por Moeda ou Indice, a Quantidade
                        //poderá ser alterada de acordo com a quantidade Executada
                        //Neste Caso, Quando o Item for de Um Aditivo Por Prazo 
                        //OU
                        //Aditivo de Valor Da Unidade de Calculo Moeda ou Indice
                        //esses serão ignorados
                        //Praticamente Mesma Regra do Serviço Não Continuado
                        $valorTotalDaQuantidade = 0.0000;
                        $valorTotalDaQuantidadeExecutado = 0.0000;
                        foreach ($todosItens as $k1 => $v1){                                                                     
                            if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v1['tipo'] == "aditivo")
                                ||
                                ($v1['id_cont_itens'] == $value->getIdContItens()
                                    && $v1['tipo'] == "contrato")
                                ){

                                $valorTotalDaQuantidadeExecutado += $v1['qtd_executado'];
                                
                                if($v1['id_contrato_motivo'] == $this->motivoPorPrazo) continue;
                                if($v1['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoMoeda()
                                        || $v1['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoIndice())
                                    continue;
                                                                
                                $qtItens = $v1['qt_itens_aux'];
                                                                
                                if($v1['id_contrato_motivo'] != $this->motivoPorPrazo
                                    && 
                                    !(   $v1['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoMoeda()
                                        || $v1['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoIndice()
                                        )    
                                    ){
                                    
//                                    if($v1['id_contrato_finalidade'] == $this->getFinalidadeSupressao()){
//                                        $valorTotalDaQuantidade -= $qtItens;
//                                    }else{
//                                        $valorTotalDaQuantidade += $qtItens;
//                                    }                                    
                                    $valorTotalDaQuantidade += $qtItens;
                                    
                                    
                                }
                                if($v1['id_contrato_motivo'] == $this->motivoPorPrazo
                                        || $v1['id_contrato_motivo'] == $this->motivoPorValorePrazo){
                                    break;
                                }   
                            }
                        }                                          
                        $finContItens[$k]->setQtItens(($valorTotalDaQuantidade - $valorTotalDaQuantidadeExecutado));
                        $finContItens[$k]->setQtItensAux(($valorTotalDaQuantidade - $valorTotalDaQuantidadeExecutado));
                        if($finContItens[$k]->getQtItens() < 0){
                            return Metodos::retornoAjax("Erro", "alert", "Cadastro Do Aditivo Não pode ser finalizado"
                                . " pois o Item ".$finContItens[$k]->getNrItem()." - ".$finContItens[$k]->getDescItem()
                                . " ficará com sua quantidade Negativa");
                        }
                        
                    
                    //====================================================
                    //Se a unidade de Cálculo for Quantidade ou Percentual
                    //Então o Campo preenchido que veio do formulário será para alter os itens do qt_itens
                    }else if($this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade()
                            || $this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual()){
                        //Se a unidade de calculo for percentual, então iremos fazer o calculo do percentual
                        //e verificar se ele está batendo com o valor informado pelo usuário na tela.
                        if($this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual()){
                            $valorNovo = round((($finContItens[$k]->getQtItens()/100) * $this->percentual), 4);
                            if($valorNovo != $this->itens[$key]['valor_aditivado']){
                                return Metodos::retornoAjax("Erro", "alert", "Os Valores dos Itens estão diferente do Informado pelo usuário. \n".STR_ERROR);
                            }else{
                                if($this->idFinalidade == $this->getFinalidadeSupressao()){
                                    $valorNovo = $valorNovo*(-1);
                                }
                                $this->itens[$key]['valor_aditivado'] = $valorNovo;
                            }                            
                        }              
                        if($this->idFinalidade == $this->getFinalidadeSupressao()){
                            $this->itens[$key]['valor_aditivado'] = $this->itens[$key]['valor_aditivado']*(-1);
                        }
                        $finContItens[$k]->setQtItens($this->itens[$key]['valor_aditivado']);                        
                        $finContItens[$k]->setQtItensAux($this->itens[$key]['valor_aditivado']);
                        
                        //O Valor Unitário irá sempre Repetir o Último Valor Válido do Contrato/Aditivo
                        foreach ($todosItens as $k1 => $v1){
                            if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v1['tipo'] == "aditivo")
                                ||
                                ($v1['id_cont_itens'] == $value->getIdContItens()
                                    && $v1['tipo'] == "contrato")
                                ){                                
                                if( $v1['vl_itens'] != "0" && $v1['vl_itens'] != "0.0"
                                        && $v1['vl_itens'] != "0.0000" && $v1['vl_itens'] != "0.00"
                                        && $v1['vl_itens'] > 0){                                    
                                    $finContItens[$k]->setVlItens($v1['vl_itens']);
                                    break;
                                }
                            }
                        }
                                                                                              
                    }
                    
                    /*
                     * Verifica se o Valor da Quantidade irá ficar negativo 
                     * se a Finalidade for Supressão
                     */
                    if($this->idFinalidade == $this->getFinalidadeSupressao()){
//                        echo "<pre>";
//                        print_r($todosItens);
//                        echo "</pre>";
                    }
                    
                }                                
            } 
            
                        
            //Ajusta os Valores dos Itens que serão duplicados no sistema
            /*############################VALOR E PRAZO#############################*/
            if(!empty($this->itens) && $this->idMotivo == $this->getMotivoPorValorePrazo()){
                                             
                foreach ($finContItens as $k => $value){
                    $key = array_search($value->getIdContItens(), array_column($this->itens, "id"));                   
                    //Se a aplicação não enviou o Id do Item, então esse item terá seu valor zerado
                    if($key === false && $this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade()){
                        $finContItens[$k]->setQtItens(0);
                        $finContItens[$k]->setVlItens(0);                     
                        $finContItens[$k]->setQtItensAux(0);
                        continue;
                    }                    
                                        
                    
                    //Se a unidade de Cálculo for Moeda ou Indice de Correção
                    //Então o Campo preenchido que veio do formulário será para alterar os itens do vl_itens
                    if($this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda()
                            || $this->idUnidadeCalculo == $this->getUnidadeCalculoIndice()){
                        //Se a unidade de calculo for indice de correção, então iremos fazer o calculo do percentual
                        //e verificar se ele está batendo com o valor informado pelo usuário na tela.
                        if($this->idUnidadeCalculo == $this->getUnidadeCalculoIndice()){
                            $valorNovo = round((($finContItens[$k]->getVlItens()/100) * $this->percentual), 4);
                            if($valorNovo != $this->itens[$key]['valor_aditivado']){
                                return Metodos::retornoAjax("Erro", "alert", "Os Valores dos Itens estão diferente do Informado pelo usuário. \n".STR_ERROR);
                            }else{
                                $this->itens[$key]['valor_aditivado'] = $valorNovo;
                            } 
                        }           
                        //Se O Valor Não foi informado, então ele deverá ser o ultimo valor valido
                        if($key === false && $this->idUnidadeCalculo == $this->getUnidadeCalculoMoeda()){
                            foreach ($todosItens as $k1 => $v1){        
                                if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                        && $v1['tipo'] == "aditivo")
                                    ||
                                    ($v1['id_cont_itens'] == $value->getIdContItens()
                                        && $v1['tipo'] == "contrato")
                                    ){
                                        //Seta o Ultimo Valor Unitário Valido
                                        if( $v1['vl_itens'] != "0" && $v1['vl_itens'] != "0.0"
                                            && $v1['vl_itens'] != "0.0000" && $v1['vl_itens'] != "0.00"
                                            && $v1['vl_itens'] > 0){                          
                                            $finContItens[$k]->setVlItens($v1['vl_itens']);
                                            break;
                                        }
                                    }
                            }                                                                                  
                        }else{                                                   
                            $finContItens[$k]->setVlItens($this->itens[$key]['valor_aditivado']);   
                        }
                        
                                                                        
                        
                        //No Caso de Mudança de Valor Unitário, A Quantidade será alterado de acordo com 
                        //a execução, Assim sempre que houver um Aditivo por Moeda ou Indice, a Quantidade
                        //poderá ser alterada de acordo com a quantidade Executada
                        //Neste Caso, Quando o Item for de Um Aditivo Por Prazo 
                        //OU
                        //Aditivo de Valor Da Unidade de Calculo Moeda ou Indice
                        //esses serão ignorados
                        //Praticamente Mesma Regra do Serviço Não Continuado
                        $valorTotalDaQuantidade = 0.0000;                        
                        foreach ($todosItens as $k1 => $v1){                                                                
                            if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v1['tipo'] == "aditivo")
                                ||
                                ($v1['id_cont_itens'] == $value->getIdContItens()
                                    && $v1['tipo'] == "contrato")
                                ){
                                
                                //Se a Unidade de Calculo for Indice ou Moeda, então devo ignorar essa quantidade
                                //para a somatoria
                                if($v1['id_contrato_unidade_calculo'] == $this->unidadeCalculoIndice
                                        || $v1['id_contrato_unidade_calculo'] == $this->unidadeCalculoMoeda){
                                    continue;
                                }
                                
                                //Faz a somatoria das Quantidades dos Itens
                                //Serviço Continuado, deverá somar todos os Itens
//                                if($v1['id_contrato_finalidade'] == $this->getFinalidadeSupressao()){
//                                    $valorTotalDaQuantidade -= $v1['qt_itens'];
//                                }else{
//                                    $valorTotalDaQuantidade += $v1['qt_itens'];   
//                                }
                                $valorTotalDaQuantidade += $v1['qt_itens'];
                                
                                //Se o Retorno for, um Item no qual o Aditivo for Por Prazo
                                //Então não precisa continuar correndo os Itens pois esse Valor já 
                                //está somando os demais aditivos anteriores
                                if($v1['id_contrato_motivo'] == $this->motivoPorPrazo
                                        || $v1['id_contrato_motivo'] == $this->motivoPorValorePrazo){
                                    break;
                                }                                                                                                                                              
                            }
                        }                       
                        $finContItens[$k]->setQtItens($valorTotalDaQuantidade);
                        $finContItens[$k]->setQtItensAux($valorTotalDaQuantidade);
                        if($finContItens[$k]->getQtItens() < 0){
                            return Metodos::retornoAjax("Erro", "alert", "Cadastro Do Aditivo Não pode ser finalizado"
                                . " pois o Item ".$finContItens[$k]->getNrItem()." - ".$finContItens[$k]->getDescItem()
                                . " ficará com sua quantidade Negativa");
                        }
                        
                    
                      
                    //Se a unidade de Cálculo for Quantidade ou Percentual
                    //Então o Campo preenchido que veio do formulário será para alter os itens do qt_itens
                    }else if($this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade()
                            || $this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual()){
                        //Se a unidade de calculo for percentual, então iremos fazer o calculo do percentual
                        //e verificar se ele está batendo com o valor informado pelo usuário na tela.
                        if($this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual()){
                            $valorNovo = round((($finContItens[$k]->getQtItens()/100) * $this->percentual), 4);
                            if($valorNovo != $this->itens[$key]['valor_aditivado']){
                                return Metodos::retornoAjax("Erro", "alert", "Os Valores dos Itens estão diferente do Informado pelo usuário. \n".STR_ERROR);
                            }else{
                                if($this->idFinalidade == $this->getFinalidadeSupressao()){
                                    $valorNovo = $valorNovo*(-1);
                                }
                                $this->itens[$key]['valor_aditivado'] = $valorNovo;
                            }                            
                        }                      
                        
                        if($this->idFinalidade == $this->getFinalidadeSupressao()){
                            $this->itens[$key]['valor_aditivado'] = $this->itens[$key]['valor_aditivado']*(-1);
                        }
                        $finContItens[$k]->setQtItensAux($this->itens[$key]['valor_aditivado']);
                        
                        $valorTotalDaQuantidade = $this->itens[$key]['valor_aditivado'];
                        foreach ($todosItens as $k1 => $v1){                                                             
                            if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v1['tipo'] == "aditivo")
                                ||
                                ($v1['id_cont_itens'] == $value->getIdContItens()
                                    && $v1['tipo'] == "contrato")
                                ){                               
                                //Se a Unidade de Calculo for Indice ou Moeda, então devo ignorar essa quantidade
                                //para a somatoria
                                if($v1['id_contrato_unidade_calculo'] == $this->unidadeCalculoIndice
                                        || $v1['id_contrato_unidade_calculo'] == $this->unidadeCalculoMoeda){
                                    continue;
                                }
                                
                                //Faz a somatoria das Quantidades dos Itens
                                //Serviço Continuado, deverá somar todos os Itens
//                                if($v1['id_contrato_finalidade'] == $this->getFinalidadeSupressao()){
//                                    $valorTotalDaQuantidade -= $v1['qt_itens'];
//                                }else{
//                                    $valorTotalDaQuantidade += $v1['qt_itens'];   
//                                }
                                $valorTotalDaQuantidade += $v1['qt_itens'];   

                                //Se o Retorno for, um Item no qual o Aditivo for Por Prazo
                                //Então não precisa continuar correndo os Itens pois esse Valor já 
                                //está somando os demais aditivos anteriores
                                if($v1['id_contrato_motivo'] == $this->motivoPorPrazo
                                        || $v1['id_contrato_motivo'] == $this->motivoPorValorePrazo){
                                    break;
                                }
                            }
                        }
                        $finContItens[$k]->setQtItens($valorTotalDaQuantidade);                        
                        if($finContItens[$k]->getQtItens() < 0){
                            return Metodos::retornoAjax("Erro", "alert", "Cadastro Do Aditivo Não pode ser finalizado"
                                . " pois o Item ".$finContItens[$k]->getNrItem()." - ".$finContItens[$k]->getDescItem()
                                . " ficará com sua quantidade Negativa");
                        }
                                                                                                                        
                        
                        //O Valor Unitário irá sempre Repetir o Último Valor Válido do Contrato/Aditivo
                        foreach ($todosItens as $k1 => $v1){
                            if( ($v1['id_cont_itens_aditivo'] == $value->getIdContItens()
                                    && $v1['tipo'] == "aditivo")
                                ||
                                ($v1['id_cont_itens'] == $value->getIdContItens()
                                    && $v1['tipo'] == "contrato")
                                ){                                
                                if( $v1['vl_itens'] != "0" && $v1['vl_itens'] != "0.0"
                                        && $v1['vl_itens'] != "0.0000" && $v1['vl_itens'] != "0.00"
                                        && $v1['vl_itens'] > 0){                                    
                                    $finContItens[$k]->setVlItens($v1['vl_itens']);
                                    break;
                                }
                            }
                        }
                                                                                              
                    }                                       
                    
                }                                
            }
//            
//            echo "<pre>";
//            print_r($finContItens);
//            echo "</pre>";
//            return;
       
            /*
             * Se o tipo de Aquisição for preenchido, então se deve calcular a Porcentagem
             * limite para cada tipo de aquisição
             */
            if(!empty($this->idTipoAquisicao)){
                $this->calculaLimitePorcentagemAquisicao($finContItens, $todosItens, $pdo);
                if(!$this->sucesso){
                    return Metodos::retornoAjax("Erro", "alert", $this->msgRetorno);
                }
//                echo "<pre>";
//                print_r($this->msgRetorno);
//                echo "</pre>";
            }
            
            //return;
//                
//            echo "<pre>";
//            print_r($finContItens);
//            echo "</pre>";
//            return;             
//            $finContItensAux = $finContItens;
//            $finContItens = "";
            
            
            //Preparar Dados Para Inserir no Banco            
            //Do Fin contrato, Fin Fornecedor.class, Fin Cont Central, Fin Cont Itens e Todos os
            //gestores, fiscais e subfiscais            
                                    
            //Adiciona os Dados na classe que representa a tabela Fin Contrato
            $finContratoTb = new FinContratoTb();
            //Nome do Numero do contrato
            $nomeDoContrato = $proximoAditivo."º Termo Aditivo ao contrato ".$contrato->getNrContrato();                          
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
            
            
            $finContratoTb->setDtAssinatura($this->dtAssinatura->format("Y-m-d"));
            $finContratoTb->setDtPublicacao($this->dtPublicacao->format("Y-m-d"));        
            $finContratoTb->setSqContrato($proximoSequencial);
            $finContratoTb->setIdContratoAditivoPai($this->idContratoAditivoPai);                 
            
            
            //Adiciona os Dados na classe que representa a tabela Fin Fornecedor.class
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
                $finItens->setNrItem($value->getNrItem());
                $finItens->setNrLote($value->getNrLote());
                $finItens->setNmMarca($value->getNmMarca());
                $finItens->setNmModelo($value->getNmModelo());
                $finItens->setQtItens($value->getQtItens());
                $finItens->setVlItens($value->getVlItens());
                $finItens->setPcDesconto($value->getPcDesconto());
                $finItens->setFlValorVariavel($value->getFlValorVariavel());
                $finItens->setDescItem($value->getDescItem());
                $finItens->setIdMaterial($value->getIdMaterial());
                $finItens->setIdContItens(NULL);
                $finItens->setIdUnidadeMedida($value->getIdUnidadeMedida());
                $finItens->setIdContItensAlt(NULL);
                $finItens->setIdContItensAditivo($value->getIdContItens());
                $finItens->setQtItensAux($value->getQtItensAux());
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
                    ->setDtInicial( (empty($this->dtPeriodoInicial)) ? NULL : $this->dtPeriodoInicial->format("Y-m-d") )
                    ->setDtFinal( (empty($this->dtPeriodoFinal)) ? NULL : $this->dtPeriodoFinal->format("Y-m-d") )
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
//            echo "<pre>";
//            print_r($contrato->getMsgRetorno());
//            echo "</pre>";
//            
//            echo "<pre>";
//            print_r($finContratoTb);
//            echo "</pre>";
//            return;                       

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
            $ultimoAditivo = (int)$daoContratoAditivo->getMsgRetorno()['numero_ultimo_aditivo'];
                                               
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
                            .'<button type="button" class="btn btn-default btn-open-modal btn-xs"'                               
                                . ' title="Detalhes" nome="'.$value['nr_contrato'].'" '                               
                                . ' value=' . $value['id_contrato'] . ' >
                                <i class="fa fa-file fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
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
            if(!( empty($this->numeroNovoAditivo) || empty($this->idFinalidade)
                || empty($this->idInstrumento) || empty($this->idBaseCalculo)                                    
                || empty($this->idUnidadeCalculo) || empty($this->dtPublicacao) 
                || empty($this->dtAssinatura) )){
                return true;
            }                        
        }
        
        //Se o Motivo é Por Prazo, então essa será a validação
        if($this->idMotivo == $this->getMotivoPorPrazo()){
            if(!( empty($this->numeroNovoAditivo) || empty($this->dtVigenciaInicial)
                    || empty($this->dtVigenciaFinal) || empty($this->dtAssinatura)
                    || empty($this->dtPublicacao) )){                
                return true;
            }
        }
        
        //Se o Motivo é Por Prazo e Valor, então essa será a validação
        if($this->idMotivo == $this->getMotivoPorValorePrazo()){    
            if(!( empty($this->numeroNovoAditivo) || empty($this->idFinalidade)
                || empty($this->idInstrumento) || empty($this->idBaseCalculo)                                    
                || empty($this->idUnidadeCalculo) || empty($this->dtPublicacao) 
                || empty($this->dtAssinatura) || empty($this->dtVigenciaInicial)
                || empty($this->dtVigenciaFinal))){
                return true;
            }                        
        }
                        
        return false;
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
        if($this->idMotivo == $this->getMotivoPorValor() || $this->idMotivo == $this->getMotivoPorValorePrazo()){     
                        
            //Se o Instrumento de equilibrio for Revisão, então é obrigatorio que seja informado
            //um tipo de aquisição
            if($this->idInstrumento == $this->getInstrumentoRevisao() 
                    && empty($this->idTipoAquisicao)){
                $this->sucesso = false;
                $this->msgRetorno = "Se o Instrumento de Equilíbrio Econômico-Financeiro for Revisão, "
                        . "deverá selecionar um Tipo de Aquisição";
                return;
            }
            if($this->idInstrumento == $this->getInstrumentoReajuste() 
                    && !empty($this->idTipoAquisicao)){
                $this->sucesso = false;
                $this->msgRetorno = "Se o Instrumento de Equilíbrio Econômico-Financeiro for Reajuste, "
                        . "não deve ser selecionado o Tipo de Aquisição";
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
            
            //Se o instrumento de equilibrio for Reajuste
            //Então é necessário que se preencha os Campos de Periodo Final e Periodo Inicial
            if( ($this->idInstrumento == $this->getInstrumentoReajuste())
                && (empty($this->dtPeriodoInicial) || empty($this->dtPeriodoFinal)) 
            ){
                $this->sucesso = false;
                $this->msgRetorno = "Se o Instrumento de Equilíbrio Econômico-Financeiro For Reajuste,"
                        . " então é obrigatório o preenchimento do Período Inicial e Final.";
                return;                                    
            }            
            
            //Se o instrumento de equilibrio for Reajuste
            //Então é necessário veririfcar se o período Final é Maior que o Período Inicial            
            if($this->dtPeriodoFinal < $this->dtPeriodoInicial){
                $this->sucesso = false;
                $this->msgRetorno = "Período Final Não pode ser Menor que o Período Inicial.";
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
                        
            //Se a Unidade de Cálculo for Percentual ou Indice de Correção
            //, então os dados dos percentuais devem estar preenchidos
            if( ($this->getUnidadeCalculoIndice() == $this->idUnidadeCalculo)
                    && empty((float)$this->percentual)){
                $this->sucesso = false;
                $this->msgRetorno = "Quando a Unidade de Cálculo for Índice de Correção, então é necesário que se informe"
                        . " o Valor do Índice de Correção.";
                return;  
            }else if(($this->getUnidadeCalculoPercentual() == $this->idUnidadeCalculo)
                    && empty((float)$this->percentual)){
                $this->sucesso = false;
                $this->msgRetorno = "Quando a Unidade de Cálculo for Percentual, então é necesário que se informe"
                        . " o Valor do Percentual.";
                return;  
            }
                                    
            
            //Motivo Por Valor, é necessário o preenchimento de algum item
            if(empty($this->itens)){
                $this->sucesso = false;
                $this->msgRetorno = "No Aditivo Por Valor, é necessário o Preenchimento dos Valores Por Cada Item que será aditivado.";
                return; 
            }
            //Se o Motivo for Valor e Prazo
            //Então pode deixar passar pois ele vai entrar no outro If
            if($this->idMotivo != $this->getMotivoPorValorePrazo()){
                $this->sucesso = true;
                $this->msgRetorno = "ok";
                return;
            }
        } 
        
        if($this->idMotivo == $this->getMotivoPorPrazo() || $this->idMotivo == $this->getMotivoPorValorePrazo()){
                                                                   
            if($this->dtVigenciaFinal < $this->dtVigenciaInicial){
                $this->sucesso = false;
                $this->msgRetorno = "Data Final da Vigência do Aditivo não pode ser Menor que a Data Inicial da Vigência do Aditivo.";
                return; 
            }
            
            if($this->dtAssinatura < $this->dtVigenciaInicial){
                $this->sucesso = false;
                $this->msgRetorno = "Data da Assinatura do Aditivo não pode ser Menor que a Data Inicial da Vigência do Aditivo.";
                return; 
            }
            
            if($this->dtPublicacao < $this->dtVigenciaInicial){
                $this->sucesso = false;
                $this->msgRetorno = "Data da Publicação do Aditivo não pode ser Menor que a Data Inicial da Vigência do Aditivo.";
                return; 
            }      
            
            $intervalo = $this->dtVigenciaInicial->diff($this->dtVigenciaFinal);
            if($intervalo->y > 0){
                $this->sucesso = false;
                $this->msgRetorno = "As Datas das Vigências, inicial e final, só poder ter no máximo diferença de 1 ano.";
                return; 
            }
           
            $this->sucesso = true;
            $this->msgRetorno = "ok";
            return;            
        }
        
        $this->sucesso = false;
        $this->msgRetorno = "Não foi possível validar os Dados desse Motivo do Aditivo.";
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
    
    
    public function retornaTodosItensComExecutado(PDO $pdo = null){
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
            $daoContratoAditivo->todosItensComExecutado($pdo);
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
    
    
    /**
     * Apartir de um Contrato, retorna em json com todos os Gestores, fiscais ... do
     * Contrato ou do Ultimo Aditivo
     * @param PDO $pdo     
     * @return json
     */
    public function retornaUltimoGestoresDoContratoAditivo(PDO $pdo = null){
        
        try{ 
        
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }

            $dao = new DaoFinContratoAditivo();
            $dao->setIdContrato($this->idContrato);
            $dao->retornaUltimoContratoAditivo($pdo);
            
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", "");
            }
            
            $idContrato = $dao->getMsgRetorno()['id_contrato'];
            $dao->setIdContrato($idContrato);
            $dao->retornaTodosGestoresFiscaisSubs($pdo);                                    
            
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", "");
            }
                        
            return Metodos::retornoAjax("ok", "console", $dao->getMsgRetorno());                                        
        
        } catch (Exception $ex) {
           return Metodos::retornoAjax("Erro", "console", $ex->getMessage());       
        }                
    }
    
    
    public function retornaInformacoesHtmlAditivo(PDO $pdo = null){
        
        try{ 
        
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            
            $dao = new DaoFinContratoAditivo();
            $dao->setIdContrato($this->idContrato);
            $dao->retornaDa($pdo);
            
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", "");
            }
            
            $idContrato = $dao->getMsgRetorno()['id_contrato'];
            $dao->setIdContrato($idContrato);
            $dao->retornaTodosGestoresFiscaisSubs($pdo);                                    
            
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", "");
            }
                        
            return Metodos::retornoAjax("ok", "console", $dao->getMsgRetorno());                                        
        
        } catch (Exception $ex) {
           return Metodos::retornoAjax("Erro", "console", $ex->getMessage());       
        }                
    }
    
    
    
    public function retornaInformacoesCompletaAditivo() {
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoAditivo();
            $daoContrato->setIdContrato($this->idContrato);
            
            
            $daoContrato->dadosCompletoAditivo($pdo);
            if(!$daoContrato->Sucesso()){
                $retorno = '<div class="alert alert-warning">'
                        . '<strong>Alerta!</strong> Não foi possível localizar os Dados do Aditivo.'
                    . '</div>';
                return $retorno;
            }
            $retorno = "";
            
            $result = $daoContrato->getMsgRetorno();
            
            $idFornecedor = $result['id_fornecedor'];
            
            $retorno .= '<div class="panel">'
                            .   '<div class="panel-body">'                               
                                .   '<div class="row">
                                        <div class="col-sm-6 celulas" >
                                            <p class="text-bold">Número do Contrato:</p>
                                            <p>&nbsp;'.$result['nr_contrato'].'</p>
                                        </div>
                                        <div class="col-sm-6 celulas">
                                            <p class="text-bold">Motivo:</p>
                                            <p>&nbsp;'.$result['nm_contrato_motivo'].'</p>
                                        </div>                                    
                                    </div>'
                                .   '<div class="row">
                                        <div class="col-sm-4 celulas">
                                            <p class="text-bold">Finalidade:</p>
                                            <p>&nbsp;'.$result['nm_contrato_finalidade'].'</p>
                                        </div>
                                        <div class="col-sm-4 celulas">
                                            <p class="text-bold">Instrumento de Equilíbrio Econômico-Financeiro:</p>
                                            <p>&nbsp;'.$result['nm_contrato_instrumento'].'</p>
                                        </div>
                                        <div class="col-sm-4 celulas">
                                            <p class="text-bold">Base de Cálculo:</p>
                                            <p>&nbsp;'.$result['nm_contrato_base_calculo'].'</p>
                                        </div>                                    
                                    </div>'
                                .   '<div class="row">
                                        <div class="col-sm-6 celulas">
                                            <p class="text-bold">Unidade de Cálculo:</p>
                                            <p>&nbsp;'.$result['nm_contrato_unidade_calculo'].'</p>
                                        </div>
                                        <div class="col-sm-6 celulas">
                                            <p class="text-bold">Tipo de Aquisição:</p>
                                            <p>&nbsp;'.$result['nm_contrato_aquisicao'].'</p>
                                        </div>                                    
                                    </div>'
                                .   '<div class="row">
                                        <div class="col-sm-6 celulas">
                                            <p class="text-bold">Vigência Inicial/Final:</p>
                                            <p>&nbsp;'.$result['dt_ini_vigencia_contrato'].' - '.$result['dt_fim_vigencia_contrato'].'</p>
                                        </div>
                                        <div class="col-sm-3 celulas">
                                            <p class="text-bold">Data da Assinatura:</p>
                                            <p>&nbsp;'.$result['dt_assinatura'].'</p>
                                        </div> 
                                        <div class="col-sm-3 celulas">
                                            <p class="text-bold">Data da Publicação:</p>
                                            <p>&nbsp;'.$result['dt_publicacao'].'</p>
                                        </div>
                                    </div>'
                    
                                .   '<div class="row">
                                        <div class="col-sm-4 celulas">
                                            <p class="text-bold">Período Inicial:</p>
                                            <p>&nbsp;'.$result['dt_inicial'].'</p>
                                        </div>
                                        <div class="col-sm-4 celulas">
                                            <p class="text-bold">Período Final:</p>
                                            <p>&nbsp;'.$result['dt_final'].'</p>
                                        </div> 
                                        <div class="col-sm-4 celulas">
                                            <p class="text-bold">Percentual/Índice de Correção:</p>
                                            <p>&nbsp;'.$result['nr_percentual_indice'].'</p>
                                        </div> 
                                    </div>'
                    
                                .   '<div class="row">
                                        <div class="col-sm-6 celulas">
                                            <p class="text-bold">Fornecedor.class:</p>
                                            <p>&nbsp;'.$result['nm_pessoa'].'</p>
                                        </div>
                                        <div class="col-sm-6 celulas">
                                            <p class="text-bold">Tipo de Gasto:</p>
                                            <p>&nbsp;'.$result['nm_tipo_gasto'].'</p>
                                        </div>                                    
                                    </div>'
                    
                                .   '<div class="row">
                                        <div class="col-sm-12 celulas">
                                            <p class="text-bold">Justificativa:</p>
                                            <p>&nbsp;'.$result['ds_justificativa'].'</p>
                                        </div>                                        
                                    </div>';
                    
            $finCentraisModel = new FinCentraisModel();
            $finCentraisModel->setIdContrato($this->idContrato);
            $finCentraisModel->retornaCentraisPorContrato($pdo);
            $centraisDoContrato = array();
            if($finCentraisModel->sucesso()){
                $centraisDoContrato = $finCentraisModel->getMsgRetorno();
            }
            
            if(is_array($centraisDoContrato) && !empty($centraisDoContrato)){
                $retorno .= '<div class="row">
                                <div class="col-sm-12 celulas">
                                    <p class="text-bold">Centrais de Demanda:</p>';
                $centrais = array();
                foreach ($centraisDoContrato as $value) {
                    $centrais[] = $value['nm_lotacao'];                                                            
                }
                $centrais = implode(", ", $centrais);
                $retorno .= '<p>&nbsp;'.$centrais.'</p>';
                $retorno .= '   </div>'
                        .   '</div>';
            }
            
            $arrayGestores = array(
                "gestor" => array(),
                "gestor_sub" => array(),
                "fiscal" => array(),
                "fiscal_sub" => array(),
                "sub_fiscal" => array(),
                "sub_fiscal_sub" => array()
            );
            
            $daoContrato->retornaTodosGestoresFiscaisSubs($pdo);  
            if($daoContrato->Sucesso()){
                $result = $daoContrato->getMsgRetorno();
                if(is_array($result) && !empty($result)){
                    foreach ($result as $key => $value) {
                        if($value['tabela'] == "gestor"
                                && $value['tipo'] == 1){
                            $arrayGestores['gestor'][] = $value['nm_pessoa'];
                            continue;
                        }
                        if($value['tabela'] == "gestor"
                                && $value['tipo'] == 2){
                            $arrayGestores['gestor_sub'][] = $value['nm_pessoa'];
                            continue;
                        }
                        if($value['tabela'] == "fiscal"
                                && $value['tipo'] == 1){
                            $arrayGestores['fiscal'][] = $value['nm_pessoa'];
                            continue;
                        }
                        if($value['tabela'] == "fiscal"
                                && $value['tipo'] == 2){
                            $arrayGestores['fiscal_sub'][] = $value['nm_pessoa'];
                            continue;
                        }
                        if($value['tabela'] == "sub_fiscal"
                                && $value['tipo'] == 1){
                            $arrayGestores['sub_fiscal'][] = $value['nm_pessoa'];
                            continue;
                        }
                        if($value['tabela'] == "sub_fiscal"
                                && $value['tipo'] == 2){
                            $arrayGestores['sub_fiscal_sub'][] = $value['nm_pessoa'];
                            continue;
                        }
                    }
                }
            }
            
            
            $retorno .= '<div class="row">
                            <div class="col-sm-6 celulas">
                                <p class="text-bold">Gestores Titulares:</p>
                                <p>&nbsp;'.implode(", " ,$arrayGestores['gestor']).'</p>
                            </div>
                            <div class="col-sm-6 celulas">
                                <p class="text-bold">Gestores Substitutos:</p>
                                <p>&nbsp;'.implode(", " ,$arrayGestores['gestor_sub']).'</p>
                            </div>                                    
                        </div>';
            
            $retorno .= '<div class="row">
                            <div class="col-sm-6 celulas">
                                <p class="text-bold">Fiscais:</p>
                                <p>&nbsp;'.implode(", " ,$arrayGestores['fiscal']).'</p>
                            </div>
                            <div class="col-sm-6 celulas">
                                <p class="text-bold">Fiscais Substitutos:</p>
                                <p>&nbsp;'.implode(", " ,$arrayGestores['fiscal_sub']).'</p>
                            </div>                                    
                        </div>';
            
            $retorno .= '<div class="row">
                            <div class="col-sm-6 celulas">
                                <p class="text-bold">Sub-Fiscais:</p>
                                <p>&nbsp;'.implode(", " ,$arrayGestores['sub_fiscal']).'</p>
                            </div>
                            <div class="col-sm-6 celulas">
                                <p class="text-bold">Sub-Fiscais Substitutos:</p>
                                <p>&nbsp;'.implode(", " ,$arrayGestores['sub_fiscal_sub']).'</p>
                            </div>                                    
                        </div>';
            
            $itemModel = new ItemModel();
            $itemModel->setIdFornecedor($idFornecedor);
            $itemModel->retornaItensPorFornecedor($pdo);
            if($itemModel->Sucesso()){
            
                $retorno .= "<div class='row'></div>";
                
                $retorno .= '<table class="table table-striped table-bordered" id="tabelaFu">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nº</th>
                                        <th class="text-center">Item</th>
                                        <th class="text-center">Descrição</th>
                                        <th class="text-center">Grupo</th>
                                        <th class="text-center">Sub Grupo</th>
                                        <th class="text-center">Unid</th>
                                        <th class="text-center">Elemento de Despesa</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Lote</th>
                                        <th class="text-center">QTD</th>
                                        <th class="text-center">Valor unit</th>                                                                                                                     
                                    </tr>
                                </thead>
                                <tbody>';

                $result = $itemModel->getMsgRetorno();
                foreach ($result as $key => $value) {
                    $retorno .= '<tr>'
                            . '<td>'.$value['nr_item'].'</td>'
                            . '<td>'.$value['nm_material'].'</td>'
                            . '<td>'.$value['cd_desc_material'].' - '.$value['nm_desc_material'].'</td>'
                            . '<td>'.$value['nm_grupo'].'</td>'
                            . '<td>'.$value['nm_sub_grupo'].'</td>'
                            . '<td>'.$value['nm_unidade_medida'].'</td>'
                            . '<td>'.$value['cd_elemento_despesa'].'</td>'
                            . '<td>'.$value['tp_material'].'</td>'
                            . '<td>'.$value['nr_lote'].'</td>'
                            . '<td>'.Metodos::ConverteValorBr($value['qt_itens'], 4) .'</td>'
                            . '<td>'.Metodos::ConverteValorBr($value["vl_itens"], 4).'</td>'                            
                            . '</tr>';
                }


                $retorno .= '   </tbody>
                            </table>';
            }
            
            
            
            
            $retorno .= '</div>
                                </div>';
                        
            return $retorno;                                                                                                                    
            
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function retornaHistoricoDosItens() {
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContratoAditivo();
            $daoContrato->setIdContrato($this->idContrato);
                    
            $daoContrato->todosItensHistorico($pdo);
            
            if(!$daoContrato->Sucesso()){
                $retorno = '<div class="alert alert-warning">'
                        . '<strong>Alerta!</strong> Não foi possível localizar os Dados do Aditivo.'
                    . '</div>';
                return $retorno;
            }
            $retorno = "";
            
            $result = $daoContrato->getMsgRetorno();
                        
            $dados = array();
            $cabecalho = array();
            $itens = array();
            foreach ($result as $key => $value) {                               
                
                if($value['tipo'] == "contrato"){
                    $cabecalho[$value['id_contrato']] = array(
                        "nr_contrato" => $value['nr_contrato'],
                        "nm_contrato_motivo" => "",
                        "nr_aditivo" => ""                        
                    );
                }else if($value['tipo'] == "aditivo_valor"){
                    $cabecalho[$value['id_contrato']] = array(
                        "nr_contrato" => $value['nr_contrato'],
                        "nm_contrato_motivo" => $value['nm_contrato_motivo'],
                        "nr_aditivo" => $value['nr_aditivo']                       
                    );
                }
                                
                $idContItens = $value['id_cont_itens'];
                if(!empty($value['id_cont_itens_aditivo'])){
                    $idContItens = $value['id_cont_itens_aditivo'];
                }
                
                if(!array_key_exists($idContItens, $dados)){
                    $dados[$idContItens] = array(
                        "nm_material" => $value['nm_material'],
                        "nm_desc_material" => $value['nm_desc_material'],
                        "cd_elemento_despesa" => $value['cd_elemento_despesa'],
                        "tp_material" => $value['tp_material'],
                        "nm_marca" => $value['nm_marca'],
                        "nr_item" => $value['nr_item'],
                        "nr_lote" => $value['nr_lote'],
                        "itens" => array(array(
                                    "qt_itens" => $value['qt_itens'],
                                    "qt_itens_aux" => $value['qt_itens_aux'],
                                    "vl_itens" => $value['vl_itens'],
                                    "finalidade" => $value['id_contrato_finalidade'],
                                    "unidade_calculo" => $value['id_contrato_unidade_calculo']
                                ))   
                    );
                }else{
                    $dados[$idContItens]['itens'][] = array(
                        "qt_itens" => $value['qt_itens'],
                        "qt_itens_aux" => $value['qt_itens_aux'],
                        "vl_itens" => $value['vl_itens'],
                        "finalidade" => $value['id_contrato_finalidade'],
                        "unidade_calculo" => $value['id_contrato_unidade_calculo']
                    );                                        
                }                                                                                               
            }
                       
            $retorno .= '<table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">Nº</th>
                                    <th class="text-center" rowspan="2">Item</th>
                                    <th class="text-center" rowspan="2">Descrição</th>                                                                                                                        
                                    <th class="text-center" rowspan="2">Elemento de Despesa</th>
                                    <th class="text-center" rowspan="2">Tipo</th>
                                    <th class="text-center" rowspan="2">Lote</th>';            
            
            $quantidadeEValor = "";
            
            foreach ($cabecalho as $key => $value) {
                $retorno .= '<th class="text-center" colspan="2">';
                if(empty($value['nr_aditivo'])){
                    $retorno .= "Contrato";
                }else{
                    $retorno .= $value['nr_aditivo']."º Por ".$value['nm_contrato_motivo'];
                }
                $retorno .= '</th>';    
                $quantidadeEValor .= '<th class="text-center">Quantidade</th>';
                $quantidadeEValor .= '<th class="text-center">Valor</th>';
            }
            $retorno .= '</tr>'; 
            $retorno .= '<tr>';
            $retorno .= $quantidadeEValor;
            $retorno .= '</tr>';
            $retorno .= '</thead><tbody>';

            foreach ($dados as $key => $value) {                              
                $retorno .= '<tr>';
                    $retorno .= '<td>'.$value['nr_item'].'</td>';
                    $retorno .= '<td>'.$value['nm_material'].'</td>';
                    $retorno .= '<td style="white-space: pre-wrap; word-wrap: break-word;">'.$value['nm_desc_material'].'</td>';
                    $retorno .= '<td>'.$value['cd_elemento_despesa'].'</td>';
                    $retorno .= '<td>'.$value['tp_material'].'</td>';
                    $retorno .= '<td>'.$value['nr_lote'].'</td>';
                $quantidade = $value['itens'][0]['qt_itens'];
                foreach ($value['itens'] as $k => $v) {
                    $textColor = "";
                    $simbolo = "";
                    $porcentagem = "";
                    if($v['finalidade'] == $this->getFinalidadeSupressao()){
                        $textColor = "text-danger";
                        $simbolo = "";
                    }
                    
                    if($v['unidade_calculo'] == $this->getUnidadeCalculoPercentual()
                            || $v['unidade_calculo'] == $this->getUnidadeCalculoQuantidade()){                    
                        $porcentagem = $v['qt_itens_aux']/$quantidade*100;
                        $porcentagem = " (".Metodos::ConverteValorBr($porcentagem, 2)."%)";                        
                    }
                    
                    
                    $retorno .= '<td class="text-center '.$textColor.' " style="white-space: nowrap; overflow: hidden;" class="text-right">'.$simbolo."".Metodos::ConverteValorBr($v['qt_itens'], 4)."".$porcentagem.'</td>';
                    $retorno .= '<td style="white-space: nowrap; overflow: hidden;" class="text-right">R$ '.Metodos::ConverteValorBr($v['vl_itens'], 4).'</td>';
                }                                                            
                $retorno .= "</tr>";
            }
                        
            $retorno .= '</tbody></table>';                                          
            return $retorno;           
            
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function calculaLimitePorcentagemAquisicao(array $finContItens, array $todosItens, PDO $pdo){
        $this->sucesso = false;
                
        /*
         * Se a Finalidade for Adição
         * Se o Instrumento de Equilíbrio Econômico-Financeiro For Revisão
         * Se o Tipo de Aquisição For Preenchido
         * Então iremos verificar a Porcentagem
         */
              
        
        /*
         * Somente será calculado a somatoria dos Itens de forem do tipo:
         * - Unidade de Cálculo = Percentual ou Quantidade
         */
        if(!($this->idFinalidade == $this->getFinalidadeAdicao()
                && $this->idInstrumento == $this->getInstrumentoRevisao()
                && !empty($this->idTipoAquisicao)
                && ($this->idUnidadeCalculo == $this->getUnidadeCalculoPercentual()
                        ||
                    $this->idUnidadeCalculo == $this->getUnidadeCalculoQuantidade())                
                )){
            $this->sucesso = true;
            $this->msgRetorno = "Não será calculado a Porcentagem, pois Não é necessário para esse tipo de requisição.";
            return;
        }
        $valores = array();
        
              
        foreach ($todosItens as $key => $value){           
            if($value['tipo'] == "aditivo"
                && 
                ($value['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoPercentual()
                ||
                $value['id_contrato_unidade_calculo'] == $this->getUnidadeCalculoQuantidade())
                &&
                $value['qt_itens_aux'] != '0.0000' && $value['qt_itens_aux'] != '0.00' && $value['qt_itens_aux'] != '0'
                && $value['id_contrato_finalidade'] == $this->getFinalidadeAdicao()
                ){
                    
                    $k = array_search($value['id_cont_itens_aditivo'], array_column($todosItens, "id_cont_itens"));  
                    $porcentagemDoItem = ($value['qt_itens_aux']/$todosItens[$k]['qt_itens'])*100;
                    $porcentagemDoItem = round($porcentagemDoItem, 4);
                    $valores[$value['id_cont_itens_aditivo']][] = array(
                        "quantidade" => $value['qt_itens_aux'],                        
                        "porcentagem" => $porcentagemDoItem,
                        "id_cont_itens" => $value['id_cont_itens']
                    ); 
            }elseif($value['tipo'] == "contrato"){                          
                $porcentagemDoItem = ($finContItens[$value['id_cont_itens']]->getQtItensAux()/$value['qt_itens'])*100;
                $porcentagemDoItem = round($porcentagemDoItem, 4);
                $valores[$value['id_cont_itens']][] = array(
                    "quantidade" => $finContItens[$value['id_cont_itens']]->getQtItensAux(),                        
                    "porcentagem" => $porcentagemDoItem,
                    "id_cont_itens" => $value['id_cont_itens']
                ); 
            }
        }         
        
       
               
        if(empty($valores)){            
            $this->sucesso = false;
            $this->msgRetorno = "Não foi encontrado nenhuma Item para ser feito o Calculo da Porcentagem. ".STR_ERROR;
            return; 
        }
    
                       
        foreach ($valores as $k => $v){
            $quantidade = 0;            
            foreach ($v as $key => $value){
                $quantidade += $value['porcentagem'];
            }
            if($quantidade > $this->porcentagemLimitePorAquisicao()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Cadastrar o Novo Aditivo pois "
                        . "o Limite da Porcentagem de ".$this->porcentagemLimitePorAquisicao()."%"
                        . " do Item do ".$finContItens[$k]->getNrItem()." - ".$finContItens[$k]->getDescItem()
                        . " será ultrapassado, ficando ". Metodos::ConverteValorBr($quantidade, 4)."%";
                return;
            }            
        }                      
        
        $this->sucesso = true;
        $this->msgRetorno = "Tudo ok com as Porcentagens.";
        return;
    }
    
    
    
    
}

