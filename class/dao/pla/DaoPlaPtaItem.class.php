<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPtaItem.class.php";

class DaoPlaPtaItem extends PlaPtaItem {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
       
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pta_item (id_pta_titulo"
                    . " , id_material, ds_pta_item, id_pta_acao_det, id_tipo_gasto"
                    . " , id_tipo_gasto_categoria, id_unidade_medida, id_fonte"
                    . " , tp_fonte, id_portaria, id_convenio"
                    . " , qt_pta_item, vl_pta_item) "
                    . " VALUES (:idPtaTitulo, :idMaterial, :dsPtaItem, :idPtaAcaoDet"
                    . " , :idTipoGasto, :idTipoGastoCategoria, :idUnidadeMedida"
                    . " , :idFonte, :tpFonte, :idPortaria, :idConvenio, :qtPtaItem, :vlPtaItem)");            
            $result->bindValue(":idPtaTitulo", $this->getIdPtaTitulo(), PDO::PARAM_INT);
            $result->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
            $result->bindValue(":dsPtaItem", $this->getDsPtaItem(), PDO::PARAM_STR);
            $result->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_STR);
            $result->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $result->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_INT);
            $result->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);
            $result->bindValue(":tpFonte", $this->getTpFonte(), PDO::PARAM_STR);
            $result->bindValue(":idPortaria", $this->getIdPortaria(), PDO::PARAM_INT);
            $result->bindValue(":idConvenio", $this->getIdConvenio(), PDO::PARAM_INT);
            $result->bindValue(":qtPtaItem", $this->getQtPtaItem(), PDO::PARAM_STR);
            $result->bindValue(":vlPtaItem", $this->getVlPtaItem(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            
            $sqlStatus = "";
            if(!empty($this->getStPtaItem())){
                $sqlStatus = " , st_pta_item = :stPtaItem";
            }
            
            $result = $pdo->prepare("UPDATE pla_pta_item SET id_material = :idMaterial, ds_pta_item = :dsPtaItem"
                    . " , id_pta_acao_det = :idPtaAcaoDet, id_tipo_gasto_categoria = :idTipoGastoCategoria "
                    . " , id_unidade_medida = :idUnidadeMedida, id_fonte = :idFonte"
                    . " , tp_fonte = :tpFonte, id_portaria = :idPortaria, id_convenio = :idConvenio"
                    . " , qt_pta_item = :qtPtaItem, vl_pta_item = :vlPtaItem"
                    . $sqlStatus
                    . " WHERE id_pta_item = :idPtaItem");
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_STR);
            $result->bindValue(":dsPtaItem", $this->getDsPtaItem(), PDO::PARAM_INT);
            $result->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_STR);         
            $result->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_STR);
            $result->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_STR);
            $result->bindValue(":tpFonte", $this->getTpFonte(), PDO::PARAM_STR);
            $result->bindValue(":idPortaria", $this->getIdPortaria(), PDO::PARAM_INT);
            $result->bindValue(":idConvenio", $this->getIdConvenio(), PDO::PARAM_INT);
            $result->bindValue(":qtPtaItem", $this->getQtPtaItem(), PDO::PARAM_STR);
            $result->bindValue(":vlPtaItem", $this->getVlPtaItem(), PDO::PARAM_INT);
            if(!empty($this->getStPtaItem())){
                $result->bindValue(":stPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            }
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();    
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pta_item WHERE id_pta_item = :idPtaItem");
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;  
            $this->msgRetorno = $e->getMessage(); 
            if($e->getCode() == "23503"){
                $this->msgRetorno = "FKViolation";                
            }            
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pta_item SET st_pta_item = 0 "
                    . "WHERE id_pta_item = :idPtaItem ");
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function mudaStatus($pdo) {
        try {            
            
            $result = $pdo->prepare("UPDATE pla_pta_item SET st_pta_item = :stPtaItem "
                    . "WHERE id_pta_item = :idPtaItem ");
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->bindValue(":stPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function mudaStatusIN(array $arrayItens, array $statusQueFicara, $pdo){
        
        try {
            $result = $pdo->prepare(""
                    . "UPDATE pla_pta_item AS PI"
                    . " SET st_pta_item = :stPtaItem"
                    . " FROM pla_pta_titulo PT, pla_pta PTA, pla_pas PAS"
                    . " WHERE PI.id_pta_titulo = PT.id_pta_titulo"
                    . " AND PT.id_pta = PTA.id_pta"
                    . " AND PAS.id_pas = PTA.id_pas"
                    . " AND PAS.id_pas = :idPas"
                    . " AND PI.id_tipo_gasto_categoria = :idTipoGastoCategoria"
                    . " AND PI.st_pta_item IN (".$statusAtual.")");                                                             
            $result->bindValue(":idPas", $idPas, PDO::PARAM_INT);
            $result->bindValue(":stPtaItem", $stPtaItem, PDO::PARAM_INT);
            $result->bindValue(":idTipoGastoCategoria", $idTipoGastoCategoria, PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }

    /**
     * Retorna as informações de um Material Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_pta_item, id_pta_titulo, id_material"
                    . " , ds_pta_item, id_pta_acao_det, id_tipo_gasto, id_tipo_gasto_categoria"
                    . " , id_unidade_medida, id_fonte, tp_fonte, id_portaria, id_convenio, qt_pta_item"
                    . " , vl_pta_item, st_pta_item"
                . " FROM pla_pta_item"
                . " WHERE id_pta_item = :idPtaItem";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    /**
     * Retorna todos os Itens Por um Titulo do Pta e Tipo de Gasto
     * @param type $pdo
     * @return boolean
     */
    function retornaPorPtaTituloTipoGasto($pdo){

        $this->sucesso = false;

        $sql = " SELECT PI.id_pta_item, PI.qt_pta_item, PI.vl_pta_item, PI.st_pta_item"
                . " , M.nm_desc_material"                
                . " , PAD.id_pta_acao_det, PAD.nm_pta_acao_det"
                . " , TGC.id_tipo_gasto_categoria, TGC.nm_tipo_gasto_categoria"
                . " , UM.nm_unidade_medida"
                . " , F.nr_fonte"
                . " FROM pla_pta_item PI"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"                
                . " INNER JOIN pla_pta_acao_det PAD ON PAD.id_pta_acao_det = PI.id_pta_acao_det"
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"
                . " INNER JOIN pla_unidade_medida UM ON UM.id_unidade_medida = PI.id_unidade_medida"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"
                . " WHERE PI.id_pta_titulo = :idPtaTitulo"
                    . " AND PI.id_tipo_gasto = :idTipoGasto"
                    . " AND PI.st_pta_item >= '1'"
                . " ORDER BY TGC.nm_tipo_gasto_categoria, F.nr_fonte, PAD.nm_pta_acao_det, M.nm_desc_material";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaTitulo", $this->getIdPtaTitulo(), PDO::PARAM_INT);
            $result->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }  

    /**
     * Retorna todos os Itens Por um Titulo do Pta e Tipo de Gasto
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosParaEdicao($pdo){

        $this->sucesso = false;

        $sql = " SELECT PI.id_pta_item, PI.ds_pta_item, PI.qt_pta_item, PI.vl_pta_item"
                . " , PI.id_unidade_medida, PI.id_tipo_gasto_categoria, PI.id_fonte"                
                . " , PI.id_tipo_gasto_categoria, PI.id_pta_acao_det"                
                . " , PI.id_fonte, PI.tp_fonte, PI.id_portaria, PI.id_convenio"
                . " , M.id_material, M.cd_material, M.nm_material, M.cd_desc_material, M.nm_desc_material"
                . " , M.cd_grupo, M.nm_grupo, M.cd_sub_grupo, M.nm_sub_grupo, M.tp_material, M.cd_elemento_despesa"
                . " FROM pla_pta_item PI"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"                                                
                . " WHERE PI.id_pta_item = :idPtaItem";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }  
    
    /**
     * Retorna todos os Itens Por um Titulo do Pta e Tipo de Gasto
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosCompleto($pdo){

        $this->sucesso = false;

        $sql = " SELECT PI.id_pta_item, PI.ds_pta_item, PI.qt_pta_item, PI.vl_pta_item"
                . " , PI.id_unidade_medida, PI.id_tipo_gasto_categoria, PI.id_fonte"                
                . " , PI.id_pta_acao_det"                
                . " , PI.id_fonte, PI.tp_fonte, PI.st_pta_item"
                . " , PORT.id_portaria, PORT.nm_portaria, RT.nm_rede_tematica"
                . " , CON.id_convenio, CON.nm_convenio"
                . " , M.id_material, M.cd_material, M.nm_material, M.cd_desc_material, M.nm_desc_material"
                . " , M.cd_grupo, M.nm_grupo, M.cd_sub_grupo, M.nm_sub_grupo, M.tp_material, M.cd_elemento_despesa"
                . " , UM.nm_unidade_medida, TGC.nm_tipo_gasto_categoria, F.nr_fonte"
                . " , PAD.nm_pta_acao_det, PT.nm_pta_titulo, PTA.nm_pta"
                . " , L.nm_lotacao"
                . " FROM pla_pta_item PI"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"
                . " INNER JOIN pla_pta_acao_det PAD ON PAD.id_pta_acao_det = PI.id_pta_acao_det"
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"
                . " INNER JOIN pla_unidade_medida UM ON UM.id_unidade_medida = PI.id_unidade_medida"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta_titulo = PI.id_pta_titulo"
                . " INNER JOIN pla_pta PTA ON PTA.id_pta = PT.id_pta"
                . " INNER JOIN pla_pas PAS ON PAS.id_pas = PTA.id_pas"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = PAS.id_lotacao"
                . " LEFT JOIN fin_portaria PORT ON PORT.id_portaria = PI.id_portaria"
                . " LEFT JOIN fin_rede_tematica RT ON RT.id_rede_tematica = PORT.id_rede_tematica"
                . " LEFT JOIN fin_convenio CON ON CON.id_convenio = PI.id_convenio"                
                . " WHERE PI.id_pta_item = :idPtaItem";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     * Verifica existe algum Item dos PTAs de acordo com um PAS
     * de acordo com os Status que foi enviado para verificação em INT
     * @param int $idPas
     * @param string $status
     * @param PDO $pdo
     */
    function verificaStatusPorPAS(int $idPas, string $status, PDO $pdo){

        $this->sucesso = false;
        
        $sql = " SELECT PAS.id_pas"                                      
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"                                                
                . " WHERE PAS.id_PAS = :idPas "
                    . " AND PI.st_pta_item IN (".$status.") LIMIT 1";                                       
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $idPas, PDO::PARAM_INT);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retornaTodosItensPorPAS(int $idPas, $pdo){

        $this->sucesso = false;

        $sql = " SELECT "                      
                . " PI.id_pta_item, M.nm_desc_material, F.nr_fonte, PI.id_tipo_gasto_categoria"
                . " , TGC.nm_tipo_gasto_categoria, UM.nm_unidade_medida"
                . " , PI.qt_pta_item, PI.vl_pta_item, L.nm_lotacao, PI.st_pta_item"                                
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"                                
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"                             
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"
                . " INNER JOIN pla_unidade_medida UM ON UM.id_unidade_medida = PI.id_unidade_medida"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"                
                . " LEFT JOIN ses_lotacao L ON L.id_lotacao = TGC.id_lotacao"                                           
                . " WHERE PAS.id_PAS = :idPas AND PI.st_pta_item >= '1'"
                . " ORDER BY TGC.nm_tipo_gasto_categoria, M.nm_desc_material, F.nr_fonte";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $idPas, PDO::PARAM_INT);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     * Retorna Todas as Unidades que solicitaram Validação de seus Itens para a Central
     * Tudo de acordo com o Tipo de Gasto Categoria
     * @param int $idLotacao
     * @param type $pdo
     */
    function retornaUnidadesValidarItensCentral(int $idLotacao, $pdo){

        $this->sucesso = false;

        $sql = " SELECT "                      
                . " L.nm_lotacao, TGC.nm_tipo_gasto_categoria, count(PI.id_pta_item) AS qtd_item, L.id_lotacao"
                . " , PAS.id_pas, PAS.nm_pas"                
                . " FROM pla_tipo_gasto_categoria TGC"
                . " INNER JOIN pla_pta_item PI ON PI.id_tipo_gasto_categoria = TGC.id_tipo_gasto_categoria"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta_titulo = PI.id_pta_titulo"
                . " INNER JOIN pla_pta PTA ON PTA.id_pta = PT.id_pta"
                . " INNER JOIN pla_pas PAS ON PAS.id_pas = PTA.id_pas"                                                                
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = PAS.id_lotacao"                  
                . " WHERE TGC.id_lotacao = :idLotacao AND PI.st_pta_item = '3'"
                . " GROUP BY L.id_lotacao, TGC.nm_tipo_gasto_categoria, PAS.id_pas"
                . " ORDER BY L.nm_lotacao";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     * Retorna todos os Itens que uma Central possui permissão de um Pas que estejam em um determinado Status
     * @param int $idCentral
     * @param int $idPas
     * @param PDO $pdo
     * @return Object
     */
    function retornaPorCentralPasStatus(int $idPas, int $idCentral, PDO $pdo){

        $this->sucesso = false;

        $sql = " SELECT PI.id_pta_item, PI.qt_pta_item, PI.vl_pta_item"
                . " , M.nm_desc_material"
                . " , TG.id_tipo_gasto, TG.nm_tipo_gasto"                                
                . " , TGC.id_tipo_gasto_categoria, TGC.nm_tipo_gasto_categoria"
                . " , UM.nm_unidade_medida"
                . " , F.nr_fonte, D.cd_despesa"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"                                
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"                             
                . " INNER JOIN pla_tipo_gasto TG ON TG.id_tipo_gasto = PI.id_tipo_gasto"
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"                
                . " INNER JOIN pla_unidade_medida UM ON UM.id_unidade_medida = PI.id_unidade_medida"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"                
                . " WHERE PAS.id_pas = :idPas AND TGC.id_lotacao = :idLotacao"
                    . " AND PI.st_pta_item = :StPtaItem"
                . " ORDER BY TG.nm_tipo_gasto, TGC.nm_tipo_gasto_categoria, F.nr_fonte, M.nm_desc_material";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $idPas, PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $idCentral, PDO::PARAM_INT);
            $result->bindValue(":StPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }  
    
    /**
     * 
     * @param int $idPas
     * @param string $status
     * @param type $pdo
     */
    function retornaPorPasTipoGastoCategoriaStatus(int $idPas, string $status, $pdo){

        $this->sucesso = false;

        
        $sql = " SELECT PI.id_pta_item"                                      
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"                                                
                . " WHERE PAS.id_PAS = :idPas "
                    . " AND PI.id_tipo_gasto_categoria = :idTipoGastoCategoria"
                    . " AND PI.st_pta_item IN (".$status.")";         
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $idPas, PDO::PARAM_INT);
            $result->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
        
    /**
     * Retorna os Valores Somados de Todos os Itens de Uma Lotação Por ano e Programa de Trabalho
     * @param int $idLotacao
     * @param type $ano
     * @param type $pdo
     */
    function retornaValoresPorLotacaoAnoProgTrab(int $idLotacao, $ano, $idProgramaTrabalho, $pdo){

                
        $this->sucesso = false;
        
        $sql = " SELECT SUM(PI.vl_pta_item*PI.qt_pta_item) as valor, F.id_fonte, F.nr_fonte"
                . " , DE.id_despesa_elemento, DE.cd_despesa_elemento"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"
                . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = D.id_despesa_elemento"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte   "
                . " WHERE to_char(PAS.dt_inicio, 'YYYY') = :ano AND PI.st_pta_item >= '1'"
                . " AND PAS.id_lotacao = :idLotacao AND PT.id_programa_trabalho = :idProgramaTrabalho"                
                . " GROUP BY F.id_fonte, DE.id_despesa_elemento, DE.cd_despesa_elemento"
                . " ORDER BY F.nr_fonte";                
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);
            $result->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);    
            $result->bindValue(":idProgramaTrabalho", $idProgramaTrabalho, PDO::PARAM_INT);    
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     * Retorna os Valores Somados de Todos os Itens de Uma Lotação Por ano e Fonte
     * @param int $idLotacao
     * @param type $ano
     * @param type $pdo
     */
    function retornaValoresPorLotacaoAnoFonte(int $idLotacao, $ano, $pdo){

        $sqlIdPtaItem = "";
        if($this->getIdPtaItem() != NULL && $this->getIdPtaItem() != 0){
            $sqlIdPtaItem = " AND PI.id_pta_item <> :idPtaItem";
        }
        
        $this->sucesso = false;
        
        $sql = " SELECT COALESCE(SUM(PI.vl_pta_item*PI.qt_pta_item), 0) as valor"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"
                . " WHERE to_char(PAS.dt_inicio, 'YYYY') = :ano AND PI.st_pta_item >= '1'"
                . $sqlIdPtaItem
                . " AND PAS.id_lotacao = :idLotacao AND PI.id_fonte = :idFonte";                            
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);
            $result->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);            
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);  
            if($this->getIdPtaItem() != NULL && $this->getIdPtaItem() != 0){
                $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);  
            }
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true;
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     * Retorna todos os Itens que uma Central possui permissão de um Pas que estejam em um determinado Status
     * @param int $idCentral
     * @param int $idPas
     * @param PDO $pdo
     * @return Object
     */
    function retornaPorCentralAnoValidado(int $ano, int $idCentral, PDO $pdo){

        $this->sucesso = false;

        $sql = " SELECT PI.id_pta_item, PI.qt_pta_item, PI.vl_pta_item"
                . " , M.nm_desc_material"
                . " , TG.id_tipo_gasto, TG.nm_tipo_gasto"                                
                . " , TGC.id_tipo_gasto_categoria, TGC.nm_tipo_gasto_categoria"
                . " , UM.nm_unidade_medida"
                . " , F.nr_fonte, D.cd_despesa"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"                                
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"                             
                . " INNER JOIN pla_tipo_gasto TG ON TG.id_tipo_gasto = PI.id_tipo_gasto"
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"                
                . " INNER JOIN pla_unidade_medida UM ON UM.id_unidade_medida = PI.id_unidade_medida"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"                
                . " WHERE to_char(PAS.dt_inicio, 'YYYY') = :ano AND TGC.id_lotacao = :idLotacao"
                    . " AND PI.st_pta_item = :StPtaItem"
                . " ORDER BY TG.nm_tipo_gasto, TGC.nm_tipo_gasto_categoria, F.nr_fonte, M.nm_desc_material";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);
            $result->bindValue(":idLotacao", $idCentral, PDO::PARAM_INT);
            $result->bindValue(":StPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
    /**
     * 
     * @param int $ano Ano
     * @param string $statusPas Status que a PAS deverá estar para ser validada. 
     * @param int $lotacao Lotação, não obrigatoria
     * @param PDO $pdo
     */
    function retornaValorProjAtiPPAPorAnoLot(int $ano, string $statusPas, int $lotacao, PDO $pdo){

        $this->sucesso = false;
        
        $sqlLotacao = "";
        if($lotacao != 0){
            $sqlLotacao = " AND PAS.id_lotacao = :idLotacao";
        }
        
             
        $sql = " SELECT PPA.id_ppa_proj_ati, PPA.nm_ppa_proj_ati, PPA.tp_ppa_proj_ati"
                . " , PP.id_ppa_prog, PP.nm_ppa_prog, PP.cd_ppa_prog"
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = PT.id_ppa_proj_ati"
                . " INNER JOIN pla_ppa_prog PP ON PP.id_ppa_prog = PPA.id_ppa_prog"
                . " WHERE to_char(PAS.dt_inicio, 'YYYY') = :ano"
                . " AND PAS.st_ativo = '1' AND PAS.st_pas IN (".$statusPas.") "
                . " AND PTA.st_ativo = '1' AND PT.st_ativo = '1'"
                . " AND PI.st_pta_item = :StPtaItem"
                . $sqlLotacao
                . " GROUP BY PPA.id_ppa_proj_ati, PP.id_ppa_prog"
                . " ORDER BY PPA.nm_ppa_proj_ati";

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);
            if($lotacao != 0){
                $result->bindValue(":idLotacao", $lotacao, PDO::PARAM_INT);
            }
            $result->bindValue(":StPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     * 
     * @param int $ano Ano
     * @param string $statusPas Status que a PAS deverá estar para ser validada. 
     * @param int $lotacao Lotação, não obrigatoria
     * @param PDO $pdo
     */
    function retornaValorAcaoPorAnoLot(int $ano, string $statusPas, int $lotacao, PDO $pdo){

        $this->sucesso = false;
        
        $sqlLotacao = "";
        if($lotacao != 0){
            $sqlLotacao = " AND PAS.id_lotacao = :idLotacao";
        }
        
             
        $sql = " SELECT A.id_acao, A.nm_acao, A.tp_cadastro"
                . " , E.id_eixo, E.nm_eixo"
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_pta_acao_det PAD ON PAD.id_pta_acao_det = PI.id_pta_acao_det"
                . " INNER JOIN pla_acao A ON A.id_acao = PAD.id_acao"
                . " INNER JOIN pla_objetivo O ON O.id_objetivo = A.id_objetivo"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER join pla_eixo E ON E.id_eixo = D.id_eixo"
                . " WHERE to_char(PAS.dt_inicio, 'YYYY') = :ano"
                . " AND PAS.st_ativo = '1' AND PAS.st_pas IN (".$statusPas.") "
                . " AND PTA.st_ativo = '1' AND PT.st_ativo = '1'"
                . " AND PI.st_pta_item = :StPtaItem"
                . $sqlLotacao
                . " GROUP BY A.id_acao, E.id_eixo"
                . " ORDER BY a.nm_acao";

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);
            if($lotacao != 0){
                $result->bindValue(":idLotacao", $lotacao, PDO::PARAM_INT);
            }
            $result->bindValue(":StPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
    /**
     * 
     * @param int $ano Ano
     * @param string $statusPas Status que a PAS deverá estar para ser validada. 
     * @param int $lotacao Lotação, não obrigatoria
     * @param int $idTipoGasto, não obrigatoria
     * @param PDO $pdo
     */
    function retornaValorCatEconomicaPorAnoLotTG(int $ano, string $statusPas, int $lotacao, int $idTipoGasto, PDO $pdo){

        $this->sucesso = false;
        
        $sqlLotacao = "";
        if($lotacao != 0){
            $sqlLotacao = " AND PAS.id_lotacao = :idLotacao";
        }                
        
        $sqlTipoGasto = "";
        if($idTipoGasto != 0){
            $sqlTipoGasto = " AND PI.id_tipo_gasto = :idTipoGasto";
        }
        
        
        $sql = " SELECT D.id_despesa_categoria, D.ds_despesa_categoria"                
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"
                . " FROM pla_pas PAS"                
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"                                                         
                . " WHERE to_char(PAS.dt_inicio, 'YYYY') = :ano"
                . " AND PAS.st_ativo = '1' AND PAS.st_pas IN (".$statusPas.") "
                . " AND PTA.st_ativo = '1' AND PT.st_ativo = '1'"
                . " AND PI.st_pta_item = :StPtaItem"          
                . $sqlLotacao
                . $sqlTipoGasto
                . " GROUP BY D.id_despesa_categoria, D.ds_despesa_categoria";                


        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);                
            if($lotacao != 0){
                $result->bindValue(":idLotacao", $lotacao, PDO::PARAM_INT);
            }
            if($idTipoGasto != 0){
                $result->bindValue(":idTipoGasto", $idTipoGasto, PDO::PARAM_INT);                
            }
            $result->bindValue(":StPtaItem", $this->getStPtaItem(), PDO::PARAM_STR);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     *      
     * @param int $idPtaTitulo Titulo do PTA
     * @param PDO $pdo
     */
    function retornaAcaoDetValPorPtaTitulo(int $idPtaTitulo, PDO $pdo){

        $this->sucesso = false;                        
             
        $sql = " SELECT A.nm_acao, A.id_acao"
                . " , PAD.nm_pta_acao_det, PAD.id_pta_acao_det, PA.ds_indicador_programacao"
                . " , F.id_fonte, F.nr_fonte"                
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"                
                . " FROM pla_pta_titulo PT"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"                
                . " INNER JOIN pla_pta_acao_det PAD ON PAD.id_pta_acao_det = PI.id_pta_acao_det"
                . " INNER JOIN pla_acao A ON A.id_acao = PAD.id_acao"
                . " INNER JOIN pla_pta P ON P.id_pta = PT.id_pta"
                . " INNER JOIN pla_pas_acao PA ON PA.id_pas = P.id_pas "
                    . " AND PA.id_acao = A.id_acao AND PA.id_ppa_proj_ati = PT.id_ppa_proj_ati"
                . " WHERE PT.id_pta_titulo = :idPtaTitulo"                
                . " AND PT.st_ativo = '1' AND PI.st_pta_item >= '1'"
                . " GROUP BY A.id_acao, PAD.id_pta_acao_det, F.id_fonte, PA.id_pas_acao"
                . " ORDER BY A.nm_acao, PAD.nm_pta_acao_det, F.nr_fonte";

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaTitulo", $idPtaTitulo, PDO::PARAM_INT);                        
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
    /**
     *      
     * @param int $idPtaTitulo Titulo do PTA
     * @param PDO $pdo
     */
    function retornaValFontePorPtaTitulo(int $idPtaTitulo, PDO $pdo){

        $this->sucesso = false;                        
             
        $sql = " SELECT F.id_fonte, F.nr_fonte"                
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"                
                . " FROM pla_pta_titulo PT"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"                               
                . " WHERE PT.id_pta_titulo = :idPtaTitulo"                
                . " AND PT.st_ativo = '1' AND PI.st_pta_item >= '1'"
                . " GROUP BY F.id_fonte"
                . " ORDER BY F.nr_fonte";

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaTitulo", $idPtaTitulo, PDO::PARAM_INT);                        
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    /**
     *      
     * @param int $idPtaTitulo Titulo do PTA
     * @param PDO $pdo
     */
    function retornaValCatEconomicaPorPtaTitulo(int $idPtaTitulo, PDO $pdo){

        $this->sucesso = false;                        
             
        $sql = " SELECT D.id_despesa_categoria, D.ds_despesa_categoria"                
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"                
                . " FROM pla_pta_titulo PT"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"                                         
                . " WHERE PT.id_pta_titulo = :idPtaTitulo"                
                . " AND PT.st_ativo = '1' AND PI.st_pta_item >= '1'"
                . " GROUP BY D.id_despesa_categoria, D.ds_despesa_categoria";                

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaTitulo", $idPtaTitulo, PDO::PARAM_INT);                        
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
    /**
     *      
     * @param int $idPtaTitulo Titulo do PTA
     * @param PDO $pdo
     */
    function retornaTGCValPorPtaTitulo(int $idPtaTitulo, PDO $pdo){

        $this->sucesso = false;                        
             
        $sql = " SELECT "
                . " TG.id_tipo_gasto, TG.nm_tipo_gasto"
                . " , TGC.id_tipo_gasto_categoria, TGC.nm_tipo_gasto_categoria"            
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor"                
                . " FROM pla_pta_titulo PT"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_tipo_gasto TG ON TG.id_tipo_gasto = PI.id_tipo_gasto"
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"                                                
                . " WHERE PT.id_pta_titulo = :idPtaTitulo"                
                . " AND PT.st_ativo = '1' AND PI.st_pta_item >= '1'"
                . " GROUP BY TG.id_tipo_gasto, TGC.id_tipo_gasto_categoria"
                . " ORDER BY TG.nm_tipo_gasto, TGC.nm_tipo_gasto_categoria";

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaTitulo", $idPtaTitulo, PDO::PARAM_INT);                        
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
    function retornaValoresPTAPorPAS(int $idPas, $pdo){

                
        $this->sucesso = false;
        
        $sql = " SELECT SUM(PI.vl_pta_item*PI.qt_pta_item) as valor, F.id_fonte, F.nr_fonte"
                . " , DE.id_despesa_elemento, DE.cd_despesa_elemento"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"
                . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = D.id_despesa_elemento"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte   "
                . " WHERE PAS.id_pas = :idPas AND PI.st_pta_item >= '1'"                            
                . " GROUP BY F.id_fonte, DE.id_despesa_elemento, DE.cd_despesa_elemento"
                . " ORDER BY F.nr_fonte";                
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $idPas, PDO::PARAM_STR);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retornaDadosParaAlteracao($pdo){

        $this->sucesso = false;

        $sql = " SELECT "
                . " PI.id_material, M.nm_desc_material"
                . " , PI.ds_pta_item"
                . " , PAD.id_pta_acao_det, PAD.nm_pta_acao_det"
                . " , TGC.id_tipo_gasto_categoria, TGC.nm_tipo_gasto_categoria"
                . " , PI.id_unidade_medida, UM.nm_unidade_medida"
                . " , F.id_fonte, F.nr_fonte, PI.tp_fonte"
                . " , PI.qt_pta_item, PI.vl_pta_item"                                
                . " , PI.st_pta_item"
                . " , PORT.id_portaria, PORT.nm_portaria, RT.nm_rede_tematica"
                . " , CON.id_convenio, CON.nm_convenio"                                                
                . " FROM pla_pta_item PI"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa D ON D.id_despesa = M.id_despesa"
                . " INNER JOIN pla_pta_acao_det PAD ON PAD.id_pta_acao_det = PI.id_pta_acao_det"
                . " INNER JOIN pla_tipo_gasto_categoria TGC ON TGC.id_tipo_gasto_categoria = PI.id_tipo_gasto_categoria"
                . " INNER JOIN pla_unidade_medida UM ON UM.id_unidade_medida = PI.id_unidade_medida"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"                
                . " LEFT JOIN fin_portaria PORT ON PORT.id_portaria = PI.id_portaria"
                . " LEFT JOIN fin_rede_tematica RT ON RT.id_rede_tematica = PORT.id_rede_tematica"
                . " LEFT JOIN fin_convenio CON ON CON.id_convenio = PI.id_convenio"
                . " WHERE PI.id_pta_item = :idPtaItem";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
}
