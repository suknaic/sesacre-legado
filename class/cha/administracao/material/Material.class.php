<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaMaterial.php";

/**
 * Description of Material
 *
 * @author elivelton
 */
class Material {

    private $idMaterial = null;
    private $nmMaterial = null;
    private $dtAquisicao = null;
    private $dsMarca = null;
    private $dsModelo = null;
    private $nmPatrimonio = null;
    private $vlPreco = null;
    private $qtGarantia = null;
    private $nmSerie = null;
    private $estado = null;
    private $idUnidadeMedida = null;
    private $qtMemoriaRam = null;
    private $dsProcessador = null;
    private $qtHd = null;
    private $qtFonte = null;
    private $wireless = null;

    function getIdMaterial() {
        return $this->idMaterial;
    }

    function getNmMaterial() {
        return $this->nmMaterial;
    }

    function getDtAquisicao() {
        return $this->dtAquisicao;
    }

    function getDsMarca() {
        return $this->dsMarca;
    }

    function getDsModelo() {
        return $this->dsModelo;
    }

    function getNmPatrimonio() {
        return $this->nmPatrimonio;
    }

    function getVlPreco() {
        return $this->vlPreco;
    }

    function getQtGarantia() {
        return $this->qtGarantia;
    }

    function getNmSerie() {
        return $this->nmSerie;
    }

    function getEstado() {
        return $this->estado;
    }

    function getIdUnidadeMedida() {
        return $this->idUnidadeMedida;
    }

    function getQtMemoriaRam() {
        return $this->qtMemoriaRam;
    }

    function getDsProcessador() {
        return $this->dsProcessador;
    }

    function getQtHd() {
        return $this->qtHd;
    }

    function getQtFonte() {
        return $this->qtFonte;
    }

