<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoFornecedorServico.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 09:17
 */

class FornecedorServico {
    private $idFornecedorServico = null;
    private $idFornecedor = null;
    private $idServico = null;

    /**
     * @return null
     */
    public function getIdFornecedorServico()
    {
        return $this->idFornecedorServico;
    }

    /**
     * @param null $idFornecedorServico
     */
    public function setIdFornecedorServico($idFornecedorServico)
    {
        $this->idFornecedorServico = $idFornecedorServico;
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
    public function getIdServico()
    {
        return $this->idServico;
    }

    /**
     * @param null $idServico
     */
    public function setIdServico($idServico)
    {
        $this->idServico = $idServico;
    }


    public function cadastraFornecedorServico ($pdo) {
        try {

            $fornecedorServico = new DaoFornecedorServico();
            $fornecedorServico->setIdServico($this->idServico);
            $fornecedorServico->setIdFornecedor($this->idFornecedor);

            $cadastra = $fornecedorServico->cadastrarFornecedorServico($pdo);
            if (!$cadastra) {
                return false;
            }

            $this->setIdFornecedorServico($pdo->lastInsertId('for_fornecedor_servico_id_fornecedor_servico_seq'));
            if (!LOG::SalvaLogI('for_fornecedor_servico', $this->getIdFornecedorServico(), $pdo)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return $e ->getMessage();
        }
    }
}