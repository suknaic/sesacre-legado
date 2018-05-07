<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPreLoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPreLoaValores.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPreLoaHistorico.class.php";

class PreLoa{
    
    private $idPreLoa = null;
    private $aaPreLoa = null;
    private $stPreLoa = null;
    private $idPessoa = null;
    private $idPreLoaValores = null;
    private $dsPreLoaHistorico = null;
    private $idProgramaTrabalho = null;
    private $idDespesaElemento = null;
    private $idFonte = null;
    private $vlPreLoaValores = null;
    private $sucesso = null;
    private $msgRetorno = null;    
    private $stLoaSalva = 1;
    private $stLoaRetornada = 2;
    private $stLoaEnviadaPeloPlanejamento = 3;
    private $stLoaSecPlaGestao = 4;
    private $stLoaSecAdmFinan = 5;
    private $stLoaSecAteSaude = 6;    
    private $stLoaSecGeral = 7;
    private $stLoaConselho = 8;
    
    function getIdPreLoa() {
        return $this->idPreLoa;
    }

    function getAaPreLoa() {
        return $this->aaPreLoa;
    }

    function getStPreLoa() {
        return $this->stPreLoa;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDsPreLoaHistorico() {
        return $this->dsPreLoaHistorico;
    }

    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getIdDespesaElemento() {
        return $this->idDespesaElemento;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getVlPreLoaValores() {
        return $this->vlPreLoaValores;
    }

    function setIdPreLoa($idPreLoa) {
        $this->idPreLoa = $idPreLoa;
        return $this;
    }

    function setAaPreLoa($aaPreLoa) {
        $this->aaPreLoa = $aaPreLoa;
        return $this;
    }

    function setStPreLoa($stPreLoa) {
        $this->stPreLoa = $stPreLoa;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setDsPreLoaHistorico($dsPreLoaHistorico) {
        $this->dsPreLoaHistorico = $dsPreLoaHistorico;
        return $this;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
        return $this;
    }

    function setIdDespesaElemento($idDespesaElemento) {
        $this->idDespesaElemento = $idDespesaElemento;
        return $this;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
        return $this;
    }

    function setVlPreLoaValores($vlPreLoaValores) {
        $this->vlPreLoaValores = $vlPreLoaValores;
        return $this;
    }     
    
    function getIdPreLoaValores() {
        return $this->idPreLoaValores;
    }

    function setIdPreLoaValores($idPreLoaValores) {
        $this->idPreLoaValores = $idPreLoaValores;
        return $this;
    }
        
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    /**
     * 1 - Loa Criada
     * @return int
     */
    public function stLoaSalva() {
        return $this->stLoaSalva;        
    }
    
    /**     
     * 2 - Foi Retornado para o Planejamento
     * @return int
     */
    public function stLoaRetornada() {
        return $this->stLoaRetornada;
    }
    
    /**
     * 3 - Enviada Pelo Planejamento Para Autorização
     * @return int
     */
    public function stLoaEnviadaPeloPlanejamento(){
        return $this->stLoaEnviadaPeloPlanejamento;
    }
    
    /**
     * 4 - Autorizada pela Secretária Adjunto de Planejamento e Gestão
     * @return int
     */
    public function stLoaSecPlaGestao(){
        return $this->stLoaSecPlaGestao;
    }
    /**
     * 5 - Autorizada pela Secretária Adjunto de Administração e Financias
     * @return int
     */
    public function stLoaSecAdmFinan(){
        return $this->stLoaSecAdmFinan;
    }
    
    /**
     * 6 - Autorizada pela Secretária Adjunto de Atenção a Saúde
     * @return int
     */
    public function stLoaSecAteSaude(){
        return $this->stLoaSecAteSaude;
    }
    
    /**
     * 7 - Autorizada pela Secretário Geral
     * @return int
     */
    public function stLoaSecGeral(){
        return $this->stLoaSecGeral;
    }
    
    /**
     * 8 - Autorizada pelo Conselho
     * @return int
     */
    public function stLoaConselho(){
        return $this->stLoaConselho;
    }
        
    
    /**
     * Retorna um Texto e uma cor a ser usanda informado o Status da PreLOA
     * @param type $status
     * @return Object
     */
    public function stTextoItem($status){
        $obj = new stdClass();
        switch ($status) {            
            case $this->stLoaSalva:                
                $obj->msg = "Criada Pelo Planejamento"; 
                $obj->cor = "warning"; 
                $obj->msgText = " Criou a Prévia-LOA. Mensagem do Planejamento: ";
                $obj->aguardando = " Aguardando Ser Enviada Para Autorização.";
                return $obj;                
                break;
            case $this->stLoaRetornada:                
                $obj->msg = "Prévia-LOA não Autorizada"; 
                $obj->cor = "danger"; 
                $obj->msgText = " Não Autorizou a Prévia-LOA. Mensagem: ";
                $obj->aguardando = " Aguardando Planejamento Reavaliar a Prévia-LOA.";
                return $obj;                
                break;
            case $this->stLoaEnviadaPeloPlanejamento:                
                $obj->msg = "Prévia-LOA Enviada Para Autorização Pelo Planejamento"; 
                $obj->cor = "warning"; 
                $obj->msgText = " Enviou para Autorização a Prévia-LOA pelo Planejamento. Mensagem: ";
                $obj->aguardando = " Aguardando Ser Autorizada Pela Sec. Adjunta de Planejamento e Gestão.";
                return $obj;                
                break;
            case $this->stLoaSecPlaGestao:
                $obj->msg = "Autorizada Pela Sec. Adjunta de Planejamento e Gestão"; 
                $obj->cor = "warning";  
                $obj->msgText = " Sec. Adj. de Planejamento e Gestão Autorizou a Prévia-LOA. Mensagem: ";
                //$obj->aguardando = " Aguardando Ser Autorizada Pela Sec. Adjunta de Administração e Finanças.";
                $obj->aguardando = " Aguardando Ser Autorizada Pela Sec. Geral.";
                return $obj;
                breal;
            case $this->stLoaSecAdmFinan:
                $obj->msg = "Autorizada Pela Sec. Adjunta de Administração e Finanças"; 
                $obj->cor = "warning"; 
                $obj->msgText = " Sec. Adj. de Administração e Finanças Autorizou a Prévia-LOA. Mensagem: ";
                $obj->aguardando = " Aguardando Ser Autorizada Pela Sec. Adjunta de Atenção a Saúde.";
                return $obj;
                break;
            case $this->stLoaSecAteSaude:
                $obj->msg = "Autorizada Pela Sec. Adjunta de Atenção a Saúde"; 
                $obj->cor = "warning"; 
                $obj->msgText = " Sec. Adj. de Atenção a Saúde Autorizou a Prévia-LOA. Mensagem: ";
                $obj->aguardando = " Aguardando Ser Autorizada Pela Sec. Geral.";
                return $obj;
                break; 
            case $this->stLoaSecGeral:
                $obj->msg = "Autorizada Pela Sec. Geral"; 
                $obj->cor = "warning"; 
                $obj->msgText = " Sec. Geral Autorizou a Prévia-LOA. Mensagem: ";
                $obj->aguardando = " Aguardando Ser Autorizada Pelo Conselho.";
                return $obj;
                break; 
            case $this->stLoaConselho:
                $obj->msg = "Autorizada Pelo Conselho"; 
                $obj->cor = "success"; 
                $obj->msgText = " Conselho Autorizou a Prévia-LOA. Mensagem: ";
                $obj->aguardando = " Prévia-LOA Válida.";
                return $obj;
                break; 
            default:
                $obj->msg = "Não Criada"; 
                $obj->cor = "default"; 
                $obj->msgText = "";
                $obj->aguardando = " Aguardando ser Criada Pelo Planejamento.";
                return $obj;                                   
                break;            
        }
    }
    
    /**
     * Verifica se o Planejamento Pode Enviar a Prévia-LOA para autorização
     * @param int $status
     * @return boolean
     */
    public function stPodeEnviarPlanejamento(int $status){
        $status = (int)$status;
        
        $array = array($this->stLoaSalva(), $this->stLoaRetornada());
        if(in_array($status, $array)){
            return TRUE;
        }else{
            return FALSE;
        }                                
    }
    
    /**
     * Verifica a Prévia-LOA ainda pode sofrer autorização ou retorno pelos Autorizadores
     * @param int $status
     * @return boolean
     */
    public function stPodeAutorizarRetornar(int $status){
        $status = (int)$status;
        
        $array = array($this->stLoaConselho());
        if(in_array($status, $array)){
            return FALSE;
        }else{
            return TRUE;
        }                                
    }
    
    
    /**
     * @param int $perfil
     * @param int $status
     * @return int
     */
    private function verificaStatusPerfil(int $perfil, int $status){                
        
        switch ($perfil) {            
            case PERFIL_PLANEJAMENTO:   
                $array = array($this->stLoaSalva(), $this->stLoaRetornada());
                if(in_array($status, $array)){
                    return TRUE;
                }else{
                    return FALSE;
                }                       
                break;
            case PERFIL_PLANEJAMENTO_SEC_ADJ_PLA_GESTAO:   
                $array = array($this->stLoaEnviadaPeloPlanejamento());
                if(in_array($status, $array)){
                    return TRUE;
                }else{
                    return FALSE;
                }                       
                break;
            case PERFIL_PLANEJAMENTO_SEC_ADJ_ADM_FINAN:
                $array = array($this->stLoaSecPlaGestao());
                if(in_array($status, $array)){
                    return TRUE;
                }else{
                    return FALSE;
                }                       
                break;             
            case PERFIL_PLANEJAMENTO_SEC_ADJ_ATE_SAUDE:
                $array = array($this->stLoaSecAdmFinan());
                if(in_array($status, $array)){
                    return TRUE;
                }else{
                    return FALSE;
                }                       
                break; 
            case PERFIL_PLANEJAMENTO_SEC_GERAL:
                $array = array($this->stLoaSecAteSaude());
                if(in_array($status, $array)){
                    return TRUE;
                }else{
                    return FALSE;
                }                       
                break;
            case PERFIL_PLANEJAMENTO_CONSELHO:
                $array = array($this->stLoaSecGeral());
                if(in_array($status, $array)){
                    return TRUE;
                }else{
                    return FALSE;
                }                       
                break;                                  
            default:
                return FALSE;
                break;
        }
    }
    
    /**
     * 
     * @param int $status
     * @return int
     */
    private function retornaProximoStatus(int $status = 0){                
        
        switch ($status) {
            case $this->stLoaSalva():
                return $this->stLoaEnviadaPeloPlanejamento();
                break;
             case $this->stLoaRetornada():
                return $this->stLoaEnviadaPeloPlanejamento();
                break;
            case $this->stLoaEnviadaPeloPlanejamento():
                return $this->stLoaSecPlaGestao();
                break;
            case $this->stLoaSecPlaGestao():
                return $this->stLoaSecGeral();
                break; 
//            case $this->stLoaSecPlaGestao():
//                return $this->stLoaSecAdmFinan();
//                break;             
//            case $this->stLoaSecAdmFinan():
//                return $this->stLoaSecAteSaude();
//                break;             
//            case $this->stLoaSecAteSaude():
//                return $this->stLoaSecGeral();
//                break;             
            case $this->stLoaSecGeral():
                return $this->stLoaConselho();
                break;                         
            default:
                return NULL;
                break;
        }
    }
    
    
    /**
     * Recebe os Perfis de um Usuario e retorna qual será os status que ele poderá visualizar
     * @param array $perfil
     */
    private function retornaStatusParaAutorizarPorPerfil(array $perfil){
                        
        $arrayTodosStatus = array($this->stLoaSalva()
                , $this->stLoaRetornada()
                , $this->stLoaEnviadaPeloPlanejamento()
                , $this->stLoaSecPlaGestao()
                , $this->stLoaSecAdmFinan()
                , $this->stLoaSecAteSaude()
                , $this->stLoaSecGeral()
                , $this->stLoaConselho()
        );
        
        $arrayPerfilTodos = array(
            PERFIL_TI
            , PERFIL_PLANEJAMENTO            
            , PERFIL_ZEUS
            , PERFIL_PLANEJAMENTO_ZEUS            
        );                        
        if(in_array(PERFIL_PLANEJAMENTO_SEC_ADJ_PLA_GESTAO, $perfil)){
            return array($this->stLoaEnviadaPeloPlanejamento());
        }elseif(in_array(PERFIL_PLANEJAMENTO_SEC_ADJ_ADM_FINAN, $perfil)){
            return array($this->stLoaSecPlaGestao());
        }elseif(in_array(PERFIL_PLANEJAMENTO_SEC_ADJ_ATE_SAUDE, $perfil)){
            return array($this->stLoaSecAdmFinan());
        }elseif(in_array(PERFIL_PLANEJAMENTO_SEC_GERAL, $perfil)){
            return array($this->stLoaSecAteSaude());
        }elseif(in_array(PERFIL_PLANEJAMENTO_CONSELHO, $perfil)){
            return array($this->stLoaSecGeral());
        }elseif(count(array_intersect($arrayPerfilTodos, $perfil)) > 0){
            return $arrayTodosStatus;
        }             
        return array(0);
    }
    
    
                              
    public function criar(){
        try {  
                                   
            if($this->aaPreLoa == "" || strlen($this->aaPreLoa) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $daoPL = new DaoPlaPreLoa();
           
            $daoPL->setAaPreLoa($this->aaPreLoa);
            $daoPL->setStPreLoa($this->stLoaSalva);
            
           
            //Verifica se Já existe alguma Pre Loa Cadastrada no Sistema para esse Ano
            $daoPL->verificaExistePorAno($pdo);
            if($daoPL->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já existe uma Prévia-LOA Cadastrada Para Este Ano."
                        . " Caso deseje Criar uma Nova, desative Primeiro."
                        . " Somente Uma Prévia-LOA por Ano pode estar Ativa.");
                $pdo->rollBack();
                return $retorno;
            }
            //Salva o Registro da Pre Loa
            $daoPL->insert($pdo);
            
            if(!$daoPL->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoPL->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPL->setIdPreLoa($pdo->lastInsertId('pla_pre_loa_id_pre_loa_seq'));            

            if (!Log::SalvaLogI('pla_pre_loa', $daoPL->getIdPreLoa(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            
            $daoPLH = new DaoPlaPreLoaHistorico();
            $daoPLH->setIdPreLoa($daoPL->getIdPreLoa());
            $daoPLH->setIdPessoa($this->idPessoa);
            $daoPLH->setStPreLoa($daoPL->getStPreLoa());
            $daoPLH->setDsPreLoaHistorico($this->dsPreLoaHistorico);
            
            //Salva o Registro do Historico de Mensagens
            $daoPLH->insert($pdo);
            if(!$daoPLH->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoPLH->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPLH->setIdPreLoaHistorico($pdo->lastInsertId('pla_pre_loa_historico_id_pre_loa_historico_seq'));            

            if (!Log::SalvaLogI('pla_pre_loa_historico', $daoPLH->getIdPreLoaHistorico(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            
            //Iremos fazer uma Busca na PAS e gerar os Valores que serão inseridos na Pre LOA
            $pas = new Pas();
            $pas->retornaValoresPreLOA((int)$daoPL->getAaPreLoa(), $pdo);
            
            if(!$pas->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $pas->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $result = $pas->getMsgRetorno();
            
            if(count($result) < 1){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível encontrar nenhuma PAS.");
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPLV = new DaoPlaPreLoaValores();
            $daoPLV->setIdPreLoa($daoPL->getIdPreLoa());            
            
            
            //Preparar os Dados Para Dar Insert
            foreach ($result as $key => $value) {
                                               
                //Seta os Campos para Salvar no Banco de Dados
                $daoPLV->setIdProgramaTrabalho($value['id_programa_trabalho']);
                $daoPLV->setIdDespesaElemento($value['id_despesa_elemento']);
                $daoPLV->setIdFonte($value['id_fonte']);
                $daoPLV->setVlPreLoaValores(number_format($value['valor'], 4, '.', ''));
                
                $daoPLV->insert($pdo);
                if(!$daoPLV->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoPLV->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                $daoPLV->setIdPreLoaValores($pdo->lastInsertId('pla_pre_loa_valores_id_pre_loa_valores_seq'));            

                if (!Log::SalvaLogI('pla_pre_loa_valores', $daoPLV->getIdPreLoaValores(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                
                
            }
            
                                                          
            $retorno = Metodos::retornoAjax("ok", "html", "Prévia-LOA Criada com Sucesso.");
            $pdo->commit();
            return $retorno;
                                                           
            
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
       
    public function salvar(){
        try {
                                                            
           
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                        
            $anoPassadoParametro = $this->aaPreLoa;
            
            //Verifica se existe alguma pre LOA para esse ano
            $this->verificaExisteCarregaDados($pdo);                                                        
            
            if(empty($this->getIdPreLoa())){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar a Prévia-LOA Válida.");
                $pdo->rollBack();
                return $retorno;
            }
            
            //Verifica se a Prévia-LOA está apta a receber alteração
            if(!$this->stPodeEnviarPlanejamento($this->stPreLoa)){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Alterar a Prévia-LOA pois ela está em processo de Autorização.");
                $pdo->rollBack();
                return $retorno;
            }
            
            if($anoPassadoParametro != $this->aaPreLoa){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Ano não corresponde a essa Prévia-LOA.".STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                        
            
            //Seta os Campos
            $dao = new DaoPlaPreLoaValores();
            
            //Verifica se é insert ou edição
            $inserir = 0;
            if($this->idPreLoaValores == "" 
                    || $this->idPreLoaValores == 0){                
                $inserir = 1;
                $dao->setIdPreLoaValores(NULL);
            }else{
                $dao->setIdPreLoaValores($this->idPreLoaValores);
            }
            
            $dao->setIdPreLoa($this->getIdPreLoa());
            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);       
            $dao->setIdDespesaElemento($this->idDespesaElemento);
            $dao->setIdFonte($this->idFonte);
            $dao->setVlPreLoaValores(Metodos::ConverteValorIng($this->vlPreLoaValores));            
            
            //Verificar se já exsite cadastrado essa Informação
            //Programa de Trabalho, Fonte, Elemento de Despesa Para esta Pre LOA
            $dao->verificaExisteCadastro($pdo);
            if($dao->Sucesso() && $inserir == 1){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe um Registro Desse Na Prévia-LOA, por favor faça a Edição do Registro.");
                $pdo->rollBack();
                return $retorno;
                //Caso seja Edição, ignorar se for o mesmo registro
            }else if($dao->Sucesso() 
                    && $inserir == 0
                    && $dao->getMsgRetorno()['id_pre_loa_valores'] != $dao->getIdPreLoaValores()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe um Registro Desse Na Prévia-LOA, por favor faça a Edição do Registro.");
                $pdo->rollBack();
                return $retorno;
            }
                                   
            
            if($inserir == 1){
                $dao->insert($pdo);
                if(!$dao->Sucesso()){                
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                $dao->setIdPreLoaValores($pdo->lastInsertId('pla_pre_loa_valores_id_pre_loa_valores_seq'));            

                if (Log::SalvaLogI('pla_pre_loa_valores', $dao->getIdPreLoaValores(), $pdo)) {
                    $sucesso = true;
                }else{
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            }else{
                $dao->retorna($pdo);
            
                if(!$dao->Sucesso()){                
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                $busca = $dao->getMsgRetorno();

                $dao->update($pdo);               
                if(!$dao->Sucesso()){                
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                if (!Log::SalvaLogU('pla_pre_loa_valores', $dao->getIdPreLoaValores(), $busca, $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }else{
                    $sucesso = true;
                }    
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            }
                                                                                     

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    
    
    
    public function removerRegistro(){
        try {
                                    
            if($this->idPreLoaValores == "" || $this->idPreLoaValores == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaPreLoaValores();            
            $dao->setIdPreLoaValores($this->idPreLoaValores);       
            
            $dao->retorna($pdo);
            
            
            if($dao->Sucesso()){                   
                $result = $dao->getMsgRetorno();  
                $dao->setIdPreLoa($result['id_pre_loa']);                
                $preLoa = new DaoPlaPreLoa();
                $preLoa->setIdPreLoa($dao->getIdPreLoa());
                $preLoa->retorna($pdo);
                
                if(!$preLoa->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar a Prévia-LOA.");
                    $pdo->rollBack();
                    return $retorno;
                }
                
                $preLoa->setAaPreLoa($preLoa->getMsgRetorno()['aa_pre_loa']);
                
                $this->setAaPreLoa($preLoa->getAaPreLoa());
                //Verifica se existe alguma pre LOA para esse ano
                $this->verificaExisteCarregaDados($pdo);                                                        

                if(empty($this->getIdPreLoa())){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar a Prévia-LOA Válida.");
                    $pdo->rollBack();
                    return $retorno;
                }

                //Verifica se a Prévia-LOA está apta a receber alteração
                if(!$this->stPodeEnviarPlanejamento($this->stPreLoa)){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Alterar a Prévia-LOA pois ela está em processo de Autorização.");
                    $pdo->rollBack();
                    return $retorno;
                }
                
                
                
                
                if (!Log::SalvaLogD('pla_pre_loa_valores', $dao->getIdPreLoaValores(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Registro.");
               $pdo->rollBack();
               return $retorno;
            }
            
            $dao->delete($pdo);
            if(!$dao->Sucesso()){            
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                                                                       

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    public function desativar(){
        try {
                                                            
           
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                        
            $anoPassadoParametro = $this->aaPreLoa;
            
            //Verifica se existe alguma pre LOA para esse ano
            $this->verificaExisteCarregaDados($pdo);                                                        
            
            if(empty($this->getIdPreLoa())){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar a Prévia-LOA Válida.");
                $pdo->rollBack();
                return $retorno;
            }
            
            $dao = new DaoPlaPreLoa();
            $dao->setIdPreLoa($this->getIdPreLoa());
                                                
            $dao->retorna($pdo);

            if(!$dao->Sucesso()){                
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            $busca = $dao->getMsgRetorno();

            $dao->desativa($pdo);               
            if(!$dao->Sucesso()){                
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('pla_pre_loa', $dao->getIdPreLoa(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }    
            
            $daoPLH = new DaoPlaPreLoaHistorico();
            $daoPLH->setIdPreLoa($this->getIdPreLoa());
            $daoPLH->setIdPessoa($this->idPessoa);
            $daoPLH->setStPreLoa(0);
            $daoPLH->setDsPreLoaHistorico($this->dsPreLoaHistorico);
            
                        
            //Salva o Registro do Historico de Mensagens
            $daoPLH->insert($pdo);
            if(!$daoPLH->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoPLH->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPLH->setIdPreLoaHistorico($pdo->lastInsertId('pla_pre_loa_historico_id_pre_loa_historico_seq'));            

            if (!Log::SalvaLogI('pla_pre_loa_historico', $daoPLH->getIdPreLoaHistorico(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            
            
            

            $retorno = Metodos::retornoAjax("ok", "html", "Prévia-LOA foi desativada com Sucesso.");
            $pdo->commit();
            return $retorno;
            
                                                                                     

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    /**
     * Irá enviar a PreLOA Para a proxima Autorização
     * @param array $perfil do usuário
     * @param string $acao Acao.. Autorizar ou Retornar
     * @return type
     */
    public function enviarProximaAutorizacao(array $perfil, string $acao){
        try {
                                                            
           
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $anoPassadoParametro = $this->aaPreLoa;
                        
            //Verifica se existe alguma pre LOA para esse ano
            $this->verificaExisteCarregaDados($pdo);                                                        
            
            if(empty($this->getIdPreLoa())){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar a Prévia-LOA Válida.");
                $pdo->rollBack();
                return $retorno;
            }
            
            //Verifica se o Perfil do Usuário corresponde a quem desejar mudar a situação da Prévia-LOA
            //Exemplo: Sec Adjunto de Planejamento e Gestão só pode Autorizar se o Status da Prévia-lOA
            //Estiver no Status de Enviado pelo Planejamento
                        
            $status = $this->retornaStatusParaAutorizarPorPerfil($perfil);
                                    
            if(!in_array($this->stPreLoa, $status)){
                $retorno = Metodos::retornoAjax("Erro", "alert", "A Situação da Prévia-LOA não condiz com a ação que deseja Realizar. Talez ela já esteja Autorizada.");
                $pdo->rollBack();
                return $retorno;
            }                        
            
//            if(!$this->verificaStatusPerfil($perfil, (int)$this->stPreLoa)){
//                $retorno = Metodos::retornoAjax("Erro", "alert", "A Situação da Prévia-LOA não condiz com a ação que deseja Realizar. Talez ela já esteja Autorizada.");
//                $pdo->rollBack();
//                return $retorno;
//            }
            
            $dao = new DaoPlaPreLoa();
            $dao->setIdPreLoa($this->getIdPreLoa());                                                
            
            if($acao == "autorizar"){
                //Verifica qual o próximo Status que deverá ser feito.
                $status = $this->retornaProximoStatus((int)$this->stPreLoa);                        
                $dao->setStPreLoa($status);
            }elseif($acao == "retornar"){
                $dao->setStPreLoa($this->stLoaRetornada());
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi possível identificar a ação.");
                $pdo->rollBack();
                return $retorno;
            }
                        
            $dao->retorna($pdo);

            if(!$dao->Sucesso()){        
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            $busca = $dao->getMsgRetorno();

            $dao->mudaStatus($pdo);               
            if(!$dao->Sucesso()){            
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('pla_pre_loa', $dao->getIdPreLoa(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }    
            
            $daoPLH = new DaoPlaPreLoaHistorico();
            $daoPLH->setIdPreLoa($this->getIdPreLoa());
            $daoPLH->setIdPessoa($this->idPessoa);
            $daoPLH->setStPreLoa($dao->getStPreLoa());
            $daoPLH->setDsPreLoaHistorico($this->dsPreLoaHistorico);
            
                        
            //Salva o Registro do Historico de Mensagens
            $daoPLH->insert($pdo);
            if(!$daoPLH->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoPLH->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPLH->setIdPreLoaHistorico($pdo->lastInsertId('pla_pre_loa_historico_id_pre_loa_historico_seq'));            

            if (!Log::SalvaLogI('pla_pre_loa_historico', $daoPLH->getIdPreLoaHistorico(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
                                    
            $retorno = Metodos::retornoAjax("ok", "html", "Ação realizada com Sucesso.");
            $pdo->commit();
            return $retorno;
            
                                                                                     

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * Retorna as Mensagens para um TextArea do Historico de uma Prévia-LOA
     * @return string
     */
    public function retornaMensagens(){
        $retorno = "";                
        try{
            $conexao = new Conexao();            
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoPlaPreLoaHistorico();
            $dao->setIdPreLoa($this->idPreLoa);
            
            $dao->retornaPorPreLoa($pdo);

            if(!$dao->Sucesso()){
                return $retorno;
            }else{
                                                
                $result = $dao->getMsgRetorno();
                foreach ($result as $value) {
                    $obj = $this->stTextoItem($value['st_pre_loa']);
                    $retorno .= $value['nm_pessoa']." às ".$value['dh_pre_loa_historico']." ".$obj->msgText. "".$value['ds_pre_loa_historico']."\n"; 
                }                                               
            }
            
            
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
            return $retorno;
        }                               
    }
    
    public function retornaDadosParaEdicao(){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaPreLoaValores();                       
            $dao->setIdPreLoaValores($this->idPreLoaValores);
            $dao->retorna($pdo);                                                   
            
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("nao_encontrou", "html", null);               
            }else{
                $retorno = $dao->getMsgRetorno();
                $retorno['vl_pre_loa_valores'] = Metodos::ConverteValorBr($retorno['vl_pre_loa_valores'], 4);                
                return Metodos::retornoAjax("ok", "html", $retorno);
            }                        
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    
    public function verificaExisteCarregaDados(PDO $pdo = null){
        
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoPlaPreLoa();                       
            $dao->setAaPreLoa($this->aaPreLoa);
            $dao->verificaExistePorAno($pdo);  
            
            if(!$dao->Sucesso()){
                
            }else{
               $result = $dao->getMsgRetorno();
               $this->idPreLoa = $result['id_pre_loa'];
               $this->aaPreLoa = $result['aa_pre_loa'];
               $this->stPreLoa = $result['st_pre_loa'];
            }                        
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    
    
    
    private function arrumaValoresPreLOA(array $result){
        $arrayDados = array();
        foreach ($result as $value) {                
            if(array_key_exists($value['id_programa_trabalho'], $arrayDados)){
                if(array_key_exists($value['id_despesa_elemento'], $arrayDados[$value['id_programa_trabalho']]["elementos"]  )){
                   $arrayDados[$value['id_programa_trabalho']] ["elementos"][$value['id_despesa_elemento']]['fontes'][$value['id_fonte']] = array(                                                                                                        
                            "fonte" => $value['nr_fonte'],
                            "valor" => $value['vl_pre_loa_valores'],
                            "id_pre_loa_valores" => $value['id_pre_loa_valores']
                    ); 

                }else{                                        
                    $arrayDados[$value['id_programa_trabalho']] ["elementos"][$value['id_despesa_elemento']] = array(                                
                                "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                                "valorTotal" => 0,
                                "fontes" => array($value['id_fonte'] => array( 
                                    "fonte" => $value['nr_fonte'],
                                    "valor" => $value['vl_pre_loa_valores'],
                                    "id_pre_loa_valores" => $value['id_pre_loa_valores']
                                )
                        )                        
                    );
                }

            }else{


                $arrayDados[$value['id_programa_trabalho']] = array(
                    "programa_trabalho" => $value['programa_trabalho'],
                    "ds_programa_trabalho" => $value['ds_programa_trabalho'],                       
                    "elementos" => array($value['id_despesa_elemento'] => array(                                
                        "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                        "valorTotal" => 0,
                        "fontes" => array($value['id_fonte'] => array( 
                            "fonte" => $value['nr_fonte'],
                            "valor" => $value['vl_pre_loa_valores'],
                            "id_pre_loa_valores" => $value['id_pre_loa_valores']
                        )))
                    )                        
                );   

                foreach (Metodos::getFontes() as $id => $fontes) {
                    $arrayDados[$value['id_programa_trabalho']]['fonte_'.$id] = 0;
                }
            }
        }



        //Arrumar os Valores
        foreach ($arrayDados as $key => $value) {
            $arrayDados[$key]['qtd_elementos'] = count($value['elementos'])+1;
            foreach ($value['elementos'] as $k1 => $v1) {
                $valorElemento = 0;
                foreach ($v1['fontes'] as $k2 => $v2) {
                    $arrayDados[$key]['fonte_'.$k2] += $v2['valor'];
                    $valorElemento += $v2['valor'];
                }                    
                $arrayDados[$key]['elementos'][$k1]['valorTotal'] = $valorElemento;

            }
        }
        
        
        
        
        
        return $arrayDados;
    }
    
    public function retornaValoresPreLOA(){
        $retorno = "";                
        try{
                                    
            if(strlen($this->aaPreLoa) != 4){
                return "Ano Inválido";
            }                        
                        
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $loa = new DaoPlaPreLoa();              
            $loa->setAaPreLoa($this->aaPreLoa);
            $loa->verificaExistePorAno($pdo);
            if(!$loa->Sucesso()){
                $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não foi Possível Localizar Nenhuma Prévia-LOA Cadastrada para este Ano.
                    </div>';
                return $retorno;
            }
            
            $resultLoa = $loa->getMsgRetorno();
            
            $loa->setIdPreLoa($resultLoa['id_pre_loa']);
            
            $valores = new DaoPlaPreLoaValores();
            $valores->setIdPreLoa($loa->getIdPreLoa());
            $valores->retornaValoresPorPreLoa($pdo);
            
            if(!$valores->Sucesso()){                
                $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não foi Possível Localizar Nenhuma Prévia-LOA Cadastrada para este Ano.
                    </div>';
                return $retorno;
            }
            
            $result = $valores->getMsgRetorno();
                                                        
            
            $arrayDados = array();
            
            $arrayDados = $this->arrumaValoresPreLOA($result);
            
                                                
            $retorno .= '<div class="panel panel-default">';                                                  
            
            $retorno .= '<table class="table table-bordered" id="tabela" cellspacing="0" width="100%">'                           
                    . '<tbody>';
            $valorTotal = 0;
            foreach (Metodos::getFontes() as $key => $value) {
                ${'fonte_'.$key} = 0;
            }            
            foreach ($arrayDados as $key => $value) {
                    $valorTotalPrograma = 0;
                                        
                    $retorno .= '<tr class="success text-bold">'
                                . '<td>Projeto/Atividade</td>'
                                . '<td>Programa de Trabalho</td>'
                                . '<td class="text-center">Despesa</td>'
                                . '<td class="text-center">Fonte 100</td>'
                                . '<td class="text-center">Fonte 200</td>'
                                . '<td class="text-center">Fonte 400</td>'
                                . '<td class="text-center">Fonte 500</td>'
                                . '<td class="text-center">Total</td>'
                            . '</tr>';
                    
                    //Inicio do Programa de Trabalho
                    $retorno .= "<tr>"
                                . "<td rowspan='".$value['qtd_elementos']."'>".$value['ds_programa_trabalho']."</td>"
                                . "<td rowspan='".$value['qtd_elementos']."'>".$value['programa_trabalho']."</td></tr>";
                                        
                        foreach ($value['elementos'] as $k2 => $v2) {
                            $retorno .= "<tr><td class='text-center'>".$v2['cd_despesa_elemento']."</td>";
                            foreach (Metodos::getFontes() as $k3 => $v3) {
                                if(array_key_exists($k3, $v2['fontes'])){
                                    $retorno .= "<td class='text-right'> R$ ".Metodos::ConverteValorBr($v2['fontes'][$k3]['valor'], 4)."</td>";
                                }else{
                                    $retorno .= "<td class='text-center'> - </td>";
                                }
                            }  
                            $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($v2['valorTotal'], 4)."</td></tr>";
                        }
                                                                                                    
                    $retorno .= "<tr class='success text-bold'>"
                            . "<td colspan='3'>Total</td>";
                    
                    foreach (Metodos::getFontes() as $k3 => $v3){
                        $valorTotalPrograma += $value['fonte_'.$k3];
                        ${'fonte_'.$k3} += $value['fonte_'.$k3];
                        $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($value['fonte_'.$k3], 4)."</td>";
                    }                    
                    $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalPrograma, 4)."</td>";                            
                    $retorno .= "</tr>";
                                                            
                    $retorno .= "<tr class='default'><td colspan='7'></td></tr>";
                   
            }
            
            $retorno .= "</tbody>";
            $retorno .= "<tfoot >"
                        . "<tr class='warning'>"
                            . "<th colspan='3'>Total</th>";
                    foreach (Metodos::getFontes() as $k3 => $v3) {
                        $valorTotal += ${'fonte_'.$k3};
                        $retorno .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr(${'fonte_'.$k3}, 4)."</th>";
                    }                                                                
                $retorno  .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                            
                        . "</tr>"
                    . "</tfoot>";
            $retorno .= "</table>";

            $retorno .= "</div>";
            
            return $retorno;
            
                                                                                                                           
        } catch (Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            $retorno = "";
        }                               
    }
    
    
    public function retornaValoresPreLOAParaEdicao(){
        $retorno = "";                
        try{
                                    
            if(strlen($this->aaPreLoa) != 4){
                return "Ano Inválido";
            }                        
                        
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $loa = new DaoPlaPreLoa();              
            $loa->setAaPreLoa($this->aaPreLoa);
            $loa->verificaExistePorAno($pdo);
            if(!$loa->Sucesso()){
                $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não foi Possível Localizar Nenhuma Prévia-LOA Cadastrada para este Ano.
                    </div>';
                return $retorno;
            }
            
            $resultLoa = $loa->getMsgRetorno();
            
            $loa->setIdPreLoa($resultLoa['id_pre_loa']);
            
            $valores = new DaoPlaPreLoaValores();
            $valores->setIdPreLoa($loa->getIdPreLoa());
            $valores->retornaValoresPorPreLoa($pdo);
            
            if(!$valores->Sucesso()){                
                $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não foi Possível Localizar Nenhuma Prévia-LOA Cadastrada para este Ano.
                    </div>';
                return $retorno;
            }
            
            $result = $valores->getMsgRetorno();
                                                        
            
            $arrayDados = array();
            
            $arrayDados = $this->arrumaValoresPreLOA($result);
            
                                                
            $retorno .= '<div class="panel panel-default">';                                                  
            
            $retorno .= '<table class="table table-bordered" id="tabela" cellspacing="0" width="100%">'                           
                    . '<tbody>';
            $valorTotal = 0;
            foreach (Metodos::getFontes() as $key => $value) {
                ${'fonte_'.$key} = 0;
            }            
            foreach ($arrayDados as $key => $value) {
                    $valorTotalPrograma = 0;
                                        
                    $retorno .= '<tr class="success text-bold">'
                                . '<td>Projeto/Atividade</td>'
                                . '<td>Programa de Trabalho</td>'
                                . '<td class="text-center">Despesa</td>'
                                . '<td class="text-center">Fonte 100</td>'
                                . '<td class="text-center">Fonte 200</td>'
                                . '<td class="text-center">Fonte 400</td>'
                                . '<td class="text-center">Fonte 500</td>'
                                . '<td class="text-center">Total</td>'
                            . '</tr>';
                    
                    //Inicio do Programa de Trabalho
                    $retorno .= "<tr>"
                                . "<td rowspan='".$value['qtd_elementos']."'>".$value['ds_programa_trabalho']."</td>"
                                . "<td rowspan='".$value['qtd_elementos']."'>".$value['programa_trabalho']."</td></tr>";
                                        
                        foreach ($value['elementos'] as $k2 => $v2) {
                            $retorno .= "<tr><td class='text-center'>".$v2['cd_despesa_elemento']."</td>";
                            foreach (Metodos::getFontes() as $k3 => $v3) {
                                if(array_key_exists($k3, $v2['fontes'])){
                                    $retorno .= "<td class='text-right registro' id='".$v2['fontes'][$k3]['id_pre_loa_valores']."' role='button'> R$ ".Metodos::ConverteValorBr($v2['fontes'][$k3]['valor'], 4)."</td>";
                                }else{
                                    $retorno .= "<td class='text-center'> - </td>";
                                }
                            }  
                            $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($v2['valorTotal'], 4)."</td></tr>";
                        }
                                                                                                    
                    $retorno .= "<tr class='success text-bold'>"
                            . "<td colspan='3'>Total</td>";
                    
                    foreach (Metodos::getFontes() as $k3 => $v3){
                        $valorTotalPrograma += $value['fonte_'.$k3];
                        ${'fonte_'.$k3} += $value['fonte_'.$k3];
                        $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($value['fonte_'.$k3], 4)."</td>";
                    }                    
                    $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalPrograma, 4)."</td>";                            
                    $retorno .= "</tr>";
                                                            
                    $retorno .= "<tr class='default'><td colspan='7'></td></tr>";
                   
            }
            
            $retorno .= "</tbody>";
            $retorno .= "<tfoot >"
                        . "<tr class='warning'>"
                            . "<th colspan='3'>Total</th>";
                    foreach (Metodos::getFontes() as $k3 => $v3) {
                        $valorTotal += ${'fonte_'.$k3};
                        $retorno .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr(${'fonte_'.$k3}, 4)."</th>";
                    }                                                                
                $retorno  .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                            
                        . "</tr>"
                    . "</tfoot>";
            $retorno .= "</table>";

            $retorno .= "</div>";
            
            return $retorno;
            
                                                                                                                           
        } catch (Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            $retorno = "";
        }                               
    }
    
    
    /**
     * Irá Receber um conjunto de Perfis para tentar Determinar qual Retorno o Usuário irá receber 
     * Para poder selecionar qual Prévia-LOA irá autorizar
     * @param int $idUser
     * @param array $perfis
     * @return string
     */
    public function retornaTabelaPreLoaAutorizar(int $idUser, array $perfis){
        $retorno = "";                
        try{
                                   
            //Retorna os Possiveis Perfis que o usuário poderá visualizar
            $status = $this->retornaStatusParaAutorizarPorPerfil($perfis);
            if(count($status) == 0){
                $retorno = "Não foi possível localizar nenhum perfil do usuário";
                return $retorno;  
            }             

            $arrayImplode = Metodos::implodeComAspas($status);
                                                    
            $conexao = new Conexao();            
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoPlaPreLoa();
            
            
            $dao->retornaPreLoaInStatus($arrayImplode, $pdo);

            if(!$dao->Sucesso()){  
                 $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não existe nenhuma Prévia-LOA para autorizar
                    </div>';
                return $retorno;
            }else{
                         
                $retorno .= '<div class="panel panel-default">';                                                  
            
                $retorno .= '<table class="table table-bordered table-striped" cellspacing="0" width="100%">'                           
                        . '<thead>'
                            . '<tr>'
                                . '<td>Ano</td>'
                                . '<td>Estado</td>'
                                . '<td>Situação</td>'
                            . '</tr>'
                        . '</thead>'
                        . '<tbody>';                                       
               
                $result = $dao->getMsgRetorno();
                foreach ($result as $value) {
                    $obj = $this->stTextoItem($value['st_pre_loa']);
                    
                     $retorno .= '<tr role="button" valor="'.$value['aa_pre_loa'].'" class="linha" >'
                                . '<td>'.$value['aa_pre_loa'].'</td>'
                                . '<td>'.$obj->msg.'</td>'
                                . '<td>'.$obj->aguardando.'</td>'                            
                            . '</tr>';                                        
                }   
                
                
                $retorno .= "</tbody>"
                        . "</table>";
                $retorno .= "</div>";
            }
            
            
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
            return $retorno;
        }                               
    }
    
    
    /**
     * Retorna todos os Anos que existem Prévia-LOAs Ativo
     * @return string
     */
    public function retornaAnosQueExiste(){
        $retorno = "";                
        try{
                                                                                                   
            $conexao = new Conexao();            
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoPlaPreLoa();
            
            
            $dao->retornaTodosAnos($pdo);

            if(!$dao->Sucesso()){  
                 $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não foi possível achar nenhuma Prévia-LOA
                    </div>';
                return $retorno;
            }else{
                         
                $retorno .= '<div class="panel panel-default">';                                                  
            
                $retorno .= '<table class="table table-bordered table-striped" cellspacing="0" width="100%">'                           
                        . '<thead>'
                            . '<tr>'
                                . '<td>Ano</td>'                                
                            . '</tr>'
                        . '</thead>'
                        . '<tbody>';                                       
               
                $result = $dao->getMsgRetorno();
                foreach ($result as $value) {                    
                    
                     $retorno .= '<tr role="button" valor="'.$value['aa_pre_loa'].'" class="linhaAno" >'
                                . '<td>'.$value['aa_pre_loa'].'</td>'                                                         
                            . '</tr>';                                        
                }                   
                
                $retorno .= "</tbody>"
                        . "</table>";
                $retorno .= "</div>";
            }
            
            
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
            return $retorno;
        }                               
    }
    
    
   
                                       
}

?>
