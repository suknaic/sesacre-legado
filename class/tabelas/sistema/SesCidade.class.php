<?php

class SesCidade{
    
    private $id_cidade = null;
    private $id_estado = null;
    private $id_regional_saude = null;
    private $id_regional_geo = null;
    private $nm_cidade = null;
    private $st_ativo = null;
    private $nm_uf = null;

    //*************************
    private $sucess = null;
    //*************************

    //*************************
    function getNm_uf() {
        return $this->nm_uf;
    }

    function setNm_uf($nm_uf) {
        $this->nm_uf = $nm_uf;
    }

        function getId_cidade() {
        return $this->id_cidade;
    }

    function getId_estado() {
        return $this->id_estado;
    }

    function getId_regional_saude() {
        return $this->id_regional_saude;
    }

    function getId_regional_geo() {
        return $this->id_regional_geo;
    }

    function getNm_cidade() {
        return $this->nm_cidade;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setId_estado($id_estado) {
        $this->id_estado = $id_estado;
    }

    function setId_regional_saude($id_regional_saude) {
        $this->id_regional_saude = $id_regional_saude;
    }

    function setId_regional_geo($id_regional_geo) {
        $this->id_regional_geo = $id_regional_geo;
    }

    function setNm_cidade($nm_cidade) {
        $this->nm_cidade = $nm_cidade;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    /**
     * @return null
     */
    public function getSucess()
    {
        return $this->sucess;
    }

    /**
     * @param null $sucess
     */
    public function setSucess($sucess)
    {
        $this->sucess = $sucess;
    }

}
