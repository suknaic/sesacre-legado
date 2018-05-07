<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";


class Relatorio{
    
    
    
    
    /**
     * Retorna uma Tr contendo todos os Valores Agrupagos Por Projeto/Atividade do PPA
     * É Necesário passar um ano especifico.
     * Porém a Lotação não é Obrigatoria, caso não seja especificado a Lotação ele irá agrupar todos.
     * @param int $ano
     * @param int $idLotacao
     * @param PDO $pdo
     * @return string
     */
    public function rTrValProjAtiPPAAnoLot(int $ano, int $idLotacao, $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                    
            if(strlen($ano) != 4){
                return $retorno;
            }
            
            if(empty($idLotacao)){
                $idLotacao == 0;
            }
            
            $ptaItem = new PtaItem();
            $ptaItem->retornaValoresProjAtiPPAAnoLot($ano, $idLotacao, $pdo);                        

                   
            if(!$ptaItem->Sucesso()){
                $retornfoot = "<tr>"
                                ."<th class='text-left' colspan=3>Total</th>"                                
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr('0.0000', 4)."</th>"                                
                            . "</tr>"; 
                $ret = array($retorno, $retornfoot);
                return Metodos::retornoAjax("ok", NULL, $ret);                
            }else{
                
                $result = $ptaItem->getMsgRetorno();
                $valorTotal = 0;
                $ppa = new PpaProjAti();
                
                foreach ($result as $v) {         
               
                    $valorTotal += $v['valor'];
                    $retorno .= "<tr>"
                                . "<td>".$v['nm_ppa_prog']."</td>"
                                . "<td>".$v['nm_ppa_proj_ati']."</td>"
                                . "<td>".$ppa->retornaTipo($v['tp_ppa_proj_ati'])."</td>"
                                . "<td class='text-right'> R$ ". Metodos::ConverteValorBr((float)$v['valor'], 4)."</td>"                                                         
                            . "</tr>";                                                                                                
                }

                                             
                $retornfoot = "<tr>"
                                ."<th class='text-left' colspan=3>Total</th>"                                                                
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                                
                            . "</tr>";                                                        
                
            }
            $ret = array($retorno, $retornfoot);
            
            return Metodos::retornoAjax("ok", NULL, $ret);
        
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }  
    
    /**
     * Retorna uma Tr contendo todos os Valores Agrupagos Por Projeto/Atividade do PPA
     * É Necesário passar um ano especifico.
     * Porém a Lotação não é Obrigatoria, caso não seja especificado a Lotação ele irá agrupar todos.
     * @param int $ano
     * @param int $idLotacao
     * @param PDO $pdo
     * @return string
     */
    public function rTrValAcaoAnoLot(int $ano, int $idLotacao, $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                    
            if(strlen($ano) != 4){
                return $retorno;
            }
            
            if(empty($idLotacao)){
                $idLotacao == 0;
            }
            
            $ptaItem = new PtaItem();
            $ptaItem->retornaValoresAcaoAnoLot($ano, $idLotacao, $pdo);                        

                   
            if(!$ptaItem->Sucesso()){                
                
                $retornfoot = "<tr>"
                                ."<th class='text-left' colspan=3>Total</th>"                                
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr('0.0000', 4)."</th>"                                
                            . "</tr>"; 
                $ret = array($retorno, $retornfoot);
                return Metodos::retornoAjax("ok", NULL, $ret);                
            }else{
                
                $result = $ptaItem->getMsgRetorno();
                $valorTotal = 0;
                $acao = new Acao();
                
                foreach ($result as $v) {         
               
                    $valorTotal += $v['valor'];
                    $retorno .= "<tr>"
                                . "<td>".$v['nm_eixo']."</td>"
                                . "<td>".$v['nm_acao']."</td>"
                                . "<td>".$acao->pegaCadastro($v['tp_cadastro'])."</td>"
                                . "<td class='text-right'> R$ ". Metodos::ConverteValorBr((float)$v['valor'], 4)."</td>"                                                         
                            . "</tr>";                                                                                                
                }

                                             
                $retornfoot = "<tr>"
                                ."<th class='text-left' colspan=3>Total</th>"                                                                
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                                
                            . "</tr>";                                                        
                
            }
            $ret = array($retorno, $retornfoot);
            
            return Metodos::retornoAjax("ok", NULL, $ret);
        
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    /**
     * Retorna uma Tr contendo todos os Valores Agrupagos Por Projeto/Atividade do PPA
     * É Necesário passar um ano especifico.
     * Porém a Lotação não é Obrigatoria, caso não seja especificado a Lotação ele irá agrupar todos.
     * @param int $ano
     * @param int $idLotacao
     * @param PDO $pdo
     * @return string
     */
    public function rTrValCatEconomicaAnoLotTG(int $ano, int $idLotacao, int $idTipoGasto, $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
                                    
            if(strlen($ano) != 4){
                return $retorno;
            }
            
            if(empty($idLotacao)){
                $idLotacao == 0;
            }
            
            if(empty($idTipoGasto)){
                $idTipoGasto == 0;
            }
            
            $ptaItem = new PtaItem();
            $ptaItem->retornaValoresCatEconomicaAnoLotTG($ano, $idLotacao, $idTipoGasto, $pdo);                        

                   
            if(!$ptaItem->Sucesso()){                
                
                $retornfoot = "<tr>"
                                ."<th class='text-left' colspan=1>Total</th>"                                
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr('0.0000', 4)."</th>"                                
                            . "</tr>"; 
                $ret = array($retorno, $retornfoot);
                return Metodos::retornoAjax("ok", NULL, $ret);                
            }else{
                
                $result = $ptaItem->getMsgRetorno();
                $valorTotal = 0;
                
                
                foreach ($result as $v) {         
               
                    $valorTotal += $v['valor'];
                    $retorno .= "<tr>"
                                . "<td>".$v['ds_despesa_categoria']."</td>"                                                            
                                . "<td class='text-right'> R$ ". Metodos::ConverteValorBr((float)$v['valor'], 4)."</td>"                                                         
                            . "</tr>";                                                                                                
                }
                                             
                $retornfoot = "<tr>"
                                ."<th class='text-left' colspan=1>Total</th>"                                                                
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotal, 4)."</th>"                                
                            . "</tr>";                                                        
                
            }
            $ret = array($retorno, $retornfoot);
            
            return Metodos::retornoAjax("ok", NULL, $ret);
        
            return $retorno;
                                                                     
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
}
