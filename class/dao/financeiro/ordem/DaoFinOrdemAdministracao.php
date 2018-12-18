<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinOrdemAdministracaoTb.class.php";

class DaoFinOrdemAdministracao extends FinOrdemAdministracaoTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function reativarOrdem(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $sql = "insert into fin_ordem_administracao (id_ordem, id_protocolo, id_solicitante, id_lotacao_solicitante, tp_administracao, st_ordem_administracao)
                    values (:ordem, :protocolo, :id_pessoa, :lotacao, :tp, :status)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdSolicitante(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacaoSolicitante(), PDO::PARAM_INT);
                $stmt->bindValue(":tp", $this->getTpAdministracao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", 1, PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function autorizacaoReativacaoOrdem(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $sql = "update fin_ordem_administracao set id_autorizado = :pessoa, id_lotacao_autorizado = :lotacao, dt_autorizacao =  now(), st_ordem_administracao = :status
                        where id_ordem_administracao = :idOrdemAdm";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pessoa", $this->getIdAutorizado(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacaoAutorizado(), PDO::PARAM_INT);
                $stmt->bindValue(":status", 2, PDO::PARAM_INT);
                 $stmt->bindValue(":idOrdemAdm", $this->getIdOrdemAdministracao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDataAtual(PDO $pdo){
        
    }

    public function alterarSituacaoOrdem(PDO $pdo, int $status = null) {
        try {
            $this->sucesso = false;
            if (!empty($pdo) && !empty($status)) {
                $sql = "update fin_ordem set sit_ordem = :situacao where id_ordem = :ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":situacao", $status, PDO::PARAM_INT);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
        }
    }

    public function retornaReativacaoAdministracaoOrdem(PDO $pdo, array $condicoes = []) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {

                $strQuery = "";
                if (!empty($condicoes)) {
                    foreach ($condicoes as $condicao) {
                        $filtro[] = $condicao['sql'];
                    }
                    $strQuery = " where " . implode(" and ", $filtro);
                }

                $sql = "select ordem.id_ordem, ordem.nr_ordem, ordem.aa_ordem, pedido.id_pedido, admOrdem.id_ordem_administracao,
                        concat(concat(pedido.nr_pedido,'/'),to_char(pedido.dt_pedido,'YYYY')) as pedido,
                        empenho.nr_empenho,
                        case 
                                when pj.nr_cnpj is not null then concat(concat(pj.nr_cnpj,'/'),pessoa.nm_pessoa)
                                when pf.nr_cpf is not null then  concat(concat(pf.nr_cpf,'/'),pessoa.nm_pessoa)
                        end as fornecedor, 
                        case 
                                when ordem.tp_ordem = '1' then 'Entrega'
                                when ordem.tp_ordem = '2' then 'Execução/Serviço'
                        end tipo_ordem,
                        to_char(ordem.dh_ordem, 'DD/MM/YYYY') as data_emissao, tp.nm_tipo_gasto, lotacao.nm_lotacao, valor.valor,
                        case 
                                when admOrdem.st_ordem_administracao = '1' then 'Cadastrado'
                                when admOrdem.st_ordem_administracao = '2' then 'Deferido'
                                when admOrdem.st_ordem_administracao = '3' then 'Indeferido'
                                when admOrdem.st_ordem_administracao = '4' then 'Cancelado'
                        end situacao, admOrdem.st_ordem_administracao
                        from fin_ordem_administracao as admOrdem
                        inner join fin_ordem as ordem
                        on ordem.id_ordem = admOrdem.id_ordem
                        inner join (select sum(qt_itens_ordem * vl_itens_ordem) as valor, id_ordem
                                    from fin_ordem_itens 
                                    group by id_ordem
                                   ) as valor
                        on valor.id_ordem = ordem.id_ordem
                        inner join fin_pedido as pedido 
                        on pedido.id_pedido = ordem.id_pedido
                        inner join fin_empenho as empenho 
                        on empenho.id_pedido = pedido.id_pedido
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = pedido.id_tipo_gasto
                        inner join ses_lotacao as lotacao
                        on lotacao.id_lotacao = pedido.id_lotacao
                        inner join fin_fornecedor as fornecedor
                        on fornecedor.id_fornecedor = pedido.id_fornecedor
                        inner join ses_pessoa as pessoa
                        on pessoa.id_pessoa = fornecedor.id_pessoa
                        left join ses_pessoa_fisica as pf
                        on pf.id_pessoa = pessoa.id_pessoa
                        left join ses_pessoa_juridica as pj
                        on pj.id_pessoa = pessoa.id_pessoa";

                $stmt = $pdo->prepare($sql);

                if (!empty($condicoes)) {
                    foreach ($condicoes as $condicao) {
                        $stmt->bindValue($condicao['bind'], $condicao['valor'], $condicao['pdo_param']);
                    }
                }

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaDadosReativacaoOrdem(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $sql = "select ordem.id_ordem, pedido.id_pedido, pedido.nr_pedido
                        from fin_ordem_administracao as admin 
                        inner join fin_ordem as ordem
                        on ordem.id_ordem = admin.id_ordem
                        inner join fin_pedido as pedido
                        on pedido.id_pedido = ordem.id_pedido
                        where id_ordem_administracao = :idAdminOrdem ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idAdminOrdem", $this->getIdOrdemAdministracao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
