<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesCidade.class.php";

//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPais.class.php";

class Cidade {

    private $id_cidade = null;
    private $id_estado = null;
    private $id_regional_saude = null;
    private $id_regional_geo = null;
    private $nm_cidade = null;
    private $st_ativo = null;

    function getId_cidade() {
        return $this->id_cidade;
    }

    function getId_estado() {
        return $this->id_estado;
    }

    function getId_regional_saude() {
        return $this->id_regional_saude;
    }

    function getId_regional_geo() {
        return $this->id_regional_geo;
    }

    function getNm_cidade() {
        return $this->nm_cidade;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setId_estado($id_estado) {
        $this->id_estado = $id_estado;
    }

    function setId_regional_saude($id_regional_saude) {
        $this->id_regional_saude = $id_regional_saude;
    }

    function setId_regional_geo($id_regional_geo) {
        $this->id_regional_geo = $id_regional_geo;
    }

    function setNm_cidade($nm_cidade) {
        $this->nm_cidade = $nm_cidade;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    public function cadastrarCidade() {
        try {

            if (empty($this->nm_cidade && $this->id_estado)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cidade = new DaoSesCidade();

            $cidade->setId_estado($this->id_estado === 0 ? NULL : $this->id_estado);
            $cidade->setId_regional_saude($this->id_regional_saude === 0 ? NULL : $this->id_regional_saude);
            $cidade->setId_regional_geo($this->id_regional_geo === 0 ? NULL : $this->id_regional_saude);
            $cidade->setNm_cidade($this->nm_cidade);

            $busca = $cidade->buscaCidadePorNomeAndEstado($pdo);
            if ($busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }

            $inseri = $cidade->insert($cidade, $pdo);
            if (!$inseri) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $inseri);
            }

            $cidade->setId_cidade($pdo->lastInsertId('ses_cidade_id_cidade_seq'));
            if (Log::SalvaLogI('ses_cidade', $cidade->getId_cidade(), $pdo)) {
                $pdo->commit();
                return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarCidade() {
        try {

            if ($this->nm_cidade == "" || $this->id_estado == "" || $this->id_regional_saude == "" || $this->id_regional_geo == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cidade = new DaoSesCidade();
            $cidade->setId_cidade($this->id_cidade);
            $cidade->setId_estado($this->id_estado);
            $cidade->setId_regional_saude($this->id_regional_saude);
            $cidade->setId_regional_geo($this->id_regional_geo);
            $cidade->setNm_cidade($this->nm_cidade);

            $busca = $cidade->buscaCidadePorNome($cidade, $pdo);

            if (!$busca) {
                //return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já Existe uma Cidade com esse nome.");
                $pdo->rollBack();
                return $retorno;
            }

            $busca = $cidade->retornaCidade($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            $result = $cidade->update($cidade, $pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_cidade', $cidade->getId_cidade(), $busca, $pdo)) {
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

    public function removerCidade() {
        try {

            if ($this->id_cidade == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cidade = new DaoSesCidade();
            $cidade->setId_cidade($this->id_cidade);

            $busca = $cidade->retornaCidade($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('ses_cidade', $cidade->getId_cidade(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Error, Por favor, contate o administrador do sistema.");
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Cidade.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $cidade->delete($cidade, $pdo);
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

    public function retornaTrCidades() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();

            $cidade->setNm_cidade($this->nm_cidade);
            $cidade->setId_estado($this->id_estado);

            $filtro = array();
            if (!empty($this->nm_cidade)) {
                $filtro[] ="unaccent(lower(CID.nm_cidade)) ilike '".$this->nm_cidade."%'";
            };
            if (!empty($this->id_estado)) {
                $filtro[] = "EST.id_estado = ".$this->id_estado;
            };
            if (count($filtro) > 0) {
                $filtro = " AND " . implode(' AND ', $filtro);
            }
            if ($filtro == "") {
                return false;
            }

            $busca = $cidade->buscarCidade($pdo, $filtro);
            if (!is_array($busca)) {
                return Metodos::retornoAjax('Erro', 'console', $busca);
            } else {
                $retorno = "";
                foreach ($busca as $cidade) {
                    $idCidade = $cidade['id_cidade'];
                    $retorno .= "<tr>
                                    <td class='text-left'>" . $cidade['nm_cidade'] . "</td>
                                    <td class='text-left'>" . $cidade['estado'] . "</td>    
                                    <td class='text-left'>" . $cidade['pais'] . "</td>
                                    <td class='text-left'>" . $cidade['geo'] . "</td>
                                    <td class='text-left'>" . $cidade['sau'] . "</td>
                                    <td class='text-center'>
                                        <button type='button' class='btn btn-default btn-edit btn-xs' title='Editar' value='" . $idCidade . "'  nome='" . $cidade['nm_cidade'] . "'>
                                            <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>
                                        </button>
                                        <button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' value='" . $idCidade . "'>
                                            <i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>
                                        </button>
                                    </td>
                                 </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax('Erro', 'console', $ex->getMessage());
        }
    }

    public function retornaCidadeUf($uf) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();
            $cidade->setNm_uf(trim($uf));
            $result = $cidade->buscaCidadeUf($pdo);
            if (!$result) {
                return FALSE;
            } else {
                $retorno[] = array(
                    "id_estado" => $result["id_estado"],
                    "id_pais" => $result["id_pais"],
                    "nm_sigla" => $result["nm_sigla"],
                    "nm_estado" => $result["nm_estado"],
                    "st_ativo" => $result["st_ativo"]
                );
                return json_encode($retorno);
            }
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionCidadeUf($idEstado, $uf) {
        $retorno = "<option value = '0'>Selecione uma Cidade</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();
            $cidade->setId_estado($idEstado);
            $result = $cidade->listaCidade($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if (trim($uf) == trim($v['nm_cidade'])) {
                        $retorno .= "<option value = '" . $v['id_cidade'] . "' selected>" . $v['nm_cidade'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_cidade'] . "'>" . $v['nm_cidade'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionCidade($idEstado, $idCidade = 0) {
        $retorno = "<option value = '0'>Selecione uma Cidade</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();
            $cidade->setId_estado($idEstado);
            $result = $cidade->listaCidade($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idCidade == $v['id_cidade']) {
                        $retorno .= "<option value = '" . $v['id_cidade'] . "' selected>" . $v['nm_cidade'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_cidade'] . "'>" . $v['nm_cidade'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionRegionalSaude($idRegional = null) {
        $retorno = "<option value = ''>Selecione uma Regional</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $cidade = new DaoSesCidade();
            $busca = $cidade->buscaRegiosnaiSaude($pdo);

            if (!$busca) {
                return $retorno;
            } else {
                foreach ($busca as $v) {
                    if ($idRegional == $v['id_regional_saude']) {
                        $retorno .= "<option value = '" . $v['id_regional_saude'] . "' selected>" . $v['nm_regional_saude'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_regional_saude'] . "'>" . $v['nm_regional_saude'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionRegionalGeo($idRegional = null) {
        $retorno = "<option value = ''>Selecione uma Regional</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $cidade = new DaoSesCidade();
            $busca = $cidade->buscaRegiosnaisGeo($pdo);

            if (!$busca) {
                return $retorno;
            } else {
                foreach ($busca as $v) {
                    if ($idRegional == $v['id_regional_geo']) {
                        $retorno .= "<option value = '" . $v['id_regional_geo'] . "' selected>" . $v['nm_regional_geo'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_regional_geo'] . "'>" . $v['nm_regional_geo'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionTodasCidades($idCidade = 0) {
        $retorno = "<option value = '0'>Selecione uma Cidade</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();
            $result = $cidade->listaTodasCidades($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($idCidade == $v['id_cidade']) {
                        $retorno .= "<option value = '" . $v['id_cidade'] . "' selected>" . $v['nm_cidade'] . " - " . $v['nm_sigla'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $v['id_cidade'] . "'>" . $v['nm_cidade'] . " - " . $v['nm_sigla'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function optionsCidadePorNomeEstado() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();
            $cidade->setNm_cidade($this->getNm_cidade());
            $resultado = $cidade->cidadePorNomeEstado($pdo);

            if (!$resultado) {
                return $retorno;
            } else {
                foreach ($resultado as $linha) {
                    $retorno .= '<tr class="selecionaCidade" data-cidade="' . $linha['id_cidade'] . '"  style="cursor:pointer;">'
                            . '<td>' . $linha['cidade'] . '</td>'
                            . '<td>' . $linha['estado_sigla'] . '</td>'
                            . '</tr>';
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            return $retorno;
        }
    }

    public function carregaDadosCidade() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cidade = new DaoSesCidade();
            $cidade->setId_cidade($this->id_cidade);

            $busca = $cidade->carregaDadosCidade($pdo);
            if (!$busca) {
                return Metodos::retornoAjax('Erro', 'alert', STR_NAO_ENCONTRADO);
            } else {
                return json_encode($busca);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax('Erro', 'console', $ex->getMessage());
        }
    }

}

?>
