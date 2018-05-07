<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinFonte.class.php";

class Fonte {

    private $idFonte = null;
    private $nrFonte = null;

    function getIdFonte() {
        return $this->idFonte;
    }

    function getNrFonte() {
        return $this->nrFonte;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
    }

    function setNrFonte($nrFonte) {
        $this->nrFonte = $nrFonte;
    }

    /**
     * Retorna os options de Todas as Fontes
     * @param PDO $pdo
     * @return string
     */
    public function retornaOptionSelect(PDO $pdo = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $fonte = new DaoFinFonte();

            $result = $fonte->retornaTodasFontes($pdo);


            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $retorno .= "<option value='" . $v['id_fonte'] . "'>" . $v['nr_fonte'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionLiberUnidadeValor(int $idLotacao, int $ano, PDO $pdo = null) {
        $retorno = "";
        try {
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $fonte = new DaoFinFonte();

            $result = $fonte->retornaLotLiberUnidadeValorAno($idLotacao, $ano, $pdo);


            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $retorno .= "<option value='" . $v['id_fonte'] . "'>" . $v['nr_fonte'] . "</option>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaFontePorAta(int $idAta = 0, PDO $pdo = null) {
        try {
            $retorno = '';
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $fonte = new DaoFinFonte();
            $idFonte = $fonte->retornaFonteAta($idAta, $pdo);

            $result = $fonte->retornaTodasFontes($pdo);

            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    if ($v['id_fonte'] == $idFonte["id_fonte"]) {
                        $retorno .= "<option value='" . $v['id_fonte'] . "' selected>" . $v['nr_fonte'] . "</option>";
                    } else {
                        $retorno .= "<option value='" . $v['id_fonte'] . "'>" . $v['nr_fonte'] . "</option>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaFontePorContrato(int $idContrato = 0, PDO $pdo = null) {
        try {
            $retorno = '';
            if ($pdo == null) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $fonte = new DaoFinFonte();
            $idFonte = $fonte->retornaFonteContrato($idContrato, $pdo);

            $result = $fonte->retornaTodasFontes($pdo);


            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    if ($v['id_fonte'] == $idFonte["id_fonte"]) {
                        $retorno .= "<option value='" . $v['id_fonte'] . "' selected>" . $v['nr_fonte'] . "</option>";
                    } else {
                        $retorno .= "<option value='" . $v['id_fonte'] . "'>" . $v['nr_fonte'] . "</option>";
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
