<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/liberacaoCentral/FinCentralLiberacaoTb.class.php";

class DaoFinCentralLiberacao extends FinCentralLiberacaoTb {

    private $sucesso = true;
    private $msgRetorno = null;

    public function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function salvaLiberacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_central_liberacao (id_pessoa, id_lotacao, id_tipo_gasto, tp_central_liberacao, ds_central_liberacao, st_central_liberacao)
                        values (:pessoa, :lotacao, :tipoGasto, :tipo, :dsCentral, :situacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->bindValue(":tipo", $this->getTpCentralLiberacao(), PDO::PARAM_INT);
                $stmt->bindValue(":dsCentral", $this->getDsCentralLiberacao(), PDO::PARAM_INT);
                $stmt->bindValue(":situacao", $this->getStCentralLiberacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    /**
     * 
     * @param int $idQdd
     * @param int $idProgramaTrabalho
     * @param int $idLotacao
     * @param int $idTipoGasto
     * @param int $idDespesaElemento
     * @param int $idFonte
     * @param PDO $pdo
     */
    public function retornaDadosLiberacao(int $idQdd, int $idProgramaTrabalho = null, int $idLotacao = null
    , int $idTipoGasto = null, int $idDespesaElemento = null
    , int $idFonte = null, PDO $pdo = null) {

        $filtro = "";
        $bindValue = array();
        $filter = array();
        if (!empty($idProgramaTrabalho)) {
            $filter[] = "qddv.id_programa_trabalho = :idProgramaTrabalho";
            $bindValue[] = array(":idProgramaTrabalho", $idProgramaTrabalho, PDO::PARAM_INT);
        }
        if (!empty($idLotacao)) {
            $filter[] = "cl.id_lotacao = :idLotacao";
            $bindValue[] = array(":idLotacao", $idLotacao, PDO::PARAM_INT);
        }
        if (!empty($idTipoGasto)) {
            $filter[] = "cl.id_tipo_gasto = :idTipoGasto";
            $bindValue[] = array(":idTipoGasto", $idTipoGasto, PDO::PARAM_INT);
        }
        if (!empty($idDespesaElemento)) {
            $filter[] = "qddv.id_despesa_elemento = :idDespesaElemento";
            $bindValue[] = array(":idDespesaElemento", $idDespesaElemento, PDO::PARAM_INT);
        }
        if (!empty($idFonte)) {
            $filter[] = "qddv.id_fonte = :idFonte";
            $bindValue[] = array(":idFonte", $idFonte, PDO::PARAM_INT);
        }

        if (count($filter) > 0) {
            $filtro = " and " . implode(' and ', $filter);
        }


        try {
            if (!empty($pdo)) {
                $sql = "select cl.id_central_liberacao, pt.cd_programa_trabalho
                        , pt.ds_programa_trabalho, l.nm_lotacao, tp.nm_tipo_gasto,
                        dl.cd_despesa_elemento, dl.ds_despesa_categoria, f.nr_fonte, ct.vl_central_liberacao_trans, 
                        cl.dh_central_liberacao as data,cl.ds_central_liberacao, p.nm_pessoa, cl.tp_central_liberacao,
                        cl.st_central_liberacao
                        from fin_central_liberacao as cl
                        inner join fin_central_liberacao_trans as ct
                            on ct.id_central_liberacao = cl.id_central_liberacao
                        inner join ses_lotacao as l 
                            on l.id_lotacao = cl.id_lotacao
                        inner join pla_tipo_gasto as tp
                            on tp.id_tipo_gasto = cl.id_tipo_gasto
                        inner join fin_qdd_valor as qddv
                            on qddv.id_qdd_valor = ct.id_qdd_valor 
                        inner join fin_fonte as f
                            on f.id_fonte = qddv.id_fonte
                        inner join view_despesa_elemento as dl
                            on dl.id_despesa_elemento = qddv.id_despesa_elemento
                        inner join view_programa_trabalho  as pt
                            on pt.id_programa_trabalho = qddv.id_programa_trabalho
                        inner join ses_pessoa as p
                            on p.id_pessoa = cl.id_pessoa    
                        where 
                            qddv.id_qdd = :idQdd
                            " . $filtro . "
                        ORDER BY cl.dh_central_liberacao DESC";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQdd", $idQdd, PDO::PARAM_INT);
                foreach ($bindValue as $key => $value) {
                    $stmt->bindValue($value[0], $value[1], $value[2]);
                }

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaDadosReducao(PDO $pdo = null, int $idQddValor) {
        try {
            if (!empty($pdo)) {
                $sql = "select cl.id_central_liberacao, pt.cd_programa_trabalho, pt.ds_programa_trabalho, l.nm_lotacao, tp.nm_tipo_gasto,
                        dl.cd_despesa_elemento, dl.ds_despesa_categoria, f.nr_fonte, ct.vl_central_liberacao_trans
                        from fin_central_liberacao as cl
                        inner join fin_central_liberacao_trans as ct
                        on ct.id_central_liberacao = cl.id_central_liberacao
                        inner join ses_lotacao as l 
                        on l.id_lotacao = cl.id_lotacao
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = cl.id_tipo_gasto
                        inner join fin_qdd_valor as qddv
                        on qddv.id_qdd_valor = ct.id_qdd_valor 
                        inner join fin_fonte as f
                        on f.id_fonte = qddv.id_fonte
                        inner join view_despesa_elemento as dl
                        on dl.id_despesa_elemento = qddv.id_despesa_elemento
                        inner join view_programa_trabalho  as pt
                        on pt.id_programa_trabalho = qddv.id_programa_trabalho
                        where ct.id_qdd_valor = :idQddValor 
                        AND cl.id_lotacao = :central 
                        AND tp.id_tipo_gasto = :tipoGasto
                        AND cl.tp_central_liberacao = '2'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQddValor", $idQddValor, PDO::PARAM_INT);
                $stmt->bindValue(":central", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaSaldoValorLiberado(PDO $pdo = null, int $idQddValor, array $dados, $condicao = '') {
        try {
            if (!empty($pdo)) {
                $sql = "select coalesce(sum(clt.vl_central_liberacao_trans),0.0000)
                        - 
                        (
                        select coalesce(sum(subclt.vl_central_liberacao_trans),0.0000) 
                        from  fin_central_liberacao as subCl
                        
                        inner join fin_central_liberacao_trans as subclt
                        on subCl.id_central_liberacao = subclt.id_central_liberacao 
                        
                        where subCl.st_central_liberacao = '1'
                        
                        and subclt.id_qdd_valor  = :idQddValor
                        
                        and subCl.id_lotacao = :central
                        
                        and subCl.id_tipo_gasto = :tipoGasto
                        
                        and subCl.tp_central_liberacao = '2'
                        ) 
                        -
                        (select coalesce(sum(p.vl_pedido),0.0000) from fin_pedido as p 
                        where p.st_pedido > '0'
                        and p.id_programa_trabalho = :projetoAtividade 
                        and p.id_fonte = :fonte
                        and p.id_tipo_gasto = :tipoGasto
                        and p.id_lotacao = :central
                        and p.id_despesa_elemento = :despesa " . $condicao . " )

                        as saldo  

                        from  fin_central_liberacao as cl
                        inner join fin_central_liberacao_trans as clt
                        on cl.id_central_liberacao = clt.id_central_liberacao 
                        where cl.st_central_liberacao = '2'
                        and clt.id_qdd_valor = :idQddValor
                        and cl.id_lotacao = :central
                        and cl.id_tipo_gasto = :tipoGasto
                        and cl.tp_central_liberacao = '1'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idQddValor", $idQddValor, PDO::PARAM_INT);
                $stmt->bindValue(":central", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->bindValue(":projetoAtividade", $dados["projeto"], PDO::PARAM_INT);
                $stmt->bindValue(":fonte", $dados["fonte"], PDO::PARAM_INT);
                $stmt->bindValue(":despesa", $dados["despesa"], PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaValorLiberado(PDO $pdo = null, int $idQddValor) {
        try {
            if (!empty($pdo)) {
                $sql = "select coalesce(sum(clt.vl_central_liberacao_trans),0.0000) as valor  
                        from  fin_central_liberacao as cl
                        inner join fin_central_liberacao_trans as clt
                        on cl.id_central_liberacao = clt.id_central_liberacao 
                        where cl.id_central_liberacao = :idLiberacao
                        and clt.id_qdd_valor = :idQddValor
                        and cl.id_lotacao = :central
                        and cl.id_tipo_gasto = :tipoGasto";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLiberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->bindValue(":idQddValor", $idQddValor, PDO::PARAM_INT);
                $stmt->bindValue(":central", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaPkLiberacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select cl.id_central_liberacao, cl.id_tipo_gasto, cl.id_lotacao, qddv.id_qdd_valor, qddv.id_programa_trabalho as projeto,
                        qddv.id_fonte as fonte, qddv.id_despesa_elemento as despesa, cl.tp_central_liberacao
                        from fin_central_liberacao as cl
                        inner join fin_central_liberacao_trans as ct
                        on ct.id_central_liberacao = cl.id_central_liberacao
                        inner join ses_lotacao as l 
                        on l.id_lotacao = cl.id_lotacao
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = cl.id_tipo_gasto
                        inner join fin_qdd_valor as qddv
                        on qddv.id_qdd_valor = ct.id_qdd_valor 
                        inner join fin_fonte as f
                        on f.id_fonte = qddv.id_fonte
                        inner join view_despesa_elemento as dl
                        on dl.id_despesa_elemento = qddv.id_despesa_elemento
                        inner join view_programa_trabalho  as pt
                        on pt.id_programa_trabalho = qddv.id_programa_trabalho
                        where cl.id_central_liberacao = :idLiberacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLiberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function deletaLiberacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_central_liberacao set st_central_liberacao = '2' where id_central_liberacao = :idLiberacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLiberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    /**
     * Esse metodo esta sendo usado para monta o tr das liberaçoes aguardando validaçao 
     * @param PDO $pdo
     */
    public function retornaLiberacaoParaValidacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select pro.cd_programa_trabalho, pro.ds_programa_trabalho, lotacao.nm_lotacao, tg.nm_tipo_gasto, 
                        desp.cd_despesa_elemento, desp.ds_despesa_elemento, font.nr_fonte, lib.dh_central_liberacao, 
                        lib.ds_central_liberacao, libTrans.vl_central_liberacao_trans, qddValor.id_qdd_valor,
                        libTrans.id_central_liberacao_trans, lib.id_central_liberacao 
                        from fin_central_liberacao as lib
                        inner join fin_central_liberacao_trans as libTrans
                        on lib.id_central_liberacao = libTrans.id_central_liberacao
                        inner join fin_qdd_valor as qddValor
                        on qddValor.id_qdd_valor = libTrans.id_qdd_valor
                        inner join fin_programa_trabalho as pro
                        on pro.id_programa_trabalho = qddValor.id_programa_trabalho
                        inner join ses_lotacao as lotacao
                        on lotacao.id_lotacao = lib.id_lotacao
                        inner join pla_tipo_gasto as tg
                        on tg.id_tipo_gasto  =  lib.id_tipo_gasto
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = qddValor.id_despesa_elemento
                        inner join fin_fonte as font
                        on font.id_fonte  = qddValor.id_fonte
                        where lib.st_central_liberacao = '1'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    /**
     * Retorna Dados da transaçao
     * @param PDO $pdo
     */
    public function retornaDadosTrans(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select libTrans.*
                        from fin_central_liberacao as lib
                        inner join fin_central_liberacao_trans as libTrans
                        on libTrans.id_central_liberacao = lib.id_central_liberacao
                        where lib.id_central_liberacao = :idLiberacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLiberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function desativaValorLiberado(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "UPDATE fin_central_liberacao SET st_central_liberacao = 0 where id_central_liberacao = :idLiberacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLiberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function validaLiberacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "UPDATE fin_central_liberacao SET st_central_liberacao = '2' where id_central_liberacao = :idLiberacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLiberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaLiberacaoPesquisa(PDO $pdo = null, $condicao = null) {
        try {
            if (!empty($pdo)) {
                
                $sql = "select pt.cd_programa_trabalho, pt.ds_programa_trabalho, l.nm_lotacao, desp.cd_despesa_elemento,
                        desp.ds_despesa_elemento, f.nr_fonte, tg.nm_tipo_gasto, qddv.id_fonte, qddv.id_programa_trabalho,
                        qddv.id_despesa_elemento, cl.id_tipo_gasto, l.id_lotacao, qddv.id_qdd_valor,
                        sum(clt.vl_central_liberacao_trans) 
                        -
                        coalesce((select sum(Sclt.vl_central_liberacao_trans) from fin_central_liberacao as Scl
                        inner join fin_central_liberacao_trans as Sclt
                        on Sclt.id_central_liberacao = Scl.id_central_liberacao
                        inner join fin_qdd_valor as Sqddv 
                        on Sqddv.id_qdd_valor = Sclt.id_qdd_valor
                        inner join pla_tipo_gasto as Stg
                        on Stg.id_tipo_gasto = Scl.id_tipo_gasto
                        inner join view_despesa_elemento as Sdesp
                        on Sdesp.id_despesa_elemento = Sqddv.id_despesa_elemento
                        inner join fin_fonte as Sf 
                        on Sf.id_fonte  = Sqddv.id_fonte
                        inner join view_programa_trabalho as Spt 
                        on Spt.id_programa_trabalho = Sqddv.id_programa_trabalho
                        inner join ses_lotacao as Sl
                        on Sl.id_lotacao = Scl.id_lotacao
                        where Scl.st_central_liberacao = '2' 
                        and Scl.tp_central_liberacao = '2'
                        and Sqddv.id_qdd_valor = qddv.id_qdd_valor
                        and Stg.id_tipo_gasto = cl.id_tipo_gasto
                        and Sdesp.id_despesa_elemento = qddv.id_despesa_elemento
                        and Sf.id_fonte = qddv.id_fonte
                        and Spt.id_programa_trabalho = qddv.id_programa_trabalho
                        and Sl.id_lotacao = l.id_lotacao
                        ),'0.0000')
                        as valor, 
                        coalesce((select sum(vl_pedido)
                         from fin_pedido as p
                         where p.st_pedido > '0'  
                         and p.id_fonte = qddv.id_fonte
                         and p.id_programa_trabalho  = qddv.id_programa_trabalho
                         and p.id_despesa_elemento = qddv.id_despesa_elemento
                         and p.id_tipo_gasto = cl.id_tipo_gasto
                         and p.id_lotacao =  l.id_lotacao
                        ),0.0000) as pedido,

                        (
                        sum(clt.vl_central_liberacao_trans) 
                        -
                        coalesce((select sum(Sclt.vl_central_liberacao_trans) from fin_central_liberacao as Scl
                        inner join fin_central_liberacao_trans as Sclt
                        on Sclt.id_central_liberacao = Scl.id_central_liberacao
                        inner join fin_qdd_valor as Sqddv 
                        on Sqddv.id_qdd_valor = Sclt.id_qdd_valor
                        inner join pla_tipo_gasto as Stg
                        on Stg.id_tipo_gasto = Scl.id_tipo_gasto
                        inner join view_despesa_elemento as Sdesp
                        on Sdesp.id_despesa_elemento = Sqddv.id_despesa_elemento
                        inner join fin_fonte as Sf 
                        on Sf.id_fonte  = Sqddv.id_fonte
                        inner join view_programa_trabalho as Spt 
                        on Spt.id_programa_trabalho = Sqddv.id_programa_trabalho
                        inner join ses_lotacao as Sl
                        on Sl.id_lotacao = Scl.id_lotacao
                        where Scl.st_central_liberacao = '2' 
                        and Scl.tp_central_liberacao = '2'
                        and Sqddv.id_qdd_valor = qddv.id_qdd_valor
                        and Stg.id_tipo_gasto = cl.id_tipo_gasto
                        and Sdesp.id_despesa_elemento = qddv.id_despesa_elemento
                        and Sf.id_fonte = qddv.id_fonte
                        and Spt.id_programa_trabalho = qddv.id_programa_trabalho
                        and Sl.id_lotacao = l.id_lotacao
                        ),'0.0000')
                        -
                        coalesce((select sum(vl_pedido)
                         from fin_pedido as p
                         where p.st_pedido > '0' 
                         and p.id_fonte = qddv.id_fonte
                         and p.id_programa_trabalho  = qddv.id_programa_trabalho
                         and p.id_despesa_elemento = qddv.id_despesa_elemento
                         and p.id_tipo_gasto = cl.id_tipo_gasto
                         and p.id_lotacao =  l.id_lotacao
                        ),0.0000)
                        ) as saldo
                        from fin_central_liberacao as cl
                        inner join fin_central_liberacao_trans as clt
                        on clt.id_central_liberacao = cl.id_central_liberacao 
                        inner join fin_qdd_valor as qddv 
                        on qddv.id_qdd_valor = clt.id_qdd_valor
                        inner join pla_tipo_gasto as tg
                        on tg.id_tipo_gasto = cl.id_tipo_gasto
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = qddv.id_despesa_elemento
                        inner join fin_fonte as f 
                        on f.id_fonte  = qddv.id_fonte
                        inner join view_programa_trabalho as pt 
                        on pt.id_programa_trabalho = qddv.id_programa_trabalho
                        inner join ses_lotacao as l
                        on l.id_lotacao = cl.id_lotacao
                        where cl.st_central_liberacao = '2' 
                        and cl.tp_central_liberacao = '1' ".$condicao."
                        group by pt.id_programa_trabalho, pt.cd_programa_trabalho, pt.ds_programa_trabalho, 
                        tg.id_tipo_gasto, l.nm_lotacao, l.id_lotacao, desp.ds_despesa_elemento, desp.cd_despesa_elemento,
                        f.nr_fonte, qddv.id_fonte, qddv.id_programa_trabalho, qddv.id_despesa_elemento, cl.id_tipo_gasto,
                        l.id_lotacao, qddv.id_qdd_valor
                        order by id_qdd_valor";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

}
