<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";


class Pas{
    
    private $idPas = null;
    private $idPes = null;
    private $idLotacao = null;
    private $nmPas = null;
    private $dtInicio = null;
    private $dtFim = null;
    private $idPessoaResp = null;
    private $idPessoaExec = null;
    private $dsObservacao = null;
    private $stPas = null;
    private $nmPes = null;
    private $nmPessoaResp = null;
    private $nmPessoaExec = null;
    private $nmLotacao = null;  
    private $sucesso = null;
    private $msgRetorno = null; 
    private $pasPrimEnviadoPlanejamento = 1;
    private $pasPrimRetornoUnidade = 2;
    private $pasPrimAutorizadoPlanejamento = 3;
    private $pasLiberadoPlanejamento = 4;     
    
    function getStPas() {
        return $this->stPas;
    }

    function setStPas($stPas) {
        $this->stPas = $stPas;
        return $this;
    }       
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }    
    
    function getNmPes() {
        return $this->nmPes;
    }

    function getNmPessoaResp() {
        return $this->nmPessoaResp;
    }

    function getNmPessoaExec() {
        return $this->nmPessoaExec;
    }

    function getNmLotacao() {
        return $this->nmLotacao;
    }

    function setNmPes($nmPes) {
        $this->nmPes = $nmPes;
        return $this;
    }

    function setNmPessoaResp($nmPessoaResp) {
        $this->nmPessoaResp = $nmPessoaResp;
        return $this;
    }

    function setNmPessoaExec($nmPessoaExec) {
        $this->nmPessoaExec = $nmPessoaExec;
        return $this;
    }

    function setNmLotacao($nmLotacao) {
        $this->nmLotacao = $nmLotacao;
        return $this;
    }
        
    function getIdPas() {
        return $this->idPas;
    }

    function getIdPes() {
        return $this->idPes;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getNmPas() {
        return $this->nmPas;
    }

    function getDtInicio() {
        return $this->dtInicio;
    }
    
    function getDtFim() {
        return $this->dtFim;
    }

    function getIdPessoaResp() {
        return $this->idPessoaResp;
    }

    function getIdPessoaExec() {
        return $this->idPessoaExec;
    }

    function getDsObservacao() {
        return $this->dsObservacao;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
    }

    function setIdPes($idPes) {
        $this->idPes = $idPes;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    function setNmPas($nmPas) {
        $this->nmPas = $nmPas;
    }

    function setDtInicio($dtInicio) {
        $this->dtInicio = $dtInicio;
    }
    
    function setDtFim($dtFim) {
        $this->dtFim = $dtFim;
    }

    function setIdPessoaResp($idPessoaResp) {
        $this->idPessoaResp = $idPessoaResp;
    }

    function setIdPessoaExec($idPessoaExec) {
        $this->idPessoaExec = $idPessoaExec;
    }

    function setDsObservacao($dsObservacao) {
        $this->dsObservacao = $dsObservacao;
    }
    
    
    /**
     * 1 - Pas Foi Enviado Para Primeira Validação no Planejamento
     * @return int
     */
    public function stPasPrimEnvioPlanejamento() {
        return $this->pasPrimEnviadoPlanejamento;        
    }
    
    /**     
     * 2 - Estado de Retorno do Planejamento Para Unidade, Planejamento não ficou de acordo com a PAS
     * @return int
     */
    public function stPasPrimRetornoUnidade() {
        return $this->pasPrimRetornoUnidade;
    }
    
    /**
     * 3 - A Pas Foi Autorizado Pela Planejamento
     * @return int
     */
    public function stPasPrimAutorizadoPlanejamento(){
        return $this->pasPrimAutorizadoPlanejamento;
    }
    /**
     * 4 - A PAS Foi Liberado Para Modificação
     * @return int
     */
    public function stPasLiberadoPlanejamento(){
        return $this->pasLiberadoPlanejamento;
    }
    
       
    /**
     * 0, $this->stPasLiberadoPlanejamento(), $this->stPasPrimRetornoUnidade(), $this->stPasSegRetornoUnidade()
     * @param int $status
     * @return boolean
     */
    public function stPodeEnviarPlanejamento(int $status){
        $status = (int)$status;
        
        $array = array(0, $this->stPasLiberadoPlanejamento(), $this->stPasPrimRetornoUnidade());
        if(in_array($status, $array)){
            return TRUE;
        }else{
            return FALSE;
        }                                
    }
    
    public function stPodeValidar(int $status){
        $status = (int)$status;
        
        $array = array($this->stPasPrimEnvioPlanejamento());
        if(in_array($status, $array)){
            return TRUE;
        }else{
            return FALSE;
        }                                
    }
    
    public function stGeraLog(int $status){
        $status = (int)$status;
        
        $array = array($this->stPasLiberadoPlanejamento(), $this->stPasPrimRetornoUnidade());
        if(in_array($status, $array)){
            return TRUE;
        }else{
            return FALSE;
        }  
    }
    
        
    
    /**
     * Retorna um Texto e uma cor a ser usanda informado o Status do Item
     * @param type $status
     * @return Object
     */
    public function stTextoItem($status){
        $obj = new stdClass();
        switch ($status) {
            case 0:
            case '':                
                $obj->msg = "Não foi enviado para Autorização"; $obj->cor = "warning"; $obj->msgText = "";
                return $obj;                
                break;
            case $this->pasPrimEnviadoPlanejamento:                
                $obj->msg = "Enviado para Planejamento"; $obj->cor = "warning"; $obj->msgText = " Enviou a PAS Para o Planejamento Autorizar. Mensagem da Unidade: ";
                return $obj;                
                break;
            case $this->pasPrimRetornoUnidade:
                $obj->msg = "Não Autorizado pelo Planejamento"; $obj->cor = "danger";  $obj->msgText = " Não Autorizou a PAS. Mensagem do Planejamento: ";
                return $obj;
                breal;
            case $this->pasPrimAutorizadoPlanejamento:
                $obj->msg = "Autorizado"; $obj->cor = "success"; $obj->msgText = " Autorizou a PAS. Mensagem do Planejamento: ";
                return $obj;
                break;
            case $this->pasLiberadoPlanejamento:
                $obj->msg = "Liberado Para Alteração"; $obj->cor = "warning"; $obj->msgText = " Liberou a PAS Para Alteração. Mensagem do Planejamento: ";
                return $obj;
                break;            
            default:
                $obj->msg = "Sem Definição"; $obj->cor = "default"; $obj->msgText = "";
                return $obj;                                   
                break;            
        }
    }

        

    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */                                    
    public function cadastrar($perfil = 0){
        try {       
            
            //Verifica se os campos foram preenchidos
            if($this->idPes == "" || $this->idLotacao == "" || $this->nmPas == ""
                    || $this->dtInicio == "" || $this->dtFim == ""
                    || $this->idPessoaResp == "" || $this->idPessoaExec == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($this->idLotacao, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                                
            }
            
            //Seta os Campos
            $pla = new DaoPlaPas();
                        
            $pla->setIdPes($this->idPes);
            $pla->setIdLotacao($this->idLotacao);            
            $pla->setNmPas($this->nmPas);            
            $pla->setDtInicio(Metodos::validaConverteDataING($this->dtInicio));
            $pla->setDtFim(Metodos::validaConverteDataING($this->dtFim));
            //Verifica se o resultado da validação deu certo.
            if($pla->getDtInicio() == "" || $pla->getDtFim() == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $dtI = new DateTime($pla->getDtInicio());
            $dtF = new DateTime($pla->getDtFim());
            
            if($dtI > $dtF){
                return Metodos::retornoAjax("Erro", "alert", STR_DATA_INICIO_FIM);
            }            
            
            $pla->setIdPessoaResp($this->idPessoaResp);
            $pla->setIdPessoaExec($this->idPessoaExec);
            $pla->setDsObservacao($this->dsObservacao);
            
            //Insere o Registro no banco
            $result = $pla->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Pega o ID Inserido                                                                                         
            $pla->setIdPas($pdo->lastInsertId('pla_pas_id_pas_seq'));            
            //Salva no Log
            $sucesso = false;
            if (Log::SalvaLogI('pla_pas', $pla->getIdPas(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do PAS Realizado com Sucesso.");
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
            if($this->idPes == "" || $this->idLotacao == "" || $this->nmPas == ""
                    || $this->dtInicio == "" || $this->dtFim == ""
                    || $this->idPessoaResp == "" || $this->idPessoaExec == ""
                    || $this->idPas == ""){            
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                                
            //Seta os Campos
            $pla = new DaoPlaPas();
            
            $pla->setIdPas($this->idPas);
            $pla->setIdPes($this->idPes);
            $pla->setIdLotacao($this->idLotacao);            
            $pla->setNmPas($this->nmPas);            
            $pla->setDtInicio(Metodos::validaConverteDataING($this->dtInicio));
            $pla->setDtFim(Metodos::validaConverteDataING($this->dtFim));
            //Verifica se o resultado da validação deu certo.
            if($pla->getDtInicio() == "" || $pla->getDtFim() == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $dtI = new DateTime($pla->getDtInicio());
            $dtF = new DateTime($pla->getDtFim());
            
            if($dtI > $dtF){
                return Metodos::retornoAjax("Erro", "alert", STR_DATA_INICIO_FIM);
            }
            
            $pla->setIdPessoaResp($this->idPessoaResp);
            $pla->setIdPessoaExec($this->idPessoaExec);
            $pla->setDsObservacao($this->dsObservacao);
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pla->retornaPas($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Verifica se a Lotação do Pas Editado é realmente a Lotação enviada pelo formulário
            if($this->idLotacao != $busca['id_lotacao']){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($this->idLotacao, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                                
            }
                                    
            //Edita o Registro no banco
            $result = $pla->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Salva no Log
            $sucesso = false;
            if (!Log::SalvaLogU('pla_pas', $pla->getIdPas(), $busca, $pdo)){
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
            if($this->idPas == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                        
                        
            //Seta os Campos
            $pla = new DaoPlaPas();
            
            $pla->setIdPas($this->idPas);    
            
            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $pla->retornaPas($pdo);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($busca['id_lotacao'], $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                               
            }
            
            //Salva no Log            
            if ($busca){
                if (!Log::SalvaLogD('pla_pas', $pla->getIdPas(), $pdo)) {
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
            $resultDao = $pla->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                                                                                                                                                              
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "PAS removido com Sucesso.");
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
     * Retorna as Trs para a Tabela da Pesquisa do PAS
     * Perfil 0 indica que o usuario somente visualiza o Pas de uma Lotação escolhida
     * Perfil 1 indica que o usuario poderá visualizar TODOS os Pas de um ano especifico
     * Esse Perfil é verificado de acordo as permissões do usuário.
     * @param int $idLotacao
     * @param int $ano
     * @param type $perfil
     * @return string
     */
    public function retornaTrPasLotacaoAnoPerfil($idLotacao, $ano, $perfil){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();
            
            //Verifica se o campo do Ano possui 4 digitos
            if(strlen($ano) != 4){
                return $retorno;
            }
            
            //Verifica se o usuario logado não é perfil 1 e também verifica, caso ele selecione uma lotação,
            //se ele possui permissão para visualizar a Lotação
            if($idLotacao != 0 && $perfil != 1){
                if(!$this->verificaPermissaoPas($idLotacao, $pdo)){
                    return $retorno;
                }                                                
            }
            
            //Caso o perfil seja 1 e ele não selecione nenhuma lotação, irá mostrar todas as lotações
            if($idLotacao == 0 && $perfil == 1){
                $result = $pas->retornaDadosPasPorAno($ano, $pdo);
                //Se Não, se ele não for 1 e não selecionar nenhuma lotação, o sistema não irá mostrar nada.
            }else if($idLotacao == 0){
                        return $retorno;                    
                    }else{                                                
                        //Irá entrar quando ele selecionar ao menos uma Lotação
                        $result = $pas->retornaDadosPasPorLotacaoAno($idLotacao, $ano, $pdo);
                    }
                                                 
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $id = $v['id_pas'];                    
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pas']."</td>"
                            . "<td>".$v['nm_lotacao']."</td>"
                            . "<td>".$v['nm_pes']."</td>"
                            . "<td>".$v['dt_inicio']." - ".$v['dt_fim']."</td>"
                            . '<td style="text-align: center;">'                            
                            . '<a href="pas_info.php?token='.$id.'" class="btn btn-default btn-entrar btn-xs" title="Entrar"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i> Visualizar
                              </a> '                                                      
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
    
    /**
     * Retorna as Trs para a Tabela da Pesquisa do PAS
     * Perfil 0 indica que o usuario somente visualiza o Pas de uma Lotação escolhida
     * Perfil 1 indica que o usuario poderá visualizar TODOS os Pas de um ano especifico
     * Esse Perfil é verificado de acordo as permissões do usuário.
     * @param int $idLotacao     
     * @param type $perfil
     * @return string
     */
    public function retornaTrPasLotacaoPerfil($idLotacao, $perfil){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();
            
            //Verifica se o usuario logado não é perfil 1 
            //se ele possui permissão para visualizar a Lotação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($idLotacao, $pdo)){
                    return $retorno;
                }                                                
            }
                        
            $result = $pas->retornaDadosPasPorLotacao($idLotacao, $pdo);
                                                                            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $id = $v['id_pas'];     
                    $idLotacao = $v['id_lotacao'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pas']."</td>"                            
                            . "<td>".$v['nm_pes']."</td>"
                            . "<td>".$v['dt_inicio']." - ".$v['dt_fim']."</td>"
                            . "<td>".$v['nm_pessoa_resp']."</td>"
                            . "<td>".$v['nm_pessoa_exec']."</td>"
                            . "<td>".$v['ds_observacao']."</td>"
                            . '<td style="text-align: center;">'
                            . '<a href="pas_info.php?token='.$id.'" class="btn btn-default btn-entrar btn-xs" title="Entrar"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i> Entrar
                              </a> '    
                            . '<a href="pas.php?token='.$idLotacao.'&tokenI='.$id.'" class="btn btn-default btn-edit btn-xs" title="Editar"> 
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i> Alterar
                              </a> '                            
                            . '<button type="button" class="btn btn-default btn-remover btn-xs"'
                                . ' title="Remover" nome="'.$v['nm_pas'].'" id='.$id.' '
                                . 'value=' . $id . ' >
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
    
    

    /**
     * Verifica se o usuário possui permissão em uma Lotação especifica
     * @param int $idLotacao
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoPas($idLotacao, $pdo){
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
     * 
     * @param int $idPas
     * @param type $pdo
     */
    public function carregaDados(int $idPas, $pdo = null){
        
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $pla = new DaoPlaPas();            
            $pla->setIdPas($idPas);                          
            $result = $pla->retornaPas($pdo);  
            
            if (!$result) {
                
            } else {                                
                
                $this->idPas = $result['id_pas'];
                $this->idPes = $result['id_pes'];
                $this->idLotacao = $result['id_lotacao'];
                $this->nmPas = $result['nm_pas'];
                $this->idPessoaResp = $result['id_pessoa_resp'];  
                $this->idPessoaExec = $result['id_pessoa_exec'];
                $this->dsObservacao = $result['ds_observacao'];
                $this->dtInicio = $result['dt_inicio'];
                $this->dtFim = $result['dt_fim'];
                $this->stPas = $result['st_pas'];
                
                
            }
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaDadosParaEdicao(){
        
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pla = new DaoPlaPas();
            //Salva a Lotação para saber se a lotação será a mesma que está no PAS
            $idLotacao = $this->idLotacao;
            
            $idPas = $this->idPas;
            $this->idPas = "";
            $this->carregaDados($idPas);
                        
            if($idLotacao != $this->idLotacao
                    || $this->idPas == "" || $this->idPas == 0){
                return Metodos::retornoAjax("nao_encontrou", "", "");
            }
            
            
            $array = array(
                "idPas" => $this->idPas,
                "lotacao" => $this->idLotacao,
                "nome" => $this->nmPas,
                "pes" => $this->idPes,
                "pessoa_resp" => $this->idPessoaResp,
                "pessoa_exec" => $this->idPessoaExec,
                "dt_inicio" => Metodos::ConverteDataBR($this->dtInicio),
                "dt_fim" => Metodos::ConverteDataBR($this->dtFim),
                "obs" => $this->dsObservacao
            );
            
            return Metodos::retornoAjax("ok", "ok", $array);                                    
                                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return;
        }
    }

            
    public function retornaList(){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();
            $pas->setIdPas($this->idPas);                     
            $result = $pas->retornaTodosDadosPorPas($pdo);
            
            if (!$result) {
                return $retorno;
            } else {  
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>PES:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_pes']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Unidade:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_lotacao']."</div>";                    
                $retorno .= "</div>";                                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Data Início - Data Fim:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['dt_inicio']." - ".$result['dt_fim']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Responsável Unidade:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_pessoa_resp']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Responsável Execução:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_pessoa_exec']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Observação:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ds_observacao']."</div>";                    
                $retorno .= "</div>";
                                                                                                                                                 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    public function carregaDadosRetornaInfo(){
        
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pla = new DaoPlaPas();            
            $pla->setIdPas($this->idPas);                          
            $result = $pla->retornaTodosDadosPorPas($pdo);  
            
            if (!$result) {
                return $retorno;
            } else {                                
                
                $this->idPas = $result['id_pas'];
                $this->idPes = $result['id_pes'];
                $this->idLotacao = $result['id_lotacao'];
                $this->nmPas = $result['nm_pas'];
                $this->idPessoaResp = $result['id_pessoa_resp'];  
                $this->idPessoaExec = $result['id_pessoa_exec'];
                $this->dsObservacao = $result['ds_observacao'];
                $this->dtInicio = $result['dt_inicio'];
                $this->dtFim = $result['dt_fim'];
                $this->nmPes = $result['nm_pes'];
                $this->nmPas = $result['nm_pas'];
                $this->nmLotacao = $result['nm_lotacao'];
                $this->nmPessoaExec = $result['nm_pessoa_exec'];
                $this->nmPessoaResp = $result['nm_pessoa_resp'];
                $this->stPas = $result['st_pas'];
                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>PES:</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->nmPes."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>PAS:</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->nmPas."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>".STR_LOTACAO.":</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->nmLotacao."</div>";                    
                $retorno .= "</div>";                                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>Data Início - Data Fim:</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->dtInicio." - ".$this->dtFim."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>Responsável Unidade:</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->nmPessoaResp."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>Responsável Execução:</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->nmPessoaExec."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>Observação:</b></div>";
                    $retorno .= "<div class='col-sm-8'>".$this->dsObservacao."</div>";                    
                $retorno .= "</div>";   
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-3'><b>Situação da PAS:</b></div>";
                    $obj = $this->stTextoItem($this->stPas);                    
                    $retorno .= "<div class='col-sm-8'>".$obj->msg."</div>";                    
                $retorno .= "</div>"; 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $retorno;
        }                               
    }
    
    
    function retornaTabelasValidacaoCentral($perfil){
        $retorno = "";                
        try{
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
                                    
            $this->carregaDados($this->idPas, $pdo);
            $idLotacao = $this->idLotacao;            
            
            //Verifica se o usuario logado não é perfil 1 
            //se ele possui permissão para visualizar a Lotação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($idLotacao, $pdo)){
                    return $retorno;
                }                                                
            }
            
            $item = new PtaItem();                        
            $arrayItens = [];
            $item->retornaTodosItensPorPAS($this->idPas, $pdo);
                                                    
            if(!$item->Sucesso()){       
                print_r($item->getMsgRetorno());                 
                return $retorno;
            }else{                                
                $result = $item->getMsgRetorno();                
                
                //Organizar o Retorno em Array Agrupado Por Tipo de Gasto Categoria                
                foreach ($result as $value) {
                    if(array_key_exists($value['id_tipo_gasto_categoria'], $arrayItens)){
                        $arrayItens[$value['id_tipo_gasto_categoria']]['itens'][] = array(
                                "id_pta_item" => $value['id_pta_item'],                                
                                "qt_pta_item" => $value['qt_pta_item'],
                                "vl_pta_item" => $value['vl_pta_item'],
                                "nm_desc_material" => $value['nm_desc_material'],                                                                
                                "nm_unidade_medida" => $value['nm_unidade_medida'],
                                "nr_fonte" => $value['nr_fonte'],
                                "st_pta_item" => $value['st_pta_item']
                            );
                    }else{
                        $arrayItens[$value['id_tipo_gasto_categoria']] = array(
                            "nm_tipo_gasto_categoria" => $value['nm_tipo_gasto_categoria'],
                            "nm_lotacao" => $value['nm_lotacao'],
                            "itens" => array(array(
                                "id_pta_item" => $value['id_pta_item'],                                
                                "qt_pta_item" => $value['qt_pta_item'],
                                "vl_pta_item" => $value['vl_pta_item'],
                                "nm_desc_material" => $value['nm_desc_material'],                                                                
                                "nm_unidade_medida" => $value['nm_unidade_medida'],
                                "nr_fonte" => $value['nr_fonte'],
                                "st_pta_item" => $value['st_pta_item']                                
                            ))                            
                        );
                    }                                        
                }                                                
            }
            
            
            
                                  
            if(count($arrayItens) > 0){
                //Pega os Ids do Tipo de Gasto Categoria
                $idsTipoGastoCategoria = implode(",", array_keys($arrayItens));
                                
                //Pega as Mensagens que ocorreram para cada Tipo de Gasto Categoria
                $itemValidacao = new PtaItemValidacao();
                $itemValidacao->setIdPas($this->idPas);      
                
                $arrayMensagem = [];
                $itemValidacao->retornaMensagensPorPASINTipoGastoCategoria($idsTipoGastoCategoria, $pdo);
                if($itemValidacao->Sucesso()){
                    foreach ($itemValidacao->getMsgRetorno() as $key => $value) {                        
                                
                        if(array_key_exists($value['id_tipo_gasto_categoria'], $arrayMensagem)){
                            $arrayMensagem[$value['id_tipo_gasto_categoria']]['mensagem'][] = array(
                                    "nm_pessoa" => $value['nm_pessoa'],                                
                                    "ds_pta_item_validacao" => $value['ds_pta_item_validacao'],
                                    "dh_pta_item_validacao" => $value['dh_pta_item_validacao'],
                                    "st_pta_item_validacao" => $value['st_pta_item_validacao']
                                );
                        }else{
                            $arrayMensagem[$value['id_tipo_gasto_categoria']] = array(                                                           
                                "mensagem" => array(array(
                                    "nm_pessoa" => $value['nm_pessoa'],                                
                                    "ds_pta_item_validacao" => $value['ds_pta_item_validacao'],
                                    "dh_pta_item_validacao" => $value['dh_pta_item_validacao'],
                                    "st_pta_item_validacao" => $value['st_pta_item_validacao']                                                                
                                ))                            
                            );
                        }    
                        
                    }
                }                

                foreach ($arrayItens as $key => $value) {  
                    
                    $valorTotal = 0;
                    $retorno .= '<div class="panel panel-default">'
                                . '<div class="panel-heading" style="margin-bottom: 5px;">'
                                    . '<div class="panel-title">Tipo de Gasto Categoria: '.$value['nm_tipo_gasto_categoria'].' - '.$value['nm_lotacao'].'</div>'
                                . '</div>';                    
                    
                    $retorno .= '<table class="table table-striped table-bordered tabela-itens-salvo" cellspacing="0" width="100%">'
                            . '<thead>'
                                . '<tr>'
                                    . '<th>Item</th>'
                                    . '<th>Fonte</th>'                                    
                                    . '<th style="white-space: nowrap; overflow: hidden;">Qtd - Valor Unit. - Total</th>'
                                    . '<th class="text-center"></th>'
                                . '</tr>'
                            . '</thead>'
                            . '<tbody>';
                    
                    foreach ($value['itens'] as $v) {
                        $id = $v['id_pta_item'];
                        $valorTotal += (float)($v['qt_pta_item']*$v['vl_pta_item']);
                        $obj = $item->stTextoItem($v['st_pta_item']);                        
                        $retorno .= "<tr>"
                                    . "<td>".$v['nm_desc_material']." - ".$v['nm_unidade_medida']."</td>"
                                    . "<td>".$v['nr_fonte']."</td>"                                    
                                    . "<td style='white-space: nowrap; overflow: hidden;'>".$v['qt_pta_item']." - R$ ". Metodos::ConverteValorBr((float)$v['vl_pta_item'], 4)." - R$ ".Metodos::ConverteValorBr((float)($v['qt_pta_item']*$v['vl_pta_item']), 4)."</td>"
                                    . '<td style="text-align: center;">'                                                     
                                    . '<button type="button" class="btn btn-default btn-informacoes btn-xs"'
                                        . ' title="Informações"  '
                                        . 'value=' . $id . ' >
                                        <i class="fa fa-info fa-lg text-warning" aria-hidden="true"></i>
                                      </button> '                                    
                                    . '<span class="label label-'.$obj->cor.'">'.$obj->msg.'</span>'
                                    . '</td>'
                                    . "</td>"
                                . "</tr>";                                                                                                
                    }
                                                                                
                    $retorno .= "</tbody>";
                    $retorno .= "<tfoot>"
                                . "<tr>"
                                    . "<th colspan='2'>Total</th>"
                                    . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"
                                    . "<th></th>"
                                . "</tr>"
                            . "</tfoot>";
                    $retorno .= "</table>";
                    
                    $retorno .= '<div class="panel-footer">   
                                            <div class="text-left">                                                                                                                                          
                                                <textarea class="form-control tAreaTipoGastoCartegoria" rows="4" disabled style="text-align: left;">';
                                            if(array_key_exists($key, $arrayMensagem)){
                                                foreach ($arrayMensagem[$key]['mensagem'] as $aMsg) {
                                                    $obj = $item->stTextoItem($aMsg['st_pta_item_validacao']); 
                                                    $retorno .= $aMsg['nm_pessoa']." às ".$aMsg['dh_pta_item_validacao']." enviou ".$obj->msgText. " ".$aMsg['ds_pta_item_validacao']."\n";                                                            
                                                }
                                            }
                    
                    
                                    $retorno .= '</textarea>                                                                                                                                      
                                            </div><br>
                                            <div class="text-right">                                            
                                            <button class="btn btn-primary btn-rounded btn-envio-central" type="button" value="'.$key.'" tipo="'.$value['nm_tipo_gasto_categoria'].'" central="'.$value['nm_lotacao'].'">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Enviar Mensagem/Enviar Para Validação
                                            </button>
                                            </div>
                                        </div>';
                    
                    
                    $retorno .= "</div>";
                }
            }                                   
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }      
    }
    
    
    
    /**
     * Verifica Se Existe Itens do PTA de todos os PAS que não foram validados pela Central de Demanda     
     * e retorna uma Mensagem
     * @param type $pdo
     * @return boolean
     */
    function vItensValidacaoCentral($pdo = null){
        $this->sucesso = false;
        $retorno = "";
        try {
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $item = new PtaItem();    
            
            $status = $item->stItemNaoOk();
            if(!is_array($status)){
                $status = array($status);
            }
            
            $item->verificaItensValidacaoCentralPorPAS($this->idPas, $status, $pdo);
            if(!$item->Sucesso()){
                
                
                $status = $item->stItemValidado();
                if(!is_array($status)){
                    $status = array($status);
                }
                $item->verificaItensValidacaoCentralPorPAS($this->idPas, $status, $pdo);
                if(!$item->Sucesso()){
                    $this->sucesso = false;
                    $retorno = '<div class="alert alert-danger">
                                <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                                Não foi possível Localizar nenhum Item Cadastrado Nos PTAs
                            </div>';
                    return $retorno;
                }else{
                    //Está tudo Ok, tudo validado
                    $this->sucesso = true;
//                    $retorno = '<div class="alert alert-success">
//                                <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
//                                Todos os Itens do PTA Estão Validados Pela Central
//                            </div>';
                    return $retorno;
                }
                
               
            }else{
                $this->sucesso = false;
                $retorno .= '<div class="alert alert-danger">
                            <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                            Alguns Itens Ainda não foram validados Pela Central de Demanda/Ou Não foram enviados.
                        </div>';
                return $retorno;
            }                                                
            
        } catch (Exception $exc) {     
            $this->sucesso = false;
            $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Validações dos Itens dos PTAs. '.STR_ERROR.'
                    </div>';
            return $retorno;            
        }                            
    }
    
    
    private function retornaProximoStatusPas(int $status = 0){                
        
        switch ($status) {
            case 0:
                return $this->stPasPrimEnvioPlanejamento();
                break;
            case $this->stPasPrimRetornoUnidade():
                return $this->stPasPrimEnvioPlanejamento();
                break;
            case $this->stPasLiberadoPlanejamento():
                return $this->stPasPrimEnvioPlanejamento();
                break;             
            default:
                return NULL;
                break;
        }
    }
    
   /**
    * 
    * @param int $idPessoa
    * @param string $mensagem
    * @param int $perfil
    * @return type
    */
    public function enviarPlanejamento(int $idPessoa, string $mensagem, int $perfil = 0){
        try {       
            
            //Verifica se os campos foram preenchidos
            if($idPessoa == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                                    
            
            $this->carregaDados($this->idPas, $pdo);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                if(!$this->verificaPermissaoPas($this->idLotacao, $pdo)){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                
            }
            
            if($this->getIdPessoaResp() != $idPessoa){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Somente o Responsável da Unidade pela PAS poderá enviar para Validação ao Planejamento.");
            }
            
           
            //Precisa Verifica se a Pas Está na situação de envio, se está com os status que podem ser enviado para o
            //Planejamento            
            if(!$this->stPodeEnviarPlanejamento((int)$this->stPas)){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não pode enviar a PAS Para o Planejamento, pois o Status da PAS Não permite.");
            }
             
            
             //Seta os Campos
            $pla = new DaoPlaPas(); 
            $pla->setIdPas($this->idPas);
            $pla->retornaValoresPASLiberadoFonteUnidade($pdo);
            if(!$pla->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar os Valores dos PTAS ou Valores de Liberação pelo Planejamento.");
            }
            
            
            
            $result = $pla->getMsgRetorno();
            
            if($result['vl_liberado'] < $result['valor_pta']){
                return Metodos::retornoAjax("Erro", "alert", "Não pode enviar a PAS para Autorização"
                        . ", enquanto o valor Liberado estiver Menor que o Valor Total de todos os PTAS.");
            }
                     
            
            
            //Posterior Deve mudar o status da PAS
            $pla->setStPas($this->retornaProximoStatusPas((int)$this->stPas));                        
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pla->retornaPas($pdo);
           
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
           
            //Modifica o Status da PAS
            $pla->mudarStatus($pdo);
            if(!$pla->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno; 
            }
                                                                  
            //Salva no Log            
            if (!Log::SalvaLogU('pla_pas', $pla->getIdPas(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                    
             
            //Posterior Salvar a PasValidacao com a mensagem de envio.
            $pasValidacao = new PasValidacao();
            $pasValidacao->setIdPas($this->idPas);
            $pasValidacao->setIdPessoa($idPessoa);
            $pasValidacao->setDsPasValidacao($mensagem);
            $pasValidacao->setStPasValidacao($pla->getStPas());
                  
            $pasValidacao->salvar($pdo);
            if(!$pasValidacao->Sucesso()){                
                $retorno = Metodos::retornoAjax("Erro", "console", $pasValidacao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }                
            
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            
            $retorno = Metodos::retornoAjax("ok", "html", "PAS Enviado com Sucesso.");
            $pdo->commit();
            return $retorno;
           
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }    
    
    function retornaTextAreaDasValidacoes($pdo = null){
        $this->sucesso = false;        
        try {
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $pasV = new PasValidacao();
            $pasV->setIdPas($this->idPas);
            
            $pasV->retornaTextos($pdo);
            if(!$pasV->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $pasV->getMsgRetorno();
                
            }else{
                $retorno = "";
                $this->sucesso = true;
                
                $result = $pasV->getMsgRetorno();
                
                $retorno .= '<div class="panel">
                                <div class="panel-heading ">
                                   
                                    <h3 class="panel-title">Mensagens Trocadas com o Planejamento</h3>
                                </div>
                                <div class="panel-body">   
                                    <div class="text-left">                                                                                                                                          
                                        <textarea class="form-control" rows="4" disabled style="text-align: left;">';                
                                        foreach ($result as $key => $value) {
                                            $obj = $this->stTextoItem($value['st_pas_validacao']); 
                                            $retorno .= $value['nm_pessoa']." às ".$value['dh_pas_validacao']." ".$obj->msgText. " ".$value['ds_pas_validacao']."\n";
                                        }                                                                                    
                $retorno .= '           </textarea>';
                $retorno .= '       </div>'
                            . ' </div>'
                            .'</div>';
                
                
                
                
                
                
                $this->msgRetorno = $retorno;
            }                        
            
        } catch (Exception $exc) {     
            $this->sucesso = false;     
            $this->msgRetorno = $exc->getMessage();            
        }                            
    }
    
    /**
     * Retorna TR Com todas as PAS que estão esperando Validacao Pelo Planejamento
     * @return string
     */
    public function retornaTrPasParaValidar(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();
            $pas->setStPas($this->stPasPrimEnvioPlanejamento());
                                    
            $pas->retornaPasPlanejamentoValidar($pdo);
            
            if(!$pas->Sucesso()){
                echo $pas->getMsgRetorno();
                return $retorno;
            }else{
                $result = $pas->getMsgRetorno();
                foreach ($result as $v) {
                    $id = $v['id_pas'];                         
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_lotacao']."</td>"                            
                            . "<td>".$v['nm_pas']."</td>"                                                        
                            . '<td style="text-align: center;">'
                            . '<a href="pas_validar.php?token='.$id.'" class="btn btn-default btn-entrar btn-xs" title="Entrar"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                              </a> '                                
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
    
    
    public function pasValida(int $idPessoa, string $msg){
        try {       
            
            //Verifica se os campos foram preenchidos
            if($idPessoa == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();    
            
            $this->carregaDados($this->idPas, $pdo);
           
            //Precisa Verifica se a Pas Está na situação de envio, se está com os status que podem ser enviado para o
            //Planejamento            
            if(!$this->stPodeValidar((int)$this->stPas)){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não pode Validar a PAS, pois o Status da PAS Não permite.");
            }
             
            //Posterior Deve mudar o status da PAS
             //Seta os Campos
            $pla = new DaoPlaPas(); 
            $pla->setIdPas($this->idPas);
            $pla->setStPas($this->stPasPrimAutorizadoPlanejamento());                        
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pla->retornaPas($pdo);
           
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
           
            //Modifica o Status da PAS
            $pla->mudarStatus($pdo);
            if(!$pla->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno; 
            }
                                                                  
            //Salva no Log            
            if (!Log::SalvaLogU('pla_pas', $pla->getIdPas(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                    
             
            //Posterior Salvar a PasValidacao com a mensagem de envio.
            $pasValidacao = new PasValidacao();
            $pasValidacao->setIdPas($this->idPas);
            $pasValidacao->setIdPessoa($idPessoa);
            $pasValidacao->setDsPasValidacao($msg);
            $pasValidacao->setStPasValidacao($pla->getStPas());
                  
            $pasValidacao->salvar($pdo);
            if(!$pasValidacao->Sucesso()){                
                $retorno = Metodos::retornoAjax("Erro", "console", $pasValidacao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }                
            
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            
            $retorno = Metodos::retornoAjax("ok", "html", "PAS Autorizada com Sucesso.");
            $pdo->commit();
            return $retorno;
           
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }  
    
    public function pasNaoValida(int $idPessoa, string $msg){
        try {       
            
            //Verifica se os campos foram preenchidos
            if($idPessoa == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();    
            
            $this->carregaDados($this->idPas, $pdo);
           
            //Precisa Verifica se a Pas Está na situação de envio, se está com os status que podem ser enviado para o
            //Planejamento            
            if(!$this->stPodeValidar((int)$this->stPas)){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não pode Validar a PAS, pois o Status da PAS Não permite.");
            }
             
            //Posterior Deve mudar o status da PAS
             //Seta os Campos
            $pla = new DaoPlaPas(); 
            $pla->setIdPas($this->idPas);
            $pla->setStPas($this->stPasPrimRetornoUnidade());                        
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pla->retornaPas($pdo);
           
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
           
            //Modifica o Status da PAS
            $pla->mudarStatus($pdo);
            if(!$pla->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno; 
            }
                                                                  
            //Salva no Log            
            if (!Log::SalvaLogU('pla_pas', $pla->getIdPas(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                    
             
            //Posterior Salvar a PasValidacao com a mensagem de envio.
            $pasValidacao = new PasValidacao();
            $pasValidacao->setIdPas($this->idPas);
            $pasValidacao->setIdPessoa($idPessoa);
            $pasValidacao->setDsPasValidacao($msg);
            $pasValidacao->setStPasValidacao($pla->getStPas());
                  
            $pasValidacao->salvar($pdo);
            if(!$pasValidacao->Sucesso()){                
                $retorno = Metodos::retornoAjax("Erro", "console", $pasValidacao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }                
            
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            
            $retorno = Metodos::retornoAjax("ok", "html", "PAS Não Autorizada com Sucesso.");
            $pdo->commit();
            return $retorno;
           
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    } 
    
    /**
     * Retorna TR Com todas as PAS de um Ano que podem ser liberadas para Alteração Posterior a Autorização
     * @param int $ano
     * @return string
     */
    public function retornaTrPasParaLiberar(int $ano){
        $retorno = "";                
        try{
            
            if(strlen($ano) != 4){
                return "Ano Inválido";
            }
            
            $array = array($this->stPasPrimAutorizadoPlanejamento(), $this->stPasLiberadoPlanejamento());            
            $status = Metodos::implodeComAspas($array);
            
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();                        
                                                
            $pas->retornaPasPlanejamentoLiberar($status, $ano, $pdo);
            
            if(!$pas->Sucesso()){
                echo $pas->getMsgRetorno();
                return $retorno;
            }else{
                $result = $pas->getMsgRetorno();
                
                foreach ($result as $v) {
                    $id = $v['id_pas'];                         
                    $retorno .= "<tr>";
                    $cadeado = "fa-lock";
                    $btnCor = "danger";
                    $title = "Liberar";
                    $nomebotao = "liberar";
                    if($v['st_pas'] == $this->stPasLiberadoPlanejamento()){
                        $cadeado = "fa-unlock-alt";
                        $btnCor = "success";
                        $title = "Voltar Status de Bloqueado";
                        $nomebotao = "bloquear";
                    }
                    $retorno .= "<td>".$v['nm_lotacao']."</td>"                            
                            . "<td>".$v['nm_pas']."</td>"                                                        
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-'.$btnCor.' btn-'.$nomebotao.' btn-xs"'
                                       . ' title="'.$title.'"  '
                                       . 'value=' . $id . ' >
                                       <i class="fa '.$cadeado.' fa-lg" aria-hidden="true"></i>
                                     </button> ' 
                            . '<button type="button" class="btn btn-default btn-informacoes btn-xs"'
                                       . ' title="Visualizar Históricos"  '
                                       . 'value=' . $id . ' >
                                       <i class="fa fa-info fa-lg text-warning" aria-hidden="true"></i>
                                     </button> '                                                         
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
    
    
    public function liberaBloqueiaPas(int $idPessoa, string $msg, int $liberaBloqueia){
        try {       
            
            //Verifica se os campos foram preenchidos
            if($idPessoa == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();    
            
            $this->carregaDados($this->idPas, $pdo);
           
                         
            //Posterior Deve mudar o status da PAS
             //Seta os Campos
            $pla = new DaoPlaPas(); 
            $pla->setIdPas($this->idPas);
            
            if($liberaBloqueia == 1){
                $pla->setStPas($this->stPasLiberadoPlanejamento());
            }else{
                $pla->setStPas($this->stPasPrimAutorizadoPlanejamento());                        
            }
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pla->retornaPas($pdo);
           
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
           
            //Modifica o Status da PAS
            $pla->mudarStatus($pdo);
            if(!$pla->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno; 
            }
                                                                  
            //Salva no Log            
            if (!Log::SalvaLogU('pla_pas', $pla->getIdPas(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                    
             
            //Posterior Salvar a PasValidacao com a mensagem de envio.
            $pasValidacao = new PasValidacao();
            $pasValidacao->setIdPas($this->idPas);
            $pasValidacao->setIdPessoa($idPessoa);
            $pasValidacao->setDsPasValidacao($msg);
            $pasValidacao->setStPasValidacao($pla->getStPas());
                  
            $pasValidacao->salvar($pdo);
            if(!$pasValidacao->Sucesso()){                
                $retorno = Metodos::retornoAjax("Erro", "console", $pasValidacao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }                
            
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if($liberaBloqueia == 1){
                $retorno = Metodos::retornoAjax("ok", "html", "PAS Liberada com Sucesso.");
            }else{
                $retorno = Metodos::retornoAjax("ok", "html", "PAS Bloqueada com Sucesso.");
            }
            $pdo->commit();
            return $retorno;
           
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * Retorna TR Com todas as PAS de um Ano que podem ser liberadas para Alteração Posterior a Autorização
     * @param int $ano
     * @return string
     */
    public function retornaValidacaoPreLoa(int $ano){
        $retorno = "";                
        try{
            
            if(strlen($ano) != 4){
                return "Ano Inválido";
            }                        
            
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();              
            $pas->setStPas($this->stPasPrimAutorizadoPlanejamento());
            //Retorna as PAS de um ano que não estão com status de Autorizado pelo Planejamento 
            //Existe a PAS porém não foi autorizada ou enviada para autorização
            $pas->retornaPasNaoAutorizadasPorAno($ano, $pdo);
            
            $arrayPasNaoAutorizadas = array();
            $arrayPasAutorizadas = array();
            $arrayPasNaoCriadas = array();
            
            if($pas->Sucesso()){
               $arrayPasNaoAutorizadas = $pas->getMsgRetorno(); 
            }
                        
            //Busca as PAS Autorizadas Pelo Planejamento
            $pas->retornaPasAutorizadasPorAno($ano, $pdo);
            if($pas->Sucesso()){
               $arrayPasAutorizadas = $pas->getMsgRetorno(); 
            }
            
            //Busca todos possiveis Lotações que não possuem PAS
            $pas->retornaPasNaoCriadasPorAno($ano, $pdo);
            if($pas->Sucesso()){
               $arrayPasNaoCriadas = $pas->getMsgRetorno(); 
            }
            if(!empty($arrayPasNaoCriadas)){
                $e = json_decode($arrayPasNaoCriadas[2]['nm_pessoa'], true);          
            }
            
            $retorno .= '<div class="panel">
                                <div class="panel-heading ">                                   
                                    <h3 class="panel-title">Situação das PAS</h3>
                                </div>
                                <div class="panel-body">';            
                $retorno .= '<div clas="row">
                                <div class="col-md-4">
                                    <div class="panel media middle pad-all">
                                        <div class="media-left">
                                            <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                            <i class="icon-2x"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="text-2x mar-no text-semibold text-main">'.count($arrayPasAutorizadas).'</p>
                                            <p class="text-main mar-no">PAS Autorizadas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel media middle pad-all">
                                        <div class="media-left">
                                            <span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                            <i class="icon-2x"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="text-2x mar-no text-semibold text-main">'.count($arrayPasNaoAutorizadas).'</p>
                                            <p class="text-main mar-no">PAS Não Autorizadas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel media middle pad-all">
                                        <div class="media-left">
                                            <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
                                            <i class="icon-2x"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="text-2x mar-no text-semibold text-main">'.count($arrayPasNaoCriadas).'</p>
                                            <p class="text-main mar-no">PAS Não Criadas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                if(count($arrayPasNaoAutorizadas) > 0){
                    $retorno .= '<table class="table table-striped table-bordered" cellspacing="0" width="100%">'
                                . '<caption><h4 class="text-main">PAS Não Autorizadas</h4></caption>'
                                . '<thead>'
                                    . '<tr>'
                                        . '<th>PAS</th>'
                                        . '<th>'.STR_LOTACAO.'</th>'                                    
                                        . '<th style="text-align: center;">Situação</th>'                                    
                                    . '</tr>'
                                . '</thead>'
                                . '<tbody>';

                        foreach ($arrayPasNaoAutorizadas as $v) {

                            $obj = $this->stTextoItem($v['st_pas']);                        
                            $retorno .= "<tr>"
                                        . "<td>".$v['nm_pas']."</td>"
                                        . "<td>".$v['nm_lotacao']."</td>"                                    
                                        . "<td style='text-align: center;'>". '<span class="label label-'.$obj->cor.'">'.$obj->msg.'</span>'."</td>"                                                                        
                                    . "</tr>";                                                                                                
                        }

                        $retorno .= "</tbody>";                   
                        $retorno .= "</table>";
                }
                
                if(count($arrayPasNaoCriadas) > 0){
                    $retorno .= '<table class="table table-striped table-bordered" cellspacing="0" width="100%">'
                                . '<caption><h4 class="text-main">PAS Não Criadas</h4></caption>'
                                . '<thead>'
                                    . '<tr>'
                                        . '<th>Unidade/Departamento/Setor</th>'
                                        . '<th>Responsáveis</th>'                                                                            
                                    . '</tr>'
                                . '</thead>'
                                . '<tbody>';

                        foreach ($arrayPasNaoCriadas as $v) {
                            
                            $e = json_decode($v['nm_pessoa'], true);
                            $nomes = implode(", ", $e);
                                
                            $retorno .= "<tr>"
                                        . "<td>".$v['nm_lotacao']."</td>"
                                        . "<td>".$nomes."</td>"                                                                            
                                    . "</tr>";                                                                                                
                        }

                        $retorno .= "</tbody>";                   
                        $retorno .= "</table>";
                }
            
            $retorno .= '</div>';
            
           
            
            $retorno .= '</div>';
            
                                               
            return $retorno;                                                
        } catch (Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            $retorno = "";
        }                               
    }
    
    
    
    public function retornaSimulacaoValoresPreLOA(int $ano){
        $retorno = "";                
        try{
            
            if(strlen($ano) != 4){
                return "Ano Inválido";
            }                        
            
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new DaoPlaPas();              
            $pas->setStPas($this->stPasPrimAutorizadoPlanejamento());
            
            $ptaItem = new PtaItem();
            
            
            //Retorna as PAS de um ano que não estão com status de Autorizado pelo Planejamento 
            //Existe a PAS porém não foi autorizada ou enviada para autorização
            $pas->retornaSimulacaoPreLOAPorAno($ano, $ptaItem->stItemValidado(), $pdo);
            
            if(!$pas->Sucesso()){
                $retorno = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                        Não foi Possível Localizar Nenhum PAS Autorizado Para Gerar a Simulação da Prévia-LOA.
                    </div>';
                return $retorno;
            }
            
            $result = $pas->getMsgRetorno();
            
            $arrayDados = array();
            
            foreach ($result as $value) {
                if(array_key_exists($value['id_programa_trabalho'], $arrayDados)){
                    if(array_key_exists($value['id_despesa_elemento'], $arrayDados[$value['id_programa_trabalho']]["elementos"]  )){
                       $arrayDados[$value['id_programa_trabalho']] ["elementos"][$value['id_despesa_elemento']]['fontes'][$value['id_fonte']] = array(                                                                                                        
                                "fonte" => $value['nr_fonte'],
                                "valor" => $value['valor']
                        ); 
                        
                    }else{                                        
                        $arrayDados[$value['id_programa_trabalho']] ["elementos"][$value['id_despesa_elemento']] = array(                                
                                    "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                                    "valorTotal" => 0,
                                    "fontes" => array($value['id_fonte'] => array( 
                                        "fonte" => $value['nr_fonte'],
                                        "valor" => $value['valor']
                                    )
                            )                        
                        );
                    }
                    
                }else{
                    
                    
                    $arrayDados[$value['id_programa_trabalho']] = array(
                        "programa_trabalho" => $value['programa_trabalho'],
                        "ds_programa_trabalho" => $value['ds_programa_trabalho'],                       
                        "elementos" => array($value['id_despesa_elemento'] => array(                                
                            "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                            "valorTotal" => 0,
                            "fontes" => array($value['id_fonte'] => array( 
                                "fonte" => $value['nr_fonte'],
                                "valor" => $value['valor']
                            )))
                        )                        
                    );                    
                    foreach (Metodos::getFontes() as $id => $fontes) {
                        $arrayDados[$value['id_programa_trabalho']]['fonte_'.$id] = 0;
                    }
                }
            }
            
            
            
            
            //Arrumar os Valores
            foreach ($arrayDados as $key => $value) {
                $arrayDados[$key]['qtd_elementos'] = count($value['elementos'])+1;
                foreach ($value['elementos'] as $k1 => $v1) {
                    $valorElemento = 0;
                    foreach ($v1['fontes'] as $k2 => $v2) {
                        $arrayDados[$key]['fonte_'.$k2] += $v2['valor'];
                        $valorElemento += $v2['valor'];
                    }                    
                    $arrayDados[$key]['elementos'][$k1]['valorTotal'] = $valorElemento;
                    
                }
            }
            
//            echo "<pre>";            
//            print_r($arrayDados);
//            echo "</pre>";
//            return;
            
            $retorno .= '<div class="panel panel-default">';                                                  
            
            $retorno .= '<table class="table table-bordered" id="tabela" cellspacing="0" width="100%">'                           
                    . '<tbody>';
            $valorTotal = 0;
            foreach (Metodos::getFontes() as $key => $value) {
                ${'fonte_'.$key} = 0;
            }            
            foreach ($arrayDados as $key => $value) {
                    $valorTotalPrograma = 0;
                                        
                    $retorno .= '<tr class="success text-bold">'
                                . '<td>Projeto/Atividade</td>'
                                . '<td>Programa de Trabalho</td>'
                                . '<td class="text-center">Despesa</td>'
                                . '<td class="text-center">Fonte 100</td>'
                                . '<td class="text-center">Fonte 200</td>'
                                . '<td class="text-center">Fonte 400</td>'
                                . '<td class="text-center">Fonte 500</td>'
                                . '<td class="text-center">Total</td>'
                            . '</tr>';
                    
                    //Inicio do Programa de Trabalho
                    $retorno .= "<tr>"
                                . "<td rowspan='".$value['qtd_elementos']."'>".$value['ds_programa_trabalho']."</td>"
                                . "<td rowspan='".$value['qtd_elementos']."'>".$value['programa_trabalho']."</td></tr>";
                                        
                        foreach ($value['elementos'] as $k2 => $v2) {
                            $retorno .= "<tr><td class='text-center'>".$v2['cd_despesa_elemento']."</td>";
                            foreach (Metodos::getFontes() as $k3 => $v3) {
                                if(array_key_exists($k3, $v2['fontes'])){
                                    $retorno .= "<td class='text-right'> R$ ".Metodos::ConverteValorBr($v2['fontes'][$k3]['valor'], 4)."</td>";
                                }else{
                                    $retorno .= "<td class='text-center'> - </td>";
                                }
                            }  
                            $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($v2['valorTotal'], 4)."</td></tr>";
                        }
                                                                                                    
                    $retorno .= "<tr class='success text-bold'>"
                            . "<td colspan='3'>Total</td>";
                    
                    foreach (Metodos::getFontes() as $k3 => $v3){
                        $valorTotalPrograma += $value['fonte_'.$k3];
                        ${'fonte_'.$k3} += $value['fonte_'.$k3];
                        $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($value['fonte_'.$k3], 4)."</td>";
                    }                    
                    $retorno .= "<td class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalPrograma, 4)."</td>";                            
                    $retorno .= "</tr>";
                                                            
                    $retorno .= "<tr class='default'><td colspan='7'></td></tr>";
                   
            }
            
            $retorno .= "</tbody>";
            $retorno .= "<tfoot >"
                        . "<tr class='warning'>"
                            . "<th colspan='3'>Total</th>";
                    foreach (Metodos::getFontes() as $k3 => $v3) {
                        $valorTotal += ${'fonte_'.$k3};
                        $retorno .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr(${'fonte_'.$k3}, 4)."</th>";
                    }                                                                
                $retorno  .= "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                            
                        . "</tr>"
                    . "</tfoot>";
            $retorno .= "</table>";

            $retorno .= "</div>";
            
            return $retorno;
            
                                                                                                                           
        } catch (Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            $retorno = "";
        }                               
    }
    
    
    public function retornaValoresPreLOA(int $ano, PDO $pdo = null){
        $retorno = "";                
        try{
            
            if(strlen($ano) != 4){
                return "Ano Inválido";
            }                        
            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $pas = new DaoPlaPas();              
            $pas->setStPas($this->stPasPrimAutorizadoPlanejamento());
            
            $ptaItem = new PtaItem();
            
            
            //Retorna as PAS de um ano que não estão com status de Autorizado pelo Planejamento 
            //Existe a PAS porém não foi autorizada ou enviada para autorização
            $pas->retornaSimulacaoPreLOAPorAno($ano, $ptaItem->stItemValidado(), $pdo);
            
            if(!$pas->Sucesso()){                
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Localizar Nenhum Valor para ser inserido.";
                return $retorno;
            }
        
            $this->sucesso = true;
            $this->msgRetorno = $pas->getMsgRetorno();            
                                                                                                                           
        } catch (Exception $ex) {
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
            $retorno = "";
        }                               
    }
    
    public function retornaOptionLotacaoExistePAS(PDO $pdo = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoPlaPas();
            
            $dao->retornaTodasLotacoes($pdo);
            if($dao->Sucesso()){
                foreach ($dao->getMsgRetorno() as $v) {
                    $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
}

?>
