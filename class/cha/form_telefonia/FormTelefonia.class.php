<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaFormTelefonia.class.php";

class FormTelefonia {

  private $id_form_telefonia = null;
    private $id_chamado = null;
    private $nr_ramal = null;
    private $ds_tipo = null;
    private $ds_destino = null;
    private $nr_patrimonio = null;
    private $ds_marca = null;
    private $ds_modelo = null;
    private $ds_localizacao = null;
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
    function getId_form_telefonia() {
        return $this->id_form_telefonia;
    }

    function getId_chamado() {
        return $this->id_chamado;
    }

    function getNr_ramal() {
        return $this->nr_ramal;
    }

    function getDs_tipo() {
        return $this->ds_tipo;
    }

    function getDs_destino() {
        return $this->ds_destino;
    }

    function getNr_patrimonio() {
        return $this->nr_patrimonio;
    }

    function getDs_marca() {
        return $this->ds_marca;
    }

    function getDs_modelo() {
        return $this->ds_modelo;
    }

    function getDs_localizacao() {
        return $this->ds_localizacao;
    }

    function setId_form_telefonia($id_form_telefonia) {
        $this->id_form_telefonia = $id_form_telefonia;
    }

    function setId_chamado($id_chamado) {
        $this->id_chamado = $id_chamado;
    }

    function setNr_ramal($nr_ramal) {
        $this->nr_ramal = $nr_ramal;
    }

    function setDs_tipo($ds_tipo) {
        $this->ds_tipo = $ds_tipo;
    }

    function setDs_destino($ds_destino) {
        $this->ds_destino = $ds_destino;
    }

    function setNr_patrimonio($nr_patrimonio) {
        $this->nr_patrimonio = $nr_patrimonio;
    }

    function setDs_marca($ds_marca) {
        $this->ds_marca = $ds_marca;
    }

    function setDs_modelo($ds_modelo) {
        $this->ds_modelo = $ds_modelo;
    }

