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
            $daoDiaDecretoValor->select($pdo);
            
            if ($daoDiaDecretoValor->getSucesso()) {
                foreach ($daoDiaDecretoValor->getMsgRetorno() as $linha) {
                    $retorno .= '<tr>'
                                    . '<td>'.$linha['nm_decreto'].'</td>'
                                    . '<td>'.$linha['cd_classe'].' - '.$linha['nm_classe'].'</td>'
                                    . '<td>'.$linha['tp_decreto_valor'].'</td>'
                                    . '<td>'.$linha['vl_decreto_valor'].'</td>'
                                    . '<td class="text-center">Excluir | Alterar</td>'
                             . '</tr>';
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

}

