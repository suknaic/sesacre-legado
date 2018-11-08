<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/fornecedor/DaoServico.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:24
 */

class Servico {
    private $idServio = null;
    private $nmServico = null;

    /**
     * @return null
     */
    public function getIdServio()
    {
        return $this->idServio;
    }

    /**
     * @param null $idServio
     */
    public function setIdServio($idServio)
    {
        $this->idServio = $idServio;
    }

    /**
     * @return null
     */
    public function getNmServico()
    {
        return $this->nmServico;
    }

    /**
     * @param null $nmServico
     */
    public function setNmServico($nmServico)
    {
        $this->nmServico = $nmServico;
    }

    public function retornaOptionServico($idServico = null) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $servico = new DaoServico();
            $retorno = '';
            $busca = $servico->retornaServico($pdo);
            foreach ($busca as $linha) {
                if ($idServico == $linha["id_servico"]) {
                    $retorno .= '<option value="' . $linha["id_servico"] . '" selected>' . $linha["nm_servico"] . '</option>';
                } else {
                    $retorno .= '<option value="' . $linha["id_servico"] . '">' . $linha["nm_servico"] . '</option>';
                }
            }
            return $retorno;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}