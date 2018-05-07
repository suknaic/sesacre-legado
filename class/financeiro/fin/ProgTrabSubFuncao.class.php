<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinProgTrabSubFuncao.class.php";

class ProgTrabSubFuncao {
    //atributos de prog_trab_sub_funcao
    private $codSubFuncao = null;
    private $idCodSubFuncao = null;
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
    //getters e setters de prog_trab_sub_funcao
    function getCodSubFuncao() {
        return $this->codSubFuncao;
    }

    function getIdCodSubFuncao() {
        return $this->idCodSubFuncao;
    }

    function setCodSubFuncao($codSubFuncao) {
        $this->codSubFuncao = $codSubFuncao;
    }

    function setIdCodSubFuncao($idCodSubFuncao) {
        $this->idCodSubFuncao = $idCodSubFuncao;
    }
    //=========================================//
    //cadastra SubFunção
    public function cadastrarTrabSubFuncao(){
        try{
            //verifica se o campo está vazio
            if (empty($this->codSubFuncao) == True){
                return Metodos::retornoAjax("Erro","alert", STR_PREENCHER_CAMPOS);
            }
            //verifica se o valor possui 2 caracteres
            if (strlen($this->codSubFuncao) != 3){
                return Metodos::retornoAjax("Erro","alert", STR_VALOR_INVALIDO."(OBS: Permitido somente valor com 3 dígitos)");
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoProgTrabSubFuncao();
            $dao->setCodSubFuncao($this->codSubFuncao);
            
            $dao->verificaTrabSubFuncao($pdo);
            
            if ($dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }else{
                $dao->cadastraTrabSubFuncao($pdo);
                if (!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }
                $dao->setIdCodSubFuncao($pdo->lastInsertId('fin_prog_trab_subfuncao_id_prog_trab_subfuncao_seq'));
                if (Log::SalvaLogI('fin_prog_trab_subfuncao', $dao->getIdCodSubFuncao(), $pdo)){
                    $pdo->commit();
                    return Metodos::retornoAjax("ok","html", STR_CADASTRO_SUCESSO);
                }else{
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro","console", STR_ERROR);
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //edita SubFunção
    public function editarTrabSubFuncao(){
        try{
            if (empty($this->codSubFuncao && $this->idCodSubFuncao) == true ){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            if (strlen($this->codSubFuncao) != 3){
                return Metodos::retornoAjax("Erro", "alert", STR_VALOR_INVALIDO."(OBS: Permitido somente valor com 3 dígitos)");
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoProgTrabSubFuncao();
            $dao->setCodSubFuncao($this->codSubFuncao);
            $dao->setIdCodSubFuncao($this->idCodSubFuncao);
            $dao->retornarTrabSubFuncao($pdo);
            $busca = $dao->getMsgRetorno();
            
            $dao->verificaTrabSubFuncao($pdo);
            if (!$dao->Sucesso()){
                $dao->editaTrabSubFuncao($pdo);
                if (!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                } else {
                    if (Log::SalvaLogU('fin_prog_trab_subfuncao', $this->getIdCodSubFuncao(), $busca, $pdo)){
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    //lista SubFunção
    public function listarTrabSubFuncao(){
        try{
            if (empty($this->codSubFuncao) == true){
                return Metodos::retornoAjax("Erro","alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $dao = new DaoProgTrabSubFuncao();
            $dao->setCodSubFuncao($this->codSubFuncao);
            if ($this->codSubFuncao != 'todas'){
                $dao->listaTrabSubFuncao($pdo);
            }else{
                $dao->listaTodasTrabSubFuncao($pdo);
            }
            if (!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro","console", $dao->getMsgRetorno());
            }else{
                $this->msgRetorno = '
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Subfunções</h3>
                        </div>
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela_prog_trab_subfunc" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-capitalize text-center">Subfunção</th>
                                                    <th class="text-capitalize text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '      
                                                <tr>
                                                    <td class="text-center">'.$linha["cd_prog_trab_subfuncao"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" subFuncao="'.$linha["cd_prog_trab_subfuncao"].'"
                                                            value="'.$linha["id_prog_trab_subfuncao"].'">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="'.$linha["id_prog_trab_subfuncao"].'">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                }
                $this->msgRetorno .= '      </tbody>
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
    //desativa SubFunção
    public function removerTrabSubFuncao(){
        try{
            if (empty($this->idCodSubFuncao) == True){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $dao = new DaoProgTrabSubFuncao();
            $dao->setIdCodSubFuncao($this->idCodSubFuncao);
            $dao->setCodSubFuncao($this->codSubFuncao);
            $dao->retornarTrabSubFuncao($pdo);
            $busca = $dao->getMsgRetorno();
            
            $dao->verificaTrabSubFuncao($pdo);
            if (!$dao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Registro não encontrado.");
            }else{
                $dao->desativaTrabSubFuncao($pdo);
                if (!$dao->Sucesso()){
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                }else{
                    if (Log::SalvaLogU('fin_prog_trab_subfuncao', $this->getIdCodSubFuncao(), $busca, $pdo)){
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
    
}