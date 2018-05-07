<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaFormInfraestrutura.class.php";

class Metrial {

    private $id_form_infraestrutura = null;
    private $id_chamado = null;
    private $tp_liberacao = null;
    private $nm_pessoa = null;
    private $id_cargo = null;
    private $id_funcao = null;
    private $id_lotacao = null;
    private $nm_email = null;
    private $ds_andar = null;
    //**************************************************************************
    private $success = null;
    private $msg = null;

    function getMsg() {
        return $this->msg;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }

    function getSuccess() {
        return $this->success;
    }

    function setSuccess($success) {
        $this->success = $success;
    }

//*******************************************************************************
    function getId_form_infraestrutura() {
        return $this->id_form_infraestrutura;
    }

    function getId_chamado() {
        return $this->id_chamado;
    }

    function getTp_liberacao() {
        return $this->tp_liberacao;
    }

    function getNm_pessoa() {
        return $this->nm_pessoa;
    }

    function getId_cargo() {
        return $this->id_cargo;
    }

    function getId_funcao() {
        return $this->id_funcao;
    }

    function getId_lotacao() {
        return $this->id_lotacao;
    }

    function getNm_email() {
        return $this->nm_email;
    }

    function getDs_andar() {
        return $this->ds_andar;
    }

    function setId_form_infraestrutura($id_form_infraestrutura) {
        $this->id_form_infraestrutura = $id_form_infraestrutura;
    }

    function setId_chamado($id_chamado) {
        $this->id_chamado = $id_chamado;
    }

    function setTp_liberacao($tp_liberacao) {
        $this->tp_liberacao = $tp_liberacao;
    }

    function setNm_pessoa($nm_pessoa) {
        $this->nm_pessoa = $nm_pessoa;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function setId_funcao($id_funcao) {
        $this->id_funcao = $id_funcao;
    }

    function setId_lotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    function setNm_email($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setDs_andar($ds_andar) {
        $this->ds_andar = $ds_andar;
    }


//*******************************************************************************
    public function cadastrarFormInfraestrutura($pdo) {
        try {
            $infraestrutura = new DaoChaFormInfraestrutura();
            $infraestrutura->setId_chamado($this->id_chamado);
            $infraestrutura->setTp_liberacao($this->tp_liberacao);
            $infraestrutura->setNm_pessoa($this->nm_pessoa);
            $infraestrutura->setId_cargo($this->id_cargo);
            $infraestrutura->setId_funcao($this->id_funcao);
            $infraestrutura->setId_lotacao($this->id_lotacao);
            $infraestrutura->setNm_email($this->nm_email);
            $infraestrutura->setDs_andar($this->ds_andar);
            //***********************************************************************
            //print_r($pessoa);
            //print_r($pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS));
            $validaEmail = $infraestrutura->validarEmail($pdo, $this->nm_email);
            if ($validaEmail) {
                $this->setSuccess(false);
                $this->setMsg(STR_EMAIL_EXISTE);
                $pdo->rollBack();
                return;
            }
            //*****************************************
            $result = $infraestrutura->insert($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            $this->setId_form_infraestrutura($pdo->lastInsertId('cha_form_infraestrutura_id_form_infraestrutura'));

            if (Log::SalvaLogI('cha_form_infraestrutura', $this->getId_form_infraestrutura(), $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg(STR_ERROR);
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            //return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
        }
    }

//*******************************************************************************************************
    public function editarFromInfraestrutura($pdo) {
        try {
            $infraestrutura = new DaoChaFormInfraestrutura();
            $infraestrutura->setId_chamado($this->id_chamado);
            $infraestrutura->setTp_liberacao($this->tp_liberacao);
            $infraestrutura->setNm_pessoa($this->nm_pessoa);
            $infraestrutura->setId_cargo($this->id_cargo);
            $infraestrutura->setId_funcao($this->id_funcao);
            $infraestrutura->setId_lotacao($this->id_lotacao);
            $infraestrutura->setNm_email($this->nm_email);
            $infraestrutura->setDs_andar($this->ds_andar);
            
            //***********************************************************************
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &1 ");
            $validaEmail = $infraestrutura->validarEmail($pdo, $this->nm_email);
            if ($validaEmail) {
                $this->setSuccess(false);
                $this->setMsg(STR_EMAIL_EXISTE);
                $pdo->rollBack();
                return;
            }
            //print_r($pessoa);
            //*****************************************
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &3 ");
            $busca = $infraestrutura->retornaFormInfraestrutura($pdo);
            //print_r($busca);
            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
            if (!$busca) {
                $this->setSuccess(false);
                $this->setMsg($busca);
                $pdo->rollBack();
                return;
            }
            //*****************************************
            $result = $infraestrutura->update($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            if (Log::SalvaLogU('cha_form_infraestrutura', $this->getId_form_infraestrutura(), $busca, $pdo)) {
                $this->setSuccess(TRUE);
                return;
            } else {
                $this->setSuccess(false);
                $this->setMsg("ERRO de LOG em UPDATE de FORMULAŔIO INFRAESTRUTURA");
                $pdo->rollBack();
                return;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

//    public function removerFormSistemas($pdo) {
//        try {
//            $pessoa = new DaoSesPessoa();
//            $pessoa->setIdPessoa($this->id_pessoa);
//            $rs = $pessoa->remPessoa($pdo);
//
//            if ($rs != "Sucesso") {
//                $this->setSuccess(false);
//                $this->setMsg($rs);
//                $pdo->rollBack();
//                return;
//            }
//            //if (Log::SalvaLogI('ses_pessoa', $this->getId_pessoa(), $pdo)) {
//            if (TRUE) {
//                $this->setSuccess(TRUE);
//                return;
//            } else {
//                $this->setSuccess(false);
//                $this->setMsg(STR_ERROR);
//                $pdo->rollBack();
//                return;
//            }
//        } catch (Exception $exc) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }

    public function retornaFormInfraestrutura($pdo) {
        try {
            $infraestrutura = new DaoChaFormInfraestrutura();
            $infraestrutura->setId_form_infraestrutura($this->id_form_infraestrutura);
            $rs = $infraestrutura->retornaFormInfraestrutura($pdo);
            if ($rs != FALSE) {
                if ($this->msg != "chamado") {
                    $retorno[] = array(
                        "idFormInfraestrutura" => $rs["id_form_infraestrutura"],
                        "idChamado" => $rs["id_chamado"],
                        "liberacao" => $rs["tp_liberacao"],
                        "nmPessoa" => $rs["nm_pessoa"],
                        "cargo" => $rs["id_cargo"],
                        "funcao" => $rs["funcao"],
                        "lotacao" => $rs["id_lotacao"],
                        "email" => $rs["nm_email"],
                        "andar" => $rs["ds_andar"]                       
                    );
                    return json_encode($retorno);
                } else {

                    return $rs;
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaOptionFormInfraestrutura() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $infraestrutura = new DaoChaFormInfraestrutura();
            $result = $infraestrutura->retornaTodosFormInfraestrutura($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_form_infraestrutura'] . "'>" . $v['id_chamado'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
