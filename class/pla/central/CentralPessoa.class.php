<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaCentralPessoa.class.php";

/**
 * Representa se os Usuários que São de Alguma Central
 */
class CentralPessoa{    
    
    private $idCentralPessoa = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $sucesso = null;
    private $msgRetorno = null;
    
    
    function getIdCentralPessoa() {
        return $this->idCentralPessoa;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdCentralPessoa($idCentralPessoa) {
        $this->idCentralPessoa = $idCentralPessoa;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }
                      
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    
    public function cadastrar(){
        try {            
            if($this->idLotacao == "" || $this->idPessoa == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaCentralPessoa();
            
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdPessoa($this->idPessoa);       
            
            //Verifica se já está cadastrado, para não duplicar
            $dao->verificaPessoaCentral($pdo);            
            if($dao->Sucesso()){            
                $retorno = Metodos::retornoAjax("Erro", "alert", "Usuário já possui Permissão para esta Central.");
                $pdo->rollback();
                return $retorno;
            }                        
                                            
            $dao->insert($pdo);
            if(!$dao->Sucesso()){            
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $dao->setIdCentralPessoa($pdo->lastInsertId('pla_central_pessoa_id_central_pessoa_seq'));            
            
            if (Log::SalvaLogI('pla_central_pessoa', $dao->getIdCentralPessoa(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Cadastra o Perfil necessário do Planejamento, para o usuário
            $perfilPessoa = new PerfilPessoa();
            $perfilPessoa->setIdPerfil(PERFIL_PLANEJAMENTO_CENTRAL_DEMANDA);
            $perfilPessoa->setIdPessoa($dao->getIdPessoa());
            
            $result = $perfilPessoa->incluirPessoaPerfil($pdo);
            if(!$result){
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
    
        
    
    public function remover(){
        try {
                                    
            if($this->idCentralPessoa == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaCentralPessoa();
            
            $dao->setIdCentralPessoa($this->idCentralPessoa);       
            
            $dao->retorna($pdo);
            if($dao->Sucesso()){            
                if (!Log::SalvaLogD('pla_central_pessoa', $dao->getIdCentralPessoa(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Registro.");
               $pdo->rollBack();
               return $retorno;
            }
           
            $dao->delete($pdo);
            if(!$dao->Sucesso()){          
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            
            //Verifica se é a última unidade da Pessoa, caso seja irá remover o Perfil dele. 
            $dao->setIdPessoa($dao->getMsgRetorno()['id_pessoa']);                
            $perfilPessoa = new PerfilPessoa();
            $perfilPessoa->setIdPerfil(PERFIL_PLANEJAMENTO_CENTRAL_DEMANDA);
            $perfilPessoa->setIdPessoa($dao->getIdPessoa());
            $result = $perfilPessoa->removerPerfilPessoa($pdo);
            if(!$result){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
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
                                                       
    
    public function carregaPorPessoa(PDO $pdo = null){
        $this->sucesso = false;
        try {
            
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }   
            
            $dao = new DaoPlaCentralPessoa();
            $dao->setIdPessoa($this->idPessoa);
            
            $dao->retornaPorPessoa($pdo);
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $result = $dao->getMsgRetorno();
                $this->idCentralPessoa = $result['id_central_pessoa'];
                $this->idLotacao = $result['id_lotacao'];
                $this->idPessoa = $result['id_pessoa'];
                $this->sucesso = true;                
            }                                    
            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            
        }
    }
                             
    
    public function retornaUnidadesParaValidacao(PDO $pdo = null){
        $this->sucesso = false;           
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                        
            $item = new PtaItem();
            $item->retornaTrUnidadesParaValidarItens($this->idLotacao, $pdo);                                                       
            
            if(!$item->Sucesso()){                    
                return "";
            }else{                
                return $item->getMsgRetorno();                                               
            }                                    
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }                               
    }
    public function verificaPermissao(PDO $pdo = null){
        $this->sucesso = false;           
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                        
            $dao = new DaoPlaCentralPessoa();
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdPessoa($this->idPessoa);
            
            $dao->verificaPessoaCentral($pdo);                                                                               
            
            if($dao->Sucesso()){                    
                $this->sucesso = true;                
            }else{                
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                                                   
            }                                    
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }                               
    }
    
    /**
     * 
     * @param int $idPas
     * @param int $idCentral
     * @param int $perfil
     * @param PDO $pdo
     * @return string
     */
    public function retornaTbParaValidacaoCentralPas(int $idPas, int $perfil, PDO $pdo = null){
        $this->sucesso = false;           
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                                
            if($perfil == 0){
                $this->verificaPermissao($pdo);
                if(!$this->sucesso){                 
                    return STR_PERMISSAO_ACAO;
                }
            }                        
            
            $item = new PtaItem();
            $item->retornaTbDosItensPorCentralPasValidar($idPas, $this->idLotacao, $pdo);                                                       
            
            if(!$item->Sucesso()){
                return $item->getMsgRetorno();   
                return "";
            }else{                
                return $item->getMsgRetorno();                                               
            }                                    
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }                               
    }
    
    
    /**
     * @param int $ano
     * @param int $perfil
     * @param PDO $pdo
     * @return string
     */
    public function retornaTbItensDaCentral(int $ano, int $perfil, PDO $pdo = null){
        $this->sucesso = false;           
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                                
            if($perfil == 0){
                $this->verificaPermissao($pdo);
                if(!$this->sucesso){                 
                    return STR_PERMISSAO_ACAO;
                }
            }                        
            
            $item = new PtaItem();            
            $item->retornaTbDosItensPorCentralAno((int)$ano, (int)$this->idLotacao, $pdo);                                                       
            
            if(!$item->Sucesso()){
                return $item->getMsgRetorno();   
                return "";
            }else{                
                return $item->getMsgRetorno();                                               
            }                                    
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }                               
    }
    
    
    public function retornaTrCentralResponsaveis(PDO $pdo = null){
        $retorno = "";
        try {
            
            
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }   
            
            $dao = new DaoPlaCentralPessoa();            
            
            $dao->retornaTodos($pdo);
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                   
            }else{
                $result = $dao->getMsgRetorno();                
                $this->sucesso = true;                
                
                foreach ($result as $v) {
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_pessoa'] . "</td>"
                            . "<td>" . $v['nm_lotacao'] . "</td>"                            
                            . '<td style="text-align: center;">'                                                                                   
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $v['id_central_pessoa'] . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>'
                            . "</tr>";                                                                              
                    $retorno .= "</tr>";
                }
                
            }                                    
            
            return $retorno;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();   
            return $retorno;
        }
    }
    
    
                                       
}

?>
