<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaMaterial.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Despesa.class.php";

class Itens{
    
    
    private $idItem = null;  
    private $cdItem = null;  
    private $nmItem = null;
    private $cdDescMaterial = null;    
    private $nmDescMaterial = null;    
    private $cdGrupo = null;
    private $nmGrupo = null;
    private $cdSubGrupo = null;
    private $nmSubGrupo = null;
    private $tipoMaterial = null;
    private $cdElementoDespesa = null;
    private $idDespesa = null;   
    private $sucesso = null;
    private $msgRetorno = null;
    private $msgTipo = null;
       
    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function getMsgTipo() {
        return $this->msgTipo;
    }    
           
    function getIdItem() {
        return $this->idItem;
    }

    function getCdItem() {
        return $this->cdItem;
    }

    function getNmItem() {
        return $this->nmItem;
    }

    function getCdDescMaterial() {
        return $this->cdDescMaterial;
    }

    function getNmDescMaterial() {
        return $this->nmDescMaterial;
    }

    function getCdGrupo() {
        return $this->cdGrupo;
    }

    function getNmGrupo() {
        return $this->nmGrupo;
    }

    function getCdSubGrupo() {
        return $this->cdSubGrupo;
    }

    function getNmSubGrupo() {
        return $this->nmSubGrupo;
    }

    function getTipoMaterial() {
        return $this->tipoMaterial;
    }

    function getCdElementoDespesa() {
        return $this->cdElementoDespesa;
    }

    function getIdDespesa() {
        return $this->idDespesa;
    }
    
