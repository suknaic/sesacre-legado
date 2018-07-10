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
            $contrato->setSqContrato($this->numeroNovoAditivo);

            //Verifica a Quantidade de Aditivos
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoAditivo->setIdContrato($contrato->getIdContrato());
            $daoContratoAditivo->retornaNumeroUltimoAditivo($pdo);                                    
            if(!$daoContratoAditivo->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", "Não foi possível saber a quantidade de Aditivo.");
            }
            //Adiciona em 1 a quantidade do Aditivo, que será o próximo aditivo            
            $proximoAditivo = (int)$daoContratoAditivo->getMsgRetorno() + 1;                      
            //Valida se o novo aditivo informado realmente é o mesmo que será gerado.
            if($proximoAditivo != $contrato->getSqContrato()){
                return Metodos::retornoAjax("Erro", "alert", "O Número do Aditivo informado parece que já está cadastrado, por favor verifique se o Aditivo já está cadastrado.");
            }
            $contrato->setSqContrato($proximoAditivo);

            //Carregar Todos os Dados do Contrato, Cont Itens, Fornecedor
            $contratoRef = new FinContratoModel();
            $contratoRef->setIdContrato($this->idContrato);
            $contratoRef->retornaDadosContratoCompleto($pdo);
            if(!$contratoRef->sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar os Dados do Último Contrato/Aditivo.");
            }
            
          
            //Busca os Dados do fin cont itens
            //Itens do Contrato
            
            
            
            
            $contRef = $contratoRef->getMsgRetorno();
                                                                       
            //Preparar Dados Para Inserir no Banco            
            //Do Fin contrato, Fin Fornecedor, Fin Cont Central, Fin Cont Itens e Todos os 
            //gestores, fiscais e subfiscais
            $daoContrato = new FinContratoModel();
                                    
            //Adiciona os Dados na classe que representa a tabela Fin Contrato
            $finContratoTb = new FinContratoTb();     
            //Nome do Numero do contrato
            $nomeDoContrato = $contrato->getSqContrato()."º Termo Aditivo ao contrato ".$contRef->getNrContrato();            
            $finContratoTb->setNrContrato($nomeDoContrato);
            $finContratoTb->setNrPrazoEntrega($contRef->getNrPrazoEntrega());
            $finContratoTb->setIdProcesso($contRef->getIdProcesso());
            $finContratoTb->setIdPessoa($contRef->getIdPessoa());
            $finContratoTb->setDsObjeto($contRef->getDsObjeto());            
            $finContratoTb->setFlServicoContinuado($contRef->getFlServicoContinuado());
            $finContratoTb->setDtIniVigenciaContrato($contRef->getDtIniVigenciaContrato());
            $finContratoTb->setDtFimVigenciaContrato($contRef->getDtFimVigenciaContrato());
            $finContratoTb->setDtAssinatura($contRef->getDtAssinatura());
            $finContratoTb->setDtPublicacao($contRef->getDtPublicacao());
            $finContratoTb->setDsObsContrato($contRef->getDsObsContrato());
            $finContratoTb->setIdModalidade($contRef->getIdModalidade());
            $finContratoTb->setDsAreaAbrangencia($contRef->getDsAreaAbrangencia());
            $finContratoTb->setDsUnidadeContemplada($contRef->getDsUnidadeContemplada());
            $finContratoTb->setIdOrgaoGerenciador($contRef->getIdOrgaoGerenciador());
            $finContratoTb->setIdTipoGasto($contRef->getIdTipoGasto());
            $finContratoTb->setVlContrato($contRef->getVlContrato());
            $finContratoTb->setTpContrato($contRef->getTpContrato());
            $finContratoTb->setSqContrato($contrato->getSqContrato());
            $finContratoTb->setIdContratoAditivoPai($this->idContrato);                       
            
            
            //Adiciona os Dados na classe que representa a tabela Fin Fornecedor
            $finFornecedorTb = new FinFornecedoresTb();            
            $finFornecedorTb->setIdPessoa($contRef->getFornecedor()->getIdPessoa());
            
            
            //Busca os Dados do Fin Cont Central
            //Centrais do Contrato
            $finContItens = new FinCentraisModel();
            $finContItens->setIdContrato($this->idContrato);
            $finContItens->retornaCentraisPorContrato($pdo);
            $centraisDoContrato = array();
            if($finContItens->sucesso()){
                $centraisDoContrato = $finContItens->getMsgRetorno();
            }
                        
                        
            $contrato->cadastrarContratoComAditivo($finContratoTb, $finFornecedorTb
                    , $centraisDoContrato
                    , $this->gestorTitular, $this->gestorSubstituto
                    , $this->fiscal, $this->fiscalSubstituto
                    , $this->subFiscal, $this->subFiscalSubstituto
                    , $pdo);
            if(!$contrato->sucesso()){  
                return Metodos::retornoAjax("Erro", "console", $contrato->getMsgRetorno());
            }
            echo $this->msgRetorno;
            $pdo->commit();
            return;
            
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
            
            
            //Busca a quantidade de Aditivos Cadastrado no sistema
            $daoContrato->retornaNumeroUltimoAditivo($pdo);
                        
            if(!$daoContrato->Sucesso()){
                $retorno = '<div class="alert alert-warning">'
                        . '<strong>Alerta!</strong> '.STR_ERROR.' '
                    . '</div>';
                return $retorno;
            }
            $quantidade = $daoContrato->getMsgRetorno();
            
            $retorno = '<div class="alert alert-warning aditivo_quantidade" quantidade='.$quantidade.'>'
                        . '<strong>Alerta!</strong> Este Contrato Não Possui Aditivo.'
                    . '</div>';
					                    			            
            return $retorno;
            
            
            $retorno = '<table class="table table-striped table-bordered table-condensed aditivo_quantidade" quantidade='.$quantidade.'>
                    <thead>
                        <tr>
                            <th>Número do Aditivo</th>
                            <th>Motivo do Aditamento</th>
                            <th>Vigência</th>
                            <th>Publicação</th>
                            <th>Valor do Aditivo</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>';                    
            
            
            
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
        }                                        
        $this->sucesso = true;
        $this->msgRetorno = "ok";
    }
    
}

