<?php

class ChaCategoriaSecundaria {

    private $idCategoriaSecundaria = null;
    private $idCategoriaPrimaria = null;
    private $nmCategoriaSecundaria = null;
    private $vlCategoriaSecundaria = null;
    private $stAtivo = null;

    /**
     * nm_categoria_secundaria: Criar Usuário, Redefinir Senha, Formatação, Troca de Tonner
     * vl_categoria_secundaria: Valor para criar usuário, valor de uma formatação
     */
    function getIdCategoriaSecundaria() {
        return $this->idCategoriaSecundaria;
    }

    function getIdCategoriaPrimaria() {
        return $this->idCategoriaPrimaria;
    }

    function getNmCategoriaSecundaria() {
        return $this->nmCategoriaSecundaria;
    }

    function getVlCategoriaSecundaria() {
        return $this->vlCategoriaSecundaria;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCategoriaSecundaria($idCategoriaSecundaria) {
        $this->idCategoriaSecundaria = $idCategoriaSecundaria;
    }

    function setIdCategoriaPrimaria($idCategoriaPrimaria) {
        $this->idCategoriaPrimaria = $idCategoriaPrimaria;
    }

    function setNmCategoriaSecundaria($nmCategoriaSecundaria) {
        $this->nmCategoriaSecundaria = $nmCategoriaSecundaria;
    }

    function setVlCategoriaSecundaria($vlCategoriaSecundaria) {
        $this->vlCategoriaSecundaria = $vlCategoriaSecundaria;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

}