    /**
     * @param int $idItem
     * @var serial id_material
     * @return $this
     */       
    function setIdItem($idItem) {
        $this->idItem = $idItem;
        return $this;
    }   
    /**
     * 
     * @param int $cdItem
     * @var smallint cd_material
     * @return $this
     */
    function setCdItem($cdItem) {
        $this->cdItem = $cdItem;
        return $this;
    }        
    /**
     * 
     * @param string $nmItem
     * @var varchar nm_material
     * @return $this
     */
    function setNmItem($nmItem) {
        $this->nmItem = $nmItem;
        return $this;
    }    
    /**
     * 
     * @param integer $codigoDescMaterial
     * @var smallint cd_desc_material
     * @return $this
     */
    function setCdDescMaterial($cdDescMaterial) {
        $this->cdDescMaterial = $cdDescMaterial;
        return $this;
    }
    /**
     * 
     * @param string $nomeDescMaterial
     * @var varchar nm_desc_material
     * @return $this
     */
    function setNmDescMaterial($nmDescMaterial) {
        $this->nmDescMaterial = $nmDescMaterial;
        return $this;
    }
    /**
     * 
     * @param intenger $cdGrupo
     * @var smallint cd_grupo
     * @return $this
     */
    function setCdGrupo($cdGrupo) {
        $this->cdGrupo = $cdGrupo;
        return $this;
    }
    /**
     * 
     * @param string $nmGrupo
     * @var varchar nm_grupo
     * @return $this
     */
    function setNmGrupo($nmGrupo) {
        $this->nmGrupo = $nmGrupo;
        return $this;
    }
    /**
     * 
     * @param integer $cdSubGrupo
     * @var smallint cd_sub_grupo
     * @return $this
     */
    function setCdSubGrupo($cdSubGrupo) {
        $this->cdSubGrupo = $cdSubGrupo;
        return $this;
    }
    /**
     * 
     * @param string $nmSubGrupo
     * @var varchar nm_sub_grupo
     * @return $this
     */
    function setNmSubGrupo($nmSubGrupo) {
        $this->nmSubGrupo = $nmSubGrupo;
        return $this;
    }
    /**
     * 
     * @param string $tipoMaterial
     * @var char tp_material
     * @return $this
     */
    function setTipoMaterial($tipoMaterial) {
        $this->tipoMaterial = $tipoMaterial;
        return $this;
    }
    /**
     * 
     * @param integer $cdElementoDespesa
     * @var smallint cd_elemento_despesa
     * @return $this
     */
    function setCdElementoDespesa($cdElementoDespesa) {
        $this->cdElementoDespesa = $cdElementoDespesa;
        return $this;
    }
    /**
     * 
     * @param intenger $idDespesa
     * @var smallint id_despesa
     * @return $this
     */
    function setIdDespesa($idDespesa) {
        $this->idDespesa = $idDespesa;
        return $this;
    }

                          
    public function Sucesso(){
        return $this->sucesso;
    }
    
    
    /**
     * Função responsável por receber as informações do Item e Salvar esse Item na Tabela pla_material
     * Caso o Código da Descrição do Material já existe no Banco, então ele somente resgata esses Dados.
     * @param type $pdo
     * @return Object/Boolean
     */
    public function salva($pdo){                
        
        try {
                                                                         
            //Verifica se os campos foram preenchidos
            if((int) $this->cdDescMaterial == 0){
                $this->sucesso = false;
                $this->msgTipo = "Erro";
                $this->msgRetorno = "Não foi Possível encontrar a Descrição do Código do Material. ". STR_ERROR;
                $pdo->rollBack();
                return;
            }
            
            //Busca se o Item já existe no Banco de Dados
            //Caso Exista basta Setar os Campos do Material
            $dao = new DaoPlaMaterial();
            $dao->setCdDescMaterial($this->cdDescMaterial);
          
            $dao->retornaPorCodigoDescMaterial($pdo);
                       
            //Verifica se deu certo achar o Material da Base de Dados
            if($dao->Sucesso()){
                //Depois de Verificado o Sucesso, Precisa Verificar se o Material está ativo para uso
                $result = $dao->getMsgRetorno();
                if($result['st_ativo'] != 1){
                    $this->sucesso = false;
                    $this->msgTipo = "Erro";
                    $this->msgRetorno = "Material Desativado Para Uso de Novos Cadastro.";
                    $pdo->rollBack();
                    return;
                }
                //Seta os Dados Do Item
                $this->idItem = $result['id_material'];
                $this->cdItem = $result['cd_material'];
                $this->nmItem = $result['nm_material'];
                $this->cdDescMaterial = $result['cd_desc_material'];
                $this->nmDescMaterial = $result['nm_desc_material'];
                $this->cdGrupo = $result['cd_grupo'];
                $this->nmGrupo = $result['nm_grupo'];
                $this->cdSubGrupo = $result['cd_sub_grupo'];
                $this->nmSubGrupo = $result['nm_sub_grupo'];
                $this->cdElementoDespesa = $result['cd_elemento_despesa'];
                $this->tipoMaterial = $result['tp_material'];
                $this->idDespesa = $result['id_despesa'];         
                $this->sucesso = true;
                return;               
                
            //Material Não Existe no Banco de Dados
            //Então terá q ser Cadastrado 
            }else{
                                
                $this->carregaPorCodigoDescricaoWS();                
                if($this->cdDescMaterial == 0){                 
                    $this->sucesso = false;
                    $this->msgTipo = "Erro";
                    $this->msgRetorno = "Não foi Possível encontrar a Descrição do Código do Material. ". STR_ERROR;
                    $pdo->rollBack();
                    return;
                }
                                
                //Retira os Dois ultimos Caracteres do elemento que vem do GRP, pois não utilizamos
                $cdDespesa = substr($this->cdElementoDespesa, 0, -2);    
                                                
                //Primeiro faz a Busca do Id do Elemento de Despesa
                $daoDespesa = new Despesa();
                $daoDespesa->carregaPorCodigoDespesa($cdDespesa, $pdo);
                if(!$daoDespesa->Sucesso()){
                    $this->sucesso = false;
                    $this->msgTipo = "Erro";
                    $this->msgRetorno = "Elemento de Despesa Não Cadastrado. ". STR_ERROR;
                    $pdo->rollBack();
                    return;
                }                
                $this->idDespesa = $daoDespesa->getIdDespesa();
                
                //Carrega os Dados no Dao
                $dao->setCdMaterial($this->cdItem);
                $dao->setNmMaterial($this->nmItem);
                $dao->setNmDescMaterial($this->nmDescMaterial);
                $dao->setCdGrupo($this->cdGrupo);
                $dao->setNmGrupo($this->nmGrupo);
                $dao->setCdSubGrupo($this->cdSubGrupo);
                $dao->setNmSubGrupo($this->nmSubGrupo);
                $dao->setTpMaterial($this->tipoMaterial);
                $dao->setCdElementoDespesa($this->cdElementoDespesa);
                $dao->setIdDespesa($this->idDespesa);
                
                //Salva o Material no Banco
                $dao->insert($pdo);
                if(!$dao->Sucesso()){
                    $this->sucesso = false;
                    $this->msgTipo = "Erro";
                    //$this->msgRetorno = $dao->getMsgRetorno();                     
                    $this->msgRetorno = STR_ERROR;
                    $pdo->rollBack();
                    return;
                }
                //Pega o ID Inserido
                $dao->setIdMaterial($pdo->lastInsertId("pla_material_id_material_seq"));
                $this->idItem = $dao->getIdMaterial();                
                if (Log::SalvaLogI('pla_material', $dao->getIdMaterial(), $pdo)) {
                    $this->sucesso = true;
                }else{
                    $this->sucesso = false;
                    $this->msgTipo = "Erro";
                    $this->msgRetorno = STR_ERROR;                    
                    $pdo->rollBack();
                    return;                    
                }  
                return;
            }                                               
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgTipo = "Erro";
            //$this->msgRetorno = $exc->getMessage();                     
            $this->msgRetorno = STR_ERROR;
            $pdo->rollBack();
            return;       
        }
    } 

