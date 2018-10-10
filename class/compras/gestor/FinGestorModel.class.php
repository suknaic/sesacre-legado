<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinGestor.class.php";

class FinGestorModel {

    private $idGestor = null;
    private $idPessoa = null;
    private $idContrato = null;
    private $tpGestor = null;
    private $dtIniGestor = null;
    private $dtFimGestor = null;
    private $sitAtivo = null;
    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdGestor() {
        return $this->idGestor;
    }

    /**
     * @param mixed $idGestor
     *
     * @return self
     */
    public function setIdGestor($idGestor) {
        $this->idGestor = $idGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->idPessoa;
    }

    /**
     * @param mixed $idPessoa
     *
     * @return self
     */
    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContrato() {
        return $this->idContrato;
    }

    /**
     * @param mixed $idContrato
     *
     * @return self
     */
    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpGestor() {
        return $this->tpGestor;
    }

    /**
     * @param mixed $tpGestor
     *
     * @return self
     */
    public function setTpGestor($tpGestor) {
        $this->tpGestor = $tpGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniGestor() {
        return $this->dtIniGestor;
    }

    /**
     * @param mixed $dtIniGestor
     *
     * @return self
     */
    public function setDtIniGestor($dtIniGestor) {
        $this->dtIniGestor = $dtIniGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimGestor() {
        return $this->dtFimGestor;
    }

    /**
     * @param mixed $dtFimGestor
     *
     * @return self
     */
    public function setDtFimGestor($dtFimGestor) {
        $this->dtFimGestor = $dtFimGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitAtivo() {
        return $this->sitAtivo;
    }

    /**
     * @param mixed $sitAtivo
     *
     * @return self
     */
    public function setSitAtivo($sitAtivo) {
        $this->sitAtivo = $sitAtivo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadastraGestor($pdo = null, int $idContrato, array $dados, int $tipo = 1) {
        try {
            if ((!is_array($dados) || count($dados) < 1)) {
                $this->msgRetorno = STR_PREENCHER_CAMPOS;
                $this->sucesso = FALSE;
                return false;
            }
            $daoFinGestor = new DaoFinGestor();
            foreach ($dados as $v) {
                $daoFinGestor->setIdPessoa($v);
                $daoFinGestor->setIdContrato($idContrato);
                $daoFinGestor->setTpGestor($tipo);
                $daoFinGestor->setDtIniGestor(date('Y-m-d'));
                $daoFinGestor->insertGestor($pdo);

                //*********** verificar ser deu certo o insert caso sim sucesso passa a ser true ***********
                if ($daoFinGestor->sucesso()) {
                    $daoFinGestor->setIdGestor(is_numeric($pdo->lastInsertId('fin_gestor_id_gestor_seq')) ? $pdo->lastInsertId('fin_gestor_id_gestor_seq') : NULL);
                    $this->sucesso = true;
                }
                //******************************************************************************************

                if (!Log::SalvaLogI('fin_gestor', $daoFinGestor->getIdGestor(), $pdo)) {
                    $this->sucesso = false;
                    $this->msgRetorno = 'Erro log';
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function cadastraGestorAditivo($pdo = null) {
        try {            
            $daoFinGestor = new DaoFinGestor();
            
            $daoFinGestor->setIdPessoa($this->idPessoa);
            $daoFinGestor->setIdContrato($this->idContrato);
            $daoFinGestor->setTpGestor($this->tpGestor);
            $daoFinGestor->setDtIniGestor($this->dtIniGestor);

            $daoFinGestor->insertGestor($pdo);
            //verificar ser deu certo o insert caso sim sucesso passa a ser true
            if ($daoFinGestor->sucesso()) {
                $daoFinGestor->setIdGestor(is_numeric($pdo->lastInsertId('fin_gestor_id_gestor_seq')) ? $pdo->lastInsertId('fin_gestor_id_gestor_seq') : NULL);
                $this->sucesso = true;                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = $daoFinGestor->getMsgRetorno();
                return;
            } 

            if (!Log::SalvaLogI('fin_gestor', $daoFinGestor->getIdGestor(), $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = 'erro log';
                return;
            }
            
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornarGestor($idFornecedor, $tp) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinGestor = new DaoFinGestor();
            $pf = new pessoaFisica();
            $pessoaFisica = $pf->retornaTodasPF();

            $daoFinGestor->retornaTodosGestoresPorContrato($idFornecedor, $tp, $pdo);
            $gestores = $daoFinGestor->getMsgRetorno();
            $retorno = '';

            if ($tp == 1) {
                $class = "selectGestores";
                $classPrincipal = "gestoresCampos";
                $id = "gestores";
                $nomeCampo = 'Gestor Titular:';
                $zera = "zeraGestor";
            } else {
                $class = "selectGestoresSub";
                $classPrincipal = "gestoresCamposSub";
                $id = "gestoresSub";
                $nomeCampo = 'Gestor Substituto:';
                $zera = "zeraGestorSubs";
            }
            $contGestor = 0;
            if ($daoFinGestor->sucesso()) {
                foreach ($gestores as $gestor) {
                    $contGestor++;
                    $retorno .= '<div class="form-group">
                                     <div class="col-sm-5">
                                        <div class="panel-body">
                                            '.$nomeCampo.'
                                            <div class="'.$classPrincipal.'">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                    <select class="form-control select '. $class.'" name="'.$id.'[]" id="'.$id.'" required="true">
                                                        <option value="">Selecione uma Pessoa</option>';
                    foreach ($pessoaFisica as $v) {
                        if ($v['id_pessoa'] == $gestor['id_pessoa']) {
                            $retorno .= "               <option value = '" . $v['id_pessoa'] . "' selected='selected'>" . $v['nm_pessoa'] . "</option>";
                        } else {
                            $retorno .= "               <option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                        }
                    }
                    $retorno .= '                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="'. $zera .' btn btn-danger">X</a>
                                        </div>
                                    </div>';
                        if ($contGestor > 1) {
                            $retorno .= '<div class="col-sm-3">
                                            <div class="panel-body">
                                                <a href="#" class="removeGestores btn btn-danger" idGestor= "' . $gestor['id_gestor'] . '">X</a>
                                            </div>
                                        </div>';
                        }
                    $retorno .= ' </div>';
                }
            } else {
                $retorno .= ' <div class="form-group">
                                 <div class="col-sm-5">
                                    <div class="panel-body">
                                        '.$nomeCampo.'
                                        <div class="'.$classPrincipal.'">
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select '. $class.'" name="'.$id.'[]" id="'.$id.'" required="true">
                                                    <option value="">Selecione uma Pessoa</option>';
                    foreach ($pessoaFisica as $pessoa) {
                        $retorno .= '               <option value = "' . $pessoa['id_pessoa'] . '">' . $pessoa["nm_pessoa"] . '</option>';
                    }
                $retorno .= '                   </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="col-sm-3"><div class="panel-body"><a href="#" class="'. $zera .' btn btn-danger">X</a></div></div>
                            </div>';
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    public function removerAditivoPorContrato(PDO $pdo){
        
        try {
            
            $dao = new DaoFinGestor();
            $dao->setIdContrato($this->idContrato);
            $dao->retornaTodosPorContrato($pdo);
           
            if($dao->sucesso()){
                if(empty($dao->getMsgRetorno())){
                    $this->sucesso = true;
                    $this->msgRetorno = "Não existe Gestor Para Esse Contrato";
                    return;
                }
                
                $result = $dao->getMsgRetorno();                
                foreach ($result as $key => $value) {
                    
                    $dao->setIdGestor($value['id_gestor']);
                    $dao->retorna($pdo);
                                                            
                    if(!$dao->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        return; 
                    }
                    
                    $busca = $dao->getMsgRetorno();
                    $dao->setIdGestor($busca['id_gestor']);                   
                    
                    if (!Log::SalvaLogD('fin_gestor', $dao->getIdGestor(), $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = "Não foi possível localizar o Gestor, LOG";
                        return; 
                    }
                    
                    $dao->delete($pdo);                   
                    
                    if(!$dao->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        return; 
                    }                                                           
                }               
                               
                $this->sucesso = true;
                $this->msgRetorno = "ok";
                return;
            }else{
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
            } 
            
            $this->sucesso = false;
            $this->msgRetorno = "Não foi possível excluir os Sub Fiscais";
            return;                                                                        
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
        
    }

    public function retornarGestoresContrato($tipo = null) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinGestor = new DaoFinGestor();
            $daoFinGestor->setIdContrato($this->idContrato);

            $daoFinGestor->retornaTodosPorContrato($pdo);
            $retorno = array();
            foreach ($daoFinGestor->getMsgRetorno() as $gestor) {
                if ($gestor['tp_gestor'] == $tipo) {
                    $retorno[] = $gestor;
                }
            }
            return $retorno;
        } catch (Exception $ex){
            return $ex->getMessage();
        }
    }

    public function deleteGestorContrato() {
        try {
            if (empty($this->idGestor)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinGestor = new DaoFinGestor();
            $daoFinGestor->setIdGestor($this->idGestor);

            $daoFinGestor->delete($pdo);
            if (!$daoFinGestor->sucesso()) {
                return Metodos::retornoAjax('Erro', 'alert', $daoFinGestor->getMsgRetorno());
            }

            if (!Log::SalvaLogD('fin_gestor', $this->idGestor, $pdo)) {
                return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
            }

            return $daoFinGestor->sucesso();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
