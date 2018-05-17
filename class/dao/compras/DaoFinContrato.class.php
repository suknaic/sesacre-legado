<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinContratoTb.class.php";

class DaoFinContrato extends FinContratoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * [sucesso e responsavel ]
     * @return [type]
     */
    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * [cadastrarAta é responsável por armazena a ATA no banco de dados]
     * @param  [type] $pdo [Conexão com o banco]
     * @return string      [ser tudo de certo retorna sucesso ser de algum erro retorna erro]
     */
    public function cadastrarAta($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "INSERT INTO fin_contrato (nr_contrato, id_processo, id_pessoa, ds_objeto,
                dt_ini_vigencia_contrato, dt_fim_vigencia_contrato, dt_assinatura, dt_publicacao,
                ds_obs_contrato, fl_carona, tp_contrato, id_orgao_gerenciador, id_tipo_gasto) VALUES (:numero, :processo, :idPessoa, :ds_objeto, :dt_ini, :dt_fim, 
                :dt_assinatura, :dt_publicacao, :ds_obs_contrato, :carona, :tipo, :orgao, :tipoGasto)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":processo", $this->getIdProcesso(), PDO::PARAM_INT);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_objeto", $this->getDsObjeto(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_ini", $this->getDtIniVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFimVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_assinatura", $this->getDtAssinatura(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_publicacao", $this->getDtPublicacao(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_obs_contrato", $this->getDsObsContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":carona", $this->getFlCarona(), PDO::PARAM_INT);
                $stmt->bindValue(":tipo", $this->getTpContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":orgao", $this->getIdOrgaoGerenciador(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    /**
     * [editarAta é responsável por armazena a ATA no banco de dados]
     * @param  [type] $pdo [Conexão com o banco]
     * @return string      [ser tudo de certo retorna sucesso ser de algum erro retorna erro]
     */
    public function editarAta($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "update fin_contrato set nr_contrato  = :numero, id_processo = :processo, id_pessoa = :idPessoa, ds_objeto = :ds_objeto, 
                        dt_ini_vigencia_contrato = :dt_ini, dt_fim_vigencia_contrato = :dt_fim, dt_assinatura = :dt_assinatura, 
                        dt_publicacao = :dt_publicacao, ds_obs_contrato = :ds_obs_contrato, id_tipo_gasto = :idTipoGasto
                        where  id_contrato  = :idContrato";
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(":numero", $this->getNrContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":processo", $this->getIdProcesso(), PDO::PARAM_INT);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_objeto", $this->getDsObjeto(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_ini", $this->getDtIniVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFimVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_assinatura", $this->getDtAssinatura(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_publicacao", $this->getDtPublicacao(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_obs_contrato", $this->getDsObsContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    /**
     * [cadastrarContrato é responsavel por armazena o contrato no banco de dados]
     * @param  [type] $pdo [Conexão com o banco]
     * @return string      [ser tudo de certo retorna sucesso ser de algum erro retorna erro]
     */
    public function insertContrato($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "INSERT INTO fin_contrato (nr_contrato,nr_prazo_entrega,id_processo,id_pessoa, "
                        . "ds_objeto,fl_servico_continuado,dt_ini_vigencia_contrato,dt_fim_vigencia_contrato,dt_assinatura, "
                        . "dt_publicacao,ds_obs_contrato, tp_contrato, id_contrato_alt, id_tipo_gasto) VALUES (:numero,:prazo,:processo,:idPessoa,:ds_objeto,:servico, "
                        . ":dt_ini,:dt_fim,:dt_assinatura,:dt_publicacao,:obs,:tp_contrato, :idContratoAlt, :tipoDeGasto)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":prazo", $this->getNrPrazoEntrega(), PDO::PARAM_INT);
                $stmt->bindValue(":processo", $this->getIdProcesso(), PDO::PARAM_INT);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_objeto", $this->getDsObjeto(), PDO::PARAM_STR);
                $stmt->bindValue(":servico", $this->getFlServicoContinuado(), PDO::PARAM_INT);
                $stmt->bindValue(":dt_ini", $this->getDtIniVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFimVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_assinatura", $this->getDtAssinatura(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_publicacao", $this->getDtPublicacao(), PDO::PARAM_STR);
                $stmt->bindValue(":obs", $this->getDsObsContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":tp_contrato", $this->getTpContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":idContratoAlt", $this->getIdContratoAlt(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoDeGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    /**
     * [cadastrarContratoVigencia responsável por cadastrar a vigência do contrato]
     * @param  [type] $pdo [Conexão com o banco]
     * @return string      [ser tudo de certo retorna sucesso ser de algum erro retorna erro]
     */
    public function cadastrarContratoVigencia($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "INSERT INTO fin_vigencia (id_contrato, vigencia_data_ini, vigencia_data_fim) values (:idContrato, :dataIni, :dataFim)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":dataIni", $this->getDtIniVigenciaContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":dataFim", $this->getDtFimVigenciaContrato(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    /**
     * [editarContrato editar o contrato]
     * @param [type] $pdo [Conexão com o banco]
     */
    public function editarContrato($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "update fin_contrato set nr_contrato  = :numero, id_processo = :processo, id_pessoa = :idPessoa, ds_objeto = :ds_objeto, 
                        dt_ini_vigencia_contrato = :dt_ini, dt_fim_vigencia_contrato = :dt_fim, dt_assinatura = :dt_assinatura, 
                        dt_publicacao = :dt_publicacao, ds_obs_contrato = :ds_obs_contrato, id_tipo_gasto = :idTipoGasto
                        where  id_contrato  = :idContrato";
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(":numero", $this->getNrContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":processo", $this->getIdProcesso(), PDO::PARAM_INT);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_objeto", $this->getDsObjeto(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_ini", $this->getDtIniVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFimVigenciaContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_assinatura", $this->getDtAssinatura(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_publicacao", $this->getDtPublicacao(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_obs_contrato", $this->getDsObsContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_STR);
                $stmt->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    /**
     * [retornaAtaCombo Retorna a ata mais todas as tabelas que tem relacionamentos com ela]
     * @param  [type] $pdo      [Conexão com o banco]
     * @param  string $condicao [Condições opcionais que pode ser passada para gera uma consulta mais detalhada]
     * @return [type]           [array com o dados encontrato]
     */
    public function retornaContratoCombo($pdo = null, $condicao = '') {
        if ($pdo != null) {
            try {
                $sql = "SELECT distinct f.id_fornecedor, cont.nr_contrato, obj.nm_objeto, plaTipoGasto.nm_tipo_gasto, modalidade.nm_modalidade, 
                        p.nm_pessoa, cont.id_contrato
                        FROM fin_contrato AS cont

                        INNER JOIN gco_processo as processo
                        on processo.id_processo = cont.id_processo

                        INNER JOIN gco_objeto as obj
                        on obj.id_objeto = processo.id_objeto
                        
                        INNER JOIN gco_modalidade as modalidade
                        on modalidade.id_modalidade = processo.id_modalidade

                        INNER JOIN fin_fornecedor as f
                        on f.id_contrato = cont.id_contrato

                        INNER JOIN ses_pessoa as p 
                        on p.id_pessoa = f.id_pessoa
                        
                        LEFT JOIN gco_processo_tipo_gasto as gtpg
                        on gtpg.id_tipo_gasto = cont.id_tipo_gasto
                        
                        LEFT JOIN pla_tipo_gasto as plaTipoGasto
                        on plaTipoGasto.id_tipo_gasto =  gtpg.id_tipo_gasto

                        WHERE f.sit_fornecedor = '1' AND cont.st_ativo = '1' " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    public function retornaCentraisContrato($pdo) {
        if ($pdo != null) {
            try {
                $sql = "select central.id_lotacao, l.nm_lotacao
                        from fin_cont_central as central
                        inner join ses_lotacao as l
                        on l.id_lotacao =  central.id_lotacao
                        where id_contrato = :idContrato ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->execute();
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    /**
     * [retornaProcessoCombo esse metodo foi criado só para teste depois tem que ser excluido]
     * @param  [type] $pdo [Conexão com o banco de dados]
     */
    public function retornaProcessoCombo($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "select distinct p.id_processo, p.cd_ada_cpr, p.cd_pregao, p.vl_total_est,
                p.vl_total_hom, TO_CHAR(p.dt_processo, 'DD/MM/YYYY') as data, 
                mod.nm_modalidade as modalidade, array_to_string(array_agg(DISTINCT tpGasto.nm_tipo_gasto), '; ') as tipo_gasto,
                obj.nm_objeto
                from gco_processo as p
                inner join gco_objeto as obj
                on obj.id_objeto = p.id_objeto
                inner join gco_modalidade as mod
                on mod.id_modalidade = p.id_modalidade
                left join gco_processo_tipo_gasto gptg
                on gptg.id_processo = p.id_processo
                left join pla_tipo_gasto as tpGasto
                on tpGasto.id_tipo_gasto = gptg.id_tipo_gasto
                where p.st_ativo = '1'
                group by p.id_processo, mod.id_modalidade, obj.id_objeto";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return $array = array();
            }
        }
    }

    public function retornaContratosBasicoVigentes($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "select cont.id_contrato, cont.nr_contrato, obj.nm_objeto 
                        from fin_contrato as cont
                        inner join fin_vigencia as fv
                        on fv.id_contrato = cont.id_contrato
                        inner join gco_processo as gco
                        on gco.id_processo = cont.id_processo
                        inner join gco_objeto as obj
                        on obj.id_objeto = gco.id_objeto
                        where to_char(fv.vigencia_data_fim, 'yyyy') >=  to_char(now(), 'yyyy')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    public function verificarContratoAta($pdo = null) {
        try {
            if ($pdo != null) {
                $sql = "select f.id_fornecedor
                        from fin_fornecedor as f
                        inner join  fin_contrato as cont 
                        on cont.id_contrato = f.id_contrato
                        where f.sit_fornecedor = '1 '
                        and cont.id_contrato_alt is not null 
                        and f.id_fornecedor = :fornecedor ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaIdContratoPorCentrais(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select id_contrato
                        from fin_cont_central 
                        where id_lotacao = :idLotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idLotacao", $this->getIdLotacaoCentral(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaDadosParaEdicao(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select f.id_pessoa, cont.nr_contrato, cont.dt_ini_vigencia_contrato, cont.dt_fim_vigencia_contrato, cont.dt_assinatura, 
                        cont.dt_publicacao, cont.ds_objeto, cont.ds_obs_contrato, cont.id_contrato, modalidade.nm_modalidade, obj.nm_objeto,
                        processo.cd_ada_cpr, processo.cd_pregao, tipoGasto.id_tipo_gasto, processo.id_processo, pessoa.nm_pessoa, cont.tp_contrato,
                        cont.nr_prazo_entrega
                        from fin_fornecedor as f
                        inner join fin_contrato as cont 
                        on cont.id_contrato = f.id_contrato
                        inner join gco_processo as processo
                        on processo.id_processo = cont.id_processo
                        inner join gco_modalidade as modalidade
                        on modalidade.id_modalidade = processo.id_modalidade
                        inner join gco_objeto as obj
                        on obj.id_objeto = processo.id_objeto
                        left join gco_processo_tipo_gasto as gptg
                        on gptg.id_tipo_gasto = cont.id_tipo_gasto
                        left join pla_tipo_gasto as tipoGasto
                        on tipoGasto.id_tipo_gasto  = gptg.id_tipo_gasto
                        inner join ses_pessoa as pessoa
                        on pessoa.id_pessoa = f.id_pessoa
                        where f.id_fornecedor = :idFornecedor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaContrato(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select * from fin_contrato where id_contrato = :idContrato";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
