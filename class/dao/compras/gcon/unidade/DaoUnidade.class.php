<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/unidade/unidadeExtd.class.php";

class DaoUnidade extends UnidadeExtd {
    /*
     * Cadastra unidade
     */

    function cadastrarUnidade($pdo) {
        try {
            $cadastra = $pdo->prepare("INSERT INTO gco_unidade_contempladas(nm_unidade_contempladas) VALUES (:unidade)");
            $cadastra->bindValue(":unidade", $this->getUnidade() === '' ? null : $this->getUnidade(), PDO::PARAM_STR);
            $cadastra->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Verifica se a unidade já existe no sistema.
     */

    function verificarUnidade($pdo) {
        try {
            $verifica = $pdo->prepare("SELECT nm_unidade_contempladas FROM gco_unidade_contempladas WHERE nm_unidade_contempladas=:unidade");
            $verifica->bindValue(":unidade", $this->getUnidade(), PDO::PARAM_STR);
            $verifica->execute();
            if ($verifica->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Pesquisa a unidade.
     */

    function pesquisarUnidade($pdo) {
        try {
            $busca = $pdo->prepare("SELECT id_unidade_contempladas,nm_unidade_contempladas FROM gco_unidade_contempladas"
                    . " WHERE nm_unidade_contempladas ILIKE :unidade AND sit_ativo='1'");
            $busca->bindValue(":unidade", $this->getUnidade() . '%', PDO::PARAM_STR);
            $busca->execute();
            if ($busca->rowCount() >= 0) {
                return $busca->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Lista todas as unidades.
     */

    function retornarTodasUnidades($pdo) {
        try {
            $busca = $pdo->prepare("SELECT * FROM gco_unidade_contempladas WHERE sit_ativo=:status ORDER BY nm_unidade_contempladas");
            $busca->bindValue(":status", 1, PDO::PARAM_INT);
            $busca->execute();
            if ($busca->rowCount() >= 0) {
                return $busca->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Edita uma unidade.
     */

    function editarUnidade($pdo) {
        try {
            $edita = $pdo->prepare("UPDATE gco_unidade_contempladas SET nm_unidade_contempladas=:unidade WHERE id_unidade_contempladas=:idUnidade");
            $edita->bindValue(":unidade", $this->getUnidade(), PDO::PARAM_STR);
            $edita->bindValue(":idUnidade", $this->getIdUnidade(), PDO::PARAM_INT);
            $edita->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Desativa uma unidade.
     */

    function desativarUnidade($pdo) {
        try {
            $exclui = $pdo->prepare("UPDATE gco_unidade_contempladas SET sit_ativo=:status WHERE id_unidade_contempladas=:idUnidade");
            $exclui->bindValue(":idUnidade", $this->getIdUnidade(), PDO::PARAM_INT);
            $exclui->bindValue(":status", 0, PDO::PARAM_STR);
            $exclui->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Lita todas as modalidades desativadas.
     */

    function unidadesDesativadas($pdo) {
        try {
            $list = $pdo->prepare("SELECT id_unidade_contempladas, nm_unidade_contempladas FROM gco_unidade_contempladas WHERE sit_ativo='0'");
            $list->execute();
            if ($list->rowcount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Ativa modalidade.
     */

    function ativarUnidade($pdo) {
        try {
            $sit = $pdo->prepare("UPDATE gco_unidade_contempladas SET sit_ativo=:status WHERE id_unidade_contempladas=:id_unidade");
            $sit->bindValue(":id_unidade", $this->getIdUnidade(), PDO::PARAM_INT);
            $sit->bindValue(":status", 1, PDO::PARAM_STR);
            $sit->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Retorna dados da unidade para o log.
     */

    function retornarUnidade($pdo) {
        try {
            $busca = $pdo->prepare("SELECT * FROM gco_unidade_contempladas WHERE id_unidade_contempladas=:idUnidade");
            $busca->bindValue(":idUnidade", $this->getIdUnidade(), PDO::PARAM_INT);
            $busca->execute();
            if ($busca->rowCount() > 0) {
                return $busca->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
