<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPasAcaoIndicador.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";


class PasAcaoIndicador{
    
    private $idPasAcaoIndicador = null;
    private $idPas = null;
    private $idAcao = null;
    private $idIndicadorSaude = null;
    private $sucesso = null;
    private $msgRetorno = null;     
   
    function getMsgRetorno(){
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
   
    function getIdPasAcaoIndicador() {
        return $this->idPasAcaoIndicador;
    }

    function getIdPas() {
        return $this->idPas;
    }

    function getIdAcao() {
        return $this->idAcao;
    }

    function getIdIndicadorSaude() {
        return $this->idIndicadorSaude;
    }

    function setIdPasAcaoIndicador($idPasAcaoIndicador) {
        $this->idPasAcaoIndicador = $idPasAcaoIndicador;
        return $this;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
        return $this;
    }

    function setIdAcao($idAcao) {
        $this->idAcao = $idAcao;
        return $this;
    }

    function setIdIndicadorSaude($idIndicadorSaude) {
        $this->idIndicadorSaude = $idIndicadorSaude;
        return $this;
    }

       
        
    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */                                    
    public function cadastrar($perfil = 0){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->idPas == "" || $this->idAcao == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            if(count($this->idIndicadorSaude) <= 0){
                return Metodos::retornoAjax("Erro", "alert", "Não foi selecionado nenhum Indicador de Saúde");
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                                
            }
            
            //Seta os Campos
            $dao = new DaoPlaPasAcaoIndicador();
                        
            $dao->setIdAcao($this->idAcao);
            $dao->setIdPas($this->idPas);            
            $sucesso = false;
            
            foreach ($this->idIndicadorSaude as $value) {                    
                    $dao->setIdIndicadorSaude($value);

                $result = $dao->insert($pdo);
                if ($result != "Sucesso") {
                    if($result == "Duplicado"){
                        $retorno = Metodos::retornoAjax("Erro", "alert", "Essa Ação já está cadastrada com Indicadores, caso quero adicionar novas, basta editar a Ação.");
                        $pdo->rollBack();
                        return $retorno;
                    }
                    $retorno = Metodos::retornoAjax("Erro", "console", $result);
                    $pdo->rollBack();
                    return $retorno;
                }

                $dao->setIdPasAcaoIndicador($pdo->lastInsertId('pla_pas_acao_indicador_id_pas_acao_indicador_seq'));            

                if (Log::SalvaLogI('pla_pas_acao_indicador', $dao->getIdPasAcaoIndicador(), $pdo)) {
                    $sucesso = true;
                }else{
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }

            }
            
                                              
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação com Indicadores de Saúde Realizada com Sucesso.");
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
     * Edita Um registro Referente a essa classe
     * @return string
     */
    public function editar($perfil){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->idPas == "" || $this->idAcao == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            if(count($this->idIndicadorSaude) <= 0){
                return Metodos::retornoAjax("Erro", "alert", "Não foi selecionado nenhum Indicador de Saúde.");
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                                            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                                
            }
            
            //Seta os Campos
            $dao = new DaoPlaPasAcaoIndicador();
                        
            $dao->setIdAcao($this->idAcao);
            $dao->setIdPas($this->idPas);                      
            $sucesso = false;
            
            
            if(count($this->idIndicadorSaude) > 0){               
                $idsAdd = array();
                $idsRem = array();
                //Organiza os Ids dos indicadores de saúde.
                //Um para remover e outro para adicionar
                foreach ($this->idIndicadorSaude as $dados) {
                    if($dados[0] == 'rem'){
                        $idsRem[] = $dados[1];
                    }else if ($dados[0] == 'add'){
                        $idsAdd[] = $dados[1];
                    }
                }                                                
            }else{
                return Metodos::retornoAjax("Erro", "alert", "Não foi selecionado nenhum Indicador de Saúde.");
            }
            
            
            //Remover os Indicadores de Saúde selecionado
            if(count($idsRem) > 0){
                $ids = implode(", ", array_map('intval', $idsRem));                    
                //Retorna os Pas Acao Indicadores de Saúde                
                $idsRetorno = $dao->retornaTodosPorPasAcaoINIndicador($ids, $pdo);
                if($idsRetorno == FALSE){
                    return Metodos::retornoAjax("Erro", "alert", "Não foi selecionado nenhum Indicador de Saúde.");
                }                
                foreach ($idsRetorno as $value) {   
                    $dao->setIdPasAcaoIndicador($value['id_pas_acao_indicador']);
                    $busca = $dao->retorna($pdo);
                    if ($busca){
                        if (!Log::SalvaLogD('pla_pas_acao_indicador', $dao->getIdPasAcaoIndicador(), $pdo)) {
                            $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                            $pdo->rollBack();
                            return $retorno;
                        }                
                    } else {
                       $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar Indicador de Saúde.");
                       $pdo->rollBack();
                       return $retorno;
                    }

                    $resultDao = $dao->delete($pdo);
                    if ($resultDao != "Sucesso"){
                        $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                        $pdo->rollBack();
                        return $retorno;
                    }
                    $sucesso = true;
                }
            }
            
            //Adicionar os Projetos/Atividade Selecionado
            if(count($idsAdd) > 0){
                foreach ($idsAdd as $value) {  
                    $dao->setIdIndicadorSaude($value);
                    $result = $dao->insert($pdo);
                    if ($result != "Sucesso") {
                        if($result == "Duplicado"){
                            $retorno = Metodos::retornoAjax("Erro", "alert", "Essa Ação já está cadastrada com Indicadores, caso quero adicionar novas, basta editar a Ação.");
                            $pdo->rollBack();
                            return $retorno;
                        }
                        $retorno = Metodos::retornoAjax("Erro", "console", $result);
                        $pdo->rollBack();
                        return $retorno;
                    }

                    $dao->setIdPasAcaoIndicador($pdo->lastInsertId('pla_pas_acao_indicador_id_pas_acao_indicador_seq'));            

                    if (Log::SalvaLogI('pla_pas_acao_indicador', $dao->getIdPasAcaoIndicador(), $pdo)) {
                        $sucesso = true;
                    }else{
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }                     
                }                                        
            }  
           
                                                                                                                                 
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                              
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição Realizada com Sucesso.");
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
            if($this->idPas == 0 || $this->idAcao == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                        
                        
            //Seta os Campos
            $dao = new DaoPlaPasAcaoIndicador();
                        
            $dao->setIdAcao($this->idAcao);
            $dao->setIdPas($this->idPas);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                                
            }
            
            
            $result = $dao->retornaTodosPorPasAcao($pdo);             
            if($result){              
                if(count($result) > 0){
                    foreach ($result as $value) {
                        $dao->setIdPasAcaoIndicador($value['id_pas_acao_indicador']);
                        $busca = $dao->retorna($pdo);
                        
                        if ($busca){
                            if (!Log::SalvaLogD('pla_pas_acao_indicador', $dao->getIdPasAcaoIndicador(), $pdo)) {
                                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                                $pdo->rollBack();
                                return $retorno;
                            }                
                        } else {
                           $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Indicador de Saúde.");
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
                }else{
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }
            }else{
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
                                            
            $retorno = Metodos::retornoAjax("ok", "html", "Ação removido com Sucesso.");
            $pdo->commit();
            return $retorno;                                     
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    /**
     * Retorna as Trs para a Tabela da da PAS Indicadores de Saúde
     * @return string
     */
    public function retornaTrPasAcao(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPasAcaoIndicador();
            
            $pas->setIdPas($this->idPas);
                                    
            $result = $pas->retornaTodasAcoesIndicadoresPorPas($pdo);                                                                       
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $id = $v['id_acao'];                    
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_acao']."</td>"
                            . "<td>".$v['nm_indicador_saude']."</td>"                            
                            . '<td style="text-align: center;">'                            
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" '                                                                
                                . ' value='.$id.'>
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" nome="'.$v['nm_acao'].'" title="Remover" value=' . $id . ' >
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
    
    
    public function retornaDadosParaEdicao(){
        
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaPasAcaoIndicador();            
            $dao->setIdAcao($this->idAcao);   
            $dao->setIdPas($this->idPas);
            $result = $dao->retornaDadosParaEdicao($pdo);
            
                        
            if($result == FALSE){
                return Metodos::retornoAjax("nao_encontrou", "", "");
            }                                        
            $result['indicadores'] = json_decode($result['indicadores'], TRUE);        
            return Metodos::retornoAjax("ok", "", $result);                                                   
                                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return;
        }
    }
    
               
    /**
     * Verifica se o usuário possui permissão em um Pas especifico
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoPas($idPas, $pdo){
        try {                    
            $retorno = FALSE;
            $pasPes = new PasPesLot();        
            $result = $pasPes->verificaPermissaoPas($_SESSION['idUser'], $idPas, $pdo);
            if(!$result){
                return $retorno;
            }else{
                return TRUE;
            }                                        
        return $retorno;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }                             
    }
    
    public function verificaExisteIndicadorPAS(PDO $pdo){
        $this->sucesso = false;
        try {                    
            
            $dao = new DaoPlaPasAcaoIndicador();        
            $dao->setIdPas($this->idPas);
            $dao->verificaAoMenosUmIndicadorExisteNaPas($pdo);
            if($dao->Sucesso()){
                $this->sucesso = true;
            }else{
                $this->sucesso = false;
            }                                                
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
            //echo $exc->getMessage();
        }                             
    }
            
     
}

?>