    /**
    * Retorna as Trs para a tabela da busca de itens de acordo com o nome do Item para ser usada na tela do Itens do PTA
    * @param string $nome
    * @return string
    */
    public function retornaTrPorNomeDoItem(){
        $retorno = "";
        try{

            if($this->nmDescMaterial == "" || $this->nmDescMaterial == " "
            || strlen($this->nmDescMaterial) < 2 ){
                return $retorno;
            }
                       
            $itens = $this->pesquisaDescricaoMaterial($this->nmDescMaterial);
            if($itens){
                foreach ($itens as  $value) {
                    $retorno .= '<tr class="selecionaItem" item="'.$value->codigoDescMaterial.'" style="cursor:pointer;">
                        <td>'.utf8_encode($value->descricaoMaterial).'</td>
                        <td>'.utf8_encode($value->nomeMaterial).'</td>
                        <td>'.utf8_encode($value->nomeGrupo).'</td>
                        <td>'.utf8_encode($value->nomeSubGrupo).'</td>
                        <td>'.$value->elementoDespesa.'</td>
                        <td>'.$value->tipoMaterial.'</td>
                        </tr>';
                }
            }
            return $retorno;

        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    /**
    * Retorna as Trs para a tabela da busca de itens de acordo com o nome do Item para ser usada na tela do Itens do PTA
    * @param string $nome
    * @return string
    */
    public function retornaTrPorCodigoDescricao(){
        $retorno = "";
        try{
            if($this->cdDescMaterial == "" || $this->cdDescMaterial == " "
                    || $this->cdDescMaterial == 0){
                return $retorno;
            }            
                $value = $this->pesquisaCodigoDescMaterial($this->cdDescMaterial);    
                if($value){
                    $retorno .= '<tr class="selecionaItem" item="'.$value->codigoDescMaterial.'" style="cursor:pointer;">
                        <td>'.utf8_encode($value->descricaoMaterial).'</td>
                        <td>'.utf8_encode($value->nomeMaterial).'</td>
                        <td>'.utf8_encode($value->nomeGrupo).'</td>
                        <td>'.utf8_encode($value->nomeSubGrupo).'</td>
                        <td>'.$value->elementoDespesa.'</td>
                        <td>'.$value->tipoMaterial.'</td>
                        </tr>';
                }
            return $retorno;

        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    /**
     * Carrega as Informações do Material de Acordo com o Código da Descrição do Material e Armazena no Objeto
     * @return string
     */
    public function carregaPorCodigoDescricaoWS(){       
        try{
            if($this->cdDescMaterial == "" || $this->cdDescMaterial == " "
                    || $this->cdDescMaterial == 0){
                $this->cdDescMaterial = 0;
            }
            $value = $this->pesquisaCodigoDescMaterial($this->cdDescMaterial);    
            if($value){                
                $this->cdGrupo = $value->codigoGrupo;
                $this->nmGrupo = $value->nomeGrupo;
                $this->cdSubGrupo = $value->codigoSubGrupo;
                $this->nmSubGrupo = $value->nomeSubGrupo;
                $this->cdItem = $value->codigoMaterial;
                $this->nmItem = $value->nomeMaterial;
                $this->cdDescMaterial = $value->codigoDescMaterial;
                $this->nmDescMaterial = $value->descricaoMaterial;
                $this->tipoMaterial = $value->tipoMaterial;
                $this->cdElementoDespesa = $value->elementoDespesa;                               
            }else{
                $this->cdDescMaterial = 0;            
            }
        } catch (Exception $ex) {
            $this->cdDescMaterial = 0;
        }
    }
              
    private function pesquisa(string $metodo, array $array){       
        try{        
            $client = new SoapClient("http://10.1.2.69:9081/grpServiceHttpRouter/services/GrpService/wsdl/GrpService.wsdl");   
            $itens = $client->__soapCall($metodo, $array);             
        
        } catch (SoapFault $fault) {        
            //print_r("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})");
            echo "Erro ao se Comunicar com o Servidor do GRP";
        }
                                
        $get = $metodo.'Return';  
        if(isset($itens->$get->CatalagoMaterial) 
                && count($itens->$get->CatalagoMaterial) > 0){                            
            return $itens->$get->CatalagoMaterial;
        }else{            
            return false;
        }               
        
    }
    
    
    //CÓDIGO DO GRUPO
    private function pesquisaCodigoGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoGrupo', array(array("codigoGrupo" => $token)));
    }

    //NOME DO GRUPO
    private function pesquisaNomeGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByNomeGrupo', array(array("nomeGrupo" => $token)));
    }

    //CÓDIGO DO SUB-GRUPO
    private function pesquisaCodigoSubGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoSubGrupo', array(array('codigoSubGrupo' => $token)));
    }

    //NOME DO SUB-GRUPO
    private function pesquisaNomeSubGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByNomeSubGrupo', array(array('nomeSubGrupo' => $token)));
    }