    function setDs_localizacao($ds_localizacao) {
        $this->ds_localizacao = $ds_localizacao;
    }

//*******************************************************************************
    public function cadastrarFormTelefonia($pdo) {
        try {
            $telefonia = new DaoChaFormTelefonia();
            $telefonia->setId_chamado($this->id_chamado);
            $telefonia->setNr_ramal($this->nr_ramal);
            $telefonia->setDs_tipo($this->ds_tipo);
            $telefonia->setDs_destino($this->ds_destino);
            $telefonia->setNr_patrimonio($this->nr_patrimonio);
            $telefonia->setDs_marca($this->ds_marca);
            $telefonia->setDs_modelo($this->ds_modelo);
            $telefonia->setDs_localizacao($this->ds_localizacao);
            //***********************************************************************
            //print_r($pessoa);
            //print_r($pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS));
            $validaEmail = $telefonia->validarEmail($pdo, $this->ds_email);
            if ($validaEmail) {
                $this->setSuccess(false);
                $this->setMsg(STR_EMAIL_EXISTE);
                $pdo->rollBack();
                return;
            }
            //*****************************************
            $result = $telefonia->insert($pdo);
            //*****************************************
            if ($result != "Sucesso") {
                $this->setSuccess(false);
                $this->setMsg($result);
                $pdo->rollBack();
                return;
            }
            $this->setId_form_telefonia($pdo->lastInsertId('cha_form_telefonia_id_form_telefonia_seq'));

            if (Log::SalvaLogI('cha_form_telefonia', $this->getId_form_telefonia(), $pdo)) {
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
//    public function editarFromSistemas($pdo) {
//        try {
//            $sistemas = new DaoChaFormSistemas();
//            $sistemas->setId_chamado($this->id_form_sistemas);
//            $sistemas->setNm_pessoa($this->nm_pessoa);
//            $sistemas->setDs_email($this->ds_email);
//            $sistemas->setNr_telefone($this->nr_telefone);
//            $sistemas->setNr_cartao_sus($this->nr_cartao_sus);
//            $sistemas->setNr_cpf($this->nr_cpf);
//            $sistemas->setNr_rg($this->nr_rg);
//            $sistemas->setNr_telefone_setor($this->nr_telefone_setor);
//            $sistemas->setNr_matricula($this->nr_matricula);
//            $sistemas->setNm_modulo($this->nm_modulo);
//            $sistemas->setNr_portaria($this->nr_portaria);
//            $sistemas->setNm_setor($this->nm_setor);
//            $sistemas->setCd_setor($this->cd_setor);
//            $sistemas->setNm_responsavel($this->nm_responsavel);
//            $sistemas->setNr_participantes($this->nr_participantes);
//            $sistemas->setDs_senha_desejada($this->ds_senha_desejada);
//            $sistemas->setNm_exame($this->nm_exame);
//            $sistemas->setDs_exame_paramentro($this->ds_exame_paramentro);
//            $sistemas->setNm_permissao($this->nm_permissao);
//            $sistemas->setNm_conselho($this->nm_conselho);
//            $sistemas->setNr_conselho($this->nr_conselho);
//            $sistemas->setDt_inicial($this->dt_inicial);
//            $sistemas->setDt_fim($this->dt_fim);
//            $sistemas->setDt_nascimento($this->dt_nascimento);
//            $sistemas->setId_cargo($this->id_cargo);
//            $sistemas->setId_funcao($this->id_funcao);
//            $sistemas->setId_lotacao($this->id_funcao);
//            $sistemas->setId_funcao($this->id_funcao);
//            //***********************************************************************
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &1 ");
//            $validaEmail = $sistemas->validarEmail($pdo, $this->ds_email);
//            if ($validaEmail) {
//                $this->setSuccess(false);
//                $this->setMsg(STR_EMAIL_EXISTE);
//                $pdo->rollBack();
//                return;
//            }
//            //print_r($pessoa);
//            //*****************************************
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &3 ");
//            $busca = $sistemas->retornaFormSistemas($pdo);
//            //print_r($busca);
//            //print_r("1--" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)." &4 ");
//            if (!$busca) {
//                $this->setSuccess(false);
//                $this->setMsg($busca);
//                $pdo->rollBack();
//                return;
//            }
//            //*****************************************
//            $result = $sistemas->update($pdo);
//            //*****************************************
//            if ($result != "Sucesso") {
//                $this->setSuccess(false);
//                $this->setMsg($result);
//                $pdo->rollBack();
//                return;
//            }
//            if (Log::SalvaLogU('cha_form_sistemas', $this->getId_form_sistemas(), $busca, $pdo)) {
//                $this->setSuccess(TRUE);
//                return;
//            } else {
//                $this->setSuccess(false);
//                $this->setMsg("ERRO de LOG em UPDATE de FORMULAŔIO SISTEMAS");
//                $pdo->rollBack();
//                return;
//            }
//        } catch (Exception $exc) {
//            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
//        }
//    }
//
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

    public function retornaFormTelefonia($pdo) {
        try {
            $telefonia = new DaoChaFormTelefonia();
            $telefonia->setId_form_telefonia($this->id_form_telefonia);
            $rs = $telefonia->retornaFormTelefonia($pdo);
            if ($rs != FALSE) {
                if ($this->msg != "chamado") {
                    $retorno[] = array(
                        "idFormTelefonia" => $rs["id_form_telefonia"],
                        "idChamado" => $rs["id_chamado"],
                        "nrRamal" => $rs["nr_ramal"],
                        "tipo" => $rs["ds_tipo"],
                        "destino" => $rs["ds_destino"],
                        "nrPatrimonio" => $rs["nr_patrimonio"],
                        "marca" => $rs["ds_marca"],
                        "modelo" => $rs["ds_modelo"],
                        "localizacao" => $rs["ds_localizacao"]                       
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

    public function retornaOptionFormTelefonia() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $telefonia = new DaoChaFormTelefonia();
            $result = $telefonia->retornaTodosFormTelefonia($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_form_telefonia'] . "'>" . $v['id_chamado'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
