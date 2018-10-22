<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesVincularTramitacao.class.php";

class DaoSesVincularTramitacao extends SesVincularTramitacao {

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
                $sql = "insert into ses_vincular_tramitacao (id_tramitacao,id_pessoa, id_lotacao, id_doc_tipo_lotacao) values (:id_tramitacao,:id_pessoa, :id_lotacao, :id_doc_tipo_lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tramitacao", $this->getIdTramitacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
   }

   function delete(PDO $pdo = null){
       try {
            if (!empty($pdo)) {
                $sql = "delete from ses_vincular_tramitacao where id_vincular_tramitacao = :id_vincular_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_vincular_tramitacao", $this->getIdVincularTramitacao(), PDO::PARAM_INT);
                
                $this->sucesso = $stmt->execute();
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
   }
   
   function selectParaLog(PDO $pdo = null){
       try {
           if (!empty($pdo)) {
                $sql = "select * from ses_vincular_tramitacao where id_vincular_tramitacao = :id_vincular_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_vincular_tramitacao", $this->getIdVincularTramitacao(), PDO::PARAM_INT);
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
       } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
       }
    }
    
    function selectComDescritivos(PDO $pdo = null){
        try {
           if (!empty($pdo)) {
                $sql = "select
                            svt.id_vincular_tramitacao,
                            tramitacao.id_tramitacao,
                            tramitacao.nm_tramitacao,
                            pessoa.id_pessoa,
                            pessoa.nm_pessoa,
                            lotacao.id_lotacao,
                            lotacao.nm_lotacao,
                            tipoLotacao.id_doc_tipo_lotacao,
                            tipoLotacao.nm_doc_tipo_lotacao 
                         from
                            ses_vincular_tramitacao as svt 
                            inner join
                               ses_tramitacao as tramitacao 
                               on tramitacao.id_tramitacao = svt.id_tramitacao 
                            inner join
                               ses_pessoa as pessoa 
                               on pessoa.id_pessoa = svt.id_pessoa 
                            inner join
                               ses_lotacao as lotacao 
                               on lotacao.id_lotacao = svt.id_lotacao 
                            inner join
                               fin_doc_tipo_lotacao as tipoLotacao 
                               on tipoLotacao.id_doc_tipo_lotacao = svt.id_doc_tipo_lotacao 
                         where
                            id_vincular_tramitacao = :id_vincular_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_vincular_tramitacao", $this->getIdVincularTramitacao(), PDO::PARAM_INT);
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
       } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
       }
    }
   
   function selectTodosComDescritivos(PDO $pdo = null){
        try {
           if (!empty($pdo)) {
                $sql = "select
                            svt.id_vincular_tramitacao,
                            tramitacao.id_tramitacao,
                            tramitacao.nm_tramitacao,
                            pessoa.id_pessoa,
                            pessoa.nm_pessoa,
                            lotacao.id_lotacao,
                            lotacao.nm_lotacao,
                            tipoLotacao.id_doc_tipo_lotacao,
                            tipoLotacao.nm_doc_tipo_lotacao 
                         from
                            ses_vincular_tramitacao as svt 
                            inner join
                               ses_tramitacao as tramitacao 
                               on tramitacao.id_tramitacao = svt.id_tramitacao 
                            inner join
                               ses_pessoa as pessoa 
                               on pessoa.id_pessoa = svt.id_pessoa 
                            inner join
                               ses_lotacao as lotacao 
                               on lotacao.id_lotacao = svt.id_lotacao 
                            inner join
                               fin_doc_tipo_lotacao as tipoLotacao 
                               on tipoLotacao.id_doc_tipo_lotacao = svt.id_doc_tipo_lotacao";
                $stmt = $pdo->prepare($sql);
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
       } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
       }
    }
    
    function retornaLotacaoTipoLiquidacaoPorUsuario (PDO $pdo = null){
        try {
            $sql = "select distinct
                        svt.id_lotacao,
                        svt.id_doc_tipo_lotacao,
                        nm_lotacao,
                        nm_doc_tipo_lotacao 
                     from
                        ses_vincular_tramitacao as svt 
                        inner join
                           ses_lotacao as lot 
                           on lot.id_lotacao = svt.id_lotacao 
                        inner join
                           fin_doc_tipo_lotacao as tipoLot 
                           on tipoLot.id_doc_tipo_lotacao = svt.id_doc_tipo_lotacao 
                     where svt.id_pessoa = :id_pessoa
                     and svt.id_tramitacao = 2 --Liquidar";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function retornaLotacaoTipoPagamentoPorUsuario (PDO $pdo = null){
        try {
            $sql = "select distinct
                        svt.id_lotacao,
                        svt.id_doc_tipo_lotacao,
                        nm_lotacao,
                        nm_doc_tipo_lotacao 
                     from
                        ses_vincular_tramitacao as svt 
                        inner join
                           ses_lotacao as lot 
                           on lot.id_lotacao = svt.id_lotacao 
                        inner join
                           fin_doc_tipo_lotacao as tipoLot 
                           on tipoLot.id_doc_tipo_lotacao = svt.id_doc_tipo_lotacao 
                     where svt.id_pessoa = :id_pessoa
                     and svt.id_tramitacao = 3 --Pagamento";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function retornaLotacaoTipoLiquidacaoPorTipoELotacao(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select distinct
                            svt.id_lotacao,
                            svt.id_doc_tipo_lotacao,
                            nm_lotacao,
                            nm_doc_tipo_lotacao 
                         from
                            ses_vincular_tramitacao as svt 
                            inner join
                               ses_lotacao as lot 
                               on lot.id_lotacao = svt.id_lotacao 
                            inner join
                               fin_doc_tipo_lotacao as tipoLot 
                               on tipoLot.id_doc_tipo_lotacao = svt.id_doc_tipo_lotacao 
                         where svt.id_doc_tipo_lotacao = :id_doc_tipo_lotacao
                         and svt.id_lotacao = :id_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
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
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function retornaLotacaoTipoAnulacaoEmpenhoPorUsuario (PDO $pdo = null){
        try {
            $sql = "select distinct
                        svt.id_lotacao,
                        svt.id_doc_tipo_lotacao,
                        nm_lotacao,
                        nm_doc_tipo_lotacao 
                     from
                        ses_vincular_tramitacao as svt 
                        inner join
                           ses_lotacao as lot 
                           on lot.id_lotacao = svt.id_lotacao 
                        inner join
                           fin_doc_tipo_lotacao as tipoLot 
                           on tipoLot.id_doc_tipo_lotacao = svt.id_doc_tipo_lotacao 
                     where svt.id_pessoa = :id_pessoa
                     and svt.id_tramitacao = 4 --Liquidar";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
}

