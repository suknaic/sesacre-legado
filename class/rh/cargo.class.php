<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesCargo.class.php";

class Cargo {

    private $id_cargo = null;
    private $nm_cargo = null;
    private $st_ativo = null;

//*******************************************************************************
    function getId_cargo() {
        return $this->id_cargo;
    }

    function getNm_cargo() {
        return $this->nm_cargo;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function setNm_cargo($nm_cargo) {
        $this->nm_cargo = $nm_cargo;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

//*******************************************************************************
    public function cadastrarCargo() {
        try {

            if (empty($this->nm_cargo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cargo = new DaoSesCargo();

            $cargo->setNm_cargo($this->nm_cargo);

            $busca = $cargo->buscaCargoPorNome($pdo);

            if (!$busca) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_REGISTRO_EXISTE);
                $pdo->rollBack();
                return $retorno;
            }
            $result = $cargo->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $cargo->setId_cargo($pdo->lastInsertId('ses_cargo_id_cargo_seq'));

            if (Log::SalvaLogI('ses_cargo', $cargo->getId_cargo(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarCargo() {
        try {
            if ($this->nm_cargo == "" || $this->id_cargo == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cargo = new DaoSesCargo();

            $cargo->setId_cargo($this->id_cargo);
            $cargo->setNm_cargo($this->nm_cargo);
            $buscaCargoNome = $cargo->buscaCargoPorNome($pdo);

            if (!$buscaCargoNome) {
                //return $retorno;            
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Cargo já existe no sistema.");
                $pdo->rollBack();
                return $retorno;
            }

            $busca = $cargo->retornaCargo($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $cargo->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('ses_cargo', $cargo->getId_cargo(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerCargo() {
        try {
            if (empty($this->id_cargo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cargo = new DaoSesCargo();
            $cargo->setId_cargo($this->id_cargo);

            $busca = $cargo->retornaCargo($pdo);
            if (!$busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_cargo', $this->id_cargo, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $result = $cargo->delete($pdo);
            if ($result === TRUE) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi Possível Realizar a Exclusão dessa Escolaridade. Este registro está Vinculado a uma Pessoa.");
            }
            
            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function desativarCargo() {
        try {
            if (empty($this->id_cargo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cargo = new DaoSesCargo();
            $cargo->setId_cargo($this->id_cargo);

            $busca = $cargo->retornaCargo($pdo);
            if (!$busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_cargo', $this->id_cargo, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $result = $cargo->desativa($pdo);
            if ($result) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $result);
            }
            
            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    public function ativarCargo() {
        try {
            if (empty($this->id_cargo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $cargo = new DaoSesCargo();
            $cargo->setId_cargo($this->id_cargo);

            $busca = $cargo->retornaCargo($pdo);
            if (!$busca) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_NAO_ENCONTRADO);
            }

            if (!Log::SalvaLogU('ses_cargo', $this->id_cargo, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $result = $cargo->ativa($pdo);
            if ($result) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $result);
            }
            
            return Metodos::retornoAjax("Erro", "console", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrCargo() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cargo = new DaoSesCargo();

            $result = $cargo->retornaCargos($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $idCargo = $v['id_cargo'];
                    $retorno .= '<tr>
                                    <td>' . $v['nm_cargo'] . '</td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" nome="' . $v['nm_cargo'] . '" value=' . $idCargo . ' >
                                            <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                                        </button> 
                                        <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $idCargo . ' >
                                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                                        </button>';
                    if ($v['st_ativo'] == '0') {
                        $retorno .= "    <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_cargo'] . "' value='" . $idCargo . "' >
                                            <i class='ion-checkmark-round text-success' aria-hidden='true'></i>                                
                                        </button>";
                    } else {
                        $retorno .= "    <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_cargo'] . "' value='" . $idCargo . "' >
                                            <i class='ion-close-round text-danger' aria-hidden='true'></i>                                
                                        </button>";
                    }
                    $retorno .= "   </td>
                                 </tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionCargo($id) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $cargo = new DaoSesCargo();
            $result = $cargo->retornaCargos($pdo);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    if ($v['st_ativo'] == '1') {
                        if ($v['id_cargo'] == $id) {
                            $retorno .= "<option selected value = '" . $v['id_cargo'] . "'>" . $v['nm_cargo'] . "</option>";
                        } else {
                            $retorno .= "<option value = '" . $v['id_cargo'] . "'>" . $v['nm_cargo'] . "</option>";
                        }
                    }
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
