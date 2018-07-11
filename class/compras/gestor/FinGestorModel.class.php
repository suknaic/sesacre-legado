<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinGestor.class.php";

class FinGestorModel {

    private $idGestor = null;
    private $idPessoa = null;
    private $idContrato = null;
    private $tpGestor = null;
    private $dtIniGestor = null;
    private $dtFimGestor = null;
    private $sitAtivo = null;
    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdGestor() {
        return $this->idGestor;
    }

    /**
     * @param mixed $idGestor
     *
     * @return self
     */
    public function setIdGestor($idGestor) {
        $this->idGestor = $idGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->idPessoa;
    }

    /**
     * @param mixed $idPessoa
     *
     * @return self
     */
    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContrato() {
        return $this->idContrato;
    }

    /**
     * @param mixed $idContrato
     *
     * @return self
     */
    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpGestor() {
        return $this->tpGestor;
    }

    /**
     * @param mixed $tpGestor
     *
     * @return self
     */
    public function setTpGestor($tpGestor) {
        $this->tpGestor = $tpGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniGestor() {
        return $this->dtIniGestor;
    }

    /**
     * @param mixed $dtIniGestor
     *
     * @return self
     */
    public function setDtIniGestor($dtIniGestor) {
        $this->dtIniGestor = $dtIniGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimGestor() {
        return $this->dtFimGestor;
    }

    /**
     * @param mixed $dtFimGestor
     *
     * @return self
     */
    public function setDtFimGestor($dtFimGestor) {
        $this->dtFimGestor = $dtFimGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitAtivo() {
        return $this->sitAtivo;
    }

    /**
     * @param mixed $sitAtivo
     *
     * @return self
     */
    public function setSitAtivo($sitAtivo) {
        $this->sitAtivo = $sitAtivo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadastraGestor($pdo = null, int $idContrato, array $dados, int $tipo = 1) {
        try {
            if ((!is_array($dados) || count($dados) < 1)) {
                $this->msgRetorno = STR_PREENCHER_CAMPOS;
                $this->sucesso = FALSE;
                return false;
            }
            $daoFinGestor = new DaoFinGestor();
            foreach ($dados as $v) {
                $daoFinGestor->setIdPessoa($v);
                $daoFinGestor->setIdContrato($idContrato);
                $daoFinGestor->setTpGestor($tipo);
                $daoFinGestor->setDtIniGestor(date('Y-m-d'));
                $daoFinGestor->insertGestor($pdo);
                //verificar ser deu certo o insert caso sim sucesso passa a ser true
                if ($daoFinGestor->sucesso()) {
                    $daoFinGestor->setIdGestor(is_numeric($pdo->lastInsertId('fin_gestor_id_gestor_seq')) ? $pdo->lastInsertId('fin_gestor_id_gestor_seq') : NULL);
                    $this->sucesso = true;
                }
                
                if (!Log::SalvaLogI('fin_gestor', $daoFinGestor->getIdGestor(), $pdo)) {
                    $this->sucesso = false;
                    $this->msgRetorno = 'erro log';
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function cadastraGestorAditivo($pdo = null) {
        try {            
            $daoFinGestor = new DaoFinGestor();
            
            $daoFinGestor->setIdPessoa($this->idPessoa);
            $daoFinGestor->setIdContrato($this->idContrato);
            $daoFinGestor->setTpGestor($this->tpGestor);
            $daoFinGestor->setDtIniGestor($this->dtIniGestor);

            $daoFinGestor->insertGestor($pdo);
            //verificar ser deu certo o insert caso sim sucesso passa a ser true
            if ($daoFinGestor->sucesso()) {
                $daoFinGestor->setIdGestor(is_numeric($pdo->lastInsertId('fin_gestor_id_gestor_seq')) ? $pdo->lastInsertId('fin_gestor_id_gestor_seq') : NULL);
                $this->sucesso = true;                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = $daoFinGestor->getMsgRetorno();
                return;
            } 

            if (!Log::SalvaLogI('fin_gestor', $daoFinGestor->getIdGestor(), $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = 'erro log';
                return;
            }
            
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

}
