<?php

class FinPedidoSituacao {

    private $id_pedido_situacao = null;
    private $nm_pedido_situacao = null;
    private $st_ativo = null;

    function getIdPedidoSituacao() {
        return $this->id_pedido_situacao;
    }

    function getNmPedidoSituacao() {
        return $this->nm_pedido_situacao;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPedidoSituacao($id_pedido_situacao) {
        $this->id_pedido_situacao = $id_pedido_situacao;
        return $this;
    }

    function setNmPedidoSituacao($nm_pedido_situacao) {
        $this->nm_pedido_situacao = $nm_pedido_situacao;
        return $this;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }


}
