<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinEntregaDocumento.class.php";

class FinEntregaDocumento {

    private $id_entrega_documento = null;
    private $id_documento_fiscal = null;
    private $id_entrega_confirmacao = null;
    private $vl_entrega_documento = null;
    private $vl_entrega_saldo = null;
    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdEntregaDocumento() {
        return $this->id_entrega_documento;
    }

    /**
     * @param mixed $id_entrega_documento
     *
     * @return self
     */
    public function setIdEntregaDocumento($id_entrega_documento) {
        $this->id_entrega_documento = $id_entrega_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    /**
     * @param mixed $id_documento_fiscal
     *
     * @return self
     */
    public function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdEntregaConfirmacao() {
        return $this->id_entrega_confirmacao;
    }

    /**
     * @param mixed $id_entrega_confirmacao
     *
     * @return self
     */
    public function setIdEntregaConfirmacao($id_entrega_confirmacao) {
        $this->id_entrega_confirmacao = $id_entrega_confirmacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlEntregaDocumento() {
        return $this->vl_entrega_documento;
    }

    /**
     * @param mixed $vl_entrega_documento
     *
     * @return self
     */
    public function setVlEntregaDocumento($vl_entrega_documento) {
        $this->vl_entrega_documento = $vl_entrega_documento;

        return $this;
    }
    
    function getVlEntregaSaldo() {
        return $this->vl_entrega_saldo;
    }

    function setVlEntregaSaldo($vl_entrega_saldo) {
        $this->vl_entrega_saldo = $vl_entrega_saldo;
        return $this;
    }

    
    /**
     * @return mixed
     */
    public function getSucesso() {
        return $this->sucesso;
    }

    /**
     * @param mixed $sucesso
     *
     * @return self
     */
    public function setSucesso($sucesso) {
        $this->sucesso = $sucesso;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * @param mixed $msgRetorno
     *
     * @return self
     */
    public function setMsgRetorno($msgRetorno) {
        $this->msgRetorno = $msgRetorno;

        return $this;
    }

    public function cadastrarEntregaDocumento(PDO $pdo) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinEntregaDocumento = new DaoFinEntregaDocumento();
        $daoFinEntregaDocumento->setIdDocumentoFiscal($this->id_documento_fiscal);
        $daoFinEntregaDocumento->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
//        $daoFinEntregaDocumento->setVlEntregaDocumento(Metodos::ConverteValorIng($this->vl_entrega_documento));
//        $daoFinEntregaDocumento->setVlEntregaSaldo(Metodos::ConverteValorIng($this->vl_entrega_saldo));
        
        //OS VALORES DO DOCUMENTO E DO SALDO JÁ ESTÃO EM FORMATO INGLÊS
        $daoFinEntregaDocumento->setVlEntregaDocumento($this->vl_entrega_documento);
        $daoFinEntregaDocumento->setVlEntregaSaldo($this->vl_entrega_saldo);
        
        $daoFinEntregaDocumento->insertEntregaDocumento($pdo);
        //log do pedido de necessidade
        $daoFinEntregaDocumento->setIdEntregaDocumento($pdo->lastInsertId('fin_entrega_documento_id_entrega_documento_seq'));

        if (!Log::SalvaLogI('fin_entrega_documento', $daoFinEntregaDocumento->getIdEntregaConfirmacao(), $pdo)) {
            return false;
        }

        if (!$daoFinEntregaDocumento->sucesso()) {
            return false;
        }

        return true;
    }
    
    public function atualizaEntregaDocumento(PDO $pdo){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoFinEntregaDocumento = new DaoFinEntregaDocumento();
            $daoFinEntregaDocumento->setIdEntregaDocumento($this->id_entrega_documento);
            $daoFinEntregaDocumento->setVlEntregaDocumento($this->vl_entrega_documento);
            $daoFinEntregaDocumento->setVlEntregaSaldo($this->vl_entrega_saldo);
            
            $daoFinEntregaDocumento->retorna($pdo);
            if (!$daoFinEntregaDocumento->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = "Erro ao localizar o registro na tabela fin_entrega_documento ";
                return false;
            }
            
            $reg_antigo = $daoFinEntregaDocumento->getMsgRetorno();
            
            $daoFinEntregaDocumento->atualiza($pdo);
            if ($daoFinEntregaDocumento->sucesso()) {
                if (!Log::SalvaLogU('fin_entrega_documento', $daoFinEntregaDocumento->getIdEntregaDocumento(), $reg_antigo, $pdo)) {
                    $this->sucesso = false;
                    $this->msgRetorno = 'Erro no Log para atualizar Entrega Documento';
                    return false;
                }
                
                $this->sucesso = true;
                $this->msgRetorno = "Atualizado com Sucesso";
                return true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEntregaDocumento->getMsgRetorno();
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function removerEntregaDocumento(PDO $pdo = null) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaDocumento = new DaoFinEntregaDocumento();
            $daoFinEntregaDocumento->setIdEntregaDocumento($this->id_entrega_documento);

            if (!Log::SalvaLogD('fin_entrega_documento', $daoFinEntregaDocumento->getIdEntregaDocumento(), $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Erro no Log para remover Entrega Documento";
                return true;
            }

            $daoFinEntregaDocumento->remove($pdo);
            if (!$daoFinEntregaDocumento->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEntregaDocumento->getMsgRetorno();
                return true;
            }

            $this->sucesso = true;
            $this->msgRetorno = "Removido com Sucesso";
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTodosDocumentoFiscal(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdDocumentoFiscal($this->id_documento_fiscal);
            $dao->retornaPorDocumentoFiscal($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retorna(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdEntregaDocumento($this->id_entrega_documento);
            $dao->retorna($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaSaldoEntregas(PDO $pdo = null) {
        try {
            
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $dao->retornaSaldoEntregas($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaSaldoEntregaAtualizacao(PDO $pdo = null){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $dao->setIdDocumentoFiscal($this->id_documento_fiscal);
            $dao->retornaSaldoEntregaAtualizacao($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaTabelaEntregaGdofEdicao(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $tabela = '';
            $daoFinEntregaDocumento = new DaoFinEntregaDocumento();
            $daoFinEntregaDocumento->setIdDocumentoFiscal($this->id_documento_fiscal);
            $daoFinEntregaDocumento->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaDocumento->retornaEntregaGdofEdicao($pdo);
            
            if ($daoFinEntregaDocumento->sucesso()) {
                foreach ($daoFinEntregaDocumento->getMsgRetorno() as $key => $campos) {
                    
                    $saldo = $campos["saldo"] + $campos['vl_entrega_documento'];
                    
                    $tabela .= '<tr id= "ent' . $campos["id_entrega_confirmacao"] . '" ordem = "' . $campos["id_ordem"] . '" class = "trEntregas" idEntrega = "' . $campos["id_entrega_confirmacao"] . '" data-id="'.$campos['id_entrega_documento'].'" data-saldo="'.$saldo.'">
                                 <td class = "text-center">' . $campos["nr_entrega_confirmacao"] . '</td>
                                 <td class = "text-center">' . $campos["ordem"] . '</td>
                                 <td class = "text-center">' . $campos["dataaviso"] . '</td>
                                 <td class = "text-center">' . $campos["datalimite"] . '</td>
                                 <td class = "text-center">' . $campos["nr_prazo_ordem"] . '</td>
                                 <td class = "text-center">' . $campos["entreguedia"] . '</td>
                                 <td class = "text-center">' . Metodos::ConverteValorBr($campos["valor"], 4) . '</td>
                                 <td class = "text-center">' . Metodos::ConverteValorBr($saldo, 4) . '</td>
                                 <td class = "text-center" valorRetirado">
                                    <input class="form-control valorRetEntrega" type="text" name="valorRetEntrega[]" id="valorRetEntrega[]"  value="0,0000"/>
                                </td>
                                <td class = "text-center">' . $campos["situacao"] . '</td>
                                <td class = "text-center">
                                   <button type="button" title="Excluir ordem" class="excluirEntrega text-danger" value="' . $campos["id_entrega_confirmacao"] . '">
                                       <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>';
                    }
                }

            return $tabela;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
