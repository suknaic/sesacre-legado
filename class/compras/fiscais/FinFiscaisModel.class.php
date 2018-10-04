<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinFiscal.class.php";
class FinFiscaisModel {
	private $idFiscal = null;
	private $idContrato = null;
	private $idPessoa = null;
	private $tpFiscal = null;
	private $dtIniFiscal = null;
	private $dtFimFiscal = null;
	private $sitAtivo = null;
	private $sucesso = false;
	private $msgRetorno = null;

	/**
	 * @return mixed
	 */
	public function getIdFiscal() {
		return $this->idFiscal;
	}

	/**
	 * @param mixed $idFiscal
	 *
	 * @return self
	 */
	public function setIdFiscal($idFiscal) {
		$this->idFiscal = $idFiscal;

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
	public function getTpFiscal() {
		return $this->tpFiscal;
	}

	/**
	 * @param mixed $tpFiscal
	 *
	 * @return self
	 */
	public function setTpFiscal($tpFiscal) {
		$this->tpFiscal = $tpFiscal;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDtIniFiscal() {
		return $this->dtIniFiscal;
	}

	/**
	 * @param mixed $dtIniFiscal
	 *
	 * @return self
	 */
	public function setDtIniFiscal($dtIniFiscal) {
		$this->dtIniFiscal = $dtIniFiscal;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDtFimFiscal() {
		return $this->dtFimFiscal;
	}

	/**
	 * @param mixed $dtFimFiscal
	 *
	 * @return self
	 */
	public function setDtFimFiscal($dtFimFiscal) {
		$this->dtFimFiscal = $dtFimFiscal;

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

	public function cadastraFiscal($pdo = null) {
		try {
			$this->idPessoa = (is_numeric($this->idPessoa)) ? $this->idPessoa : null;
			$this->idContrato = (is_numeric($this->idContrato)) ? $this->idContrato : null;
			$this->tpFiscal = (is_numeric($this->tpFiscal)) ? $this->tpFiscal : null;
			$this->dtIniFiscal = (is_numeric($this->dtIniFiscal)) ? $this->dtIniFiscal : null;
			$this->dtFimFiscal = (is_numeric($this->dtFimFiscal)) ? $this->dtFimFiscal : null;
			if (!empty($this->idAta) || !empty($this->idContrato) && !empty($this->idPessoa) && !empty($this->tpFiscal)) {
				$daoFinFiscal = new DaoFinFiscal();
				$daoFinFiscal->setIdPessoa($this->idPessoa);
				$daoFinFiscal->setIdContrato($this->idContrato);
				$daoFinFiscal->setTpFiscal($this->tpFiscal);
				$daoFinFiscal->setDtIniFiscal(date('Y-m-d'));
				$daoFinFiscal->insertFiscal($pdo);
				if ($daoFinFiscal->sucesso()) {
					$daoFinFiscal->setIdFiscal($pdo->lastInsertId('fin_fiscal_id_fiscal_seq'));
					$this->sucesso = true;
					if (!Log::SalvaLogI('fin_fiscal', $daoFinFiscal->getIdFiscal(), $pdo)) {
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
        
        public function cadastraFiscalAditivo($pdo = null) {
            try {
                
                $this->idPessoa = (is_numeric($this->idPessoa)) ? $this->idPessoa : null;
                $this->idContrato = (is_numeric($this->idContrato)) ? $this->idContrato : null;
                $this->tpFiscal = (is_numeric($this->tpFiscal)) ? $this->tpFiscal : null;
                $this->dtIniFiscal = (!empty($this->dtIniFiscal)) ? $this->dtIniFiscal : null;
                $this->dtFimFiscal = (!empty($this->dtFimFiscal)) ? $this->dtFimFiscal : null;
                if (!empty($this->idContrato) && !empty($this->idPessoa) && !empty($this->tpFiscal)) {                    
                    $daoFinFiscal = new DaoFinFiscal();
                    $daoFinFiscal->setIdPessoa($this->idPessoa);
                    $daoFinFiscal->setIdContrato($this->idContrato);
                    $daoFinFiscal->setTpFiscal($this->tpFiscal);
                    $daoFinFiscal->setDtIniFiscal($this->dtIniFiscal);
                    $daoFinFiscal->insertFiscal($pdo);
                    if ($daoFinFiscal->sucesso()) {
                        $daoFinFiscal->setIdFiscal($pdo->lastInsertId('fin_fiscal_id_fiscal_seq'));
                        $this->sucesso = true;
                        if (!Log::SalvaLogI('fin_fiscal', $daoFinFiscal->getIdFiscal(), $pdo)) {
                            $this->sucesso = false;
                            $this->msgRetorno = 'erro log';
                        }
                    }else{
                        $this->sucesso = false;
                        $this->msgRetorno = $daoFinFiscal->getMsgRetorno();
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
            
            $dao = new DaoFinFiscal();
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
                    
                    $dao->setIdFiscal($value['id_fiscal']);
                    $dao->retorna($pdo);
                                                            
                    if(!$dao->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        return; 
                    }
                    
                    $busca = $dao->getMsgRetorno();
                    $dao->setIdFiscal($busca['id_fiscal']);                   
                    
                    if (!Log::SalvaLogD('fin_fiscal', $dao->getIdFiscal(), $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = "Não foi possível localizar o Fiscal, LOG";
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

    public function retornarFiscal($idFornecedor, $tp) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinFiscal = new DaoFinFiscal();
            $pf = new pessoaFisica();
            $pessoaFisica = $pf->retornaTodasPF();

            $daoFinFiscal->retornaTodosFiscaisPorContrato($idFornecedor, $tp, $pdo);
            $fiscais = $daoFinFiscal->getMsgRetorno();
            $retorno = '';

            if ($tp == 1) {
                $class = "selectFiscais";
                $classPrincipal = "fiscaisCampos";
                $id = "fiscais";
                $nomeCampo = 'Fiscal Titular:';
            } else {
                $class = "selectFiscaisSub";
                $classPrincipal = "fiscaisSubCampos";
                $id = "fiscaisSub";
                $nomeCampo = 'Fiscal Substituto:';
            }

            if ($daoFinFiscal->sucesso()) {
                foreach ($fiscais as $fiscal) {

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
                            if ($v['id_pessoa'] == $fiscal['id_pessoa']) {
                                $retorno .= "       <option selected value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                            } else {
                                $retorno .= "       <option value = '" . $v['id_pessoa'] . "'>" . $v['nm_pessoa'] . "</option>";
                            }
                        }
                    $retorno .= '                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="col-sm-3">
                                    <div class="panel-body">
                                        <a href="#" class="removeFiscais btn btn-danger" idFiscal = "' . $fiscal['id_fiscal'] . '">X</a>
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
                        $retorno .= '               <option value = "' . $pessoa['id_pessoa'] . '">' . $pessoa["nm_pessoa"] . '</option>';
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

    public function retornarFiscaisContrato($tipo = null) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinFiscal = new DaoFinFiscal();
            $daoFinFiscal->setIdContrato($this->idContrato);

            $daoFinFiscal->retornaTodosPorContrato($pdo);
            $retorno = array();
            foreach ($daoFinFiscal->getMsgRetorno() as $fiscal) {
                if ($fiscal['tp_fiscal'] == $tipo) {
                    $retorno[] = $fiscal;
                }
            }
            return $retorno;
        } catch (Exception $ex){
            return $ex->getMessage();
        }
    }

    public function deleteFiscalContrato() {
        try {
            if (empty($this->idFiscal)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinFiscal = new DaoFinFiscal();
            $daoFinFiscal->setIdFiscal($this->idFiscal);

            $daoFinFiscal->delete($pdo);
            if (!$daoFinFiscal->sucesso()) {
                return Metodos::retornoAjax('Erro', 'alert', $daoFinFiscal->getMsgRetorno());
            }

            if (!Log::SalvaLogD('fin_fiscal', $this->idFiscal, $pdo)) {
                return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
            }

            return $daoFinFiscal->sucesso();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}