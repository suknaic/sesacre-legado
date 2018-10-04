<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinTipoDocumento.class.php";

class FinTipoDocumento {

    private $id_tipo_documento = null;
    private $nm_tipo_documento = null;
    private $st_ativo = null;
    /**
     * @return mixed
     */
    public function getIdTipoDocumento() {
        return $this->id_tipo_documento;
    }

    /**
     * @param mixed $id_tipo_documento
     *
     * @return self
     */
    public function setIdTipoDocumento($id_tipo_documento) {
        $this->id_tipo_documento = $id_tipo_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmTipoDocumento() {
        return $this->nm_tipo_documento;
    }

    /**
     * @param mixed $nm_tipo_documento
     *
     * @return self
     */
    public function setNmTipoDocumento($nm_tipo_documento) {
        $this->nm_tipo_documento = $nm_tipo_documento;

        return $this;
    }
    
    function getStAtivo() {
        return $this->st_ativo;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }
    
    public static function retornaOptionsTipoDocumento($id = 0) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinTipoDocumento = new DaoFinTipoDocumento();
        $daoFinTipoDocumento->retornaTipoDocumento($pdo);
        $options = '';
        if ($daoFinTipoDocumento->sucesso()) {
            foreach ($daoFinTipoDocumento->getMsgRetorno() as $valores) {
                if ($valores['st_ativo'] == '1') { //Ativos
                    if ($id == $valores["id_tipo_documento"]) {
                        $options .= '<option value="' . $valores["id_tipo_documento"] . '" selected>' . $valores["nm_tipo_documento"] . '</option>';
                    } else {
                        $options .= '<option value="' . $valores["id_tipo_documento"] . '">' . $valores["nm_tipo_documento"] . '</option>';
                    }
                }
            }
        }
        return $options;
    }
    
    function listaTodos() {
        try {
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinTipoDocumento = new DaoFinTipoDocumento();
            $daoFinTipoDocumento->retornaTodos($pdo);
            
            if ($daoFinTipoDocumento->sucesso()) {
                foreach ($daoFinTipoDocumento->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-objeto='". json_encode($linha,JSON_HEX_APOS)."'>"
                                    . "<td>".$linha['nm_tipo_documento']."</td>";
                    
                    if($linha['st_ativo'] == '1'){
                        $retorno .=  "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-alterar' title='Editar'><i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden=true></i></button>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-excluir' title='Excluir'><i class='fa fa-trash fa-lg text-danger' aria-hidden=true></i></button>"
                                    . "</td>";
                    } else {
                        $retorno .=  "<td class='text-center'>"
                                        . "<button type='button' class='btn btn-default btn-xs btn-ativar' title='Ativar'><i class='fa fa-check fa-lg text-success' aria-hidden=true></i></button>"
                                    . "</td>";
                    }
                    $retorno .= "</tr>";
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    public function cadastrar(){
        try {  
            
            if (empty($this->getNmTipoDocumento())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoFinTipoDocumento = new DaoFinTipoDocumento();
            $daoFinTipoDocumento->setNmTipoDocumento($this->getNmTipoDocumento());
            $daoFinTipoDocumento->insert($pdo);
            
            if ($daoFinTipoDocumento->sucesso()) {
                $idTipoDocumento = $pdo->lastInsertId('fin_tipo_documento_id_tipo_documento_seq');
                if (!Log::SalvaLogI('fin_tipo_documento', $idTipoDocumento, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $this->setIdTipoDocumento($idTipoDocumento);

                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinTipoDocumento->getMsgRetorno());
            }
            return $retorno;                                                                                                        
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    function alterar(){
        try {
            
            if (empty($this->getNmTipoDocumento())){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $retorno = "";

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinTipoDocumento = new DaoFinTipoDocumento();
            $daoFinTipoDocumento->setIdTipoDocumento($this->getIdTipoDocumento());
            $daoFinTipoDocumento->setNmTipoDocumento($this->getNmTipoDocumento());
           

            //Retorna os dados antes da alteração
            $daoFinTipoDocumento->retorna($pdo);

            if (!$daoFinTipoDocumento->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinTipoDocumento->getMsgRetorno());
            }
            
            //Se não der erro na seleção do registro do decreto valor, atribui à variável
            $reg_antigo = $daoFinTipoDocumento->getMsgRetorno();
            
            $daoFinTipoDocumento->update($pdo);

            if ($daoFinTipoDocumento->getSucesso()) {

                //Registra no log
                if (!Log::SalvaLogU('fin_tipo_documento', $daoFinTipoDocumento->getIdTipoDocumento(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinTipoDocumento->getMsgRetorno());
            }

            return $retorno;

        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }
    
    function desativar(){
        try {
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinTipoDocumento = new DaoFinTipoDocumento();
            $daoFinTipoDocumento->setIdTipoDocumento($this->getIdTipoDocumento());

            //Retorna os dados antes da alteração
            $daoFinTipoDocumento->retorna($pdo);

            if (!$daoFinTipoDocumento->sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoFinTipoDocumento->getMsgRetorno());
            }
            
            //Se não der erro na seleção do registro do decreto valor, atribui à variável
            $reg_antigo = $daoFinTipoDocumento->getMsgRetorno();
            
            $daoFinTipoDocumento->desativa($pdo);

            if ($daoFinTipoDocumento->sucesso()) {

                //Registra no log
                if (!Log::SalvaLogU('fin_tipo_documento', $daoFinTipoDocumento->getIdTipoDocumento(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                $pdo->commit();
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", $daoFinTipoDocumento->getMsgRetorno());
            }

            return $retorno;

        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

}
