<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaTipoGastoCategoria.class.php";


class TipoGastoCategoria{
    
    private $idTipoGastoCategoria = null;
    private $nmTipoGastoCategoria = null;    
    private $idLotacao = null;
    private $idTipoGasto = null;
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    function getIdTipoGastoCategoria() {
        return $this->idTipoGastoCategoria;
    }

    function getNmTipoGastoCategoria() {
        return $this->nmTipoGastoCategoria;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function setIdTipoGastoCategoria($idTipoGastoCategoria) {
        $this->idTipoGastoCategoria = $idTipoGastoCategoria;
        return $this;
    }

    function setNmTipoGastoCategoria($nmTipoGastoCategoria) {
        $this->nmTipoGastoCategoria = $nmTipoGastoCategoria;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
        return $this;
    }       
   

    
    /**
     * Cadastra/Edita Um registro Referente a essa classe     
     * @return string
     */                                    
    public function salvar(){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->idTipoGasto == 0 || $this->nmTipoGastoCategoria == ""
                    || $this->idLotacao == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                                           
            
            //Seta os Campos
            $dao = new DaoPlaTipoGastoCategoria();
            $dao->setNmTipoGastoCategoria($this->nmTipoGastoCategoria);
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdTipoGasto($this->idTipoGasto);
            
            
            //Verifica se é insert ou edição
            $inserir = 0;
            if($this->idTipoGastoCategoria == "" 
                    || $this->idTipoGastoCategoria == 0){                
                $inserir = 1;
            }else{
                $dao->setIdTipoGastoCategoria($this->idTipoGastoCategoria);
            }
            
            
            
            if($inserir == 1){
                        
            //Insere o Registro no banco
            $result = $dao->insert($pdo);
                if ($result != "Sucesso") {
                    $retorno = Metodos::retornoAjax("Erro", "console", $result);
                    $pdo->rollBack();
                    return $retorno;
                }
                //Pega o ID Inserido                                                                                         
                $dao->setIdTipoGastoCategoria($pdo->lastInsertId('pla_tipo_gasto_categoria_id_tipo_gasto_categoria_seq'));            
                //Salva no Log
                $sucesso = false;
                if (Log::SalvaLogI('pla_tipo_gasto_categoria', $dao->getIdTipoGastoCategoria(), $pdo)) {
                    $sucesso = true;
                }else{
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }            
            }else{
                $busca = $dao->retorna($pdo);
            
                if (!$busca){
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }

                $result = $dao->update($pdo);
                if ($result != "Sucesso") {
                    $retorno = Metodos::retornoAjax("Erro", "console", $result);
                    $pdo->rollBack();
                    return $retorno;
                }

                if (!Log::SalvaLogU('pla_tipo_gasto_categoria', $dao->getIdTipoGastoCategoria(), $busca, $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }else{
                    $sucesso = true;
                }   
            }
            
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                 if($inserir == 1){
                    $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                }else{
                    $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                }
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                                                                       
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    /**
     * Remove Um registro Referente a essa classe
     * @return string
     */
    public function remover($perfil){
        try {
            
            //Verifica se enviou o campo.                   
            if($this->idTipoGastoCategoria == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                 
                        
            //Seta os Campos
            $dao = new DaoPlaTipoGastoCategoria();
            
            $dao->setIdTipoGastoCategoria($this->idTipoGastoCategoria);    
            
            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $dao->retorna($pdo);
                                                                     
            
            //Salva no Log            
            if ($busca){
                if (!Log::SalvaLogD('pla_tipo_gasto_categoria', $dao->getIdTipoGastoCategoria(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar a Categoria do Tipo de Gasto.");
               $pdo->rollBack();
               return $retorno;
            }
                                                
            //Remove o Registro no banco
            $resultDao = $dao->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                                                                                                                                                              
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Categoria do Tipo de Gasto removido com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }        
            
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
        
    /**
     * Retorna options para o select contendo o nome da lotacao como atributo no option
     * @param int $idTipoGasto
     * @param type $pdo
     * @return string
     */
    public function retornaOptionComLotacao(int $idTipoGasto = null, $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoPlaTipoGastoCategoria();
            $dao->setIdTipoGasto($idTipoGasto);
                                    
            $result = $dao->retornaTodosPorTipoGasto($pdo);
                                                                                    
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {                   
                    $retorno .= "<option value=".$v['id_tipo_gasto_categoria']." lotacao='".$v['nm_lotacao']."'>".$v['nm_tipo_gasto_categoria']."</option>";                    
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function carregaTipoGastoCategoria(PDO $pdo = null){
        $this->sucesso = false;              
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoPlaTipoGastoCategoria();
            $dao->setIdTipoGastoCategoria($this->idTipoGastoCategoria);
                                    
            $result = $dao->retorna($pdo);
                                                                      
            if (!$result) {
                $this->sucesso = false;
                $this->msgRetorno = $result;                
            } else {
                $this->sucesso = true;
                $this->idLotacao = $result['id_lotacao'];
                $this->idTipoGasto = $result['id_tipo_gasto'];
                $this->nmTipoGastoCategoria = $result['nm_tipo_gasto_categoria'];                                                
            }                                                  
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            
        }
    }
}

?>
