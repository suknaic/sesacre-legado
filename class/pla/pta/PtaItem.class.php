<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPtaItem.class.php";

class PtaItem{
    
    private $idPtaItem = null;
    private $idPtaTitulo = null;
    private $idMaterial = null;
    private $dsPtaItem = null;
    private $idPtaAcaoDet = null;
    private $idTipoGasto = null;
    private $idTipoGastoCategoria = null;
    private $idUnidadeMedida = null;
    private $idFonte = null;
    private $tpFonte = null;
    private $idPortaria = null;
    private $idConvenio = null;
    private $qtPtaItem = null;
    private $vlPtaItem = null;
    private $cdMaterial = null;
    private $sucesso = null;
    private $msgRetorno = null;        
    private $itemSalvo = 1;
    private $itemRetornoCentral = 2;
    private $itemEnviadoCentral = 3;
    private $itemValidado = 4;
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    function getIdPtaItem() {
        return $this->idPtaItem;
    }

    function getIdPtaTitulo() {
        return $this->idPtaTitulo;
    }

    function getIdMaterial() {
        return $this->idMaterial;
    }

    function getDsPtaItem() {
        return $this->dsPtaItem;
    }

    function getIdPtaAcaoDet() {
        return $this->idPtaAcaoDet;
    }

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getIdTipoGastoCategoria() {
        return $this->idTipoGastoCategoria;
    }

    function getIdUnidadeMedida() {
        return $this->idUnidadeMedida;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getQtPtaItem() {
        return $this->qtPtaItem;
    }

    function getVlPtaItem() {
        return $this->vlPtaItem;
    }

    function getCdMaterial() {
        return $this->cdMaterial;
    }

    function setIdPtaItem($idPtaItem) {
        $this->idPtaItem = $idPtaItem;
        return $this;
    }

    function setIdPtaTitulo($idPtaTitulo) {
        $this->idPtaTitulo = $idPtaTitulo;
        return $this;
    }

    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
        return $this;
    }

    function setDsPtaItem($dsPtaItem) {
        $this->dsPtaItem = $dsPtaItem;
        return $this;
    }

    function setIdPtaAcaoDet($idPtaAcaoDet) {
        $this->idPtaAcaoDet = $idPtaAcaoDet;
        return $this;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
        return $this;
    }

    function setIdTipoGastoCategoria($idTipoGastoCategoria) {
        $this->idTipoGastoCategoria = $idTipoGastoCategoria;
        return $this;
    }

    function setIdUnidadeMedida($idUnidadeMedida) {
        $this->idUnidadeMedida = $idUnidadeMedida;
        return $this;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
        return $this;
    }

    function setQtPtaItem($qtPtaItem) {
        $this->qtPtaItem = $qtPtaItem;
        return $this;
    }

    function setVlPtaItem($vlPtaItem) {
        $this->vlPtaItem = $vlPtaItem;
        return $this;
    }

    function setCdMaterial($cdMaterial) {
        $this->cdMaterial = $cdMaterial;
        return $this;
    }
    
    function getTpFonte() {
        return $this->tpFonte;
    }

    function getIdPortaria() {
        return $this->idPortaria;
    }

    function getIdConvenio() {
        return $this->idConvenio;
    }

    function setTpFonte($tpFonte) {
        $this->tpFonte = $tpFonte;
        return $this;
    }

    function setIdPortaria($idPortaria) {
        $this->idPortaria = $idPortaria;
        return $this;
    }

    function setIdConvenio($idConvenio) {
        $this->idConvenio = $idConvenio;
        return $this;
    }

        
    /**
     * 1 - Estado Normal do Item, somente foi cadastrado no PTA
     * 2 - Estado de Retorno da Validação da Central de Demanda, ou seja, o Item não está de acordo com o que a Central     
     * @return array
     */
    public function stItemNaUnidade() {
        return array($this->itemSalvo, $this->itemRetornoCentral);        
    }
    
    /**
     * 1 - Estado Normal do Item, somente foi cadastrado no PTA
     * 2 - Estado de Retorno da Validação da Central de Demanda, ou seja, o Item não está de acordo com o que a Central
     * 3 - Item Enviado Pela Validação na Central     
     * @return array
     */
    public function stItemNaoOk() {
        return array($this->itemSalvo, $this->itemRetornoCentral, $this->itemEnviadoCentral);        
    }
    
    /**
     * 3 - Item foi enviado para Validação na Central de Demanda
     * @return int
     */
    public function stItemEnviadoValidacaoCentral(){
        return $this->itemEnviadoCentral;
    }
    /**
     * 1 - Estado Normal do Item, somente foi cadastrado no PTA
     * @return int
     */
    public function stItemSalvo(){
        return $this->itemSalvo;
    }
    
    /**
     * 2 - Estado de Retorno da Validação da Central de Demanda, ou seja, o Item não está de acordo com o que a Central
     * Acha, e retornou para a Unidade reformular ele.
     * @return int
     */
    public function stItemRetornoCentral(){
        return $this->itemRetornoCentral;
    }
    
    /**
     * 4 - Estado Validado do Item Pela Central
     * @return int
     */
    public function stItemValidado(){
        return $this->itemValidado;
    }
    
    
    /**
     * Retorna um Texto e uma cor a ser usanda informado o Status do Item
     * @param type $status
     * @return Object
     */
    public function stTextoItem($status){
        $obj = new stdClass();
        switch ($status) {
            case $this->itemSalvo:                
                $obj->msg = "Não Enviado"; $obj->cor = "warning"; $obj->msgText = "";
                return $obj;                
                break;
            case $this->itemRetornoCentral:
                $obj->msg = "Não Validado Pela Central"; $obj->cor = "danger";  $obj->msgText = " Não Validou os Itens que foram enviados. Mensagem da Central: ";
                return $obj;
                breal;
            case $this->itemEnviadoCentral:
                $obj->msg = "Enviado Para Central"; $obj->cor = "info"; $obj->msgText = " Uma Mensagem/Validação dos Itens Para a Central. Mensagem Para a Central: ";
                return $obj;
                break;
            case $this->itemValidado:
                $obj->msg = "Validado"; $obj->cor = "success"; $obj->msgText = " Validou os Itens. Mensagem da Central: ";
                return $obj;
                break;
            default:
                $obj->msg = "Sem Definição"; $obj->cor = "default"; $obj->msgText = "";
                return $obj;                                   
                break;            
        }
    }

        
                              
