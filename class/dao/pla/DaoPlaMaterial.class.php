<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaMaterial.class.php";

class DaoPlaMaterial extends PlaMaterial {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
       
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_material (cd_material, nm_material"
                    . " , cd_desc_material, nm_desc_material, cd_grupo, nm_grupo"
                    . " , cd_sub_grupo, nm_sub_grupo, tp_material"
                    . " , cd_elemento_despesa, id_despesa) "
                    . " VALUES (:cdMaterial, :nmMaterial, :cdDescMaterial, :nmDescMaterial"
                    . " , :cdGrupo, :nmGrupo, :cdSubGrupo, :nmSubGrupo, :tpMaterial, :cdElementoDespesa"
                    . " , :idDespesa)");            
            $result->bindValue(":cdMaterial", $this->getCdMaterial(), PDO::PARAM_INT);
            $result->bindValue(":nmMaterial", $this->getNmMaterial(), PDO::PARAM_STR);
            $result->bindValue(":cdDescMaterial", $this->getCdDescMaterial(), PDO::PARAM_INT);
            $result->bindValue(":nmDescMaterial", $this->getNmDescMaterial(), PDO::PARAM_STR);
            $result->bindValue(":cdGrupo", $this->getCdGrupo(), PDO::PARAM_INT);
            $result->bindValue(":nmGrupo", $this->getNmGrupo(), PDO::PARAM_STR);
            $result->bindValue(":cdSubGrupo", $this->getCdSubGrupo(), PDO::PARAM_INT);
            $result->bindValue(":nmSubGrupo", $this->getNmSubGrupo(), PDO::PARAM_STR);
            $result->bindValue(":tpMaterial", $this->getTpMaterial(), PDO::PARAM_STR);
            $result->bindValue(":cdElementoDespesa", $this->getCdElementoDespesa(), PDO::PARAM_STR);
            $result->bindValue(":idDespesa", $this->getIdDespesa(), PDO::PARAM_INT); 
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_material SET cd_material = :cdMaterial, nm_material = :nmMaterial"
                    . " , cd_desc_material = :idObjetivo, nm_desc_material = :dsIndicador "
                    . " , cd_grupo = :nm_grupo, cd_sub_grupo = :cd_sub_grupo"
                    . " , tp_material = :tp_material, cd_elemento_despesa = :cd_elemento_despesa"
                    . " , id_despesa = :id_despesa"
                    . " WHERE id_material = :idMaterial");
            $result->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
            $result->bindValue(":cdMaterial", $this->getCdMaterial(), PDO::PARAM_INT);
            $result->bindValue(":nmMaterial", $this->getNmMaterial(), PDO::PARAM_STR);
            $result->bindValue(":cdDescMaterial", $this->getCdDescMaterial(), PDO::PARAM_INT);
            $result->bindValue(":nmDescMaterial", $this->getNmDescMaterial(), PDO::PARAM_STR);
            $result->bindValue(":cdGrupo", $this->getCdGrupo(), PDO::PARAM_INT);
            $result->bindValue(":nmGrupo", $this->getNmGrupo(), PDO::PARAM_STR);
            $result->bindValue(":cdSubGrupo", $this->getCdSubGrupo(), PDO::PARAM_INT);
            $result->bindValue(":nmSubGrupo", $this->getNmSubGrupo(), PDO::PARAM_STR);
            $result->bindValue(":tpMaterial", $this->getTpMaterial(), PDO::PARAM_STR);
            $result->bindValue(":cdElementoDespesa", $this->getCdElementoDespesa(), PDO::PARAM_INT);
            $result->bindValue(":idDespesa", $this->getIdDespesa(), PDO::PARAM_INT);          
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();    
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_material WHERE id_material = :idMaterial");
            $result->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_material SET st_ativo = 0 "
                    . "WHERE id_material = :idMaterial ");
            $result->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }

    /**
     * Retorna as informações de um Material Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_material, cd_material, nm_material"
                    . " , cd_desc_material, nm_desc_material, cd_grupo, nm_grupo"
                    . " , cd_sub_grupo, nm_sub_grupo, tp_material"
                    . " , cd_elemento_despesa, id_despesa, st_ativo"
                . " FROM pla_material"
                . " WHERE id_material = :idMaterial";
        try {
            $sth = $pdo->prepare($sql);
            $result->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true; 
                $this->msgRetorno = $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    /**
     * Retorna as informações de um Material Especifico Pelo Codigo da Descrição do Material
     * @param type $pdo
     * @return boolean
     */
    function retornaPorCodigoDescMaterial($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_material, cd_material, nm_material"
                    . " , cd_desc_material, nm_desc_material, cd_grupo, nm_grupo"
                    . " , cd_sub_grupo, nm_sub_grupo, tp_material"
                    . " , cd_elemento_despesa, id_despesa, st_ativo"
                . " FROM pla_material"
                . " WHERE cd_desc_material = :cdDescMaterial";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":cdDescMaterial", $this->getCdDescMaterial(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true; 
                $this->msgRetorno = $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    } 
    
    function pesquisaPorNmDescMaterial($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_material, cd_material, nm_material"
                    . " , cd_desc_material, nm_desc_material, cd_grupo, nm_grupo"
                    . " , cd_sub_grupo, nm_sub_grupo, tp_material"
                    . " , cd_elemento_despesa, id_despesa, st_ativo"
                . " FROM pla_material"
                . " WHERE nm_desc_material ILIKE :nmDescMaterial";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmDescMaterial", "%".$this->getNmDescMaterial()."%", PDO::PARAM_STR);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true; 
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }

}
