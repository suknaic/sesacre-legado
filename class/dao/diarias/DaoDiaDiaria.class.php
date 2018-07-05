<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaDiaria.class.php";

class DaoDiaDiaria extends DiaDiaria {
    
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }


    public function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into dia_diaria "
                        . "(id_tipo, id_pessoa_proponente, id_funcao_proponente,id_lotacao_proponente,"
                        . " id_pessoa_proposto,id_funcao_proposto, id_lotacao_proposto,"
                        . " ds_servico_executado,ds_locais_executado, ds_obs, dt_criacao, "
                        . " id_pessoa_solicitante, id_pedido,id_diaria_pai,nr_protocolo, id_central_solicitante) "
                        . "values (:id_tipo, :id_pessoa_proponente, :id_funcao_proponente, :id_lotacao_proponente, "
                        . "        :id_pessoa_proposto, :id_funcao_proposto, :id_lotacao_proposto, "
                        . "        :ds_servico_executado, :ds_locais_executado, :ds_obs, :dt_criacao, "
                        . "         :id_pessoa_solicitante, :id_pedido, :id_diaria_pai,:nr_protocolo, :id_central_solicitante)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo", $this->getIdTipo(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa_proponente", $this->getIdPessoaProponente(), PDO::PARAM_INT);
                $stmt->bindValue(":id_funcao_proponente", $this->getIdFuncaoProponente(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao_proponente", $this->getIdLotacaoProponente(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa_proposto", $this->getIdPessoaProposto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_funcao_proposto", $this->getIdFuncaoProposto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao_proposto", $this->getIdLotacaoProposto(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_servico_executado", $this->getDsServicoExecutado(),PDO::PARAM_STR);
                $stmt->bindValue(":ds_locais_executado", $this->getDsLocaisExecutado(),PDO::PARAM_STR);
                $stmt->bindValue(":ds_obs", $this->getDsObs(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_criacao", $this->getDtCriacao(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa_solicitante", $this->getIdPessoaSolicitante(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria_pai", $this->getIdDiariaPai(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_protocolo", $this->getNrProtocolo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_central_solicitante", $this->getIdCentralSolicitante(), PDO::PARAM_INT);

           
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
                $sql = "update dia_diaria "
                        . "set "
                            . "id_tipo = :id_tipo , "
                            . "id_pessoa_proponente = :id_pessoa_proponente , "
                            . "id_funcao_proponente = :id_funcao_proponente , "
                            . "id_lotacao_proponente = :id_lotacao_proponente , "
                            . "id_pessoa_proposto = :id_pessoa_proposto , "
                            . "id_funcao_proposto = :id_funcao_proposto , "
                            . "id_lotacao_proposto = :id_lotacao_proposto , "
                            . "ds_servico_executado = :ds_servico_executado , "
                            . "ds_locais_executado = :ds_locais_executado , "
                            . "ds_obs = :ds_obs , "
                            . "dt_criacao = :dt_criacao , "
                            . "id_pessoa_solicitante = :id_pessoa_solicitante, "
//                            . "fl_retorno = :fl_retorno, "
                            . "id_pedido = :id_pedido, "
                            . "id_diaria_pai = :id_diaria_pai, "
                            . "nr_protocolo = :nr_protocolo, "
                            . "id_central_solicitante = :id_central_solicitante "
                        . " where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo", $this->getIdTipo(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa_proponente", $this->getIdPessoaProponente(), PDO::PARAM_INT);
                $stmt->bindValue(":id_funcao_proponente", $this->getIdFuncaoProponente(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao_proponente", $this->getIdLotacaoProponente(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa_proposto", $this->getIdPessoaProposto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_funcao_proposto", $this->getIdFuncaoProposto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao_proposto", $this->getIdLotacaoProposto(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_servico_executado", $this->getDsServicoExecutado(),PDO::PARAM_STR);
                $stmt->bindValue(":ds_locais_executado", $this->getDsLocaisExecutado(),PDO::PARAM_STR);
                $stmt->bindValue(":ds_obs", $this->getDsObs(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_criacao", $this->getDtCriacao(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa_solicitante", $this->getIdPessoaSolicitante(), PDO::PARAM_INT);
//                $stmt->bindValue(":fl_retorno", $this->getFlRetorno(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria_pai", $this->getIdDiariaPai(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_protocolo", $this->getNrProtocolo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":id_central_solicitante", $this->getIdCentralSolicitante(), PDO::PARAM_INT);
                
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
    
    public function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from dia_diaria where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                $this->sucesso = $stmt->execute();
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectDestinos(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_diaria_destino, 
                                id_diaria, 
                                id_cidade_inicio, 
                                dh_inicio, 
                                dh_fim, 
                                id_transporte, 
                                id_decreto, 
                                id_classe, 
                                fl_pernoite, 
                                qt_diaria_destino,
                                vl_diaria_destino 
                         from dia_diaria_destino destino
                         where destino.id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
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
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectAnexos(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select id_anexo, 
                                id_diaria, 
                                nm_anexo, 
                                nm_mime_type, 
                                aq_anexo
                         from dia_anexo anexo
                         where anexo.id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
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
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectHistorico(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select *
                         from dia_diaria_historico hst
                         where hst.id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
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
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function retornaDiaria(PDO $pdo = null) {
        try{
            if (!empty($pdo)) {
                $sql = "SELECT  diaria.id_tipo, 
                                diaria.id_diaria,
                                diaria.id_diaria_pai, 
                                diaria.id_pessoa_proponente,
                                diaria.id_lotacao_proponente, 
                                diaria.id_funcao_proponente, 
                                diaria.id_pessoa_proposto, 
                                diaria.id_lotacao_proposto, 
                                diaria.id_funcao_proposto,
                                diaria.ds_servico_executado, 
                                diaria.ds_locais_executado, 
                                diaria.ds_obs,
                                diaria.nr_protocolo,
                                diaria.id_pessoa_solicitante,
                                diaria.fl_retorno,
                                diaria.id_pedido,
                                diaria.id_diaria_pai,
                                diaria.id_relatorio,
                                diaria.st_estagio,
                                diaria.st_ativo,
                                coalesce(diaria.id_central_solicitante,0) as id_central_solicitante,
                                coalesce(ps.nm_pessoa,'') as nm_solicitante,
                                To_char(diaria.dt_criacao, 'dd/mm/yyyy')         AS dt_criacao, 
                                destino.id_cidade_inicio, 
                                cid_ini.nm_cidade 
                                || ' - ' 
                                || est_ini.nm_sigla                              AS origem, 
                                cid_fim.nm_cidade 
                                || ' - ' 
                                || est_fim.nm_sigla                              AS destino, 
                                destino.id_cidade_fim, 
                                To_char(destino.dh_inicio, 'dd/mm/yyyy hh24:mi') AS dh_inicio, 
                                To_char(destino.dh_fim, 'dd/mm/yyyy hh24:mi')    AS dh_fim, 
                                destino.id_diaria_destino,
                                destino.id_transporte, 
                                destino.fl_pernoite, 
                                destino.id_decreto, 
                                destino.id_classe, 
                                destino.qt_diaria_destino, 
                                destino.vl_diaria_destino 
                         FROM   dia_diaria diaria
                                left join ses_pessoa ps
                                       ON ps.id_pessoa = diaria.id_pessoa_solicitante,
                                dia_diaria_destino destino 
                                left join ses_cidade cid_ini 
                                       ON cid_ini.id_cidade = destino.id_cidade_inicio 
                                join ses_estado est_ini 
                                  ON est_ini.id_estado = cid_ini.id_estado 
                                left join ses_cidade cid_fim 
                                       ON cid_fim.id_cidade = destino.id_cidade_fim 
                                join ses_estado est_fim 
                                  ON est_fim.id_estado = cid_fim.id_estado 
                         WHERE  diaria.id_diaria = destino.id_diaria 
                            AND diaria.id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                
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
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function infoDiariaPedido(PDO $pdo = null) {
        try{
            if (!empty($pdo)) {
                $sql = "SELECT  diaria.id_tipo, 
                                diaria.id_diaria,
                                diaria.id_diaria_pai, 
                                diaria.id_pessoa_proponente,
                                diaria.id_lotacao_proponente, 
                                diaria.id_funcao_proponente,
                                diaria.nr_protocolo,
                                dt.nm_tipo,
                                (
                                    select
                                       nm_pessoa 
                                    from
                                       ses_pessoa proponente 
                                    where
                                       proponente.id_pessoa = diaria.id_pessoa_proponente
                                 )
                                 as nm_proponente,
                                 (
                                    select
                                       nm_lotacao 
                                    from
                                       ses_lotacao lt_proponente 
                                    where
                                       lt_proponente.id_lotacao = diaria.id_lotacao_proponente
                                 )
                                 as lt_proponente,
                                 (
                                    select
                                       nm_funcao 
                                    from
                                       ses_funcao fn_proponente 
                                    where
                                       fn_proponente.id_funcao = diaria.id_funcao_proponente
                                 )
                                 as fn_proponente,
                                diaria.id_pessoa_proposto, 
                                diaria.id_lotacao_proposto, 
                                diaria.id_funcao_proposto,
                                (
                                    select
                                       nm_pessoa 
                                    from
                                       ses_pessoa proposto 
                                    where
                                       proposto.id_pessoa = diaria.id_pessoa_proposto
                                 )
                                 as nm_proposto,
                                 (
                                    select
                                       nm_lotacao 
                                    from
                                       ses_lotacao lt_proposto 
                                    where
                                       lt_proposto.id_lotacao = diaria.id_lotacao_proposto
                                 )
                                 as lt_proposto,
                                 (
                                    select
                                       nm_funcao 
                                    from
                                       ses_funcao fn_proposto 
                                    where
                                       fn_proposto.id_funcao = diaria.id_funcao_proposto
                                 )
                                as fn_proposto,
                                 cs.nm_lotacao as central_demanda,
                                 ps.nm_pessoa as nm_solicitante,
                                diaria.ds_servico_executado, 
                                diaria.ds_locais_executado, 
                                diaria.ds_obs, 
                                diaria.id_pessoa_solicitante,
                                diaria.fl_retorno,
                                diaria.id_pedido,
                                diaria.id_diaria_pai,
                                diaria.id_relatorio,
                                diaria.st_estagio,
                                diaria.st_ativo,
                                To_char(diaria.dt_criacao, 'dd/mm/yyyy')         AS dt_criacao, 
                                destino.id_cidade_inicio, 
                                cid_ini.nm_cidade 
                                || ' - ' 
                                || est_ini.nm_sigla                              AS origem, 
                                cid_fim.nm_cidade 
                                || ' - ' 
                                || est_fim.nm_sigla                              AS destino, 
                                destino.id_cidade_fim, 
                                To_char(destino.dh_inicio, 'dd/mm/yyyy hh24:mi') AS dh_inicio, 
                                To_char(destino.dh_fim, 'dd/mm/yyyy hh24:mi')    AS dh_fim, 
                                destino.id_diaria_destino,
                                destino.id_transporte, 
                                destino.fl_pernoite, 
                                destino.id_decreto, 
                                destino.id_classe, 
                                destino.qt_diaria_destino, 
                                destino.vl_diaria_destino,
                                trim(to_char(destino.qt_diaria_destino * destino.vl_diaria_destino , '999G999G999D99')) as vl_total 
                         FROM   dia_diaria diaria
                                left join ses_pessoa ps 
				       ON ps.id_pessoa = diaria.id_pessoa_solicitante
			        left join ses_lotacao cs
			               ON cs.id_lotacao = diaria.id_central_solicitante
                                join dia_tipo dt 
				       ON dt.id_tipo = diaria.id_tipo, 
                                dia_diaria_destino destino 
                                left join ses_cidade cid_ini 
                                       ON cid_ini.id_cidade = destino.id_cidade_inicio 
                                join ses_estado est_ini 
                                  ON est_ini.id_estado = cid_ini.id_estado 
                                left join ses_cidade cid_fim 
                                       ON cid_fim.id_cidade = destino.id_cidade_fim 
                                join ses_estado est_fim 
                                  ON est_fim.id_estado = cid_fim.id_estado 
                         WHERE  diaria.id_diaria = destino.id_diaria 
                            AND diaria.id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                
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
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function dadosProposto(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "SELECT proposto.nm_pessoa     AS nm_proposto, 
                            fn_proposto.nm_funcao  AS nm_funcao_proposto, 
                            lt_proposto.nm_lotacao AS nm_lotacao_proposto 
                     FROM   dia_diaria diaria 
                            INNER JOIN ses_pessoa proposto 
                                    ON proposto.id_pessoa = diaria.id_pessoa_proposto 
                            INNER JOIN ses_funcao fn_proposto 
                                    ON fn_proposto.id_funcao = diaria.id_funcao_proposto 
                            INNER JOIN ses_lotacao lt_proposto 
                                    ON lt_proposto.id_lotacao = diaria.id_lotacao_proposto " . $this->montaFiltro() ;
                $stmt = $pdo->prepare($sql);

                if (!empty($this->getIdDiaria())) {
                    $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                }
                if (!empty($this->getIdRelatorio())) {
                    $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
                }
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
            
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function listaDiariasAutorizacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT di.id_diaria, 
                                proponente.nm_pessoa                               AS nm_proponente, 
                                proposto.nm_pessoa                                 AS nm_proposto, 
                                lt_proposto.nm_lotacao                             AS lt_proposto,
                                di.nr_protocolo,
                                di.st_estagio,
                                di.id_pedido,
                                sl.nm_lotacao AS demanda_central,
                                (select to_char(dt_pedido,'YYYY') from fin_pedido fp where fp.id_pedido = di.id_pedido) ano_pedido,
                                String_agg(pais_ini.nm_pais 
                                           || '(' 
                                           || est_ini. nm_sigla 
                                           || ')' 
                                           || ci.nm_cidade 
                                           || ' a ' 
                                           || pais_fim.nm_pais 
                                           || '(' 
                                           || est_fim.nm_sigla 
                                           || ')' 
                                           || cf.nm_cidade 
                                           || ' / ' 
                                           || Trim(To_char(dd.qt_diaria_destino, '999G999G999D99')) 
                                           || ' X ' 
                                           || 'R$ ' 
                                           || Trim(To_char(dd.vl_diaria_destino, '999G999G999D99')) 
                                           || ' = R$ ' 
                                           || ( Trim(To_char(dd.qt_diaria_destino * dd.vl_diaria_destino, 
                                                     '999G999G999D99')) ), '<hr>') AS destino 
                         FROM   dia_diaria di 
                                INNER JOIN dia_diaria_destino dd 
                                        ON dd.id_diaria = di.id_diaria 
                                INNER JOIN ses_cidade ci 
                                        ON ci.id_cidade = dd.id_cidade_inicio 
                                INNER JOIN ses_cidade cf 
                                        ON cf.id_cidade = dd.id_cidade_fim 
                                INNER JOIN ses_pessoa proposto 
                                        ON proposto.id_pessoa = di.id_pessoa_proposto 
                                INNER JOIN ses_lotacao lt_proposto 
                                        ON lt_proposto.id_lotacao = di.id_lotacao_proposto 
                                INNER JOIN ses_pessoa proponente 
                                        ON proponente.id_pessoa = di.id_pessoa_proponente 
                                INNER JOIN ses_estado est_ini 
                                        ON est_ini.id_estado = ci.id_estado 
                                INNER JOIN ses_estado est_fim 
                                        ON est_fim.id_estado = cf.id_estado 
                                INNER JOIN ses_pais pais_ini 
                                        ON pais_ini.id_pais = est_ini.id_pais 
                                INNER JOIN ses_pais pais_fim 
                                        ON pais_fim.id_pais = est_fim.id_pais
                                LEFT JOIN ses_lotacao sl
                                        ON sl.id_lotacao = di.id_central_solicitante
                                WHERE (di.st_estagio = :st_estagio or '9' = :st_estagio)
                         GROUP  BY di.id_diaria, 
                                   proponente.nm_pessoa, 
                                   proposto.nm_pessoa, 
                                   lt_proposto.nm_lotacao,
                                   di.nr_protocolo,
                                    di.st_estagio,
                                    di.id_pedido,
                                    sl.nm_lotacao
                         ORDER BY di.id_diaria desc";
                        
                $stmt = $pdo->prepare($sql);
               
                $stmt->bindValue(':st_estagio', $this->getStEstagio(),PDO::PARAM_STR);

                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function listaTodasDiarias(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "SELECT di.id_diaria, 
                                proponente.nm_pessoa                               AS nm_proponente, 
                                proposto.nm_pessoa                                 AS nm_proposto, 
                                lt_proposto.nm_lotacao                             AS lt_proposto,
                                di.st_estagio,
                                di.id_pedido,
                                di.nr_protocolo,
                                cd.nm_lotacao AS central_demanda,
                                (select to_char(dt_pedido,'YYYY') from fin_pedido fp where fp.id_pedido = di.id_pedido) ano_pedido,
                                String_agg(pais_ini.nm_pais 
                                           || '(' 
                                           || est_ini. nm_sigla 
                                           || ')' 
                                           || ci.nm_cidade 
                                           || ' a ' 
                                           || pais_fim.nm_pais 
                                           || '(' 
                                           || est_fim.nm_sigla 
                                           || ')' 
                                           || cf.nm_cidade 
                                           || ' / ' 
                                           || Trim(To_char(dd.qt_diaria_destino, '999G999G990D99')) 
                                           || ' X ' 
                                           || 'R$ ' 
                                           || Trim(To_char(dd.vl_diaria_destino, '999G999G990D99')) 
                                           || ' = R$ ' 
                                           || ( Trim(To_char(dd.qt_diaria_destino * dd.vl_diaria_destino, 
                                                     '999G999G999D99')) ), '<hr>') AS destino 
                         FROM   dia_diaria di 
                                INNER JOIN dia_diaria_destino dd 
                                        ON dd.id_diaria = di.id_diaria 
                                INNER JOIN ses_cidade ci 
                                        ON ci.id_cidade = dd.id_cidade_inicio 
                                INNER JOIN ses_cidade cf 
                                        ON cf.id_cidade = dd.id_cidade_fim 
                                INNER JOIN ses_pessoa proposto 
                                        ON proposto.id_pessoa = di.id_pessoa_proposto 
                                INNER JOIN ses_lotacao lt_proposto 
                                        ON lt_proposto.id_lotacao = di.id_lotacao_proposto 
                                INNER JOIN ses_pessoa proponente 
                                        ON proponente.id_pessoa = di.id_pessoa_proponente 
                                INNER JOIN ses_estado est_ini 
                                        ON est_ini.id_estado = ci.id_estado 
                                INNER JOIN ses_estado est_fim 
                                        ON est_fim.id_estado = cf.id_estado 
                                INNER JOIN ses_pais pais_ini 
                                        ON pais_ini.id_pais = est_ini.id_pais 
                                INNER JOIN ses_pais pais_fim 
                                        ON pais_fim.id_pais = est_fim.id_pais
                                LEFT JOIN ses_lotacao cd
					ON cd.id_lotacao = di.id_central_solicitante
                         GROUP  BY di.id_diaria, 
                                   proponente.nm_pessoa, 
                                   proposto.nm_pessoa, 
                                   lt_proposto.nm_lotacao,
                                   di.nr_protocolo,
                                   cd.nm_lotacao
                         ORDER BY di.id_diaria desc";
                        
                $stmt = $pdo->prepare($sql);
               

                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function listaDiarias(PDO $pdo = null,int $usuario = 0, string $centrais = "") {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT di.id_diaria, 
                                proponente.nm_pessoa                               AS nm_proponente, 
                                proposto.nm_pessoa                                 AS nm_proposto, 
                                lt_proposto.nm_lotacao                             AS lt_proposto, 
                                di.st_estagio, 
                                di.id_pedido, 
                                di.nr_protocolo,
                                cr.id_lotacao,
                                cd.nm_lotacao AS central_demanda, 
                                (SELECT To_char(dt_pedido, 'YYYY') 
                                 FROM   fin_pedido fp 
                                 WHERE  fp.id_pedido = di.id_pedido)               ano_pedido, 
                                String_agg(pais_ini.nm_pais 
                                           || '(' 
                                           || est_ini. nm_sigla 
                                           || ')' 
                                           || ci.nm_cidade 
                                           || ' a ' 
                                           || pais_fim.nm_pais 
                                           || '(' 
                                           || est_fim.nm_sigla 
                                           || ')' 
                                           || cf.nm_cidade 
                                           || ' / ' 
                                           || Trim(To_char(dd.qt_diaria_destino, '999G999G990D99')) 
                                           || ' X ' 
                                           || 'R$ ' 
                                           || Trim(To_char(dd.vl_diaria_destino, '999G999G990D99')) 
                                           || ' = R$ ' 
                                           || ( Trim(To_char(dd.qt_diaria_destino * dd.vl_diaria_destino, 
                                                     '999G999G999D99')) ), '<hr>') AS destino 
                         FROM   dia_diaria di 
                                INNER JOIN dia_diaria_destino dd 
                                        ON dd.id_diaria = di.id_diaria 
                                INNER JOIN ses_cidade ci 
                                        ON ci.id_cidade = dd.id_cidade_inicio 
                                INNER JOIN ses_cidade cf 
                                        ON cf.id_cidade = dd.id_cidade_fim 
                                INNER JOIN ses_pessoa proposto 
                                        ON proposto.id_pessoa = di.id_pessoa_proposto 
                                INNER JOIN ses_lotacao lt_proposto 
                                        ON lt_proposto.id_lotacao = di.id_lotacao_proposto 
                                INNER JOIN ses_pessoa proponente 
                                        ON proponente.id_pessoa = di.id_pessoa_proponente 
                                INNER JOIN ses_estado est_ini 
                                        ON est_ini.id_estado = ci.id_estado 
                                INNER JOIN ses_estado est_fim 
                                        ON est_fim.id_estado = cf.id_estado 
                                INNER JOIN ses_pais pais_ini 
                                        ON pais_ini.id_pais = est_ini.id_pais 
                                INNER JOIN ses_pais pais_fim 
                                        ON pais_fim.id_pais = est_fim.id_pais
                                LEFT JOIN ses_lotacao cd
					ON cd.id_lotacao = di.id_central_solicitante
                                LEFT JOIN fin_central_responsavel cr 
                                       ON cr.id_lotacao = di.id_central_solicitante 
                                          AND cr.id_tipo_administracao = 3 
                                          AND cr.id_pessoa = :usuario 
                         WHERE  ( di.id_pessoa_proposto = :usuario 
                                   OR di.id_pessoa_proponente = :usuario 
                                   OR cr.id_lotacao in (".$centrais.") ) 
                         GROUP  BY di.id_diaria, 
                                   proponente.nm_pessoa, 
                                   proposto.nm_pessoa, 
                                   lt_proposto.nm_lotacao,
                                   di.nr_protocolo,
                                   cr.id_lotacao,
                                   cd.nm_lotacao
                         ORDER  BY di.id_diaria DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':usuario', $usuario,PDO::PARAM_INT);
//                $stmt->bindValue(':central', $centrais,PDO::PARAM_STR);

                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function selectDiariaImpressao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            pf_proposto.nr_cpf as proposto_cpf,
                            cnt_proposto.nr_matricula as proposto_matricula,
                            diaria.id_tipo,
                            diaria.nr_protocolo,
                            diaria.ds_locais_executado,
                            diaria.ds_servico_executado,
                            diaria.ds_obs,
                            to_char(diaria.dt_criacao,'dd/mm/yyyy') as dt_criacao,
                            (
                               select
                                  nm_pessoa 
                               from
                                  ses_pessoa proposto 
                               where
                                  proposto.id_pessoa = diaria.id_pessoa_proposto
                            )
                            as nm_proposto,
                            (
                               select
                                  nm_lotacao 
                               from
                                  ses_lotacao lt_proposto 
                               where
                                  lt_proposto.id_lotacao = diaria.id_lotacao_proposto
                            )
                            as lt_proposto,
                            (
                               select
                                  nm_funcao 
                               from
                                  ses_funcao fn_proposto 
                               where
                                  fn_proposto.id_funcao = diaria.id_funcao_proposto
                            )
                            as fn_proposto,
                            (
                               select
                                  nm_pessoa 
                               from
                                  ses_pessoa proponente 
                               where
                                  proponente.id_pessoa = diaria.id_pessoa_proponente
                            )
                            as nm_proponente,
                            (
                               select
                                  nm_lotacao 
                               from
                                  ses_lotacao lt_proponente 
                               where
                                  lt_proponente.id_lotacao = diaria.id_lotacao_proponente
                            )
                            as lt_proponente,
                            (
                               select
                                  nm_funcao 
                               from
                                  ses_funcao fn_proponente 
                               where
                                  fn_proponente.id_funcao = diaria.id_funcao_proponente
                            )
                            as fn_proponente 
                         from
                            dia_diaria diaria 
                            left join
                               ses_pessoa_fisica pf_proposto 
                               on pf_proposto.id_pessoa = diaria.id_pessoa_proposto 
                            left join
                               ses_contrato cnt_proposto 
                               on cnt_proposto.id_pessoa_fisica = pf_proposto.id_pessoa_fisica
                            where diaria.id_diaria = :id_diaria";
                
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                 
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    
    public function select(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select id_diaria, 
                                id_tipo, 
                                id_pessoa_proponente,
                                (select nm_pessoa from ses_pessoa where id_pessoa = id_pessoa_proponente) as nm_proponente, 
                                id_funcao_proponente,
                                id_lotacao_proponente,
                                id_pessoa_proposto,
                                (select nm_pessoa from ses_pessoa where id_pessoa = id_pessoa_proposto) as nm_proposto, 
                                id_funcao_proposto,
                                id_lotacao_proposto,
                                ds_servico_executado,
                                ds_locais_executado,
                                ds_obs,
                                to_char(dt_criacao,'dd/mm/yyyy') as dt_criacao,
                                dh_diaria,
                                id_pessoa_solicitante,
                                fl_retorno,
                                id_pedido,
                                id_diaria_pai,
                                id_relatorio,
                                st_estagio,
                                st_ativo
                        from dia_diaria diaria " . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdDiaria())) {
                    $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                }
                if (!empty($this->getIdRelatorio())) {
                    $stmt->bindValue(":id_relatorio", $this->getIdRelatorio(), PDO::PARAM_INT);
                }
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function selectDiariaPedidoOption(PDO $pdo = null){ 
        try {
            if (!empty($pdo)) {
                $sql = "SELECT id_diaria, 
                                id_tipo, 
                                id_pessoa_proponente,
                                (select nm_pessoa from ses_pessoa where id_pessoa = id_pessoa_proponente) as nm_proponente, 
                                id_funcao_proponente,
                                id_lotacao_proponente,
                                id_pessoa_proposto,
                                (select nm_pessoa from ses_pessoa where id_pessoa = id_pessoa_proposto) as nm_proposto, 
                                id_funcao_proposto,
                                id_lotacao_proposto,
                                ds_servico_executado,
                                ds_locais_executado,
                                ds_obs,
                                to_char(dt_criacao,'dd/mm/yyyy') as dt_criacao,
                                dh_diaria,
                                id_pessoa_solicitante,
                                fl_retorno,
                                id_pedido,
                                id_diaria_pai,
                                id_relatorio,
                                st_estagio,
                                st_ativo,
                                (select trim(to_char(sum(qt_diaria_destino * vl_diaria_destino),'999G999G999D99')) from dia_diaria_destino dd where dd.id_diaria = diaria.id_diaria ) as vl_total,
                                (select trim(to_char(round(sum(qt_diaria_destino * vl_diaria_destino),2),'999G999G999D9999')) from dia_diaria_destino dd where dd.id_diaria = diaria.id_diaria ) as vl_total_sm
                         FROM dia_diaria diaria
                         WHERE id_central_solicitante = :id_central_solicitante
                         AND st_estagio in (4,6) and id_pedido is null"; //Somente as diárias deferidas
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_central_solicitante", $this->getIdCentralSolicitante(), PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function centraisDiaria(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "SELECT DISTINCT l.id_lotacao,l.nm_lotacao
                        FROM fin_central_responsavel f,
                             ses_lotacao l
                        WHERE l.id_lotacao = f.id_lotacao
                          AND f.id_pessoa = :id_pessoa_solicitante
                          AND f.id_tipo_administracao = 3";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_pessoa_solicitante', $this->getIdPessoaSolicitante(),PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function verificaDiariasUsuario(PDO $pdo = null, int $usuario = 0){ //Verifica se o usuário está como proposto ou proponente de uma diária para poder visualizar
        try {
            if (!empty($pdo)) {
                $sql = "select
                            id_diaria,
                            id_pessoa_proposto,
                            id_pessoa_proponente,
                            id_central_solicitante 
                        from
                           dia_diaria d 
                        where
                           (
                              d.id_pessoa_proponente = :usuario 
                              or d.id_pessoa_proposto = :usuario 
                           )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':usuario', $usuario, PDO::PARAM_INT);
                
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) { 
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
                
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
             $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function selectLinha(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select * from dia_diaria where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_diaria', $this->getIdDiaria(),PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        }  catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function selectDiariaPedido(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from dia_diaria where id_pedido = :id_pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_pedido', $this->getIdPedido(), PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }  else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function updateDiariaRelatorio(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update dia_diaria set id_relatorio = :id_relatorio where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function desvinculaDiariaPedido(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "update dia_diaria set id_pedido = null, st_estagio = 6 where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function vinculaDiariaPedido(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "update dia_diaria set id_pedido = :id_pedido, st_estagio = 5 where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido",$this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function updateEstagio(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "update dia_diaria set st_estagio = :st_estagio where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":st_estagio", $this->getStEstagio(),PDO::PARAM_STR);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(),PDO::PARAM_INT);
                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    private function montaFiltro(){
        $filtro_sql = "";
        //diaria - DiaDiaria
        if (!empty($this->getIdDiaria())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " diaria.id_diaria = :id_diaria";
        }
        
        if (!empty($this->getIdRelatorio())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " diaria.id_relatorio = :id_relatorio";
        }

        return $filtro_sql;
    }
    
}