    function getWireless() {
        return $this->wireless;
    }

    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
    }

    function setNmMaterial($nmMaterial) {
        $this->nmMaterial = $nmMaterial;
    }

    function setDtAquisicao($dtAquisicao) {
        $this->dtAquisicao = $dtAquisicao;
    }

    function setDsMarca($dsMarca) {
        $this->dsMarca = $dsMarca;
    }

    function setDsModelo($dsModelo) {
        $this->dsModelo = $dsModelo;
    }

    function setNmPatrimonio($nmPatrimonio) {
        $this->nmPatrimonio = $nmPatrimonio;
    }

    function setVlPreco($vlPreco) {
        $this->vlPreco = $vlPreco;
    }

    function setQtGarantia($qtGarantia) {
        $this->qtGarantia = $qtGarantia;
    }

    function setNmSerie($nmSerie) {
        $this->nmSerie = $nmSerie;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setIdUnidadeMedida($idUnidadeMedida) {
        $this->idUnidadeMedida = $idUnidadeMedida;
    }

    function setQtMemoriaRam($qtMemoriaRam) {
        $this->qtMemoriaRam = $qtMemoriaRam;
    }

    function setDsProcessador($dsProcessador) {
        $this->dsProcessador = $dsProcessador;
    }

    function setQtHd($qtHd) {
        $this->qtHd = $qtHd;
    }

    function setQtFonte($qtFonte) {
        $this->qtFonte = $qtFonte;
    }

    function setWireless($wireless) {
        $this->wireless = $wireless;
    }

    public function cadastrarMaterial() {
        try {
            if (empty($this->nmMaterial && $this->idUnidadeMedida && $this->estado)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $DaoMaterial = new DaoChaMaterial();
                $DaoMaterial->setNm_material($this->nmMaterial === '' ? null : $this->nmMaterial);

                if ($DaoMaterial->verificaMaterial($pdo, $coluna = 'nm_material', $atributo = "'" . $this->nmMaterial . "'") == 0) {
                    $DaoMaterial->setId_unidade_medida($this->idUnidadeMedida);
                    $DaoMaterial->setDt_aquisicao(Metodos::ConverteDataING($this->dtAquisicao) === '--' ? null : Metodos::ConverteDataING($this->dtAquisicao));
                    $DaoMaterial->setQt_meses_garantia($this->qtGarantia === '' ? null : $this->qtGarantia);
                    $DaoMaterial->setNr_patrimonio($this->nmPatrimonio === '' ? null : $this->nmPatrimonio);
                    $DaoMaterial->setVl_preco(Metodos::ConverteValorIng($this->vlPreco) === '' ? null : Metodos::ConverteValorIng($this->vlPreco));
                    $DaoMaterial->setDs_modelo($this->dsModelo === '' ? null : $this->dsModelo);
                    $DaoMaterial->setDs_marca($this->dsMarca === '' ? null : $this->dsMarca);
                    $DaoMaterial->setDs_processador($this->dsProcessador === '' ? null : $this->dsProcessador);
                    $DaoMaterial->setQt_hd($this->qtHd === '' ? null : $this->qtHd);
                    $DaoMaterial->setQt_fonte($this->qtFonte === '' ? null : $this->qtFonte);
                    $DaoMaterial->setFl_wireless($this->wireless === '' ? null : $this->wireless);
                    $DaoMaterial->setTp_estado($this->estado === '' ? null : $this->estado);
                    $DaoMaterial->setQt_memoria_ram($this->qtMemoriaRam === '' ? null : $this->qtMemoriaRam);
                    $DaoMaterial->setNm_serie($this->nmSerie === '' ? null : $this->nmSerie);

                    if ($DaoMaterial->cadastrarMaterial($pdo)) {
                        $DaoMaterial->setId_material($pdo->lastInsertId('cha_material_id_material_seq'));
                        if (Log::SalvaLogI('cha_material', $DaoMaterial->getId_material(), $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                } else {
                    return Metodos::retornoAjax('Erro', 'alert', STR_REGISTRO_EXISTE);
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarMateriais() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoMaterial = new DaoChaMaterial();
            if (!empty($this->nmMaterial)) {
                $condicao = "WHERE M.nm_material ILIKE '%" . $this->nmMaterial . "%'";
            }
            if (!empty($this->nmSerie)) {
                $condicao = "WHERE M.nm_serie ILIKE '%" . $this->nmSerie . "%'";
            }
            if (!empty($this->nmPatrimonio)) {
                $condicao = "WHERE M.nr_patrimonio ILIKE '%" . $this->nmPatrimonio . "%'";
            }

            $resultado = $daoMaterial->listarMateriais($pdo, $condicao);
            $retorno = "";
            if (!is_array($resultado)) {
                return Metodos::retornoAjax('Erro', 'console', $resultado);
            } else {
                foreach ($resultado as $linha) {
                    $retorno .= '
                                                    <tr>
                                                        <td class="text-center">' . $linha["nm_material"] . '</td>
                                                        <td class="text-center">';
                                                            if ($linha["dt_aquisicao"] != '') {
                                                                $retorno .= Metodos::ConverteDataBR($linha["dt_aquisicao"]);
                                                            } else {
                                                                $retorno .= $linha["dt_aquisicao"];
                                                            }
                    $retorno .= '                   </td>
                                                        <td class="text-center">' . $linha["ds_marca"] . '</td>
                                                        <td class="text-center">' . $linha["ds_modelo"] . '</td>
                                                        <td class="text-center">' . $linha["nr_patrimonio"] . '</td>
                                                        <td class="text-center">';
                                                            if ($linha["vl_preco"] != '') {
                                                                $retorno .= Metodos::ConverteValorBr($linha["vl_preco"], 2);
                                                            } else {
                                                                $retorno .= $linha["vl_preco"];
                                                            }
                    $retorno .= '                   </td>
                                                        <td class="text-center">' . $linha["qt_meses_garantia"] . '</td>
                                                        <td class="text-center">' . $linha["nm_serie"] . '</td>
                                                        <td class="text-center">';
                                                            if ($linha["tp_estado"] == '1') {
                                                                $retorno .= 'Novo';
                                                            } elseif ($linha["tp_estado"] == '2') {
                                                                $retorno .= 'Velho';
                                                            } else {
                                                                $retorno .= $linha["tp_estado"];
                                                            }
                    $retorno .= '                   </td>
                                                        <td class="text-center">' . $linha["nm_unidade_medida"] . '</td>
                                                        <td class="text-center">' . $linha["qt_memoria_ram"] . '</td>
                                                        <td class="text-center">' . $linha["ds_processador"] . '</td>
                                                        <td class="text-center">' . $linha["qt_hd"] . '</td>
                                                        <td class="text-center">' . $linha["qt_fonte"] . '</td>
                                                        <td class="text-center">';
                                                            if ($linha["fl_wireless"] == '1') {
                                                                $retorno .= 'Sim';
                                                            } elseif ($linha["fl_wireless"] == '2') {
                                                                $retorno .= 'Não';
                                                            } else {
                                                                $retorno .= $linha["fl_wireless"];
                                                            }
                    $retorno .= '                   </td>             
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" material="' . $linha["nm_material"] . '" value="' . $linha["id_material"] . '">
                                                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                            </button>

                                                            <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_material"] . '">
                                                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                }
                return $retorno;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function editarMaterial() {
        try {
            if (empty($this->nmMaterial && $this->idUnidadeMedida && $this->estado)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $DaoMaterial = new DaoChaMaterial();
                $dados = $DaoMaterial->verificaMaterial($pdo, $coluna = 'id_material', $this->idMaterial);
                if (count($dados) > 0) {
                    $DaoMaterial->setId_material($this->idMaterial);
                    $DaoMaterial->setNm_material($this->nmMaterial === '' ? null : $this->nmMaterial);
                    $DaoMaterial->setId_unidade_medida($this->idUnidadeMedida);
                    $DaoMaterial->setDt_aquisicao(Metodos::ConverteDataING($this->dtAquisicao) === '--' ? null : Metodos::ConverteDataING($this->dtAquisicao));
                    $DaoMaterial->setQt_meses_garantia($this->qtGarantia === '' ? null : $this->qtGarantia);
                    $DaoMaterial->setNr_patrimonio($this->nmPatrimonio === '' ? null : $this->nmPatrimonio);
                    $DaoMaterial->setVl_preco(Metodos::ConverteValorIng($this->vlPreco) === '' ? null : Metodos::ConverteValorIng($this->vlPreco));
                    $DaoMaterial->setDs_modelo($this->dsModelo === '' ? null : $this->dsModelo);
                    $DaoMaterial->setDs_marca($this->dsMarca === '' ? null : $this->dsMarca);
                    $DaoMaterial->setDs_processador($this->dsProcessador === '' ? null : $this->dsProcessador);
                    $DaoMaterial->setQt_hd($this->qtHd === '' ? null : $this->qtHd);
                    $DaoMaterial->setQt_fonte($this->qtFonte === '' ? null : $this->qtFonte);
                    $DaoMaterial->setFl_wireless($this->wireless === '' ? null : $this->wireless);
                    $DaoMaterial->setTp_estado($this->estado === '' ? null : $this->estado);
                    $DaoMaterial->setQt_memoria_ram($this->qtMemoriaRam === '' ? null : $this->qtMemoriaRam);
                    $DaoMaterial->setNm_serie($this->nmSerie === '' ? null : $this->nmSerie);

                    if ($DaoMaterial->editarMaterial($pdo)) {
                        if (Log::SalvaLogU('cha_material', $DaoMaterial->getId_material(), $dados, $pdo)) {
                            $pdo->commit();
                            return Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    }
                } else {
                    return Metodos::retornoAjax('Erro', 'alert', 'Registro Não Encontrado.');
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function deletarMaterial() {
        try {
            if (empty($this->idMaterial)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            } else {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();

                $DaoMaterial = new DaoChaMaterial();
                $DaoMaterial->setId_material($this->idMaterial);

                if (!$DaoMaterial->deletarMaterial($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                } else {
                    if (!Log::SalvaLogD('cha_material', $DaoMaterial->getId_material(), $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $pdo->commit();
                        return Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function carregarMaterial() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoMaterial = new DaoChaMaterial();
            $daoMaterial->setId_material($this->idMaterial);
            return $daoMaterial->carregarDadosMaterial($pdo);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
