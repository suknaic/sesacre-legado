<?php

class DaoTipoGastoDespesaElemento {

    private $sucesso = true;
    private $msgRetorno = null;

    public function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

}
