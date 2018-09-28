<?php

class FinContItensGrupoTb {

    private $id_cont_itens_grupo = null;
    private $dh_cont_itens_grupo = null;

    
    /**
     * Get the value of Id Cont Itens Grupo
     *
     * @return mixed
     */
    public function getIdContItensGrupo()
    {
        return $this->id_cont_itens_grupo;
    }

    /**
     * Set the value of Id Cont Itens Grupo
     *
     * @param mixed id_cont_itens_grupo
     *
     * @return self
     */
    public function setIdContItensGrupo($id_cont_itens_grupo)
    {
        $this->id_cont_itens_grupo = $id_cont_itens_grupo;

        return $this;
    }

    /**
     * Get the value of Dh Cont Itens Grupo
     *
     * @return mixed
     */
    public function getDhContItensGrupo()
    {
        return $this->dh_cont_itens_grupo;
    }

    /**
     * Set the value of Dh Cont Itens Grupo
     *
     * @param mixed dh_cont_itens_grupo
     *
     * @return self
     */
    public function setDhContItensGrupo($dh_cont_itens_grupo)
    {
        $this->dh_cont_itens_grupo = $dh_cont_itens_grupo;

        return $this;
    }

}
