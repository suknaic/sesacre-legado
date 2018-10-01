<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinSubFiscal.class.php";

class SubFiscalModel {
    private $idSubFiscal = null;
    private $idContrato = null;
    private $idPessoa = null;
    private $tpSubFiscal = null;
    private $dtIniSubFiscal = null;
    private $dtFimSubFiscal = null;
    private $sitAtivo = null;
    private $sucesso = false;
    private $msgRetorno = null;

    function getIdSubFiscal() {
            return $this->idSubFiscal;
    }

    function getIdContrato() {
            return $this->idContrato;
    }

    function getIdPessoa() {
            return $this->idPessoa;
    }

    function getTpSubFiscal() {
            return $this->tpSubFiscal;
    }

    function getDtIniSubFiscal() {
            return $this->dtIniSubFiscal;
    }

    function getDtFimSubFiscal() {
            return $this->dtFimSubFiscal;
    }

    function getSitAtivo() {
            return $this->sitAtivo;
    }

    function setIdSubFiscal($idSubFiscal) {
            $this->idSubFiscal = $idSubFiscal;
    }

    function setIdContrato($idContrato) {
            $this->idContrato = $idContrato;
    }

    function setIdPessoa($idPessoa) {
            $this->idPessoa = $idPessoa;
    }

    function setTpSubFiscal($tpSubFiscal) {
            $this->tpSubFiscal = $tpSubFiscal;
    }

    function setDtIniSubFiscal($dtIniSubFiscal) {
            $this->dtIniSubFiscal = $dtIniSubFiscal;
    }

    function setDtFimSubFiscal($dtFimSubFiscal) {
            $this->dtFimSubFiscal = $dtFimSubFiscal;
    }

    function setSitAtivo($sitAtivo) {
            $this->sitAtivo = $sitAtivo;
    }

    public function sucesso() {
            return $this->sucesso;
    }

    public function getMsgRetorno() {
            return $this->msgRetorno;
    }

