<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPpaProjAti.class.php";

class PpaProjAti{
    
    private $idPpaProjAti = null;
    private $nmPpaProjAti = null;
    private $idPpaProg = null;
    private $cdPpaProjAti = null;
    private $tpPpaProjAti = null;
    
    function getTpPpaProjAti() {
        return $this->tpPpaProjAti;
    }
    function setTpPpaProjAti($tpPpaProjAti) {
        $this->tpPpaProjAti = $tpPpaProjAti;
    }
        
    function getIdPpaProjAti() {
        return $this->idPpaProjAti;
    }

    function getNmPpaProjAti() {
        return $this->nmPpaProjAti;
    }

    function getIdPpaProg() {
        return $this->idPpaProg;
    }

    function getCdPpaProjAti() {
        return $this->cdPpaProjAti;
    }

    function setIdPpaProjAti($idPpaProjAti) {
        $this->idPpaProjAti = $idPpaProjAti;
    }

    function setNmPpaProjAti($nmPpaProjAti) {
        $this->nmPpaProjAti = $nmPpaProjAti;
    }

    function setIdPpaProg($idPpaProg) {
        $this->idPpaProg = $idPpaProg;
    }

    function setCdPpaProjAti($cdPpaProjAti) {
        $this->cdPpaProjAti = $cdPpaProjAti;
    }

    /**
     * Passado um Tipo P ou A do Projeto/Atividade irá retornar o nome o qual representa esse Tipo
     * P = Projeto A = Atividade
     * @param string $tipo
     * @return string
     */
    function retornaTipo(string $tipo){        
        if($tipo == "P"){
            return "Projeto";
        }else if($tipo == "A"){
            return "Atividade";
        }        
        return "";
    }
        

                              
    public function cadastrarPpaProjAti(){
        try {            
            if($this->nmPpaProjAti == "" 
                    || $this->idPpaProg == 0 
                    || $this->cdPpaProjAti == ""
                    || ($this->tpPpaProjAti != "P" && $this->tpPpaProjAti != "A") ){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            
            $conexao = new Conexao();            
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $proj = new DaoPlaPpaProjAti();
            
            $proj->setNmPpaProjAti($this->nmPpaProjAti);
            $proj->setIdPpaProg($this->idPpaProg);            
            $proj->setCdPpaProjAti($this->cdPpaProjAti);
            $proj->setTpPpaProjAti($this->tpPpaProjAti);
           
            
                                
            $result = $proj->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $proj->setIdPpaProjAti($pdo->lastInsertId('pla_ppa_proj_ati_id_ppa_proj_ati_seq'));            
            
            if (Log::SalvaLogI('pla_ppa_proj_ati', $proj->getIdPpaProjAti(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Projeto/Atividade do PPA Realizado com Sucesso.");
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
    
    
    public function editarPpaProjAti(){
        try {
                                    
            if($this->idPpaProjAti == "" || $this->idPpaProjAti == 0                    
                    || $this->nmPpaProjAti == ""
                    || ($this->tpPpaProjAti != "P" && $this->tpPpaProjAti != "A") ){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $proj = new DaoPlaPpaProjAti();
            
            $proj->setIdPpaProjAti($this->idPpaProjAti);            
            $proj->setNmPpaProjAti($this->nmPpaProjAti);            
            $proj->setCdPpaProjAti($this->cdPpaProjAti);
            $proj->setTpPpaProjAti($this->tpPpaProjAti);                                
                        
            $busca = $proj->retornaPpaProjAti($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $proj->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('pla_ppa_proj_ati', $proj->getIdPpaProjAti(), $busca, $pdo)) {
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
    
    public function removerPpaProjAti(){
        try {
                                    
            if($this->idPpaProjAti == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $proj = new DaoPlaPpaProjAti();
            
            $proj->setIdPpaProjAti($this->idPpaProjAti);       
            
            $busca = $proj->retornaPpaProjAti($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_ppa_proj_ati', $proj->getIdPpaProjAti(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Projeto/Atividade do PPA.");
               $pdo->rollBack();
               return $retorno;
            }
            
            $resultDao = $proj->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Projeto/Atividade do PPA removido com Sucesso.");
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
    
    
    public function retornaTrPpaProjAtiPorPpaProg(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $proj = new DaoPlaPpaProjAti();
            $proj->setIdPpaProg($this->idPpaProg);
            
            $result = $proj->retornaPpaProjAtiPorPpaProg($pdo);            
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idPpaProjAti = $v['id_ppa_proj_ati'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" .$v['cd_ppa_proj_ati']." - ".$v['nm_ppa_proj_ati'] . "</td>"
                            . "<td>". $this->retornaTipo($v['tp_ppa_proj_ati'])."</td>"                                                       
                            . '<td style="text-align: center;">'                           
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_ppa_proj_ati'].'" '
                                . ' codigo="'.$v['cd_ppa_proj_ati'].'" '
                                . ' tipo="'.$v['tp_ppa_proj_ati'].'" '                                
                                . ' value=' . $idPpaProjAti . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i> Alterar                                 
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idPpaProjAti . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i> Remover
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
    
    
    public function retornaSelectPorVigencia($anoInicio, $anoFim){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $proj = new DaoPlaPpaProjAti();
                        
            $result = $proj->retornaTodosPpaProjAtiPorVigencia($anoInicio, $anoFim, $pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value='".$v['id_ppa_proj_ati']."'>".$v['cd_ppa_proj_ati']. " - " .$v['nm_ppa_proj_ati']." </option>";                                       
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    
}

?>
