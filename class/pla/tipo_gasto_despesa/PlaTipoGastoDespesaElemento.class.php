<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaTipoGastoDespesaElemento.class.php";

class PlatipoGastoDespesaElemento {

    private $id_tipo_gasto_despesa_elemento = null;
    private $id_tipo_gasto = null;
    private $id_despesa_elemento = null;
    private $st_ativo = null;

    /**
     * @return mixed
     */
    public function getIdTipoGastoDespesaElemento() {
        return $this->id_tipo_gasto_despesa_elemento;
    }

    /**
     * @param mixed $id_tipo_gasto_despesa_elemento
     *
     * @return self
     */
    public function setIdTipoGastoDespesaElemento($id_tipo_gasto_despesa_elemento) {
        $this->id_tipo_gasto_despesa_elemento = $id_tipo_gasto_despesa_elemento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTipoGasto() {
        return $this->id_tipo_gasto;
    }

    /**
     * @param mixed $id_tipo_gasto
     *
     * @return self
     */
    public function setIdTipoGasto($id_tipo_gasto) {
        $this->id_tipo_gasto = $id_tipo_gasto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDespesaElemento() {
        return $this->id_despesa_elemento;
    }

    /**
     * @param mixed $id_despesa_elemento
     *
     * @return self
     */
    public function setIdDespesaElemento($id_despesa_elemento) {
        $this->id_despesa_elemento = $id_despesa_elemento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStAtivo() {
        return $this->st_ativo;
    }

    /**
     * @param mixed $st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;

        return $this;
    }

    public function salvaTipoGastoDespesaElemento() {

        if (empty($this->id_tipo_gasto) || empty($this->id_despesa_elemento)) {
            return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
        }
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pdo->beginTransaction();

        $DaoPlaTipoGastoDespesaElemento = new DaoPlaTipoGastoDespesaElemento();
        $DaoPlaTipoGastoDespesaElemento->setIdTipoGasto($this->id_tipo_gasto);
        $DaoPlaTipoGastoDespesaElemento->setIdDespesaElemento($this->id_despesa_elemento);
        $DaoPlaTipoGastoDespesaElemento->insert($pdo);

        if ($DaoPlaTipoGastoDespesaElemento->sucesso()) {
            $retorno = $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Cadastro realizado com sucesso.");
        } else {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        }
    }

    public function trTipoGastoDespesaElemento() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoPlaTipoGastoDespesaElemento = new DaoPlaTipoGastoDespesaElemento();
        $daoPlaTipoGastoDespesaElemento->listaPlaTipoDespesaelemento($pdo);
        $tabela = '';
        if ($daoPlaTipoGastoDespesaElemento->sucesso()) {
            foreach ($daoPlaTipoGastoDespesaElemento->getMsgRetorno() as $linha) {
                $tabela .= '<tr>
                                <td class = "text-center">' . $linha["nm_tipo_gasto"] . '</td>
                                <td class = "text-center">' . $linha["cd_despesa_elemento"] . ' - ' . $linha["ds_despesa_elemento"] . '</td>
                                <td class = "text-center">
                                   <button type = "button" title = "editar" class = "editar" value = "' . $linha['id_tipo_gasto_despesa_elemento'] . '">
                                   <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i></i>
                                   </button >

                                   <button type="button" title="Excluir ordem" class="excluir text-danger" value="' . $linha['id_tipo_gasto_despesa_elemento'] . '" >
                                   <i class="fa fa-trash" aria-hidden="true"></i>
                                   </button> 
                                </td>    
                            </tr>';
            }
        } else {
            $tabela = 'Nenhum registro encontrado';
        }
        return $tabela;
    }

}
