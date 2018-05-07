<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesVinculo.class.php";

class Vinculo{
    
    private $idVinculo = null;
    private $nmVinculo = null;
    
    function getIdVinculo() {
        return $this->idVinculo;
    }
    function getNmVinculo() {
        return $this->nmVinculo;
    }
    function setIdVinculo($idVinculo) {
        $this->idVinculo = $idVinculo;
    }
    function setNmVinculo($nmVinculo) {
        $this->nmVinculo = $nmVinculo;
    }
                          
    public function cadastrarVinculo(){
        try {
                                    
            if($this->nmVinculo == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $vinculo = new DaoSesVinculo();
            
            $vinculo->setNmVinculo($this->nmVinculo);
            
            $busca = $vinculo->buscaVinculoPorNome($vinculo, $pdo);
            
            if (!$busca) {
                //return $retorno;            
            } else {
               $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe um Vínculo com esse nome.");
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $vinculo->insert($vinculo, $pdo);                
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $vinculo->setIdVinculo($pdo->lastInsertId('ses_vinculo_id_vinculo_seq'));            
            
            if (Log::SalvaLogI('ses_vinculo', $vinculo->getIdVinculo(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Novo Vínculo Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }                                                                                       

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    public function editarVinculo(){
        try {
                                    
            if($this->nmVinculo == "" || $this->idVinculo == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $vinculo = new DaoSesVinculo();
            
            $vinculo->setIdVinculo($this->idVinculo);
            $vinculo->setNmVinculo($this->nmVinculo);
                        
            $busca = $vinculo->buscaVinculoPorNome($vinculo, $pdo);
            
            if (!$busca) {
                //return $retorno;            
            } else {
               $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe um Vínculo com esse nome.");
                $pdo->rollBack();
                return $retorno;
            }
            
            $busca = $vinculo->retornaVinculo($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }
                    
            $result = $vinculo->update($vinculo, $pdo);                
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            
            if (!Log::SalvaLogU('ses_vinculo', $vinculo->getIdVinculo(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }
                                                                                                                                 
                                            
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição do Vínculo Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }                                                                                       

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    public function removerVinculo(){
        try {
                                    
            if($this->idVinculo == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $vinculo = new DaoSesVinculo();            
            $vinculo->setIdVinculo($this->idVinculo);            
            
            $busca = $vinculo->retornaVinculo($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('ses_vinculo', $vinculo->getIdVinculo(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Vínculo.");
               $pdo->rollBack();
               return $retorno;
            }
            
            $resultDao = $vinculo->delete($vinculo, $pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Vínculo removido com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }                                                                                       

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    public function retornaTrVinculos(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $vinculo = new DaoSesVinculo();
            
            $result = $vinculo->retornaVinculos($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idVinculo = $v['id_vinculo'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_vinculo'] . "</td>"                          
                            . '<td style="text-align: center;">'                           
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_vinculo'].'" value=' . $idVinculo . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idVinculo . ' >
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
    public function retornaOptionVinculo($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $vinculo = new DaoSesVinculo();
            $result = $vinculo->retornaVinculos($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if($v['id_vinculo'] == $id){
                        $retorno .= "<option selected value = '" . $v['id_vinculo'] . "'>" . $v['nm_vinculo'] ."</option>";
                    }else{
                        $retorno .= "<option value = '" . $v['id_vinculo'] . "'>" . $v['nm_vinculo'] ."</option>";
                    }
                    
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    
}

?>
