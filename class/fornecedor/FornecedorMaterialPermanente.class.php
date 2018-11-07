<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoFornecedorMaterialPermanente.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 09:17
 */

class FornecedorMaterialPermanente{

    private $idFornecedorMaterialPermanente = null;
    private $idFornecedor = null;
    private $idMaterialPermanente = null;

    /**
     * @return null
     */
    public function getIdFornecedorMaterialPermanente()
    {
        return $this->idFornecedorMaterialPermanente;
    }

    /**
     * @param null $idFornecedorMaterialPermanente
     */
    public function setIdFornecedorMaterialPermanente($idFornecedorMaterialPermanente)
    {
        $this->idFornecedorMaterialPermanente = $idFornecedorMaterialPermanente;
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
    public function getIdMaterialPermanente()
    {
        return $this->idMaterialPermanente;
    }

    /**
     * @param null $idMaterialPermanente
     */
    public function setIdMaterialPermanente($idMaterialPermanente)
    {
        $this->idMaterialPermanente = $idMaterialPermanente;
    }


    public function cadastraFornecedorMaterialPermanente($pdo) {
        try {
            $fornecedorMaterialPermanente = new DaoFornecedorMaterialPermanente();
            $fornecedorMaterialPermanente->setIdMaterialPermanente($this->idMaterialPermanente);
            $fornecedorMaterialPermanente->setIdFornecedor($this->idFornecedor);

            if (!$fornecedorMaterialPermanente->cadastrarFornecedorMaterialPermanente($pdo)) {
                return false;
            }

            $this->setIdFornecedorMaterialPermanente($pdo->lastInsertId('for_fornecedor_material_perma_id_fornecedor_material_perman_seq'));
            if (!LOG::SalvaLogI('for_fornecedor_material_permanente', $this->getIdFornecedorMaterialPermanente(), $pdo)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}