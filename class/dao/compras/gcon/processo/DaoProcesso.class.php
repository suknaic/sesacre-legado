<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/gcon/processo/processoExtd.class.php";

class DaoProcesso extends ProcessoExtd {

    //Método para cadastrar processo no BD   
    function cadastraProcesso($pdo) {
        try {

            $cadpro = $pdo->prepare("INSERT INTO gco_processo (cd_ada_cpr, cd_pregao, vl_total_est, vl_total_hom,"
                                                           . " dt_processo, id_objeto, id_modalidade)"
                                                           . " VALUES (:ada_process, :nume_pregao_process, :valor_estim_process, :val_homo_process,"
                                                           . " :data_process, :id_objeto, :id_modalidade)");

            $cadpro->bindValue(":ada_process", $this->getAda() === '' ? null : $this->getAda(), PDO::PARAM_STR);
            $cadpro->bindValue(":nume_pregao_process", $this->getNumePregao() === '' ? null : $this->getNumePregao(), PDO::PARAM_STR);
            $cadpro->bindValue(":valor_estim_process", $this->getValorEstimado() === '' ? null : $this->getValorEstimado(), PDO::PARAM_STR);
            $cadpro->bindValue(":val_homo_process", $this->getValorHomologado() === '' ? null : $this->getValorHomologado(), PDO::PARAM_STR);
            $cadpro->bindValue(":data_process", $this->getData() === '' ? null : $this->getData(), PDO::PARAM_STR);
            $cadpro->bindValue(":id_objeto", $this->getObjeto() === 0 ? null : $this->getObjeto(), PDO::PARAM_INT);
            $cadpro->bindValue(":id_modalidade", $this->getModalidade() === 0 ? NULL : $this->getModalidade(), PDO::PARAM_INT);
            $cadpro->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Método para cadastrar Anotação do processo
    function cadastraAnotacao($pdo) {
        try {
            $cadanota = $pdo->prepare("INSERT INTO gco_anotacao(ds_anotacao, id_processo, id_situacao, id_pessoa, id_usuario)
                                       VALUES(:anotacoes_process, :id_processo, :id_situacao, :id_tecnico, :id_usuario)");

            $cadanota->bindValue(":anotacoes_process", $this->getAnotacoes() === '' ? null : $this->getAnotacoes(), PDO::PARAM_STR);
            $cadanota->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $cadanota->bindValue(":id_situacao", $this->getSituacao(), PDO::PARAM_INT);
            $cadanota->bindValue(":id_usuario", $this->getUser(), PDO::PARAM_INT);
            $cadanota->bindValue(":id_tecnico", $this->getTecnico(), PDO::PARAM_INT);
            $cadanota->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function updateIdAnotacaoPro($pdo) {
        try {
            $upidanota = $pdo->prepare("UPDATE gco_processo SET id_anotacao =:id_anotacao WHERE id_processo =:id_processo");
            $upidanota->bindValue(":id_anotacao", $this->getId_anotacao(), PDO::PARAM_INT);
            $upidanota->bindValue(":id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $upidanota->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function cadastrarUnidadeContemplada($pdo) {
        try {
            $uniComt = $pdo->prepare("INSERT INTO gcon_unidade_contempladas(id_processo,nm_unidades_contempladas) VALUES (:id_processo, :unidade)");
            $uniComt->bindValue(":unidade", $this->getUni_cont_process() === '' ? null : $this->getUni_cont_process(), PDO::PARAM_STR);
            $uniComt->bindValue(":id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $uniComt->execute();
            return true;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //Método para listar processos cadastrados        
    function listarProcesso($pdo, $filtro, $anexo) {
        try {
            $list = $pdo->prepare("SELECT DISTINCT ON (PRO.id_processo) PRO.id_processo, PRO.nm_centrais, PRO.cd_ada_cpr, PRO.cd_pregao, 
                                            PRO.vl_total_est, PRO.vl_total_hom, PRO.dt_processo,
                                            UNI.nm_unidade_contempladas, array_to_string(array_agg(CID.nm_cidade), ', ') as nm_cidade, MOD.nm_modalidade, 
                                            OBJ.nm_objeto, SIT.nm_situacao, TPG.nm_tipo_gasto, PES.nm_pessoa 
                                            $anexo
                                    FROM gco_processo  PRO
                                            LEFT JOIN gco_objeto OBJ ON OBJ.id_objeto = PRO.id_objeto
                                            LEFT JOIN gco_modalidade MOD ON MOD.id_modalidade = PRO.id_modalidade
                                            LEFT JOIN gco_anexo ANE ON ANE.id_processo = PRO.id_processo
                                            LEFT JOIN gco_processo_unidade PU ON PU.id_processo = PRO.id_processo
                                            LEFT JOIN gco_unidade_contempladas UNI ON UNI.id_unidade_contempladas = PU.id_unidade_contempladas                                        
                                            LEFT JOIN gco_anotacao ANO ON ANO.id_processo = PRO.id_processo
                                            LEFT JOIN gco_situacao SIT ON SIT.id_situacao = (select DISTINCT ON (id_processo) id_situacao 
                                                                                                                                                from gco_anotacao where id_processo = PRO.id_processo order by id_processo, id_anotacao  desc)
                                            LEFT JOIN pla_tipo_gasto TPG ON TPG.id_tipo_gasto = PRO.id_tipo_gasto
                                            LEFT JOIN ses_pessoa PES ON PES.id_pessoa = ANO.id_pessoa       
                                            LEFT JOIN gco_area_abrangencia AREA on AREA.id_processo = PRO.id_processo
                                            LEFT JOIN ses_cidade CID ON CID.id_cidade = AREA.id_cidade  
                                    $filtro 
                                            GROUP by PRO.id_processo, OBJ.id_objeto, MOD.id_modalidade, UNI.id_unidade_contempladas, TPG.id_tipo_gasto, PES.id_pessoa, SIT.id_situacao, ANO.dh_anotacao, ANO,id_anotacao 
                                            ORDER BY PRO.id_processo, ANO.id_anotacao DESC");
            $list->execute();
            if ($list->rowCount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function listarProcessoJSON($pdo, $condicao, $anexo) {
        try {
            $list = $pdo->prepare(" SELECT DISTINCT ON (PRO.id_processo) PRO.id_processo, PRO.cd_ada_cpr, PRO.cd_pregao, PRO.vl_total_est, PRO.vl_total_hom, PRO.dt_processo, OBJ.nm_objeto,
                                        MOD.nm_modalidade, UNI.nm_unidade_contempladas, SIT.nm_situacao, CID.nm_cidade, TIG.nm_tipo_gasto, PE.nm_pessoa" . $anexo . "
                                    FROM gco_processo PRO
                                        INNER JOIN gco_objeto OBJ ON OBJ.id_objeto = PRO.id_objeto
                                        INNER JOIN gco_modalidade MOD ON MOD.id_modalidade = PRO.id_modalidade
                                        LEFT JOIN gco_anexo ANE ON ANE.id_processo = PRO.id_processo
                                        LEFT JOIN gco_anotacao ANO ON ANO.id_processo = PRO.id_processo
                                        LEFT JOIN gco_situacao SIT ON SIT.id_situacao = ANO.id_situacao
                                        LEFT JOIN gco_processo_unidade PU ON PU.id_processo = PRO.id_processo
                                        LEFT JOIN gco_area_abrangencia ARE ON ARE.id_processo = PRO.id_processo
                                        LEFT JOIN ses_cidade CID ON CID.id_cidade = ARE.id_cidade
                                        LEFT JOIN pla_tipo_gasto TIG ON TIG.id_tipo_gasto = PRO.id_tipo_gasto
                                        LEFT JOIN ses_pessoa PE ON PE.id_pessoa = ANO.id_pessoa
                                        LEFT JOIN gco_unidade_contempladas UNI ON UNI.id_unidade_contempladas = PU.id_unidade_contempladas
                                   GROUP by PRO.id_processo, OBJ.id_objeto, MOD.id_modalidade, UNI.id_unidade_contempladas,
                                        SIT.id_situacao, CID.id_cidade, TIG.id_tipo_gasto, PE.id_pessoa, ANO.id_anotacao 
                                   ORDER BY PRO.id_processo, ANO.id_anotacao desc");
            $list->execute();
            if ($list->rowCount() >= 0) {
                return $list->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return "Processo não encontrado!";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornarProcesso($pdo) {
        try {
            $veri = $pdo->prepare("SELECT PRO.id_processo, PRO.cd_ada_cpr, PRO.cd_pregao, PRO.vl_total_est, PRO.vl_total_hom, PRO.dt_processo, OBJ.id_objeto,
                                        MOD.id_modalidade, UNI.id_unidade_contempladas, SIT.id_situacao, array_to_string(array_agg(CID.id_cidade), ', ') as id_cidade, PE.id_pessoa, ANO.id_anotacao
                                    FROM gco_processo PRO
                                    LEFT JOIN gco_objeto OBJ ON OBJ.id_objeto = PRO.id_objeto
                                    LEFT JOIN gco_modalidade MOD ON MOD.id_modalidade = PRO.id_modalidade
                                    LEFT JOIN gco_anotacao ANO ON ANO.id_processo = PRO.id_processo
                                    LEFT JOIN gco_situacao SIT ON SIT.id_situacao = ANO.id_situacao
                                    LEFT JOIN gco_processo_unidade PU ON PU.id_processo = PRO.id_processo
                                    LEFT JOIN gco_area_abrangencia ARE ON ARE.id_processo = PRO.id_processo
                                    LEFT JOIN ses_cidade CID ON CID.id_cidade = ARE.id_cidade
                                    LEFT JOIN ses_pessoa PE ON PE.id_pessoa = ANO.id_pessoa
                                    LEFT JOIN gco_unidade_contempladas UNI ON UNI.id_unidade_contempladas = PU.id_unidade_contempladas
                                    WHERE PRO.id_processo = :id_processo AND PRO.st_ativo='1'
                                    GROUP by PRO.id_processo, OBJ.id_objeto, MOD.id_modalidade, UNI.id_unidade_contempladas, PE.id_pessoa, SIT.id_situacao, ANO.dh_anotacao, ANO,id_anotacao 
                                    ORDER BY ANO.id_anotacao DESC");
            $veri->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $veri->execute();

            if ($veri->rowCount() > 0) {
                return $veri->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Método para verificar se processo já existe  
    function verificaProcesso($pdo) {
        try {
            $ret = $pdo->prepare("SELECT id_processo, cd_ada_cpr, st_ativo
                                    FROM gco_processo 
                                  WHERE cd_ada_cpr=:ada");

            $ret->bindValue(":ada", $this->getAda(), PDO::PARAM_STR);
            $ret->execute();

            if ($ret->rowCount() > 0) {
                return $ret->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //Método para editar processo
    function editarProcesso($pdo) {
        try {
            $sql = $pdo->prepare("UPDATE gco_processo SET 
                                                cd_ada_cpr=:ada,
                                                cd_pregao=:pregao,
                                                vl_total_est=:estimado,
                                                vl_total_hom=:homologado,
                                                dt_processo=:data,
                                                id_objeto=:id_objeto,
                                                id_modalidade=:id_modalidade
                                    WHERE id_processo =:id_processo");
            $sql->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->bindValue(":ada", $this->getAda(), PDO::PARAM_STR);
            $sql->bindValue(":pregao", $this->getNumePregao(), PDO::PARAM_STR);
            $sql->bindValue(":estimado", $this->getValorEstimado(), PDO::PARAM_STR);
            $sql->bindValue(":homologado", $this->getValorHomologado(), PDO::PARAM_STR);
            $sql->bindValue(":data", $this->getData(), PDO::PARAM_STR);
            $sql->bindValue(":id_objeto", $this->getObjeto() === 0 ? null : $this->getObjeto(), PDO::PARAM_INT);
            $sql->bindValue(":id_modalidade", $this->getModalidade() === 0 ? NULL : $this->getModalidade(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function editarArea($pdo) {
        try {
            $edit = $pdo->prepare("UPDATE gco_area_abrangencia 
                                       SET id_cidade=:id_area 
                                   WHERE id_processo=:id_processo");
            $edit->bindValue(":id_area", $this->getId_area(), PDO::PARAM_INT);
            $edit->bindValue(":id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $edit->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    function editarUnidade($pdo) {
        try {
            $edit = $pdo->prepare(" UPDATE gco_processo_unidade 
                                        SET id_unidade_contempladas=:id_unidade 
                                    WHERE id_processo=:id_processo");
            $edit->bindValue(":id_unidade", $this->getUnidade(), PDO::PARAM_INT);
            $edit->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $edit->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    //Método desativar um processo cadastrado(OBS: Os processos não podem ser apagados, por isso são desativados)
    function desativarProcesso($pdo) {
        try {
            $del = $pdo->prepare("  UPDATE gco_processo 
                                        SET st_ativo =:status 
                                    WHERE id_processo =:id_processo");

            $del->bindValue(":id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $del->bindValue(':status', 0, PDO::PARAM_STR);
            $del->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Método que lista todas as áreas abrangentes no select option
    function retornaTodasAreas($pdo) {
        try {
            $sql = $pdo->prepare("SELECT ses_cidade.id_cidade, ses_cidade.nm_cidade, ses_regional_geo.nm_regional_geo 
                                    FROM ses_cidade 
                                        INNER JOIN ses_estado ON ses_cidade.id_estado=ses_estado.id_estado
                                        INNER JOIN ses_regional_geo ON ses_regional_geo.id_regional_geo=ses_cidade.id_regional_geo
                                    WHERE nm_estado='Acre' 
                                        AND ses_cidade.st_ativo=:status
                                    ORDER BY ses_cidade.nm_cidade");

            $sql->bindValue(":status", 1, PDO::PARAM_STR);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Método que lista todos os técnicos no select option na página de editar e cadastrar processo
    function retornaTodosTecnicos($pdo) {
        try {
            $retec = $pdo->prepare("SELECT DISTINCT P.id_pessoa, P.nm_pessoa 
                                         FROM ses_pessoa as P
                                             INNER JOIN ses_pessoa_fisica as F ON F.id_pessoa=P.id_pessoa
                                                  WHERE P.st_ativo=:status 
                                                       ORDER BY P.nm_pessoa");
            $retec->bindValue(":status", 1, PDO::PARAM_STR);
            $retec->execute();
            if ($retec->rowCount() > 0) {
                return $retec->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    //Método que lista todos os técnicos no select option na página de pesquisa de processo
    function retornaTecnicosProcessos($pdo) {
        try {
            $sql = $pdo->prepare("SELECT DISTINCT PES.id_pessoa, PES.nm_pessoa
                                            FROM gco_processo as PRO
                                        INNER JOIN gco_anotacao as ANO ON ANO.id_processo = PRO.id_processo
                                        INNER JOIN ses_pessoa as PES ON PES.id_pessoa = ANO.id_pessoa 
                                            WHERE PES.st_ativo=:status AND PRO.st_ativo=:status");
            $sql->bindValue(":status", 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    //metodo para inserir a area de um processo
    function cadastrarAreaAbrangencia($pdo) {
        try {
            $area = $pdo->prepare("INSERT INTO gco_area_abrangencia(id_cidade, id_processo) VALUES (:id_cidade, :id_processo)");
            $area->bindValue(":id_cidade", $this->getArea(), PDO::PARAM_INT);
            $area->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $area->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //metodo para inserir a(s) central(is) de um processo
    function cadastrarCentraisAtendimento($pdo) {
        try {
            $sql = $pdo->prepare("INSERT INTO gco_processo_central(id_processo, id_lotacao) VALUES (:id_processo, :id_central)");
            $sql->bindValue(":id_central", $this->getCentraisAtendimento(), PDO::PARAM_INT);
            $sql->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //metodo para inserir a(s) central(is) de um processo
    function cadastrarTipoGasto($pdo, $valorTipoGasto) {
        try {
            $sql = $pdo->prepare("INSERT INTO gco_processo_tipo_gasto(id_processo, id_tipo_gasto, vl_processo_tipo_gasto) VALUES (:id_processo, :id_tipo_gasto, :valorTipoGasto)");
            $sql->bindValue(":id_tipo_gasto", $this->getTipoGasto(), PDO::PARAM_INT);
            $sql->bindValue(":valorTipoGasto", $valorTipoGasto, PDO::PARAM_STR);
            $sql->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //metodo para deletar a area de um processo
    function deletarAreaAbrangencia($pdo) {
        try {
            $area = $pdo->prepare("DELETE FROM gco_area_abrangencia WHERE id_processo=:id_processo AND id_cidade=:id_cidade");
            $area->bindValue(":id_cidade", $this->getArea(), PDO::PARAM_INT);
            $area->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $area->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    //metodo para deletar a area de um processo
    function deletarProcessoCentral($pdo) {
        try {
            $area = $pdo->prepare("DELETE FROM gco_processo_central WHERE id_processo=:id_processo AND id_lotacao=:id_lotacao");
            $area->bindValue(":id_lotacao", $this->getCentraisAtendimento(), PDO::PARAM_INT);
            $area->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $area->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    //metodo para inserir os dados da tabela gcon_processo_unidade
    function cadastarProcessoUnidade($pdo) {
        try {
            $unidade = $pdo->prepare("INSERT INTO gco_processo_unidade(id_processo, id_unidade_contempladas) VALUES (:id_processo, :id_unidade)");
            $unidade->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $unidade->bindValue(":id_unidade", $this->getUnidade(), PDO::PARAM_INT);
            $unidade->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Método que lista a unidade de um processo para o log
    function retornaProcessoUnidadeLog($pdo) {
        try {
            $sql = $pdo->prepare("SELECT * FROM gco_processo_unidade WHERE id_processo=:idProcesso");
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //método para salvar dados do anexo
    function cadastrarAnexo($pdo) {
        try {
            $upload = $pdo->prepare("INSERT INTO gco_anexo(ds_anexo, lk_anexo, id_processo) VALUES (:nome, :endereco, :id_processo)");
            $upload->bindValue(":nome", $this->getNomeAnexo() === '' ? null : $this->getNomeAnexo(), PDO::PARAM_STR);
            $upload->bindValue(":endereco", $this->getEndereço() === '' ? null : $this->getEndereço(), PDO::PARAM_STR);
            $upload->bindValue("id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $upload->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //método para listar processo para PDF
    function carregarProcessoPdf($pdo) {
        try {
            $processo = $pdo->prepare(" SELECT PRO.id_processo, PRO.cd_ada_cpr, PRO.cd_pregao, 
                                            PRO.vl_total_est, PRO.vl_total_hom, PRO.dt_processo,
                                            UNI.nm_unidade_contempladas, array_to_string(array_agg(CID.nm_cidade), ', ') as nm_cidade, MOD.nm_modalidade, 
                                            OBJ.nm_objeto, SIT.nm_situacao, TPG.nm_tipo_gasto, PES.nm_pessoa 
                                        FROM gco_processo  PRO
                                            LEFT JOIN gco_objeto OBJ ON OBJ.id_objeto = PRO.id_objeto
                                            LEFT JOIN gco_modalidade MOD ON MOD.id_modalidade = PRO.id_modalidade
                                            LEFT JOIN gco_anexo ANE ON ANE.id_processo = PRO.id_processo
                                            LEFT JOIN gco_processo_unidade PU ON PU.id_processo = PRO.id_processo
                                            LEFT JOIN gco_unidade_contempladas UNI ON UNI.id_unidade_contempladas = PU.id_unidade_contempladas                                        
                                            LEFT JOIN gco_anotacao ANO ON ANO.id_processo = PRO.id_processo
                                            LEFT JOIN gco_situacao SIT ON SIT.id_situacao = ANO.id_situacao
                                            LEFT JOIN pla_tipo_gasto TPG ON TPG.id_tipo_gasto = PRO.id_tipo_gasto
                                            LEFT JOIN ses_pessoa PES ON PES.id_pessoa = ANO.id_pessoa       
                                            LEFT JOIN gco_area_abrangencia AREA on AREA.id_processo = PRO.id_processo
                                            LEFT JOIN ses_cidade CID ON CID.id_cidade = AREA.id_cidade  
                                        WHERE (PRO.id_processo=:id_processo) AND PRO.st_ativo='1' 
                                            GROUP by PRO.id_processo, OBJ.id_objeto, MOD.id_modalidade, UNI.id_unidade_contempladas, TPG.id_tipo_gasto, PES.id_pessoa, SIT.id_situacao, ANO.dh_anotacao, ANO,id_anotacao 
                                            ORDER BY ANO.id_anotacao DESC");
            $processo->bindValue(":id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $processo->execute();
            if ($processo->rowCount() > 0) {
                return $processo->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function historicoProcesso($pdo) {
        try {

            $dados = $pdo->prepare("SELECT ANO.dh_anotacao, USU.nm_pessoa as usuario, PE.nm_pessoa as tecnico, SIT.nm_situacao, ANO.ds_anotacao 
                                    FROM gco_anotacao as ANO
                                        INNER JOIN ses_pessoa as USU ON USU.id_pessoa = ANO.id_usuario
                                        INNER JOIN ses_pessoa as PE ON PE.id_pessoa = ANO.id_pessoa
                                        INNER JOIN gco_situacao as SIT ON SIT.id_situacao = ANO.id_situacao
                                    WHERE ANO.id_processo =:id_processo
                                        ORDER BY ANO.id_anotacao");
            $dados->bindValue(":id_processo", $this->getId_Processo(), PDO::PARAM_INT);
            $dados->execute();
            if ($dados->rowCount() >= 0) {
                return $dados->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function listarProcessosDesativados($pdo) {
        try {
            $processos = $pdo->prepare("SELECT DISTINCT ON (PRO.id_processo) PRO.id_processo, PRO.cd_ada_cpr, PRO.cd_pregao, PRO.vl_total_est, PRO.vl_total_hom, PRO.dt_processo, OBJ.nm_objeto,
                                            MOD.nm_modalidade, UNI.nm_unidade_contempladas, SIT.nm_situacao, array_to_string(array_agg(DISTINCT CID.nm_cidade), ', ') as nm_cidade, TIG.nm_tipo_gasto, PE.nm_pessoa,
                                            COALESCE(json_object_agg(ANE.id_anexo, ANE.ds_anexo) FILTER (WHERE ANE.id_anexo IS NOT NULL), '[]') AS ds_anexo,
                                            COALESCE(json_object_agg(ANE.id_anexo, ANE.lk_anexo) FILTER (WHERE ANE.id_anexo IS NOT NULL), '[]') AS lk_anexo
                                        FROM gco_processo PRO
                                            LEFT JOIN gco_objeto OBJ ON OBJ.id_objeto = PRO.id_objeto
                                            LEFT JOIN gco_modalidade MOD ON MOD.id_modalidade = PRO.id_modalidade
                                            LEFT JOIN gco_anexo ANE ON ANE.id_processo = PRO.id_processo
                                            LEFT JOIN gco_processo_unidade PU ON PU.id_processo = PRO.id_processo
                                            LEFT JOIN gco_unidade_contempladas UNI ON UNI.id_unidade_contempladas = PU.id_unidade_contempladas                                        
                                            LEFT JOIN gco_anotacao ANO ON ANO.id_processo = PRO.id_processo
                                            LEFT JOIN gco_situacao SIT ON SIT.id_situacao = ANO.id_situacao
                                            LEFT JOIN pla_tipo_gasto TIG ON TIG.id_tipo_gasto = PRO.id_tipo_gasto
                                            LEFT JOIN ses_pessoa PE ON PE.id_pessoa = ANO.id_pessoa       
                                            LEFT JOIN gco_area_abrangencia AREA on AREA.id_processo = PRO.id_processo
                                            LEFT JOIN ses_cidade CID ON CID.id_cidade = AREA.id_cidade                                         
                                        WHERE PRO.st_ativo=:status
                                        GROUP by PRO.id_processo, OBJ.id_objeto, MOD.id_modalidade, UNI.id_unidade_contempladas, SIT.id_situacao, TIG.id_tipo_gasto, PE.id_pessoa, ANO.id_anotacao");
            $processos->bindValue(':status', 0, PDO::PARAM_STR);
            $processos->execute();
            if ($processos->rowCount() >= 0) {
                return $processos->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function ativarProcesso($pdo) {
        try {
            $processo = $pdo->prepare("UPDATE gco_processo 
                                        SET st_ativo ='1' 
                                    WHERE cd_ada_cpr =:ada");

            $processo->bindValue(":ada", $this->getADA_process(), PDO::PARAM_STR);
            $processo->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function acharProcessoUpload($pdo) {
        try {
            $dados = $pdo->prepare("SELECT SIT.id_situacao, PE.id_pessoa
                                    FROM gco_processo PRO
                                    INNER JOIN gco_anotacao ANO ON ANO.id_processo = PRO.id_processo
                                    INNER JOIN gco_situacao SIT ON SIT.id_situacao = ANO.id_situacao
                                    INNER JOIN ses_pessoa PE ON PE.id_pessoa = ANO.id_pessoa                                        
                                    WHERE PRO.id_processo =:id_processo AND PRO.st_ativo='1'
                                    order by ANO.id_anotacao desc 
                                    limit 1");
            $dados->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $dados->execute();
            if ($dados->rowCount() > 0) {
                return $dados->fetch(PDO::FETCH_ASSOC);
            } else {
                return "";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function anexos($pdo) {
        try {
            $dados = $pdo->prepare(" SELECT id_anexo, ds_anexo 
                                        FROM gco_anexo
                                        WHERE id_processo=:id_processo
                                    GROUP BY id_anexo");
            $dados->bindValue(":id_processo", $this->getIdProcesso(), PDO::PARAM_INT);
            $dados->execute();
            if ($dados->rowCount() >= 0) {
                return $dados->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return "";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function excluiAnexo($pdo) {
        try {
            $exclui = $pdo->prepare(" DELETE 
                                        FROM gco_anexo 
                                      WHERE id_anexo=:id_anexo");
            $exclui->bindValue("id_anexo", $this->getIdAnexo(), PDO::PARAM_INT);
            $exclui->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaAnotacoes($pdo) {
        try {
            $sql = $pdo->prepare('SELECT anotacao.ds_anotacao, anotacao.dh_anotacao, pessoa.nm_pessoa
                                        FROM gco_anotacao as anotacao 
                                            INNER JOIN ses_pessoa as pessoa ON pessoa.id_pessoa=anotacao.id_usuario
                                                 WHERE anotacao.id_processo=:idProcesso
                                                      ORDER BY anotacao.id_anotacao');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function carregaAnotacao($pdo) {
        try {
            $sql = $pdo->prepare('SELECT anotacao.id_anotacao, pessoa.id_pessoa, anotacao.id_situacao
                                  FROM gco_anotacao as anotacao 
                                  INNER JOIN ses_pessoa as pessoa ON pessoa.id_pessoa = anotacao.id_pessoa
                                  WHERE anotacao.id_processo = :idProcesso 
                                  order by anotacao.id_anotacao desc');
            $sql->bindValue(':idProcesso', $this->getId_Processo(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornarProcessoLog($pdo) {
        try {
            $sql = $pdo->prepare('SELECT *
                                        FROM gco_processo
                                                 WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornarAreaLog($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_area_abrangencia '
                                    . 'FROM gco_area_abrangencia '
                                    . 'WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornarProcessoCentral($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_processo_central '
                                    . 'FROM gco_processo_central '
                                    . 'WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornarProcessoTipoGasto($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_processo_tipo_gasto '
                                    . 'FROM gco_processo_tipo_gasto '
                                    . 'WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornaAreaDelete($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_area_abrangencia FROM gco_area_abrangencia WHERE id_processo=:idProcesso AND id_cidade=:idCidade');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->bindValue(':idCidade', $this->getArea(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornaCeltralDelete($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_processo_central FROM gco_processo_central WHERE id_processo=:idProcesso AND id_lotacao=:idLotacao');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->bindValue(':idLotacao', $this->getCentraisAtendimento(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornarAreaCidade($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_cidade FROM gco_area_abrangencia
                                  WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_COLUMN);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornarCentraisDoProcesso($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_lotacao FROM gco_processo_central
                                  WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_COLUMN);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornarTipoDeGastoDoProcesso($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_processo_tipo_gasto as id, id_tipo_gasto as tpg, vl_processo_tipo_gasto as valor FROM gco_processo_tipo_gasto
                                  WHERE id_processo=:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornaTiposGastoProcesso($pdo) {
        try {
            $sql = $pdo->prepare('SELECT GPTG.id_processo_tipo_gasto, PTG.id_tipo_gasto, PTG.nm_tipo_gasto, GPTG.vl_processo_tipo_gasto
                                    FROM gco_processo_tipo_gasto GPTG
                                            INNER JOIN pla_tipo_gasto PTG ON PTG.id_tipo_gasto = GPTG.id_tipo_gasto
                                    WHERE GPTG.id_processo = :idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    function retornaCentraisProcesso($pdo) {
        try {
            $sql = $pdo->prepare('SELECT SL.id_lotacao, SL.nm_lotacao
                                    FROM gco_processo_central GPC
                                            INNER JOIN ses_lotacao SL ON SL.id_lotacao = GPC.id_lotacao
                                    WHERE GPC.id_processo =:idProcesso');
            $sql->bindValue(':idProcesso', $this->getIdProcesso(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
