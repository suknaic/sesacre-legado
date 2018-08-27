<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocLotacao.class.php";

class DaoFinDocLotacao extends FinDocLotacao {

    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function insert(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_doc_lotacao (id_lotacao,id_doc_tipo_lotacao) values (:id_lotacao,:id_doc_tipo_lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
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
    
    
    function delete(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_doc_lotacao where id_doc_lotacao = :id_doc_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
                
                $this->sucesso = $stmt->execute();
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE fin_doc_lotacao SET st_ativo = 0 "
                    . "WHERE id_doc_lotacao = :idDocLotacao ");
            $result->bindValue(":idDocLotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function ativar($pdo) {
        try {
            $result = $pdo->prepare("UPDATE fin_doc_lotacao SET st_ativo = 1 "
                    . "WHERE id_doc_lotacao = :idDocLotacao ");
            $result->bindValue(":idDocLotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function selectAtivos(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select 
                                id_doc_lotacao,
                                fdtl.id_doc_tipo_lotacao, 
                                nm_doc_tipo_lotacao,
                                sl.id_lotacao,
                                nm_lotacao,
                                fdl.st_ativo
                        from 
                                fin_doc_lotacao fdl,
                                fin_doc_tipo_lotacao fdtl,
                                ses_lotacao sl
                        where
                                fdl.st_ativo = '1'
                        and     fdl.id_doc_tipo_lotacao = fdtl.id_doc_tipo_lotacao
                        and	fdl.id_lotacao = sl.id_lotacao ". $this->filtroSql() . " order by nm_doc_tipo_lotacao,nm_lotacao";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocLotacao()){
                    $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocTipoLotacao()) {
                    $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                }

                if ($this->getIdLotacao()) {
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
    
    function select(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select 
                                id_doc_lotacao,
                                fdtl.id_doc_tipo_lotacao, 
                                nm_doc_tipo_lotacao,
                                sl.id_lotacao,
                                nm_lotacao,
                                fdl.st_ativo
                        from 
                                fin_doc_lotacao fdl,
                                fin_doc_tipo_lotacao fdtl,
                                ses_lotacao sl
                        where
                                fdl.id_doc_tipo_lotacao = fdtl.id_doc_tipo_lotacao
                        and	fdl.id_lotacao = sl.id_lotacao ". $this->filtroSql() . " order by nm_doc_tipo_lotacao,nm_lotacao";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocLotacao()){
                    $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocTipoLotacao()) {
                    $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                }

                if ($this->getIdLotacao()) {
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
    
    function retornaTipoDocLotaEstaAtivo(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select docLot.id_doc_lotacao, docTpLot.id_doc_tipo_lotacao
                        from fin_doc_lotacao as docLot 
                        inner join fin_doc_tipo_lotacao as docTpLot
                        on docTpLot.id_doc_tipo_lotacao = docLot.id_doc_tipo_lotacao
                        and docTpLot.st_ativo = '1'
                        where docLot.id_doc_lotacao = :id_doc_lotacao";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
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
            echo $exc->getTraceAsString();
        }
    }
    
    function selectLinha(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_doc_lotacao where id_doc_lotacao = :id_doc_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
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
    
    function filtroSql(){
        $filtro = "";
        
        if ($this->getIdDocLotacao()) {
            $filtro .= " and id_doc_lotacao = :id_doc_lotacao";
        }
        
        if ($this->getIdDocTipoLotacao()) {
            $filtro .= " and fdl.id_doc_tipo_lotacao = :id_doc_tipo_lotacao";
        }
        
        if ($this->getIdLotacao()) {
            $filtro .= " and fdl.id_lotacao = :id_lotacao";
        }
        
        return $filtro;
    }
    
    function verificaTramitacaoExiste(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_doc_tramitacao"
                        . " where id_doc_origem = :id_doc_lotacao"
                        . " OR"
                        . " id_doc_destino = :id_doc_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_doc_destino", $this->getIdDocLotacao(), PDO::PARAM_INT);
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
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }

    }
}