    //CÓDIGO DO MATERIAL
    private function pesquisaCodigoMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoMaterial', array(array('codigoMaterial' => $token)));
    }

    //NOME DO MATERIAL
    private function pesquisaNomeMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByNomeMaterial', array(array('nomeMaterial' => $token)));
    }

    //CÓDIGO DA DESCRIÇÃO DO MATERIAL
    private function pesquisaCodigoDescMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoDescMaterial', array(array('codigoDescMaterial' => $token)));
    }

    //DESCRIÇÃO DO MATERIAL
    private function pesquisaDescricaoMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByDescricaoMaterial', array(array('descricaoMaterial' => $token)));
    }

    //TIPO DE MATERIAL
    private function pesquisaTipoMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByTipoMaterial', array(array('tipoMaterial' => $token)));
    }

    //ELEMENTO DESPESA
    private function pesquisaElementoDespesa($token) {
        return $this->pesquisa('getCatalagoMaterialByElementoDespesa', array(array('elementoDespesa' => $token)));
    }
    
    
    public function retornaTrPesquisaDescricaoItem(){
        $retorno = "";
                
        try{

            if($this->nmDescMaterial == "" || $this->nmDescMaterial == " "
            || strlen($this->nmDescMaterial) < 2 ){
                return $retorno;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
                       
            $dao = new DaoPlaMaterial();
            $dao->setNmDescMaterial($this->nmDescMaterial);
            $dao->pesquisaPorNmDescMaterial($pdo);            
            
            if($dao->Sucesso()){
                foreach ($dao->getMsgRetorno() as $key => $value) {                    
                    $retorno .= '<tr class="selecionaItem" data-item="'.$value['id_material'].'"';
                    $retorno .= "data-info='".json_encode($value)."'";
                    $retorno .= 'style="cursor:pointer;">
                        <td>'.$value['cd_desc_material'].'</td>
                        <td>'.$value['nm_desc_material'].'</td>
                        <td>'.$value['nm_material'].'</td>
                        <td>'.$value['nm_grupo'].'</td>
                        <td class="text-center">'.$value['nm_sub_grupo'].'</td>                        
                        <td class="text-center">'.$value['tp_material'].'</td>
                        <td class="text-center">'.$value['cd_elemento_despesa'].'</td>                        
                        </tr>';
                }
            }            
            return $retorno;

        } catch (Exception $ex) {
            $retorno = $ex->getMessage();
            return $retorno;
        }
    }
    
    
    
    
}

?>
