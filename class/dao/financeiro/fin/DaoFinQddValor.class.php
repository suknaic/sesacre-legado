<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinQddValorTb.class.php";

class DaoFinQddValor extends FinsQddValorTb {

    private $sucesso = null;
    private $msgRetorno = null;

    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function insertInicial($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO fin_qdd_valor (id_qdd, id_fonte, id_programa_trabalho"
                    . " , id_despesa_elemento, vl_qdd_inicial, vl_saldo) "
                    . " VALUES (:idQdd, :idFonte, :idProgramaTrabalho, :idDespesaElemento"
                    . " , :vlQddInicial, :vlSaldo)");
            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $result->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
            $result->bindValue(":vlQddInicial", $this->getVlQddInical(), PDO::PARAM_STR);
            $result->bindValue(":vlSaldo", $this->getVlQddInical(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM fin_qdd_valor WHERE id_qdd_valor = :idQddValor");
            $result->bindValue(":idQddValor", $this->getIdQddValor(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function updateSuplementado($pdo) {
        try {

            $result = $pdo->prepare("UPDATE fin_qdd_valor SET vl_qdd_suplementado = :vlQddSuplementado "
                    . "WHERE id_qdd_valor = :idQddValor ");
            $result->bindValue(":idQddValor", $this->getIdQddValor(), PDO::PARAM_INT);
            $result->bindValue(":vlQddSuplementado", $this->getVlQddSuplementado(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function updateReduzidoBloqueado($pdo) {
        try {

            $result = $pdo->prepare("UPDATE fin_qdd_valor SET vl_qdd_reduzido = :vlQddReduzido"
                    . " , vl_bloqueado = :vlBloqueado "
                    . " WHERE id_qdd_valor = :idQddValor ");
            $result->bindValue(":idQddValor", $this->getIdQddValor(), PDO::PARAM_INT);
            $result->bindValue(":vlBloqueado", $this->getVlBloqueado(), PDO::PARAM_STR);
            $result->bindValue(":vlQddReduzido", $this->getVlQddReduzido(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function updateBloqueado($pdo) {
        try {

            $result = $pdo->prepare("UPDATE fin_qdd_valor SET vl_bloqueado = :vlBloqueado"
                    . " WHERE id_qdd_valor = :idQddValor ");
            $result->bindValue(":idQddValor", $this->getIdQddValor(), PDO::PARAM_INT);
            $result->bindValue(":vlBloqueado", $this->getVlBloqueado(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function atualizaSaldoIN(string $ids, $pdo) {
        try {

            $result = $pdo->prepare("UPDATE fin_qdd_valor"
                    . " SET vl_saldo = ((vl_qdd_inicial+vl_qdd_suplementado-vl_qdd_reduzido) - vl_empenhado - vl_bloqueado)"
                    . " WHERE id_qdd_valor IN ( " . $ids . ") ");
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retorna($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT * FROM fin_qdd_valor where id_qdd_valor = :idQddValor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQddValor", $this->getIdQddValor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function fonteQdd($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT font.id_fonte, font.nr_fonte
			 		FROM fin_qdd_valor as qdv
			 		INNER JOIN fin_fonte as font
			 		ON font.id_fonte = qdv.id_fonte
			 		where font.st_ativo = '1'
			 		group by font.id_fonte";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function programaQddPorFonte($pdo = null, $ano = null) {
        try {
            if (!empty($pdo) && !empty($ano)) {
                $sql = "SELECT programa.id_programa_trabalho, programa.cd_programa_trabalho,
							programa.ds_programa_trabalho
							FROM fin_qdd_valor as qdv
							INNER JOIN fin_programa_trabalho as programa
							ON programa.id_programa_trabalho = qdv.id_programa_trabalho
							where programa.aa_programa_trabalho = :ano
							AND  programa.st_ativo = '1'
							AND  qdv.id_fonte = :fonte
							group by programa.id_programa_trabalho";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ano", $ano, PDO::PARAM_INT);
                $stmt->bindValue(":fonte", $this->getIdFonte(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaQddCompleto($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT QV.id_qdd_valor
                        , PT.id_programa_trabalho, PT.ds_programa_trabalho, PT.programa_trabalho
                        , DE.cd_despesa_elemento, DE.ds_despesa_elemento
                        , F.nr_fonte, F.id_fonte
                        , QV.vl_qdd_inicial, QV.vl_qdd_suplementado, QV.vl_qdd_reduzido, QV.vl_empenhado
                        , QV.vl_bloqueado, QV.vl_liberado, QV.vl_saldo
                        FROM fin_qdd_valor QV
                        INNER JOIN fin_fonte F ON F.id_fonte = QV.id_fonte
                        INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = QV.id_programa_trabalho
                        INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = QV.id_despesa_elemento
                        WHERE QV.id_qdd = :idQdd
                        ORDER BY F.nr_fonte, PT.programa_trabalho, DE.cd_despesa_elemento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function despesaQddPorFonteEPrograma($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select view_despesa.id_despesa_elemento, view_despesa.cd_despesa_elemento, view_despesa.ds_despesa_elemento
						from fin_qdd_valor as qdv
						inner join view_despesa_elemento as view_despesa
						on view_despesa .id_despesa_elemento = qdv.id_despesa_elemento
						where qdv.id_fonte = :fonte
						AND qdv.id_programa_trabalho = :programa";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fonte", $this->getIdFonte(), PDO::PARAM_INT);
                $stmt->bindValue(":programa", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaContratacao($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_tipo_solicitacao order by id_tipo_solicitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaDotacaoInicial($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT QV.id_qdd_valor
                        , PT.ds_programa_trabalho, PT.programa_trabalho, PT.cd_programa_trabalho
                        , DE.cd_despesa_elemento
                        , F.nr_fonte
                        , QV.vl_qdd_inicial
                        FROM fin_qdd_valor QV
                        INNER JOIN fin_fonte F ON F.id_fonte = QV.id_fonte
                        INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = QV.id_programa_trabalho
                        INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = QV.id_despesa_elemento
                        WHERE QV.id_qdd = :idQdd
                        ORDER BY PT.cd_programa_trabalho, F.nr_fonte, DE.cd_despesa_elemento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaPorQddFonteProgDespesa($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT QV.id_qdd_valor, QV.id_qdd, QV.id_fonte, QV.id_programa_trabalho"
                        . " , QV.id_despesa_elemento, QV.vl_qdd_inicial"
                        . " , QV.vl_qdd_suplementado, QV.vl_qdd_reduzido"
                        . " , QV.vl_empenhado, QV.vl_bloqueado"
                        . " , QV.vl_liberado, QV.vl_saldo"
                        . " , coalesce((QV.vl_qdd_inicial + QV.vl_qdd_suplementado - QV.vl_qdd_reduzido - QV.vl_bloqueado),0.0000) AS vl_atual"
                        . " , PT.cd_programa_trabalho, PT.ds_programa_trabalho"
                        . " , DE.cd_despesa_elemento"
                        . " , F.nr_fonte"
                        . " FROM fin_qdd_valor QV"
                        . " INNER JOIN fin_fonte F ON F.id_fonte = QV.id_fonte"
                        . " INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = QV.id_programa_trabalho"
                        . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = QV.id_despesa_elemento"
                        . " WHERE QV.id_qdd = :idQdd AND QV.id_fonte = :idFonte"
                        . " AND QV.id_programa_trabalho = :idProgramaTrabalho AND QV.id_despesa_elemento = :idDespesaElemento";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
                $stmt->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);
                $stmt->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
                $stmt->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function atualizaEmpenhoQdd(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_qdd_valor set vl_empenhado = :valor where id_qdd_valor = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":valor", $this->getVlEmpenhado(), PDO::PARAM_INT);
                $stmt->bindValue(":id", $this->getIdQddValor(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaProjetoAtividadeAnoQdd(PDO $pdo = null, int $ano = 0, $condicao = "") {
        try {
            if (!empty($pdo)) {
                $sql = "select DISTINCT ON (pt.id_programa_trabalho) pt.id_programa_trabalho, pt.cd_programa_trabalho,
                        pt.ds_programa_trabalho
                        from view_programa_trabalho as pt
                        inner join fin_qdd_valor as qddValor
                        on qddValor.id_programa_trabalho = pt.id_programa_trabalho
                        inner join fin_qdd as qdd
                        on qdd.id_qdd = qddValor.id_qdd
                        where qdd.aa_qdd = :ano " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ano", $ano, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function atualizaLiberadadoQdd(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_qdd_valor set vl_liberado = :valor where id_qdd_valor = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":valor", $this->getVlLiberado(), PDO::PARAM_STR);
                $stmt->bindValue(":id", $this->getIdQddValor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
}
