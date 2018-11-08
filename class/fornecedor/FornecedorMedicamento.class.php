<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoFornecedorMedicamento.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 09:16
 */

class FornecedorMedicamento {
    private $idFornecedorMedicamento = null;
    private $idFornecedor = null;
    private $idMedicamento = null;

    /**
     * @return null
     */
    public function getIdFornecedorMedicamento()
    {
        return $this->idFornecedorMedicamento;
    }

    /**
     * @param null $idFornecedorMedicamento
     */
    public function setIdFornecedorMedicamento($idFornecedorMedicamento)
    {
        $this->idFornecedorMedicamento = $idFornecedorMedicamento;
    }

    /**
     * @return null
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param null $idFornecedor
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
    }

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

    public function cadastrarFornecedorMedicamento ($pdo) {
        try {

            $fornecedorMedicamento = new DaoFornecedorMedicamento();
            $fornecedorMedicamento->setIdFornecedor($this->idFornecedor);
            $fornecedorMedicamento->setIdMedicamento($this->idMedicamento);

            $cadastra = $fornecedorMedicamento->cadastrarFornecedorMedicamento($pdo);
            if (!$cadastra) {
                return false;
            }

            $this->setIdFornecedorMedicamento($pdo->lastInsertId('for_fornecedor_medicamento_id_fornecedor_medicamento_seq'));
            if (!LOG::SalvaLogI('for_fornecedor_medicamento', $this->getIdFornecedorMedicamento(), $pdo)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return $e ->getMessage();
        }
    }
}