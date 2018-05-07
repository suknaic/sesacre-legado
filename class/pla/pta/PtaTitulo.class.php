<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPtaTitulo.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";


class PtaTitulo{
    
    private $idPtaTitulo = null;
    private $idPta = null;    
    private $nmPtaTitulo = null;           
    private $idProgramaTrabalho = null;
    private $idPpaProjAti = null;
    private $dsObjeto = null;
    private $dsJustificativa = null;    
    private $idPas = null;    
    private $nmPas = null;
    private $nmPta = null;
    private $dtInicio = null;
    private $dtFim = null;
    private $dsProgramaTrabalho = null;
    private $programaTrabalho = null;
    private $nmPpaProjAti = null;
    private $nmLotacao = null;
    private $idLotacao = null;
    
    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }
        
    function getDsProgramaTrabalho() {
        return $this->dsProgramaTrabalho;
    }

    function setDsProgramaTrabalho($dsProgramaTrabalho) {
        $this->dsProgramaTrabalho = $dsProgramaTrabalho;
        return $this;
    }
        
    function getNmPas() {
        return $this->nmPas;
    }

    function getNmPta() {
        return $this->nmPta;
    }

    function getDtInicio() {
        return $this->dtInicio;
    }

    function getDtFim() {
        return $this->dtFim;
    }

    function getProgramaTrabalho() {
        return $this->programaTrabalho;
    }

    function getNmPpaProjAti() {
        return $this->nmPpaProjAti;
    }

    function getNmLotacao() {
        return $this->nmLotacao;
    }

    function setNmPas($nmPas) {
        $this->nmPas = $nmPas;
        return $this;
    }

    function setNmPta($nmPta) {
        $this->nmPta = $nmPta;
        return $this;
    }

    function setDtInicio($dtInicio) {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    function setDtFim($dtFim) {
        $this->dtFim = $dtFim;
        return $this;
    }

    function setProgramaTrabalho($programaTrabalho) {
        $this->programaTrabalho = $programaTrabalho;
        return $this;
    }

    function setNmPpaProjAti($nmPpaProjAti) {
        $this->nmPpaProjAti = $nmPpaProjAti;
        return $this;
    }

    function setNmLotacao($nmLotacao) {
        $this->nmLotacao = $nmLotacao;
        return $this;
    }
        
    function getIdPtaTitulo() {
        return $this->idPtaTitulo;
    }

    function getIdPta() {
        return $this->idPta;
    }

    function getNmPtaTitulo() {
        return $this->nmPtaTitulo;
    }

    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getIdPpaProjAti() {
        return $this->idPpaProjAti;
    }

    function getDsObjeto() {
        return $this->dsObjeto;
    }

    function getDsJustificativa() {
        return $this->dsJustificativa;
    }

    function getIdPas() {
        return $this->idPas;
    }

    function setIdPtaTitulo($idPtaTitulo) {
        $this->idPtaTitulo = $idPtaTitulo;
        return $this;
    }

    function setIdPta($idPta) {
        $this->idPta = $idPta;
        return $this;
    }

    function setNmPtaTitulo($nmPtaTitulo) {
        $this->nmPtaTitulo = $nmPtaTitulo;
        return $this;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
        return $this;
    }

    function setIdPpaProjAti($idPpaProjAti) {
        $this->idPpaProjAti = $idPpaProjAti;
        return $this;
    }

    function setDsObjeto($dsObjeto) {
        $this->dsObjeto = $dsObjeto;
        return $this;
    }

    function setDsJustificativa($dsJustificativa) {
        $this->dsJustificativa = $dsJustificativa;
        return $this;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
        return $this;
    }

       
    

    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */                                    
    public function cadastrar($perfil){
        try {     
            
            //Verifica se os campos foram preenchidos
            if($this->idPta == 0 || $this->nmPtaTitulo == ""
                    || $this->idPpaProjAti == 0 || $this->idProgramaTrabalho == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                    
            
            $p = new Pta();
            $p->setIdPta($this->idPta);
            $p->carregaDados($p->getIdPta());
            $this->idPas = $p->getIdPas();
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPas($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }
            
            //Seta os Campos
            $pta = new DaoPlaPtaTitulo();
                        
            $pta->setIdPta($this->idPta);
            $pta->setNmPtaTitulo($this->nmPtaTitulo);                        
            $pta->setIdPpaProjAti($this->idPpaProjAti);
            $pta->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $pta->setDsJustificativa($this->dsJustificativa);
            $pta->setDsObjeto($this->dsObjeto);                                                           
            
            //Insere o Registro no banco
            $result = $pta->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Pega o ID Inserido                                                                                         
            $pta->setIdPtaTitulo($pdo->lastInsertId('pla_pta_titulo_id_pta_titulo_seq'));            
            //Salva no Log
            $sucesso = false;
            if (Log::SalvaLogI('pla_pta_titulo', $pta->getIdPtaTitulo(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Título do PTA Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                                                                       
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * Edita Um registro Referente a essa classe
     * @return string
     */
    public function editar($perfil){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->idPtaTitulo == 0 || $this->nmPtaTitulo == ""
                    || $this->idPpaProjAti == 0 || $this->idProgramaTrabalho == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            
            //Seta os Campos
            $pta = new DaoPlaPtaTitulo();
                        
            $pta->setIdPtaTitulo($this->idPtaTitulo);            
            $pta->setNmPtaTitulo($this->nmPtaTitulo);                        
            $pta->setIdPpaProjAti($this->idPpaProjAti);
            $pta->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $pta->setDsJustificativa($this->dsJustificativa);
            $pta->setDsObjeto($this->dsObjeto);  
            
            $busca = $pta->retorna($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            $p = new Pta();
            $p->setIdPta($busca['id_pta']);
            $p->carregaDados($p->getIdPta());
            $this->idPas = $p->getIdPas();
                                                
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPas($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                    
            }                        
            
                                                
            //Edita o Registro no banco
            $result = $pta->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Salva no Log
            $sucesso = false;
            if (!Log::SalvaLogU('pla_pta_titulo', $pta->getIdPtaTitulo(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }
                                                                                                                                 
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                              
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição Realizada com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }    
            
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * Remove Um registro Referente a essa classe
     * @return string
     */
    public function remover($perfil){
        try {
            
            //Verifica se enviou o campo.                   
            if($this->idPtaTitulo == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                 
                        
            //Seta os Campos
            $pta = new DaoPlaPtaTitulo();
            
            $pta->setIdPtaTitulo($this->idPtaTitulo);    
            
            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $pta->retorna($pdo);                                    
            
            $p = new Pta();
            $p->setIdPta($busca['id_pta']);
            $p->carregaDados($p->getIdPta());
            $this->idPas = $p->getIdPas();
            
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPas($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                         
            }                       
            
            //Salva no Log            
            if ($busca){
                if (!Log::SalvaLogD('pla_pta_titulo', $pta->getIdPtaTitulo(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Título do PTA.");
               $pdo->rollBack();
               return $retorno;
            }
                                                
            //Remove o Registro no banco
            $resultDao = $pta->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                                                                                                                                                              
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Título do PTA removido com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }        
            
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
                  
    
    /**
     * Verifica se o usuário possui permissão em um Pas especifico
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoPas($idPas, $pdo){
        try {                    
            $retorno = FALSE;
            $pasPes = new PasPesLot();        
            $result = $pasPes->verificaPermissaoPas($_SESSION['idUser'], $idPas, $pdo);
            if(!$result){
                return $retorno;
            }else{
                return TRUE;
            }                                        
            return $retorno;
        } catch (Exception $exc) {
            $retorno = FALSE;
            echo $exc->getMessage();
        }
                             
    }
    
    
    /**
     * 
     * @param int $idPtaTitulo
     */
    public function carregaDados(PDO $pdo = null){
        
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $pta = new DaoPlaPtaTitulo();    
            $pta->setIdPtaTitulo($this->idPtaTitulo);
            $result = $pta->retornaTodosDadosPorPtaTitulo($pdo);              
            if (!$result) {
                $this->idPtaTitulo = NULL;
            } else {                                
                
                $this->nmPtaTitulo = $result['nm_pta_titulo'];
                $this->dtInicio = $result['dt_inicio'];
                $this->dtFim = $result['dt_fim'];                
                $this->idPta = $result['id_pta'];
                $this->nmPta = $result['nm_pta'];
                $this->idPas = $result['id_pas'];
                $this->nmPas = $result['nm_pas'];
                $this->idPpaProjAti = $result['id_ppa_proj_ati'];
                $this->nmPpaProjAti = $result['nm_ppa_proj_ati'];
                $this->idProgramaTrabalho = $result['id_programa_trabalho'];
                $this->dsProgramaTrabalho = $result['ds_programa_trabalho'];
                $this->programaTrabalho = $result['programa_trabalho'];                                
                $this->dsObjeto = $result['ds_objeto'];
                $this->dsJustificativa = $result['ds_justificativa'];     
                $this->nmLotacao = $result['nm_lotacao'];     
                $this->idLotacao = $result['id_lotacao'];
                
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function retornaDadosParaEdicao(){
        
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();                        
                                                   
            $idPtaTitulo = $this->idPtaTitulo;            
            $this->carregaDados($pdo);                                    
            
            if($idPtaTitulo != $this->idPtaTitulo
                    || $this->idPta == "" || $this->idPas == 0){
                return Metodos::retornoAjax("nao_encontrou", "", "");
            }
                           
            $array = array(                
                "nome" => $this->nmPtaTitulo,
                "programa" => $this->retornaOptionProgramaTrabalho($this->idProgramaTrabalho),
                "proj_ppa_ati" => $this->retornaOptionPpaProjAti($this->idPpaProjAti),
                "objeto" => $this->dsObjeto,
                "justificativa" => $this->dsJustificativa
            );
            
            return Metodos::retornoAjax("ok", "ok", $array);                                    
                                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return;
        }
    }
    
    public function retornaList(){
        $retorno = "";
        
        try{           
                
            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>PAS:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->nmPas."</div>";                       
            $retorno .= "</div>";

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>PTA:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->nmPta."</div>";                    
            $retorno .= "</div>";                                

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>Data Início - Fim:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->dtInicio." - ".$this->dtFim."</div>";                    
            $retorno .= "</div>";

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>Programa de Trabalho:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->programaTrabalho." - ".$this->dsProgramaTrabalho."</div>";                    
            $retorno .= "</div>";

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>Projeto/Atividade do PPA:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->nmPpaProjAti."</div>";                    
            $retorno .= "</div>";

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>Objeto:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->dsObjeto."</div>";                    
            $retorno .= "</div>";

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>Justificativa:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->dsJustificativa."</div>";                    
            $retorno .= "</div>";

            $retorno .= "<div class='row'>";
                $retorno .= "<div class='col-sm-2'><b>Local:</b></div>";
                $retorno .= "<div class='col-sm-9'>".$this->nmLotacao."</div>";                    
            $retorno .= "</div>";
                                                                                                                                                 
                    
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    
    
    public function retornaOptionProgramaTrabalho($idProgramaTrabalho = null){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pta = new Pta();            
            $pta->setIdPta($this->idPta);                  
            $pta->carregaDados($pta->getIdPta());                                                                        
            
            $data = new DateTime($pta->getDtInicio());
            
            $programa = new ProgramaTrabalho();
            $programa->setAaProgramaTrabalho($data->format("Y"));
            $retorno = $programa->retornaOptionSelectPorAno($idProgramaTrabalho);
            
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaOptionPpaProjAti($idPpaProjAti = null){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pta = new Pta();            
            $pta->setIdPta($this->idPta);                  
            $pta->carregaDados($pta->getIdPta());                                                                                                
            
            $pas = new PasAcao();
            $pas->setIdPas($pta->getIdPas());
            $retorno = $pas->retornaOptionPpaProjAti($idPpaProjAti);
            
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaTabelaAcoes(){
        $retorno = "";
        
        try{           
                                                                
            $pta = new PtaItem();
            $pta->retornaAcoesDetValPtaTitulo($this->idPtaTitulo);
            
            if(!$pta->Sucesso()){
                return $retorno;
            }
            
            $result = $pta->getMsgRetorno();
            
            if(count($result) > 0){                                
                
                $arrayDados = array();
                
                foreach ($result as $value) {                
                    if(array_key_exists($value['id_acao'], $arrayDados)){
                        if(array_key_exists($value['id_pta_acao_det'], $arrayDados[$value['id_acao']]["elementos"]  )){
                           $arrayDados[$value['id_acao']] ["elementos"][$value['id_pta_acao_det']]['fontes'][$value['id_fonte']] = array(                                                                                                        
                                    "fonte" => $value['nr_fonte'],
                                    "valor" => $value['valor']                                    
                            ); 
                           $arrayDados[$value['id_acao']] ["qtd_elementos"]++;
                           $arrayDados[$value['id_acao']] ["elementos"][$value['id_pta_acao_det']]["qtd_elementos"]++;

                        }else{                                        
                            $arrayDados[$value['id_acao']] ["elementos"][$value['id_pta_acao_det']] = array(                                
                                        "nm_pta_acao_det" => $value['nm_pta_acao_det'],    
                                        "qtd_elementos" => 1,
                                        "fontes" => array($value['id_fonte'] => array( 
                                            "fonte" => $value['nr_fonte'],
                                            "valor" => $value['valor']
                                        )
                                )                        
                            );
                            $arrayDados[$value['id_acao']] ["qtd_elementos"]++;
                        }

                    }else{


                        $arrayDados[$value['id_acao']] = array(
                            "nm_acao" => $value['nm_acao'],
                            "ds_indicador_programacao" => $value['ds_indicador_programacao'],  
                            "qtd_elementos" => 1,
                            "elementos" => array($value['id_pta_acao_det'] => array(                                
                                "nm_pta_acao_det" => $value['nm_pta_acao_det'],       
                                "qtd_elementos" => 1,
                                "fontes" => array($value['id_fonte'] => array( 
                                    "fonte" => $value['nr_fonte'],
                                    "valor" => $value['valor']                             
                                )))
                            )                        
                        );   
                       
                    }
                }                
                
                $retorno .= '<div class="panel panel-default">';                                                  
            
                $retorno .= '<table class="table table-bordered" cellspacing="0" width="100%">';
                
                $retorno .= '<thead>
                                <tr>
                                    <th>Ação</th>                                                        
                                    <th>Detalhamento da Ação</th>
                                    <th>Fonte</th>
                                    <th class="text-right">Valor</th> 
                                </tr>
                            </thead>';
                
                    
                $retorno .= '<tbody>';
                $valorTotal = 0;                
                foreach ($arrayDados as $key => $value) {                        
                        
                    //#DFF0D8 = success
                    //#bbddad = verde escuro
                    
                    $retorno .= "<tr >"
                                . "<td rowspan='".$value['qtd_elementos']."' style='vertical-align: middle !important;' class='text-left active text-bold'>".$value['nm_acao']."</td>";                                                

                        foreach ($value['elementos'] as $k2 => $v2) {
                            $retorno .= "<td rowspan='".$v2['qtd_elementos']."' style='vertical-align: middle !important; background-color: #bbddad;' class='text-left' >".$v2['nm_pta_acao_det']."</td>";

                            $priFonte = 0;
                            
                            $classColor = '';
                            foreach ($v2['fontes'] as $k3 => $v3) {
                                $classColor = (empty($classColor)) ? 'success' : '';
                                
                                if($priFonte != 0){
                                    $retorno .= "<tr>";
                                }
                                $valorTotal += $v3['valor'];
                                $retorno .= "<td class='text-center ".$classColor." '>".$v3['fonte']."</td>";
                                $retorno .= "<td class='text-right ".$classColor."'>R$ ".Metodos::ConverteValorBr($v3['valor'], 4)."</td>";
                                $retorno .= "</tr>";
                                $priFonte = 1;
                            }                                
                        }                      
                }

                $retorno .= "</tbody>";
                $retorno .= "<tfoot >"
                            . "<tr class='warning'>"
                                . "<th colspan='3'>Total</th>";                                                                                    
                    $retorno  .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                            
                            . "</tr>"
                        . "</tfoot>";
                $retorno .= "</table>";

                $retorno .= "</div>";
                                                
            }      
            
            
            $pta->retornaTGCValPtaTitulo($this->idPtaTitulo);
            
            if(!$pta->Sucesso()){
                return $retorno;
            }
            
            $result = $pta->getMsgRetorno();
                                    
            if(count($result) > 0){                                
                
                $arrayDados = array();
                
                foreach ($result as $value) {                
                    if(array_key_exists($value['id_tipo_gasto'], $arrayDados)){
                                                             
                        $arrayDados[$value['id_tipo_gasto']] ["elementos"][$value['id_tipo_gasto_categoria']] = array(                                
                                    "nm_tipo_gasto_categoria" => $value['nm_tipo_gasto_categoria'],   
                                    "valor" => $value['valor']                                                                                     
                        );
                        $arrayDados[$value['id_tipo_gasto']] ["qtd_elementos"]++;
                       

                    }else{


                        $arrayDados[$value['id_tipo_gasto']] = array(
                            "nm_tipo_gasto" => $value['nm_tipo_gasto'],                            
                            "qtd_elementos" => 1,
                            "elementos" => array($value['id_tipo_gasto_categoria'] => array(                                
                                "nm_tipo_gasto_categoria" => $value['nm_tipo_gasto_categoria'],       
                                "valor" => $value['valor']
                                )
                            )                        
                        );   
                       
                    }
                }                
                                                
                
                $retorno .= '<div class="panel panel-default">';                                                  
            
                $retorno .= '<table class="table table-bordered" cellspacing="0" width="100%">';
                
                $retorno .= '<thead>
                                <tr>
                                    <th>Tipo de Gasto</th>                                                        
                                    <th>Tipo de Gasto Categoria</th>                                    
                                    <th class="text-right">Valor</th> 
                                </tr>
                            </thead>';
                
                    
                $retorno .= '<tbody>';
                $valorTotal = 0;                
                foreach ($arrayDados as $key => $value) {                        
                        
                    //#DFF0D8 = success
                    //#bbddad = verde escuro
                    
                    $retorno .= "<tr >"
                                . "<td rowspan='".$value['qtd_elementos']."' style='vertical-align: middle !important;' class='text-left active text-bold'>".$value['nm_tipo_gasto']."</td>";                                                
                        $priFonte = 0;
                        $classColor = '';
                        foreach ($value['elementos'] as $k2 => $v2) {
                            $classColor = (empty($classColor)) ? 'success' : '';
                            if($priFonte != 0){
                                $retorno .= "<tr>";
                            }
                            $valorTotal += $v2['valor'];
                            $retorno .= "<td class='text-left ".$classColor."' >".$v2['nm_tipo_gasto_categoria']."</td>";
                            $retorno .= "<td class='text-right ".$classColor."' >R$ ".Metodos::ConverteValorBr($v2['valor'], 4)."</td>";

                            $retorno .= "</tr>";
                            $priFonte = 1;                                                       
                        }                      
                }

                $retorno .= "</tbody>";
                $retorno .= "<tfoot >"
                            . "<tr class='warning'>"
                                . "<th colspan='2'>Total</th>";                                                                                    
                    $retorno  .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                            
                            . "</tr>"
                        . "</tfoot>";
                $retorno .= "</table>";

                $retorno .= "</div>";
                                                
            }
            
                        
            
            
            
            
            

            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    public function retornaDadosValoresFonte(){
        $retorno = "";
        
        try{           
                                                                
            $pta = new PtaItem();
            $pta->retornaValFontesPorPtaTitulo($this->idPtaTitulo);
            
            if(!$pta->Sucesso()){
                return Metodos::retornoAjax("erro", null, null); 
            }
            
            $result = $pta->getMsgRetorno();
            
            if(count($result) > 0){                              
                               
                foreach ($result as $key => $value) {
                    $result[$key]['valor'] = number_format($value['valor'], 4, '.', '');
                }                
                return Metodos::retornoAjax("ok", null, $result);                                                                
            }
            
            return Metodos::retornoAjax("erro", null, null);     
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    public function retornaDadosValoresCatEconomica(){
        $retorno = "";
        
        try{           
                                                                
            $pta = new PtaItem();
            $pta->retornaValCatEconomicaPorPtaTitulo($this->idPtaTitulo);
            
            if(!$pta->Sucesso()){                
                return Metodos::retornoAjax("erro", null, null); 
            }
            
            $result = $pta->getMsgRetorno();
            
            if(count($result) > 0){                              
                               
                foreach ($result as $key => $value) {
                    $result[$key]['valor'] = number_format($value['valor'], 4, '.', '');
                }                
                return Metodos::retornoAjax("ok", null, $result);                                                                
            }
            
            return Metodos::retornoAjax("erro", null, null);     
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
                     
}

?>
