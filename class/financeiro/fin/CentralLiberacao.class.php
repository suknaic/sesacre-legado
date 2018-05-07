<?php
class CentralLiberacao {
	private $idCentralLiberacao = null;
	private $vlCentralLiberacao = null;
	private $dhCentralLiberacao = null;
	private $dsCentralLiberacao = null;
	private $idPessoa = null;
	private $idQddValor = null;
	private $idLotacao = null;
	private $idConvenio = null;
	private $idPortaria = null;

	/**
	 * @return mixed
	 */
	public function getIdCentralLiberacao() {
		return $this->idCentralLiberacao;
	}

	/**
	 * @param mixed $idCentralLiberacao
	 *
	 * @return self
	 */
	public function setIdCentralLiberacao($idCentralLiberacao) {
		$this->idCentralLiberacao = $idCentralLiberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlCentralLiberacao() {
		return $this->vlCentralLiberacao;
	}

	/**
	 * @param mixed $vlCentralLiberacao
	 *
	 * @return self
	 */
	public function setVlCentralLiberacao($vlCentralLiberacao) {
		$this->vlCentralLiberacao = $vlCentralLiberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDhCentralLiberacao() {
		return $this->dhCentralLiberacao;
	}

	/**
	 * @param mixed $dhCentralLiberacao
	 *
	 * @return self
	 */
	public function setDhCentralLiberacao($dhCentralLiberacao) {
		$this->dhCentralLiberacao = $dhCentralLiberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDsCentralLiberacao() {
		return $this->dsCentralLiberacao;
	}

	/**
	 * @param mixed $dsCentralLiberacao
	 *
	 * @return self
	 */
	public function setDsCentralLiberacao($dsCentralLiberacao) {
		$this->dsCentralLiberacao = $dsCentralLiberacao;

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
	public function getIdQddValor() {
		return $this->idQddValor;
	}

	/**
	 * @param mixed $idQddValor
	 *
	 * @return self
	 */
	public function setIdQddValor($idQddValor) {
		$this->idQddValor = $idQddValor;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdLotacao() {
		return $this->idLotacao;
	}

	/**
	 * @param mixed $idLotacao
	 *
	 * @return self
	 */
	public function setIdLotacao($idLotacao) {
		$this->idLotacao = $idLotacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdConvenio() {
		return $this->idConvenio;
	}

	/**
	 * @param mixed $idConvenio
	 *
	 * @return self
	 */
	public function setIdConvenio($idConvenio) {
		$this->idConvenio = $idConvenio;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdPortaria() {
		return $this->idPortaria;
	}

	/**
	 * @param mixed $idPortaria
	 *
	 * @return self
	 */
	public function setIdPortaria($idPortaria) {
		$this->idPortaria = $idPortaria;

		return $this;
	}
}