    public function salvar($idPessoa, $perfil){
        try {         
            
            if($this->idPtaTitulo == 0 || $this->cdMaterial == 0
                    || $this->idPtaAcaoDet == 0 || $this->idTipoGastoCategoria == 0
                    || $this->idUnidadeMedida == 0
                    || $this->idFonte == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();            
            $pdo->beginTransaction();
                       
            //Seta os Cammpos
            $dao = new DaoPlaPtaItem();
            $dao->setIdPtaTitulo($this->idPtaTitulo);
            $dao->setDsPtaItem($this->dsPtaItem);
            $dao->setIdPtaAcaoDet($this->idPtaAcaoDet);
            $dao->setIdTipoGastoCategoria($this->idTipoGastoCategoria);
            $dao->setIdUnidadeMedida($this->idUnidadeMedida);
            $dao->setIdFonte($this->idFonte);
            $dao->setQtPtaItem(Metodos::ConverteValorIng($this->qtPtaItem));
            $dao->setVlPtaItem(Metodos::ConverteValorIng($this->vlPtaItem));
            $dao->setIdTipoGasto($this->idTipoGasto);
            $dao->setTpFonte($this->tpFonte);
            $dao->setIdPortaria($this->idPortaria);
            $dao->setIdConvenio($this->idConvenio);
            
            if(empty($dao->getTpFonte())){
                $dao->setTpFonte(NULL);                
            }
            if(empty($dao->getIdPortaria())){
                $dao->setIdPortaria(NULL);
            }
            if(empty($dao->getIdConvenio())){
                $dao->setIdConvenio(NULL);
            }
            
            //Se tipo da Fonte tiver selecionado, então não se pode ter Portaria ou Convenio selecionado.
            if( !empty($dao->getTpFonte()) 
                    && ( !empty($dao->getIdPortaria()) || !empty($dao->getIdConvenio()) ) ){
                return Metodos::retornoAjax("Erro", "alert", "Se Tipo da Fonte for Selecionado, então não deve exister Portaria/Convênio.");                
            }                        
            
            //Verifica se é insert ou edição
            $inserir = 0;
            if($this->idPtaItem == "" 
                    || $this->idPtaItem == 0){                
                $inserir = 1;
                $dao->setIdPtaItem(NULL);
            }else{
                $dao->setIdPtaItem($this->idPtaItem);
            }
            
            $p = new PtaTitulo();
            $p->setIdPtaTitulo($this->idPtaTitulo);            
            $p->carregaDados($pdo);
                                                            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$p->verificaPermissaoPas($p->getIdPas(), $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }
            
            //Verifica se a PAS está apta a receber Insert ou Update
            $pas = new Pas();            
            $pas->carregaDados($p->getIdPas(), $pdo);                        
            if(!$pas->stPodeEnviarPlanejamento((int)$pas->getStPas())){
                return Metodos::retornoAjax("Erro", "alert", STR_PLANEJAMENTO_LIBERAR);
            }                                                                                                                                                            
                                       
            //Verifica Validação dos Itens
            $item = new Itens();
            $item->setCdDescMaterial($this->cdMaterial);
            $item->salva($pdo);
                       
            if(!$item->Sucesso()){                
                return Metodos::retornoAjax("Erro", "alert", $item->getMsgRetorno());                
            }else{
                $dao->setIdMaterial($item->getIdItem());
            }
                        
            $ano = new DateTime($p->getDtInicio());
            
            //Verifica se Existe Liberação do Planejamento Para a 
            //Programa de Trabalho, Lotação, Ano, Fonte, Despesa
            $libercao = new LiberacaoFonteUnidade();           
            $libercao->verificaExisteLiberacaoParaPTA((int)$p->getIdProgramaTrabalho(), (int)$p->getIdLotacao()
                    , (int)$ano->format("Y"), (int)$dao->getIdFonte(), (int)$item->getIdDespesa(), $pdo);
            if(!$libercao->Sucesso()){               
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não existe Liberação Para Esse Elemento de Despesa e Fonte.");                
            }
            
            $sucesso = false;
            
            //irá dar Insert nos Dados
            if($inserir == 1){                
                $dao->insert($pdo);
                if(!$dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }else{
                    $dao->setIdPtaItem($pdo->lastInsertId('pla_pta_item_id_pta_item_seq'));
                    if (Log::SalvaLogI('pla_pta_item', $dao->getIdPtaItem(), $pdo)) {
                        $sucesso = true;
                    }else{
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
                
                
            //Irá somente Atualizar os Dados
            //Precisa Validar de novo os Itens do PTA caso a PAS esteja liberada.
            }else{
                $dao->retorna($pdo);
                $busca = $dao->getMsgRetorno();
                if(!$dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }else{                                        
                    
                    $dao->setStPtaItem($this->stItemSalvo());
                                                            
                    $dao->update($pdo);
                    if(!$dao->Sucesso()){
                        $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }else{
                        if (!Log::SalvaLogU('pla_pta_item', $dao->getIdPtaItem(), $busca, $pdo)) {
                            $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                            $pdo->rollBack();
                            return $retorno;
                        }else{
                            $sucesso = true;
                        }   
                    }
                    
                }
                
            }
            
            //Gerar Log no Evento de Log dos Itens do PTA caso a PAS esteja liberada.
            //Assim saberemos tudo que foi alterado posterior a Autorização.
            if($pas->stGeraLog((int)$pas->getStPas())){
                //Nova conexao para pegar os dados originais
                $conexaoAux = new Conexao();
                /* @var $pdo PDO */
                $pdoAux = $conexaoAux->connect();
                $dao->retornaDadosParaAlteracao($pdoAux);            
                $antigo = array();
                if($dao->Sucesso()){
                    $antigo = $dao->getMsgRetorno();
                }

                $novo = array();
                $dao->retornaDadosParaAlteracao($pdo);           
                if($dao->Sucesso()){
                    $novo = $dao->getMsgRetorno();
                }

                $json = $this->retornaJSONAlteracaoDaPAS($antigo, $novo, $inserir == 1 ? "I" : "U");
                
                if(!empty($json)){

                    $pasAlteracao = new PasAlteracao();       
                    $pasAlteracao->setIdPas($p->getIdPas());
                    $pasAlteracao->setIdPessoa($idPessoa);
                    $pasAlteracao->setIdPtaTitulo($p->getIdPtaTitulo());
                    $pasAlteracao->setIdPta($p->getIdPta());     
                    $pasAlteracao->setIdPtaItem($dao->getIdPtaItem());
                    if($inserir == 1){
                        $pasAlteracao->setTpPasAlteracao("I");
                    }else{
                        $pasAlteracao->setTpPasAlteracao("U");
                    }                    
                    $pasAlteracao->setDsPasAlteracao($json);
                    $pasAlteracao->setDsTela("Item do PTA");

                    $pasAlteracao->salvar($pdo);
                    if(!$pasAlteracao->Sucesso()){
                        $retorno = Metodos::retornoAjax("Erro", "console", "Não foi possível salvar a Alteração dos Itens");
                        $pdo->rollBack();
                        return $retorno;
                    }            
                }
            }      
                                  
            
                
                       
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

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
       
    public function remover($idPessoa, $perfil){
        try {
                                    
            if($this->idPtaItem == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaPtaItem();
            
            $dao->setIdPtaItem($this->idPtaItem);       
            
            $dao->retorna($pdo);
            $busca = $dao->getMsgRetorno();
            
            $this->setIdPtaTitulo($busca['id_pta_titulo']);
            $p = new PtaTitulo();
            $p->setIdPtaTitulo($this->idPtaTitulo);            
            $p->carregaDados($pdo);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA                
                if(!$p->verificaPermissaoPas($p->getIdPas(), $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }
            
            //Verifica se a PAS está apta a receber Insert ou Update
            $pas = new Pas();            
            $pas->carregaDados($p->getIdPas(), $pdo);            
            if(!$pas->stPodeEnviarPlanejamento((int)$pas->getStPas())){
                return Metodos::retornoAjax("Erro", "alert", STR_PLANEJAMENTO_LIBERAR);
            }
            
            //Caso esse Item já tenha alguma Movimentação, ele somente deverá ser desativa e não Ativado
            //Mudar para o Status do Item
            if($busca['st_pta_item'] > 1){
                $dao->desativa($pdo);
                if(!$dao->Sucesso()){                   
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;  
                }                    
                if (!Log::SalvaLogU('pla_pta_item', $dao->getIdPtaItem(), $busca, $pdo)) {                    
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                
            }else{                                               
                if ($dao->Sucesso()){
                    if (!Log::SalvaLogD('pla_pta_item', $dao->getIdPtaItem(), $pdo)){
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }                
                } else{
                   $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o Item.");
                   $pdo->rollBack();
                   return $retorno;
                }
                
                $dao->delete($pdo);
                if(!$dao->Sucesso()){                             
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;                
                }                            
            }    
            
            
            //Gerar Log no Evento de Log dos Itens do PTA caso a PAS esteja liberada.
            //Assim saberemos tudo que foi alterado posterior a Autorização.
            if($pas->stGeraLog((int)$pas->getStPas())){
                $novo = array();
                //Nova conexao para pegar os dados originais
                $conexaoAux = new Conexao();
                /* @var $pdo PDO */
                $pdoAux = $conexaoAux->connect();
                $dao->retornaDadosParaAlteracao($pdoAux);                       
                if($dao->Sucesso()){
                    $novo = $dao->getMsgRetorno();
                }

                $antigo = array();                     

                $json = $this->retornaJSONAlteracaoDaPAS($antigo, $novo, "D");                        

                $pasAlteracao = new PasAlteracao();       
                $pasAlteracao->setIdPas($p->getIdPas());
                $pasAlteracao->setIdPessoa($idPessoa);
                $pasAlteracao->setIdPtaTitulo($p->getIdPtaTitulo());
                $pasAlteracao->setIdPta($p->getIdPta());            
                $pasAlteracao->setTpPasAlteracao("D");            
                $pasAlteracao->setDsPasAlteracao($json);
                $pasAlteracao->setDsTela("Item do PTA");
                if($busca['st_pta_item'] > 1){
                    $pasAlteracao->setIdPtaItem($dao->getIdPtaItem());
                }

                $pasAlteracao->salvar($pdo);
                if(!$pasAlteracao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", "Não foi possível salvar a Alteração dos Itens");
                    $pdo->rollBack();
                    return $retorno;
                }                                           
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
    
    
    public function retornaTbDosItens($pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
            
            $dao = new DaoPlaPtaItem();
            $dao->setIdPtaTitulo($this->idPtaTitulo);
            $dao->setIdTipoGasto($this->idTipoGasto);
                        
            $dao->retornaPorPtaTituloTipoGasto($pdo);
           
            $arrayItens = [];
            
            if(!$dao->Sucesso()){
                return $retorno;
            }else{
                $result = $dao->getMsgRetorno();
                //Organizar o Retorno em Array Agrupado Por Tipo de Gasto Categoria                
                foreach ($result as $value) {
                    if(array_key_exists($value['id_tipo_gasto_categoria'], $arrayItens)){
                        $arrayItens[$value['id_tipo_gasto_categoria']]['itens'][] = array(
                                "id_pta_item" => $value['id_pta_item'],                                
                                "qt_pta_item" => $value['qt_pta_item'],
                                "vl_pta_item" => $value['vl_pta_item'],
                                "nm_desc_material" => $value['nm_desc_material'],                                
                                "nm_pta_acao_det" => $value['nm_pta_acao_det'],
                                "nm_unidade_medida" => $value['nm_unidade_medida'],
                                "nr_fonte" => $value['nr_fonte'],
                                "st_pta_item" => $value['st_pta_item']
                            );
                    }else{
                        $arrayItens[$value['id_tipo_gasto_categoria']] = array(
                            "nm_tipo_gasto_categoria" => $value['nm_tipo_gasto_categoria'],
                            "itens" => array(array(
                                "id_pta_item" => $value['id_pta_item'],                                
                                "qt_pta_item" => $value['qt_pta_item'],
                                "vl_pta_item" => $value['vl_pta_item'],
                                "nm_desc_material" => $value['nm_desc_material'],                                
                                "nm_pta_acao_det" => $value['nm_pta_acao_det'],
                                "nm_unidade_medida" => $value['nm_unidade_medida'],
                                "nr_fonte" => $value['nr_fonte'],
                                "st_pta_item" => $value['st_pta_item']
                            ))                            
                        );
                    }                                        
                }                                
            }
            
            if(count($arrayItens) > 0){
                foreach ($arrayItens as $key => $value) {  
                    
                    $valorTotal = 0;
                    $retorno .= '<div class="panel panel-default">'
                                . '<div class="panel-heading" style="margin-bottom: 5px;">'
                                    . '<div class="panel-title">Tipo de Gasto Categoria: '.$value['nm_tipo_gasto_categoria'].'</div>'
                                . '</div>';                    
                    
                    $retorno .= '<table class="table table-striped table-bordered tabela-itens-salvo" cellspacing="0" width="100%" id="'.$key.'">'
                            . '<thead>'
                                . '<tr>'
                                    . '<th>Item</th>'
                                    . '<th>Fonte</th>'
                                    . '<th>Detalhamento da Ação</th>'
                                    . '<th style="white-space: nowrap; overflow: hidden;">Qtd - Valor Unit. - Total</th>'
                                    . '<th class="text-center">Ações</th>'
                                . '</tr>'
                            . '</thead>'
                            . '<tbody>';
                    
                    foreach ($value['itens'] as $v) {
                        $id = $v['id_pta_item'];
                        $valorTotal += (float)($v['qt_pta_item']*$v['vl_pta_item']);
                        $obj = $this->stTextoItem($v['st_pta_item']);
                        $retorno .= "<tr>"
                                    . "<td>".$v['nm_desc_material']." - ".$v['nm_unidade_medida']."</td>"
                                    . "<td>".$v['nr_fonte']."</td>"
                                    . "<td>".$v['nm_pta_acao_det']."</td>"
                                    . "<td style='white-space: nowrap; overflow: hidden;'>".Metodos::ConverteValorBr((float)$v['qt_pta_item'], 4)." - R$ ". Metodos::ConverteValorBr((float)$v['vl_pta_item'], 4)." - R$ ".Metodos::ConverteValorBr((float)($v['qt_pta_item']*$v['vl_pta_item']), 4)."</td>"
                                    . '<td style="text-align: center;" class='.$obj->cor.'>'                                                     
                                    . '<button type="button" class="btn btn-default btn-informacoes btn-xs"'
                                        . ' title="Informações"  '
                                        . 'value=' . $id . ' >
                                        <i class="fa fa-info fa-lg text-warning" aria-hidden="true"></i>
                                      </button> '
                                    . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                                        . ' title="Editar" nome="'.$v['nm_desc_material'].'"  '
                                        . 'value=' . $id . ' >
                                        <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                      </button> '
                                    . '<button type="button" class="btn btn-default btn-remover btn-xs"'
                                        . ' title="Remover" nome="'.$v['nm_desc_material'].'" '
                                        . 'value=' . $id . ' >
                                        <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                      </button>'
                                    . '</td>'
                                    . "</td>"
                                . "</tr>";                                                                                                
                    }
                                                                                
                    $retorno .= "</tbody>";
                    $retorno .= "<tfoot>"
                                . "<tr>"
                                    . "<th colspan='3'>Total</th>"
                                    . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"
                                    . "<th></th>"
                                . "</tr>"
                            . "</tfoot>";
                    $retorno .= "</table>";
                    
                    $retorno .= "</div>";
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
            $dao = new DaoPlaPtaItem();            
            $dao->setIdPtaItem($this->idPtaItem);                                             
            $dao->retornaDadosParaEdicao($pdo);
            
            if(!$dao->Sucesso()){                
                return Metodos::retornoAjax("nao_encontrou", "", "");
            }else{                
                $retorno = $dao->getMsgRetorno();
                $retorno['qt_pta_item'] = Metodos::ConverteValorBr($retorno['qt_pta_item'], 4);
                $retorno['vl_pta_item'] = Metodos::ConverteValorBr($retorno['vl_pta_item'], 4);
                return Metodos::retornoAjax("ok", "", $retorno);                
            }                                                                                   
                                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return;
        }
    }
    
    public function retornaInformacoesDoItem($pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
            
            $dao = new DaoPlaPtaItem();
            $dao->setIdPtaItem($this->idPtaItem);            
                        
            $dao->retornaDadosCompleto($pdo);                       
            
            if(!$dao->Sucesso()){               
                return $retorno;
            }else{
                $result = $dao->getMsgRetorno();                     
                $obj = $this->stTextoItem($result['st_pta_item']);
                
                $retorno .= '<div class="panel panelInformacoesItens">'
                            . '<div class="panel-body">'
                                . '<div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-bold">Item: <span class=text-'.$obj->cor.'>'.$obj->msg.'</span></p>
                                        <p>'.$result['nm_desc_material'].'</p>
                                    </div>                                   
                                </div>'
                                . '<div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-bold">Código da Descrição do Item:</p>
                                        <p>'.$result['cd_desc_material'].'</p>
                                    </div>                                    
                                </div>'
                        
                                . '<div class="row">
                                    <div class="col-sm-6">
                                        <p class="text-bold">Item:</p>
                                        <p>'.$result['nm_material'].'</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-bold">Código do Item:</p>
                                        <p>'.$result['cd_material'].'</p>
                                    </div>                                    
                                </div>'
                        
                                . '<div class="row">
                                    <div class="col-sm-6">
                                        <p class="text-bold">Nome do Grupo:</p>
                                        <p>'.$result['nm_grupo'].'</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-bold">Código do Grupo:</p>
                                        <p>'.$result['cd_grupo'].'</p>
                                    </div>                                    
                                </div>'
                        
                                . '<div class="row">
                                     <div class="col-sm-6">
                                        <p class="text-bold">Nome do Sub Grupo:</p>
                                        <p>'.$result['nm_sub_grupo'].'</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-bold">Código do Sub Grupo:</p>
                                        <p>'.$result['cd_sub_grupo'].'</p>
                                    </div>                                   
                                </div>'
                        
                                . '<div class="row">
                                    <div class="col-sm-6">
                                        <p class="text-bold">Elemento de Despesa:</p>
                                        <p>'.$result['cd_elemento_despesa'].'</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-bold">Tipo de Item:</p>
                                        <p>'.$result['tp_material'].'</p>
                                    </div>                                    
                                </div>'  
                        
                                . '<div class="row">
                                        <div class="col-sm-12">
                                            <p class="text-bold">Detalhamento da ação:</p>
                                            <p>'.$result['nm_pta_acao_det'].'</p>
                                        </div>                                   
                                    </div>'
                        
                                . '<div class="row">
                                        <div class="col-sm-12">
                                            <p class="text-bold">Descrição do Item:</p>
                                            <p>'.$result['ds_pta_item'].'</p>
                                        </div>                                   
                                    </div>'
                                
                                . '<div class="row">
                                        <div class="col-sm-6">
                                            <p class="text-bold">Tipo de Gasto Categoria:</p>
                                            <p>'.$result['nm_tipo_gasto_categoria'].'</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="text-bold">Fonte:</p>
                                            <p>'.$result['nr_fonte'].'</p>
                                        </div>                 
                                        <div class="col-sm-3">
                                            <p class="text-bold">Tipo Fonte:</p>
                                            <p>'.Metodos::retornaTpFonteTexto($result['tp_fonte']).'</p>
                                        </div>
                                    </div>';
                if(!empty ($result['id_portaria'])){
                    $retorno .=  '<div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-bold">Portaria:</p>
                                        <p>'.$result['nm_rede_tematica']." - ".$result['nm_portaria'].'</p>
                                    </div>
                                </div>';    
                }
                if(!empty ($result['id_convenio'])){
                    $retorno .=  '<div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-bold">Convênio:</p>
                                        <p>'.$result['id_convenio'].'</p>
                                    </div>
                                </div>';    
                }
                                
                $retorno           .= '<div class="row">
                                    <div class="col-sm-3">
                                        <p class="text-bold">Unidade Medida:</p>
                                        <p>'.$result['nm_unidade_medida'].'</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="text-bold">Quantidade:</p>
                                        <p>'.Metodos::ConverteValorBr((float)$result['qt_pta_item'], 4).'</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="text-bold">Valor Unitário:</p>
                                        <p>R$ '. Metodos::ConverteValorBr((float)$result['vl_pta_item'], 4).'</p>
                                    </div>  
                                     <div class="col-sm-3">
                                        <p class="text-bold">Valor Total:</p>
                                        <p>R$ '.Metodos::ConverteValorBr((float)($result['qt_pta_item']*$result['vl_pta_item']), 4).'</p>
                                    </div>  
                                </div>'
                                . '<div class="row">
                                        <div class="col-sm-6">
                                            <p class="text-bold">PTA:</p>
                                            <p>'.$result['nm_pta'].'</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-bold">PTA Título:</p>
                                            <p>'.$result['nm_pta_titulo'].'</p>
                                        </div>                                    
                                    </div>' 
                                . '<div class="row">
                                        <div class="col-sm-12">
                                            <p class="text-bold">Unidade/Departamento/Setor:</p>
                                            <p>'.$result['nm_lotacao'].'</p>
                                        </div>                                                                    
                                    </div>' 
                            
                            . '</div>'
                        . '</div>';
            }
                        
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    /**
     * 
     * @param int $idPas
     * @param type $pdo
     * @return type
     */
    public function retornaTodosItensPorPAS( int $idPas,  $pdo = null){
        $this->sucesso = false;
        
        try {
            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $dao = new DaoPlaPtaItem();                                                    
            $dao->retornaTodosItensPorPAS($idPas, $pdo);                       
            
            if(!$dao->Sucesso()){  
                $this->msgRetorno = $dao->getMsgRetorno();
                $this->sucesso = false;                
            }else{  
                $this->msgRetorno = $dao->getMsgRetorno();
                $this->sucesso = true;                
            }                        
            return;
        } catch (Exception $exc) {
            //echo $exc->getMessage();
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;             
            return;            
        }        
    }
            
    
    public function verificaItensValidacaoCentralPorPAS( int $idPas, array $status, $pdo = null){
        $this->sucesso = false;
        
        try {
            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $dao = new DaoPlaPtaItem();    
            $ids = Metodos::implodeComAspas($status);                                       
            $dao->verificaStatusPorPAS($idPas, $ids, $pdo);                       
            
            if(!$dao->Sucesso()){   
                $this->sucesso = false;                
            }else{  
                $this->sucesso = true;                
            }                        
            return;
        } catch (Exception $exc) {
            //echo $exc->getMessage();
            $this->sucesso = false;             
            return;            
        }        
    }
    
    
    /**
     * 
     * @param int $idPas
     * @param int $idTipoGastoCategoria
     * @param int $status
     * @param array $statusAtual
     * @param PDO $pdo
     * @return type
     */
    public function alterarStatusItensPorPASTipoGastoCategoria(array $arrayItens, $statusQueFicara, PDO $pdo){
        $this->sucesso = false;
        
        try {                        
                        
            $dao = new DaoPlaPtaItem();                                     
            
            $dao->setStPtaItem($statusQueFicara);
            
            foreach ($arrayItens as $value){                
                $dao->setIdPtaItem($value['id_pta_item']);
                $dao->retorna($pdo);
                if(!$dao->Sucesso()){
                    $pdo->rollBack();
                    $this->sucesso = false;
                    $this->msgRetorno = $dao->getMsgRetorno();
                    return;
                }
                $busca = $dao->getMsgRetorno();
                                
                $dao->mudaStatus($pdo);
                if(!$dao->Sucesso()){
                    $pdo->rollBack();
                    $this->sucesso = false;      
                    $this->msgRetorno = $dao->getMsgRetorno();
                    return;
                }else{
                    if (!Log::SalvaLogU('pla_pta_item', $dao->getIdPtaItem(), $busca, $pdo)){
                        $pdo->rollBack();
                        $this->sucesso = false;
                        $this->msgRetorno = "Log ".STR_ERROR;
                    }
                }
            }
            
            $this->sucesso = true;
            return;
                                                       
        } catch (Exception $exc) {
            //echo $exc->getMessage();
            $this->sucesso = false;      
            $this->msgRetorno = $exc->getMessage();
            return;            
        }     
    }
    
    
    /**
     * A partir de uma Central de Demanda, irá retornar uma TR de todos as unidades que solicitaram 
     * Validação dos Itens para a Tipo de Gasto de Categoria a qual ela pertence
     * @param int $idLotacao
     * @param type $pdo
     * @return type
     */
    public function retornaTrUnidadesParaValidarItens( int $idLotacao,  $pdo = null){
        $this->sucesso = false;
        
        try {
            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $dao = new DaoPlaPtaItem();                                                    
            $dao->retornaUnidadesValidarItensCentral($idLotacao, $pdo);                 
            
            if(!$dao->Sucesso()){
                $this->msgRetorno = $dao->getMsgRetorno();
                $this->sucesso = false;                
            }else{                 
                $result = $dao->getMsgRetorno();
                $retorno = "";
                foreach ($result as $value) {
                    $retorno .= "<tr>";
                        $retorno .= "<td>".$value['nm_lotacao']."</td>";
                        $retorno .= "<td>".$value['nm_pas']."</td>";
                        $retorno .= "<td>".$value['nm_tipo_gasto_categoria']."</td>";
                        $retorno .= "<td style='text-align: center;'>".$value['qtd_item']."</td>";
                        $retorno .= "<td style='text-align: center;'>"
                                    . "<a href='validar.php?token=".$value['id_lotacao']."&tokenC=".$idLotacao."&tokenP=".$value['id_pas']."' class='btn btn-default btn-entrar btn-xs' title='Visualizar Os Itens Para Validar'> 
                                        <i class='fa fa-search-plus fa-lg text-info' aria-hidden='true'></i>
                                    </a></td>";
                    $retorno .= "</tr>";
                }
                $this->msgRetorno = $retorno;
                $this->sucesso = true;                
            }                        
            return;
        } catch (Exception $exc) {            
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;             
            return;            
        }        
    }
    
    
    /**
     *      
     * @param int $idPas
     * @param int $idCentral
     * @param PDO $pdo
     * @return string
     */
    public function retornaTbDosItensPorCentralPasValidar(int $idPas, int $idCentral, $pdo = null){
        $retorno = "";
        $this->sucesso = false;
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
            
                                    
            $dao = new DaoPlaPtaItem();
            $dao->setStPtaItem($this->stItemEnviadoValidacaoCentral());          
            $dao->retornaPorCentralPasStatus($idPas, $idCentral, $pdo);
            
            $arrayItens = [];
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                return $retorno;
            }else{
                $result = $dao->getMsgRetorno();                                
                
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
                                "cd_despesa" => $value['cd_despesa']
                            );
                    }else{
                        $arrayItens[$value['id_tipo_gasto_categoria']] = array(
                            "nm_tipo_gasto_categoria" => $value['nm_tipo_gasto_categoria'],
                            "nm_tipo_gasto" => $value['nm_tipo_gasto'],
                            "itens" => array(array(
                                "id_pta_item" => $value['id_pta_item'],                                
                                "qt_pta_item" => $value['qt_pta_item'],
                                "vl_pta_item" => $value['vl_pta_item'],
                                "nm_desc_material" => $value['nm_desc_material'],                                                                
                                "nm_unidade_medida" => $value['nm_unidade_medida'],
                                "nr_fonte" => $value['nr_fonte'],
                                "cd_despesa" => $value['cd_despesa']
                            ))                            
                        );
                    }                                        
                }                                
            }
            
            if(count($arrayItens) > 0){
                
                 //Pega os Ids do Tipo de Gasto Categoria
                $idsTipoGastoCategoria = implode(",", array_keys($arrayItens));
                $arrayMensagem = [];

                $itemValidacao = new PtaItemValidacao();
                $itemValidacao->setIdPas($idPas); 

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
                                    . '<div class="panel-title">'.$value['nm_tipo_gasto'].': '.$value['nm_tipo_gasto_categoria'].'</div>'
                                . '</div>';                    
                    
                    $retorno .= '<table class="table table-striped table-bordered tabela-itens-salvo" cellspacing="0" width="100%">'
                            . '<thead>'
                                . '<tr>'
                                    . '<th>Item</th>'
                                    . '<th>Fonte</th>'
                                    . '<th>Despesa</th>'
                                    . '<th style="white-space: nowrap; overflow: hidden;">Qtd - Valor Unit. - Total</th>'
                                    . '<th class="text-center">Ações</th>'
                                . '</tr>'
                            . '</thead>'
                            . '<tbody>';
                    
                    foreach ($value['itens'] as $v) {
                        $id = $v['id_pta_item'];
                        
                        $valorTotal += (float)($v['qt_pta_item']*$v['vl_pta_item']);
                        $retorno .= "<tr>"
                                    . "<td>".$v['nm_desc_material']." - ".$v['nm_unidade_medida']."</td>"
                                    . "<td>".$v['nr_fonte']."</td>"
                                    . "<td>".$v['cd_despesa']."</td>"
                                    . "<td style='white-space: nowrap; overflow: hidden;'>".Metodos::ConverteValorBr((float)$v['qt_pta_item'], 4)." - R$ ". Metodos::ConverteValorBr((float)$v['vl_pta_item'], 4)." - R$ ".Metodos::ConverteValorBr((float)($v['qt_pta_item']*$v['vl_pta_item']), 4)."</td>"
                                    . '<td style="text-align: center;">'                                                     
                                    . '<button type="button" class="btn btn-default btn-informacoes btn-xs"'
                                        . ' title="Informações"  '
                                        . 'value=' . $id . ' >
                                        <i class="fa fa-info fa-lg text-warning" aria-hidden="true"></i>
                                      </button> '                                    
                                    . '</td>'
                                    . "</td>"
                                . "</tr>";                                                                                                
                    }
                                                                                
                    $retorno .= "</tbody>";
                    $retorno .= "<tfoot>"
                                . "<tr>"
                                    . "<th colspan='3'>Total</th>"
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
                                                    $obj = $this->stTextoItem($aMsg['st_pta_item_validacao']); 
                                                    $retorno .= $aMsg['nm_pessoa']." às ".$aMsg['dh_pta_item_validacao']." enviou ".$obj->msgText. " ".$aMsg['ds_pta_item_validacao']."\n";                                                            
                                                }
                                            }
                    
                    
                        $retorno .= '</textarea>                                                                                                                                      
                                </div><br>
                                <div class="text-right">                                            
                                <button class="btn btn-primary btn-rounded btn-concordo-central" type="button" value="'.$key.'" tipo="'.$value['nm_tipo_gasto_categoria'].'" >
                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Concordo com os Itens e Preços
                                </button>
                                <button class="btn btn-primary btn-rounded btn-discordo-central" type="button" value="'.$key.'" tipo="'.$value['nm_tipo_gasto_categoria'].'" >
                                    <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Discordo com os Itens e Preços
                                </button>
                                </div>
                            </div>';
                    
                    $retorno .= "</div>";
                }
            }                                  
            $this->sucesso = true;
            $this->msgRetorno = $retorno;
            return;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;            
        }                               
    }
    
    
           
    public function retornaItensPorPasTGCStatus(int $idPas, string $status, $pdo = null){
        $this->sucesso = false;
        
        try {
            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                        
            $dao = new DaoPlaPtaItem();                    
            $dao->setIdTipoGastoCategoria($this->idTipoGastoCategoria);
            $dao->retornaPorPasTipoGastoCategoriaStatus($idPas, $status, $pdo);                 
            
            if(!$dao->Sucesso()){
                $this->msgRetorno = $dao->getMsgRetorno();
                $this->sucesso = false;                
            }else{                 
                $this->msgRetorno = $dao->getMsgRetorno();                                 
                $this->sucesso = true;                
            }                        
            return;
        } catch (Exception $exc) {            
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;             
            return;            
        }        
    }
    
    /**
     * Retorna os options para a Tela de Itens do PTA de acordo com o ID da Fonte passada.
     * Ex. Se o Id for da fonte 400, então só irá mostrar um Select com as Portarias.
     * @return string
     */
    public function retornaDivSelectOptionTelaItensPorFonte(){
        $retorno = "";                
        try{                                              
            //Verifica se algumas das fontes selecionados irá possuir algum Combo box
            //Hoje só utilizamos para Fonte de Convenio ou Fonte de Portaria
            if($this->idFonte == FONTE_200 || $this->idFonte == FONTE_400){
                
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                //$conta = new DaoFinConta();  
                
                if($this->idFonte == FONTE_200){
                    $convenio = new Convenio();
                    $convenio->setIdFonte($this->idFonte);
                    $convenio->retornaConvenioPorFonte($pdo);
                    if(!$convenio->Sucesso()){
                        //echo $convenio->getMsgRetorno();
                        return $retorno;
                    }else{
                        $result = $convenio->getMsgRetorno();
                        $retorno .= '<div class="panel-body">'
                                            . '<label for="convenio">'
                                                . 'Convênio:'
                                            . '</label>'
                                            . '<div class="input-group">'
                                                . '<span class="input-group-addon">'
                                                    . '<p class="fa fa-list inputPFa"></p>'
                                                . '</span>'
                                                . '<select id="convenio" class="form-control">';                                                                                                                                                                     
                                    
                        
                        //Armazena as informações na variável $retorno com os dados.
                        $retorno .= "<option value='0'>Selecione um Convênio</option>";
                        foreach ($result as $v) {                
                            $retorno .= "<option value='".$v['id_convenio']."'>".$v['nm_convenio']."</option>";
                        }                        
                        
                        $retorno .= "</select>
                                </div>                            
                        </div>";
                    }
                    return $retorno;                         
                }
                
                if($this->idFonte == FONTE_400){
                    $portaria = new Portaria();
                                                        
                    $portaria->retornaPortarias($pdo);
                    if(!$portaria->Sucesso()){
                        //echo $portaria->getMsgRetorno();
                        return $retorno;
                    }else{
                        $result = $portaria->getMsgRetorno();
                        $retorno .= '<div class="panel-body">'
                                            . '<label for="portaria">'
                                                . 'Portaria:'
                                            . '</label>'
                                            . '<div class="input-group">'
                                                . '<span class="input-group-addon">'
                                                    . '<p class="fa fa-list inputPFa"></p>'
                                                . '</span>'
                                                . '<select id="portaria" class="form-control">';                                                                                                                                                                     
                                                            
                        //Armazena as informações na variável $retorno com os dados.
                        $retorno .= "<option value='0'>Selecione uma Portaria</option>";
                        foreach ($result as $v) {                  
                            $retorno .= "<option value='".$v['id_portaria']."'>".$v['nm_rede_tematica']." - ".$v['nm_portaria']."</option>";
                        }                        
                        
                        $retorno .= "</select>
                                </div>                            
                        </div>";
                    }
                    return $retorno;                                                                                
                }
            }                        
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function retornaLimiteValores($pdo = null){
        $retorno = "Não encontrou Registros";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                   
            
            $pta = new PtaTitulo();
            $pta->setIdPtaTitulo($this->idPtaTitulo);                        
            $pta->carregaDados($pdo);
                      
            $dao = new DaoPlaPtaItem();
            
            $dao->setIdPtaTitulo($this->idPtaTitulo);            
            
            $dataInicio = new DateTime($pta->getDtInicio());            
            
            $resultItensFonte = array();
            $resultValoresLiberado = array();
            
            //Pega os Valores da Somatória dos Itens dos PTA's de uma lotação e Ano
            $dao->retornaValoresPorLotacaoAnoProgTrab((int)$pta->getIdLotacao(), $dataInicio->format("Y"), $pta->getIdProgramaTrabalho(), $pdo);
            if($dao->Sucesso()){       
                $resultItensFonte = $dao->getMsgRetorno();
            }           
            
            //Pega os Valores que foram liberados para a Unidade e Ano
            $liber = new LiberacaoFonteUnidade();            
            $liber->setIdLotacao((int)$pta->getIdLotacao());
            $liber->setIdProgramaTrabalho($pta->getIdProgramaTrabalho());
            
            $liber->retornaValoresAnoLotacaoProgTrab((int)$dataInicio->format("Y"), $pdo);
            if($liber->Sucesso()){
                $resultValoresLiberado = $liber->getMsgRetorno();
            }                                                   
            
            $arrayValores = array();
            
            foreach ($resultItensFonte as $value) {                
                $arrayValores[$value['id_fonte'].":".$value['id_despesa_elemento']] = array(
                        "id_fonte" => $value['id_fonte'],
                        "nr_fonte" => $value['nr_fonte'],
                        "id_despesa_elemento" => $value['id_despesa_elemento'],
                        "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                        "valor_itens" => $value['valor'],
                        "valor_liberado" => 0
                        );                
            }
            
            foreach ($resultValoresLiberado as $value) {
                if(array_key_exists($value['id_fonte'].":".$value['id_despesa_elemento'], $arrayValores)){
                    $arrayValores[$value['id_fonte'].":".$value['id_despesa_elemento']]['valor_liberado'] = $value['vl_total'];
                }else{
                    $arrayValores[$value['id_fonte'].":".$value['id_despesa_elemento']] = array(
                        "id_fonte" => $value['id_fonte'],
                        "nr_fonte" => $value['nr_fonte'],
                        "id_despesa_elemento" => $value['id_despesa_elemento'],
                        "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                        "valor_itens" => 0,
                        "valor_liberado" => $value['vl_total']
                        );    
                }
            }
            
            
            if(count($arrayValores) > 0){
                $retorno = '<div class="panel panel-default">'
                                . '<div class="panel-heading" style="margin-bottom: 5px;">'
                                    . '<div class="panel-title">'.$pta->getProgramaTrabalho()." ".$pta->getDsProgramaTrabalho().'</div>'
                                . '</div>';                    
                    
                $retorno .= '<table class="table table-striped table-bordered tabela-itens-salvo" cellspacing="0" width="100%">'
                        . '<thead>'
                            . '<tr>'
                                . '<th class="text-center">Fonte</th>'
                                . '<th class="text-center">Despesa</th>'
                                . '<th class="text-right">Valor Liberado</th>'
                                . '<th class="text-right">Valor Dos Itens</th>'
                                . '<th class="text-right">Saldo</th>'                                
                            . '</tr>'
                        . '</thead>'
                        . '<tbody>';
                
                $valorTotalLiberado = 0;
                $diferenca = 0;
                $valorTotalItens = 0;
                $valorTotal = 0;
                foreach ($arrayValores as $v) {                 
                    $diferenca = ($v['valor_liberado']-$v['valor_itens']);
                    $valorTotalLiberado += $v['valor_liberado'];
                    $valorTotalItens += $v['valor_itens'];         
                    $textoColor = 'text-default';
                    if($diferenca < 0){
                        $textoColor = 'text-danger';
                    }
                    $retorno .= "<tr>"
                                . "<td class='text-center'>".$v['nr_fonte']."</td>"
                                . "<td class='text-center'>".$v['cd_despesa_elemento']."</td>"
                                . "<td class='text-right'>R$ ". Metodos::ConverteValorBr((float)$v['valor_liberado'], 4)."</td>"
                                . "<td class='text-right'>R$ ". Metodos::ConverteValorBr((float)$v['valor_itens'], 4)."</td>"
                                . "<td class='text-right'><span class='".$textoColor."'> R$ ". Metodos::ConverteValorBr((float)$diferenca, 4)."</span></td>"                                
                            . "</tr>";                                                                                                
                }

                
                $valorTotal = ($valorTotalLiberado-$valorTotalItens);
                $retorno .= "</tbody>";
                $retorno .= "<tfoot>"
                            . "<tr>"
                                ."<th class='text-center' colspan=2>Total</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalLiberado, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalItens, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                                
                            . "</tr>"
                        . "</tfoot>";
                $retorno .= "</table>";

                $retorno .= "</div>";
                                                
            }                                                                                                                    
                        
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }  
    
    
    /**
     *      
     * @param int $ano
     * @param int $idCentral
     * @param PDO $pdo
     * @return string
     */
    public function retornaTbDosItensPorCentralAno(int $ano, int $idCentral, $pdo = null){
        $retorno = "";
        $this->sucesso = false;
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
            
                                    
            $dao = new DaoPlaPtaItem();
            $dao->setStPtaItem($this->stItemValidado());          
            $dao->retornaPorCentralAnoValidado($ano, $idCentral, $pdo);
            
            $arrayItens = [];
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                return $retorno;
            }else{
                $result = $dao->getMsgRetorno();                                
//                echo "<pre>";
//                print_r($result);
//                echo "</pre>";
//                return;
                
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
                                "cd_despesa" => $value['cd_despesa']
                            );
                    }else{
                        $arrayItens[$value['id_tipo_gasto_categoria']] = array(
                            "nm_tipo_gasto_categoria" => $value['nm_tipo_gasto_categoria'],
                            "nm_tipo_gasto" => $value['nm_tipo_gasto'],
                            "itens" => array(array(
                                "id_pta_item" => $value['id_pta_item'],                                
                                "qt_pta_item" => $value['qt_pta_item'],
                                "vl_pta_item" => $value['vl_pta_item'],
                                "nm_desc_material" => $value['nm_desc_material'],                                                                
                                "nm_unidade_medida" => $value['nm_unidade_medida'],
                                "nr_fonte" => $value['nr_fonte'],
                                "cd_despesa" => $value['cd_despesa']
                            ))                            
                        );
                    }                                        
                }                                
            }
            
            if(count($arrayItens) > 0){
                
                
                foreach ($arrayItens as $key => $value) {  
                    
                   
                                                            
                    $valorTotal = 0;
                    $retorno .= '<div class="panel panel-default">'
                                . '<div class="panel-heading" style="margin-bottom: 5px;">'
                                    . '<div class="panel-title">'.$value['nm_tipo_gasto'].': '.$value['nm_tipo_gasto_categoria'].'</div>'
                                . '</div>';                    
                    
                    $retorno .= '<table class="table table-striped table-bordered tabela-itens-salvo" cellspacing="0" width="100%">'
                            . '<thead>'
                                . '<tr>'
                                    . '<th>Item</th>'
                                    . '<th>Fonte</th>'
                                    . '<th>Despesa</th>'
                                    . '<th style="white-space: nowrap; overflow: hidden;">Qtd - Valor Unit. - Total</th>'
                                    . '<th class="text-center">Ações</th>'
                                . '</tr>'
                            . '</thead>'
                            . '<tbody>';
                    
                    foreach ($value['itens'] as $v) {
                        $id = $v['id_pta_item'];
                        
                        $valorTotal += (float)($v['qt_pta_item']*$v['vl_pta_item']);
                        $retorno .= "<tr>"
                                    . "<td>".$v['nm_desc_material']." - ".$v['nm_unidade_medida']."</td>"
                                    . "<td>".$v['nr_fonte']."</td>"
                                    . "<td>".$v['cd_despesa']."</td>"
                                    . "<td style='white-space: nowrap; overflow: hidden;'>".Metodos::ConverteValorBr((float)$v['qt_pta_item'], 4)." - R$ ". Metodos::ConverteValorBr((float)$v['vl_pta_item'], 4)." - R$ ".Metodos::ConverteValorBr((float)($v['qt_pta_item']*$v['vl_pta_item']), 4)."</td>"
                                    . '<td style="text-align: center;">'                                                     
                                    . '<button type="button" class="btn btn-default btn-informacoes btn-xs"'
                                        . ' title="Informações"  '
                                        . 'value=' . $id . ' >
                                        <i class="fa fa-info fa-lg text-warning" aria-hidden="true"></i>
                                      </button> '                                    
                                    . '</td>'
                                    . "</td>"
                                . "</tr>";                                                                                                
                    }
                                                                                
                    $retorno .= "</tbody>";
                    $retorno .= "<tfoot>"
                                . "<tr>"
                                    . "<th colspan='3'>Total</th>"
                                    . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"
                                    . "<th></th>"
                                . "</tr>"
                            . "</tfoot>";
                    $retorno .= "</table>";
                    
                    
                    
                    $retorno .= "</div>";
                }
            }                                  
            $this->sucesso = true;
            $this->msgRetorno = $retorno;
            return;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;            
        }                               
    }
    
    
    public function retornaValoresProjAtiPPAAnoLot(int $ano, int $idLotacao, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();
            $pas = new Pas();
            $dao->setStPtaItem($this->stItemValidado());
            $statusPas = Metodos::implodeComAspas(array($pas->stPasPrimAutorizadoPlanejamento(), $pas->stPasLiberadoPlanejamento()));
            $dao->retornaValorProjAtiPPAPorAnoLot($ano, $statusPas, $idLotacao, $pdo);
                   
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }  
    
    public function retornaValoresAcaoAnoLot(int $ano, int $idLotacao, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();
            $pas = new Pas();
            $dao->setStPtaItem($this->stItemValidado());
            $statusPas = Metodos::implodeComAspas(array($pas->stPasPrimAutorizadoPlanejamento(), $pas->stPasLiberadoPlanejamento()));
            $dao->retornaValorAcaoPorAnoLot($ano, $statusPas, $idLotacao, $pdo);                               
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }  
    
    
    public function retornaValoresCatEconomicaAnoLotTG(int $ano, int $idLotacao, int $idTipoGasto, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();
            $pas = new Pas();
            $dao->setStPtaItem($this->stItemValidado());
            $statusPas = Metodos::implodeComAspas(array($pas->stPasPrimAutorizadoPlanejamento(), $pas->stPasLiberadoPlanejamento()));
            $dao->retornaValorCatEconomicaPorAnoLotTG($ano, $statusPas, $idLotacao, $idTipoGasto, $pdo);                               
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }  
    
    
    public function retornaAcoesDetValPtaTitulo(int $idPtatitulo, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();                                    
            $dao->retornaAcaoDetValPorPtaTitulo($idPtatitulo, $pdo);                               
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }
    
    
    public function retornaValFontesPorPtaTitulo(int $idPtatitulo, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();                                    
            $dao->retornaValFontePorPtaTitulo($idPtatitulo, $pdo);                               
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }
    
    public function retornaValCatEconomicaPorPtaTitulo(int $idPtatitulo, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();                                    
            $dao->retornaValCatEconomicaPorPtaTitulo($idPtatitulo, $pdo);                               
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }
    
    public function retornaTGCValPtaTitulo(int $idPtatitulo, $pdo = null){
        $this->sucesso = false;
        
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }                                                            
                        
            $dao = new DaoPlaPtaItem();                                    
            $dao->retornaTGCValPorPtaTitulo($idPtatitulo, $pdo);                               
            
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();                                                                
            }                             
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();                        
        }                               
    }
    
    
    public function retornaValoresLimitesPelaPAS(int $idPas, $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                   
            $pas = new Pas();
            $pas->carregaDados($idPas, $pdo);
            
            
            $dataInicio = new DateTime($pas->getDtInicio());            
            
            $resultItensFonte = array();
            $resultValoresLiberado = array();
            
            $dao = new DaoPlaPtaItem();
                        
            //Pega os Valores da Somatória dos Itens dos PTA's de uma lotação e Ano
            $dao->retornaValoresPTAPorPAS($idPas, $pdo);
            if($dao->Sucesso()){       
                $resultItensFonte = $dao->getMsgRetorno();
            }                                
                        
            //Pega os Valores que foram liberados para a Unidade e Ano
            $liber = new LiberacaoFonteUnidade();            
            $liber->setIdLotacao((int)$pas->getIdLotacao());                        
            
            $liber->retornaValoresAnoLotacao((int)$dataInicio->format("Y"), $pdo);
            if($liber->Sucesso()){
                $resultValoresLiberado = $liber->getMsgRetorno();
            }                                                   
            
                      
            $arrayValores = array();
            
            foreach ($resultItensFonte as $value) {                
                $arrayValores[$value['id_fonte'].":".$value['id_despesa_elemento']] = array(
                        "id_fonte" => $value['id_fonte'],
                        "nr_fonte" => $value['nr_fonte'],
                        "id_despesa_elemento" => $value['id_despesa_elemento'],
                        "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                        "valor_itens" => $value['valor'],
                        "valor_liberado" => 0
                        );                
            }
            
            foreach ($resultValoresLiberado as $value) {
                if(array_key_exists($value['id_fonte'].":".$value['id_despesa_elemento'], $arrayValores)){
                    $arrayValores[$value['id_fonte'].":".$value['id_despesa_elemento']]['valor_liberado'] = $value['vl_total'];
                }else{
                    $arrayValores[$value['id_fonte'].":".$value['id_despesa_elemento']] = array(
                        "id_fonte" => $value['id_fonte'],
                        "nr_fonte" => $value['nr_fonte'],
                        "id_despesa_elemento" => $value['id_despesa_elemento'],
                        "cd_despesa_elemento" => $value['cd_despesa_elemento'],
                        "valor_itens" => 0,
                        "valor_liberado" => $value['vl_total']
                        );    
                }
            }
            
            
            if(count($arrayValores) > 0){
                $retorno = '<div class="panel panel-default">'
                                . '<div class="panel-heading" style="margin-bottom: 5px;">'
                                    . '<div class="panel-title">Diferença dos Valores dos Liberados pelo Planejamneto e PTAs</div>'
                                . '</div>';                    
                    
                $retorno .= '<table class="table table-striped table-bordered tabela-itens-salvo" cellspacing="0" width="100%">'
                        . '<thead>'
                            . '<tr>'
                                . '<th class="text-center">Fonte</th>'
                                . '<th class="text-center">Despesa</th>'
                                . '<th class="text-right">Valor Liberado</th>'
                                . '<th class="text-right">Valor Dos Itens</th>'
                                . '<th class="text-right">Saldo</th>'                                
                            . '</tr>'
                        . '</thead>'
                        . '<tbody>';
                
                $valorTotalLiberado = 0;
                $diferenca = 0;
                $valorTotalItens = 0;
                $valorTotal = 0;
                foreach ($arrayValores as $v) {                 
                    $diferenca = ($v['valor_liberado']-$v['valor_itens']);
                    $valorTotalLiberado += $v['valor_liberado'];
                    $valorTotalItens += $v['valor_itens'];         
                    $textoColor = 'text-default';
                    if($diferenca < 0){
                        $textoColor = 'text-danger';
                    }
                    $retorno .= "<tr>"
                                . "<td class='text-center'>".$v['nr_fonte']."</td>"
                                . "<td class='text-center'>".$v['cd_despesa_elemento']."</td>"
                                . "<td class='text-right'>R$ ". Metodos::ConverteValorBr((float)$v['valor_liberado'], 4)."</td>"
                                . "<td class='text-right'>R$ ". Metodos::ConverteValorBr((float)$v['valor_itens'], 4)."</td>"
                                . "<td class='text-right'><span class='".$textoColor."'> R$ ". Metodos::ConverteValorBr((float)$diferenca, 4)."</span></td>"                                
                            . "</tr>";                                                                                                
                }

                
                $valorTotal = ($valorTotalLiberado-$valorTotalItens);
                $retorno .= "</tbody>";
                $retorno .= "<tfoot>"
                            . "<tr>"
                                ."<th class='text-center' colspan=2>Total</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalLiberado, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalItens, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                                
                            . "</tr>"
                        . "</tfoot>";
                $retorno .= "</table>";

                $retorno .= "</div>";
                                                
            }                                                                                                                    
                        
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    } 
    
    
    private function retornaJSONAlteracaoDaPAS(array $antigo, array $novo, string $tipo){
               
        $diff = array_diff_assoc($novo, $antigo);       
        $arrayDiff = array();

        foreach ($diff as $key => $value) {
            switch ($key) {
                case "id_material":                    
                    $arrayDiff["Item"] = array(
                                            "antigo" => array_key_exists("id_material", $antigo) ? $antigo["nm_desc_material"] : ""
                                            , "novo" => $novo["nm_desc_material"]);
                    break;                    
                case "ds_pta_item":
                    if($tipo == "U"){
                        $arrayDiff["Descrição do Item"] = array(
                                                "antigo" => array_key_exists($key, $antigo) ? $antigo[$key] : ""
                                                , "novo" => $novo[$key]);
                    }
                    break;
                case "id_pta_acao_det":                    
                    $arrayDiff["Detalhamento da Ação"] = array(
                                            "antigo" => array_key_exists("id_pta_acao_det", $antigo) ? $antigo["nm_pta_acao_det"] : ""
                                            , "novo" => $novo["nm_pta_acao_det"]);
                    break;                    
                case "id_tipo_gasto_categoria":
                    $arrayDiff["Tipo de Gasto Categoria"] = array(
                                            "antigo" => array_key_exists("id_tipo_gasto_categoria", $antigo) ? $antigo["nm_tipo_gasto_categoria"] : ""
                                            , "novo" => $novo["nm_tipo_gasto_categoria"]);
                    break;
                case "id_unidade_medida":
                    if($tipo == "U"){
                        $arrayDiff["Unidade de Medida"] = array(
                                                "antigo" => array_key_exists("id_unidade_medida", $antigo) ? $antigo["nm_unidade_medida"] : ""
                                                , "novo" => $novo["nm_unidade_medida"]);
                    }
                    break;
                case "id_fonte":                    
                    $arrayDiff["Fonte"] = array(
                                            "antigo" => array_key_exists("id_fonte", $antigo) ?  $antigo["nr_fonte"] : ""
                                            , "novo" => $novo["nr_fonte"]);
                    break;
                case "tp_fonte":
                    $arrayDiff["Tipo da Fonte"] = array(
                                            "antigo" => array_key_exists("tp_fonte", $antigo) ? Metodos::retornaTpFonteTexto($antigo['tp_fonte']) : ""
                                            , "novo" => Metodos::retornaTpFonteTexto($novo["tp_fonte"]) );
                    break;
                case "qt_pta_item":
                    $arrayDiff["Quantidade do Item"] = array(
                                            "antigo" => array_key_exists("qt_pta_item", $antigo) ? $antigo["qt_pta_item"] : ""
                                            , "novo" => $novo["qt_pta_item"]);
                    break;
                case "vl_pta_item":
                    $arrayDiff["Valor do Item"] = array(
                                            "antigo" => array_key_exists("vl_pta_item", $antigo) ? Metodos::ConverteValorBr($antigo["vl_pta_item"], 4) : ""
                                            , "novo" => Metodos::ConverteValorBr($novo["vl_pta_item"], 4) );
                    break;
                case "id_portaria":
                    $arrayDiff["Portaria"] = array(
                                            "antigo" => array_key_exists("id_portaria", $antigo) ? $antigo['nm_rede_tematica']." ".$antigo["nm_portaria"] : ""
                                            , "novo" => $novo['nm_rede_tematica']." ".$novo["nm_portaria"]);
                    break;
                case "id_convenio":
                    $arrayDiff["Convênio"] = array(
                                        "antigo" => array_key_exists("id_convenio", $antigo) ? $antigo["nm_convenio"] : ""
                                        , "novo" => $novo["nm_convenio"]);
                    break;

                default:
                    break;
            }
        }
        if(count($arrayDiff) > 0){
            return json_encode($arrayDiff, JSON_UNESCAPED_UNICODE);
        }else{
            return "";
        }        
        
    }
    
                                       
}

?>
