<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoMaterialPermanente.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:27
 */

class MaterialPermanente {
    private $idMaterialPermanente = null;
    private $nmMaterialPermanente = null;

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

    /**
     * @return null
     */
    public function getNmMaterialPermanente()
    {
        return $this->nmMaterialPermanente;
    }

    /**
     * @param null $nmMaterialPermanente
     */
    public function setNmMaterialPermanente($nmMaterialPermanente)
    {
        $this->nmMaterialPermanente = $nmMaterialPermanente;
    }

    public function retornaOptionMaterialPermanente($idMaterialPermanente = null) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $materialPermanente  = new DaoMaterialPermanente();
            $retorno = '';
            $busca = $materialPermanente ->retornaMaterialPermanente($pdo);
            foreach ($busca as $linha) {
                if ($idMaterialPermanente == $linha["id_material_permanente"]) {
                    $retorno .= '<option value="' . $linha["id_material_permanente"] . '" selected>' . $linha["nm_material_permanente"] . '</option>';
                } else {
                    $retorno .= '<option value="' . $linha["id_material_permanente"] . '">' . $linha["nm_material_permanente"] . '</option>';
                }
            }
            return $retorno;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}