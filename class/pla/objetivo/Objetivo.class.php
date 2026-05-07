<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaObjetivo.class.php";

class Objetivo{
    
    private $idObjetivo = null;     
    private $idDiretriz = null;    
    private $nmObjetivo = null;    
    private $nrOrdem = null;
    private $idPes = null;
    private $idEixo = null; 
    
    function getIdPes() {
        return $this->idPes;
    }

    function getIdEixo() {
        return $this->idEixo;
    }

    function setIdPes($idPes) {
        $this->idPes = $idPes;
    }

    function setIdEixo($idEixo) {
        $this->idEixo = $idEixo;
    }
    
    function getIdObjetivo() {
        return $this->idObjetivo;
    }

    function getIdDiretriz() {
        return $this->idDiretriz;
    }

    function getNmObjetivo() {
        return $this->nmObjetivo;
    }

    function getNrOrdem() {
        return $this->nrOrdem;
    }

    function setIdObjetivo($idObjetivo) {
        $this->idObjetivo = $idObjetivo;
    }

    function setIdDiretriz($idDiretriz) {
        $this->idDiretriz = $idDiretriz;
    }

    function setNmObjetivo($nmObjetivo) {
        $this->nmObjetivo = $nmObjetivo;
    }

    function setNrOrdem($nrOrdem) {
        $this->nrOrdem = $nrOrdem;
    }

                                              
    public function cadastrarObjetivo(){
        try {            
            if($this->nmObjetivo == "" || $this->idDiretriz == "" || $this->nrOrdem == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $obj = new DaoPlaObjetivo();
            
            $obj->setIdDiretriz($this->idDiretriz);
            $obj->setNmObjetivo($this->nmObjetivo);            
            $obj->setNrOrdem($this->nrOrdem);
                                            
            $result = $obj->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $obj->setIdObjetivo($pdo->lastInsertId('pla_objetivo_id_objetivo_seq'));            
            
            if (Log::SalvaLogI('pla_objetivo', $obj->getIdObjetivo(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Objetivo Realizado com Sucesso.");
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
    
    
    public function editarObjetivo(){
        try {
            if($this->nmObjetivo == "" || $this->idDiretriz == "" || $this->nrOrdem == ""
                    || $this->idObjetivo == ""){                   
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $obj = new DaoPlaObjetivo();
            
            $obj->setIdObjetivo($this->idObjetivo);
            $obj->setIdDiretriz($this->idDiretriz);
            $obj->setNmObjetivo($this->nmObjetivo);            
            $obj->setNrOrdem($this->nrOrdem);
                                                
            $busca = $obj->retornaObjetivo($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $obj->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('pla_objetivo', $obj->getIdObjetivo(), $busca, $pdo)) {
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
    
    public function removerObjetivo(){
        try {
                                    
            if($this->idObjetivo == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $obj = new DaoPlaObjetivo();
            
            $obj->setIdObjetivo($this->idObjetivo);       
            
            $busca = $obj->retornaObjetivo($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_objetivo', $obj->getIdObjetivo(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Objetivo.");
               $pdo->rollBack();
               return $retorno;
            }
           
            $resultDao = $obj->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Objetivo removido com Sucesso.");
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
    
    
    public function retornaTrObjetivoPorDiretriz(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $obj = new DaoPlaObjetivo();
            $obj->setIdDiretriz($this->idDiretriz);
            
            $result = $obj->retornaTodosObjetivoPorDiretriz($pdo);
            
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $id = $v['id_objetivo'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nr_ordem'].". " . $v['nm_objetivo'] . "</td>"                                                        
                            . '<td style="text-align: center;">'
                            . '<a href="../acao/index.php?token='.$id.'" class="btn btn-default btn-entrar btn-xs" title="Ação"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                              </a> '                          
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_objetivo'].'" '
                                . ' nr_ordem="'.$v['nr_ordem'].'" '                                
                                . ' value=' . $id . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $id . ' >
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
    
    public function carregaInfoObjetivo(int $idObjetivo){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $obj = new DaoPlaObjetivo();            
            $obj->setIdObjetivo($idObjetivo);                          
            $result = $obj->retornaDadosCompleto($pdo);  
            
            if (!$result) {
                
            } else {
                $this->idObjetivo = $result['id_objetivo'];
                $this->idDiretriz = $result['id_diretriz'];
                $this->nmObjetivo = $result['nm_objetivo'];
                $this->nrOrdem = $result['ordemeixo'].".".$result['ordemdiretriz'].".".$result['ordemobjetivo'];
                $this->idEixo = $result['id_eixo'];  
                $this->idPes = $result['id_pes'];
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function retornaList(){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $obj = new DaoPlaObjetivo();
            $obj->setIdObjetivo($this->idObjetivo);                          
            $result = $obj->retornaDadosCompleto($pdo);
            
            if (!$result) {
                return $retorno;
            } else {       
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>PES:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_pes']."</div>";                    
                $retorno .= "</div>";
                
                 $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Eixo:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ordemeixo'].". ".$result['nm_eixo']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Projeto do PPA:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['Projeto/Atividade do PPA']."</div>";                    
                $retorno .= "</div>";                                                                                                                         
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Diretriz:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ordemeixo'].".".$result['ordemdiretriz'].". ".$result['nm_diretriz']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Objetivo:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ordemeixo'].".".$result['ordemdiretriz'].".".$result['ordemobjetivo'].". ".$result['nm_objetivo']."</div>";                    
                $retorno .= "</div>";
                                                                                                                                                 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    public function retornaOptionObjetivos(){
        $retorno = "";
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $obj = new DaoPlaObjetivo();

            $result = $obj->retornaObjetivoSelect($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '".$v['id_objetivo']."'>".$v['nm_objetivo'] ."</option>";
                }
            }

            return $retorno;




        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    /**
     * Retorna os Options do Select das Objetivos de Acordo com uma Diretriz
     * @return string
     */
    public function retornaOptionPorDiretriz(){
        $retorno = "";
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $obj = new DaoPlaObjetivo();
            $obj->setIdDiretriz($this->idDiretriz);
            $result = $obj->retornaTodosObjetivoPorDiretriz($pdo);
            $retorno .= "<option value=0>Selecione um Objetivo</option>";
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '".$v['id_objetivo']."'>".$v['nr_ordem'].". ".$v['nm_objetivo'] ."</option>";
                }
            }

            return $retorno;




        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    
    
}

?>
