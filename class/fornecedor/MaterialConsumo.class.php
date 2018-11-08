<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoMaterialConsumo.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:27
 */

class MaterialConsumo {
    private $idMaterialConsumo = null;
    private $nmMaterialConsumo = null;

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

    /**
     * @return null
     */
    public function getNmMaterialConsumo()
    {
        return $this->nmMaterialConsumo;
    }

    /**
     * @param null $nmMaterialConsumo
     */
    public function setNmMaterialConsumo($nmMaterialConsumo)
    {
        $this->nmMaterialConsumo = $nmMaterialConsumo;
    }

    public function retornaOptionMaterialConsumo($idMaterialConsumo = null) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $materialConsumo = new DaoMaterialConsumo();
            $retorno = '';
            $busca = $materialConsumo->retornaMaterialConsumo($pdo);
            foreach ($busca as $linha) {
                if ($idMaterialConsumo == $linha["id_material_consumo"]) {
                    $retorno .= '<option value="' . $linha["id_material_consumo"] . '" selected>' . $linha["nm_material_consumo"] . '</option>';
                } else {
                    $retorno .= '<option value="' . $linha["id_material_consumo"] . '">' . $linha["nm_material_consumo"] . '</option>';
                }
            }
            return $retorno;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}