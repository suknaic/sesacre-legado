<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContItensSaldo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContItensGrupo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContItensGrupoItem.class.php";


class FinContItensSaldo {
   
    
    private $idContItensSaldo = null;
    private $idContItensGrupo = null;
    private $idContItens = null;
    private $idContItensOriginal = null;
    private $vlContItensSaldo = null;
    private $dsContItensSaldo = null;                   
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getIdContItensSaldo() {
        return $this->idContItensSaldo;
    }

    function getIdContItensGrupo() {
        return $this->idContItensGrupo;
    }

    function getIdContItens() {
        return $this->idContItens;
    }

    function getIdContItensOriginal() {
        return $this->idContItensOriginal;
    }

    function getVlContItensSaldo() {
        return $this->vlContItensSaldo;
    }

    function getDsContItensSaldo() {
        return $this->dsContItensSaldo;
    }

    function setIdContItensSaldo($idContItensSaldo) {
        $this->idContItensSaldo = $idContItensSaldo;
        return $this;
    }

    function setIdContItensGrupo($idContItensGrupo) {
        $this->idContItensGrupo = $idContItensGrupo;
        return $this;
    }

    function setIdContItens($idContItens) {
        $this->idContItens = $idContItens;
        return $this;
    }

    function setIdContItensOriginal($idContItensOriginal) {
        $this->idContItensOriginal = $idContItensOriginal;
        return $this;
    }

    function setVlContItensSaldo($vlContItensSaldo) {
        $this->vlContItensSaldo = $vlContItensSaldo;
        return $this;
    }

    function setDsContItensSaldo($dsContItensSaldo) {
        $this->dsContItensSaldo = $dsContItensSaldo;
        return $this;
    }       
    
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    public function Sucesso(){
        return $this->sucesso;
    }
    
    
        
    /**
     * Ao Passar um Array de Objetos de FinItensTb
     * O Sistema irá registrar uma nova informação no Saldo do Item
     * Se for necessário, ele irá criar um novo grupo e colocar o Item nesse Grupo de Itens
     * Ou, ele somente irá usar o grupo ao qual ele pertence
     * 
     * Também irá validar o Saldo, não deixando o saldo daquela item e grupo com Saldo negativo
     * @param array $finItens
     * @param bool $novoGrupo
     * @param string $motivo
     * @param PDO $pdo
     * @return type
     */
    public function salvar(array $finItens, bool $novoGrupo
            , string $motivo, PDO $pdo){
        
        try {
            
            $dao = new DaoFinContItensSaldo();
            
            //Se novoGrupo for True, então se deve criar um novo grupo
            if($novoGrupo){
                $daoContItensGrupo = new DaoFinContItensGrupo();
                
                $daoContItensGrupo->insert($pdo);
            
                if(!$daoContItensGrupo->Sucesso()){
                    $this->sucesso = false;
                    $this->msgRetorno = $daoContItensGrupo->getMsgRetorno();
                    return;
                }
                $daoContItensGrupo->setIdContItensGrupo($pdo->lastInsertId('fin_cont_itens_grupo_id_cont_itens_grupo_seq'));
                if (!Log::SalvaLogI('fin_cont_itens_grupo', $daoContItensGrupo->getIdContItensGrupo(), $pdo)){
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro no Log dos itens";
                    return;
                }                                
                $this->idContItensGrupo = $daoContItensGrupo->getIdContItensGrupo();
            }else{
                /*
                 * Se não for criar o novo grupo, então é necessário somente buscar o Grupo mais Recente
                 * que está sendo utilizado pelo Item Original(A Qual o Item está sendo referenciado)
                 */
                
                $dao->retornaUltimoGrupoParaContItensOriginal($pdo);
                
            }
            
            
            $dao->setIdFornecedor($this->idFornecedor);
            $dao->retornaItensFornecedorSemJoins($pdo);
            
            if($dao->sucesso()){
                if(empty($dao->getMsgRetorno())){
                    $this->sucesso = false;
                    $this->msgRetorno = "Não existe Itens Para Esse Contrato";
                    return;
                }                                
                
                $result = $dao->getMsgRetorno();                
                
                //Utilizado para saber se a quantidade de itens que veio do fornecedor é a mesma que foi excluído
                $quantidadeDeItens = count($result);
                $i = 0;
                foreach ($result as $key => $value) {
                    
                    $dao->setIdContItens($value['id_cont_itens']);
                    $dao->retorna($pdo);
                    
                    if(!$dao->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        return; 
                    }
                    
                    $busca = $dao->getMsgRetorno();
                    $dao->setIdContItens($busca['id_cont_itens']);                   
                    
                    if (!Log::SalvaLogD('fin_cont_itens', $dao->getIdContItens(), $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = "Não foi possível localizar os Itens, LOG";
                        return; 
                    }
                    
                    $dao->excluirItem($pdo);                   
                    
                    if(!$dao->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        return; 
                    }     
                    
                    $i++;                    
                }       
                
                if($quantidadeDeItens == $i){
                    $this->sucesso = true;
                    $this->msgRetorno = "ok";
                    return;
                }else{
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível excluir todos os Itens";
                    return;  
                }
                               
                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
            }            
            $this->sucesso = false;
            $this->msgRetorno = "Não foi possível excluir os Itens";
            return;                                                                        
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    
    
    
}

