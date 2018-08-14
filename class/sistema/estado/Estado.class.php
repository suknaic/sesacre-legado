<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesEstado.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPais.class.php";

class Estado {

    private $idPais = null;
    private $idEstado = null;
    private $nmEstado = null;
    private $nmSigla = null;

    function getIdPais() {
        return $this->idPais;
    }

    function getIdEstado() {
        return $this->idEstado;
    }

    function getNmEstado() {
        return $this->nmEstado;
    }

    function getNmSigla() {
        return $this->nmSigla;
    }

    function setIdPais($idPais) {
        $this->idPais = $idPais;
    }

    function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }

    function setNmEstado($nmEstado) {
        $this->nmEstado = $nmEstado;
    }

    function setNmSigla($nmSigla) {
        $this->nmSigla = $nmSigla;
    }

    public function cadastrarEstado() {
        try {

            if ($this->nmEstado == "" || $this->nmSigla == "" || $this->idPais == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $est = new DaoSesEstado();

//            $aux=;
            //echo $aux;
            $est->setNmEstado($this->nmEstado);
            $est->setIdPais($this->idPais);

            if (strlen($this->nmSigla) != 2) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $est->setNmsigla(strtoupper($this->nmSigla));
            }

            $busca = $est->buscaEstadoPorNome($est, $pdo);

            if (!$busca) {
                //return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe um Estado com esse nome.");
                $pdo->rollBack();
                return $retorno;
            }

            $result = $est->insert($est, $pdo);
            //echo ($this->idPais);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $est->setIdEstado($pdo->lastInsertId('ses_estado_id_estado_seq'));

            if (Log::SalvaLogI('ses_estado', $est->getIdEstado(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Novo País Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarEstado() {
        try {

            if ($this->nmEstado == "" || $this->idEstado == "" || $this->idPais == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $est = new DaoSesEstado();
            $est->setIdPais($this->idPais);
            $est->setIdEstado($this->idEstado);
            $est->setNmEstado($this->nmEstado);
            if (strlen($this->nmSigla) != 2) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $est->setNmsigla(strtoupper($this->nmSigla));
            }
            $busca = $est->buscaEstadoPorNome($est, $pdo);

            if (!$busca) {
                //return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe um Estado com esse nome.");
                $pdo->rollBack();
                return $retorno;
            }

            $busca = $est->retornaEstado($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            $result = $est->update($est, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_estado', $est->getIdEstado(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }


            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição do País Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerEstado() {
        try {

            if ($this->idEstado == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $est = new DaoSesEstado();
            $est->setIdEstado($this->idEstado);

            $busca = $est->retornaEstado($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('ses_estado', $est->getIdEstado(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Estado.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $est->delete($est, $pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "País removido com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrEstados() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $est = new DaoSesEstado();

            $result = $est->retornaEstados($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idEstado = $v['id_estado'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_estado'] . "</td>" .
                            "<td>" . $v['nm_pais'] . "</td>" .
                            "<td>" . $v['nm_sigla'] . "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Editar" value=' . $idEstado . '  nome="' . $v['nm_estado'] . '" sigla="' . $v['nm_sigla'] . '" idpa="' . $v['id_pais'] . '" >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $idEstado . '" >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>'
                            . "</tr>";
                    $retorno .= "</tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionPaises() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $est = new DaoSesPais();

            $result = $est->retornaPaisesSelect($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_pais'] . "'>" . $v['nm_pais'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionEstado($idPais = null, $idEstado = null) {
        $retorno = "<option value = '0'>Selecione um estado</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $est = new DaoSesEstado();

            $est->setIdPais($idPais);
            $result = $est->retornaEstados($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if (empty($est->getIdPais())) {
                        if ($idEstado == $v['id_estado']) {
                            $retorno .= "<option selected value = '" . $v['id_estado'] . "'>" . $v['nm_estado'] . " - " . $v['nm_pais'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_estado'] . "'>" . $v['nm_estado'] . " - " . $v['nm_pais'] . "</option>";
                        }
                    } else {
                        if ($idEstado == $v['id_estado']) {
                            $retorno .= "<option value = '" . $v['id_estado'] . "' selected>" . $v['nm_estado'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_estado'] . "'>" . $v['nm_estado'] . "</option>";
                        }
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
