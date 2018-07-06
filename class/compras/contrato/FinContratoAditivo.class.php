<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoAditivo.class.php";

class FinContratoAditivo {
            
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
    
    private $contrato = null;
    private $itens = array();
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    function getIdContrato() {
        return $this->idContrato;
    }

    function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }       
    
    function getIdMotivo() {
        return $this->idMotivo;
    }

    function getNumeroNovoAditivo() {
        return $this->numeroNovoAditivo;
    }

    function getIdBaseCalculo() {
        return $this->idBaseCalculo;
    }

    function getDtPublicacao() {
        return $this->dtPublicacao;
    }

    function getIdFinalidade() {
        return $this->idFinalidade;
    }

    function getIndiceCorrecao() {
        return $this->indiceCorrecao;
    }

    function getIdInstrumento() {
        return $this->idInstrumento;
    }

    function getPercentual() {
        return $this->percentual;
    }

    function getDtPeriodoInicial() {
        return $this->dtPeriodoInicial;
    }

    function getDtPeriodoFinal() {
        return $this->dtPeriodoFinal;
    }

    function getIdTipoAquisicao() {
        return $this->idTipoAquisicao;
    }

    function setIdMotivo($idMotivo) {
        $this->idMotivo = $idMotivo;
    }

    function setNumeroNovoAditivo($numeroNovoAditivo) {
        $this->numeroNovoAditivo = $numeroNovoAditivo;
    }

    function setIdBaseCalculo($idBaseCalculo) {
        $this->idBaseCalculo = $idBaseCalculo;
    }

    function setDtPublicacao($dtPublicacao) {
        $this->dtPublicacao = $dtPublicacao;
    }

    function setIdFinalidade($idFinalidade) {
        $this->idFinalidade = $idFinalidade;
    }

    function setIndiceCorrecao($indiceCorrecao) {
        $this->indiceCorrecao = $indiceCorrecao;
    }

    function setIdInstrumento($idInstrumento) {
        $this->idInstrumento = $idInstrumento;
    }

    function setPercentual($percentual) {
        $this->percentual = $percentual;
    }

    function setDtPeriodoInicial($dtPeriodoInicial) {
        $this->dtPeriodoInicial = $dtPeriodoInicial;
    }

    function setDtPeriodoFinal($dtPeriodoFinal) {
        $this->dtPeriodoFinal = $dtPeriodoFinal;
    }

    function setIdTipoAquisicao($idTipoAquisicao) {
        $this->idTipoAquisicao = $idTipoAquisicao;
    }

    function getDtAssinatura() {
        return $this->dtAssinatura;
    }

    function setDtAssinatura($dtAssinatura) {
        $this->dtAssinatura = $dtAssinatura;
    }        
            
    function getIdUnidadeCalculo() {
        return $this->idUnidadeCalculo;
    }
    
    function getDsJustificativa() {
        return $this->dsJustificativa;
    }

    function setDsJustificativa($dsJustificativa) {
        $this->dsJustificativa = $dsJustificativa;
    }

    
    function setIdUnidadeCalculo($idUnidadeCalculo) {
        $this->idUnidadeCalculo = $idUnidadeCalculo;
    }
    
    function getMotivoPorValor() {
        return $this->motivoPorValor;
    }

    function getMotivoPorPrazo() {
        return $this->motivoPorPrazo;
    }

    function getMotivoPorValorePrazo() {
        return $this->motivoPorValorePrazo;
    }
    
    function getFinalidadeAdicao() {
        return $this->finalidadeAdicao;
    }

    function getFinalidadeSupressao() {
        return $this->finalidadeSupressao;
    }

    function getInstrumentoRevisao() {
        return $this->instrumentoRevisao;
    }

    function getInstrumentoReajuste() {
        return $this->instrumentoReajuste;
    }

    function getBaseCalculoGlobal() {
        return $this->baseCalculoGlobal;
    }

    function getBaseCalculoUnitario() {
        return $this->baseCalculoUnitario;
    }

    function getUnidadeCalculoPercentual() {
        return $this->unidadeCalculoPercentual;
    }

    function getUnidadeCalculoIndice() {
        return $this->unidadeCalculoIndice;
    }

    function getUnidadeCalculoMoeda() {
        return $this->unidadeCalculoMoeda;
    }

    function getUnidadeCalculoQuantidade() {
        return $this->unidadeCalculoQuantidade;
    }

    function getTipoAquisicaoObras() {
        return $this->tipoAquisicaoObras;
    }

    function getTipoAquisicaoReforma() {
        return $this->tipoAquisicaoReforma;
    }
    
    
    public function salvar($dados){

        try{

            if(!is_array($dados)){
                return Metodos::retornoAjax("Erro", "console", "Não foi possível validar esses dados como array.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();

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
            $daoContratoAditivo->retornaUltimoAditivo($pdo);                                    
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
            $this->contrato = new FinContratoModel();            
            
            $this->itens[] = new ItemModel();
            $this->itens[] = new ItemModel();
            
            echo "<pre>";
            print_r($this->contrato);
            echo "</pre>";
            
            echo "<pre>";
            print_r($this->itens);
            echo "</pre>";
           





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
            $daoContrato->retornaUltimoAditivo($pdo);
                        
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

