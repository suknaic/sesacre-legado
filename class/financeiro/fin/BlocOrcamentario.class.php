<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinBlocOrcamentario.class.php";

class BlocOrcametario {
    
    private $nmBlocOrcamentario = null;
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
    
    function getNmBlocOrcamentario() {
        return $this->nmBlocOrcamentario;
    }

    function getIdBlocOrcamentario() {
        return $this->idBlocOrcamentario;
    }

    function setNmBlocOrcamentario($nmBlocOrcamentario) {
        $this->nmBlocOrcamentario = $nmBlocOrcamentario;
    }

    function setIdBlocOrcamentario($idBlocOrcamentario) {
        $this->idBlocOrcamentario = $idBlocOrcamentario;
    }
    //========================================================================//
    public function cadastrarBlocOrcamentario(){
        try{
            if (empty($this->nmBlocOrcamentario) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoBlocOrcamentario();
            $dao->setNmBlocOrcamentario($this->nmBlocOrcamentario);
            
            $dao->verificaBlocOrcamentario($pdo);
            if ($dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }else{
                $dao->cadastraBlocOrcamentario($pdo);
                if (!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }else{
                    $dao->setIdBlocOrcamentario($pdo->lastInsertId('fin_bloco_orcamentario_id_bloco_orcamentario_seq'));
                    if (Log::SalvaLogI('fin_bloco_orcamentario', $dao->getIdBlocOrcamentario(), $pdo)){
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
    
    public function editarBlocOrcamentario(){
        try{
            if (empty($this->nmBlocOrcamentario && $this->idBlocOrcamentario) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoBlocOrcamentario();
            $dao->setIdBlocOrcamentario($this->idBlocOrcamentario);
            $dao->setNmBlocOrcamentario($this->nmBlocOrcamentario);
            $dao->retornaBlocOrcamentario($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaBlocOrcamentario($pdo);
            if ($dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }else{
                $dao->editaBlocOrcamentario($pdo);
                if(!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }else{
                    if (Log::SalvaLogU('fin_bloco_orcamentario', $this->getIdBlocOrcamentario(), $busca, $pdo)){
                        $pdo->commit();
                        return Metodos::retornoAjax("ok","html", STR_EDICAO_SUCESSO);
                    }else{
                        $pdo->rollBack();
                        return Metodos::retornoAjax('ok', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    
    public function listarBlocOrcamentario(){
        try{
            if (empty($this->nmBlocOrcamentario) == true){
                return Metodos::retornoAjax("Erro","alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $dao = new DaoBlocOrcamentario();
            $dao->setNmBlocOrcamentario($this->nmBlocOrcamentario);
            if ($this->nmBlocOrcamentario != 'todas'){
                $dao->listaBlocOrcamentario($pdo);
            }else{
                $dao->listaTodosBlocOrcamentario($pdo);
            }
            if (!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro","console", $dao->getMsgRetorno());
            }else{
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Blocos Orçamentários</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_bloco" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Bloco Orçamentário</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno.= '      
                                                <tr>
                                                    <td class="text-center">'.$linha["nm_bloco_orcamentario"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" bloco="'.$linha["nm_bloco_orcamentario"].'"
                                                            value="'.$linha["id_bloco_orcamentario"].'">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="'.$linha["id_bloco_orcamentario"].'">
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
    
    public function removerBlocOrcamentario(){
        try{
            if (empty($this->idBlocOrcamentario && $this->nmBlocOrcamentario) == TRUE){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoBlocOrcamentario();
            $dao->setIdBlocOrcamentario($this->idBlocOrcamentario);
            $dao->setNmBlocOrcamentario($this->nmBlocOrcamentario);
            $dao->retornaBlocOrcamentario($pdo);
            $busca = $dao->getMsgRetorno();
            
            $dao->verificaBlocOrcamentario($pdo);
            if(!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Registro não encontrado.");
            }else{
                $dao->desativaBlocOrcamentario($pdo);
                if(!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }else{
                    if (Log::SalvaLogU('fin_bloco_orcamentario', $this->getIdBlocOrcamentario(), $busca, $pdo)){
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                    }else{
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
}