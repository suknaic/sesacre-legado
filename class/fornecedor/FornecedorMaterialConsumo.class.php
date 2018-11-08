<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoFornecedorMaterialConsumo.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 09:17
 */

class FornecedorMaterialConsumo {
    private $idFornecedorMaterialConsumo = null;
    private $idFornecedor = null;
    private $idMaterialConsumo = null;

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
    public function getIdFornecedorMaterialConsumo()
    {
        return $this->idFornecedorMaterialConsumo;
    }

    /**
     * @param null $idFornecedorMaterialConsumo
     */
    public function setIdFornecedorMaterialConsumo($idFornecedorMaterialConsumo)
    {
        $this->idFornecedorMaterialConsumo = $idFornecedorMaterialConsumo;
    }

    /**
     * @return null
     */
    public function getIdMaterialConsumo()
    {
        return $this->idMaterialConsumo;
    }

    /**
     * @param null $idMaterialConsumo
     */
    public function setIdMaterialConsumo($idMaterialConsumo)
    {
        $this->idMaterialConsumo = $idMaterialConsumo;
    }


    public function cadastrarFornecedorMaterialConsumo($pdo) {
        try {
            $fornecedorMaterialConsumo = new DaoFornecedorMaterialConsumo();
            $fornecedorMaterialConsumo->setIdMaterialConsumo($this->idMaterialConsumo);
            $fornecedorMaterialConsumo->setIdFornecedor($this->idFornecedor);

            if (!$fornecedorMaterialConsumo->cadastrarFornecedorMaterialConsumo($pdo)) {
                return false;
            }

            $this->setIdFornecedorMaterialConsumo($pdo->lastInsertId('for_fornecedor_material_consu_id_fornecedor_material_consum_seq'));
            if (!LOG::SalvaLogI('for_fornecedor_material_consumo', $this->getIdFornecedorMaterialConsumo(), $pdo)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}