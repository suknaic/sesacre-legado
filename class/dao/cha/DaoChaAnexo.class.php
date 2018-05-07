<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaAnexo.class.php";

class DaoChaAnexo extends ChaAnexo {
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function getSucesso() {
        return $this->sucesso;
    }
}