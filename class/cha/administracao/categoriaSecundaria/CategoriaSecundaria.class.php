<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/cha/DaoChaCategoriaSecundaria.class.php";

/**
 * Description of CategoriaTipo
 *
 * @author elivelton
 */
class CategoriaSecundaria {

    private $idCategoriaSecundaria = null;
    private $idCategoriaPrimaria = null;
    private $nmCategoriaSecundaria = null;
    private $vlCategoriaSecundaria = null;
    private $stAtivo = null;
    /* ========================== */
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /* ========================== */

    function getIdCategoriaSecundaria() {
        return $this->idCategoriaSecundaria;
    }

    function getIdCategoriaPrimaria() {
        return $this->idCategoriaPrimaria;
    }

    function getNmCategoriaSecundaria() {
        return $this->nmCategoriaSecundaria;
    }

    function getVlCategoriaSecundaria() {
        return $this->vlCategoriaSecundaria;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdCategoriaSecundaria($idCategoriaSecundaria) {
        $this->idCategoriaSecundaria = $idCategoriaSecundaria;
    }

    function setIdCategoriaPrimaria($idCategoriaPrimaria) {
        $this->idCategoriaPrimaria = $idCategoriaPrimaria;
    }

    function setNmCategoriaSecundaria($nmCategoriaSecundaria) {
        $this->nmCategoriaSecundaria = $nmCategoriaSecundaria;
    }

    function setVlCategoriaSecundaria($vlCategoriaSecundaria) {
        $this->vlCategoriaSecundaria = $vlCategoriaSecundaria;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
    }

    public function cadastrarCategoriaSecundaria() {
        try {
            if (empty($this->nmCategoriaSecundaria && $this->vlCategoriaSecundaria && $this->idCategoriaPrimaria)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->setNmCategoriaSecundaria($this->nmCategoriaSecundaria);
            $dao->setVlCategoriaSecundaria(Metodos::ConverteValorIng($this->vlCategoriaSecundaria));
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);

            $dao->verificaCategoriaSecundaria($pdo);
            if ($dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Categoria Já Existe no Sistema.');
            } else {
                $dao->cadastrarCategoriaSecundaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    $dao->setIdCategoriaSecundaria($pdo->lastInsertId('cha_categoria_secundaria_id_categoria_secundaria_seq'));
                    if (!Log::SalvaLogI('cha_categoria_secundaria', $dao->getIdCategoriaSecundaria(), $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_CADASTRO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function editarCategoriaSecundaria() {
        try {
            if (empty($this->idCategoriaPrimaria && $this->idCategoriaSecundaria && $this->nmCategoriaSecundaria && $this->vlCategoriaSecundaria)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->setIdCategoriaSecundaria($this->idCategoriaSecundaria);
            $dao->setNmCategoriaSecundaria($this->nmCategoriaSecundaria);
            $dao->setVlCategoriaSecundaria(Metodos::ConverteValorIng($this->vlCategoriaSecundaria));
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);

            $dao->retornarCategoriaSecundaria($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaSecundaria($pdo);
            if ($dao->Sucesso()) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Categoria Já Existe no Sistema.');
            } else {
                $dao->editarCategoriaSecundaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_secundaria', $this->getIdCategoriaSecundaria(), $busca, $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_EDICAO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function removerCategoriaSecundaria() {
        try {
            if (empty($this->idCategoriaSecundaria && $this->nmCategoriaSecundaria && $this->vlCategoriaSecundaria && $this->idCategoriaPrimaria)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->setIdCategoriaSecundaria($this->idCategoriaSecundaria);

            $dao->retornarCategoriaSecundaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                if (!Log::SalvaLogD('cha_categoria_secundaria', $this->getIdCategoriaSecundaria(), $pdo)) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                } else {
                    $dao->removerCategoriaSecundaria($pdo);
                    if (!$dao->Sucesso()) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                    } else {
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_REMOCAO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function desativarCategoriaSecundaria() {
        try {
            if (empty($this->idCategoriaSecundaria && $this->nmCategoriaSecundaria && $this->vlCategoriaSecundaria && $this->idCategoriaPrimaria)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->setIdCategoriaSecundaria($this->idCategoriaSecundaria);
            $dao->setNmCategoriaSecundaria($this->nmCategoriaSecundaria);
            $dao->setVlCategoriaSecundaria(Metodos::ConverteValorIng($this->vlCategoriaSecundaria));
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);

            $dao->retornarCategoriaSecundaria($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaSecundaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                $dao->desativarCategoriaSecundaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_secundaria', $this->getIdCategoriaSecundaria(), $busca, $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_DESATIVADO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function ativarCategoriaSecundaria() {
        try {
            if (empty($this->idCategoriaSecundaria && $this->nmCategoriaSecundaria && $this->vlCategoriaSecundaria && $this->idCategoriaPrimaria)) {
                $this->sucesso = TRUE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
                return;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->setIdCategoriaSecundaria($this->idCategoriaSecundaria);
            $dao->setNmCategoriaSecundaria($this->nmCategoriaSecundaria);
            $dao->setVlCategoriaSecundaria(Metodos::ConverteValorIng($this->vlCategoriaSecundaria));
            $dao->setIdCategoriaPrimaria($this->idCategoriaPrimaria);
            $dao->retornarCategoriaSecundaria($pdo);
            $busca = $dao->getMsgRetorno();

            $dao->verificaCategoriaSecundaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', 'Registro Não Existe no Sistema.');
            } else {
                $dao->ativarCategoriaSecundaria($pdo);
                if (!$dao->Sucesso()) {
                    $this->sucesso = FALSE;
                    $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', $dao->getMsgRetorno());
                } else {
                    if (!Log::SalvaLogU('cha_categoria_secundaria', $this->getIdCategoriaSecundaria(), $busca, $pdo)) {
                        $this->sucesso = FALSE;
                        $this->msgRetorno = Metodos::retornoAjax('Erro', 'console', STR_ERROR);
                    } else {
                        $this->sucesso = TRUE;
                        $this->msgRetorno = Metodos::retornoAjax('ok', 'html', STR_ATIVADO_SUCESSO);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function listarCategoriaPrimaria() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->retornaCategoriaPrimaria($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    $this->msgRetorno .= "<option value='" . $linhas['id_categoria_primaria'] . "'>" . $linhas['nm_categoria_primaria'] . "</option>";
                }
            }
            return $this->msgRetorno;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function listarCategoriaSecundarias() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->retornaCategoriaSecundarias($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = Metodos::retornoAjax('Erro', 'alert', $dao->getMsgRetorno());
            } else {
                foreach ($dao->getMsgRetorno() as $linhas) {
                    $this->msgRetorno .= "<option value='" . $linhas['id_categoria_secundaria'] . "'>" . $linhas['nm_categoria_secundaria'] . "</option>";
                }
            }
            return $this->msgRetorno;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function listarCategoriaSecundaria() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $dao = new DaoChaCategoriaSecundaria();
            $dao->listarCategoriaSecundaria($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                foreach ($dao->getMsgRetorno() as $linha) {
                    $this->msgRetorno .= '
                                                <tr>
                                                    <td class="text-center">' . $linha["nm_categoria_secundaria"] . '</td>
                                                    <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_categoria_secundaria"], 2) . '</td>
                                                    <td class="text-center">' . $linha["nm_categoria_primaria"] . '</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" categoriaPrimaria="' . $linha["id_categoria_primaria"] . '" categoriaSecundaria="' . $linha["nm_categoria_secundaria"] . '" vlSecundaria="' . Metodos::ConverteValorBr($linha["vl_categoria_secundaria"], 2) . '"
                                                            value="' . $linha["id_categoria_secundaria"] . '">
                                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value="' . $linha["id_categoria_secundaria"] . '">
                                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                                        </button>';

                    if ($linha['st_ativo'] == '1') {
                        $this->msgRetorno .= '
                                                            <button type="button" class="btn btn-default btn-desativar btn-xs" title="Desativar" value="' . $linha["id_categoria_secundaria"] . '">
                                                                <i class="glyphicon glyphicon-off glyphicon-sm text-success" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                    } else {
                        $this->msgRetorno .= '              <button type="button" class="btn btn-default btn-ativar btn-xs" title="Ativar" value="' . $linha["id_categoria_secundaria"] . '">
                                                                <i class="glyphicon glyphicon-off glyphicon-sm text-default" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                    }
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaOptionCategoriaSecundaria($idCategoriaPrimaria = null, $idCategoriaSecundaria = null) {
        $retorno = "<option value = '0'>Selecione a Categoria Secundária</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $sec = new DaoChaCategoriaSecundaria();

            $sec->setIdCategoriaPrimaria($idCategoriaPrimaria);
            $result = $sec->retornaCategoriasSecundaria($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if (empty($sec->getIdCategoriaPrimaria())) {
                        $retorno .= "<option value = '" . $v['id_categoria_secundaria'] . "'>" . $v['nm_categoria_secundaria'] . " - " . $v['nm_categoria_primaria'] . "</option>";
                    } else {
                        if ($idCategoriaSecundaria == $v['id_categoria_secundaria']) {
                            $retorno .= "<option value = '" . $v['id_categoria_secundaria'] . "' selected>" . $v['nm_categoria_secundaria'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_categoria_secundaria'] . "'>" . $v['nm_categoria_secundaria'] . "</option>";
                        }
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function dominioCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <form id="demo-dropzone" action="#" class="dropzone dz-clickable" style="border-style: dashed; float: center">
                                                                        <div class="dz-default dz-message col-lg-3 control-label" style="border-style: dashed">
                                                                            <div class="dz-icon">
                                                                                <i class="fa fa-cloud-upload fa-5x"></i></br>
                                                                            <span class="dz-text" style="margin-left: 50px">FAZER UPLOAD DE ARQUIVOS</span>
                                                                            <p class="text-sm text-muted">clique para escolher manualmente</p>
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function dominioDesativarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function dominioExluirUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function dominioHabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function dominioRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeAtivacaoDePontoDeRede() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeAtualizacaoDeAplicativosNosServidores() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome do Aplicativo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nmApp" placeholder="Aplicativo" id="nmApp" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeConectorizacaoDeCabos() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Cabos: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtCabos" min="0" placeholder="__" id="qtCabos" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  ';
    }

    /*  public function redeConfeccaoDeLineCord() {
      echo '<div class="form-group" >
      <div class="tab-content clearfix">
      <div class="tab-pane active" id="demo-cir-tab3">
      <div class="form-group">
      <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
      <div class="col-lg-7">
      <select class="form-control" id="id_pessoa" name="id_pessoa" >
      <option value="0">Pessoa não cadastrada no sistema</option>
      <?php
      // echo $lotacoes;
      ?>
      </select>
      </div>
      </div>
      <div class="form-group">
      <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
      <div class="col-lg-7">
      <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="" id="nm_pessoa" required>
      </div>
      </div>
      <div class="form-group">
      <label class="col-lg-3 control-label">Quantidade de Line Cords: <span class="text-danger">*</span></label>
      <div class="col-lg-7">
      <input type="number" class="form-control" name="qtLineCords" min="0" placeholder="" id="qtLineCords" required>
      </div>
      </div>
      <div class="form-group">
      <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
      <div class="col-lg-7">
      <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
      <option value="0">Selecione Lotação</option>
      <?php
      // echo $lotacoes;
      ?>
      </select>
      </div>
      </div>
      <div class="form-group">
      <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
      <div class="col-lg-7">
      <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
      </div>
      </div>
      <div class="form-group">
      <label class="col-lg-3 control-label">Descrição do Problema: </label>
      <div class="col-lg-7">
      <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
      </div>
      </div>
      </div>
      </div>
      </div>';
      } */

    public function redeConfeccaoDeNovoPontoDeRede() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Pontos de Rede: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPontos" min="0" placeholder="" id="qtPontos" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeConfeccaoDePatchCord() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Patch Cords: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPatchCord" min="0" placeholder="" id="qtPatchCord" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeConfiguracaoDeRotasNoGateway() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Endereço da Rota: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="dsIpGateway" placeholder="" id="dsIpGateway" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeConfiguracaoDeVlan() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Pontos de Rede: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPontos" min="0" placeholder="" id="qtPontos" required>
                                                                        </div>
                                                                    </div>                                                                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número da VLAN: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control Vlan" name="nrVlan" min="1" max="4096" placeholder="" id="nrVlan">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label " id="demo_chosen_select_chosen">Andar: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="dsAndar" nm="dsAndar">
                                                                                <option value="0" selected>Selecione o Andar</option>
                                                                                <option value="1">Subsolo</option>
                                                                                <option value="2">Térreo</option>
                                                                                <option value="3">Mezanino</option>
                                                                                <option value="4">1º Andar</option>
                                                                                <option value="5">2º Andar</option>
                                                                                <option value="6">3º Andar</option>
                                                                                <option value="7">4º Andar</option>
                                                                                <option value="8">5º Andar</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeCriacaoConfiguracaoDeVpn() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeInstalacaoSubstituicaoDeSwitch() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeLevantamentoDeMaterialParaMudancaDeLayout() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Computadores: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtComputador" min="0" placeholder="" id="qtComputador" required>
                                                                        </div>
                                                                    </div>     
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Impressoras: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtImpressora" min="0" placeholder="" id="qtImpressora" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Pontos de Rede: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPontos" min="0" placeholder="" id="qtPontos" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label " id="demo_chosen_select_chosen">Andar: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="dsAndar" nm="dsAndar">
                                                                                <option value="0" selected>Selecione o Andar</option>
                                                                                <option value="1">Subsolo</option>
                                                                                <option value="2">Térreo</option>
                                                                                <option value="3">Mezanino</option>
                                                                                <option value="4">1º Andar</option>
                                                                                <option value="5">2º Andar</option>
                                                                                <option value="6">3º Andar</option>
                                                                                <option value="7">4º Andar</option>
                                                                                <option value="8">5º Andar</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label"></label>
                                                                        <div class="col-lg-7">
                                                                            <strong>É OBRIGATÓRIO ANEXAR A PLANTA DO NOVO LAYOUT, CASO CONTRÁRIO O CHAMADO NÃO PODERÁ SER REALIZADO <span class="text-danger">*</span></strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeManutencaoDeConectorKeystone() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Keystones: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtKeystone" min="1" placeholder="" id="qtKeystone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeManutencaoDeConectorRj45() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de RJ45: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtRj45" min="1" placeholder="" id="qtRj45" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeManutencaoDeRack() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Racks: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtRack" min="1" placeholder="" id="qtRack" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redePermissaoDeAcesso() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label " id="demo_chosen_select_chosen">Tipo de Permissão: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="tpLiberacao" nm="tpLiberacao">
                                                                                <option value="0" selected>Selecione o Tipo de Permissão</option>
                                                                                <option value="1">Celular</option>
                                                                                <option value="2">Notebook</option>
                                                                                <option value="3">Pasta Compartilhada</option>
                                                                                <option value="4">Tablet</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome da Pasta: <i class="fa fa-question-circle text-danger" title="Preencha quando o Tipo de Permissão for Pasta Compartilhada"></i></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nmPasta" placeholder="Pasta" id="nmPasta" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeRemanejamentoDePontoDeRede() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Pontos de Rede: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPontos" min="0" placeholder="" id="qtPontos" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Local de Origem: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Local de Destino: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição detalhada do destino do ponto de rede" rows="4" class="form-control" id="dsDestino" name="dsDestino"></textarea>
                                                                        </div>
                                                                    </div>   
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Justificativa: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Justificativa" rows="6" class="form-control" id="dsJustificativa" name="dsJustificativa"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeServicoDeEstruturacaoDeRede() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Computadores: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtComputador" min="0" placeholder="" id="qtComputador" required>
                                                                        </div>
                                                                    </div>     
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Impressoras: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtImpressora" min="0" placeholder="" id="qtImpressora" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Pontos de Rede: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPontos" min="0" placeholder="" id="qtPontos" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label " id="demo_chosen_select_chosen">Andar: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="dsAndar" nm="dsAndar">
                                                                                <option value="0" selected>Selecione o Andar</option>
                                                                                <option value="1">Subsolo</option>
                                                                                <option value="2">Térreo</option>
                                                                                <option value="3">Mezanino</option>
                                                                                <option value="4">1º Andar</option>
                                                                                <option value="5">2º Andar</option>
                                                                                <option value="6">3º Andar</option>
                                                                                <option value="7">4º Andar</option>
                                                                                <option value="8">5º Andar</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label"></label>
                                                                        <div class="col-lg-7">
                                                                            <strong>É OBRIGATÓRIO ANEXAR A PLANTA DO LAYOUT DAS MESAS, CASO CONTRÁRIO O CHAMADO NÃO PODERÁ SER REALIZADO <span class="text-danger">*</span></strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeServicoDeReestruturacaoDeRede() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Computadores: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtComputador" min="0" placeholder="" id="qtComputador" required>
                                                                        </div>
                                                                    </div>     
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Impressoras: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtImpressora" min="0" placeholder="" id="qtImpressora" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Quantidade de Pontos de Rede: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="number" class="form-control" name="qtPontos" min="0" placeholder="" id="qtPontos" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label " id="demo_chosen_select_chosen">Andar: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="dsAndar" nm="dsAndar">
                                                                                <option value="0" selected>Selecione o Andar</option>
                                                                                <option value="1">Subsolo</option>
                                                                                <option value="2">Térreo</option>
                                                                                <option value="3">Mezanino</option>
                                                                                <option value="4">1º Andar</option>
                                                                                <option value="5">2º Andar</option>
                                                                                <option value="6">3º Andar</option>
                                                                                <option value="7">4º Andar</option>
                                                                                <option value="8">5º Andar</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label"></label>
                                                                        <div class="col-lg-7">
                                                                            <strong>É OBRIGATÓRIO ANEXAR A PLANTA DO LAYOUT DAS MESAS, CASO CONTRÁRIO O CHAMADO NÃO PODERÁ SER REALIZADO <span class="text-danger">*</span></strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function redeVerificacaoDeCabeamentoDeRede() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span> </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function cadWebCriarUsuario() {
        echo '    <div class="form-group"  >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required >
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function cadWebDesabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="Cartão do Sus" id="nr_cns" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function cadWebExcluirUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="Cartão do Sus" id="nr_cns" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function cadWebHabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="Cartão do Sus" id="nr_cns" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function cadWebOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="Cartão do Sus" id="nr_cns" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function cadWebRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="Cartão do Sus" id="nr_cns" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function emailCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRamal" name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Vínculo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Vinculo" id="id_vinculo1" name="id_vinculo1" >
                                                                                <option value="0">Selecione o Vínculo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function emailCriarEmailParaDepartamento() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome do Responsável: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                                                                            
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone do Responsável: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Departamento: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone do Departamento: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Sugestão de Login: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nm_sugestivo" placeholder="departamento.teste@ac.gov.br" id="nm_sugestivo" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function emailOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) _ ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Vínculo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Vinculo" id="id_vinculo1" name="id_vinculo1" >
                                                                                <option value="0">Selecione o Vínculo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function emailRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) _ ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Vínculo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Vinculo" id="id_vinculo1" name="id_vinculo1" >
                                                                                <option value="0">Selecione o Vínculo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div><div class="form-group">
                                                                        <label class="col-lg-3 control-label">Escolaridade: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_escolaridade1" name="id_escolaridade1" >
                                                                                <option value="0">Selecione a Escolaridade</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>  
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepDesabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepHabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepPermissoes() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissões: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição das Permissões Desejadas" rows="4" class="form-control" id="nmPermissao" name="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function gepTreinamento() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>                                                                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control" id="nrParticipantes">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissão: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição da Permissão Desejada" rows="6" class="form-control" name="nmPermissao" id="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpDesabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpHabilitarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpPermissoes() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissão: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição da Permissão Desejada" rows="4" class="form-control" name="nmPermissao" id="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>      
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="Nome" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function grpTreinamento() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>                                                                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: </label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubAdicionarNovoExame() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>         
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome do Exame: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nm_exame" placeholder="Nome do Exame" id="nm_exame" required>
                                                                        </div>
                                                                    </div>                                                                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Parâmetro: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Parâmetro do Exame" rows="6" class="form-control" name="ds_exame_parametro" id="ds_exame_parametro"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubCadastroDeProfissional() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                             
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__"" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome do Conselho: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nm_conselho" placeholder="Nome do Conselho" id="nm_conselho" required>
                                                                        </div>
                                                                    </div>      
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número do Conselho: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nr_conselho" placeholder="Número do Conselho" id="nr_conselho" required>
                                                                        </div>
                                                                    </div>      
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="Cartão do Sus" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control " id="" name="" >
                                                                                <option value="0">Selecione a Função</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Senha Desejada: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="ds_senha_desejada" placeholder="Senha" id="ds_senha_desejada" required>
                                                                        </div>
                                                                    </div>                                                                                                                          
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissão: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Permissão" rows="4" class="form-control" name="nmPermissao" id="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubGerarPlanilhaDeAtendimento() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>      
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Data Inicial: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="#dt_inicial" placeholder="__/__/____" id="dt_inicial" required>
                                                                        </div>
                                                                    </div>      
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Data Final: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="#dt_fim" placeholder="__/__/____" id="dt_fim" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Email: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dsEmail" name="nm_email" placeholder="exemplo@ac.gov.br" id="nm_email" required>
                                                                        </div>
                                                                    </div>                                                                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubPermissoes() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome do Conselho: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nm_conselho" placeholder="Nome do Conselho" id="nm_conselho" required>
                                                                        </div>
                                                                    </div>      
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número do Conselho: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nr_conselho" placeholder="Número do Conselho" id="nr_conselho" required>
                                                                        </div>
                                                                    </div>      
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissões: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição das Permissões Desejadas" rows="4" class="form-control" id="nmPermissao" name="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function hospubRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Senha Desejada: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="dsSenhaDesejada" placeholder="Senha" id="dsSenhaDesejada" required>
                                                                        </div>
                                                                    </div>                                                                       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control" id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function kanbanCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissões: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição das Permissões Desejadas" rows="4" class="form-control" id="nmPermissao" name="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function kanbanRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function pesCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>                         
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Data de Nascimento: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control dtNascimento" name="dt_nascimento" placeholder="__/__/____" id="dt_nascimento" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">País Naturalidade: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control pais" id="id_pais_naturalidade" name="id_pais_naturalidade" >
                                                                                <option value="0">Selecione o País de Naturalidade</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                          
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label chosen-container chosen-container-single" id="demo_chosen_select_chosen">Sexo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control chosen-single" id="tp_sexo">
                                                                                <option value="0" selected>Selecione o Sexo</option>
                                                                                <option value="1">Feminino</option>
                                                                                <option value="2">Masculino</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                           
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Estado Civíl: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control estadoCivil" id="id_estado_civil1" name="id_estado_civil1" >
                                                                                <option value="0">Selecione o Estado Civíl</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                                                                   
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Matrícula: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrMatricula" name="nr_matricula" placeholder="Matrícula" id="nr_matricula" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cnes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="cdCnes" placeholder="Código Cnes" id="cdCnes" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>                  
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Função: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Funcao" id="id_funcao1" name="id_funcao1" >
                                                                                <option value="0">Selecione a Função</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Vínculo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Vinculo" id="id_vinculo1" name="id_vinculo1" >
                                                                                <option value="0">Selecione o Vínculo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissões: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição das Permissões Desejadas" rows="4" class="form-control" id="nmPermissao" name="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function pesOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>            
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function pesPermissoes() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>            
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Permissões: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição das Permissões Desejadas" rows="4" class="form-control" id="nmPermissao" name="nmPermissao"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function pesRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>            
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function pesTreinamento() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control" id="nrParticipantes">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function sesacrenetCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control" id="nrParticipantes">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function sesacrenetOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control" id="nrParticipantes">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function sesacrenetPermissoes() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control" id="nrParticipantes">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function sesacrenetRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cartão do Sus: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCartaoSus" name="nr_cns" placeholder="___ ____ ____ ____" id="nr_cns" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número de Participantes: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="__" class="form-control" id="nrParticipantes">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function siagCadastrarSetor() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Responsável Pelo Setor: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nmSetor" placeholder="Nome da Lotação" id="nmSetor" required>
                                                                        </div>
                                                                    </div>                                                                                         
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número do Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nrTelefoneSetor" placeholder="(    ) ____-____" id="nrTelefoneSetor" required>
                                                                        </div>
                                                                    </div>                                                                           
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Número da Portaria: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control" name="nrPortaria" placeholder="Portaria Nº" id="nrPortaria" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function siagCriarUsuario() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Código da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="Código da Lotação" class="form-control" id="cdSetor" name="cdSetor">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function siagGerarEtiquetas() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Código da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="Código da Lotação" class="form-control" id="cdSetor" name="cdSetor">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function siagOutros() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Código da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="Código da Lotação" class="form-control" id="cdSetor" name="cdSetor">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function siagRedefinirSenha() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">RG: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrRg" name="nr_rg" placeholder="RG" id="nr_rg" required>
                                                                        </div>
                                                                    </div>     
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Cargo: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Cargo" id="id_cargo1" name="id_cargo1" >
                                                                                <option value="0">Selecione o Cargo</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>          
                                                                     <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Código da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" placeholder="Código da Lotação" class="form-control" id="cdSetor" name="cdSetor">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

    public function siagTrocarDeSetor() {
        echo '<div class="form-group" >
                                                            <div class="tab-content clearfix">
                                                                <div class="tab-pane active" id="demo-cir-tab3">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Chamado Para: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control" id="id_pessoa" name="id_pessoa" >
                                                                                <option value="0">Pessoa não cadastrada no sistema</option>
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Nome: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nmPessoa" name="nm_pessoa" placeholder="Nome" id="nm_pessoa" required>
                                                                        </div>
                                                                    </div>                                                                       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">CPF: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control nrCpf" name="nr_cpf" placeholder="___.___.___-__" id="nr_cpf" required>
                                                                        </div>
                                                                    </div>       
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nrTelefone" placeholder="(    ) _ ____-____" id="nrTelefone" required>
                                                                        </div>
                                                                    </div>        
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Lotação de Destino: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <select class="form-control Lotacao" id="id_lotacao1" name="id_lotacao1" >
                                                                                <option value="0">Selecione Lotação</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Telefone da Lotação: <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-7">
                                                                            <input type="text" class="form-control " name="nr_telefone" placeholder="(    ) ____-____" id="nr_telefone" required>
                                                                        </div>
                                                                    </div>
                                                                                                                                        <div class="form-group">
                                                                        <label class="col-lg-3 control-label">Descrição do Problema: </label>
                                                                        <div class="col-lg-7">
                                                                            <textarea placeholder="Descrição do Problema" rows="6" class="form-control"  id="dsProblema" name="dsProblema"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> ';
    }

}
