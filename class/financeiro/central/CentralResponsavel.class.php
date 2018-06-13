<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/central/DaoFinCentralResponsavel.class.php";

/**
 * Representa se os Usuários que São de Alguma Central
 */
class CentralResponsavel {

    private $idCentralResponsavel = null;
    private $idPessoa = null;
    private $idLotacao = null;
    private $tiposSolicitacoes = null;
    private $sucesso = null;
    private $msgRetorno = null;

    function getTiposSolicitacoes() {
        return $this->tiposSolicitacoes;
    }

    function setTiposSolicitacoes($tiposSolicitacoes) {
        $this->tiposSolicitacoes = $tiposSolicitacoes;
    }
    
    function getIdCentralResponsavel() {
        return $this->idCentralResponsavel;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdCentralResponsavel($idCentralResponsavel) {
        $this->idCentralResponsavel = $idCentralResponsavel;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    function descritivoGestor($idSolicitacao){
        switch ($idSolicitacao) {
            case 1:
                return "Gestor Compras (Administrativa)";
            case 2:
                return "Gestor Contratos (Administrativa por Licitação)";
            case 3:
                return "Gestor de Diárias (Diárias)";
            case 4:
                return "Gestor TFD (Ajuda de Custo)";

        }
    }
    
    public function cadastrar() {
        try {
            if ($this->idLotacao == "" || $this->idPessoa == "" || empty($this->getTiposSolicitacoes())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoFinCentralResponsavel();

            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdPessoa($this->idPessoa);

            //Percorre os tipos de solicitações para cadastrar
            foreach ($this->getTiposSolicitacoes() as $linha) {
                $dao->verificaPessoaCentralSolicitacao($pdo,(int)$linha);
                $dao->setIdTipoSolicitacao((int)$linha);
                
                if ($dao->Sucesso()) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Usuário já possui Permissão para esta Central e para o Tipo de Solicitação.");
                    $pdo->rollback();
                    return $retorno;
                    break;
                }
                
                $dao->insert($pdo);
                if (!$dao->Sucesso()) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                    break;
                }
                
                $dao->setIdCentralResponsavel($pdo->lastInsertId('fin_central_responsavel_id_central_responsavel_seq'));

                if (Log::SalvaLogI('fin_central_responsavel', $dao->getIdCentralResponsavel(), $pdo)) {
                    $sucesso = true;
                } else {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                    break;
                }
            }
            
            //Verifica se já está cadastrado, para não duplicar
//            $dao->verificaPessoaCentral($pdo);
//            if ($dao->Sucesso()) {
//                $retorno = Metodos::retornoAjax("Erro", "alert", "Usuário já possui Permissão para esta Central.");
//                $pdo->rollback();
//                return $retorno;
//            }

//            $dao->insert($pdo);
//            if (!$dao->Sucesso()) {
//                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
//                $pdo->rollBack();
//                return $retorno;
//            }

//            $dao->setIdCentralResponsavel($pdo->lastInsertId('fin_central_responsavel_id_central_responsavel_seq'));
//
//            if (Log::SalvaLogI('fin_central_responsavel', $dao->getIdCentralResponsavel(), $pdo)) {
//                $sucesso = true;
//            } else {
//                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//                $pdo->rollBack();
//                return $retorno;
//            }

            //Cadastra o Perfil necessário do Financeiro Central, para o usuário
            if (in_array(1, $this->getTiposSolicitacoes()) or in_array(2, $this->getTiposSolicitacoes()) or in_array(4, $this->getTiposSolicitacoes())) {
                $perfilPessoa = new PerfilPessoa();
                $perfilPessoa->setIdPerfil(PERFIL_FINANCEIRO_CENTRAL);
                $perfilPessoa->setIdPessoa($dao->getIdPessoa());
                if (!$perfilPessoa->verificaPessoaPerfilExiste($pdo)) {
                    $result = $perfilPessoa->incluirPessoaPerfil($pdo);
                    if (!$result) {
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }
            
            
            //Cadastra o Perfil necessário da Solicitação de Diária, para o usuário
            if (in_array(3, $this->getTiposSolicitacoes())) {
                $perfilPessoa = new PerfilPessoa();
                $perfilPessoa->setIdPerfil(PERFIL_DIARIA_SOLICITACAO);
                $perfilPessoa->setIdPessoa($dao->getIdPessoa());
                if (!$perfilPessoa->verificaPessoaPerfilExiste($pdo)) {
                    $result = $perfilPessoa->incluirPessoaPerfil($pdo);
                    if (!$result) {
                        $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
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

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function remover() {
        try {

            if ($this->idCentralResponsavel == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoFinCentralResponsavel();

            $dao->setIdCentralResponsavel($this->idCentralResponsavel);

            $dao->retorna($pdo);
            if ($dao->Sucesso()) {
                if (!Log::SalvaLogD('fin_central_responsavel', $dao->getIdCentralResponsavel(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o Registro.");
                $pdo->rollBack();
                return $retorno;
            }

            $dao->setIdPessoa($dao->getMsgRetorno()['id_pessoa']);

            $dao->delete($pdo);
            if (!$dao->Sucesso()) {
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }


            $perfil = "";
            //Se for a ultima unidade referente ao tipo de solicitação do financeiro
            if ($dao->getMsgRetorno()['id_tipo_solicitacao'] == 1 || $dao->getMsgRetorno()['id_tipo_solicitacao'] == 2 || $dao->getMsgRetorno()['id_tipo_solicitacao'] == 4) {
                $perfil = PERFIL_FINANCEIRO_CENTRAL;
                //Verifica se é a última unidade da Pessoa, caso seja irá remover o Perfil dele. Financeiro
                $dao->retornaPorPessoa($pdo);
                
            } elseif ($dao->getMsgRetorno()['id_tipo_solicitacao'] == 3) { //Se for a ultima unidade referente ao tipo de solicitação da diária
                $perfil = PERFIL_DIARIA_SOLICITACAO;
                //Verifica se é a última unidade da Pessoa, caso seja irá remover o Perfil dele. Diária
                $dao->retornaPorPessoaDiaria($pdo);
            }
            
//            //Verifica se é a última unidade da Pessoa, caso seja irá remover o Perfil dele. 
//            $dao->retornaPorPessoa($pdo);
            if (!$dao->Sucesso()) {
                $perfilPessoa = new PerfilPessoa();
                $perfilPessoa->setIdPerfil($perfil);
                $perfilPessoa->setIdPessoa($dao->getIdPessoa());
                $result = $perfilPessoa->removerPerfilPessoa($pdo);
                if (!$result) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            }
            

            $sucesso = true;

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
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

    public function carregaPorPessoa(PDO $pdo = null) {
        $this->sucesso = false;
        try {

            if ($pdo == null) {
                $conexao = new Conexao();
                /* @var $pdo PDO */
                $pdo = $conexao->connect();
            }

            $dao = new DaoFinCentralResponsavel();
            $dao->setIdPessoa($this->idPessoa);

            $dao->retornaPorPessoa($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
            } else {
                $result = $dao->getMsgRetorno();
                $this->idCentralPessoa = $result['id_central_pessoa'];
                $this->idLotacao = $result['id_lotacao'];
                $this->idPessoa = $result['id_pessoa'];
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function verificaPermissao(PDO $pdo = null) {
        $this->sucesso = false;
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                /* @var $pdo PDO */
                $pdo = $conexao->connect();
            }

            $dao = new DaoFinCentralResponsavel();
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdPessoa($this->idPessoa);

            $dao->verificaPessoaCentral($pdo);

            if ($dao->Sucesso()) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

    public function retornaTrCentralResponsaveis(PDO $pdo = null) {
        $retorno = "";
        try {

            if ($pdo == null) {
                $conexao = new Conexao();
                /* @var $pdo PDO */
                $pdo = $conexao->connect();
            }

            $dao = new DaoFinCentralResponsavel();

            $dao->retornaTodos($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = false;
                return $dao->getMsgRetorno();
            } else {
                $result = $dao->getMsgRetorno();
                $this->sucesso = true;

                foreach ($result as $v) {
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_pessoa'] . "</td>"
                            . "<td>" . $v['nm_lotacao'] . "</td>"
                            . "<td>".$this->descritivoGestor($v['id_tipo_solicitacao'])."</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $v['id_central_responsavel'] . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>'
                            . "</tr>";
                    $retorno .= "</tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $this->sucesso = false;
            return $ex->getMessage();
            return $retorno;
        }
    }

    public function retornaLotacaoUsuarioCentral($pdo = null) {
        $retorno = '';
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinCentralResponsavel();
            $dao->setIdPessoa($this->idPessoa);
            $result = '';
            $dao->retornaLotacaoPorPessoa($pdo);
            if ($dao->Sucesso()) {
                $result = $dao->getMsgRetorno();
                if (!empty($result)) {
                    foreach ($result as $v) {
                        $retorno .= "<option value = '" . $v['id_lotacao'] . "'>" . $v['nm_lotacao'] . "</option>";
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            return "";
        }
    }

    public function retornaIdCentralLiberacao($pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $dao = new DaoFinCentralResponsavel();
            $dao->setIdPessoa($this->idPessoa);
            $dao->retornaIdsLotacao($pdo);
            if ($dao->Sucesso()) {
                return $dao->getMsgRetorno();
            }
            return false;
        } catch (Exception $ex) {
            return "";
        }
    }

}

?>
