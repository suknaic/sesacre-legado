<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoMedicamento.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:24
 */

class Medicamento {
    private $idMedicamento = null;
    private $nmMedicamento = null;

    /**
     * @return null
     */
    public function getIdMedicamento()
    {
        return $this->idMedicamento;
    }

    /**
     * @param null $idMedicamento
     */
    public function setIdMedicamento($idMedicamento)
    {
        $this->idMedicamento = $idMedicamento;
    }

    /**
     * @return null
     */
    public function getNmMedicamento()
    {
        return $this->nmMedicamento;
    }

    /**
     * @param null $nmMedicamento
     */
    public function setNmMedicamento($nmMedicamento)
    {
        $this->nmMedicamento = $nmMedicamento;
    }

    public function retornaOptionMedicamento($idMedicamento = null) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $medicamento = new DaoMedicamento();
            $retorno = '';
            $busca = $medicamento->retornaMedicamento($pdo);
            foreach ($busca as $linha) {
                if ($idMedicamento == $linha["id_medicamento"]) {
                    $retorno .= '<option value="' . $linha["id_medicamento"] . '" selected>' . $linha["nm_medicamento"] . '</option>';
                } else {
                    $retorno .= '<option value="' . $linha["id_medicamento"] . '">' . $linha["nm_medicamento"] . '</option>';
                }
            }
            return $retorno;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}