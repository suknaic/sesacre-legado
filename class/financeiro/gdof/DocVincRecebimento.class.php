<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocVincRecebimento.class.php";

class DocVincRecebimento {

    private $idDocVincRecebimento = null;
    private $idDocLotacao = null;
    private $idPessoa = null;
    private $sucesso = false;
    private $msgRetorno = null;        

    function getIdDocVincRecebimento() {
        return $this->idDocVincRecebimento;
    }

    function getIdDocLotacao() {
        return $this->idDocLotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function setIdDocVincRecebimento($idDocVincRecebimento) {
        $this->idDocVincRecebimento = $idDocVincRecebimento;
        return $this;
    }

    function setIdDocLotacao($idDocLotacao) {
        $this->idDocLotacao = $idDocLotacao;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadastrar() {
        try {

            if (empty($this->getIdPessoa()) or empty($this->getIdDocLotacao())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdDocLotacao($this->getIdDocLotacao())
                    ->setIdPessoa($this->getIdPessoa());

            //verifica se já existe o registro, o banco já possui a constraint, para informar o usuário
            $daoFinDocVincRecebimento->select($pdo, 2);


            if ($daoFinDocVincRecebimento->getSucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "O registro já existe, não é possível incluir outro.");
            }

            $daoFinDocVincRecebimento->insert($pdo);

            if ($daoFinDocVincRecebimento->getSucesso()) {

                $idDocVincRecebimento = $pdo->lastInsertId('fin_doc_vinc_recebimento_id_doc_vinc_recebimento_seq');
                if (!Log::SalvaLogI('fin_doc_vinc_recebimento', $idDocVincRecebimento, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $this->setIdDocVincRecebimento($idDocVincRecebimento);
                $pdo->commit();

                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincRecebimento->getMsgRetorno());
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    function excluir() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdDocVincRecebimento($this->getIdDocVincRecebimento());

            $idDocVincRecebimento = $daoFinDocVincRecebimento->getIdDocVincRecebimento();
            if (!Log::SalvaLogD('fin_doc_vinc_recebimento', $idDocVincRecebimento, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoFinDocVincRecebimento->delete($pdo);
            if ($daoFinDocVincRecebimento->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinDocVincRecebimento->getMsgRetorno());
                $pdo->rollBack();
            }

            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    function listaTodos(int $tipoTramitacao = 0) {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();

            if ($this->getIdDocVincRecebimento()) {
                $daoFinDocVincRecebimento->setIdDocVincRecebimento($this->getIdDocVincRecebimento());
            }
            if ($this->getIdDocLotacao()) {
                $daoFinDocVincRecebimento->setIdDocLotacao($this->getIdDocLotacao());
            }
            if ($this->getIdPessoa()) {
                $daoFinDocVincRecebimento->setIdPessoa($this->getIdPessoa());
            }


            $daoFinDocVincRecebimento->select($pdo, $tipoTramitacao);

            if ($daoFinDocVincRecebimento->getSucesso()) {
                foreach ($daoFinDocVincRecebimento->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='" . json_encode($linha) . "'>"
                            . "<td>" . $linha['nm_pessoa'] . "</td>"
                            . "<td>" . $linha['ds_tramitacao'] . "</td>"
                            . "<td>" . $linha['nm_lotacao'] . "</td>"
                            . "<td>" . $linha['nm_doc_tipo_lotacao'] . "</td>"
                            . "<td class='text-center'>"
                            . "<button type='button' title='Remover Registro' class='btn-excluir'><i class='fa fa-trash text-danger' aria-hidden='true'></i></button>"
                            . "</td>"
                            . "</tr>";
                }
            }

            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function optionsLotacaoRecebimentoPorUsuarioETipo(int $idLotacao = 0) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $options = '';

            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdPessoa($this->idPessoa);
            $daoFinDocVincRecebimento->retornaLotacaoTipoRecibementoPorUsuario($pdo);
            if ($daoFinDocVincRecebimento->getSucesso()) {
                foreach ($daoFinDocVincRecebimento->getMsgRetorno() as $linha) {

                    if ($linha["id_doc_lotacao"] == $idLotacao) {
                        $options .= '<option value="' . $linha["id_lotacao"] . '" selected="true" id_doc_lotacao ="' . $linha["id_doc_lotacao"] . '" >'
                                . $linha["nm_doc_tipo_lotacao"] . ' / ' . $linha["nm_lotacao"] . '</option>';
                    } else {
                        $options .= '<option value="' . $linha["id_lotacao"] . '"  id_doc_lotacao ="' . $linha["id_doc_lotacao"] . '" >'
                                . $linha["nm_doc_tipo_lotacao"] . ' / ' . $linha["nm_lotacao"] . '</option>';
                    }
                }
            }
            return $options;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaIdLotacaoUsuarioRecebimento() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdPessoa($this->idPessoa);
            $daoFinDocVincRecebimento->retornaLotacaoTipoRecibementoPorUsuario($pdo);
            return $daoFinDocVincRecebimento->getMsgRetorno();
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirTodosDocLotacao(PDO $pdo = null){
        $this->sucesso = false;
        try {
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
                                                
            /**
             * Lista todos os Doc Vinc Recebimento, de acordo com o ID Doc Lotação
             * 
             */           
                                    
            $daoFinDocVincRecebimento = new DaoFinDocVincRecebimento();
            $daoFinDocVincRecebimento->setIdDocLotacao($this->idDocLotacao);
            $daoFinDocVincRecebimento->retornaTodosDocLotacao($pdo);
            if(!$daoFinDocVincRecebimento->getSucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $daoFinDocVincRecebimento->getMsgRetorno(); 
                return;
            }
            
            $result = $daoFinDocVincRecebimento->getMsgRetorno();
            if(empty($result)){
                $this->sucesso = true;
                $this->msgRetorno = "Não possui Registro";
                return;
            }
            
            foreach ($result as $key => $value) {
                $daoFinDocVincRecebimento->setIdDocVincRecebimento($value['id_doc_vinc_recebimento']);
                if (!Log::SalvaLogD('fin_doc_vinc_recebimento', $daoFinDocVincRecebimento->getIdDocVincRecebimento(), $pdo)) {                    
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro no LOG";
                    return;
                }
                $daoFinDocVincRecebimento->delete($pdo);
                if (!$daoFinDocVincRecebimento->getSucesso()) {
                    $this->sucesso = false;
                    $this->msgRetorno = $daoFinDocVincRecebimento->getMsgRetorno();
                    return;                    
                }
            }
            
            $this->sucesso = true;
            $this->msgRetorno = "Excluido geral";                                               
            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            
        }
    }

}
