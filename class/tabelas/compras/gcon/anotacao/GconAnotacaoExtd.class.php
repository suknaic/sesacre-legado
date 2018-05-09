<?php
/**
 * Description of GconAnotacaoExtd
 *
 * @author elivelton
 */
class GcoAnotacaoExtd {
    private $idProcesso = null;
    private $situacao = null;
    private $user = null;
    private $tecnico = null;
    private $Anotacao = null;
    
    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getUser() {
        return $this->user;
    }

    function getTecnico() {
        return $this->tecnico;
    }

    function getAnotacao() {
        return $this->Anotacao;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setTecnico($tecnico) {
        $this->tecnico = $tecnico;
    }

    function setAnotacao($Anotacao) {
        $this->Anotacao = $Anotacao;
    }


}