    public function cadastraSubFiscal($pdo = null) {
        try {
            $this->idPessoa = (is_numeric($this->idPessoa)) ? $this->idPessoa : null;
            $this->idContrato = (is_numeric($this->idContrato)) ? $this->idContrato : null;
            $this->tpSubFiscal = (is_numeric($this->tpSubFiscal)) ? $this->tpSubFiscal : null;
            $this->dtIniSubFiscal = (is_numeric($this->dtIniSubFiscal)) ? $this->dtIniSubFiscal : null;
            $this->dtFimSubFiscal = (is_numeric($this->dtFimSubFiscal)) ? $this->dtFimSubFiscal : null;

            if (!empty($this->idAta) || !empty($this->idContrato) && !empty($this->idPessoa) && !empty($this->tpSubFiscal)) {

                $daoFinSubFiscal = new DaoFinSubFiscal();
                $daoFinSubFiscal->setIdPessoa($this->idPessoa);
                $daoFinSubFiscal->setIdContrato($this->idContrato);
                $daoFinSubFiscal->setTpSubFiscal($this->tpSubFiscal);
                $daoFinSubFiscal->setDtIniSubFiscal(date('Y-m-d'));
                $daoFinSubFiscal->insertSubFiscal($pdo);
                if ($daoFinSubFiscal->sucesso()) {
                        $daoFinSubFiscal->setIdSubFiscal($pdo->lastInsertId('fin_sub_fiscal_id_sub_fiscal_seq'));
                        $this->sucesso = true;
                        if (!Log::SalvaLogI('fin_sub_fiscal', $daoFinSubFiscal->getIdSubFiscal(), $pdo)) {
                                $this->sucesso = false;
                                $this->msgRetorno = 'erro log';
                        }
                }

            } else {
                    $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function cadastraSubFiscalAditivo($pdo = null) {
        try {
            $this->idPessoa = (is_numeric($this->idPessoa)) ? $this->idPessoa : null;
            $this->idContrato = (is_numeric($this->idContrato)) ? $this->idContrato : null;
            $this->tpSubFiscal = (is_numeric($this->tpSubFiscal)) ? $this->tpSubFiscal : null;
            $this->dtIniSubFiscal = (!empty($this->dtIniSubFiscal)) ? $this->dtIniSubFiscal : null;
            $this->dtFimSubFiscal = (!empty($this->dtFimSubFiscal)) ? $this->dtFimSubFiscal : null;
            if (!empty($this->idContrato) && !empty($this->idPessoa) && !empty($this->tpSubFiscal)) {                    
                $daoFinSubFiscal = new DaoFinSubFiscal();
                $daoFinSubFiscal->setIdPessoa($this->idPessoa);
                $daoFinSubFiscal->setIdContrato($this->idContrato);
                $daoFinSubFiscal->setTpSubFiscal($this->tpSubFiscal);
                $daoFinSubFiscal->setDtIniSubFiscal($this->dtIniSubFiscal);
                $daoFinSubFiscal->insertSubFiscal($pdo);
                if ($daoFinSubFiscal->sucesso()) {
                    $daoFinSubFiscal->setIdSubFiscal($pdo->lastInsertId('fin_sub_fiscal_id_sub_fiscal_seq'));
                    $this->sucesso = true;
                    if (!Log::SalvaLogI('fin_sub_fiscal', $daoFinSubFiscal->getIdSubFiscal(), $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = 'erro log';
                        return;
                    }
                }else{
                    $this->sucesso = false;
                    $this->msgRetorno = $daoFinSubFiscal->getMsgRetorno();
                    return;
                } 
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function removerAditivoPorContrato(PDO $pdo){
        
        try {
            
            $dao = new DaoFinSubFiscal();
            $dao->setIdContrato($this->idContrato);
            $dao->retornaTodosPorContrato($pdo);
           
            if($dao->sucesso()){
                if(empty($dao->getMsgRetorno())){
                    $this->sucesso = true;
                    $this->msgRetorno = "Não existe Sub Fiscal Para Esse Contrato";
                    return;
                }
                
                $result = $dao->getMsgRetorno();                
                foreach ($result as $key => $value) {
                    
                    $dao->setIdSubFiscal($value['id_sub_fiscal']);
                    $dao->retorna($pdo);
                                                            
                    if(!$dao->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        return; 
                    }
                    
                    $busca = $dao->getMsgRetorno();
                    $dao->setIdSubFiscal($busca['id_sub_fiscal']);            
                    
                    if (!Log::SalvaLogD('fin_sub_fiscal', $dao->getIdSubFiscal(), $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = "Não foi possível localizar o Sub Fiscal, LOG";
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

    public function retornarSubFiscal($idFornecedor, $tp) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinSubFiscal = new DaoFinSubFiscal();
            $pf = new pessoaFisica();
            $pessoaFisica = $pf->retornaTodasPF();

            $daoFinSubFiscal->retornaTodosSubFiscaisPorContrato($idFornecedor, $tp, $pdo);
            $subFiscais = $daoFinSubFiscal->getMsgRetorno();
            $retorno = '';

            if ($tp == 1) {
                $class = "selectSubFiscais";
                $classPrincipal = "SubFiscaisCampos";
                $id = "subFiscais";
                $nomeCampo = 'Sub-Fiscal Titular:';
            } else {
                $class = "selectSubFiscaisSub";
                $classPrincipal = "SubFiscaisCamposSub";
                $id = "subFiscaisSub";
                $nomeCampo = 'Sub-Fiscal Substituto:';
            }

            if ($daoFinSubFiscal->sucesso()) {
                foreach ($subFiscais as $subFiscal) {
                    $retorno .= ' <div class="form-group">
                                 <div class="col-sm-5">
                                    <div class="panel-body">
                                        '.$nomeCampo.'
                                        <div class="'.$classPrincipal.'">
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select '. $class.'" name="'.$id.'[]" id="'.$id.'" required="true">
                                                    <option value="">Selecione uma Pessoa</option>';
                    foreach ($pessoaFisica as $v) {
                        if ($v['id_pessoa'] == $subFiscal['id_pessoa']) {
                            $retorno .= "       <option selected value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                        } else {
                            $retorno .= "       <option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                        }
                    }
                    $retorno .= '                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="panel-body">
                                        <a href="#" class="removeFiscais btn btn-danger" idSubFiscal = "' . $subFiscal['id_sub_fiscal'] . '">X</a>
                                    </div>
                                </div>
                            </div>';
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
                    $retorno .= '                <option value = "' . $pessoa['id_pessoa'] . '">' . $pessoa["nm_pessoa"] . '</option>';
                }
                $retorno .= '                   </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            }
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
        
}