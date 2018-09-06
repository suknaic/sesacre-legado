<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinAutorizaAtividade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinAutorizaCentral.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinAutorizaOrcamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinAutorizacaoFinanceiro.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinAutorizacaoOrdenado.class.php";

class Autorizacao {

    private $dt_ini = null;
    private $dt_fim = null;
    private $sit_ativo = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    private $tipo_autorizacao = null;
    private $msgErros = null;
    private $id_autorizacao = null;

    public function getIdAutorizacao() {
        return $this->id_autorizacao;
    }

    public function getDtIni() {
        return $this->dt_ini;
    }

    public function getDtFim() {
        return $this->dt_fim;
    }

    public function getSitAtivo() {
        return $this->sit_ativo;
    }

    public function getTipoAutorizacao() {
        return $this->tipo_autorizacao;
    }

    public function setIdAutorizacao($id_autorizacao) {
        $this->id_autorizacao = $id_autorizacao;
    }

    public function setTipoAutorizacao($tipo_autorizacao) {
        $this->tipo_autorizacao = $tipo_autorizacao;
    }

    public function setDtIni($dt_ini) {
        $this->dt_ini = $dt_ini;
    }

    public function setDtFim($dt_fim) {
        $this->dt_fim = $dt_fim;
    }

    public function setSitAtivo($sit_ativo) {
        $this->sit_ativo = $sit_ativo;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    public function getMsgErros() {
        return $this->msgErros;
    }

    public function getTiposAutorizacoes() {
        //O atributo "lotacao" indica se na tabela que irá gravar a autorização existe 
        //a informação de lotação(id_lotacao)
        $tipos_autorizacoes = array(
            1 => array("tipo" => "Atividade", "lotacao" => 1),
            2 => array("tipo" => "Central", "lotacao" => 1),
            3 => array("tipo" => "Orçamento", "lotacao" => 0),
            4 => array("tipo" => "Financeiro", "lotacao" => 0),
            5 => array("tipo" => "Ordenado", "lotacao" => 0)
        );
        return $tipos_autorizacoes;
    }

    public function selectTiposAutorizacoes() {
        $optionsTpAut = '';
        //Preenche os options value dos tipos de autorizações
        foreach ($this->getTiposAutorizacoes() as $key => $value) {
            $optionsTpAut .= '<option value="' . $key . '" lotacao="' . $value["lotacao"] . '">' . $value["tipo"] . '</option>';
        }

        return $optionsTpAut;
    }

    public function validaAutorizacao() {
        try {
            //Valida se é uma data Válida
            if (!Metodos::ValidaData(Metodos::ConverteDataING($this->getDtIni()), 'Y-m-d') || !Metodos::ValidaData(Metodos::ConverteDataING($this->getDtFim()), 'Y-m-d')) {

                $this->msgErros = "Informe uma data válida.";
                return false;
            }

            $data_inicio = new DateTime(Metodos::validaConverteDataING($this->getDtIni()));
            $data_fim = new DateTime(Metodos::validaConverteDataING($this->getDtFim()));

            //Data de início não pode ser menor que a data fim
            if ($data_inicio > $data_fim) {
                $this->msgErros = "Data de início deve ser maior ou igual que a data fim.";
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaAutorizacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $retorno = '';

            switch ($this->getTipoAutorizacao()) {
                case 1: //*********Autoriza Atividade*****************
                    $retorno = $this->retornaAutorizaAtividade($pdo);
                    break;
                case 2: //*********Autoriza Central*******************
                    $retorno = $this->retornaAutorizaCentral($pdo);
                    break;
                case 3: //*********Autoriza Orçamento*****************
                    $retorno = $this->retornaAutorizaOrcamento($pdo);
                    break;
                case 4: //*********Autorizaçao Financeiro*************
                    $retorno = $this->retornaAutorizacaoFinanceiro($pdo);
                    break;
                case 5: //*********Autorização Ordenado***************
                    $retorno = $this->retornaAutorizacaoOrdenado($pdo);
                    break;
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //***************************SALVA AUTORIZAÇÃO******************************
    public function salvarAutorizacao() {
        try {
            if ($this->validaAutorizacao()) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                switch ($this->getTipoAutorizacao()) {
                    case 1: //*********Autoriza Atividade*****************
                        $retono = $this->salvaAutorizaAtividade($pdo);
                        break;
                    case 2: //*********Autoriza Central*******************
                        $retono = $this->salvaAutorizaCentral($pdo);
                        break;
                    case 3: //*********Autoriza Orçamento*****************
                        $retono = $this->salvaAutorizaOrcamento($pdo);
                        break;
                    case 4: //*********Autorizaçao Financeiro*************
                        $retono = $this->salvaAutorizacaoFinanceiro($pdo);
                        break;
                    case 5: //*********Autorização Ordenado***************
                        $retono = $this->salvaAutorizacaoOrdenado($pdo);
                        break;
                }
                return $retono;
            } else {
                return Metodos::retornoAjax("Erro", "alert", $this->msgErros);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //***************************EXCLUI AUTORIZAÇÃO*****************************
    public function excluiAutorizacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            switch ($this->getTipoAutorizacao()) {
                case 1: //*********Autoriza Atividade*****************
                    $retono = $this->excluiAutorizacaoAtividade($pdo);
                    break;
                case 2: //*********Autoriza Central*******************
                    $retono = $this->excluiAutorizacaoCentral($pdo);
                    break;
                case 3: //*********Autoriza Orçamento*****************
                    $retono = $this->excluiAutorizacaoOrcamento($pdo);
                    break;
                case 4: //*********Autorizaçao Financeiro*************
                    $retono = $this->excluiAutorizacaoFinanceiro($pdo);
                    break;
                case 5: //*********Autorização Ordenado***************
                    $retono = $this->excluiAutorizacaoOrdenado($pdo);
                    break;
            }
            return $retono;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //**************************ATUALIZA AUTORIZAÇÕES***************************
    public function atualizaAutorizacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            switch ($this->getTipoAutorizacao()) {
                case 1: //*********Autoriza Atividade*****************
                    $retorno = $this->atualizaAutorizacaoAtividade($pdo);
                    break;
                case 2: //*********Autoriza Central*******************
                    $retorno = $this->atualizaAutorizacaoCentral($pdo);
                    break;
                case 3: //*********Autoriza Orçamento*****************
                    $retorno = $this->atualizaAutorizacaoOrcamento($pdo);
                    break;
                case 4: //*********Autorizaçao Financeiro*************
                    $retorno = $this->atualizaAutorizacaoFinanceiro($pdo);
                    break;
                case 5: //*********Autorização Ordenado***************
                    $retorno = $this->atualizaAutorizacaoOrdenado($pdo);
                    break;
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //**************************LISTA AUTORIZAÇÕES******************************
    public function listaAutorizacoes() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $retorno = "";
            switch ($this->getTipoAutorizacao()) {
                case 1: //LISTA AUTORIZAÇÕES DE ATIVIDADE
                    $retorno = $this->listaAutorizacoesAtividade($pdo);
                    break;
                case 2: //LISTA AUTORIZAÇÕES DA CENTRAL
                    $retorno = $this->listaAutorizacoesCentral($pdo);
                    break;
                case 3: //LISTA AUTORIZAÇÕES DE ORÇAMENTO
                    $retorno = $this->listaAutorizacoesOrcamento($pdo);
                    break;
                case 4: //LISTA AUTORIZAÇÕES DO FINANCEIRO
                    $retorno = $this->listaAutorizacoesFinanceiro($pdo);
                    break;
                case 5: //LISTA AUTORIZAÇÕES DE ORDENADO
                    $retorno = $this->listaAutorizacoesOrdenado($pdo);
                    break;
                default: //TODAS AUTORIZAÇÕES
                    $retorno .= $this->listaAutorizacoesAtividade($pdo);
                    $retorno .= $this->listaAutorizacoesCentral($pdo);
                    $retorno .= $this->listaAutorizacoesOrcamento($pdo);
                    $retorno .= $this->listaAutorizacoesFinanceiro($pdo);
                    $retorno .= $this->listaAutorizacoesOrdenado($pdo);
                    break;
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //----------------------------FUNÇÕES PRIVADAS-----------------------------

    private function listaAutorizacoesAtividade(PDO $pdo) {
        try {
            $daoFinAutorizaAtividade = new DaoFinAutorizaAtividade();
            $daoFinAutorizaAtividade->setIdLotacao($this->getIdLotacao());
            $daoFinAutorizaAtividade->setIdPessoa($this->getIdPessoa());

            $daoFinAutorizaAtividade->selectAll($pdo);
            $retorno = '';

            if ($daoFinAutorizaAtividade->sucesso()) {
                $tabela = $daoFinAutorizaAtividade->getMsgRetorno();

                foreach ($tabela as $linha) {
                    $retorno .= '<tr>'
                            . '<td>' . $linha['nm_pessoa'] . '</td>'
                            . '<td>' . $linha['nm_lotacao'] . '</td>'
                            . '<td>' . $linha['dt_ini'] . '</td>'
                            . '<td>' . $linha['dt_fim'] . '</td>'
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"
                                        title="Editar" tp_aut="1" value=' . $linha['id_autoriza_atividade'] . ' >
                                        <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>'
                            . '</button>'
                            //O atribunto TP_AUT no botão identifica qual o tipo de autorização a ser excluída
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" tp_aut="1" value=' . $linha['id_autoriza_atividade'] . ' >
                                        <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                      </button>'
                            . '</td>'
                            . '</tr>';
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function listaAutorizacoesCentral(PDO $pdo) {
        try {
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdLotacao($this->getIdLotacao());
            $daoFinAutorizaCentral->setIdPessoa($this->getIdPessoa());

            $daoFinAutorizaCentral->selectAll($pdo);
            $retorno = '';

            if ($daoFinAutorizaCentral->sucesso()) {
                $tabela = $daoFinAutorizaCentral->getMsgRetorno();

                foreach ($tabela as $linha) {
                    $retorno .= '<tr>'
                            . '<td>' . $linha['nm_pessoa'] . '</td>'
                            . '<td>' . $linha['nm_lotacao'] . '</td>'
                            . '<td>' . $linha['dt_ini'] . '</td>'
                            . '<td>' . $linha['dt_fim'] . '</td>'
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"
                                        title="Editar" tp_aut="2" value=' . $linha['id_autoriza_central'] . ' >
                                        <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>'
                            . '</button>'
                            //O atribunto TP_AUT no botão identifica qual o tipo de autorização a ser excluída
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" tp_aut="2" value=' . $linha['id_autoriza_central'] . ' >
                                        <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                      </button>'
                            . '</td>'
                            . '</tr>';
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function listaAutorizacoesOrcamento(PDO $pdo) {
        try {
            $daoFinAutorizaOrcamento = new DaoFinAutorizaOrcamento();
            $daoFinAutorizaOrcamento->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizaOrcamento->selectAll($pdo);
            $retorno = '';

            if ($daoFinAutorizaOrcamento->sucesso()) {
                $tabela = $daoFinAutorizaOrcamento->getMsgRetorno();

                foreach ($tabela as $linha) {
                    $retorno .= '<tr>'
                            . '<td>' . $linha['nm_pessoa'] . '</td>'
                            . '<td> - </td>'
                            . '<td>' . $linha['dt_ini'] . '</td>'
                            . '<td>' . $linha['dt_fim'] . '</td>'
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"
                                        title="Editar" tp_aut="3" value=' . $linha['id_autoriza_orcamento'] . ' >
                                        <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>'
                            . '</button>'
                            //O atribunto TP_AUT no botão identifica qual o tipo de autorização a ser excluída
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" tp_aut="3" value=' . $linha['id_autoriza_orcamento'] . ' >
                                        <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                    </button>'
                            . '</td>'
                            . '</tr>';
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function listaAutorizacoesFinanceiro(PDO $pdo) {
        try {
            $daoFinAutorizacaoFinanceiro = new DaoFinAutorizacaoFinanceiro();
            $daoFinAutorizacaoFinanceiro->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizacaoFinanceiro->selectAll($pdo);
            $retorno = '';

            if ($daoFinAutorizacaoFinanceiro->sucesso()) {
                $tabela = $daoFinAutorizacaoFinanceiro->getMsgRetorno();

                foreach ($tabela as $linha) {
                    $retorno .= '<tr>'
                            . '<td>' . $linha['nm_pessoa'] . '</td>'
                            . '<td> - </td>'
                            . '<td>' . $linha['dt_ini'] . '</td>'
                            . '<td>' . $linha['dt_fim'] . '</td>'
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"
                                        title="Editar" tp_aut="4" value=' . $linha['id_autorizacao_financeiro'] . ' >
                                        <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>'
                            . '</button>'
                            //O atribunto TP_AUT no botão identifica qual o tipo de autorização a ser excluída
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" tp_aut="4" value=' . $linha['id_autorizacao_financeiro'] . ' >
                                        <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                      </button>'
                            . '</td>'
                            . '</tr>';
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function listaAutorizacoesOrdenado(PDO $pdo) {
        try {
            $daoFinAutorizacaoOrdenado = new DaoFinAutorizacaoOrdenado();
            $daoFinAutorizacaoOrdenado->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizacaoOrdenado->selectAll($pdo);
            $retorno = '';

            if ($daoFinAutorizacaoOrdenado->sucesso()) {
                $tabela = $daoFinAutorizacaoOrdenado->getMsgRetorno();

                foreach ($tabela as $linha) {
                    $retorno .= '<tr>'
                            . '<td>' . $linha['nm_pessoa'] . '</td>'
                            . '<td> - </td>'
                            . '<td>' . $linha['dt_ini'] . '</td>'
                            . '<td>' . $linha['dt_fim'] . '</td>'
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"
                                        title="Editar" tp_aut="5" value=' . $linha['id_autorizacao_ordenado'] . ' >
                                        <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>'
                            . '</button>'
                            //O atribunto TP_AUT no botão identifica qual o tipo de autorização a ser excluída
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" tp_aut="5" value=' . $linha['id_autorizacao_ordenado'] . ' >
                                        <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                      </button>'
                            . '</td>'
                            . '</tr>';
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //****************************INSERÇÃO AUTORIZAÇÃO*******************************************
    private function salvaAutorizaAtividade(PDO $pdo) {
        try {

            $retorno = "";
            $daoFinAutorizaAtividade = new DaoFinAutorizaAtividade();
            $daoFinAutorizaAtividade->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizaAtividade->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizaAtividade->setIdLotacao($this->getIdLotacao());
            $daoFinAutorizaAtividade->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizaAtividade->insert($pdo);
            if ($daoFinAutorizaAtividade->sucesso()) {

                $id_autoriza_atividade = $pdo->lastInsertId('fin_autoriza_atividade_id_autoriza_atividade_seq');
                if (!Log::SalvaLogI('fin_autoriza_atividade', $id_autoriza_atividade, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaAtividade->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function salvaAutorizaCentral(PDO $pdo) {
        try {
            $retorno = "";
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizaCentral->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizaCentral->setIdLotacao($this->getIdLotacao());
            $daoFinAutorizaCentral->setIdPessoa($this->getIdPessoa());

            $daoFinAutorizaCentral->insert($pdo);

            if ($daoFinAutorizaCentral->sucesso()) {

                $id_autoriza_central = $pdo->lastInsertId('fin_autoriza_central_id_autoriza_central_seq');
                if (!Log::SalvaLogI('fin_autoriza_central', $id_autoriza_central, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaCentral->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function salvaAutorizaOrcamento(PDO $pdo) {
        try {
            $retorno = "";
            $daoFinAutorizaOrcamento = new DaoFinAutorizaOrcamento();
            $daoFinAutorizaOrcamento->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizaOrcamento->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizaOrcamento->setIdPessoa($this->getIdPessoa());

            $daoFinAutorizaOrcamento->insert($pdo);

            if ($daoFinAutorizaOrcamento->sucesso()) {

                $id_autoriza_orcamento = $pdo->lastInsertId('fin_autoriza_orcamento_id_autoriza_orcamento_seq');
                if (!Log::SalvaLogI('fin_autoriza_orcamento', $id_autoriza_orcamento, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaOrcamento->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function salvaAutorizacaoFinanceiro(PDO $pdo) {
        try {
            $retorno = "";
            $daoFinAutorizacaoFinanceiro = new DaoFinAutorizacaoFinanceiro();
            $daoFinAutorizacaoFinanceiro->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizacaoFinanceiro->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizacaoFinanceiro->setIdPessoa($this->getIdPessoa());

            $daoFinAutorizacaoFinanceiro->insert($pdo);

            if ($daoFinAutorizacaoFinanceiro->sucesso()) {

                $id_autorizacao_financeiro = $pdo->lastInsertId('fin_autorizacao_financeiro_id_autorizacao_financeiro_seq');
                if (!Log::SalvaLogI('fin_autorizacao_financeiro', $id_autorizacao_financeiro, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoFinanceiro->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function salvaAutorizacaoOrdenado(PDO $pdo) {
        try {
            $retorno = "";
            $daoAutorizacaoOrdenado = new DaoFinAutorizacaoOrdenado();
            $daoAutorizacaoOrdenado->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoAutorizacaoOrdenado->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoAutorizacaoOrdenado->setIdPessoa($this->getIdPessoa());

            $daoAutorizacaoOrdenado->insert($pdo);

            if ($daoAutorizacaoOrdenado->sucesso()) {

                $id_autorizacao_ordenado = $pdo->lastInsertId('fin_autorizacao_ordenado_id_autorizacao_ordenado_seq');
                if (!Log::SalvaLogI('fin_autorizacao_ordenado', $id_autorizacao_ordenado, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoAutorizacaoOrdenado->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //**********************************ALTERAÇÃO***********************************************

    private function atualizaAutorizacaoAtividade(PDO $pdo) {
        try {
            $retorno = '';
            $daoFinAutorizaAtividade = new DaoFinAutorizaAtividade();
            $daoFinAutorizaAtividade->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizaAtividade->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizaAtividade->setIdLotacao($this->getIdLotacao());
            $daoFinAutorizaAtividade->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizaAtividade->setIdAutorizaAtividade($this->getIdAutorizacao());

            //Retorna os dados antes da alteração
            $daoFinAutorizaAtividade->selectAutorizacao($pdo);

            if (!$daoFinAutorizaAtividade->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaAtividade->getMsgRetorno());
            }

            //Se não der erro na seleção da autorização, atribui à variável
            $reg_antigo = $daoFinAutorizaAtividade->getMsgRetorno();

            //Atualiza os registros
            $daoFinAutorizaAtividade->update($pdo);

            if ($daoFinAutorizaAtividade->sucesso()) {


                if (!Log::SalvaLogU('fin_autoriza_atividade', $daoFinAutorizaAtividade->getIdAutorizaAtividade(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Alteração realizada com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaAtividade->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function atualizaAutorizacaoCentral(PDO $pdo) {
        try {
            $retorno = '';
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizaCentral->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizaCentral->setIdLotacao($this->getIdLotacao());
            $daoFinAutorizaCentral->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizaCentral->setIdAutorizaCentral($this->getIdAutorizacao());

            //Retorna os dados antes da alteração
            $daoFinAutorizaCentral->selectAutorizacao($pdo);

            if (!$daoFinAutorizaCentral->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaCentral->getMsgRetorno());
            }

            //Se não der erro na seleção da autorização, atribui à variável
            $reg_antigo = $daoFinAutorizaCentral->getMsgRetorno();

            //Atualiza os registros
            $daoFinAutorizaCentral->update($pdo);

            if ($daoFinAutorizaCentral->sucesso()) {


                if (!Log::SalvaLogU('fin_autoriza_central', $daoFinAutorizaCentral->getIdAutorizaCentral(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Alteração realizada com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaCentral->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function atualizaAutorizacaoOrcamento(PDO $pdo) {
        try {
            $retorno = '';
            $daoFinAutorizaOrcamento = new DaoFinAutorizaOrcamento();
            $daoFinAutorizaOrcamento->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizaOrcamento->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizaOrcamento->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizaOrcamento->setIdAutorizaOrcamento($this->getIdAutorizacao());

            //Retorna os dados antes da alteração
            $daoFinAutorizaOrcamento->selectAutorizacao($pdo);

            if (!$daoFinAutorizaOrcamento->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaOrcamento->getMsgRetorno());
            }

            //Se não der erro na seleção da autorização, atribui à variável
            $reg_antigo = $daoFinAutorizaOrcamento->getMsgRetorno();

            //Atualiza os registros
            $daoFinAutorizaOrcamento->update($pdo);

            if ($daoFinAutorizaOrcamento->sucesso()) {


                if (!Log::SalvaLogU('fin_autoriza_orcamento', $daoFinAutorizaOrcamento->getIdAutorizaCentral(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Alteração realizada com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaOrcamento->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function atualizaAutorizacaoFinanceiro(PDO $pdo) {
        try {
            $retorno = '';
            $daoFinAutorizacaoFinanceiro = new DaoFinAutorizacaoFinanceiro();
            $daoFinAutorizacaoFinanceiro->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizacaoFinanceiro->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizacaoFinanceiro->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizacaoFinanceiro->setIdAutorizacaoFinanceiro($this->getIdAutorizacao());

            //Retorna os dados antes da alteração
            $daoFinAutorizacaoFinanceiro->selectAutorizacao($pdo);

            if (!$daoFinAutorizacaoFinanceiro->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoFinanceiro->getMsgRetorno());
            }

            //Se não der erro na seleção da autorização, atribui à variável
            $reg_antigo = $daoFinAutorizacaoFinanceiro->getMsgRetorno();

            //Atualiza os registros
            $daoFinAutorizacaoFinanceiro->update($pdo);

            if ($daoFinAutorizacaoFinanceiro->sucesso()) {


                if (!Log::SalvaLogU('fin_autorizacao_financeiro', $daoFinAutorizacaoFinanceiro->getIdAutorizacaoFinanceiro(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Alteração realizada com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoFinanceiro->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function atualizaAutorizacaoOrdenado(PDO $pdo) {
        try {
            $retorno = '';
            $daoFinAutorizacaoOrdenado = new DaoFinAutorizacaoOrdenado();
            $daoFinAutorizacaoOrdenado->setDtIni(Metodos::ConverteDataING($this->getDtIni()));
            $daoFinAutorizacaoOrdenado->setDtFim(Metodos::ConverteDataING($this->getDtFim()));
            $daoFinAutorizacaoOrdenado->setIdPessoa($this->getIdPessoa());
            $daoFinAutorizacaoOrdenado->setIdAutorizacaoOrdenado($this->getIdAutorizacao());

            //Retorna os dados antes da alteração
            $daoFinAutorizacaoOrdenado->selectAutorizacao($pdo);

            if (!$daoFinAutorizacaoOrdenado->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoOrdenado->getMsgRetorno());
            }

            //Se não der erro na seleção da autorização, atribui à variável
            $reg_antigo = $daoFinAutorizacaoOrdenado->getMsgRetorno();

            //Atualiza os registros
            $daoFinAutorizacaoOrdenado->update($pdo);

            if ($daoFinAutorizacaoOrdenado->sucesso()) {


                if (!Log::SalvaLogU('fin_autorizacao_financeiro', $daoFinAutorizacaoOrdenado->getIdAutorizacaoOrdenado(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Alteração realizada com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoOrdenado->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //***********************************EXCLUSÃO***********************************************
    private function excluiAutorizacaoAtividade(PDO $pdo) {
        try {
            $retorno = "";
            $daoFinAutorizaAtividade = new DaoFinAutorizaAtividade();
            $daoFinAutorizaAtividade->setIdAutorizaAtividade($this->getIdAutorizacao());

            $id_autoriza_atividade = $daoFinAutorizaAtividade->getIdAutorizaAtividade();
            if (!Log::SalvaLogD('fin_autoriza_atividade', $id_autoriza_atividade, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoFinAutorizaAtividade->delete($pdo);
            if ($daoFinAutorizaAtividade->sucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaAtividade->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function excluiAutorizacaoCentral(PDO $pdo) {
        try {
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdAutorizaCentral($this->getIdAutorizacao());

            $id_autoriza_central = $daoFinAutorizaCentral->getIdAutorizaCentral();
            if (!Log::SalvaLogD('fin_autoriza_central', $id_autoriza_central, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoFinAutorizaCentral->delete($pdo);
            if ($daoFinAutorizaCentral->sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinAutorizaCentral->getMsgRetorno());
                return $retorno;
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function excluiAutorizacaoOrcamento(PDO $pdo) {
        try {
            $daoFinAutorizaOrcamento = new DaoFinAutorizaOrcamento();
            $daoFinAutorizaOrcamento->setIdAutorizaOrcamento($this->getIdAutorizacao());

            $id_autoriza_orcamento = $daoFinAutorizaOrcamento->getIdAutorizaOrcamento();
            if (!Log::SalvaLogD('fin_autoriza_orcamento', $id_autoriza_orcamento, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoFinAutorizaOrcamento->delete($pdo);
            if ($daoFinAutorizaOrcamento->sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaOrcamento->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function excluiAutorizacaoFinanceiro(PDO $pdo) {
        try {
            $daoFinAutorizacaoFinanceiro = new DaoFinAutorizacaoFinanceiro();
            $daoFinAutorizacaoFinanceiro->setIdAutorizaFinanceiro($this->getIdAutorizacao());

            $id_autoriza_financeiro = $daoFinAutorizacaoFinanceiro->getIdAutorizaFinanceiro();
            if (!Log::SalvaLogD('fin_autorizacao_financeiro', $id_autoriza_financeiro, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoFinAutorizacaoFinanceiro->delete($pdo);
            if ($daoFinAutorizacaoFinanceiro->sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoFinanceiro->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function excluiAutorizacaoOrdenado(PDO $pdo) {
        try {
            $daoFinAutorizacaoOrdenado = new DaoFinAutorizacaoOrdenado();
            $daoFinAutorizacaoOrdenado->setIdAutorizacaoOrdenado($this->getIdAutorizacao());

            $id_autorizacao_ordenado = $daoFinAutorizacaoOrdenado->getIdAutorizacaoOrdenado();
            if (!Log::SalvaLogD('fin_autorizacao_ordenado', $id_autorizacao_ordenado, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoFinAutorizacaoOrdenado->delete($pdo);
            if ($daoFinAutorizacaoOrdenado->sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoOrdenado->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    //**************************RETORNA AUTORIZAÇÃO*****************************

    private function retornaAutorizaAtividade(PDO $pdo) {
        try {
            $daoFinAutorizaAtividade = new DaoFinAutorizaAtividade();
            $daoFinAutorizaAtividade->setIdAutorizaAtividade($this->getIdAutorizacao());
            $daoFinAutorizaAtividade->selectAutorizacao($pdo);

            if (!$daoFinAutorizaAtividade->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaAtividade->getMsgRetorno());
            }
            return Metodos::retornoAjax("ok", "html", $daoFinAutorizaAtividade->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function retornaAutorizaCentral(PDO $pdo) {
        try {
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdAutorizaCentral($this->getIdAutorizacao());
            $daoFinAutorizaCentral->selectAutorizacao($pdo);

            if (!$daoFinAutorizaCentral->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaCentral->getMsgRetorno());
            }

            return Metodos::retornoAjax("ok", "html", $daoFinAutorizaCentral->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function retornaAutorizaOrcamento(PDO $pdo) {
        try {
            $daoFinAutorizaOrcamento = new DaoFinAutorizaOrcamento();
            $daoFinAutorizaOrcamento->setIdAutorizaOrcamento($this->getIdAutorizacao());
            $daoFinAutorizaOrcamento->selectAutorizacao($pdo);

            if (!$daoFinAutorizaOrcamento->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizaOrcamento->getMsgRetorno());
            }

            return Metodos::retornoAjax("ok", "html", $daoFinAutorizaOrcamento->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function retornaAutorizacaoFinanceiro(PDO $pdo) {
        try {
            $daoFinAutorizacaoFinanceiro = new DaoFinAutorizacaoFinanceiro();
            $daoFinAutorizacaoFinanceiro->setIdAutorizacaoFinanceiro($this->getIdAutorizacao());
            $daoFinAutorizacaoFinanceiro->selectAutorizacao($pdo);

            if (!$daoFinAutorizacaoFinanceiro->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoFinanceiro->getMsgRetorno());
            }

            return Metodos::retornoAjax("ok", "html", $daoFinAutorizacaoFinanceiro->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    private function retornaAutorizacaoOrdenado(PDO $pdo) {
        try {
            $daoFinAutorizacaoOrdenado = new DaoFinAutorizacaoOrdenado();
            $daoFinAutorizacaoOrdenado->setIdAutorizacaoOrdenado($this->getIdAutorizacao());
            $daoFinAutorizacaoOrdenado->selectAutorizacao($pdo);

            if (!$daoFinAutorizacaoOrdenado->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinAutorizacaoOrdenado->getMsgRetorno());
            }

            return Metodos::retornoAjax("ok", "html", $daoFinAutorizacaoOrdenado->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPedidoAutorizacaoCentral() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdPessoa($this->id_pessoa);
            //retorno as lotaçoes do usario
            $daoFinAutorizaCentral->retornaLotacoAutorizacaoUsuario($pdo);
            $idLotacao = 0;
            //tranformor essas lotaçoes em um array
            if ($daoFinAutorizaCentral->sucesso()) {
                foreach ($daoFinAutorizaCentral->getMsgRetorno() as $lotacao) {
                    $this->id_lotacao[] = $lotacao["id_lotacao"];
                }
                //trato as lotaçoes para ser inserida no in do dao
                $this->id_lotacao = implode(",", $this->id_lotacao);
            }

            $daoFinAutorizaCentral->setIdLotacao($this->id_lotacao);
            $daoFinAutorizaCentral->setTipoAutorizacao($this->tipo_autorizacao);
            $daoFinAutorizaCentral->retornaPedidoParaAutorizacaoCentral($pdo);

            $retorno = '';
            $dados = '';
            if ($daoFinAutorizaCentral->Sucesso()) {
                $dados = $daoFinAutorizaCentral->getMsgRetorno();
                foreach ($dados as $l) {
                    $retorno .= '<tr>
                                    <td class="text-center">' . $l["numero"] . '</td>
                                    <td class="text-center">' . $l["ds_pedido"] . '</td>
                                    <td class="text-center">' . $l["nm_tipo_gasto"] . '</td>
                                    <td class="text-center">' . $l["nr_fonte"] . '</td>
                                    <td class="text-center">' . $l["cd_despesa_elemento"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($l["vl_pedido"], 4) . '</td>
                                    <td class="text-center">
                                    <a type="button" href="/pages/financeiro/autorizacoes/central/autorCentral.php?id=' . $l["id_pedido"] . '" class="button">
                                        <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a>';
                    if (!empty($l['id_diaria'])) {
                        $retorno .= '<a href="/pages/diarias/diaria/index.php?id=' . $l['id_diaria'] . '" target="_blank"><button type="button" title="Visualizar"><i class="fa fa-file-text-o  text-primary" aria-hidden="true"></i></button></a>'
                                . '<a href="/pages/diarias/diaria/imprimir.php?id=' . $l['id_diaria'] . '" target="_blank"><button title="Imprimir proposta e concessão da Diária" type="button"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                    }

                    $retorno .= '</td>
                                </tr>';
                }
            }
            if (empty($retorno)) {
                return Metodos::retornoAjax("Erro", "alert", "Nenhum pedido encontrado.");
            }
            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPedidoAutorizacaoOrcamentario() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            //retorno as lotaçoes do usario
            $idLotacao = 0;
            $daoFinAutorizaCentral->setTipoAutorizacao($this->tipo_autorizacao);
            $daoFinAutorizaCentral->retornaPedidoParaAutorizacaoOrcamnetoEOrdenado($pdo);

            $retorno = '';
            $dados = '';
            if ($daoFinAutorizaCentral->Sucesso()) {
                $dados = $daoFinAutorizaCentral->getMsgRetorno();
                foreach ($dados as $l) {
                    $retorno .= '<tr>
                                    <td class="text-center">' . $l["numero"] . '</td>
                                    <td class="text-center">' . $l["ds_pedido"] . '</td>
                                    <td class="text-center">' . $l["nm_tipo_gasto"] . '</td>
                                    <td class="text-center">' . $l["nr_fonte"] . '</td>
                                    <td class="text-center">' . $l["cd_despesa_elemento"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($l["vl_pedido"], 4) . '</td>
                                    <td class="text-center">
                                    <a type="button" href="/pages/financeiro/autorizacoes/orcamento/autorOrcamentario.php?id=' . $l["id_pedido"] . '" class="button">
                                        <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a>';
                    if (!empty($l['id_diaria'])) {
                        $retorno .= '<a href="/pages/diarias/diaria/index.php?id=' . $l['id_diaria'] . '" target="_blank"><button type="button" title="Visualizar"><i class="fa fa-file-text-o  text-primary" aria-hidden="true"></i></button></a>'
                                . '<a href="/pages/diarias/diaria/imprimir.php?id=' . $l['id_diaria'] . '" target="_blank"><button title="Imprimir proposta e concessão da Diária" type="button"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                    }

                    $retorno .= '</td>
                                </tr>';
                }
            }
            if (empty($retorno)) {
                return Metodos::retornoAjax("Erro", "alert", "Nenhum pedido encontrado.");
            }
            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPedidoAutorizacaoFinanceiro() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setTipoAutorizacao($this->tipo_autorizacao);
            $daoFinAutorizaCentral->retornaPedidoParaAutorizacaoOrcamnetoEOrdenado($pdo);

            $retorno = '';
            $dados = '';
            if ($daoFinAutorizaCentral->Sucesso()) {
                $dados = $daoFinAutorizaCentral->getMsgRetorno();
                foreach ($dados as $l) {
                    $retorno .= '<tr>
                                    <td class="text-center">' . $l["numero"] . '</td>
                                    <td class="text-center">' . $l["ds_pedido"] . '</td>
                                    <td class="text-center">' . $l["nm_tipo_gasto"] . '</td>
                                    <td class="text-center">' . $l["nr_fonte"] . '</td>
                                    <td class="text-center">' . $l["cd_despesa_elemento"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($l["vl_pedido"], 4) . '</td>
                                    <td class="text-center">
                                    <a type="button" href="/pages/financeiro/autorizacoes/financeiro/autorFinanceiro.php?id=' . $l["id_pedido"] . '" class="button">
                                        <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a>';
                    if (!empty($l['id_diaria'])) {
                        $retorno .= '<a href="/pages/diarias/diaria/index.php?id=' . $l['id_diaria'] . '" target="_blank"><button type="button" title="Visualizar"><i class="fa fa-file-text-o  text-primary" aria-hidden="true"></i></button></a>'
                                . '<a href="/pages/diarias/diaria/imprimir.php?id=' . $l['id_diaria'] . '" target="_blank"><button title="Imprimir proposta e concessão da Diária" type="button"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                    }

                    $retorno .= '</td>
                                </tr>';
                }
            }
            if (empty($retorno)) {
                return Metodos::retornoAjax("Erro", "alert", "Nenhum pedido encontrado.");
            }
            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPedidoAutorizacaoOrdenado() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setTipoAutorizacao($this->tipo_autorizacao);
            $daoFinAutorizaCentral->retornaPedidoParaAutorizacaoOrcamnetoEOrdenado($pdo);
            $retorno = '';
            $dados = '';
            if ($daoFinAutorizaCentral->Sucesso()) {
                $dados = $daoFinAutorizaCentral->getMsgRetorno();
                foreach ($dados as $l) {
                    $retorno .= '<tr>
                                    <td class="text-center">' . $l["numero"] . '</td>
                                    <td class="text-center">' . $l["ds_pedido"] . '</td>
                                    <td class="text-center">' . $l["nm_tipo_gasto"] . '</td>
                                    <td class="text-center">' . $l["nr_fonte"] . '</td>
                                    <td class="text-center">' . $l["cd_despesa_elemento"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($l["vl_pedido"], 4) . '</td>
                                    <td class="text-center">
                                    <a type="button" href="/pages/financeiro/autorizacoes/ordenador/autorOrdenador.php?id=' . $l["id_pedido"] . '" class="button">
                                        <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a>';
                    if (!empty($l['id_diaria'])) {
                        $retorno .= '<a href="/pages/diarias/diaria/index.php?id=' . $l['id_diaria'] . '" target="_blank"><button type="button" title="Visualizar"><i class="fa fa-file-text-o  text-primary" aria-hidden="true"></i></button></a>'
                                . '<a href="/pages/diarias/diaria/imprimir.php?id=' . $l['id_diaria'] . '" target="_blank"><button title="Imprimir proposta e concessão da Diária" type="button"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                    }

                    $retorno .= '</td>
                                </tr>';
                }
            }
            if (empty($retorno)) {
                return Metodos::retornoAjax("Erro", "alert", "Nenhum pedido encontrado.");
            }
            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verficarAutorizacaoUsuarioCentral() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdPessoa($this->id_pessoa);
            $daoFinAutorizaCentral->validaPermisaoUsuarioCentral($pdo);
            return $daoFinAutorizaCentral->sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verficarAutorizacaoUsuarioAtividade() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdPessoa($this->id_pessoa);
            $daoFinAutorizaCentral->validaPermisaoUsuarioAtividade($pdo);
            return $daoFinAutorizaCentral->sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verficarAutorizacaoUsuarioOrcamento() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdPessoa($this->id_pessoa);
            $daoFinAutorizaCentral->validaPermisaoUsuarioOrcamento($pdo);
            return $daoFinAutorizaCentral->sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verficarAutorizacaoUsuarioFinanceiro() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdPessoa($this->id_pessoa);
            $daoFinAutorizaCentral->validaPermisaoUsuarioFinanceiro($pdo);
            return $daoFinAutorizaCentral->sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verficarAutorizacaoUsuarioOrdenado() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinAutorizaCentral = new DaoFinAutorizaCentral();
            $daoFinAutorizaCentral->setIdPessoa($this->id_pessoa);
            $daoFinAutorizaCentral->validaPermisaoUsuarioOrdenado($pdo);
            return $daoFinAutorizaCentral->sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
