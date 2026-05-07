<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPes.class.php";

class Pes{
    
    private $idPes = null;
    private $nmPes = null;
    private $vigenciaInicio = null;
    private $vigenciaFim = null;
    
    function getIdPes() {
        return $this->idPes;
    }

    function getNmPes() {
        return $this->nmPes;
    }

    function getVigenciaInicio() {
        return $this->vigenciaInicio;
    }

    function getVigenciaFim() {
        return $this->vigenciaFim;
    }

    function setIdPes($idPes) {
        $this->idPes = $idPes;
    }

    function setNmPes($nmPes) {
        $this->nmPes = $nmPes;
    }

    function setVigenciaInicio($vigenciaInicio) {
        $this->vigenciaInicio = $vigenciaInicio;
    }

    function setVigenciaFim($vigenciaFim) {
        $this->vigenciaFim = $vigenciaFim;
    }

                              
    public function cadastrarPes(){
        try {            
            if($this->nmPes == "" || $this->vigenciaInicio == "" || $this->vigenciaFim == ""
                    || strlen($this->vigenciaInicio) != 4 || strlen($this->vigenciaFim) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pes = new DaoPlaPes();
            
            $pes->setNmPes($this->nmPes);
            $pes->setAaVigenciaInicio($this->vigenciaInicio);
            $pes->setAaVigenciaFim($this->vigenciaFim);
            
                                
            $result = $pes->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $pes->setIdPes($pdo->lastInsertId('pla_pes_id_pes_seq'));            
            
            if (Log::SalvaLogI('pla_pes', $pes->getIdPes(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Plano Estadual de Saúde Realizado com Sucesso.");
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
    
    
    public function editarPes(){
        try {
                                    
            if($this->idPes == "" || $this->idPes == 0
                    || $this->nmPes == "" || $this->vigenciaInicio == "" 
                    || $this->vigenciaFim == ""
                    || strlen($this->vigenciaInicio) != 4 || strlen($this->vigenciaFim) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pes = new DaoPlaPes();
            
            $pes->setIdPes($this->idPes);
            $pes->setNmPes($this->nmPes);
            $pes->setAaVigenciaInicio($this->vigenciaInicio);
            $pes->setAaVigenciaFim($this->vigenciaFim);
                        
                        
            $busca = $pes->retornaPes($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $pes->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('pla_pes', $pes->getIdPes(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }
                                                                                                                                 
                                            
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição Realizada com Sucesso.");
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
    
    public function removerPes(){
        try {
                                    
            if($this->idPes == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pes = new DaoPlaPes();
            
            $pes->setIdPes($this->idPes);       
            
            $busca = $pes->retornaPes($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_pes', $pes->getIdPes(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Plano Estadual.");
               $pdo->rollBack();
               return $retorno;
            }
            
            $resultDao = $pes->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Plano Estadual removido com Sucesso.");
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
    
    
    public function retornaTrPes(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pes = new DaoPlaPes();
            
            $result = $pes->retornaTodosPes($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idPes = $v['id_pes'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_pes'] . "</td>"
                            . "<td>" . $v['aa_vigencia_inicio'] ." - ".$v['aa_vigencia_fim'].  "</td>"                            
                            . '<td style="text-align: center;">'
                            . '<a href="../eixo/index.php?token='.$idPes.'" class="btn btn-default btn-entrar btn-xs" title="Eixos"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                              </a> '                          
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_pes'].'" '
                                . ' aa_vigencia_inicio="'.$v['aa_vigencia_inicio'].'" '
                                . ' aa_vigencia_fim="'.$v['aa_vigencia_fim'].'" '
                                . ' value=' . $idPes . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idPes . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>'
                            . "</tr>";                                                                              
                    $retorno .= "</tr>";
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function carregaInfoPes(){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pes = new DaoPlaPes();
            $pes->setIdPes($this->idPes);
                          
            $result = $pes->retornaPes($pdo);
            
            if (!$result) {
                
            } else {
                $this->idPes = $result['id_pes'];
                $this->nmPes = $result['nm_pes'];
                $this->vigenciaInicio = $result['aa_vigencia_inicio'];
                $this->vigenciaFim = $result['aa_vigencia_fim'];                                                 
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaSelectPes(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pes = new DaoPlaPes();
            
            $result = $pes->retornaTodosPes($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= '<option value='.$v['id_pes'].'>'.$v['nm_pes'].'</option>';                    
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaList(){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pes = new DaoPlaPes();
            $pes->setIdPes($this->idPes);                     
            $result = $pes->retornaPes($pdo);
            
            if (!$result) {
                return $retorno;
            } else {  
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>PES:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_pes']."</div>";                       
                $retorno .= "</div>";                                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Ano Início - Fim:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['aa_vigencia_inicio']." - ".$result['aa_vigencia_fim']."</div>";                    
                $retorno .= "</div>";                                                                                                                                                                                                             
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
           
    
    public function retornaTodosPesUlLi(){
        
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pes = new DaoPlaPes();
            
            $result = $pes->retornaTodosPesAteObjetivo($pdo);
            
            if (!$result) {
                return $retorno;
            } else {
                $array = [];                
               
                foreach ($result as $v) {                                                            
                    //Caso já existe algum PES, se não irá adicionar o primeiro
                    if(array_key_exists($v['id_pes'], $array)){
                        //Já existe um PES, então agora precisa verificar se já existe algum Eixo Cadastrado
                        //Se Existir um Eixo Cadastradao, então Adicionar somente a diretriz no Eixo
                        //Se Não, adicionar o Eixo no PES
                        
                        //Verifica se Tem Eixo, caso tenha, add.
                        if($v['id_eixo'] != "" || $v['id_eixo'] != NULL){
                            
                            //Se Já tiver um Eixo Cadastrado, basta somente cadastrar uma diretriz dentro do Eixo
                            if(array_key_exists( $v['id_eixo'], $array[ $v['id_pes']]['eixo'] )){
                                                                                                
                                //Verifica se tem alguma Diretriz
                                if($v['id_diretriz'] != "" || $v['id_diretriz'] != NULL){
                                    //Se Já tiver uma diretriz cadastrada, precisa verificar se tem um objetivo
                                    //Caso já tenha, cadastrar o Objetivo dentro da diretriz
                                    //Caso não tenha, cadastrar a Diretriz                                    
                                    if(array_key_exists( $v['id_diretriz'], $array[ $v['id_pes']] ['eixo'][$v['id_eixo']]['diretriz'] )){
                                        //Verifica se tem algum Objetivo 
                                        //Se Já tiver um Objetivo, basta cadastrar a Ação Dentro do Objetivo
                                        //Caso não tenha, cadastrar o Objetivo e a Ação
                                        if($v['id_objetivo'] != "" || $v['id_objetivo'] != NULL){
                                            
                                            //Verifica se já tem Objetivo
                                            if(array_key_exists( $v['id_objetivo'], $array[ $v['id_pes']] ['eixo'][$v['id_eixo']]['diretriz'][$v['id_diretriz']]['obj'] )){                                            
                                                //Cadastra Somente a Ação Dentro do Objetivo
                                                //Verifica se tem alguma Ação
                                                if($v['id_acao'] != "" || $v['id_acao'] != NULL){
                                                    $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] ['acao'][$v['id_acao']] = array
                                                    (
                                                        "id_acao" => $v['id_acao'],
                                                        "nm_acao" => $v['nm_acao'],
                                                        "ds_indicador" => $v['ds_indicador'],
                                                        "ds_parceria" => $v['ds_parceria'],
                                                        "value" => $v['nm_acao']
                                                    );
                                                }
                                                
                                            }else{
                                                //Cadastra o Objetivo e depois a Ação Caso Tenha
                                                $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] = array
                                                (
                                                    "id_objetivo" => $v['id_objetivo'],
                                                    "nm_objetivo" => $v['nm_objetivo'],
                                                    "ordem" => $v['ordemobjetivo'],
                                                    "value" => $v['ordemeixo'].".".$v['ordemdiretriz'].".".$v['ordemobjetivo']." ".$v['nm_objetivo']
                                                );
                                                //Verifica se tem alguma Ação
                                                if($v['id_acao'] != "" || $v['id_acao'] != NULL){
                                                    $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] ['acao'][$v['id_acao']] = array
                                                    (
                                                        "id_acao" => $v['id_acao'],
                                                        "nm_acao" => $v['nm_acao'],
                                                        "ds_indicador" => $v['ds_indicador'],
                                                        "ds_parceria" => $v['ds_parceria'],
                                                        "value" => $v['nm_acao']
                                                    );
                                                }
                                            }
                                        }
                                        
                                    }else{                                                                        
                                        //Adiciona uma Diretriz no Eixo                                    
                                        $array[$v['id_pes']] ["eixo"][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] = array                                    
                                        (
                                            "id_diretriz" => $v['id_diretriz'],
                                            "nm_diretriz" => $v['nm_diretriz'],
                                            "ordem" => $v['ordemdiretriz'],
                                            "value" => $v['ordemeixo'].".".$v['ordemdiretriz']." ".$v['nm_diretriz']
                                        );   
                                        
                                        //Verifica se tem algum Objetivo
                                        if($v['id_objetivo'] != "" || $v['id_objetivo'] != NULL){
                                            $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] = array
                                            (
                                                "id_objetivo" => $v['id_objetivo'],
                                                "nm_objetivo" => $v['nm_objetivo'],
                                                "ordem" => $v['ordemobjetivo'],
                                                "value" => $v['ordemeixo'].".".$v['ordemdiretriz'].".".$v['ordemobjetivo']." ".$v['nm_objetivo']
                                            );
                                            //Verifica se tem alguma Ação
                                            if($v['id_acao'] != "" || $v['id_acao'] != NULL){
                                                $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] ['acao'][$v['id_acao']] = array
                                                (
                                                    "id_acao" => $v['id_acao'],
                                                    "nm_acao" => $v['nm_acao'],
                                                    "ds_indicador" => $v['ds_indicador'],
                                                    "ds_parceria" => $v['ds_parceria'],
                                                    "value" => $v['nm_acao']
                                                );
                                            }
                                        }
                                    }
                                }

                            }else{
                                //Como não tem nenhum Eixo Cadastrado, tem que se cadastrar o Eixo                                
                                $array[$v['id_pes']] ["eixo"][$v['id_eixo']] = array
                                (
                                    "id_eixo" => $v['id_eixo'],
                                    "nm_eixo" => $v['nm_eixo'],
                                    "ordem" => $v['ordemeixo'],                               
                                    "value" => $v['ordemeixo']." ".$v['nm_eixo']
                                );
                                
                                //Verifica se tem alguma Diretriz
                                if($v['id_diretriz'] != "" || $v['id_diretriz'] != NULL){                                    
                                    //Adiciona uma Diretriz no Eixo
                                    $array[$v['id_pes']] ["eixo"][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] = array
                                    (
                                        "id_diretriz" => $v['id_diretriz'],
                                        "nm_diretriz" => $v['nm_diretriz'],
                                        "ordem" => $v['ordemdiretriz'],
                                        "value" => $v['ordemeixo'].".".$v['ordemdiretriz']." ".$v['nm_diretriz']
                                    );                                    
                                }
                                
                                //Verifica se tem algum Objetivo
                                if($v['id_objetivo'] != "" || $v['id_objetivo'] != NULL){
                                    $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] = array
                                    (
                                        "id_objetivo" => $v['id_objetivo'],
                                        "nm_objetivo" => $v['nm_objetivo'],
                                        "ordem" => $v['ordemobjetivo'],
                                        "value" => $v['ordemeixo'].".".$v['ordemdiretriz'].".".$v['ordemobjetivo']." ".$v['nm_objetivo']
                                    );
                                }
                                
                                //Verifica se tem alguma Ação
                                if($v['id_acao'] != "" || $v['id_acao'] != NULL){
                                    $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] ['acao'][$v['id_acao']] = array
                                    (
                                        "id_acao" => $v['id_acao'],
                                        "nm_acao" => $v['nm_acao'],
                                        "ds_indicador" => $v['ds_indicador'],
                                        "ds_parceria" => $v['ds_parceria'],
                                        "value" => $v['nm_acao']
                                    );
                                }
                            }
                        }
                        
                    }else{
                        
                        //Primeiro Add no Array
                        $array[$v['id_pes']] = array
                        (
                            "id_pes" => $v['id_pes'],
                            "nm_pes" => $v['nm_pes'],
                            "aa_vigencia_inicio" => $v['vig_inicio_pes'],
                            "aa_vigencia_fim" => $v['vig_fim_pes'],
                            "value" => $v['nm_pes']
                        );
                        
                        //Verifica se Tem Eixo, caso tenha, add.
                        if($v['id_eixo'] != "" || $v['id_eixo'] != NULL){
                            $array[$v['id_pes']] ['eixo'][$v['id_eixo']] = array
                            (
                                "id_eixo" => $v['id_eixo'],
                                "nm_eixo" => $v['nm_eixo'],
                                "ordem" => $v['ordemeixo'],                          
                                "value" => $v['ordemeixo']." ".$v['nm_eixo']
                            );
                            
                            //Verifica se tem alguma Diretriz
                            if($v['id_diretriz'] != "" || $v['id_diretriz'] != NULL){
                                $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] = array
                                (
                                    "id_diretriz" => $v['id_diretriz'],
                                    "nm_diretriz" => $v['nm_diretriz'],
                                    "ordem" => $v['ordemdiretriz'],                                    
                                    "value" => $v['ordemeixo'].".".$v['ordemdiretriz']." ".$v['nm_diretriz']
                                );
                                
                                //Verifica se tem algum Objetivo
                                if($v['id_objetivo'] != "" || $v['id_objetivo'] != NULL){
                                    $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] = array
                                    (
                                        "id_objetivo" => $v['id_objetivo'],
                                        "nm_objetivo" => $v['nm_objetivo'],
                                        "ordem" => $v['ordemobjetivo'],
                                        "value" => $v['ordemeixo'].".".$v['ordemdiretriz'].".".$v['ordemobjetivo']." ".$v['nm_objetivo']
                                    );
                                    //Verifica se tem alguma Ação
                                    if($v['id_acao'] != "" || $v['id_acao'] != NULL){
                                        $array[$v['id_pes']] ['eixo'][$v['id_eixo']] ['diretriz'][$v['id_diretriz']] ['obj'][$v['id_objetivo']] ['acao'][$v['id_acao']] = array
                                        (
                                            "id_acao" => $v['id_acao'],
                                            "nm_acao" => $v['nm_acao'],
                                            "ds_indicador" => $v['ds_indicador'],
                                            "ds_parceria" => $v['ds_parceria'],
                                            "value" => $v['nm_acao']
                                        );
                                    }  
                                }  
                                
                            }        
                            
                        }                                                                                                                                                
                                                
                    }                    
                }
                return $array;                
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    
    
}

?>
