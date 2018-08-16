<?php

class FinTipoDocumentoTb {

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

}
