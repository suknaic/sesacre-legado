<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContratoAditivo.class.php";

class FinContratoAditivo {
            
    private $idContrato = null;
    private $idMotivo = null;
    private $numeroNovoAditivo = null;
    private $idBaseCalculo = null;
    private $dtPublicacao = null;
    private $idFinalidade = null;
    private $indiceCorrecao = null;
    private $idInstrumento = null;
    private $percentual = null;
    private $dtPeriodoInicial = null;
    private $dtPeriodoFinal = null;
    private $idTipoAquisicao = null;
    
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
            $this->indiceCorrecao = $dados['dados']['indice_correcao'];
            $this->idInstrumento = (int)$dados['dados']['instrumento'];
            $this->idMotivo = (int)$dados['dados']['motivo'];
            $this->percentual = $dados['dados']['percentual'];
            $this->idTipoAquisicao = (int)$dados['dados']['tipo_aquisicao'];            
            
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
            
            
            $contrato = new FinContratoModel();
            $contrato->setIdContrato($this->idContrato);
            $contrato->setSqContrato($this->numeroNovoAditivo);
            
            //Verifica a Quantidade de Aditivos
            $daoContratoAditivo = new DaoFinContratoAditivo();
            $daoContratoAditivo->setIdContrato($contrato->getIdContrato());
            $daoContratoAditivo->retornaQuantidadeDeAditivo($pdo);                                    
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
            $daoContrato->retornaQuantidadeDeAditivo($pdo);
                        
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
    
    
}

