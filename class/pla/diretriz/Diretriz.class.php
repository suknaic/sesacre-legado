<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaDiretriz.class.php";

class Diretriz{
    
    private $idDiretriz = null;
    private $idEixo = null;     
    private $nmDiretriz = null;    
    private $nrOrdem = null;
    private $idPes = null;

   
    function getIdDiretriz() {
        return $this->idDiretriz;
    }

    function getIdEixo() {
        return $this->idEixo;
    }

    function getNmDiretriz() {
        return $this->nmDiretriz;
    }

    function getNrOrdem() {
        return $this->nrOrdem;
    }

    function setIdDiretriz($idDiretriz) {
        $this->idDiretriz = $idDiretriz;
    }

    function setIdEixo($idEixo) {
        $this->idEixo = $idEixo;
    }

    function setNmDiretriz($nmDiretriz) {
        $this->nmDiretriz = $nmDiretriz;
    }

    function setNrOrdem($nrOrdem) {
        $this->nrOrdem = $nrOrdem;
    }
    
    function getIdPes() {
        return $this->idPes;
    }

    function setIdPes($idPes) {
        $this->idPes = $idPes;
    }

    
        
    
                              
    public function cadastrarDiretriz(){
        try {            
            if($this->nmDiretriz == "" || $this->idEixo == "" || $this->nrOrdem == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dir = new DaoPlaDiretriz();
            
            $dir->setNmDiretriz($this->nmDiretriz);
            $dir->setIdEixo($this->idEixo);            
            $dir->setNrOrdem($this->nrOrdem);
                                            
            $result = $dir->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $dir->setIdDiretriz($pdo->lastInsertId('pla_diretriz_id_diretriz_seq'));            
            
            if (Log::SalvaLogI('pla_diretriz', $dir->getIdDiretriz(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Diretriz Realizada com Sucesso.");
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
    
    
    public function editarDiretriz(){
        try {
            if($this->nmDiretriz == "" || $this->idEixo == "" || $this->nrOrdem == ""
                    || $this->idDiretriz == ""){                   
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dir = new DaoPlaDiretriz();
            
            $dir->setIdDiretriz($this->idDiretriz);
            $dir->setNmDiretriz($this->nmDiretriz);
            $dir->setIdEixo($this->idEixo);            
            $dir->setNrOrdem($this->nrOrdem);
                                                
            $busca = $dir->retornaDiretriz($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $dir->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('pla_diretriz', $dir->getIdDiretriz(), $busca, $pdo)) {
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
    
    public function removerDiretriz(){
        try {
                                    
            if($this->idDiretriz == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dir = new DaoPlaDiretriz();
            
            $dir->setIdDiretriz($this->idDiretriz);       
            
            $busca = $dir->retornaDiretriz($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_diretriz', $dir->getIdDiretriz(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar a Diretriz.");
               $pdo->rollBack();
               return $retorno;
            }
           
            $resultDao = $dir->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Diretriz removida com Sucesso.");
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
    
    
    public function retornaTrDiretrizesPorEixo(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dir = new DaoPlaDiretriz();
            $dir->setIdEixo($this->idEixo);
            
            $result = $dir->retornaTodasDiretrizesPorEixo($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idDiretriz = $v['id_diretriz'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nr_ordem'].". " . $v['nm_diretriz'] . "</td>"                                                        
                            . '<td style="text-align: center;">'
                            . '<a href="../objetivo/index.php?token='.$idDiretriz.'" class="btn btn-default btn-entrar btn-xs" title="Objetivo"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                              </a> '                          
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_diretriz'].'" '
                                . ' nr_ordem="'.$v['nr_ordem'].'" '                                
                                . ' value=' . $idDiretriz . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idDiretriz . ' >
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
    
    
    public function carregaInfoDiretriz(int $idDiretriz){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dir = new DaoPlaDiretriz();            
            $dir->setIdDiretriz($idDiretriz);                          
            $result = $dir->retornaDadosCompleto($pdo);              
                        
            if (!$result) {
                
            } else {
                $this->idDiretriz = $result['id_diretriz'];
                $this->nmDiretriz = $result['nm_diretriz'];
                $this->nrOrdem = $result['ordemeixo'].".".$result['ordemdiretriz'];
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
            $dir = new DaoPlaDiretriz();
            $dir->setIdDiretriz($this->idDiretriz);                          
            $result = $dir->retornaDadosCompleto($pdo);
          
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
                                                                                                                                                 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    /**
     * Retorna os Options do Select das Diretrizes de Acordo com um Eixo
     * @return string
     */
    public function retornaOptionPorEixo(){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaDiretriz();
            $dao->setIdEixo($this->idEixo);
            $result = $dao->retornaTodasDiretrizesPorEixo($pdo);
            
            $retorno .= "<option value='0'>Selecione um Eixo</option>";                  
            if (!$result) {
                return $retorno;
            } else {                         
                foreach ($result as $value) {                    
                    $retorno .= "<option value=".$value['id_diretriz'].">"
                            . $value['nr_ordem'].". ".$value['nm_diretriz']
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
