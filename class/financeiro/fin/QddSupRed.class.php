<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinQddSupRed.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinQddSupRedTrans.class.php";

class QddSupRed {
    
    private $idQddSupRed = null;
    private $idQdd = null;
    private $idPessoa = null;    
    private $dsQddSupRed = null;
    private $tpQddSupRed = null;
    private $dhQddSupRed = null;
    private $stQddSupRed = null;
    private $idPessoaSt = null;
    
    private $idQddValor = null;
    private $vlQddSupRedTrans = null;
    private $tpQddSupRedTrans = null;
    
    
    function getStQddSupRed() {
        return $this->stQddSupRed;
    }

    function getIdPessoaSt() {
        return $this->idPessoaSt;
    }

    function setStQddSupRed($stQddSupRed) {
        $this->stQddSupRed = $stQddSupRed;
        return $this;
    }

    function setIdPessoaSt($idPessoaSt) {
        $this->idPessoaSt = $idPessoaSt;
        return $this;
    }
        
    function getDhQddSupRed() {
        return $this->dhQddSupRed;
    }

    function setDhQddSupRed($dhQddSupRed) {
        $this->dhQddSupRed = $dhQddSupRed;
        return $this;
    }
        
    function getIdQdd() {
        return $this->idQdd;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDsQddSupRed() {
        return $this->dsQddSupRed;
    }

    function getTpQddSupRed() {
        return $this->tpQddSupRed;
    }

    function getIdQddSupRed() {
        return $this->idQddSupRed;
    }

    function getIdQddValor() {
        return $this->idQddValor;
    }

    function getVlQddSupRedTrans() {
        return $this->vlQddSupRedTrans;
    }

    function getTpQddSupRedTrans() {
        return $this->tpQddSupRedTrans;
    }

    function setIdQdd($idQdd) {
        $this->idQdd = $idQdd;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setDsQddSupRed($dsQddSupRed) {
        $this->dsQddSupRed = $dsQddSupRed;
        return $this;
    }

    function setTpQddSupRed($tpQddSupRed) {
        $this->tpQddSupRed = $tpQddSupRed;
        return $this;
    }

    function setIdQddSupRed($idQddSupRed) {
        $this->idQddSupRed = $idQddSupRed;
        return $this;
    }

    function setIdQddValor($idQddValor) {
        $this->idQddValor = $idQddValor;
        return $this;
    }

    function setVlQddSupRedTrans($vlQddSupRedTrans) {
        $this->vlQddSupRedTrans = $vlQddSupRedTrans;
        return $this;
    }

    function setTpQddSupRedTrans($tpQddSupRedTrans) {
        $this->tpQddSupRedTrans = $tpQddSupRedTrans;
        return $this;
    }       
    
    
    /**
     * Salvar a Suplementado e Reduzido   
     * Se o inicial for reduzido o sistema entende que os registros são suplementação
     * Se o inicial for suplementado o sistema entende que os registro são redução  
     * @param array $inicial Compoe o Dado que irá ser iniciado a transação, é obrigatório.
     * @param array $registros Registros que podem conter os Dados que serão suplementados ou reduzidos, não obrigatório.
     * @param int $ano
     * @return type
     */
    public function salvar(array $inicial, array $registros = null, int $ano){
        
        try {  
                        
            //Parte Inicial é Obrigatória
            if( (!is_array($inicial) || count($inicial) < 1) 
                    || strlen((string)$ano) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }                        
                                    
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();            
            $pdo->beginTransaction();
            
            //Procurar Informação do QDD
            $qdd = new Qdd();
            $qdd->setAaQdd($ano);
            $qdd->verificaExisteCarregaDados($pdo);
            if(empty($qdd->getIdQdd())){
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o QDD.");
            }
            
            //Seta os Campos para cadastrar o Qdd Sup Red
            $this->idQdd = $qdd->getIdQdd();
            $this->dsQddSupRed = trim($inicial['obs']);
            $this->tpQddSupRed = strtoupper($inicial['tipo']);            
            if($this->tpQddSupRed != "S" && $this->tpQddSupRed != "R"){
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Tipo de Requisição. Suplementado ou Reduzido.");
            }
            
            
            $suplementado = TRUE;
            $textoTipo = "Suplementado";
            $textoTipoContra = "Reduzido";
            $tipoContra = "R";
            if($this->tpQddSupRed == "R"){
                $suplementado = FALSE;
                $textoTipo = "Reduzido";
                $textoTipoContra = "Suplementado";
                $tipoContra = "S";
            }
            
            //Verifica se Contem Registros que são o contrario do Inicial.
            $contemRegistros = TRUE;
            if(!is_array($registros) || count($registros) < 1 || $registros == null){
                $contemRegistros = FALSE;
            }
            
                        
            $qddValor = new QddValor();
            $qddValor->setIdProgramaTrabalho((int)$inicial['programa']);
            $qddValor->setIdFonte((int)$inicial['fonte']);
            $qddValor->setIdDespesaElemento((int)$inicial['despesa']);
            $qddValor->setIdQdd($qdd->getIdQdd());
            $qddValor->carregaDadosQddFonteProgDespesa($pdo);
            if(empty($qddValor->getIdQddValor())){
                return Metodos::retornoAjax("Erro", "alert", "Não foi encontrado Para o Programa, Fonte e Despesa "
                        . "no QDD o Registro para o ".$textoTipo.". É Necesário que se tenha uma Dotação Inicial.");
            }
            
            $this->idQddValor = $qddValor->getIdQddValor();
            $this->vlQddSupRedTrans = Metodos::ConverteValorIng($inicial['valor']);
            $this->tpQddSupRedTrans = $this->tpQddSupRed;
            
            
            //Se existe algum Registro, iremos verifica se o Inicial existe em algum Registro
            //Caso exista, abortar.
            $valorTotalRegistros = 0;
            if($contemRegistros){
                foreach ($registros as $value) {
                    $valorTotalRegistros += Metodos::ConverteValorIng($value['valor']);
                    if($value['programa'] == $qddValor->getIdProgramaTrabalho()
                            && $value['fonte'] == $qddValor->getIdFonte()
                            && $value['despesa'] == $qddValor->getIdDespesaElemento()){
                        return Metodos::retornoAjax("Erro", "alert", "Um Mesmo Programa de Trabalho, Fonte e Despesa "
                                . "não pode sofrer a Suplementação e Redução. Remova o Registro Duplicado.");
                    }
                }
                //A Soma dos Registros devem ser igual a Valor do Inicial            
                if($this->vlQddSupRedTrans != $valorTotalRegistros){
                    return Metodos::retornoAjax("Erro", "alert", "O Valor do ".$textoTipo." tem que ser igual a soma dos Valores do ".$textoTipoContra." ");
                }
            }                                    
            
            //Se suplementado for false, então ele irá reduzir
            //Assim precisamos verificar se o saldo não irá ficar negativo.
            if(!$suplementado){
                if( ($qddValor->getVlSaldo() - $this->vlQddSupRedTrans) < 0 ){
                    return Metodos::retornoAjax("Erro", "alert", "Ação não realizada, pois ao fazer essa operação"
                            . " de Reduzido o Saldo de R$ ". Metodos::ConverteValorBr($qddValor->getVlSaldo(), 2)." irá ficar Negativo.");
                }
            }
            
            
            
            
            //Arruma os Registros 
            if($contemRegistros){             
                $classeRegistros = array();                
                foreach ($registros as $value) {                  
                    $qddValorAux = new QddValor();
                    $qddValorAux->setIdProgramaTrabalho((int)$value['programa']);
                    $qddValorAux->setIdFonte((int)$value['fonte']);
                    $qddValorAux->setIdDespesaElemento((int)$value['despesa']);
                    $qddValorAux->setIdQdd($qdd->getIdQdd());
                    $qddValorAux->carregaDadosQddFonteProgDespesa($pdo);
                    if(empty($qddValorAux->getIdQddValor())){            
                        return Metodos::retornoAjax("Erro", "alert", "Não foi encontrado Para o Programa, Fonte e Despesa "
                        . "no QDD o Registro para o ".$textoTipoContra.". É Necesário que se tenha uma Dotação Inicial.");
                    }
                    $qddValorAux->setValor(Metodos::ConverteValorIng($value['valor']));
                    //Se o inicial for suplementado, então os Registros serão os reduzidos
                    //Se os Registros forem Redução
                    //Precisa Verificar se eles não ficarão negativos
                    if($suplementado){   
                        if( ($qddValorAux->getVlSaldo() - $qddValorAux->getValor()) < 0 ){
                            return Metodos::retornoAjax("Erro", "alert", "Ação não realizada, pois ao fazer essa operação"
                                . " de Reduzido o Saldo de R$ ". Metodos::ConverteValorBr($qddValorAux->getVlSaldo(), 2)." irá ficar Negativo.");
                        }
                    }
                    $classeRegistros[] = $qddValorAux;
                }                
            }
                                    
            
            //Tudas as Validações foram Feitas, Rodar os  Inserts
            
            $daoSupRed = new DaoFinQddSupRed();
            $daoSupRed->setIdPessoa($this->idPessoa);
            $daoSupRed->setIdQdd($qdd->getIdQdd());
            $daoSupRed->setDsQddSupRed($this->dsQddSupRed);
            $daoSupRed->setTpQddSupRed($this->tpQddSupRed);
            $daoSupRed->insert($pdo);
            if(!$daoSupRed->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoSupRed->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoSupRed->setIdQddSupRed($pdo->lastInsertId('fin_qdd_sup_red_id_qdd_sup_red_seq'));            

            if (!Log::SalvaLogI('fin_qdd_sup_red', $daoSupRed->getIdQddSupRed(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }    
            
            //Dao para o Inicial
            $daoSupRedTrans = new DaoFinQddSupRedTrans();
            $daoSupRedTrans->setIdQddSupRed($daoSupRed->getIdQddSupRed());
            $daoSupRedTrans->setIdQddValor($qddValor->getIdQddValor());
            $daoSupRedTrans->setVlQddSupRedTrans($this->vlQddSupRedTrans);
            $daoSupRedTrans->setTpQddSupRedTrans($this->tpQddSupRedTrans);
            $daoSupRedTrans->insert($pdo);
            if(!$daoSupRedTrans->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoSupRedTrans->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoSupRedTrans->setIdQddSupRedTrans($pdo->lastInsertId('fin_qdd_sup_red_trans_id_qdd_sup_red_trans_seq'));            

            if (!Log::SalvaLogI('fin_qdd_sup_red_trans', $daoSupRedTrans->getIdQddSupRedTrans(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Atualiza o QddValor com o Valor Novo do Suplementado ou Reduzido
            //Como irá ter uma validação agora, o QDD Não será atualizado editado nesse momento
            //Foi Modificado dias antes da implatação
            /*if($suplementado){
                $qddValor->setVlQddSuplementado($qddValor->getVlQddSuplementado()+$this->vlQddSupRedTrans);                
            }else{
                $qddValor->setVlQddReduzido($qddValor->getVlQddReduzido()+$this->vlQddSupRedTrans);
            }
            $qddValor->alterarSuplementadoReduzido($this->tpQddSupRed, $pdo);
            if(!$qddValor->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $qddValor->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }*/
            $arrayParaAtualizar = array();
            if(!$suplementado){
                $qddValor->setVlBloqueado($qddValor->getVlBloqueado()+$this->vlQddSupRedTrans);
                $qddValor->alterarBloqueado($pdo);
                if(!$qddValor->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $qddValor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
                $arrayParaAtualizar[] = $qddValor->getIdQddValor();
            }
            
                                    
            //Dao para os Registros
            if($contemRegistros){ 
                foreach ($classeRegistros as $value) {
                    $daoSupRedTrans = new DaoFinQddSupRedTrans();                
                    $daoSupRedTrans->setIdQddSupRed($daoSupRed->getIdQddSupRed());
                    $daoSupRedTrans->setIdQddValor($value->getIdQddValor());
                    $daoSupRedTrans->setVlQddSupRedTrans($value->getValor());
                    $daoSupRedTrans->setTpQddSupRedTrans($tipoContra);
                    $daoSupRedTrans->insert($pdo);
                    if(!$daoSupRedTrans->Sucesso()){
                        $retorno = Metodos::retornoAjax("Erro", "console", $daoSupRedTrans->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }

                    $daoSupRedTrans->setIdQddSupRedTrans($pdo->lastInsertId('fin_qdd_sup_red_trans_id_qdd_sup_red_trans_seq'));            

                    if (!Log::SalvaLogI('fin_qdd_sup_red_trans', $daoSupRedTrans->getIdQddSupRedTrans(), $pdo)) {
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }

                    //Atualiza o QddValor com o Valor Novo do Suplementado ou Reduzido
                    if($suplementado){                 
                        $value->setVlBloqueado($value->getVlBloqueado()+$value->getValor());                        
                        $value->alterarBloqueado($pdo);                              
                        if(!$value->Sucesso()){
                            $retorno = Metodos::retornoAjax("Erro", "console", $value->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                        }      
                        $arrayParaAtualizar[] = $value->getIdQddValor();
                        
                    }
                    
                }
            }
            if(count($arrayParaAtualizar) > 0 && !empty($arrayParaAtualizar)){     
                
                $qddValor->atualizaValoresPorArray($arrayParaAtualizar, $pdo);
                if(!$qddValor->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $qddValor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }
                 
            
            $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            $pdo->commit();
            return $retorno;
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    public function carregaDados(PDO $pdo = null){        
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinQddSupRed();                       
            $dao->setIdQddSupRed($this->idQddSupRed);
            $dao->retorna($pdo);  
            
            if(!$dao->Sucesso()){
                
            }else{
               $result = $dao->getMsgRetorno();
               $this->idQddSupRed = $result['id_qdd_sup_red'];
               $this->idQdd = $result['id_qdd'];
               $this->idPessoa = $result['id_pessoa'];
               $this->dhQddSupRed = $result['dh_qdd_sup_red'];
               $this->dsQddSupRed = $result['ds_qdd_sup_red'];
               $this->tpQddSupRed = $result['tp_qdd_sup_red'];
               $this->stQddSupRed = $result['st_qdd_sup_red'];
               $this->idPessoaSt = $result['id_pessoa_st'];
               
            }                        
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    /**
     *      
     * @param int $validacao
     * @return type
     */
    public function validar(int $idPessoaSt, int $validacao){
        
        try {  
                        
            //Parte Inicial é Obrigatória
            if( (empty($this->idQddSupRed) || ($validacao != 1 && $validacao != 0)
                    || empty($idPessoaSt))){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }                        
                                    
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                        
            $this->carregaDados($pdo);
            if(empty($this->idQdd)){
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");
            }
            
                        
            if(!empty($this->stQddSupRed)){
                return Metodos::retornoAjax("Erro", "alert", "Esse Registro Já foi Validado.");
            }
            
            $dao = new DaoFinQddSupRed();
            $dao->setIdQddSupRed($this->idQddSupRed);            
            //Saber se foi Validado ou não pelo usuario.
            //1 - Representa que foi Validado com Sucesso
            //2 - Representa que não foi Validado, recusado.
            $acaoValidacao = "";
            if($validacao == 1){
                $this->stQddSupRed = 1;
                $acaoValidacao = TRUE;
            }else{
                $acaoValidacao = FALSE;
                $this->stQddSupRed = 2;
            }
            
            $dao->retorna($pdo);
            if(!$dao->Sucesso()){
                $pdo->rollBack();                
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            }
            $busca = $dao->getMsgRetorno();
            
            $dao->setStQddSupRed($this->stQddSupRed);
            
            $dao->setIdPessoaSt($idPessoaSt);            
            
            //Atualiza o Qdd Sup Red para quem fez a validacao e o Status dela.
            $dao->updateValidacao($pdo);
            if(!$dao->Sucesso()){                
                $pdo->rollBack();                
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível atualizar o Registro.");
            }
            
            if (!Log::SalvaLogU('fin_qdd_sup_red', $dao->getIdQddSupRed(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
                                    
            //Localiza as Transações para atualizar o Qdd
            $qddSupRedTrans = new DaoFinQddSupRedTrans();
            $qddSupRedTrans->setIdQddSupRed($this->idQddSupRed);
            $qddSupRedTrans->retornaPorSupRed($pdo);
            if(!$qddSupRedTrans->Sucesso()){
                $pdo->rollBack(); 
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar as Transações.");
            }
            
            $result = $qddSupRedTrans->getMsgRetorno();                       
                        
            $arrayParaAtualizar = array();
            
            foreach ($result as $key => $value) {
                $daoQddValor = new QddValor();
                $daoQddValor->setIdQddValor($value['id_qdd_valor']);
                //se a Transação for Suplementado, então basta pegar o suplementado atual, somar e atualizar.
                if($value['tp_qdd_sup_red_trans'] == "S" && $acaoValidacao){                    
                    $daoQddValor->setVlQddSuplementado($value['vl_qdd_suplementado']+$value['vl_qdd_sup_red_trans']);
                    $daoQddValor->alterarSuplementadoReduzido("S", $pdo);                    
                    if(!$daoQddValor->Sucesso()){
                        $pdo->rollBack(); 
                        return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Atualizar o Suplementado do QDD.");
                    }
                    $arrayParaAtualizar[] = $value['id_qdd_valor'];
                //Se a transação for Reduzido e a ação for para Validar
                //Então, se deve diminuir o valor do bloqueado com a da transação
                //E Somar no Reduzido
                }elseif($value['tp_qdd_sup_red_trans'] == "R" && $acaoValidacao){
                    $daoQddValor->setVlBloqueado($value['vl_bloqueado'] - $value['vl_qdd_sup_red_trans']);
                    $daoQddValor->setVlQddReduzido($value['vl_qdd_reduzido'] + $value['vl_qdd_sup_red_trans']);
                    if($daoQddValor->getVlBloqueado() < 0){
                        $pdo->rollBack(); 
                        return Metodos::retornoAjax("Erro", "alert", STR_ERROR." O Valor do Bloqueado ficará Menor que 0.");
                    }
                    $daoQddValor->alterarSuplementadoReduzido("R", $pdo);
                    if(!$daoQddValor->Sucesso()){
                        $pdo->rollBack(); 
                        return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Atualizar o Reduzido do QDD.");
                    }
                    $arrayParaAtualizar[] = $value['id_qdd_valor'];
                //Se a transação for Reduzido e a ação for para não validar
                //Então, se deve diminuir o valor do bloqueado com a da transação
                //E Não precisa somar no Reduzido
                }elseif($value['tp_qdd_sup_red_trans'] == "R" && !$acaoValidacao){
                    $daoQddValor->setVlBloqueado($value['vl_bloqueado'] - $value['vl_qdd_sup_red_trans']);                    
                    if($daoQddValor->getVlBloqueado() < 0){
                        $pdo->rollBack(); 
                        return Metodos::retornoAjax("Erro", "alert", STR_ERROR." O Valor do Bloqueado ficará Menor que 0.");
                    }
                    $daoQddValor->alterarSuplementadoReduzido("R", $pdo);
                    if(!$daoQddValor->Sucesso()){
                        $pdo->rollBack(); 
                        return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Atualizar o Bloqueado do QDD.");
                    }
                    
                    $arrayParaAtualizar[] = $value['id_qdd_valor'];
                }
            }
                        
                                           
            $qddValor = new QddValor();                                            
            if(count($arrayParaAtualizar) > 0 && !empty($arrayParaAtualizar)){                
                $qddValor->atualizaValoresPorArray($arrayParaAtualizar, $pdo);
                if(!$qddValor->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $qddValor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }
                        
            $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            $pdo->commit();
            return $retorno;
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
        
    
    public function retornaTrComSupRed(int $ano, PDO $pdo = null){        
        $retorno = "";
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $qdd = new Qdd();
            $qdd->setAaQdd($ano);
            $qdd->verificaExisteCarregaDados($pdo);
            if(empty($qdd->getIdQdd())){
                return $retorno;                
            }
            
            $this->idQdd = $qdd->getIdQdd();
            $dao = new DaoFinQddSupRed();
            $dao->setIdQdd($qdd->getIdQdd());
            $dao->retornaSupRedETrans($pdo);
            if(!$dao->Sucesso()){                
                return $retorno;
            }
            
            $result = $dao->getMsgRetorno();
            if(count($result) < 1){
                return $retorno;
            }
            $arrayDados = array();
            
            foreach ($result as $key => $value) {
                
                if(array_key_exists($value['id_qdd_sup_red'], $arrayDados)){
                    if($value['tp_qdd_sup_red'] == $value['tp_qdd_sup_red_trans']){
                        $arrayDados[$value['id_qdd_sup_red']]['origem'] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }else{
                        $arrayDados[$value['id_qdd_sup_red']]['destino'][] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }
                    
                }else{
                    $arrayDados[$value['id_qdd_sup_red']] = array(
                        "dh_qdd_sup_red" => $value['dh_qdd_sup_red'],
                        "tp_qdd_sup_red" => $value['tp_qdd_sup_red'],
                        "ds_qdd_sup_red" => $value['ds_qdd_sup_red'],
                        "nm_pessoa" => $value['nm_pessoa'],
                        "st_qdd_sup_red" => $value['st_qdd_sup_red'],
                        "nm_pessoa_st" => $value['nm_pessoa_st'],
                        "origem" => "",
                        "destino" => ""
                    );
                    if($value['tp_qdd_sup_red'] == $value['tp_qdd_sup_red_trans']){
                        $arrayDados[$value['id_qdd_sup_red']]['origem'] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }else{
                        $arrayDados[$value['id_qdd_sup_red']]['destino'][] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }
                    
                }
                
            }
 
            
            foreach ($arrayDados as $value) {                                                

                $tipo =  ($value['tp_qdd_sup_red'] == "S") ? "Suplementado" : "Reduzido";
                $retorno .= "<tr>";
                $retorno .= "<td>".$value['dh_qdd_sup_red']."</td>"
                        . "<td class='text-center'>".$tipo."</td>"
                        . "<td>".$value['nm_pessoa']."</td>"
                        . "<td>".$value['origem']['programa'].""
                            . "<br/>Fonte: ".$value['origem']['fonte'].""
                            . "<br/>Despesa: ".$value['origem']['cd_despesa_elemento'].""
                            . "<br/>Valor: ".$value['origem']['vl_qdd_sup_red_trans'].""
                        . "</td>";
                if(count($value['destino']) > 0 && !empty($value['destino'])){
                    $retorno .= "<td>";
                    foreach ($value['destino'] as $v) {
                        $retorno .= "".$v['programa'].""
                            . "<br/>Fonte: ".$v['fonte'].""
                            . "<br/>Despesa: ".$v['cd_despesa_elemento'].""
                            . "<br/>Valor: ".$v['vl_qdd_sup_red_trans'].""
                            . "<br/><hr>";                        
                    }        
                    $retorno .= "</td>";
                }else{
                    $retorno .= "<td></td>";
                }
                if(empty($value['st_qdd_sup_red'])){
                    $cor = "warning";
                    $texto = "Esperando Validação";
                }elseif($value['st_qdd_sup_red'] == 1){
                    $cor = "success";
                    $texto = "Validado";
                }elseif($value['st_qdd_sup_red'] == 2){
                    $cor = "danger";
                    $texto = "Não Validado";
                }else{
                    $cor = "default";
                    $texto = "Erro";
                }
                
                $retorno .= "<td class='text-center' title='".$value['nm_pessoa_st']."'><span class='label label-".$cor."'>".$texto."</span></td>";
                $retorno .= "</tr>";
                                                             
            }
          
            
            return $retorno;
                              
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function retornaTrComSupRedParaValidar(int $ano, PDO $pdo = null){
        $retorno = "";
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $qdd = new Qdd();
            $qdd->setAaQdd($ano);
            $qdd->verificaExisteCarregaDados($pdo);
            if(empty($qdd->getIdQdd())){
                return $retorno;                
            }
            
            $this->idQdd = $qdd->getIdQdd();
            $dao = new DaoFinQddSupRed();
            $dao->setIdQdd($qdd->getIdQdd());
            $dao->retornaSupRedParaValidar($pdo);
            if(!$dao->Sucesso()){                
                return $retorno;
            }
            
            $result = $dao->getMsgRetorno();
            
            if(count($result) < 1){
                return $retorno;
            }
            $arrayDados = array();
            
            foreach ($result as $key => $value) {
                
                if(array_key_exists($value['id_qdd_sup_red'], $arrayDados)){
                    if($value['tp_qdd_sup_red'] == $value['tp_qdd_sup_red_trans']){
                        $arrayDados[$value['id_qdd_sup_red']]['origem'] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }else{
                        $arrayDados[$value['id_qdd_sup_red']]['destino'][] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }
                    
                }else{
                    $arrayDados[$value['id_qdd_sup_red']] = array(
                        "dh_qdd_sup_red" => $value['dh_qdd_sup_red'],
                        "tp_qdd_sup_red" => $value['tp_qdd_sup_red'],
                        "ds_qdd_sup_red" => $value['ds_qdd_sup_red'],
                        "nm_pessoa" => $value['nm_pessoa'],                        
                        "origem" => "",
                        "destino" => ""
                    );
                    if($value['tp_qdd_sup_red'] == $value['tp_qdd_sup_red_trans']){
                        $arrayDados[$value['id_qdd_sup_red']]['origem'] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }else{
                        $arrayDados[$value['id_qdd_sup_red']]['destino'][] = array(
                            "programa" => $value['cd_programa_trabalho']." - ".$value['ds_programa_trabalho'],
                            "fonte" => $value['nr_fonte'],
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "vl_qdd_sup_red_trans" => "R$ ".Metodos::ConverteValorBr($value['vl_qdd_sup_red_trans'], 2)
                        );
                    }
                    
                }
                
            }
 
            
            foreach ($arrayDados as $key => $value) {                                                

                $tipo =  ($value['tp_qdd_sup_red'] == "S") ? "Suplementado" : "Reduzido";
                $retorno .= "<tr>";
                $retorno .= "<td>".$value['dh_qdd_sup_red']."</td>"
                        . "<td class='text-center'>".$tipo."</td>"
                        . "<td>".$value['nm_pessoa']."</td>"
                        . "<td>".$value['origem']['programa'].""
                            . "<br/>Fonte: ".$value['origem']['fonte'].""
                            . "<br/>Despesa: ".$value['origem']['cd_despesa_elemento'].""
                            . "<br/>Valor: ".$value['origem']['vl_qdd_sup_red_trans'].""
                        . "</td>";
                if(count($value['destino']) > 0 && !empty($value['destino'])){
                    $retorno .= "<td>";
                    foreach ($value['destino'] as $v) {
                        $retorno .= "".$v['programa'].""
                            . "<br/>Fonte: ".$v['fonte'].""
                            . "<br/>Despesa: ".$v['cd_despesa_elemento'].""
                            . "<br/>Valor: ".$v['vl_qdd_sup_red_trans'].""
                            . "<br/><hr>";                        
                    }        
                    $retorno .= "</td>";
                }else{
                    $retorno .= "<td></td>";
                }
               
                
                $retorno .= "<td class='text-center'>"
                        . "<button type='button' class='btn btn-default btn-nao-validar btn-xs' title='Não Validar' value='".$key."'>"
                            . "<i class='fa fa-thumbs-o-down fa-lg text-danger' aria-hidden='true'></i>"
                        . "</button> "
                        . "<button type='button' class='btn btn-default btn-validar btn-xs' title='Validar' value='".$key."'>"
                            . "<i class='fa fa-thumbs-o-up fa-lg text-success' aria-hidden='true'></i>"
                        . "</button>"                           
                        . "</td>";
                $retorno .= "</tr>";
                                                             
            }
          
            
            return $retorno;
                              
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
        
   
	
}