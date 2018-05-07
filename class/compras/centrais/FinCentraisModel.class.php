<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinCentrais.class.php";

class FinCentraisModel {

    //central contrato
    private $idContCentral = null;
    private $idContrato = null;
    private $stAtivoContrato = null;
    //central ata
    private $idAtaCentral = null;
    private $idAta = null;
    private $stAtivoAta = null;
    //atributo hibrido
    private $idLotacao = null;
    //atributo de retorno
    private $sucesso = false;
    private $msgRetorno = null;

    function getIdContCentral() {
        return $this->idContCentral;
    }

    function getIdContrato() {
        return $this->idContrato;
    }

    function getStAtivoContrato() {
        return $this->stAtivoContrato;
    }

    function getIdAtaCentral() {
        return $this->idAtaCentral;
    }

    function getIdAta() {
        return $this->idAta;
    }

    function getStAtivoAta() {
        return $this->stAtivoAta;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function setIdContCentral($idContCentral) {
        $this->idContCentral = $idContCentral;
    }

    function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    function setStAtivoContrato($stAtivoContrato) {
        $this->stAtivoContrato = $stAtivoContrato;
    }

    function setIdAtaCentral($idAtaCentral) {
        $this->idAtaCentral = $idAtaCentral;
    }

    function setIdAta($idAta) {
        $this->idAta = $idAta;
    }

    function setStAtivoAta($stAtivoAta) {
        $this->stAtivoAta = $stAtivoAta;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    public function cadastrarCentralAta($pdo = null) {
        try {
            $this->idAta = (is_numeric($this->idAta)) ? $this->idAta : null;
            $this->idLotacao = (is_numeric($this->idLotacao)) ? $this->idLotacao : null;

            if (!empty($this->idAta) && !empty($this->idLotacao)) {

                $daoFinCentrais = new DaoFinCentrais();
                $daoFinCentrais->setIdAta($this->idAta);
                $daoFinCentrais->setIdLotacao($this->idLotacao);
                $daoFinCentrais->insertCentralAta($pdo);
                //ṕegando o ultimo id
                $daoFinCentrais->setIdAtaCentral($pdo->lastInsertId('fin_ata_central_id_ata_central_seq'));

                if ($daoFinCentrais->sucesso()) {
                    $this->sucesso = true;
                    if (!Log::SalvaLogI('fin_ata_central', $daoFinCentrais->getIdAtaCentral(), $pdo)) {
                        $sucesso = false;
                    }
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function cadastrarCentralContrato($pdo = null) {
        try {

            $this->idContrato = (is_numeric($this->idContrato)) ? $this->idContrato : null;
            $this->idLotacao = (is_numeric($this->idLotacao)) ? $this->idLotacao : null;
            if (!empty($this->idContrato) && !empty($this->idLotacao)) {

                $daoFinCentrais = new DaoFinCentrais();
                $daoFinCentrais->setIdContrato($this->idContrato);
                $daoFinCentrais->setIdLotacao($this->idLotacao);
                $daoFinCentrais->insertCentralContrato($pdo);
                //ṕegando o ultimo id
                $daoFinCentrais->setIdContCentral($pdo->lastInsertId('fin_cont_central_id_cont_central_seq'));

                if ($daoFinCentrais->sucesso()) {
                    $this->sucesso = true;
                    if (!Log::SalvaLogI('fin_cont_central', $daoFinCentrais->getIdContCentral(), $pdo)) {
                        $this->sucesso = false;
                    }
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function verificaCentralCadastro(PDO $pdo = null) {
        try {
            //variaveis do sistema
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoCentral = new DaoFinCentrais();
            $daoCentral->setIdContrato($this->idContrato);
            $daoCentral->setIdLotacao($this->idLotacao);
            $daoCentral->verificarCentralBanco($pdo);
            return $daoCentral->sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function campoCentraisOptions(PDO $pdo = null, int $idFornecedor) {
        try {
            //variaveis do sistema
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoCentral = new DaoFinCentrais();
            $daoCentral->retornaCentrais($pdo);
            $centrais = 0;
            $centrais = $daoCentral->getMsgRetorno();
            $centraisSalvas = 0;
            $daoCentral->retornaCentraisPorFornecedor($pdo, $idFornecedor);
            $retorno = '';
            $contCentral = 0;
            if ($daoCentral->sucesso()) {
                $centraisSalvas = $daoCentral->getMsgRetorno();
                foreach ($centraisSalvas as $linha) {
                    $contCentral++;
                    $retorno .= ' <div class="form-group">
                                 <div class="col-sm-5">
                                    <div class="panel-body">
                                        <div class="centraisCampos">
                                            <div class="input-group">
                                            
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control selectCentrais" name="central[]" id="central" required="true">
                                                <option value="">Selecione uma central</option>';
                    foreach ($centrais as $value) {
                        if ($value['id_lotacao'] == $linha['id_lotacao']) {
                            $retorno .= '<option value = "' . $value['id_lotacao'] . '" selected>' . $value["nm_lotacao"] . '</option>';
                        } else {
                            $retorno .= '<option value = "' . $value['id_lotacao'] . '">' . $value["nm_lotacao"] . '</option>';
                        }
                    }
                    $retorno .= '                       </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-sm-3">
                            <div class="panel-body">
                                <a href="#" class="removeCentrais btn btn-danger" idCentral = "' . $linha['id_lotacao'] . '">X</a>
                            </div>
                        </div>

                        </div>';
                }
            } else {
                $contCentral = 1;
                $retorno .= ' <div class="form-group">
                                 <div class="col-sm-5">
                                    <div class="panel-body">
                                        <div class="centraisCampos">
                                            <div class="input-group">
                                            
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control selectCentrais" name="central[]" id="central" required="true">
                                                <option value="">Selecione uma central</option>';
                foreach ($centrais as $value) {
                    $retorno .= '<option value = "' . $value['id_lotacao'] . '">' . $value["nm_lotacao"] . '</option>';
                }
                $retorno .= '                       </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            $retorno .= '<input type = "hidden" id="contCentral" value="' . $contCentral . '"/>';
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removeCentral(PDO $pdo = null) {
        try {
            //variaveis do sistema
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoCentral = new DaoFinCentrais();
            $daoCentral->setIdContrato($this->idContrato);
            $daoCentral->setIdLotacao($this->idLotacao);
            $daoCentral->removeCentral($pdo);
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
