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
    

}
