<?php

class FinQdd {

    private $id_qdd = null;
    private $aa_qdd = null;
    
    function getIdQdd() {
        return $this->id_qdd;
    }

    function getAaQdd() {
        return $this->aa_qdd;
    }

    function setIdQdd($id_qdd) {
        $this->id_qdd = $id_qdd;
        return $this;
    }

    function setAaQdd($aa_qdd) {
        $this->aa_qdd = $aa_qdd;
        return $this;
    }


    

}
