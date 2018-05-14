<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinAta.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/processo/DaoProcesso.class.php";

class FinAtaModel {


    
    public function cadastraAta() {
        try {
            if (empty($this->idPessoa) || empty($this->nrAta) || empty($this->dsObjeto) || empty($this->idProcesso) ||
                    empty($this->dtIniVigenciaAta) || empty($this->dtFimVigenciaAta) || empty($this->dtAssinatura) ||
                    empty($this->dtPublicacao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoAta = new DaoFinAta();
            $sucesso = true;
            //Seta os campos
            $daoAta->setIdProcesso($this->idProcesso);
            $daoAta->setNrAta($this->nrAta);
            $daoAta->setDsObjeto($this->dsObjeto);
            $daoAta->setDtIniVigenciaAta(Metodos::ConverteDataING($this->dtIniVigenciaAta));
            $daoAta->setDtFimVigenciaAta(Metodos::ConverteDataING($this->dtFimVigenciaAta));
            $daoAta->setDtAssinatura(Metodos::ConverteDataING($this->dtAssinatura));
            $daoAta->setDtPublicacao(Metodos::ConverteDataING($this->dtPublicacao));
            $daoAta->setDsObsAta($this->dsObsAta);
            $daoAta->setFlCarona($this->flCarona);
            $daoAta->setOrgaoGerenciador($this->orgaoGerenciador);
            //cadastrar ata no banco
            $daoAta->cadastrarAta($pdo);
            if (!$daoAta->sucesso()) {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoAta->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            //pegando id da ata
            $daoAta->setIdAta($pdo->lastInsertId('fin_ata_id_ata_seq'));
            //cadastrar centrais
            if (!empty($this->idLotacao)) {
                $finCentraisModel = new FinCentraisModel();

                foreach ($this->idLotacao as $valor) {
                    $finCentraisModel->setIdAta($daoAta->getIdAta());
                    $finCentraisModel->setIdLotacao($valor);
                    $finCentraisModel->cadastrarCentralAta($pdo);
                    if (!$finCentraisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }

                    if ($sucesso == false) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $daoAta->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }

            //cadastrar gestor titular
            if (!empty($this->idPessoaGestor)) {
                $finGestor = new FinGestorModel();
                foreach ($this->idPessoaGestor as $valor) {
                    $finGestor->setIdPessoa($valor);
                    $finGestor->setIdAta($daoAta->getIdAta());
                    $finGestor->setTpGestor(1);
                    $finGestor->cadastraGestor($pdo);

                    if (!$finGestor->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar gestor substituto
            if (!empty($this->idGestoresSub)) {
                $finGestor = new FinGestorModel();
                foreach ($this->idGestoresSub as $valor) {
                    $finGestor->setIdPessoa($valor);
                    $finGestor->setIdAta($daoAta->getIdAta());
                    $finGestor->setTpGestor(2);
                    $finGestor->cadastraGestor($pdo);

                    if (!$finGestor->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar fiscal
            if (!empty($this->idPessoaFiscal)) {
                $finFiscaisModel = new FinFiscaisModel();
                foreach ($this->idPessoaFiscal as $valor) {
                    $finFiscaisModel->setIdPessoa($valor);
                    $finFiscaisModel->setIdAta($daoAta->getIdAta());
                    $finFiscaisModel->setTpFiscal(1);
                    $finFiscaisModel->cadastraFiscal($pdo);

                    if (!$finFiscaisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar fiscal substituto
            if (!empty($this->idPessoaFiscalSub)) {
                $finFiscaisModel = new FinFiscaisModel();
                foreach ($this->idPessoaFiscalSub as $valor) {
                    $finFiscaisModel->setIdPessoa($valor);
                    $finFiscaisModel->setIdAta($daoAta->getIdAta());
                    $finFiscaisModel->setTpFiscal(2);
                    $finFiscaisModel->cadastraFiscal($pdo);

                    if (!$finFiscaisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar Subfiscal
            if (!empty($this->idPessoaSubFiscal)) {
                $subFiscalModel = new SubFiscalModel();
                foreach ($this->idPessoaSubFiscal as $valor) {
                    $subFiscalModel->setIdPessoa($valor);
                    $subFiscalModel->setIdAta($daoAta->getIdAta());
                    $subFiscalModel->setTpSubFiscal(1);
                    $subFiscalModel->cadastraSubFiscal($pdo);

                    if (!$subFiscalModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar Subfiscal substituto
            if (!empty($this->idPessoaSubFiscalSub)) {
                $subFiscalModel = new SubFiscalModel();
                foreach ($this->idPessoaSubFiscalSub as $valor) {
                    $subFiscalModel->setIdPessoa($valor);
                    $subFiscalModel->setIdAta($daoAta->getIdAta());
                    $subFiscalModel->setTpSubFiscal(2);
                    $subFiscalModel->cadastraSubFiscal($pdo);

                    if (!$subFiscalModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar fornecedor
            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdAta($daoAta->getIdAta());
            $fornecedor->setIdPessoa($this->idPessoa);
            $fornecedor->cadastrarFornecedores($pdo);
            if (!$fornecedor->sucesso()) {
                $sucesso = false;
            }

            //cadastrar vigencia
            $daoAta->cadastrarVigenciaATa($pdo);
            //pegando id da vigencia
            $idVigencia = (is_numeric($pdo->lastInsertId('fin_vigencia_id_vigencia_seq'))) ? $pdo->lastInsertId('fin_vigencia_id_vigencia_seq') : null;
            //log da vigencia da ata
            if (!Log::SalvaLogI('fin_vigencia', $idVigencia, $pdo)) {
                $sucesso = false;
            }

            //log do cadastramento da ata
            if (!Log::SalvaLogI('fin_ata', $daoAta->getIdAta(), $pdo)) {
                $sucesso = false;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", $fornecedor->getMsgRetorno());
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * [retornaLicitacaoGcon esse metodo foi criado só para teste tem que ser retirado a sim que criar a classe do gcon]
     * @return [type] [retorna um array com os dados do gcon de acordo com alguma licitação]
     */
    public function retornaLicitacaoGcon() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoAta = new DaoFinAta();
            $result = array();
            $retorno = '';
            //fim de variaveis
            $result = $daoAta->retornaProcessoCombo($pdo);
            foreach ($result as $value) {
                $retorno .= '<tr class="selecionaItem" processo="' . $value["id_processo"] . '" style="cursor:pointer;">
                <td>' . $value["cd_ada_cpr"] . '</td>
                <td>' . $value["cd_pregao"] . '</td>
                <td>' . $value["tipo_gasto"] . '</td>
                <td>' . $value["nm_objeto"] . '</td>
                <td>' . $value["modalidade"] . '</td>
                </tr>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function retornaTipoDeGastoLicitacao($idProcesso) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $licitacao = new DaoProcesso();
            $licitacao->setIdProcesso($idProcesso);
            $retorno = '<option value = "">Seleciona um tipo de gasto</option>';

            $busca = $licitacao->retornaTiposGastoProcesso($pdo);
            foreach ($busca as $value) {
                if (count($busca) > 1) {
                    $retorno .= '<option value = "' . $value["id_tipo_gasto"] . '">' . $value["nm_tipo_gasto"] . '</option>';
                } else {
                    $retorno .= '<option value = "' . $value["id_tipo_gasto"] . '" selected>' . $value["nm_tipo_gasto"] . '</option>';
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function optionsOrgaoGerenciador($id = null) {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoAta = new DaoFinAta();
            $result = array();
            $retorno = '<div class="form-group">
                        	<div class="col-sm-5">
                            	<div class="panel-body">
                                	<div class="checkbox">
                                     	Orgão gerenciador
                                        	<select class="form-control select" name="orgaoGerenciador" id="orgaoGerenciador" required="true">
                                            	<option value="" selected>Selecione um orgão gerenciador</option>';
            //fim de variaveis
            $daoAta->retornaOrgaoGerenciador($pdo);
            $result = $daoAta->getMsgRetorno();
            if (empty(!$result)) {
                foreach ($result as $value) {
                    if ($id == $value["id_orgao_gerenciador"]) {
                        $retorno .= '<option value = "' . $value["id_orgao_gerenciador"] . '" selected>' . $value["nm_pessoa"] . '</option>';
                    } else {
                        $retorno .= '<option value = "' . $value["id_orgao_gerenciador"] . '">' . $value["nm_pessoa"] . '</option>';
                    }
                }
            }
            $retorno .= '</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7"></div>
                        </div>';
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaOptionsAtas($id = null, $condicao = '') {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoAta = new DaoFinAta();
            $result = array();
            $retorno = '<option value="">Selecionar uma ATA</option>';
            //fim de variaveis
            $daoAta->retornaAtaParaContrato($pdo, $condicao);

            if ($daoAta->sucesso()) {
                foreach ($daoAta->getMsgRetorno() as $value) {
                    if ($value["id_contrato"] == $id) {
                        $retorno .= '<option value="' . $value["id_contrato"] . '" selected>' . $value["contrato_numero"] . '-' . $value["resumo_objeto"] . '</option>';
                    } else {
                        $retorno .= '<option value="' . $value["id_contrato"] . '">' . $value["contrato_numero"] . '-' . $value["resumo_objeto"] . '</option>';
                    }
                }
            }

            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
