<?php
class FinsQddValorTb {
	private $idQddValor = null;
	private $idQdd = null;
	private $idFonte = null;
	private $idProgramaTrabalho = null;
	private $idDespesaElemento = null;
	private $vlQddInical = null;
	private $vlQddSuplementado = null;
	private $vlQddReduzido = null;
	private $vlEmpenhado = null;
	private $vlBloqueado = null;
	private $vlLiberado = null;
	private $vlSaldo = null;
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
	public function getIdQdd() {
		return $this->idQdd;
	}

	/**
	 * @param mixed $idQdd
	 *
	 * @return self
	 */
	public function setIdQdd($idQdd) {
		$this->idQdd = $idQdd;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdFonte() {
		return $this->idFonte;
	}

	/**
	 * @param mixed $idFonte
	 *
	 * @return self
	 */
	public function setIdFonte($idFonte) {
		$this->idFonte = $idFonte;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdProgramaTrabalho() {
		return $this->idProgramaTrabalho;
	}

	/**
	 * @param mixed $idProgramaTrabalho
	 *
	 * @return self
	 */
	public function setIdProgramaTrabalho($idProgramaTrabalho) {
		$this->idProgramaTrabalho = $idProgramaTrabalho;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdDespesaElemento() {
		return $this->idDespesaElemento;
	}

	/**
	 * @param mixed $idDespesaElemento
	 *
	 * @return self
	 */
	public function setIdDespesaElemento($idDespesaElemento) {
		$this->idDespesaElemento = $idDespesaElemento;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlQddInical() {
		return $this->vlQddInical;
	}

	/**
	 * @param mixed $vlQddInical
	 *
	 * @return self
	 */
	public function setVlQddInical($vlQddInical) {
		$this->vlQddInical = $vlQddInical;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlQddSuplementado() {
		return $this->vlQddSuplementado;
	}

	/**
	 * @param mixed $vlQddSuplementado
	 *
	 * @return self
	 */
	public function setVlQddSuplementado($vlQddSuplementado) {
		$this->vlQddSuplementado = $vlQddSuplementado;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlQddReduzido() {
		return $this->vlQddReduzido;
	}

	/**
	 * @param mixed $vlQddReduzido
	 *
	 * @return self
	 */
	public function setVlQddReduzido($vlQddReduzido) {
		$this->vlQddReduzido = $vlQddReduzido;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlEmpenhado() {
		return $this->vlEmpenhado;
	}

	/**
	 * @param mixed $vlEmpenhado
	 *
	 * @return self
	 */
	public function setVlEmpenhado($vlEmpenhado) {
		$this->vlEmpenhado = $vlEmpenhado;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlBloqueado() {
		return $this->vlBloqueado;
	}

	/**
	 * @param mixed $vlBloqueado
	 *
	 * @return self
	 */
	public function setVlBloqueado($vlBloqueado) {
		$this->vlBloqueado = $vlBloqueado;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlLiberado() {
		return $this->vlLiberado;
	}

	/**
	 * @param mixed $vlLiberado
	 *
	 * @return self
	 */
	public function setVlLiberado($vlLiberado) {
		$this->vlLiberado = $vlLiberado;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVlSaldo() {
		return $this->vlSaldo;
	}

	/**
	 * @param mixed $vlSaldo
	 *
	 * @return self
	 */
	public function setVlSaldo($vlSaldo) {
		$this->vlSaldo = $vlSaldo;

		return $this;
	}
}