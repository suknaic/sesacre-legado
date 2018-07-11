<?php
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
}