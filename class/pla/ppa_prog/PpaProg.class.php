<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPpaProg.class.php";

class PpaProg{
    
    private $idPpaProg = null;
    private $nmPpaProg = null;
    private $aaInicio = null;
    private $aaFim = null;
    private $cdPpaProg = null;
    
    function getCdPpaProg() {
        return $this->cdPpaProg;
    }

    function setCdPpaProg($cdPpaProg) {
        $this->cdPpaProg = $cdPpaProg;
    }
        
    public function getIdPpaProg() {
        return $this->idPpaProg;
    }

    public function getNmPpaProg() {
        return $this->nmPpaProg;
    }

    public function setIdPpaProg($idPpaProg) {
        $this->idPpaProg = $idPpaProg;
    }

    public function setNmPpaProg($nmPpaProg) {
        $this->nmPpaProg = $nmPpaProg;
    }       
    
    function getAaInicio() {
        return $this->aaInicio;
    }

    function getAaFim() {
        return $this->aaFim;
    }

    function setAaInicio($aaInicio) {
        $this->aaInicio = $aaInicio;
    }

    function setAaFim($aaFim) {
        $this->aaFim = $aaFim;
    }

                              
    public function cadastrarPpaProg(){
        try {
            
            if($this->nmPpaProg == "" || $this->aaFim == ""
                    || strlen($this->aaInicio) != 4 || strlen($this->aaFim) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $prog = new DaoPlaPpaProg();
            
            $prog->setNmPpaProg($this->nmPpaProg);
            $prog->setCdPpaProg($this->cdPpaProg);
            $prog->setAaInicio($this->aaInicio);
            $prog->setAaFim($this->aaFim);
            
                                            
            $result = $prog->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $prog->setIdPpaProg($pdo->lastInsertId('pla_ppa_prog_id_ppa_prog_seq'));            
            
            if (Log::SalvaLogI('pla_ppa_prog', $prog->getIdPpaProg(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
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
    
    
    public function editarPpaProg(){
        try {
                                    
            if($this->idPpaProg == "" || $this->idPpaProg == 0
                    || $this->nmPpaProg == "" || $this->aaInicio == "" 
                    || $this->aaFim == ""
                    || strlen($this->aaInicio) != 4 || strlen($this->aaFim) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $prog = new DaoPlaPpaProg();
            
            $prog->setIdPpaProg($this->idPpaProg);
            $prog->setNmPpaProg($this->nmPpaProg);
            $prog->setCdPpaProg($this->cdPpaProg);
            $prog->setAaInicio($this->aaInicio);
            $prog->setAaFim($this->aaFim);
                        
                        
            $busca = $prog->retornaPpaProg($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $prog->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('pla_ppa_prog', $prog->getIdPpaProg(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }
                                                                                                                                 
                                            
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
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
    
    public function removerPpaProg(){
        try {
                                    
            if($this->idPpaProg == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $prog = new DaoPlaPpaProg();
            
            $prog->setIdPpaProg($this->idPpaProg);       
            
            $busca = $prog->retornaPpaProg($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_ppa_prog', $prog->getIdPpaProg(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Programa PPA.");
               $pdo->rollBack();
               return $retorno;
            }
            
            $resultDao = $prog->delete($pdo);
            if ($resultDao != "Sucesso"){
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
    
    
    public function retornaTrPpaProg(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $prog = new DaoPlaPpaProg();
            
            $result = $prog->retornaTodosPpaProg($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idPpaProg = $v['id_ppa_prog'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['cd_ppa_prog'] ." - ".$v['nm_ppa_prog']. "</td>"                            
                            . "<td>" . $v['aa_inicio'] ." - ".$v['aa_fim'].  "</td>"                            
                            . '<td style="text-align: center;">'                           
                            . '<a href="../ppa_proj_ati/index.php?token='.$idPpaProg.'" class="btn btn-default btn-entrar btn-xs" title="Visualizar Projeto/Atividade do PPA"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i> Entrar
                              </a> '
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_ppa_prog'].'" '
                                . ' codigo="'.$v['cd_ppa_prog'].'" '
                                . ' aa_inicio="'.$v['aa_inicio'].'" '
                                . ' aa_fim="'.$v['aa_fim'].'" '
                                . ' value=' . $idPpaProg . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i> Alterar                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idPpaProg . ' >
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
    
           
    
    
    public function carregaDados(int $idPpaProg){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaPpaProg();            
            $dao->setIdPpaProg($idPpaProg);                          
            $result = $dao->retornaPpaProg($pdo);  
            
            if (!$result) {
                
            } else {                                
                
                $this->idPpaProg = $result['id_ppa_prog'];
                $this->nmPpaProg = $result['nm_ppa_prog'];
                $this->cdPpaProg = $result['cd_ppa_prog'];
                $this->aaInicio = $result['aa_inicio'];
                $this->aaFim = $result['aa_fim'];                
                
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    
}

?>
