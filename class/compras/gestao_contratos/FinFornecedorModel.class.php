<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinFornecedores.class.php";

class FinFornecedoresModel {

    private $id_fornecedor = null;
    private $id_pessoa = null;
    private $id_contrato = null;
    private $id_ata = null;
    private $sit_fornecedor = null;
    private $sucesso = true;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdFornecedor() {
        return $this->id_fornecedor;
    }

    /**
     * @param mixed $id_fornecedor
     *
     * @return self
     */
    public function setIdFornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    /**
     * @param mixed $id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContrato() {
        return $this->id_contrato;
    }

    /**
     * @param mixed $id_contrato
     *
     * @return self
     */
    public function setIdContrato($id_contrato) {
        $this->id_contrato = $id_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdAta() {
        return $this->id_ata;
    }

    /**
     * @param mixed $id_ata
     *
     * @return self
     */
    public function setIdAta($id_ata) {
        $this->id_ata = $id_ata;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitFornecedor() {
        return $this->sit_fornecedor;
    }

    /**
     * @param mixed $sit_fornecedor
     *
     * @return self
     */
    public function setSitFornecedor($sit_fornecedor) {
        $this->sit_fornecedor = $sit_fornecedor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadastrarFornecedores($pdo = null) {
        try {
            $this->id_contrato = (is_numeric($this->id_contrato)) ? $this->id_contrato : null;
            $this->id_pessoa = (is_numeric($this->id_pessoa)) ? $this->id_pessoa : null;
            if (!empty($this->id_ata) || !empty($this->id_contrato) && !empty($this->id_pessoa)) {
                $daoFornecedores = new DaoFinFornecedores();
                $daoFornecedores->setIdContrato($this->id_contrato);
                $daoFornecedores->setIdPessoa($this->id_pessoa);
                $daoFornecedores->insertFornecedor($pdo);
                $daoFornecedores->setIdFornecedor($pdo->lastInsertId('fin_fornecedor_id_fornecedor_seq'));
                $this->sucesso = true;
                $this->msgRetorno = $daoFornecedores->getIdFornecedor();
                if (!Log::SalvaLogI('fin_fornecedor', $daoFornecedores->getIdFornecedor(), $pdo)) {
                    $sucesso = false;
                }
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function editarFornecedor(PDO $pdo = null) {
        try {
            $daoFornecedores = new DaoFinFornecedores();
            $daoFornecedores->setIdPessoa($this->id_pessoa);
            $daoFornecedores->setIdFornecedor($this->id_fornecedor);
            $daoFornecedores->retornaDados($pdo);
            $busca = $daoFornecedores->getMsgRetorno();
            $daoFornecedores->editarFornecedor($pdo);
            if ($daoFornecedores->getSucesso()) {
                if (!Log::SalvaLogU('fin_fornecedor', $this->id_fornecedor, $busca, $pdo)) {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    /**
     * essa funcao foi criada para retorna os dados do fin_fornecedor por id
     * @param type $pdo = conexao com o banco
     */
    public function dadosFornecedorPorId($pdo = null) {

        try {
            $this->id_fornecedor = (is_numeric($this->id_fornecedor)) ? $this->id_fornecedor : null;
            if (!empty($this->id_fornecedor)) {
                $daoFornecedores = new DaoFinFornecedores();
                $daoFornecedores->setIdFornecedor($this->id_fornecedor);
                $daoFornecedores->retornaDados($pdo);
                if ($daoFornecedores->getSucesso()) {
                    $this->sucesso = true;
                    $this->msgRetorno = $daoFornecedores->getMsgRetorno();
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = 'erro sql';
                }
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    /**
     * eu passo o id do fornecedor do contrato para descobri o fornecedor da ata 
     * @param type $pdo = conexao com o banco
     */
    public function retornaFornecedorAta($pdo = null) {
        try {
            if (!empty($this->id_fornecedor)) {
                $daoFornecedores = new DaoFinFornecedores();
                $daoFornecedores->setIdFornecedor($this->id_fornecedor);
                $daoFornecedores->retornaFornecedorAta($pdo);
                if ($daoFornecedores->getSucesso()) {
                    $this->sucesso = true;
                    $this->msgRetorno = $daoFornecedores->getMsgRetorno();
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = $daoFornecedores->getMsgRetorno();
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Id Nao informado';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    /**
     * [retornaOptionsAtaContrato essa função retorna o id do fornecedor da ata ou contrato ]
     * @param  [type] $id   [id do fornecedor]
     * @param  string $tipo [ATA; Contrato]
     * @return [type]       [Retorna um options com ata e contrato e o id do fornecedor]
     */
    public function retornaOptionsAtaContrato($id = null, $tipo = 'contrato') {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinFornecedores = new DaoFinFornecedores();
            $result = array();
            $condicao = 'and f.id_contrato is not null';

            if ($tipo == 'contrato') {
                $retorno = '<option value="">Selecionar um Contrato</option>';
            } else {
                $retorno = '<option value="">Selecionar uma ATA</option>';
                $condicao = 'and f.id_contrato is null';
            }

            //fim de variaveis
            $daoFinFornecedores->retornaAtaContrato($pdo, $condicao);

            if ($daoFinFornecedores->getSucesso()) {
                foreach ($daoFinFornecedores->getMsgRetorno() as $value) {
                    if ($value["id_fornecedor"] == $id) {
                        $retorno .= '<option value="' . $value["id_fornecedor"] . '" selected>' . $value["numero"] . '</option>';
                    } else {
                        $retorno .= '<option value="' . $value["id_fornecedor"] . '">' . $value["numero"] . '</option>';
                    }
                }
            }

            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaFornecedorPeloIdPedido($pdo = null, $pedido = null) {
        try {
            //variaveis do sistema
            //verificar ser a conexao foi passada, ser nao cria conexao
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinFornecedores = new DaoFinFornecedores();
            $daoFinFornecedores->retornaFornecedorDoPedido($pdo, $pedido);
            if ($daoFinFornecedores->getSucesso()) {
                $this->sucesso = true;
                $this->msgRetorno = $daoFinFornecedores->getMsgRetorno();
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaOptionsPessoa($id = null) {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinFornecedores = new DaoFinFornecedores();
            $daoFinFornecedores->retornaPessoa($pdo);
            $retorno = '';
            if ($daoFinFornecedores->getSucesso()) {
                foreach ($daoFinFornecedores->getMsgRetorno() as $value) {
                    if ($value["id_pessoa"] == $id) {
                        $retorno .= '<option value="' . $value["id_pessoa"] . '" selected>' . $value["nm_pessoa"] . '</option>';
                    } else {
                        $retorno .= '<option value="' . $value["id_pessoa"] . '">' . $value["nm_pessoa"] . '</option>';
                    }
                }
                return $retorno;
            }
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function optionsAtaContPorTipoGasto($id = null, $tipo = 'contrato', $tipoGasto = null) {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinFornecedores = new DaoFinFornecedores();
            $result = array();
            $condicao = "and f.id_contrato is not null AND contrato.tp_contrato = '2' AND (contrato.id_tipo_gasto = '" . $tipoGasto . "')";

            if ($tipo == 'contrato') {
                $retorno = '<option value="">Selecionar um Contrato</option>';
            } else {
                $retorno = '<option value="">Selecionar uma ATA</option>';
                $condicao = "and f.id_contrato is not null AND contrato.tp_contrato = '1' AND (contrato.id_tipo_gasto = '" . $tipoGasto . "')";
            }

            //fim de variaveis
            $daoFinFornecedores->retornaAtaContrato($pdo, $condicao);

            if ($daoFinFornecedores->getSucesso()) {
                foreach ($daoFinFornecedores->getMsgRetorno() as $value) {
                    if ($value["id_fornecedor"] == $id) {
                        $retorno .= '<option value="' . $value["id_fornecedor"] . '" selected>' . $value["numero"] . '</option>';
                    } else {
                        $retorno .= '<option value="' . $value["id_fornecedor"] . '">' . $value["numero"] . '</option>';
                    }
                }
            }

            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    
    //
    
    
    /**
     * Retorna o Id Do Fornecedor de um Contrato
     * Utilizada pois quando foi implementado a funcionalidade, não tinhamos a certeza 
     * como iriamos buscar o ID do fornecedor do contrato, pois as ATAS estavam duplicado o id do Contrato
     * na tabela de fornecedor, por isso a SQL utilizada tem limit 1 e order by asc
     * para buscar o primeiro fornecedor criado com aquele contrato    
     * @param type $pdo
     */
    public function retornaPrimeiroFornecedorDoContrato($pdo = null) {
        try {
            if (!empty($this->id_contrato)) {
                $daoFornecedores = new DaoFinFornecedores();
                $daoFornecedores->setIdContrato($this->id_contrato);
                $daoFornecedores->retornaDadosPrimeiroFornecedorContrato($pdo);
                if ($daoFornecedores->getSucesso()) {
                    $this->sucesso = true;
                    $this->msgRetorno = $daoFornecedores->getMsgRetorno();
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = $daoFornecedores->getMsgRetorno();
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Id Nao informado';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

}
