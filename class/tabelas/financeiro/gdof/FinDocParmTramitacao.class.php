<?php

class FinDocParmTramitacao {

    private $idDocParmTramitacao = null;
    private $idDocTipoRemetente = null;
    private $idDocTipoDestinatario = null;
    private $tpDocParmTramitacao = null;
    private $idDocumentoSituacao = null;
    

    /**
     * Get the value of idDocParmTramitacao
     */ 
    public function getIdDocParmTramitacao()
    {
        return $this->idDocParmTramitacao;
    }

    /**
     * Set the value of idDocParmTramitacao
     *
     * @return  self
     */ 
    public function setIdDocParmTramitacao($idDocParmTramitacao)
    {
        $this->idDocParmTramitacao = $idDocParmTramitacao;

        return $this;
    }

    /**
     * Get the value of idDocTipoRemetente
     */ 
    public function getIdDocTipoRemetente()
    {
        return $this->idDocTipoRemetente;
    }

    /**
     * Set the value of idDocTipoRemetente
     *
     * @return  self
     */ 
    public function setIdDocTipoRemetente($idDocTipoRemetente)
    {
        $this->idDocTipoRemetente = $idDocTipoRemetente;

        return $this;
    }

    /**
     * Get the value of idDocTipoDestinatario
     */ 
    public function getIdDocTipoDestinatario()
    {
        return $this->idDocTipoDestinatario;
    }

    /**
     * Set the value of idDocTipoDestinatario
     *
     * @return  self
     */ 
    public function setIdDocTipoDestinatario($idDocTipoDestinatario)
    {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;

        return $this;
    }

    /**
     * Get the value of tpDocParmTramitacao
     */ 
    public function getTpDocParmTramitacao()
    {
        return $this->tpDocParmTramitacao;
    }

    /**
     * Set the value of tpDocParmTramitacao
     *
     * @return  self
     */ 
    public function setTpDocParmTramitacao($tpDocParmTramitacao)
    {
        $this->tpDocParmTramitacao = $tpDocParmTramitacao;

        return $this;
    }

    /**
     * Get the value of idDocumentoSituacao
     */ 
    public function getIdDocumentoSituacao()
    {
        return $this->idDocumentoSituacao;
    }

    /**
     * Set the value of idDocumentoSituacao
     *
     * @return  self
     */ 
    public function setIdDocumentoSituacao($idDocumentoSituacao)
    {
        $this->idDocumentoSituacao = $idDocumentoSituacao;

        return $this;
    }
}