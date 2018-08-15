<?php

class FinDocTramitacao {

    private $idDocTramitacao = null;
    private $idDocumentoFiscal = null;
    private $idPessoa = null;
    private $dhDocTramitacao = null;
    private $dsDocTramitacao = null;
    private $idLotacaoOrigem = null;
    private $idLotacaoDestino = null;
    private $idDocumentoSituacao = null;


    public function getIdDocTramitacao()
    {
        return $this->idDocTramitacao;
    }

    public function setIdDocTramitacao($idDocTramitacao)
    {
        $this->idDocTramitacao = $idDocTramitacao;

        return $this;
    }

    public function getIdDocumentoFiscal()
    {
        return $this->idDocumentoFiscal;
    }


    public function setIdDocumentoFiscal($idDocumentoFiscal)
    {
        $this->idDocumentoFiscal = $idDocumentoFiscal;

        return $this;
    }


    public function getIdPessoa()
    {
        return $this->idPessoa;
    }


    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;

        return $this;
    }

 
    public function getDhDocTramitacao()
    {
        return $this->dhDocTramitacao;
    }

 
    public function setDhDocTramitacao($dhDocTramitacao)
    {
        $this->dhDocTramitacao = $dhDocTramitacao;

        return $this;
    }


    public function getDsDocTramitacao()
    {
        return $this->dsDocTramitacao;
    }


    public function setDsDocTramitacao($dsDocTramitacao)
    {
        $this->dsDocTramitacao = $dsDocTramitacao;

        return $this;
    }


    public function getIdLotacaoOrigem()
    {
        return $this->idLotacaoOrigem;
    }


    public function setIdLotacaoOrigem($idLotacaoOrigem)
    {
        $this->idLotacaoOrigem = $idLotacaoOrigem;

        return $this;
    }


    public function getIdLotacaoDestino()
    {
        return $this->idLotacaoDestino;
    }


    public function setIdLotacaoDestino($idLotacaoDestino)
    {
        $this->idLotacaoDestino = $idLotacaoDestino;

        return $this;
    }


    public function getIdDocumentoSituacao()
    {
        return $this->idDocumentoSituacao;
    }


    public function setIdDocumentoSituacao($idDocumentoSituacao)
    {
        $this->idDocumentoSituacao = $idDocumentoSituacao;

        return $this;
    }
}

