<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocTramitacao.class.php";

class DaoFinDocTramitacao extends FinDocTramitacao {

    private $sucesso = false;
    private $msgRetorno = null;

    public function getSucesso()
    {
        return $this->sucesso;
    }

    public function getMsgRetorno()
    {
        return $this->msgRetorno;
    }

    function insert(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "insert into
                            fin_doc_tramitacao (id_documento_fiscal, id_pessoa, id_lotacao_origem, id_lotacao_destino, id_documento_situacao, ds_doc_tramitacao) 
                        values
                            (
                                :id_documento_fiscal, :id_pessoa, :id_lotacao_origem, :id_lotacao_destino, :id_documento_situacao, :ds_doc_tramitacao
                            )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_documento_fiscal', $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->bindValue(':id_pessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(':id_lotacao_origem', $this->getIdLotacaoOrigem(), PDO::PARAM_INT);
                $stmt->bindValue(':id_lotacao_destino', $this->getIdLotacaoDestino(), PDO::PARAM_INT);
                $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(':ds_doc_tramitacao', $this->getDsDocTramitacao(), PDO::PARAM_STR);
                
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

    function select(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_doc_tramitacao " . $this->filtroSql();
                $stmt = $pdo->prepare($sql);
                
                if ($this->getIdDocumentoFiscal()) {
                    $stmt->bindValue(':id_documento_fiscal', $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                }
                if ($this->getIdPessoa()) {
                    $stmt->bindValue(':id_pessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                }
                if ($this->getIdLotacaoOrigem()) {
                    $stmt->bindValue(':id_lotacao_origem', $this->getIdLotacaoOrigem(), PDO::PARAM_INT);
                }
                if ($this->getIdLotacaoDestino()) {
                    $stmt->bindValue(':id_lotacao_destino', $this->getIdLotacaoDestino(), PDO::PARAM_INT);
                }
                if ($this->getIdDocumentoSituacao()) {
                    $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
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
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    private function filtroSql(){
        $filtro = "";
        
        if ($this->getIdDocumentoFiscal) {
            $filtro .= empty($filtro) ? " where id_documento_fiscal = :id_documento_fiscal " : " and id_documento_fiscal = :id_documento_fiscal ";
        }

        if ($this->getIdPessoa) {
            $filtro .= empty($filtro) ? " where id_pessoa = :id_pessoa " : " and id_pessoa = :id_pessoa ";
        }

        if ($this->getIdLotacaoOrigem) {
            $filtro .= empty($filtro) ? " where id_lotacao_origem = :id_lotacao_origem " : " and id_lotacao_origem = :id_lotacao_origem ";
        }

        if ($this->getIdLotacaoDestino) {
            $filtro .= empty($filtro) ? " where id_lotacao_destino = :id_lotacao_destino " : " and id_lotacao_destino = :id_lotacao_destino ";
        }

        if ($this->getIdDocumentoSituacao) {
            $filtro .= empty($filtro) ? " where id_documento_situacao = :id_documento_situacao " : " and id_documento_situacao = :id_documento_situacao ";
        }

        return $filtro;
    }
}