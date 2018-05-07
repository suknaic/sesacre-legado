<?php

class TipoGastoElementoModel {

	private $id_tipo_gasto_depesa_elemento = null;
	private $id_tipo_gasto = null;
	private $id_despesa_elemento = null;
	private $st_ativo = null;

	/**
	 * @return mixed
	 */
	public function getIdTipoGastoDepesaElemento() {
		return $this->id_tipo_gasto_depesa_elemento;
	}

	/**
	 * @param mixed $id_tipo_gasto_depesa_elemento
	 *
	 * @return self
	 */
	public function setIdTipoGastoDepesaElemento($id_tipo_gasto_depesa_elemento) {
		$this->id_tipo_gasto_depesa_elemento = $id_tipo_gasto_depesa_elemento;

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

	/**
	 * @return mixed
	 */
	public function getIdDespesaElemento() {
		return $this->id_despesa_elemento;
	}

	/**
	 * @param mixed $id_despesa_elemento
	 *
	 * @return self
	 */
	public function setIdDespesaElemento($id_despesa_elemento) {
		$this->id_despesa_elemento = $id_despesa_elemento;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStAtivo() {
		return $this->st_ativo;
	}

	/**
	 * @param mixed $st_ativo
	 *
	 * @return self
	 */
	public function setStAtivo($st_ativo) {
		$this->st_ativo = $st_ativo;

		return $this;
	}

	public function retornaTipoGastoElemento($pdo = null) {
		$retorno = "";
		try {
			if ($pdo == null) {
				$conexao = new Conexao();
				$pdo = $conexao->connect();
			}
			$tg = new DaoPlaTipoGasto();

			$result = $tg->retornaElementoTipoGasto($pdo);

			if (!$result) {
				return $retorno;
			} else {
				//Armazena as informações na variável $retorno com os dados.
				foreach ($result as $v) {
					if ($v['id_despesa_elemento'] == $idDespesaElemento) {
						$retorno .= "<option selected value=" . $v['id_despesa_elemento'] . ">" . $v['cd_despesa_elemento'] . "-" . $v['ds_despesa_elemento'] . "</option>";
					} else {
						$retorno .= "<option value=" . $v['id_despesa_elemento'] . ">" . $v['cd_despesa_elemento'] . "-" . $v['ds_despesa_elemento'] . "</option>";
					}
				}
			}
			return $retorno;
		} catch (Exception $ex) {
			$retorno = "";
		}
	}

}
