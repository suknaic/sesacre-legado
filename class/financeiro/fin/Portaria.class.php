<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinPortaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";


class Portaria{
    
    private $idPortaria = null;
    private $idRedeTematica = null;
    private $nmPortaria = null;
    private $dtPortaria = null;
    private $stPortaria = null;
    private $vlTotal = null;
    private $idFonte = null;
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
        return $this;
    }
        
    function getIdPortaria() {
        return $this->idPortaria;
    }

    function getIdRedeTematica() {
        return $this->idRedeTematica;
    }

    function getNmPortaria() {
        return $this->nmPortaria;
    }

    function getDtPortaria() {
        return $this->dtPortaria;
    }

    function getStPortaria() {
        return $this->stPortaria;
    }

    function getVlTotal() {
        return $this->vlTotal;
    }

    function setIdPortaria($idPortaria) {
        $this->idPortaria = $idPortaria;
        return $this;
    }

    function setIdRedeTematica($idRedeTematica) {
        $this->idRedeTematica = $idRedeTematica;
        return $this;
    }

    function setNmPortaria($nmPortaria) {
        $this->nmPortaria = $nmPortaria;
        return $this;
    }

    function setDtPortaria($dtPortaria) {
        $this->dtPortaria = $dtPortaria;
        return $this;
    }

    function setStPortaria($stPortaria) {
        $this->stPortaria = $stPortaria;
        return $this;
    }

    function setVlTotal($vlTotal) {
        $this->vlTotal = $vlTotal;
        return $this;
    }

                         
    
    /**    
     * @return Object
     */
    public function retornaPortarias(PDO $pdo){
        $this->sucesso = false;             
        try{            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $dao = new DaoFinPortaria();

            $dao->retornaTodasPortarias($pdo);
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
    
    //cadastra portaria
    public function cadastrarPortaria(){
        try {
            if (empty($this->idRedeTematica && $this->nmPortaria && $this->dtPortaria && $this->vlTotal)){
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
                return;
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dao = new DaoFinPortaria();
            
            $dao->setIdRedeTematica($this->idRedeTematica);
            $dao->setNmPortaria($this->nmPortaria);
            $dao->setDtPortaria(Metodos::ConverteDataING($this->dtPortaria));
            $dao->setVlTotal(Metodos::ConverteValorIng($this->vlTotal));
            
            $dao->verificaPortaria($pdo);
            if ($dao->Sucesso()){
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", "Portaria com o mesmo NOME já existe.");
            } else {
                $dao->cadastrarPortaria($pdo);
                if (!$dao->Sucesso()){
                    $pdo->rollBack();
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    $dao->setIdPortaria($pdo->lastInsertId('fin_portaria_id_portaria_seq'));
                    if (Log::SalvaLogI('fin_portaria', $this->getIdPortaria(), $pdo)) {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    //lista portaria
    public function listarPortaria(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $dao = new DaoFinPortaria();
            
            if ($this->nmPortaria){
                $codigo = "portaria.nm_portaria ILIKE '".$this->nmPortaria."%'";
            } elseif ($this->idRedeTematica){
                $codigo = "portaria.id_rede_tematica=".$this->idRedeTematica;
            }else{
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $dao->listarPortaria($pdo, $codigo);
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", $dao->getMsgRetorno());
            }else{
                $this->sucesso = TRUE;
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Portarias</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_port" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Nome</th>
                                                    <th class="text-capitalize text-center">Rede Temática</th>
                                                    <th class="text-capitalize text-center">Data</th>
                                                    <th class="text-capitalize text-center">Valor</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                        $this->msgRetorno .= '      
                                                <tr>
                                                    <td class="text-center">'.$linha["nm_portaria"] . '</td>
                                                    <td class="text-center">'.$linha["nm_rede_tematica"] . '</td>
                                                    <td class="text-center">'. Metodos::ConverteDataBR($linha["dt_portaria"]) . '</td>
                                                    <td class="text-center">'. Metodos::ConverteValorBr($linha["vl_total"],2) . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" portaria="'.$linha["nm_portaria"].'"
                                                            value="'.$linha["id_portaria"].'">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="'.$linha["id_portaria"].'">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                }
                $this->msgRetorno.='        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $this->msgRetorno);
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function editarPortaria($verifica){
        try {
            if (empty($this->idPortaria && $this->nmPortaria && $this->dtPortaria && $this->vlTotal && $this->idRedeTematica)){
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
                return;
            }else{
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $dao = new DaoFinPortaria();
                $pdo->beginTransaction();
                
                $dao->setIdPortaria($this->idPortaria);
                $dao->setNmPortaria($this->nmPortaria);
                $dao->setDtPortaria(Metodos::ConverteDataING($this->dtPortaria));
                $dao->setVlTotal(Metodos::ConverteValorIng($this->vlTotal));
                $dao->setIdRedeTematica($this->idRedeTematica);
                $dao->retornaPortaria($pdo);
                $busca = $dao->getMsgRetorno();
                
                if ($verifica != $this->nmPortaria){
                    $dao->verificaPortaria($pdo);
                    if (!$dao->Sucesso()){
                        $dao->editarPortaria($pdo);
                        if (!$dao->Sucesso()){
                            $pdo->rollBack();
                            $this->sucesso = FALSE;
                            $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                        }else{
                            if (Log::SalvaLogU('fin_portaria', $this->getIdPortaria(), $busca, $pdo)){
                                $pdo->commit();
                                $this->sucesso = TRUE;
                                $this->msgRetorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                            } else {
                                $pdo->rollBack();
                                $this->sucesso = FALSE;
                                $this->msgRetorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            }
                        }
                    }else{
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", "Portaria com o mesmo NOME já existe.");
                    }
                }else{
                    $dao->editarPortaria($pdo);
                    if (!$dao->Sucesso()) {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
                        $pdo->commit();
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function carregaDadosPortaria() {
        try {
            if (empty($this->idPortaria)){
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
                return;
            }else{
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                
                $dao = new DaoFinPortaria();
                $dao->setIdPortaria($this->idPortaria);
                
                $dao->carregaDadosPortaria($pdo);
                if(!$dao->Sucesso()){
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                }else{
                    $this->sucesso = TRUE;
                    $this->msgRetorno = $dao->getMsgRetorno();
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    //desativa portaria
    public function desativarPortaria(){
        try {
            if (empty($this->idPortaria && $this->nmPortaria)){
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
                return;
            }else{
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                
                $dao = new DaoFinPortaria();
                $dao->setIdPortaria($this->idPortaria);
                $dao->setNmPortaria($this->nmPortaria);
                $dao->retornaPortaria($pdo);
                $busca = $dao->getMsgRetorno();
                
                $dao->verificaPortaria($pdo);
                if ($dao->Sucesso()){
                    $dao->desativaPortaria($pdo);
                    if ($dao->Sucesso()){
                        if (Log::SalvaLogU('fin_portaria', $this->getIdPortaria(), $busca, $pdo)) {
                            $pdo->commit();
                            $this->sucesso = TRUE;
                            $this->msgRetorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            $this->sucesso = FALSE;
                            $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    }
                } else {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = $dao->getMsgRetorno();
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //lista redes tematicas em combo box
    public function listarRedeTematica(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinPortaria();
            
            $dao->listarRedesTematicas($pdo);
            if(!$dao->Sucesso()){
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", $dao->getMsgRetorno());
            }else{
                $this->sucesso = TRUE;
                foreach ($dao->getMsgRetorno() as $linha){
                    if($this->idRedeTematica == $linha['id_rede_tematica']){
                        $this->msgRetorno .="<option value='".$linha['id_rede_tematica']."' selected>".$linha['nm_rede_tematica']."</option>";
                    }else{
                        $this->msgRetorno .="<option value='".$linha['id_rede_tematica']."'>".$linha['nm_rede_tematica']."</option>";
                    }
                }
                return $this->msgRetorno;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
}

?>
