<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinFornecedoresTb.class.php";

class DaoFinFornecedores extends FinFornecedoresTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getSucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function insertFornecedor($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_fornecedor (id_contrato, id_pessoa) values (:idContrato, :idPessoa)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    public function editarFornecedor($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "update fin_fornecedor set id_pessoa = :idPessoa where id_fornecedor = :idFornecedor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }
    
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM fin_fornecedor WHERE id_fornecedor = :idFornecedor");
            $result->bindValue(":idFornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
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

    public function retornaDados($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "SELECT * FROM fin_fornecedor WHERE id_fornecedor = :fornecedor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

    public function retornaFornecedorAta($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "SELECT f.id_fornecedor 
                        FROM fin_fornecedor as f
                        where f.id_contrato  = (SELECT subCont.id_contrato_alt 
                                                FROM fin_fornecedor as subF
						inner join fin_contrato as subCont
						on subCont.id_contrato  = subF.id_contrato
						where subCont.id_contrato_alt is not null
						and subF.id_fornecedor = :ata )
                        and f.sit_fornecedor = '1'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ata", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

    public function retornaAtaContrato($pdo = null, $condicao = '') {
        if (!empty($pdo) && !empty($condicao)) {
            try {
                $sql = "select f.id_fornecedor, concat(concat(concat(concat(contrato.nr_contrato,'/'),to_char(contrato.dt_publicacao,'yyyy')), '-'), obsC.nm_objeto) as numero
                        from fin_fornecedor as f
                        inner join fin_contrato as contrato
                        on contrato.id_contrato = f.id_contrato
                        inner join gco_processo as gconC
                        on gconC.id_processo = contrato.id_processo
                        inner join gco_objeto as obsC
                        on obsC.id_objeto = gconC.id_objeto
                        inner join fin_vigencia as vigCont
                        on vigCont.id_contrato = f.id_contrato where contrato.st_ativo ='1' " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

    public function retornaFornecedorDoPedido($pdo = null, $pedido = null) {
        if (!empty($pdo) && !empty($pedido)) {
            try {
                $sql = "select f.* from fin_pedido as p
						inner join fin_fornecedor as f
						on p.id_fornecedor = f.id_fornecedor
						where p.id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $pedido, PDO::PARAM_INT);
                $stmt->execute();
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        } else {
            $this->msgRetorno = 'Sem conexão';
        }
    }

    public function retornaPessoa($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "select * from ses_pessoa";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }
    
    
    /**
     * Retorna o Id Do Fornecedor de um Contrato
     * Utilizada pois quando foi implementado a funcionalidade, não tinhamos a certeza 
     * como iriamos buscar o ID do fornecedor do contrato, pois as ATAS estavam duplicado o id do Contrato
     * na tabela de fornecedor, por isso a SQL utilizada tem limit 1 e order by asc
     * para buscar o primeiro fornecedor criado com aquele contrato  
     * @param type $pdo
     */
    public function retornaDadosPrimeiroFornecedorContrato($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "SELECT id_fornecedor, id_pessoa, id_contrato, sit_fornecedor"
                    . " FROM fin_fornecedor"
                    . " WHERE id_contrato = :idContrato"
                    . " ORDER BY id_fornecedor ASC"
                    . " LIMIT 1";                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

}
