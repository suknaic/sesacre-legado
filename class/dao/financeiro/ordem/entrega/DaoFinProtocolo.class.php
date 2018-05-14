<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinProtocoloTb.class.php";

class DaoFinProtocolo extends FinProtocoloTb {

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

    public function retornaInforLoadProtocolo(PDO $pdo) {
        try {
            if($pdo != null){
                
                $sql = "select ordem.id_ordem, ordem.nr_ordem, p.nr_pedido, centalLotacao.nm_lotacao, 
                        pFornecedor.nm_pessoa, modalidade.nm_modalidade, processo.cd_pregao as licitacao,
                        cont.dt_ini_vigencia_contrato, cont.dt_fim_vigencia_contrato, emp.nr_empenho,
                        tpEmpenho.nm_tipo_empenho, emp.id_tipo_empenho, tpGasto.nm_tipo_gasto
                        from fin_ordem as ordem
                        inner join fin_pedido as p
                        on p.id_pedido = ordem.id_pedido
                        inner join pla_tipo_gasto as tpGasto
                        on tpGasto.id_tipo_gasto  = p.id_tipo_gasto
                        inner join fin_empenho as emp
                        on emp.id_pedido = p.id_pedido
                        inner join fin_tipo_empenho as tpEmpenho
                        on tpEmpenho.id_tipo_empenho = emp.id_tipo_empenho
                        inner join ses_lotacao as centalLotacao
                        on centalLotacao.id_lotacao = p.id_lotacao
                        inner join fin_fornecedor as f
                        on f.id_fornecedor = p.id_fornecedor
                        inner join ses_pessoa as pFornecedor
                        on pFornecedor.id_pessoa  = f.id_fornecedor
                        inner join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato
                        inner join gco_processo as processo
                        on processo.id_processo = cont.id_processo
                        inner join gco_modalidade as modalidade
                        on modalidade.id_modalidade = processo.id_modalidade
                        where p.st_pedido > '0' 
                        and ordem.sit_ordem > '0'
                        and ordem.id_ordem  = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                 if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }else{
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
            
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
