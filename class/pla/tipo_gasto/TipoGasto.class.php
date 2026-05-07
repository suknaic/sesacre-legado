<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaTipoGasto.class.php";

class TipoGasto {

    private $idTipoGasto = null;
    private $nmTipoGasto = null;

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getNmTipoGasto() {
        return $this->nmTipoGasto;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
    }

    function setNmTipoGasto($nmTipoGasto) {
        $this->nmTipoGasto = $nmTipoGasto;
    }

    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */
    public function cadastrar($perfil) {
        try {

            //Verifica se os campos foram preenchidos
            if ($this->idPtaAcao == "" || $this->nmPtaAcaoDet == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();


            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if ($perfil != 1) {
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if (!$this->verificaPermissaoPtaAcaoDet($this->idPtaAcao, $pdo)) {
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }
            }

            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();

            $pad->setIdPtaAcao($this->idPtaAcao);
            $pad->setNmPtaAcaoDet($this->nmPtaAcaoDet);

            //Insere o Registro no banco
            $result = $pad->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Pega o ID Inserido                                                                                         
            $pad->setIdPtaAcaoDet($pdo->lastInsertId('pla_pta_acao_det_id_pta_acao_det_seq'));
            //Salva no Log
            $sucesso = false;
            if (Log::SalvaLogI('pla_pta_acao_det', $pad->getIdPtaAcaoDet(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Detalhemento da Ação Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * Edita Um registro Referente a essa classe
     * @return string
     */
    public function editar($perfil) {
        try {

            //Verifica se os campos foram preenchidos
            if ($this->nmPtaAcaoDet == "" || $this->idPtaAcaoDet == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();

            $pad->setIdPtaAcaoDet($this->idPtaAcaoDet);
            $pad->setNmPtaAcaoDet($this->nmPtaAcaoDet);

            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pad->retornaPtaAcaoDet($pdo);

            $this->setIdPtaAcao($busca['id_pta_acao']);

            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if ($perfil != 1) {
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if (!$this->verificaPermissaoPtaAcaoDet($this->idPtaAcao, $pdo)) {
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }
            }

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            //Edita o Registro no banco
            $result = $pad->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Salva no Log
            $sucesso = false;
            if (!Log::SalvaLogU('pla_pta_acao_det', $pad->getIdPtaAcaoDet(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }

            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                              
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição Realizada com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * Remove Um registro Referente a essa classe
     * @return string
     */
    public function remover($perfil) {
        try {

            //Verifica se enviou o campo.                   
            if ($this->idPtaAcaoDet == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();

            $pad->setIdPtaAcaoDet($this->idPtaAcaoDet);

            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $pad->retornaPtaAcaoDet($pdo);


            $this->setIdPtaAcao($busca['id_pta_acao']);

            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if ($perfil != 1) {
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if (!$this->verificaPermissaoPtaAcaoDet($this->idPtaAcao, $pdo)) {
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }
            }


            //Salva no Log            
            if ($busca) {
                if (!Log::SalvaLogD('pla_pta_acao_det', $pad->getIdPtaAcaoDet(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Detalhamento da Ação.");
                $pdo->rollBack();
                return $retorno;
            }

            //Remove o Registro no banco
            $resultDao = $pad->delete($pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                                                                                                                                                              
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Detalhemento da Ação removido com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * Retorna os Boxes com os tipos de Gastos     
     * @param int $idPtaTitulo 
     * @return string
     */
    public function retornaBox(int $idPtaTitulo) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tg = new DaoPlaTipoGasto();

            $result = $tg->retornaTodosPlaTipoGasto($pdo);


            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {

                    $idTipoGasto = $v['id_tipo_gasto'];

                    $retorno .= '<div class="col-sm-4">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">' . $v['nm_tipo_gasto'] . '</p>                                        
                                        <div class="mar-top">                                                                                        
                                            <a href="itens.php?token=' . $idPtaTitulo . '&tokenT=' . $v['id_tipo_gasto'] . '" class="btn btn-primary btn-rounded btn-entrar" title="Entrar"> 
                                                Entrar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    /**
     * 
     * @param int $idTipoGasto
     * @param type $pdo
     * @return string
     */
    public function retornaOption(int $idTipoGasto = null, $pdo = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $tg = new DaoPlaTipoGasto();

            $result = $tg->retornaTodosPlaTipoGasto($pdo);

            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    if ($v['id_tipo_gasto'] == $idTipoGasto) {
                        $retorno .= "<option selected value=" . $v['id_tipo_gasto'] . ">" . $v['nm_tipo_gasto'] . "</option>";
                    } else {
                        $retorno .= "<option value=" . $v['id_tipo_gasto'] . ">" . $v['nm_tipo_gasto'] . "</option>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function carregaDados() {

        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tg = new DaoPlaTipoGasto();
            $tg->setIdTipoGasto($this->idTipoGasto);
            $result = $tg->retornaPlaTipoGasto($pdo);

            if (!$result) {
                
            } else {
                $this->nmTipoGasto = $result['nm_tipo_gasto'];
            }
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaTipoGastoElemento(int $idTipoGasto = null, int $idDespesaElemento = null, $pdo = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $tg = new DaoPlaTipoGasto();
            $tg->setIdTipoGasto($idTipoGasto);
            $result = $tg->retornaElementoTipoGasto($pdo);

            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    if ($v['id_despesa_elemento'] == $idDespesaElemento) {
                        $retorno .= "<option selected value=" . $v['id_despesa_elemento'] . ">" . $v['cd_despesa_elemento'] . "-" . $v['ds_despesa_elemento'] . "</option>";
                    } else {
                        $retorno .= "<option value=" . $v['id_despesa_elemento'] . ">" . $v['cd_despesa_elemento'] . "-" . $v['ds_despesa_elemento'] . "</option>";
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
