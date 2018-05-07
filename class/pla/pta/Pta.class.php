<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPta.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";


class Pta{
    
    private $idPta = null;
    private $idPas = null;    
    private $nmPta = null;    
    private $dtInicio = null;
    private $dtFim = null;        
    
   
    function getIdPta() {
        return $this->idPta;
    }

    function getIdPas() {
        return $this->idPas;
    }

    function getNmPta() {
        return $this->nmPta;
    }

    function getDtInicio() {
        return $this->dtInicio;
    }

    function getDtFim() {
        return $this->dtFim;
    }
   
    function setIdPta($idPta) {
        $this->idPta = $idPta;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
    }

    function setNmPta($nmPta) {
        $this->nmPta = $nmPta;
    }

    function setDtInicio($dtInicio) {
        $this->dtInicio = $dtInicio;
    }

    function setDtFim($dtFim) {
        $this->dtFim = $dtFim;
    }      
        

    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */                                    
    public function cadastrar($perfil){
        try {     
            
            //Verifica se os campos foram preenchidos
            if($this->idPas == "" || $this->nmPta == ""
                    || $this->dtInicio == "" || $this->dtFim == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                    
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPta($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }
            
            //Seta os Campos
            $pta = new DaoPlaPta();
                        
            $pta->setIdPas($this->idPas);
            $pta->setNmPta($this->nmPta);                        
            $pta->setDtInicio(Metodos::validaConverteDataING($this->dtInicio));
            $pta->setDtFim(Metodos::validaConverteDataING($this->dtFim));            
            //Verifica se o resultado da validação deu certo.
            if($pta->getDtInicio() == "" || $pta->getDtFim() == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $dtI = new DateTime($pta->getDtInicio());
            $dtF = new DateTime($pta->getDtFim());
            
            if($dtI > $dtF){
                return Metodos::retornoAjax("Erro", "alert", STR_DATA_INICIO_FIM);
            }                                    
            
            //Insere o Registro no banco
            $result = $pta->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Pega o ID Inserido                                                                                         
            $pta->setIdPta($pdo->lastInsertId('pla_pta_id_pta_seq'));            
            //Salva no Log
            $sucesso = false;
            if (Log::SalvaLogI('pla_pta', $pta->getIdPta(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do PTA Realizado com Sucesso.");
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
            if($this->idPas == "" || $this->nmPta == ""
                    || $this->dtInicio == "" || $this->dtFim == ""
                    || $this->idPta == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                                
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPta($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                    
            }
            
            //Seta os Campos
            $pta = new DaoPlaPta();
                        
            $pta->setIdPta($this->idPta);
            $pta->setIdPas($this->idPas);
            $pta->setNmPta($this->nmPta);                        
            $pta->setDtInicio(Metodos::validaConverteDataING($this->dtInicio));
            $pta->setDtFim(Metodos::validaConverteDataING($this->dtFim));            
            //Verifica se o resultado da validação deu certo.
            if($pta->getDtInicio() == "" || $pta->getDtFim() == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $dtI = new DateTime($pta->getDtInicio());
            $dtF = new DateTime($pta->getDtFim());
            
            if($dtI > $dtF){
                return Metodos::retornoAjax("Erro", "alert", STR_DATA_INICIO_FIM);
            }            
                        
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pta->retornaPta($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Verifica se o PTA Editado é realmente desse PAS
            if($this->idPas != $busca['id_pas']){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
                                                
            //Edita o Registro no banco
            $result = $pta->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Salva no Log
            $sucesso = false;
            if (!Log::SalvaLogU('pla_pta', $pta->getIdPta(), $busca, $pdo)){
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
            if($this->idPta == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                 
                        
            //Seta os Campos
            $pta = new DaoPlaPta();
            
            $pta->setIdPta($this->idPta);    
            
            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $pta->retornaPta($pdo);
            
            
            $this->setIdPas($busca['id_pas']);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPta($this->idPas, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                         
            }
            
            //Verifica se o PTA é realmente desse PAS
            if($this->idPas != $busca['id_pas']){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Salva no Log            
            if ($busca){
                if (!Log::SalvaLogD('pla_pta', $pta->getIdPta(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o PTA.");
               $pdo->rollBack();
               return $retorno;
            }
                                                
            //Remove o Registro no banco
            $resultDao = $pta->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                                                                                                                                                              
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "PTA removido com Sucesso.");
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
     * Retorna os Boxes para, contendo todos os PTAs por um Pas especifico
     * Juntamente com seus titulos, caso tenha
     * Perfil 0 indica que o usuario somente visualiza o Pas de uma Lotação escolhida
     * Perfil 1 indica que o usuario poderá visualizar TODOS os Pas de um ano especifico
     * Esse Perfil é verificado de acordo as permissões do usuário.
     * @param int $idLotacao
     * @param int $ano
     * @param type $perfil
     * @return string
     */
    public function retornaBoxPorPasComTitulos($perfil){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pta = new DaoPlaPta();
            
            $pta->setIdPas($this->idPas);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse PAS                                                                           
                if(!$this->verificaPermissaoPta($this->idPas, $pdo)){
                    return "";
                }                                      
            }            
            $result = $pta->retornaTodosPtaPorPasAgrupadoTitulo($pdo);                                                    
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    
                    $nomePta = $v['nm_pta'];
                    $idPta = $v['id_pta'];
                    $dtInicio = $v['dt_inicio'];
                    $dtFim = $v['dt_fim'];
                    $v['titulos'] = json_decode($v['titulos'], TRUE);
                    
                    $retorno .=  '<div class="col-sm-6">'
                            . '<div class="panel">'
                                . '<div class="panel-body">'
                                    . '<div class="caption"><h4>'.$nomePta.'</h4>'
                                        . '<dl>'
                                        . '<dt>Títulos do PTA:</dt>'
                                            . '<p></p>';
                            //Caso o PTa tenha títulos, então irá mostrar eles
                            if(is_array($v['titulos'])){                                
                                foreach ($v['titulos'] as $key => $value){
                                    $retorno .= '<dd class="dd-direita">'.$value. ' '
                                                . '<a href="pta_titulo_info.php?token='.$key.'" class="" title="Entrar">'
                                                    . '<span class="fa fa-search-plus fa-lg text-primary" value="'.$idPta.'" title="Entrar" aria-hidden="true" role="button"></span> '
                                                . '</a>'
                                                . '<span class="fa fa-pencil-square-o fa-lg text-info editarTitulo" value="'.$key.'" title="Editar" aria-hidden="true" role="button"></span> '
                                                . '<span class="fa fa-trash text-danger fa-lg removerTitulo" value="'.$key.'" title="Remover" nome="'.$value.'"aria-hidden="true" role="button"></span> '                                            
                                            . '</dd>';                                                                                                                                
                                }
                            }
                                                                                                         
                    $retorno .= '           </dl>'
                                    . '</div>'
                                . '</div>'
                                . '<div class="panel-footer text-right dadosPta" nome="'.$nomePta.'" dt_inicio="'.$dtInicio.'" dt_fim="'.$dtFim.'">'                                                                   
                                    . '<button type="button" class="btn btn-primary btn-rounded btn-cad-titulo" value="'.$idPta.'" >'
                                        . 'Cadastrar Título do PTA'
                                    . '</button> '
                                    . '<button type="button" class="btn btn-info btn-rounded btn-pta-edit" value="'.$idPta.'">'
                                        . '<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Editar PTA'
                                    . '</button> '
                                    . '<button class="btn btn-danger btn-rounded btn-pta-remover" nome="'.$nomePta.'" type="button" value="'.$idPta.'">'
                                        . '<i class="fa fa-trash fa-lg" aria-hidden="true"></i> Remover PTA'
                                    . '</button> '
                                . '</div>'
                            . '</div>'
                        . '</div>';                     
                        
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
       
    
    /**
     * Verifica se o usuário possui permissão em um Pas especifico
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoPta($idPas, $pdo){
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
            $retorno = FALSE;
            echo $exc->getMessage();
        }
                             
    }
    
    
    public function carregaDados(int $idPta){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pta = new DaoPlaPta();            
            $pta->setIdPta($idPta);                          
            $result = $pta->retornaPta($pdo);  
            
            if (!$result) {
                
            } else {                                
                
                $this->idPta = $result['id_pta'];
                $this->idPas = $result['id_pas'];
                $this->nmPta = $result['nm_pta'];                                
                $this->dtInicio = $result['dt_inicio'];
                $this->dtFim = $result['dt_fim'];
                
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
                        
    /**
     * Retorna uma TRs para ser apresentada na Tela Info do PAS
     * @return string
     */
    public function retornaTrPorPasTelaPAS(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pta = new DaoPlaPta();            
            $pta->setIdPas($this->idPas);                        
            $result = $pta->retornaTodosPtaIndicadorPorPas($pdo);                                                                       
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $id = $v['id_pas'];  
                    $idPtaTitulo = $v['id_pta_titulo'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pta']."</td>"
                            . "<td>".$v['nm_pta_titulo']."</td>"                                                    
                            . "<td>".$v['dt_inicio']." - ".$v['dt_fim']."</td>"                            
                            . '<td style="text-align: center;">';
                        if($v['id_pta_titulo'] == ""){
                            $retorno .= '<a href="../pta/index.php?token='.$id.'" class="btn btn-default btn-entrar btn-xs" title="Entrar"> 
                                        <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a>';                           
                        }else{
                            $retorno .= '<a href="../pta/pta_titulo_info.php?token='.$idPtaTitulo.'" class="btn btn-default btn-entrar btn-xs" title="Entrar"> 
                                        <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a>';                           
                        }
                                                        
                    $retorno .= '</td>'
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
