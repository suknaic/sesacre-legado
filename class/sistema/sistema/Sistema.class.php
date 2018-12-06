<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesSistema.class.php";

class Sistema {

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

    public function retornaOptionSistemas(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoSesSistema = new DaoSesSistema();
            $daoSesSistema->retornaTodos($pdo);
            
            $opcoes = [];
            if ($daoSesSistema->getSucesso()) {
                foreach ($daoSesSistema->getMsgRetorno() as $linha) {
                    $opcoes[] = (object) array('id' => $linha['id_sistema'], 'nome' => $linha['nm_sistema']);
                }
                return json_encode($opcoes);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}