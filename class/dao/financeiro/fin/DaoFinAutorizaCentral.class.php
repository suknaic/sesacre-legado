<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinAutorizaCentral.class.php";

class DaoFinAutorizaCentral extends FinAutorizaCentral {

    private $sucesso = false;
    private $msgRetorno = null;

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function sucesso() {
        return $this->sucesso;
    }

    public function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_autoriza_central (dt_ini,dt_fim,id_pessoa,id_lotacao) "
                        . "values (:dt_ini, :dt_fim, :id_pessoa, :id_lotacao) ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function update(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_autoriza_central "
                        . "set "
                        . "dt_ini = :dt_ini, "
                        . "dt_fim = :dt_fim, "
                        . "id_pessoa = :id_pessoa, "
                        . "id_lotacao = :id_lotacao "
                        . "where id_autoriza_central = :id_autoriza_central";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_autoriza_atividade", $this->getIdAutorizaCentral(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_autoriza_central where id_autoriza_central = :id_autoriza_central";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_autoriza_central", $this->getIdAutorizaCentral(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function selectAll(PDO $pdo = null) {

        try {
            if (!empty($pdo)) {
                $sql = "select fac.id_autoriza_central"
                        . " ,to_char(fac.dt_ini,'dd/mm/yyyy') as dt_ini"
                        . " ,to_char(fac.dt_fim, 'dd/mm/yyyy') as dt_fim"
                        . " ,sp.nm_pessoa, sl.nm_lotacao, fac.st_ativo"
                        . " from fin_autoriza_central fac"
                        . " inner join ses_pessoa sp on sp.id_pessoa = fac.id_pessoa"
                        . " inner join ses_lotacao sl on sl.id_lotacao = fac.id_lotacao"
                        . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);

                if (!empty($this->getIdPessoa())) {
                    $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                }
                if (!empty($this->getIdLotacao())) {
                    $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                }

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function selectAutorizacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select fac.id_autoriza_central as id_autorizacao, "
                        . "to_char(fac.dt_ini,'dd/mm/yyyy') as dt_ini, "
                        . "to_char(fac.dt_fim,'dd/mm/yyyy') as dt_fim, "
                        . "fac.st_ativo, fac.id_pessoa, fac.id_lotacao , 2 as tipo_autorizacao "
                        . "from fin_autoriza_central fac "
                        . "where id_autoriza_central = :id_autoriza_central";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_autoriza_central', $this->getIdAutorizaCentral(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    private function montaFiltro() {
        $filtro_sql = "";
        //faa - FinAutorizaAtividade
        if (!empty($this->getIdPessoa())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " fac.id_pessoa = :id_pessoa";
        }
        if (!empty($this->getIdLotacao())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " fac.id_lotacao = :id_lotacao";
        }

        return $filtro_sql;
    }

    public function retornaLotacoAutorizacaoUsuario(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_lotacao from fin_autoriza_central  where id_pessoa  = :idPessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idPessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaPedidoParaAutorizacaoCentral(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as numero, 
                        p.ds_pedido, tp.nm_tipo_gasto, font.nr_fonte, desp.cd_despesa_elemento, coalesce(p.vl_pedido,'0.0000') as vl_pedido, p.id_pedido,
                        diaria.id_diaria
                        from fin_pedido as p
                        inner join pla_tipo_gasto as tp 
                        on tp.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_fonte as font
                        on font.id_fonte = p.id_fonte
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento
                        left join dia_diaria as diaria
                        on diaria.id_pedido = p.id_pedido
                        where p.st_pedido = :tipoAutorizacao
                        and p.id_lotacao in (" . $this->getIdLotacao() . ") ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':tipoAutorizacao', $this->getTipoAutorizacao(), PDO::PARAM_INT);

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
        public function retornaPedidoParaAutorizacaoOrcamnetoEOrdenado(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as numero, 
                        p.ds_pedido, tp.nm_tipo_gasto, font.nr_fonte, desp.cd_despesa_elemento, coalesce(p.vl_pedido,'0.0000') as vl_pedido, p.id_pedido,
                        diaria.id_diaria
                        from fin_pedido as p
                        inner join pla_tipo_gasto as tp 
                        on tp.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_fonte as font
                        on font.id_fonte = p.id_fonte
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento
                        left join dia_diaria as diaria
                        on diaria.id_pedido = p.id_pedido
                        where p.st_pedido = :tipoAutorizacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':tipoAutorizacao', $this->getTipoAutorizacao(), PDO::PARAM_INT);

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function validaPermisaoUsuarioCentral(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pessoa from fin_autoriza_central  where id_pessoa  = :idPessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idPessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function validaPermisaoUsuarioAtividade(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pessoa from fin_autoriza_atividade  where id_pessoa  = :idPessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idPessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function validaPermisaoUsuarioOrcamento(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pessoa from fin_autoriza_orcamento  where id_pessoa  = :idPessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idPessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function validaPermisaoUsuarioFinanceiro(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pessoa from fin_autorizacao_financeiro  where id_pessoa  = :idPessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idPessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function validaPermisaoUsuarioOrdenado(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pessoa from fin_autorizacao_ordenado  where id_pessoa  = :idPessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idPessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
