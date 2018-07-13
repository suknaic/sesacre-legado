<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/central/DaoFinCentral.class.php";

class FinCentralModel {

    private $id_central_demanda = null;
    private $id_lotacao = null;

    /**
     * @return mixed
     */
    public function getIdCentralDemanda() {
        return $this->id_central_demanda;
    }

    /**
     * @param mixed $id_central_demanda
     *
     * @return self
     */
    public function setIdCentralDemanda($id_central_demanda) {
        $this->id_central_demanda = $id_central_demanda;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    /**
     * @param mixed $id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;

        return $this;
    }

    public function retornaOptionsCentrais(PDO $pdo = null) {
        try {
            //variaveis do sistema
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoCentral = new DaoFinCentral();
            $daoCentral->retornaCentrais($pdo);
            $retorno = '<option value="0">Selecione uma Central</option>';
            if ($daoCentral->Sucesso()) {
                foreach ($daoCentral->getMsgRetorno() as $value) {
                    if (!empty($this->id_lotacao) && $this->id_lotacao == $value['id_lotacao']) {
                        $retorno .= '<option value = "' . $value['id_lotacao'] . '" selected>' . $value["nm_lotacao"] . '</option>';
                    } else {
                        $retorno .= '<option value = "' . $value['id_lotacao'] . '">' . $value["nm_lotacao"] . '</option>';
                    }
                }
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function retornaTrCentrais(PDO $pdo = null){
        try {
            //variaveis do sistema
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoCentral = new DaoFinCentral();
            $daoCentral->retornaCentrais($pdo);
            $retorno = "";
            if ($daoCentral->Sucesso()) {
                foreach ($daoCentral->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-id=".$linha['id_central_demanda'].">"
                                    . "<td>".$linha['nm_lotacao']."</td>"
                                    . "<td style='text-align: center;'>"
                                        . "<button type='button' class='btn btn-default btn-remover btn-xs' title='Remover' >"
                                    .      "<i class='fa fa-trash fa-lg text-danger' aria-hidden='true'></i>"
                                    .    "</button>"
                                    . "</td>"
                            . "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function salvarCentralDemanda(PDO $pdo = null) {
        $retorno = "";
        try {
            //variaveis do sistema
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
            
            if (empty($this->getIdLotacao() )) {
                return Metodos::retornoAjax("Erro", "alert","Por favor preencha todos os campos necessários.");
            }
            $daoCentral = new DaoFinCentral();
            $daoCentral->setIdLotacao($this->getIdLotacao());
            $daoCentral->insert($pdo);
            
            if ($daoCentral->Sucesso()) {
                $idCentralDemanda = $pdo->lastInsertId('fin_central_demanda_id_central_demanda_seq');
                if (!Log::SalvaLogI('fin_central_demanda', $idCentralDemanda, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdCentralDemanda($idCentralDemanda);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Central de Demanda realizado com sucesso.");
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console",$daoCentral->getMsgRetorno());
            }
            
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirCentralDemanda(PDO $pdo = null) {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoCentral = new DaoFinCentral();
            $daoCentral->setIdCentralDemanda($this->getIdCentralDemanda());
            
            $idCentralDemanda = $daoCentral->getIdCentralDemanda();
            if (!Log::SalvaLogD('fin_central_demanda', $idCentralDemanda, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoCentral->delete($pdo);
            if ($daoCentral->Sucesso()) {
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", "Exclusão realizada com Sucesso.");
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoCentral->getMsgRetorno());
                $pdo->rollBack();
            }
            
            return $retorno;
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$ex->getMessage());
        }
    }

}
