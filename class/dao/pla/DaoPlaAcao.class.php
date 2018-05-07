<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaAcao.class.php";

class DaoPlaAcao extends PlaAcao {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_acao (id_objetivo, nm_acao, ds_indicador, ds_meta_plano, tp_cadastro, id_lotacao) "
                    . " VALUES (:idObjetivo, :nmAcao, :dsIndicador, :dsMetaPlano, :tpCadastro, :idLotacao)");
            $result->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);
            $result->bindValue(":nmAcao", $this->getNmAcao() === '' ? null : $this->getNmAcao(), PDO::PARAM_STR);            
            $result->bindValue(":dsIndicador", $this->getDsIndicador() === '' ? null : $this->getDsIndicador(), PDO::PARAM_STR);
            $result->bindValue(":dsMetaPlano", $this->getDsMetaPlano() === '' ? null : $this->getDsMetaPlano(), PDO::PARAM_STR);
            $result->bindValue(":tpCadastro", $this->getTpCadastro(), PDO::PARAM_STR);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_acao SET nm_acao = :nmAcao "
                    . " , id_objetivo = :idObjetivo, ds_indicador = :dsIndicador "
                    . " , ds_meta_plano = :dsMetaPlano "
                    . " WHERE id_acao = :idAcao ");
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $result->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);
            $result->bindValue(":nmAcao", $this->getNmAcao(), PDO::PARAM_STR);
            $result->bindValue(":dsIndicador", $this->getDsIndicador(), PDO::PARAM_STR);
            $result->bindValue(":dsMetaPlano", $this->getDsMetaPlano(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_acao WHERE id_acao = :idAcao");
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_acao SET st_ativo = 0 "
                    . "WHERE id_acao = :idAcao ");
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retorna as informações de uma Ação Especifica
     * @param type $pdo
     * @return boolean
     */
    function retornaAcao($pdo) {

        $retorno = FALSE;

        $sql = " SELECT id_acao, id_objetivo, nm_acao, ds_indicador, ds_meta_plano, tp_cadastro, id_lotacao, st_ativo"
                . " FROM pla_acao"
                . " WHERE id_acao = :idAcao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    /**
     * Retorna todas as Informações da Ação Por um Objetivo Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaTodasAcoesPorObjetivo($pdo) {

        $retorno = FALSE;

        $sql = " SELECT A.id_acao, A.id_objetivo, A.nm_acao"
                . " , A.ds_indicador, A.ds_meta_plano"
                . " , A.tp_cadastro"
                . " , CASE A.tp_cadastro WHEN 'U' THEN S.nm_lotacao ELSE '' END as tipo"
                . " FROM pla_acao A"
                . " LEFT JOIN ses_lotacao S ON S.id_lotacao = A.id_lotacao"
                . " WHERE A.id_objetivo = :idObjetivo"
                . " ORDER BY A.nm_acao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }      
    
    /**
     * Retorna todas as Informações da Ação Por um Eixo Especifico
     * E além das criada pelo Planejamento, retorna as criadas pela unidade
     * @param int $idEixo id do Eixo
     * @param int $idLotacao id do Lotacao
     * @param type $pdo
     * @return boolean
     */
    function retornaTodasAcoesPorEixoLotacao(int $idEixo, int $idLotacao, $pdo) {

        $retorno = FALSE;

        $sql = " SELECT A.id_acao, A.nm_acao"                                
                . " FROM pla_acao A"
                . " INNER JOIN pla_objetivo O ON O.id_objetivo = A.id_objetivo"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"                
                . " WHERE E.id_eixo = :idEixo"
                    . " AND (A.id_lotacao IS NULL OR A.id_lotacao = :idLotacao)"
                . " ORDER BY A.nm_acao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idEixo", $idEixo, PDO::PARAM_INT);
            $sth->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    
    function retornaDadosAcaoAteEixo($pdo) {

        $retorno = FALSE;

        $sql = " SELECT A.ds_indicador, A.ds_meta_plano, A.nm_acao"
                . " , CONCAT(O.nr_ordem, '. ', O.nm_objetivo) AS nm_objetivo, O.id_objetivo"
                . " , CONCAT(D.nr_ordem, '. ', D.nm_diretriz) AS nm_diretriz, D.id_diretriz"
                . " , CONCAT(E.nr_ordem, '. ', E.nm_eixo) AS nm_eixo, E.id_eixo"
                . " , A.tp_cadastro"
                . " , CASE A.tp_cadastro WHEN 'U' THEN S.nm_lotacao ELSE '' END as tipo"
                . " FROM pla_acao A"
                . " INNER JOIN pla_objetivo O ON O.id_objetivo = A.id_objetivo"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"
                . " LEFT JOIN ses_lotacao S ON S.id_lotacao = A.id_lotacao"
                . " WHERE A.id_acao = :idAcao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    /**
     * Retorna as Ações de Uma Lotação de Acordo com o PAS
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    function retornaAcoesLotacaoPorPas(int $idPas, $pdo) {

        $retorno = FALSE;

        $sql = " SELECT A.id_acao, A.nm_acao"                                
                . " FROM pla_pas P"
                . " INNER JOIN pla_pes PES ON PES.id_pes = P.id_pes"
                . " INNER JOIN pla_eixo E ON E.id_pes = PES.id_pes"
                . " INNER JOIN pla_diretriz D ON D.id_eixo = E.id_eixo"
                . " INNER JOIN pla_objetivo O ON O.id_diretriz = D.id_diretriz"
                . " INNER JOIN pla_acao A ON A.id_objetivo = O.id_objetivo "
                    . " AND A.id_lotacao = P.id_lotacao"                                
                . " WHERE P.id_pas = :idPas";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPas", $idPas, PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

}
