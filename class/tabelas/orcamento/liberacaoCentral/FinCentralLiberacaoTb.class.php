<?php

class FinCentralLiberacaoTb {

	private $id_central_liberacao = null;
	private $dh_central_liberacao = null;
	private $ds_central_liberacao = null;
	private $tp_central_liberacao = null;
	private $id_pessoa = null;
	private $id_lotacao = null;
	private $st_central_liberacao = null;
	private $id_pessoa_valida = null;
	private $id_tipo_gasto = null;

	/**
	 * @return mixed
	 */
	public function getIdCentralLiberacao() {
		return $this->id_central_liberacao;
	}

	/**
	 * @param mixed $id_central_liberacao
	 *
	 * @return self
	 */
	public function setIdCentralLiberacao($id_central_liberacao) {
		$this->id_central_liberacao = $id_central_liberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDhCentralLiberacao() {
		return $this->dh_central_liberacao;
	}

	/**
	 * @param mixed $dh_central_liberacao
	 *
	 * @return self
	 */
	public function setDhCentralLiberacao($dh_central_liberacao) {
		$this->dh_central_liberacao = $dh_central_liberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDsCentralLiberacao() {
		return $this->ds_central_liberacao;
	}

	/**
	 * @param mixed $ds_central_liberacao
	 *
	 * @return self
	 */
	public function setDsCentralLiberacao($ds_central_liberacao) {
		$this->ds_central_liberacao = $ds_central_liberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTpCentralLiberacao() {
		return $this->tp_central_liberacao;
	}

	/**
	 * @param mixed $tp_central_liberacao
	 *
	 * @return self
	 */
	public function setTpCentralLiberacao($tp_central_liberacao) {
		$this->tp_central_liberacao = $tp_central_liberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdPessoa() {
		return $this->id_pessoa;
	}

	/**
	 * @param mixed $id_pessoa
	 *
	 * @return self
	 */
	public function setIdPessoa($id_pessoa) {
		$this->id_pessoa = $id_pessoa;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdLotacao() {
		return $this->id_lotacao;
	}

	/**
	 * @param mixed $id_lotacao
	 *
	 * @return self
	 */
	public function setIdLotacao($id_lotacao) {
		$this->id_lotacao = $id_lotacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStCentralLiberacao() {
		return $this->st_central_liberacao;
	}

	/**
	 * @param mixed $st_central_liberacao
	 *
	 * @return self
	 */
	public function setStCentralLiberacao($st_central_liberacao) {
		$this->st_central_liberacao = $st_central_liberacao;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdPessoaValida() {
		return $this->id_pessoa_valida;
	}

	/**
	 * @param mixed $id_pessoa_valida
	 *
	 * @return self
	 */
	public function setIdPessoaValida($id_pessoa_valida) {
		$this->id_pessoa_valida = $id_pessoa_valida;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdTipoGasto() {
		return $this->id_tipo_gasto;
	}

	/**
	 * @param mixed $id_tipo_gasto
	 *
	 * @return self
	 */
	public function setIdTipoGasto($id_tipo_gasto) {
		$this->id_tipo_gasto = $id_tipo_gasto;

		return $this;
	}
}