<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaIndicadorSaude.class.php";

class IndicadorSaude{
    
    private $idIndicadorSaude = null;
    private $nmIndicadorSaude = null;
    private $aaIndicadorSaude = null;
    private $cdNota = null;
    private $tpIndicadorSaude = null;
    private $dsMeta = null;
    private $dsUnidade = null;

    function getIdIndicadorSaude() {
        return $this->idIndicadorSaude;
    }

    function getNmIndicadorSaude() {
        return $this->nmIndicadorSaude;
    }

    function getAaIndicadorSaude() {
        return $this->aaIndicadorSaude;
    }

    function getCdNota() {
        return $this->cdNota;
    }

    function getTpIndicadorSaude() {
        return $this->tpIndicadorSaude;
    }

    function getDsMeta() {
        return $this->dsMeta;
    }

    function getDsUnidade() {
        return $this->dsUnidade;
    }

    function setIdIndicadorSaude($idIndicadorSaude) {
        $this->idIndicadorSaude = $idIndicadorSaude;
    }

    function setNmIndicadorSaude($nmIndicadorSaude) {
        $this->nmIndicadorSaude = $nmIndicadorSaude;
    }

    function setAaIndicadorSaude($aaIndicadorSaude) {
        $this->aaIndicadorSaude = $aaIndicadorSaude;
    }

    function setCdNota($cdNota) {
        $this->cdNota = $cdNota;
    }

    function setTpIndicadorSaude($tpIndicadorSaude) {
        $this->tpIndicadorSaude = $tpIndicadorSaude;
    }

    function setDsMeta($dsMeta) {
        $this->dsMeta = $dsMeta;
    }

    function setDsUnidade($dsUnidade) {
        $this->dsUnidade = $dsUnidade;
    }

    
                              
    public function salvarIndicadorSaude(){
        try {            
            if($this->nmIndicadorSaude == "" || strlen($this->aaIndicadorSaude) != 4                     
                    || $this->cdNota == "" || $this->tpIndicadorSaude == ""                    
                    || $this->dsMeta == "" || $this->dsUnidade == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaIndicadorSaude();
            
            $dao->setNmIndicadorSaude($this->nmIndicadorSaude);
            $dao->setAaIndicadorSaude($this->aaIndicadorSaude);
            $dao->setCdNota($this->cdNota);
            $dao->setTpIndicadorSaude($this->tpIndicadorSaude);
            $dao->setDsMeta($this->dsMeta);
            $dao->setDsUnidade($this->dsUnidade);
            
            //Verifica se é insert ou edição
            $inserir = 0;
            if($this->idIndicadorSaude == "" 
                    || $this->idIndicadorSaude == 0){                
                $inserir = 1;
            }else{
                $dao->setIdIndicadorSaude($this->idIndicadorSaude);
            }
                                                
            if($inserir == 1){
                $result = $dao->insert($pdo);
                if ($result != "Sucesso") {
                    $retorno = Metodos::retornoAjax("Erro", "console", $result);
                    $pdo->rollBack();
                    return $retorno;
                }

                $dao->setIdIndicadorSaude($pdo->lastInsertId('pla_indicador_saude_id_indicador_saude_seq'));            

                if (Log::SalvaLogI('pla_indicador_saude', $dao->getIdIndicadorSaude(), $pdo)) {
                    $sucesso = true;
                }else{
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            }else{
                $busca = $dao->retornaIndicadorSaude($pdo);
            
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

                if (!Log::SalvaLogU('pla_indicador_saude', $dao->getIdIndicadorSaude(), $busca, $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }else{
                    $sucesso = true;
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
    
       
    public function removerIndicadorSaude(){
        try {
                                    
            if($this->idIndicadorSaude == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaIndicadorSaude();
            
            $dao->setIdIndicadorSaude($this->idIndicadorSaude);       
            
            $busca = $dao->retornaIndicadorSaude($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_indicador_saude', $dao->getIdIndicadorSaude(), $pdo)) {
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
    
    
    public function retornaTrIndicadorSaude(){
        $retorno = "";                
        try{
            $conexao = new Conexao();            
            $pdo = $conexao->connect();
            /* @var $pdo PDO */
            $dao = new DaoPlaIndicadorSaude();
            
            $result = $dao->retornaTodosIndicadores($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idIndicadorSaude = $v['id_indicador_saude'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['cd_nota'] . "</td>"
                            . "<td>" . $v['tp_indicador_saude'] . "</td>"
                            . "<td>" . $v['nm_indicador_saude'] . "</td>"
                            . "<td>" . $v['aa_indicador_saude'] .  "</td>"
                            . "<td>" . $v['ds_meta'] .  "</td>"
                            . "<td>" . $v['ds_unidade'] .  "</td>"
                            . '<td style="text-align: center;">'                                                       
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nm_indicador_saude'].'" '
                                . ' ano="'.$v['aa_indicador_saude'].'" '
                                . ' nota="'.$v['cd_nota'].'" '
                                . ' tipo="'.$v['tp_indicador_saude'].'" '
                                . ' meta="'.$v['ds_meta'].'" '
                                . ' unidade="'.$v['ds_unidade'].'" '
                                . ' value=' . $idIndicadorSaude . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idIndicadorSaude . ' >
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
    
    /**
     * 
     * @param int $ano
     * @return string
     */
    public function retornaSelectPorAno(int $ano){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaIndicadorSaude();            
            $dao->setAaIndicadorSaude($ano);
            $result = $dao->retornaTodosIndicadorSaudePorAno($pdo);                                                                       
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.                                    
                foreach ($result as $value) {                    
                    $retorno .= "<option value=".$value['id_indicador_saude'].">"
                            . $value['cd_nota']." - ".$value['nm_indicador_saude']
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
