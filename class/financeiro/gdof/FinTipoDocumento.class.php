<?php

class FinTipoDocumento {

    private $id_tipo_documento = null;
    private $nm_tipo_documento = null;

    /**
     * @return mixed
     */
    public function getIdTipoDocumento() {
        return $this->id_tipo_documento;
    }

    /**
     * @param mixed $id_tipo_documento
     *
     * @return self
     */
    public function setIdTipoDocumento($id_tipo_documento) {
        $this->id_tipo_documento = $id_tipo_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmTipoDocumento() {
        return $this->nm_tipo_documento;
    }

    /**
     * @param mixed $nm_tipo_documento
     *
     * @return self
     */
    public function setNmTipoDocumento($nm_tipo_documento) {
        $this->nm_tipo_documento = $nm_tipo_documento;

        return $this;
    }

    public static function retornaOptionsTipoDocumento($id = 0) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinTipoDocumento = new DaoFinTipoDocumento();
        $daoFinTipoDocumento->retornaTipoDocumento($pdo);
        $options = '';
        if ($daoFinTipoDocumento->sucesso()) {
            foreach ($daoFinTipoDocumento->getMsgRetorno() as $valores) {
                if ($id == $valores["id_tipo_documento"]) {
                    $options .= '<option value="' . $valores["id_tipo_documento"] . '" selected>' . $valores["nm_tipo_documento"] . '</option>';
                } else {
                    $options .= '<option value="' . $valores["id_tipo_documento"] . '">' . $valores["nm_tipo_documento"] . '</option>';
                }
            }
        }
        return $options;
    }

}
