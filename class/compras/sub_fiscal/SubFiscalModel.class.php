<?php
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
}