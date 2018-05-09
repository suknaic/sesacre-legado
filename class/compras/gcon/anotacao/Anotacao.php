<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/anotacao/DaoGcoAnotacao.class.php";

/**
 * Description of Anotacao
 *
 * @author elivelton
 */
class Anotacao {
    private $idProcesso = null;
    private $situacao = null;
    private $user = null;
    private $tecnico = null;
    private $Anotacao = null;
    
    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getUser() {
        return $this->user;
    }

    function getTecnico() {
        return $this->tecnico;
    }

    function getAnotacao() {
        return $this->Anotacao;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setTecnico($tecnico) {
        $this->tecnico = $tecnico;
    }

    function setAnotacao($Anotacao) {
        $this->Anotacao = $Anotacao;
    }

    public function cadastrarAnotacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoGcoAnotacao();
            $pdo->beginTransaction();

            $dao->setIdProcesso($this->idProcesso);
            $dao->setAnotacao($this->Anotacao);
            $busca = $dao->carregaAnotacao($pdo);
            $dao->setSituacao($busca['id_situacao']);
            $dao->setUser($_SESSION['idUser']);
            $dao->setTecnico($busca['id_pessoa']);

            $cadastraAnotacao = $dao->cadastrarAnotacao($pdo);
            if (!$cadastraAnotacao) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $cadastraAnotacao);
            } else {
                $dao->setAnotacao($pdo->lastInsertId('gco_anotacao_id_anotacao_seq'));
                if (Log::SalvaLogI('gco_anotacao', $dao->getAnotacao(), $pdo)) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", 'Anotação Adicionada com Sucesso.');
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    
    
    public function retornarAnotacoes() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $anotacao = new DaoGcoAnotacao();
            $anotacao->setIdProcesso($this->idProcesso);

            $dados = $anotacao->retornarAnotacoes($pdo);
            $retorno = '';
            if (count($dados != 0)) {
                foreach ($dados as $anotacoes) {
                    $retorno .= date('d/m/Y H:i:s', strtotime($anotacoes['dh_anotacao'])) . ' - ' . $anotacoes['nm_pessoa'] . ': ' . $anotacoes['ds_anotacao'] . "\n";
                }
                return $retorno;
            } else {
                return $retorno;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
