<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaMaterial.class.php";

/**
 * Description of DaoChaMaterial
 *
 * @author elivelton
 */
class DaoChaMaterial extends ChaMaterial {

    public function cadastrarMaterial($pdo) {
        try {
            $sql = $pdo->prepare('INSERT INTO cha_material(nm_material, dt_aquisicao, ds_marca, ds_modelo, nr_patrimonio, vl_preco, qt_meses_garantia, nm_serie, tp_estado,id_unidade_medida, qt_memoria_ram, ds_processador, qt_hd, qt_fonte, fl_wireless) '
                    . 'VALUES(:nmMaterial, :dtAquisicao, :dsMarca, :dsModelo, :nrPatrimonio, :vlPreco, :qtMesesGarantia, :nmSerie, :tpEstado, :idUnidadeMedida, :qtMemoriaRam, :dsProcessador, :qtHd, :qtFonte, :flWireless)');
            $sql->bindValue(':nmMaterial', $this->getNm_material(), PDO::PARAM_STR);
            $sql->bindValue(':dtAquisicao', $this->getDt_aquisicao(), PDO::PARAM_STR);
            $sql->bindValue(':dsMarca', $this->getDs_marca(), PDO::PARAM_STR);
            $sql->bindValue(':dsModelo', $this->getDs_modelo(), PDO::PARAM_STR);
            $sql->bindValue(':nrPatrimonio', $this->getNr_patrimonio(), PDO::PARAM_STR);
            $sql->bindValue(':vlPreco', $this->getVl_preco(), PDO::PARAM_STR);
            $sql->bindValue(':qtMesesGarantia', $this->getQt_meses_garantia() === 0 ? null : $this->getQt_meses_garantia(), PDO::PARAM_INT);
            $sql->bindValue(':nmSerie', $this->getNm_serie(), PDO::PARAM_STR);
            $sql->bindValue(':tpEstado', $this->getTp_estado(), PDO::PARAM_STR);
            $sql->bindValue(':idUnidadeMedida', $this->getId_unidade_medida() === 0 ? null : $this->getId_unidade_medida(), PDO::PARAM_INT);
            $sql->bindValue(':qtMemoriaRam', $this->getQt_memoria_ram() === 0 ? null : $this->getQt_memoria_ram(), PDO::PARAM_STR);
            $sql->bindValue(':dsProcessador', $this->getDs_processador(), PDO::PARAM_STR);
            $sql->bindValue(':qtHd', $this->getQt_hd() === 0 ? null : $this->getQt_hd(), PDO::PARAM_STR);
            $sql->bindValue(':qtFonte', $this->getQt_fonte() === 0 ? null : $this->getQt_fonte(), PDO::PARAM_STR);
            $sql->bindValue(':flWireless', $this->getFl_wireless() === 0 ? null : $this->getFl_wireless(), PDO::PARAM_STR);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function listarMateriais($pdo, $condicao) {
        try {
            $sql = $pdo->prepare("SELECT M.id_material, M.nm_material, M.dt_aquisicao, M.ds_marca, M.ds_modelo,
                                    M.nr_patrimonio, M.vl_preco, M.qt_meses_garantia, M.nm_serie, M.tp_estado,
                                    U.nm_unidade_medida, M.qt_memoria_ram, M.ds_processador, M.qt_hd, M.qt_fonte,
                                    M.fl_wireless
                                 FROM cha_material M
                                    INNER JOIN pla_unidade_medida U ON M.id_unidade_medida = U.id_unidade_medida
                              $condicao");
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function editarMaterial($pdo) {
        try {
            $sql = $pdo->prepare("UPDATE cha_material SET 
                                    nm_material = :nmMaterial, 
                                    dt_aquisicao = :dtAquisicao, 
                                    ds_marca = :dsMarca, 
                                    ds_modelo = :dsModelo, 
                                    nr_patrimonio = :nrPatrimonio, 
                                    vl_preco = :vlPreco, 
                                    qt_meses_garantia = :qtGarantia, 
                                    nm_serie = :nmSerie, 
                                    tp_estado = :tpEstado, 
                                    id_unidade_medida = :idUnidadeMedida, 
                                    qt_memoria_ram = :qtMemoriaRam, 
                                    ds_processador = :dsProcessador, 
                                    qt_hd = :qtHd, 
                                    qt_fonte = :qtFonte, 
                                    fl_wireless = :flWireless
                                 WHERE id_material = :idMaterial");
            $sql->bindValue(':idMaterial', $this->getId_material(), PDO::PARAM_INT);
            $sql->bindValue(':nmMaterial', $this->getNm_material(), PDO::PARAM_STR);
            $sql->bindValue(':dtAquisicao', $this->getDt_aquisicao(), PDO::PARAM_STR);
            $sql->bindValue(':dsMarca', $this->getDs_marca(), PDO::PARAM_STR);
            $sql->bindValue(':dsModelo', $this->getDs_modelo(), PDO::PARAM_STR);
            $sql->bindValue(':nrPatrimonio', $this->getNr_patrimonio(), PDO::PARAM_STR);
            $sql->bindValue(':vlPreco', $this->getVl_preco(), PDO::PARAM_STR);
            $sql->bindValue(':qtGarantia', $this->getQt_meses_garantia() === 0 ? null : $this->getQt_meses_garantia(), PDO::PARAM_INT);
            $sql->bindValue(':nmSerie', $this->getNm_serie(), PDO::PARAM_STR);
            $sql->bindValue(':tpEstado', $this->getTp_estado(), PDO::PARAM_STR);
            $sql->bindValue(':idUnidadeMedida', $this->getId_unidade_medida() === 0 ? null : $this->getId_unidade_medida(), PDO::PARAM_INT);
            $sql->bindValue(':qtMemoriaRam', $this->getQt_memoria_ram() === 0 ? null : $this->getQt_memoria_ram(), PDO::PARAM_STR);
            $sql->bindValue(':dsProcessador', $this->getDs_processador(), PDO::PARAM_STR);
            $sql->bindValue(':qtHd', $this->getQt_hd() === 0 ? null : $this->getQt_hd(), PDO::PARAM_STR);
            $sql->bindValue(':qtFonte', $this->getQt_fonte() === 0 ? null : $this->getQt_fonte(), PDO::PARAM_STR);
            $sql->bindValue(':flWireless', $this->getFl_wireless(), PDO::PARAM_STR);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function carregarDadosMaterial($pdo) {
        try {
            $sql = $pdo->prepare("SELECT M.id_material, M.nm_material, M.dt_aquisicao, M.ds_marca, M.ds_modelo,
                                    M.nr_patrimonio, M.vl_preco, M.qt_meses_garantia, M.nm_serie, M.tp_estado,
                                    U.id_unidade_medida, M.qt_memoria_ram, M.ds_processador, M.qt_hd, M.qt_fonte,
                                    M.fl_wireless
                                 FROM cha_material M
                                    INNER JOIN pla_unidade_medida U ON M.id_unidade_medida = U.id_unidade_medida
                                 WHERE M.id_material = :idMaterial");
            $sql->bindValue(':idMaterial', $this->getId_material(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function verificaMaterial($pdo, $coluna, $atributo) {
        try {
            $sql = $pdo->prepare('SELECT * '
                               . 'FROM cha_material '
                               . 'WHERE '.$coluna.' = '.$atributo);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return 0;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function deletarMaterial($pdo) {
        try {
            $sql = $pdo->prepare('DELETE FROM cha_material '
                               . 'WHERE id_material = :idMaterial');
            $sql->bindValue(':idMaterial', $this->getId_material(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
