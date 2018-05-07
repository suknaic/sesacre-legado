<?php

class ChaServicoMaterial {
    
    private $id_servico_material = null;
    private $id_servico = null;
    private $id_material = null;
    private $qt_material = null;
    private $vl_material = null;
    
    /**
     * ChaServicoMaterial: No mesmo serviço pode-se usar vários materiais, e o material tem o quantidade de usados e valores. Ex: Para arrumar 
     * qt_material
     * vl_material: Valor de cada material utilizado
     */
    function getId_servico_material() {
        return $this->id_servico_material;
    }

    function getId_servico() {
        return $this->id_servico;
    }

    function getId_material() {
        return $this->id_material;
    }

    function getQt_material() {
        return $this->qt_material;
    }

    function getVl_material() {
        return $this->vl_material;
    }

    function setId_servico_material($id_servico_material) {
        $this->id_servico_material = $id_servico_material;
    }

    function setId_servico($id_servico) {
        $this->id_servico = $id_servico;
    }

    function setId_material($id_material) {
        $this->id_material = $id_material;
    }

    function setQt_material($qt_material) {
        $this->qt_material = $qt_material;
    }

    function setVl_material($vl_material) {
        $this->vl_material = $vl_material;
    }


}
