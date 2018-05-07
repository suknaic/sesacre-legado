<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaEixo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaEixoPpaProjAti.class.php";

class Eixo{
    
    private $idEixo = null;
    private $idPes = null;
    private $idPpaProjAti = null;
    private $nmEixo = null;
    private $nrOrdem = null;    

    function getIdEixo() {
        return $this->idEixo;
    }

    function getIdPes() {
        return $this->idPes;
    }
  
    function getNmEixo() {
        return $this->nmEixo;
    }

    function getNrOrdem() {
        return $this->nrOrdem;
    }

    function setIdEixo($idEixo) {
        $this->idEixo = $idEixo;
    }

    function setIdPes($idPes) {
        $this->idPes = $idPes;
    }   

    function setNmEixo($nmEixo) {
        $this->nmEixo = $nmEixo;
    }

    function setNrOrdem($nrOrdem) {
        $this->nrOrdem = $nrOrdem;
    }
    
    function getIdPpaProjAti() {
        return $this->idPpaProjAti;
    }

    function setIdPpaProjAti($idPpaProjAti) {
        $this->idPpaProjAti = $idPpaProjAti;
    }

                                  
    public function cadastrarEixo(){
        try {            
            if($this->nmEixo == "" || $this->idPes == ""
                    || $this->nrOrdem == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $eixo = new DaoPlaEixo();
            
            $eixo->setNmEixo($this->nmEixo);
            $eixo->setIdPes($this->idPes);           
            $eixo->setNrOrdem($this->nrOrdem);
                                            
            $result = $eixo->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $eixo->setIdEixo($pdo->lastInsertId('pla_eixo_id_eixo_seq'));            
            
            if (Log::SalvaLogI('pla_eixo', $eixo->getIdEixo(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            if(count($this->idPpaProjAti) > 0){
                $dao = new DaoPlaEixoPpaProjAti();
                               
                $dao->setIdEixo($eixo->getIdEixo());
                foreach ($this->idPpaProjAti as $value) {                    
                    $dao->setIdPpaProjAti($value);
                    
                    $result = $dao->insert($pdo);
                    if ($result != "Sucesso") {
                        $retorno = Metodos::retornoAjax("Erro", "console", $result);
                        $pdo->rollBack();
                        return $retorno;
                    }

                    $dao->setIdEixoPpaProjAti($pdo->lastInsertId('pla_eixo_ppa_proj_ati_id_eixo_ppa_proj_ati_seq'));            

                    if (Log::SalvaLogI('pla_eixo_ppa_proj_ati', $dao->getIdEixoPpaProjAti(), $pdo)) {
                        $sucesso = true;
                    }else{
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                    
                }
                
            }
                                                                                  
            
            
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Eixo Realizado com Sucesso.");
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
    
    
    public function editarEixo(){
        try {
              
            if($this->nmEixo == "" || $this->idPes == "" 
                    || $this->nrOrdem == "" || $this->idEixo == ""){            
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $eixo = new DaoPlaEixo();
            
            $eixo->setIdEixo($this->idEixo);
            $eixo->setNmEixo($this->nmEixo);
            $eixo->setIdPes($this->idPes);            
            $eixo->setNrOrdem($this->nrOrdem);
                        
                        
            $busca = $eixo->retornaEixo($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $eixo->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('pla_eixo', $eixo->getIdEixo(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }
            
            
             if(count($this->idPpaProjAti) > 0){
                $dao = new DaoPlaEixoPpaProjAti();
                $dao->setIdEixo($eixo->getIdEixo());
                $idsAdd = array();
                $idsRem = array();
                //Organiza os Ids dos projetos do PPA Separados.
                //Um para remover e outro para adicionar
                foreach ($this->idPpaProjAti as $dados) {
                    if($dados[0] == 'rem'){
                        $idsRem[] = $dados[1];
                    }else if ($dados[0] == 'add'){
                        $idsAdd[] = $dados[1];
                    }
                }
                
                //Remover os Projetos/Atividade Selecionado
                if(count($idsRem) > 0){
                    $ids = implode(", ", array_map('intval', $idsRem));                    
                    //Retorna os Projetos e Atividades daquele Eixo
                    $idsRetorno = $dao->retornaTodosPorPpaProjAtiINEixo($ids, $eixo->getIdEixo(), $pdo);                    
                    foreach ($idsRetorno as $value) {   
                        $dao->setIdEixoPpaProjAti($value['id_eixo_ppa_proj_ati']);
                        $busca = $dao->retornaEixoPpaProjAti($pdo);
                        if ($busca){
                            if (!Log::SalvaLogD('pla_eixo_ppa_proj_ati', $dao->getIdEixoPpaProjAti(), $pdo)) {
                                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                                $pdo->rollBack();
                                return $retorno;
                            }                
                        } else {
                           $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Projeto/Atividade do PPA.");
                           $pdo->rollBack();
                           return $retorno;
                        }

                        $resultDao = $dao->delete($pdo);
                        if ($resultDao != "Sucesso"){
                            $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                            $pdo->rollBack();
                            return $retorno;
                        }
                        
                    }
                }
                
                //Adicionar os Projetos/Atividade Selecionado
                if(count($idsAdd) > 0){
                    foreach ($idsAdd as $value) {  
                        $dao->setIdPpaProjAti($value);
                        $result = $dao->insert($pdo);
                        if ($result != "Sucesso") {
                            $retorno = Metodos::retornoAjax("Erro", "console", $result);
                            $pdo->rollBack();
                            return $retorno;
                        }

                        $dao->setIdEixoPpaProjAti($pdo->lastInsertId('pla_eixo_ppa_proj_ati_id_eixo_ppa_proj_ati_seq'));            

                        if (Log::SalvaLogI('pla_eixo_ppa_proj_ati', $dao->getIdEixoPpaProjAti(), $pdo)) {
                            $sucesso = true;
                        }else{
                            $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                            $pdo->rollBack();
                            return $retorno;
                        }                        
                    }                                        
                }                                                                                                                                            
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
    
    public function removerEixo(){
        try {
                                    
            if($this->idEixo == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $eixo = new DaoPlaEixo();
            
            $eixo->setIdEixo($this->idEixo);    
            
            
            
            //Remover os Projetos/Atividades do PPA caso tenha
            $dao = new DaoPlaEixoPpaProjAti();
            $result = $dao->retornaTodosPorEixo($eixo->getIdEixo(), $pdo);
             
            if($result){
              
                if(count($result) > 0){
                    foreach ($result as $value) {
                        $dao->setIdEixoPpaProjAti($value['id_eixo_ppa_proj_ati']);
                        $busca = $dao->retornaEixoPpaProjAti($pdo);
                        
                        if ($busca){
                            if (!Log::SalvaLogD('pla_eixo_ppa_proj_ati', $dao->getIdEixoPpaProjAti(), $pdo)) {
                                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                                $pdo->rollBack();
                                return $retorno;
                            }                
                        } else {
                           $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Projeto/Atividade do PPA.");
                           $pdo->rollBack();
                           return $retorno;
                        }

                        $resultDao = $dao->delete($pdo);
                        if ($resultDao != "Sucesso"){
                            $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                            $pdo->rollBack();
                            return $retorno;
                        }                        
                    }                    
                }
            }
            
            
            $busca = $eixo->retornaEixo($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_eixo', $eixo->getIdEixo(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Eixo.");
               $pdo->rollBack();
               return $retorno;
            }
           
            $resultDao = $eixo->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Eixo removido com Sucesso.");
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
    
    
    public function retornaTrEixoPorPes(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $eixo = new DaoPlaEixo();
            $eixo->setIdPes($this->idPes);
            
            $result = $eixo->retornaTodosEixosPorPes($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idEixo = $v['id_eixo'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nr_ordem'].". " . $v['nm_eixo'] . "</td>"
                            . "<td>" . $v['Projeto/Atividade do PPA'].  "</td>"                            
                            . '<td style="text-align: center;">'
                            . '<a href="../diretriz/index.php?token='.$idEixo.'" class="btn btn-default btn-entrar btn-xs" title="Diretriz"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                              </a> '                          
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" '
                                . ' nome="'.$v['nm_eixo'].'" '                                                      
                                . ' value=' . $idEixo . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idEixo . ' >
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
    
    
    public function carregaInfoEixo(int $idEixo){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $eixo = new DaoPlaEixo();
            $eixo->setIdEixo($idEixo);
                          
            $result = $eixo->retornaEixo($pdo);
            
            if (!$result) {
                
            } else {
                $this->idPes = $result['id_pes'];
                $this->nmEixo = $result['nm_eixo'];
                $this->nrOrdem = $result['nr_ordem'];
                $this->idEixo = $result['id_eixo'];                                                 
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function retornaDadosJson(){
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $eixo = new DaoPlaEixo();
            $eixo->setIdEixo($this->idEixo);
            
            $result = $eixo->retornaDadosParaEdicao($pdo);            
                                    
            if (!$result) {
                
            } else {
                $result['ppa_proj_ati'] = json_decode($result['ppa_proj_ati'], TRUE);        
                return Metodos::retornoAjax("ok", "", $result);                                                                          
            }
            return;                                             
        } catch (Exception $ex) {
            $retorno = "";
        }   
    }
    
    public function retornaList(){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $eixo = new DaoPlaEixo();
            $eixo->setIdEixo($this->idEixo);                          
            $result = $eixo->retornaDadosCompleto($pdo);            
            if (!$result) {
                return $retorno;
            } else {         
                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>PES:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_pes']."</div>";                    
                $retorno .= "</div>"; 
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Eixo:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nr_ordem'].". ".$result['nm_eixo']."</div>";                
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Projeto/Atividade do PPA:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['Projeto/Atividade do PPA']."</div>";                    
                $retorno .= "</div>";                                                                                             
                                                                                                                                                 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    /**
     * Retorna os Options do Select dos Eixos de Acordo com um Projeto/Atividade do PPA
     * @param int $idPpaProjAti id do Projeto/Atividade do PPA
     * @return string
     */
    public function retornaOptionPorPpaProjAti(int $idPpaProjAti){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaEixoPpaProjAti();
            $result = $dao->retornaTodosPorPpaProjAti($idPpaProjAti, $pdo);
            
            $retorno .= "<option value='0'>Selecione um Eixo</option>";  
            
            if (!$result) {                
                return $retorno;
            } else {                         
                foreach ($result as $value) {                    
                    $retorno .= "<option value=".$value['id_eixo'].">"
                            . $value['nr_ordem'].". ".$value['nm_eixo']
                            . "</option>";
                }                                                                                                                                                                                                                                                                           
            }            
            return $retorno;                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    /**
     * Retorna os Options do Select dos Eixos de Acordo com um PES
     * @param int $idPes id do PES
     * @return string
     */
    public function retornaOptionPorPes(int $idPes){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaEixo();
            $dao->setIdPes($idPes);
            $result = $dao->retornaTodosEixosPorPes($pdo);
            
            $retorno .= "<option value='0'>Selecione um Eixo</option>";                  
            if (!$result) {
                return $retorno;
            } else {                         
                foreach ($result as $value) {                    
                    $retorno .= "<option value=".$value['id_eixo'].">"
                            . $value['nr_ordem'].". ".$value['nm_eixo']
                            . "</option>";
                }                                                                                                                                                                                                                                                                           
            }            
            return $retorno;                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    
           
}

?>
