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
                        . " id_pessoa_solicitante, id_pedido,id_diaria_pai) "
                        . "values (:id_tipo, :id_pessoa_proponente, :id_funcao_proponente, :id_lotacao_proponente, "
                        . "        :id_pessoa_proposto, :id_funcao_proposto, :id_lotacao_proposto, "
                        . "        :ds_servico_executado, :ds_locais_executado, :ds_obs, :dt_criacao, "
                        . "         :id_pessoa_solicitante, :id_pedido, :id_diaria_pai)";
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
                            . "fl_retorno = :fl_retorno, "
                            . "id_pedido = :id_pedido, "
                            . "id_diaria_pai = :id_diaria_pai, "
                            . "id_relatorio = :id_relatorio "
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
                $stmt->bindValue(":fl_retorno", $this->getFlRetorno(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria_pai", $this->getIdDiariaPai(), PDO::PARAM_INT);
                $stmt->bindValue(":id_relatorio", $this->getIdRelatorio(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                
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
                $stmt->execute();
                $this->sucesso = true;
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
                                destino.vl_diaria_destino 
                         FROM   dia_diaria diaria, 
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
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function listaDiarias(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT diaria.id_diaria,
                                diaria.id_relatorio,
                                proponente.nm_pessoa AS nm_proponente,
                                proposto.nm_pessoa AS nm_proposto,
                                lot.nm_lotacao AS nm_lotacao_proposto,
                                fun.nm_funcao AS nm_funcao_proposto,
                                cdi.descricao || ' até ' || cdf.descricao AS origem_destino,
                                destino.qt_diaria_destino,
                                destino.vl_diaria_destino, 
                                round(destino.qt_diaria_destino * destino.vl_diaria_destino,2) as valor
                         FROM dia_diaria diaria
                         LEFT JOIN dia_diaria_destino destino ON destino.id_diaria = diaria.id_diaria
                         LEFT JOIN
                           (SELECT cidade.id_cidade,
                                   pais.nm_pais || '(' || estado.nm_sigla || ')' || cidade.nm_cidade AS descricao
                            FROM ses_cidade cidade,
                                 ses_estado estado,
                                 ses_pais pais
                            WHERE cidade.id_estado = estado.id_estado
                              AND estado.id_pais = pais.id_pais) AS cdi ON cdi.id_cidade = destino.id_cidade_inicio
                         LEFT JOIN
                           (SELECT cidade.id_cidade,
                                   pais.nm_pais || '(' || estado.nm_sigla || ')' || cidade.nm_cidade AS descricao
                            FROM ses_cidade cidade,
                                 ses_estado estado,
                                 ses_pais pais
                            WHERE cidade.id_estado = estado.id_estado
                              AND estado.id_pais = pais.id_pais) AS cdf ON cdf.id_cidade = destino.id_cidade_fim
                         LEFT JOIN ses_pessoa proposto ON diaria.id_pessoa_proposto = proposto.id_pessoa
                         LEFT JOIN ses_contrato cnt ON cnt.id_pessoa_fisica = diaria.id_pessoa_proposto
                         LEFT JOIN ses_contrato_lotacao cl ON cl.id_contrato = cnt.id_contrato
                         LEFT JOIN ses_funcao fun ON fun.id_funcao = cl.id_funcao
                         LEFT JOIN ses_lotacao lot ON lot.id_lotacao = cl.id_lotacao
                         LEFT JOIN ses_pessoa proponente ON diaria.id_pessoa_proponente = proponente.id_pessoa" . $this->montaFiltro() . " order by diaria.id_diaria desc";
                        
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdDiaria())) {
                    $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                }
                if (!empty($this->getIdRelatorio())) {
                    $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
                }
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
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
                } 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function updateDiariaRelatorio(PDO $pdo = null) {
        $retorno = "";
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

