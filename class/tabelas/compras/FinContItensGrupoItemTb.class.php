<?php

class FinContItensGrupoItemTb {

    private $id_cont_itens_grupo_item = null;
    private $id_cont_itens_grupo = null;
    private $id_cont_itens = null;

    
    /**
     * Get the value of Id Cont Itens Grupo Item
     *
     * @return mixed
     */
    public function getIdContItensGrupoItem()
    {
        return $this->id_cont_itens_grupo_item;
    }

    /**
     * Set the value of Id Cont Itens Grupo Item
     *
     * @param mixed id_cont_itens_grupo_item
     *
     * @return self
     */
    public function setIdContItensGrupoItem($id_cont_itens_grupo_item)
    {
        $this->id_cont_itens_grupo_item = $id_cont_itens_grupo_item;

        return $this;
    }

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
     * Get the value of Id Cont Itens
     *
     * @return mixed
     */
    public function getIdContItens()
    {
        return $this->id_cont_itens;
    }

    /**
     * Set the value of Id Cont Itens
     *
     * @param mixed id_cont_itens
     *
     * @return self
     */
    public function setIdContItens($id_cont_itens)
    {
        $this->id_cont_itens = $id_cont_itens;

        return $this;
    }

}
