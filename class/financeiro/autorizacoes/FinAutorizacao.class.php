<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/autorizacoes/DaoAutorizacaoPedido.class.php";

class FinAutorizacao {

    private $id_autorizacao = null;
    private $id_pedido = null;
    private $st_nivel = null;
    private $dt_autorizacao = null;
    private $ds_autorizacao = null;
    private $id_pessoa = null;

    /**
     * @return mixed
     */
    public function getIdAutorizacao() {
        return $this->id_autorizacao;
    }

    /**
     * @param mixed $id_autorizacao
     *
     * @return self
     */
    public function setIdAutorizacao($id_autorizacao) {
        $this->id_autorizacao = $id_autorizacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPedido() {
        return $this->id_pedido;
    }

    /**
     * @param mixed $id_pedido
     *
     * @return self
     */
    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStNivel() {
        return $this->st_nivel;
    }

    /**
     * @param mixed $st_nivel
     *
     * @return self
     */
    public function setStNivel($st_nivel) {
        $this->st_nivel = $st_nivel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtAutorizacao() {
        return $this->dt_autorizacao;
    }

    /**
     * @param mixed $dt_autorizacao
     *
     * @return self
     */
    public function setDtAutorizacao($dt_autorizacao) {
        $this->dt_autorizacao = $dt_autorizacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsAutorizacao() {
        return $this->ds_autorizacao;
    }

    /**
     * @param mixed $ds_autorizacao
     *
     * @return self
     */
    public function setDsAutorizacao($ds_autorizacao) {
        $this->ds_autorizacao = $ds_autorizacao;

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

    public function salvaAutorizacaoPedido() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pdo->beginTransaction();
        $daoAutorizacaoPedido = new DaoAutorizacaoPedido;
        $daoAutorizacaoPedido->setIdPessoa($this->id_pessoa);
        $daoAutorizacaoPedido->setIdPedido($this->id_pedido);
        $daoAutorizacaoPedido->setStNivel($this->st_nivel);
        $daoAutorizacaoPedido->setDsAutorizacao($this->ds_autorizacao);
        $daoAutorizacaoPedido->insert($pdo);
       
        if (!$daoAutorizacaoPedido->sucesso()) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro na autorização1");
        }
        $this->id_autorizacao = (is_numeric($pdo->lastInsertId('fin_autorizacao_id_autorizacao_seq'))) ? $pdo->lastInsertId('fin_autorizacao_id_autorizacao_seq') : null;
        //log do insert da autorizacao
        
        if (!Log::SalvaLogI('fin_autorizacao', $this->id_autorizacao, $pdo)) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro log");
        }

        if ($daoAutorizacaoPedido->sucesso()) {
            $daoAutorizacaoPedido->setStNivel($this->st_nivel + 1);
            $daoAutorizacaoPedido->updateStPedidoAutorizacao($pdo);
        } else {
            return Metodos::retornoAjax("Erro", "alert", "Erro na autorização2");
        }

        if ($daoAutorizacaoPedido->sucesso()) {
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Pedido autorizado com sucesso.");
        } else {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro na autorização3");
        }
        unset($conexao);
        unset($pdo);
    }
    
        public function cancelarAutorizacaoPedido() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pdo->beginTransaction();
        $daoAutorizacaoPedido = new DaoAutorizacaoPedido;
        $daoAutorizacaoPedido->setIdPessoa($this->id_pessoa);
        $daoAutorizacaoPedido->setIdPedido($this->id_pedido);
        $daoAutorizacaoPedido->setStNivel(0);
        $daoAutorizacaoPedido->setDsAutorizacao($this->ds_autorizacao);
        $daoAutorizacaoPedido->insert($pdo);
       
        if (!$daoAutorizacaoPedido->sucesso()) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro na autorização1");
        }
        $this->id_autorizacao = (is_numeric($pdo->lastInsertId('fin_autorizacao_id_autorizacao_seq'))) ? $pdo->lastInsertId('fin_autorizacao_id_autorizacao_seq') : null;
        //log do insert da autorizacao
        
        if (!Log::SalvaLogI('fin_autorizacao', $this->id_autorizacao, $pdo)) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro log");
        }

        if ($daoAutorizacaoPedido->sucesso()) {
            $daoAutorizacaoPedido->setStNivel(0);
            $daoAutorizacaoPedido->updateStPedidoAutorizacao($pdo);
        } else {
            return Metodos::retornoAjax("Erro", "alert", "Erro na autorização2");
        }

        if ($daoAutorizacaoPedido->sucesso()) {
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Pedido cancelado com sucesso.");
        } else {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro na autorização3");
        }
        unset($conexao);
        unset($pdo);
    }

    public function retornaHistoricoAutorizacoes() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoAutorizacaoPedido = new DaoAutorizacaoPedido;
        $daoAutorizacaoPedido->setIdPedido($this->id_pedido);
        $daoAutorizacaoPedido->retornaNivelAutorizacoes($pdo);
        $table = '';
        if ($daoAutorizacaoPedido->sucesso()) {
            foreach ($daoAutorizacaoPedido->getMsgRetorno() as $dados) {
                $table .= '
                         <table class="table table-bordered" cellspacing="0" width="100%">
                           <tr>
                              <th colspan="4">' . $dados["nivel"] . '</th>
                           </tr>
                           <tr>
                              <td><strong>Nome</strong></td>
                              <td>' . $dados["nm_pessoa"] . '</td>
                              <td><strong>Data</strong></td>
                              <td>' . Metodos::obterDataBRTimestamp($dados["dt_autorizacao"]) . ' as ' . Metodos::obterHoraTimestamp($dados["dt_autorizacao"]) . '</td>
                           </tr>
                           <tr>
                              <td><strong>Despacho</strong></td>
                              <td colspan="3">' . $dados["ds_autorizacao"] . '</td>
                           </tr>
                         </table><br/>';
            }
        }
        return $table;
    }
}
