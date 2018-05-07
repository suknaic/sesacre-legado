<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/autorizacoes/FinAutorizacaoTb.class.php";

class DaoAutorizacaoPedido extends FinAutorizacoesTb {

    private $sucesso = false;
    private $msgRetorno = null;

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function sucesso() {
        return $this->sucesso;
    }

    public function insert(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "INSERT INTO fin_autorizacao (id_pedido, st_nivel, ds_autorizacao, id_pessoa) values (:pedido, :nivel, :ds, :idPessoa)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":nivel", $this->getStNivel(), PDO::PARAM_INT);
                $stmt->bindValue(":ds", $this->getDsAutorizacao(), PDO::PARAM_STR);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function updateStPedidoAutorizacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "UPDATE fin_pedido SET st_pedido = :st where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":st", $this->getStNivel(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaNivelAutorizacoes(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select p.nm_pessoa,
                        case 
                                WHEN aut.st_nivel = 0 THEN 'Cancelamento do pedido'
                                WHEN aut.st_nivel = 11 THEN 'Autorização Central'
                                WHEN aut.st_nivel = 12 THEN 'Autorização Orcamentario'
                                WHEN aut.st_nivel = 13 THEN 'Autorização Financeiro'
                                WHEN aut.st_nivel = 14 THEN 'Autorização Ordenador'
                        end as nivel,
                        aut.ds_autorizacao, aut.dt_autorizacao

                        from fin_autorizacao as aut
                        inner join ses_pessoa as p
                        on p.id_pessoa =  aut.id_pessoa
                        where aut.id_pedido = :pedido
                        order by aut.id_autorizacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
