<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/perfil_pessoa/PerfilPessoa.class.php";

class Perfil{
        
    private $idPessoa = null;
    private $idPerfil = null;    
    private $idPerfilPessoa = null;

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
        return $this;
    }
    
    function getIdPerfilPessoa() {
        return $this->idPerfilPessoa;
    }

    function setIdPerfilPessoa($idPerfilPessoa) {
        $this->idPerfilPessoa = $idPerfilPessoa;
        return $this;
    }
        
    private function getPerfisContabil(){
        $array = array(
            PERFIL_CONTABIL_ADMINISTRACAO =>  "Perfil Contábil Administração",
            PERFIL_CONTABIL_EMPENHO_ANULACAO => "Perfil Contábil Empenho Anulacão",
            PERFIL_CONTABIL_LIQUIDACAO => "Perfil Contábil Liquidação",
            PERFIL_CONTABIL_PAGAMENTO =>  "Perfil Contábil Pagamento",
            PERFIL_CONTABIL_ZEUS => "Perfil Contábil Zeus"
            );
        return $array;
    }
        
                              
    public function cadastrar(){
        try {            
            if(empty($this->idPessoa) || empty($this->idPerfil)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $perfilPessoa = new PerfilPessoa();
            
            $perfilPessoa->setIdPerfil($this->idPerfil);
            $perfilPessoa->setIdPessoa($this->idPessoa);                                   
                                            
            $result = $perfilPessoa->incluirPessoaPerfil($pdo);
            if(!$result){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
           
            $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            $pdo->commit();
            return $retorno;                                                                                                          
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
        
    
    public function remover(){
        try {
                                    
            if(empty($this->idPerfil) || empty($this->idPessoa)){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $perfilPessoa = new PerfilPessoa();
            
            $perfilPessoa->setIdPessoa($this->idPessoa);
            $perfilPessoa->setIdPerfil($this->idPerfil);
            $result = $perfilPessoa->removerPerfilPessoa($pdo);                        
            if(!$result){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }   
            
            $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            $pdo->commit();
            return $retorno;                                                                                                
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    public function retornaSelectPerfis(PDO $pdo = null){
        $retorno = "";                
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $array = $this->getPerfisContabil();    
           
            foreach ($array as $key => $value) {
                $retorno .= "<option value=".$key.">".$value."</option>";    
            }
                     
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    
    public function retornaTrTodos(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $perfilPessoa = new PerfilPessoa();                 
            $perfis = implode(",", array_keys($this->getPerfisContabil()));                                    
            $perfilPessoa->retornaPessoasPorINPerfil($perfis, $pdo);
                        
            if($perfilPessoa->Sucesso()){                
                $result = $perfilPessoa->getMsgRetorno();                
                foreach ($result as $v) {
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pessoa']."</td>"
                            . "<td>" . $v['nm_perfil'].  "</td>"                            
                            . '<td style="text-align: center;">'                                                                                
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $v['id_perfil'] . ' data-id='.$v['id_pessoa'].'>
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
    
   
    

  
    
          
    
    
    
           
}

?>
