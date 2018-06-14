<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDecreto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaClasse.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDecretoValor.class.php";


class DecretoValor {

    private $idDecretoValor = null;
    private $idDecreto = null;
    private $idClasse = null;
    private $tpDecretoValor = null;
    private $vlDecretoValor = null;
    
    //mensagem de erro dos eventos
    private $msgErros = null;
    
    function getIdDecretoValor() {
        return $this->idDecretoValor;
    }

    function getIdDecreto() {
        return $this->idDecreto;
    }

    function getIdClasse() {
        return $this->idClasse;
    }

    function getTpDecretoValor() {
        return $this->tpDecretoValor;
    }

    function getVlDecretoValor() {
        return $this->vlDecretoValor;
    }

    function setIdDecretoValor($idDecretoValor) {
        $this->idDecretoValor = $idDecretoValor;
    }

    function setIdDecreto($idDecreto) {
        $this->idDecreto = $idDecreto;
    }

    function setIdClasse($idClasse) {
        $this->idClasse = $idClasse;
    }

    function setTpDecretoValor($tpDecretoValor) {
        $this->tpDecretoValor = $tpDecretoValor;
    }

    function setVlDecretoValor($vlDecretoValor) {
        $this->vlDecretoValor = $vlDecretoValor;
    }
    
    function __construct(int $idDecreto = 0, int $idClasse = 0, string $tpDecretoValor = "",  string $vlDecretoValor = "") {
        $this->idDecreto = $idDecreto;
        $this->idClasse = $idClasse;
        $this->tpDecretoValor = $tpDecretoValor;
        $this->vlDecretoValor = $vlDecretoValor;
    }

    function optionsDecreto(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDiaDecreto = new DaoDiaDecreto();
            $daoDiaDecreto->select($pdo);
            
            if ($daoDiaDecreto->getSucesso()) {
                foreach ($daoDiaDecreto->getMsgRetorno() as $linha) {
                    $retorno .= '<option value="'.$linha['id_decreto'].'">'.$linha['nm_decreto'].'</option>';
                }
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    function optionsClasse(int $idDecreto = 0, int $idClasse = 0) {
        $retorno = "<option value='0'>Selecione a classe</option>";
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDiaDecretoValor = new DaoDiaDecretoValor();
            $daoDiaDecretoValor->setIdDecreto($idDecreto);
            $daoDiaDecretoValor->select($pdo);
            
            
            if($daoDiaDecretoValor->getSucesso()){
                foreach ($daoDiaDecretoValor->getMsgRetorno() as $linha){
                    if ($idClasse == $linha['id_classe']) {
                        $retorno .= "<option value='" . $linha['id_classe'] . "' selected>" . $linha['cd_classe'] . " - " . $linha['nm_classe'] . "</option>";
                    } else {
                        $retorno .= "<option value='" . $linha['id_classe'] . "'>" . $linha['cd_classe'] . " - " . $linha['nm_classe'] . "</option>";
                    }
                }
            }
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoDiaDecretoValor = new DaoDiaDecretoValor();
            $daoDiaDecretoValor->selectDCValorCompleto($pdo);
            
            if ($daoDiaDecretoValor->getSucesso()) {
                foreach ($daoDiaDecretoValor->getMsgRetorno() as $linha) {
                    $dentro_ou_fora_estado = ($linha['tp_decreto_valor'] == 'F') ? 'Fora do Estado' : 'Dentro do Estado';
                    $retorno .= "<tr data-registro='". json_encode($linha)."'>"
                                    . "<td>".$linha['nm_decreto']."</td>"
                                    . "<td>".$linha['cd_classe'].' - '.$linha['nm_classe']."</td>"
                                    . "<td>".$dentro_ou_fora_estado."</td>"
                                    . "<td>".$linha['vl_decreto_valor']."</td>"
                                    . "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-alterar'><i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i></button>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-excluir'><i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i></button>"
                                    . '</td>'
                             . '</tr>';
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function salvarDecretoValor(){
        try {
            $retorno = "";
            if ($this->validaDados()) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                
                $daoDiaDecretoValor = new DaoDiaDecretoValor($this->getIdDecreto(),$this->getIdClasse(),$this->getTpDecretoValor(),$this->getVlDecretoValor());
                $daoDiaDecretoValor->insert($pdo);
                
                if ($daoDiaDecretoValor->getSucesso()) {
                    $idDecretoValor = $pdo->lastInsertId('dia_decreto_valor_id_decreto_valor_seq');
                    if (!Log::SalvaLogI('dia_decreto_valor', $idDecretoValor, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                    }
                    $this->setIdDecretoValor($idDecretoValor);
                    
                    $pdo->commit();
                    $retorno = Metodos::retornoAjax("ok", "html", "Valor incluído com sucesso.");
                } else {
                    $pdo->rollBack();
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDecretoValor->getMsgRetorno());
                }
                return $retorno;
            } else {
                return Metodos::retornoAjax("Erro", "alert", $this->msgErros);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function alteraDecretoValor(){
        try {
            $retorno = "";
            if ($this->validaDados()) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                
               
                return $retorno;
            } else {
                return Metodos::retornoAjax("Erro", "alert", $this->msgErros);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function excluirDecretoValor(){
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoDiaDecretoValor = new DaoDiaDecretoValor();
            $daoDiaDecretoValor->setIdDecretoValor($this->getIdDecretoValor());
            
            $idDiaDecretoValor = $daoDiaDecretoValor->getIdDecretoValor();
            if (!Log::SalvaLogD('dia_decreto_valor', $idDiaDecretoValor, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDiaDecretoValor->delete($pdo);
            if ($daoDiaDecretoValor->getSucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaDecretoValor->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function validaDados(){
        try {
            if (empty($this->getIdClasse()) or empty($this->getIdDecreto()) or empty($this->getTpDecretoValor()) or empty($this->getVlDecretoValor())) {
                $this->msgErros = 'Por favor preencha todos os campos necessários.';
                return false;
            }
            return true;
        } catch (Exception $exc) {
            $this->msgErros = $exc->getMessage();
            return false;
        }
    }

}

