<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinRedeTematica.class.php";

class RedeTematica {
    
    private $nmRedeTematica = null;
    private $idRedeTematica = null;
    private $idBlocOrcamentario = null;
    
//============================//
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    //============================//
    function getNmRedeTematica() {
        return $this->nmRedeTematica;
    }

    function getIdRedeTematica() {
        return $this->idRedeTematica;
    }

    function getIdBlocOrcamentario() {
        return $this->idBlocOrcamentario;
    }

    function setNmRedeTematica($nmRedeTematica) {
        $this->nmRedeTematica = $nmRedeTematica;
    }

    function setIdRedeTematica($idRedeTematica) {
        $this->idRedeTematica = $idRedeTematica;
    }

    function setIdBlocOrcamentario($idBlocOrcamentario) {
        $this->idBlocOrcamentario = $idBlocOrcamentario;
    }
//========================================================================//
    //cadastra Rede Tematica
    public function cadastrarRedeTematica(){
        try{
            if (empty($this->nmRedeTematica && $this->idBlocOrcamentario) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoRedeTematica();
            $dao->setNmRedeTematica($this->nmRedeTematica);
            $dao->setIdBlocOrcamentario($this->idBlocOrcamentario);
            
            $dao->verificaRedeTematica($pdo);
            if($dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Registro com o mesmo NOME já existe no sistema.");
            }else{
                $dao->cadastraRedeTematica($pdo);
                if (!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }else{
                    $dao->setIdRedeTematica($pdo->lastInsertId('fin_rede_tematica_id_rede_tematica_seq'));
                    if (Log::SalvaLogI('fin_rede_tematica', $dao->getIdRedeTematica(), $pdo)){
                        $pdo->commit();
                        return Metodos::retornoAjax("ok","html", STR_CADASTRO_SUCESSO);
                    }else{
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro","console", STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //edita Rede Tematica
    public function editarRedeTematica($verifica){
        try{
            if (empty($this->nmRedeTematica && $this->idBlocOrcamentario) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoRedeTematica();
            $dao->setIdBlocOrcamentario($this->idBlocOrcamentario);
            $dao->setNmRedeTematica($this->nmRedeTematica);
            $dao->setIdRedeTematica($this->idRedeTematica);
            $dao->retornaRedeTematica($pdo);
            $busca = $dao->getMsgRetorno();
            
            if ($verifica != $this->nmRedeTematica){
                $dao->verificaRedeTematica($pdo);
                if ($dao->Sucesso()){
                    return Metodos::retornoAjax("Erro", "alert", "Registro com o mesmo NOME já existe no sistema.");
                } else {
                    $dao->editaRedeTematica($pdo);
                    if (!$dao->Sucesso()){
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    } else {
                        if (Log::SalvaLogU('fin_rede_tematica', $this->getIdRedeTematica(), $busca, $pdo)){
                            $pdo->commit();
                            return Metodos::retornoAjax("ok","html", STR_EDICAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    }
                }
            } else {
                $dao->editaRedeTematica($pdo);
                if (!$dao->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_rede_tematica', $this->getIdRedeTematica(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //lista as redes tematicas de acordo com a pesquisa
    public function listarRedeTematica(){
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $dao = new DaoRedeTematica();
            if(empty($this->nmRedeTematica) == FALSE){
                $codigo = "REDE.nm_rede_tematica ='".$this->nmRedeTematica."'";
            }else if(empty($this->idBlocOrcamentario) == FALSE){
                $codigo = 'REDE.id_bloco_orcamentario ='.$this->idBlocOrcamentario;
            }else {
                return Metodos::retornoAjax("Erro","alert", STR_PREENCHER_CAMPOS);
            }
            
            if ($this->nmRedeTematica != 'todas'){
                $dao->listaRedeTematica($codigo, $pdo);
            }else{
                $dao->listaTodasRedeTematica($pdo);
            }
            
            if (!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro","console", $dao->getMsgRetorno());
            }else{
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Redes Temáticas</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_rede" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Rede Temática</th>
                                                    <th class="text-capitalize text-center">Bloco Orçamentário</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno.= '      
                                                <tr>
                                                    <td class="text-center">'.$linha["nm_rede_tematica"] . '</td>
                                                    <td class="text-center">'.$linha["nm_bloco_orcamentario"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" rede="'.$linha["nm_rede_tematica"].'" value="'.$linha["id_rede_tematica"].'">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="'.$linha["id_rede_tematica"].'">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                }
                    $this->msgRetorno.= '   </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                return Metodos::retornoAjax("ok", "html", $this->msgRetorno);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //desativa a rede tematica
    public function removerRedeTematica(){
        try{
            if (empty($this->idRedeTematica && $this->nmRedeTematica) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoRedeTematica();
            $dao->setIdRedeTematica($this->idRedeTematica);
            $dao->setNmRedeTematica($this->nmRedeTematica);
            $dao->retornaRedeTematica($pdo);
            $busca = $dao->getMsgRetorno();
            
            $dao->verificaRedeTematica($pdo);
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Registro não encontrado.");
            }else{
                $dao->desativaRedeTematica($pdo);
                if(!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }else{
                    if (Log::SalvaLogU('fin_rede_tematica', $this->getIdRedeTematica(), $busca, $pdo)) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //carrega todos o dados necessários para edicao da rede tematica
    public function carregaDadosRedeTematica() {
        try {
            if (empty($this->idRedeTematica) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $dao = new DaoRedeTematica();
            $dao->setIdRedeTematica($this->idRedeTematica);
            
            $dao->carregaDadosRedeTematica($pdo);
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
            }else{
                return $dao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //lista o blocos orçamentários
    public function listarBlocosOrcamentario(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoRedeTematica();
            
            $dao->listaTodosBlocosOrcamentarios($pdo);
            if (!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "concole", $dao->getMsgRetorno());
            }else{
                foreach ($dao->getMsgRetorno() as $linhas) {
                    if($this->idBlocOrcamentario == $linhas['id_bloco_orcamentario']){
                        $this->msgRetorno .= "<option value='".$linhas['id_bloco_orcamentario']."' selected>".$linhas['nm_bloco_orcamentario']."</option>";                      
                    }else{
                        $this->msgRetorno .= "<option value='".$linhas['id_bloco_orcamentario']."'>".$linhas['nm_bloco_orcamentario']."</option>";                    
                    }
                }
                return $this->msgRetorno;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
}