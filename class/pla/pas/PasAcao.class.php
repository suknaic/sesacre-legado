<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPasAcao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";


class PasAcao{
    
    private $idPasAcao = null;
    private $idPas = null;
    private $idAcao = null;        
    private $idPpaProjAti = null;
    private $dsParceria = null;
    private $dsMetaProgramacao = null;
    private $dsIndicadorProgramacao = null;        
    private $idLotacao = null;
    
    
    function getIdPasAcao() {
        return $this->idPasAcao;
    }

    function getIdPas() {
        return $this->idPas;
    }

    function getIdAcao() {
        return $this->idAcao;
    }

    function getIdPpaProjAti() {
        return $this->idPpaProjAti;
    }

    function getDsParceria() {
        return $this->dsParceria;
    }

    function getDsMetaProgramacao() {
        return $this->dsMetaProgramacao;
    }

    function getDsIndicadorProgramacao() {
        return $this->dsIndicadorProgramacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdPasAcao($idPasAcao) {
        $this->idPasAcao = $idPasAcao;
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

    function setIdPpaProjAti($idPpaProjAti) {
        $this->idPpaProjAti = $idPpaProjAti;
        return $this;
    }

    function setDsParceria($dsParceria) {
        $this->dsParceria = $dsParceria;
        return $this;
    }

    function setDsMetaProgramacao($dsMetaProgramacao) {
        $this->dsMetaProgramacao = $dsMetaProgramacao;
        return $this;
    }

    function setDsIndicadorProgramacao($dsIndicadorProgramacao) {
        $this->dsIndicadorProgramacao = $dsIndicadorProgramacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
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
            if($this->idPas == "" || $this->idAcao == "" 
                    || $this->idPpaProjAti == ""
                    || $this->dsMetaProgramacao == "" || $this->dsIndicadorProgramacao == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
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
            $dao = new DaoPlaPasAcao();
                        
            $dao->setIdAcao($this->idAcao);
            $dao->setIdPas($this->idPas);
            $dao->setIdPpaProjAti($this->idPpaProjAti);
            $dao->setDsParceria($this->dsParceria);
            $dao->setDsMetaProgramacao($this->dsMetaProgramacao);
            $dao->setDsIndicadorProgramacao($this->dsIndicadorProgramacao);                                                            
            
            //Insere o Registro no banco
            $result = $dao->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Pega o ID Inserido                                                                                         
            $dao->setIdPasAcao($pdo->lastInsertId('pla_pas_acao_id_pas_acao_seq'));
            //Salva no Log
            $sucesso = false;
            if (Log::SalvaLogI('pla_pas_acao', $dao->getIdPasAcao(), $pdo)){
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
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
            
            if($this->idAcao == "" || $this->idPpaProjAti == ""
                    || $this->dsMetaProgramacao == "" || $this->dsIndicadorProgramacao == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                                
            //Seta os Campos
            $dao = new DaoPlaPasAcao();
                        
            $dao->setIdPasAcao($this->idPasAcao);
            $dao->setIdAcao($this->idAcao);            
            $dao->setIdPpaProjAti($this->idPpaProjAti);
            $dao->setDsParceria($this->dsParceria);
            $dao->setDsMetaProgramacao($this->dsMetaProgramacao);
            $dao->setDsIndicadorProgramacao($this->dsIndicadorProgramacao);  
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $dao->retorna($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
                                    
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($busca['id_pas'], $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                                
            }
                                    
            //Edita o Registro no banco
            $result = $dao->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Salva no Log
            $sucesso = false;
            if (!Log::SalvaLogU('pla_pas_acao', $dao->getIdPasAcao(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
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
            if($this->idPasAcao == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                        
                        
            //Seta os Campos
            $dao = new DaoPlaPasAcao();
                        
            $dao->setIdPasAcao($this->idPasAcao);
            
            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $dao->retorna($pdo);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($busca['id_pas'], $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                               
            }
            
            //Salva no Log            
            if ($busca){
                if (!Log::SalvaLogD('pla_pas_acao', $dao->getIdPasAcao(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o PAS.");
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
                $retorno = Metodos::retornoAjax("ok", "html", "Ação removido com Sucesso.");
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
     * Retorna as Trs para a Tabela da PAS Acao          
     * @return string
     */
    public function retornaTrPasAcao(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPasAcao();
            
            $pas->setIdPas($this->idPas);
                                    
            $result = $pas->retornaTodosPorPas($pdo);                                                                       
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $id = $v['id_pas_acao'];                    
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_acao']."</td>"
                            . "<td>".$v['nm_ppa_proj_ati']."</td>"
                            . "<td>".$v['nm_eixo']."</td>"
                            . "<td>".$v['tipo']."</td>"
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
            $dao = new DaoPlaPasAcao();            
            $dao->setIdPasAcao($this->idPasAcao);                                             
            $result = $dao->retornaDadosCompleto($pdo);
            
            if($result == FALSE){
                return Metodos::retornoAjax("nao_encontrou", "", "");
            }                
                        
            $array = array(                
                "acao" => $result['id_acao'],
                "ppa_proj_ati" => $result['id_ppa_proj_ati'],
                "parceria" => $result['ds_parceria'],
                "meta" => $result['ds_meta_programacao'],
                "indicador" => $result['ds_indicador_programacao'],
                "eixo" => $result['id_eixo']
            );
            
            return Metodos::retornoAjax("ok", "ok", $array);                                    
                                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return;
        }
    }
    
       
    

    /**
     * Verifica se o usuário possui permissão em uma Lotação especifica
     * @param int $idLotacao
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoLotacao($idLotacao, $pdo){
        try {                    
            $retorno = FALSE;
            $pasPes = new PasPesLot();        
            $result = $pasPes->verificaPermissao($_SESSION['idUser'], $idLotacao, $pdo);
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
    
    public function retornaSelectPorPas(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPasAcao();
            
            $pas->setIdPas($this->idPas);
                                    
            $result = $pas->retornaAcaoPorPas($pdo);                                                                       
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.                                    
                foreach ($result as $value) {                    
                    $retorno .= "<option value=".$value['id_acao'].">"
                            . $value['nm_acao']
                            . "</option>";
                }                  
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaOptionPpaProjAti($idPpaProjAti = null){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPasAcao();
            
            $pas->setIdPas($this->idPas);
                                    
            $result = $pas->retornaPpaProjAtiPorPas($pdo);                                                                       
            
            $retorno .= "<option value=0>Selecione um Projeto/Atividade</option>";
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.                                    
                foreach ($result as $value) {     
                    if($idPpaProjAti == $value['id_ppa_proj_ati']){
                        $retorno .= "<option value=".$value['id_ppa_proj_ati']." selected>"
                            . $value['cd_ppa_proj_ati']." - ".$value['nm_ppa_proj_ati']
                            . "</option>";
                    }else{
                        $retorno .= "<option value=".$value['id_ppa_proj_ati'].">"
                                . $value['cd_ppa_proj_ati']." - ".$value['nm_ppa_proj_ati']
                                . "</option>";
                    }
                }                  
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaOptionAcaoPorPpaProjAti(PDO $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $pas = new DaoPlaPasAcao();
            
            $pas->setIdPpaProjAti($this->idPpaProjAti);
            $pas->setIdPas($this->idPas);
                                    
            $result = $pas->retornaAcaoPorPpaProjAti($pdo);                                                                       
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.                                    
                foreach ($result as $value) {                    
                    $retorno .= "<option value=".$value['id_acao'].">"
                            . $value['nm_acao']
                            . "</option>";
                }                  
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
     
}

?>
