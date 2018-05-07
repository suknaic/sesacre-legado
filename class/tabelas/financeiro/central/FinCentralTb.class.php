<?php
class FinCentralTb {
	private $id_central_demanda = null;
	private $id_lotacao = null;
	/**
	 * @return mixed
	 */
	public function getIdCentralDemanda() {
		return $this->id_central_demanda;
	}

	/**
	 * @param mixed $id_central_demanda
	 *
	 * @return self
	 */
	public function setIdCentralDemanda($id_central_demanda) {
		$this->id_central_demanda = $id_central_demanda;

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
}
