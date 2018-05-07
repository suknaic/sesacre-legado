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
        
    private function getPerfisPlanejamento(){
        $array = array(
                PERFIL_PLANEJAMENTO => "Perfil Planejamento",
                PERFIL_PLANEJAMENTO_ZEUS => "Perfil Planejamento Zeus",
                PERFIL_PLANEJAMENTO_SEC_ADJ_PLA_GESTAO => "Perfil Sec. Adjunto de Planejamento e Gestão",
                PERFIL_PLANEJAMENTO_SEC_ADJ_ADM_FINAN => "Perfil Sec. Adjunto de Administração e Finanças",
                PERFIL_PLANEJAMENTO_SEC_ADJ_ATE_SAUDE => "Perfil Sec. Adjunto de Atenção e Saúde",
                PERFIL_PLANEJAMENTO_SEC_GERAL => "Perfil Sec. Geral",
                PERFIL_PLANEJAMENTO_CONSELHO => "Perfil Conselho"
                
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
            
            $array = $this->getPerfisPlanejamento();    
           
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
            $perfis = implode(",", array_keys($this->getPerfisPlanejamento()));                                    
            $perfilPessoa->retornaPessoasPorINPerfil($perfis, $pdo);
                        
            if($perfilPessoa->Sucesso()){                
                $result = $perfilPessoa->getMsgRetorno();                
                foreach ($result as $v) {
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pessoa']."</td>"
                            . "<td>" . $v['nm_perfil'].  "</td>"                            
                            . '<td style="text-align: center;">'                                                                                
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $v['id_perfil'] . ' dataid='.$v['id_pessoa'].'>
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
