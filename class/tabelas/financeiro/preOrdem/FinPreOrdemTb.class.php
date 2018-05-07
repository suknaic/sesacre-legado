<?php

class FinPreOrdemTb {

	private $idPreOrdem = null;
	private $idContItens = null;
	private $idPedido = null;
	private $idFornecedor = null;
	private $qtItensPre = null;
	private $vlItensPre = null;

	function getIdPreOrdem() {
		return $this->idPreOrdem;
	}

	function getIdContItens() {
		return $this->idContItens;
	}

	function getIdPedido() {
		return $this->idPedido;
	}

	function getIdFornecedor() {
		return $this->idFornecedor;
	}

	function getQtItensPre() {
		return $this->qtItensPre;
	}

	function getVlItensPre() {
		return $this->vlItensPre;
	}

	function setIdPreOrdem($idPreOrdem) {
		$this->idPreOrdem = $idPreOrdem;
	}

	function setIdContItens($idContItens) {
		$this->idContItens = $idContItens;
	}

	function setIdPedido($idPedido) {
		$this->idPedido = $idPedido;
	}

	function setIdFornecedor($idFornecedor) {
		$this->idFornecedor = $idFornecedor;
	}

	function setQtItensPre($qtItensPre) {
		$this->qtItensPre = $qtItensPre;
	}

	function setVlItensPre($vlItensPre) {
		$this->vlItensPre = $vlItensPre;
	}

}
