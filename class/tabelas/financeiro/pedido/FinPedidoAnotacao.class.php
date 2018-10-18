<?php


class FinPedidoAnotacao {

    private $idPedidoAnotacao = null;
    private $dhPedidoAnotacao = null;
    private $dsPedidoAnotacao = null;
    private $idPessoa = null;
    private $idPedido = null;    
    
    function getIdPedidoAnotacao() {
        return $this->idPedidoAnotacao;
    }

    function getDhPedidoAnotacao() {
        return $this->dhPedidoAnotacao;
    }

    function getDsPedidoAnotacao() {
        return $this->dsPedidoAnotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function setIdPedidoAnotacao($idPedidoAnotacao) {
        $this->idPedidoAnotacao = $idPedidoAnotacao;
        return $this;
    }

    function setDhPedidoAnotacao($dhPedidoAnotacao) {
        $this->dhPedidoAnotacao = $dhPedidoAnotacao;
        return $this;
    }

    function setDsPedidoAnotacao($dsPedidoAnotacao) {
        $this->dsPedidoAnotacao = $dsPedidoAnotacao;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
        return $this;
    }        
}