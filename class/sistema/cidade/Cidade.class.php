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

            $cidade->setId_estado($this->id_estado);
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

            if (empty($this->nm_cidade && $this->id_estado && $this->id_cidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cidade = new DaoSesCidade();
            $cidade->setId_cidade(base64_decode($this->id_cidade));
            $cidade->setId_estado($this->id_estado);
            $cidade->setId_regional_saude($this->id_regional_saude == 0 || $this->id_regional_saude == '' ? null:$this->id_regional_saude);
            $cidade->setId_regional_geo($this->id_regional_geo == 0 || $this->id_regional_geo == '' ? null:$this->id_regional_geo);
            $cidade->setNm_cidade($this->nm_cidade);

            //************ Busca Cidade Pelo Id ***********
            $log = $cidade->retornaCidade($pdo);
            //*********************************************

            if (!is_array($log)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $log);
            }

            if ($log['nm_cidade'] != $this->nm_cidade) {
                $busca = $cidade->buscaCidadePorNomeAndEstado($pdo);
            } else {
                $busca = false;
            }

            if ($busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
            }

            $edita = $cidade->update($pdo);
            if (!$edita) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $edita);
            }

            if (!Log::SalvaLogU('ses_cidade', $cidade->getId_cidade(), $log, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            } else {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerCidade() {
        try {

            if (empty($this->id_cidade)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cidade = new DaoSesCidade();
            $cidade->setId_cidade(base64_decode($this->id_cidade));

            $busca = $cidade->retornaCidade($pdo);
            if (!is_array($busca)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogD('ses_cidade', $cidade->getId_cidade(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $deleta = $cidade->delete($pdo);
            if ($cidade->getSucess()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                if ($deleta->getCode() == 23503) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", ' Não foi Possível Realizar a Exclusão dessa Cidade. Este registro está Vinculado a uma Pessoa.');
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $deleta->getMessage());
                }
            }
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

            $filtro = '';
            if ($this->id_estado != 'Todos') {
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
                if (empty($filtro)) {
                    return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                }
            }

            $busca = $cidade->buscarCidade($pdo, $filtro);
            if (!is_array($busca)) {
                return Metodos::retornoAjax('Erro', 'console', $busca);
            } else {
                $retorno = "";
                foreach ($busca as $cidade) {
                    $idCidade = base64_encode($cidade['id_cidade']);
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
        $retorno = "<option value = '0'>Selecione a Cidade</option>";
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
        $retorno = "<option value = '0'>Selecione a Cidade</option>";
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
