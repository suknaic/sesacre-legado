<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinAtaTb.class.php";

class DaoFinAta extends FinAtaTb {

    private $sucesso = false;
    private $msgRetorno = null;

    public function __construct() {
        
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
                ds_obs_contrato, fl_carona) VALUES (:processo, :orgao, :numero, :ds_objeto, :dt_ini, 
                :dt_fim, :dt_assinatura, :dt_publicacao, :ds_obs_ata, :carona)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":processo", $this->getIdProcesso(), PDO::PARAM_INT);
                $stmt->bindValue(":orgao", $this->getOrgaoGerenciador(), PDO::PARAM_INT);
                $stmt->bindValue(":numero", $this->getNrAta(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_objeto", $this->getDsObjeto(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_ini", $this->getDtIniVigenciaAta(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFimVigenciaAta(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_assinatura", $this->getDtAssinatura(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_publicacao", $this->getDtPublicacao(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_obs_contrato", $this->getDsObsAta(), PDO::PARAM_STR);
                $stmt->bindValue(":carona", $this->getFlCarona(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (Error $e) {
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
    public function retornaAtaCombo($pdo = null, $condicao = ''): array {
        if ($pdo != null) {
            try {
                $sql = "SELECT ata.id_ata, ata.nr_ata, ds_resumo_objeto, l.nr_licitacao,m.ds_modalidade, pj.nm_fantasia "
                        . "FROM fin_ata AS ata "
                        . "INNER JOIN fin_licitacao AS l "
                        . "ON l.id_licitacao = ata.id_licitacao "
                        . "INNER JOIN fin_contrato_modalidade AS m "
                        . "ON m.id_contrato_modalidade = ata.id_contrato_modalidade "
                        . "INNER JOIN ses_pessoa_juridica AS pj "
                        . "ON pj.id_pessoa_juridica = ata.id_ata "
                        . "WHERE ata.st_ata = 1 " . $conficao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return 'Sucesso';
            } catch (Error $e) {
                return $array = array();
            }
        }
    }

    public function retornaAtaParaContrato($pdo = null, $condicao = '') {
        if ($pdo != null) {
            try {
//                $sql = "select DISTINCT(cont.id_contrato), cont.id_contrato, cont.nr_contrato as contrato_numero,
//                        obs.nm_objeto as resumo_objeto
//                        from fin_fornecedor as f
//                        inner join fin_contrato as cont
//                        on cont.id_contrato = f.id_contrato
//                        inner join gco_processo as gcon
//                        on gcon.id_processo = cont.id_processo
//                        inner join gco_objeto as obs
//                        on obs.id_objeto = gcon.id_objeto
//                        where (NOW()- interval '1 year') <= cont.dt_fim_vigencia_contrato
//                        and cont.tp_contrato = '1'
//                        group by cont.id_contrato, obs.nm_objeto " . $condicao;
                $sql = "select DISTINCT(cont.id_contrato), cont.id_contrato, cont.nr_contrato as contrato_numero,
                        obs.nm_objeto as resumo_objeto
                        from fin_fornecedor as f
                        inner join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato
                        inner join gco_processo as gcon
                        on gcon.id_processo = cont.id_processo
                        inner join gco_objeto as obs
                        on obs.id_objeto = gcon.id_objeto
                        where cont.tp_contrato = '1'
                        group by cont.id_contrato, obs.nm_objeto ". $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (Error $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

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
                inner join gco_processo_tipo_gasto gptg
                on gptg.id_processo = p.id_processo
                inner join pla_tipo_gasto as tpGasto
                on tpGasto.id_tipo_gasto = gptg.id_tipo_gasto
                group by p.id_processo, mod.id_modalidade, obj.id_objeto";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Error $e) {
                $this->sucesso = false;
            }
        }
    }

    public function retornaOrgaoGerenciador($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "select og.id_orgao_gerenciador, p.nm_pessoa
			from fin_orgao_gerenciador as og
			inner join ses_pessoa as p
			on p.id_pessoa = og.id_pessoa";
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

}
