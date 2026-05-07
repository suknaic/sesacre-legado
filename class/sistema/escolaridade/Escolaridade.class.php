<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesEscolaridade.class.php";

class Escolaridade {

    private $idEscolaridade = null;
    private $nmEscolaridade = null;
    private $idPessoaFisica = null;
    private $stAtivo = null;

    function getIdEscolaridade() {
        return $this->idEscolaridade;
    }

    function getNmEscolaridade() {
        return $this->nmEscolaridade;
    }

    function setIdEscolaridade($idEscolaridade) {
        $this->idEscolaridade = $idEscolaridade;
    }

    function setNmEscolaridade($nmEscolaridade) {
        $this->nmEscolaridade = $nmEscolaridade;
    }

    function getIdPessoaFisica() {
        return $this->idPessoaFisica;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdPessoaFisica($idPessoaFisica) {
        $this->idPessoaFisica = $idPessoaFisica;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    public function cadastrarEscolaridade() {
        try {

            if ($this->nmEscolaridade == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $esc = new DaoSesEscolaridade();

            $esc->setNmEscolaridade($this->nmEscolaridade);

            $busca = $esc->buscaEscolaridade($esc, $pdo);

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $esc->insert($esc, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $esc->setIdEscolaridade($pdo->lastInsertId('ses_escolaridade_id_escolaridade_seq'));

            if (Log::SalvaLogI('ses_escolaridade', $esc->getIdEscolaridade(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarEscolaridade() {
        try {

            if ($this->nmEscolaridade == "" || $this->idEscolaridade == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $esc = new DaoSesEscolaridade();

            $esc->setIdEscolaridade($this->idEscolaridade);
            $esc->setNmEscolaridade($this->nmEscolaridade);

            $buscaNome = $esc->buscaEscolaridade($esc, $pdo);
            if (!$buscaNome) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $buscaId = $esc->retornaEscolaridade($pdo);

            if (!$buscaId) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $esc->update($esc, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_escolaridade', $esc->getIdEscolaridade(), $buscaId, $pdo)) {
                $retorno = retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerEscolaridade() {
        try {

            if (empty($this->idEscolaridade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $esc = new DaoSesEscolaridade();
            $esc->setIdEscolaridade($this->idEscolaridade);

            $busca = $esc->retornaEscolaridade($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogD('ses_escolaridade', $esc->getIdEscolaridade(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $resultDao = $esc->delete($pdo);
            if ($resultDao === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Realizar a Exclusão dessa Escolaridade. Este registro está Vinculado a uma Pessoa.");
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function desativarEscolaridade() {
        try {

            if (empty($this->idEscolaridade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $esc = new DaoSesEscolaridade();
            $esc->setIdEscolaridade($this->idEscolaridade);

            $busca = $esc->retornaEscolaridade($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_escolaridade', $esc->getIdEscolaridade(), $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $resultDao = $esc->desativar($pdo);
            if ($resultDao === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function ativarEscolaridade() {
        try {

            if (empty($this->idEscolaridade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $esc = new DaoSesEscolaridade();
            $esc->setIdEscolaridade($this->idEscolaridade);

            $busca = $esc->retornaEscolaridade($pdo);

            if ($busca === FALSE) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_escolaridade', $esc->getIdEscolaridade(), $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            $resultDao = $esc->ativar($pdo);
            if ($resultDao === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrEscolaridade() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $esc = new DaoSesEscolaridade();

            $result = $esc->listaEscolaridade($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idEscolaridade = $v['id_escolaridade'];
                    $retorno .= "<tr>
                                    <td>" . $v['nm_escolaridade'] . "</td>
                                    <td style='text-align: center;'>
                                        <button type='button' class='btn btn-default btn-edit btn-xs title='Editar' nome='" . $v['nm_escolaridade'] . "' value='" . $idEscolaridade . "' >
                                            <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                        </button> 
                                        <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' value='" . $idEscolaridade . "' >
                                            <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
                                        </button>";
                    if ($v['st_ativo'] == '0') {
                        $retorno .= "   <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_escolaridade'] . "' value='" . $idEscolaridade . "' >
                                            <i class='ion-checkmark-round text-success' aria-hidden='true'></i>                                
                                        </button>";
                    } else {
                        $retorno .= "    <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_escolaridade'] . "' value='" . $idEscolaridade . "' >
                                            <i class='ion-close-round text-danger' aria-hidden='true'></i>                                
                                        </button>";
                    }
                    $retorno .= "   </td>
                                </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //*************************************************************************
    public function retornaOptionEscolaridadeFormacao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $escolaridade = new DaoSesEscolaridade();
            $result = $escolaridade->retornaEscolaridadeFormacao($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_escolaridade_formacao'] . "'>" . $v['nm_escolaridade_formacao'] . " - " . $v['nm_escolaridade'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    //*************************************************************************
    public function retornaOptionEscolaridade($id = null) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $escolaridade = new DaoSesEscolaridade();
            $result = $escolaridade->listaEscolaridade($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['st_ativo'] == '1') {
                        if ($v['id_escolaridade'] == $id) {
                            $retorno .= "<option selected value = '" . $v['id_escolaridade'] . "'>" . $v['nm_escolaridade'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_escolaridade'] . "'>" . $v['nm_escolaridade'] . "</option>";
                        }
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionEscolaridadePessoa() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $escolaridade = new DaoSesEscolaridade();
            $escolaridade->setId_pessoa_fisica($this->idPessoaFisica);
            $result = $escolaridade->buscaEscolaridadePorPessoa($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_escolaridade'] . "'>" . $v['nm_escolaridade'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaEscolaridade() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $esc = new DaoSesEscolaridade();
            $esc->setIdEscolaridade($this->idEscolaridade);

            $busca = $esc->retornaEscolaridade($pdo);

            if (!$busca) {
                return $retorno;
            } else {
                return $busca;
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
