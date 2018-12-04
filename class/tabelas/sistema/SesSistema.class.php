<?php

class SesSistema {

    private $idSistema = null;
    private $nmSistema = null;
    private $stAtivo = null;
    
    

    /**
     * Get the value of idSistema
     */ 
    public function getIdSistema()
    {
        return $this->idSistema;
    }

    /**
     * Set the value of idSistema
     *
     * @return  self
     */ 
    public function setIdSistema($idSistema)
    {
        $this->idSistema = $idSistema;

        return $this;
    }

    /**
     * Get the value of nmSistema
     */ 
    public function getNmSistema()
    {
        return $this->nmSistema;
    }

    /**
     * Set the value of nmSistema
     *
     * @return  self
     */ 
    public function setNmSistema($nmSistema)
    {
        $this->nmSistema = $nmSistema;

        return $this;
    }

    /**
     * Get the value of stAtivo
     */ 
    public function getStAtivo()
    {
        return $this->stAtivo;
    }

    /**
     * Set the value of stAtivo
     *
     * @return  self
     */ 
    public function setStAtivo($stAtivo)
    {
        $this->stAtivo = $stAtivo;

        return $this;
    }
}