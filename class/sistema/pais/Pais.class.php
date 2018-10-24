<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPais.class.php";

class Pais {

    private $idPais = null;
    private $nmPais = null;
    private $nmSigla = null;

    function getIdPais() {
        return $this->idPais;
    }

    function getNmPais() {
        return $this->nmPais;
    }

    function getNmSigla() {
        return $this->nmSigla;
    }

    function setIdPais($idPais) {
        $this->idPais = $idPais;
    }

    function setNmPais($nmPais) {
        $this->nmPais = $nmPais;
    }

    function setNmSigla($nmSigla) {
        $this->nmSigla = $nmSigla;
    }

    public function cadastrarPais() {
        try {

            if (empty($this->nmPais && $this->nmSigla)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pais = new DaoSesPais();

//            $aux=;
            //echo $aux;
            $pais->setNmPais($this->nmPais);

            if (strlen($this->nmSigla) != 2) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $pais->setNmsigla(strtoupper($this->nmSigla));
            }

            $busca = $pais->buscaPaisPorNome($pais, $pdo);

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            if ($pais->verificaSiglaPais($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", 'Registro com mesma <strong>sigla</strong> já existe.');
            }

            $result = $pais->insert($pais, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $pais->setIdPais($pdo->lastInsertId('ses_pais_id_pais_seq'));

            if (Log::SalvaLogI('ses_pais', $pais->getIdPais(), $pdo)) {
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
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarPais() {
        try {

            if ($this->nmPais == "" || $this->idPais == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pais = new DaoSesPais();

            $pais->setIdPais($this->idPais);
            $pais->setNmPais($this->nmPais);
            if (strlen($this->nmSigla) != 2) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            } else {
                $pais->setNmsigla(strtoupper($this->nmSigla));
            }
            $busca = $pais->buscaPaisPorNome($pais, $pdo);

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }

            $busca = $pais->retornaPais($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            if ($busca['nm_sigla'] != $this->nmSigla) {
                if ($pais->verificaSiglaPais($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", 'Registro com mesma <strong>sigla</strong> já existe.');
                }
            }

            $result = $pais->update($pais, $pdo);
            if ($result != "Sucesso") {
                if ($result->getCode() == 23505) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $result->getMessage());
                }
            }

            if (!Log::SalvaLogU('ses_pais', $pais->getIdPais(), $busca, $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
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
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerPais() {
        try {

            if ($this->idPais == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pais = new DaoSesPais();
            $pais->setIdPais($this->idPais);

            $busca = $pais->retornaPais($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('ses_pais', $pais->getIdPais(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o País.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $pais->delete($pais, $pdo);
            if ($resultDao != "Sucesso") {
                if ($resultDao->getCode() == 23503) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", 'Não foi Possível Realizar a Exclusão desse País. Este registro está Vinculado a uma Pessoa.');
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $resultDao->getMessage());
                }
            }

            $sucesso = true;

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrPaises() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pais = new DaoSesPais();

            $result = $pais->retornaPaises($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idPais = $v['id_pais'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_pais'] . "</td>" .
                            "<td>" . $v['nm_sigla'] . "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Editar" value=' . $idPais . ' nome="' . $v['nm_pais'] . '" sigla="' . $v['nm_sigla'] . '" >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idPais . ' >
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

}

?>
