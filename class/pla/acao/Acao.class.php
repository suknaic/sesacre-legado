<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaAcao.class.php";

class Acao {

    private $idAcao = null;
    private $idObjetivo = null;
    private $nmAcao = null;
    private $dsIndicador = null;
    private $dsMetaPlano = null;
    private $tpCadastro = null;
    private $idLotacao = null;

    function getDsMetaPlano() {
        return $this->dsMetaPlano;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setDsMetaPlano($dsMetaPlano) {
        $this->dsMetaPlano = $dsMetaPlano;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }
    
    function getIdAcao() {
        return $this->idAcao;
    }

    function getIdObjetivo() {
        return $this->idObjetivo;
    }

    function getNmAcao() {
        return $this->nmAcao;
    }

    function getDsIndicador() {
        return $this->dsIndicador;
    }

    function getTpCadastro() {
        return $this->tpCadastro;
    }

    function setIdAcao($idAcao) {
        $this->idAcao = $idAcao;
    }

    function setIdObjetivo($idObjetivo) {
        $this->idObjetivo = $idObjetivo;
    }

    function setNmAcao($nmAcao) {
        $this->nmAcao = $nmAcao;
    }

    function setDsIndicador($dsIndicador) {
        $this->dsIndicador = $dsIndicador;
    }
   
    function setTpCadastro($tpCadastro) {
        $this->tpCadastro = $tpCadastro;
    }

    function pegaCadastro($tpCadastro) {
        $array = array(
            "P" => "Planejamento",
            "U" => "Unidade"
        );
        if (array_key_exists($tpCadastro, $array)) {
            return $array[$tpCadastro];
        } else {
            return "";
        }
    }

    public function cadastrarAcao() {
        try {
            if ($this->nmAcao == "" || $this->idObjetivo == "" || $this->tpCadastro == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            if($this->idLotacao == "" || $this->idLotacao == 0){
                $this->idLotacao = NULL;
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $acao = new DaoPlaAcao();

            $acao->setIdObjetivo($this->idObjetivo);
            $acao->setNmAcao($this->nmAcao);
            $acao->setDsIndicador($this->dsIndicador);
            $acao->setDsMetaPlano($this->dsMetaPlano);
            $acao->setIdLotacao($this->idLotacao);
            $acao->setTpCadastro($this->tpCadastro);

            $result = $acao->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            $acao->setIdAcao($pdo->lastInsertId('pla_acao_id_acao_seq'));

            if (Log::SalvaLogI('pla_acao', $acao->getIdAcao(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro da Ação Realizada com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarAcao() {
        try {
            if ($this->nmAcao == "" || $this->idObjetivo == "" || $this->idAcao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            if($this->idLotacao == "" || $this->idLotacao == 0){
                $this->idLotacao = NULL;
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $acao = new DaoPlaAcao();

            $acao->setIdAcao($this->idAcao);
            $acao->setIdObjetivo($this->idObjetivo);
            $acao->setNmAcao($this->nmAcao);
            $acao->setDsIndicador($this->dsIndicador);
            $acao->setDsMetaPlano($this->dsMetaPlano);                        

            $busca = $acao->retornaAcao($pdo);

            if (!$busca) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $result = $acao->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }

            if (!Log::SalvaLogU('pla_acao', $acao->getIdAcao(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            } else {
                $sucesso = true;
            }


            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição Realizada com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function removerAcao() {
        try {

            if ($this->idAcao == "") {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $acao = new DaoPlaAcao();

            $acao->setIdAcao($this->idAcao);

            $busca = $acao->retornaAcao($pdo);

            if ($busca) {
                if (!Log::SalvaLogD('pla_acao', $acao->getIdAcao(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            } else {
                $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar a Ação.");
                $pdo->rollBack();
                return $retorno;
            }

            $resultDao = $acao->delete($pdo);
            if ($resultDao != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Ação removida com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrAcaoPorObjetivo() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $acao = new DaoPlaAcao();
            $acao->setIdObjetivo($this->idObjetivo);

            $result = $acao->retornaTodasAcoesPorObjetivo($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $id = $v['id_acao'];

                    $cadastro = $this->pegaCadastro($v['tp_cadastro']);
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_acao'] . "</td>"
                            . "<td>" . $v['ds_indicador'] . "</td>"
                            . "<td>" . $v['ds_meta_plano'] . "</td>"
                            . "<td>" . $v['tipo'] . "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Editar" nome="' . $v['nm_acao'] . '" '
                            . ' ds_indicador="'.$v['ds_indicador'].'" ds_meta_plano="'.$v['ds_meta_plano'].'" value=' . $id . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $id . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>';
                    $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionAcaoPorObjetivo() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $acao = new DaoPlaAcao();
            $acao->setIdObjetivo($this->idObjetivo);
            $result = $acao->retornaTodasAcoesPorObjetivo($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= '<option value = "' . $v['id_acao'] . '">' . $v['nm_acao'] . '</option>';
                }
            }
            $retorno = Metodos::retornoAjax("ok", "html", $retorno);
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    public function retornaOptionObjetivos() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $obj = new DaoPlaObjetivo();

            $result = $obj->retornaObjetivoSelect($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value = '" . $v['id_objetivo'] . "'>" . $v['nm_objetivo'] . "</option>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    /**
     * Retorna Options do Select Por Um Eixo Especifico
     * Também recebe a PAS, para somente listar além de todas as Ações cadastradas pelo planejamento
     * Também listar as Ações que a Lotação criou
     * @param int $idEixo
     * @param int $idPas
     * @return string
     */
    public function retornaOptionAcaoPorEixoPas(int $idEixo, int $idPas) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pas = new Pas();
            $pas->carregaDados($idPas);
            
            $acao = new DaoPlaAcao();            
            $result = $acao->retornaTodasAcoesPorEixoLotacao($idEixo, $pas->getIdLotacao(), $pdo);            
            $retorno .= "<option value='0'>Selecione uma Ação</option>";
            if (!$result) {
                return $retorno;
            } else {                
                foreach ($result as $v) {
                    $retorno .= '<option value = "' . $v['id_acao'] . '">' . $v['nm_acao'] . '</option>';
                }
            }            
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    

    public function retornaTrAcaoPlaPta() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $acao = new DaoPlaAcao();
            $acao->setIdPta($this->idPta);

            $result = $acao->retornaAcoesPta($pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $id = $v['id_pta_acao'];

                    $cadastro = $this->pegaCadastro($v['tp_cadastro']);
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_acao'] . "</td>"
                            . "<td class = 'text-center'>" . $cadastro . "</td>"
                            . '<td class = "text-right">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Editar" nome="' . $v['nm_acao'] . '" value=' . $id . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" nome="' . $v['nm_acao'] .'" value=' . $id . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>';
                    $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    
    /**
     * Retorna Informações da Ação até a Diretriz
     * @param int $idPas
     * @return string
     */
    public function retornaListAcao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();                              
            
            $acao = new DaoPlaAcao();
            $acao->setIdAcao($this->idAcao);
            $result = $acao->retornaDadosAcaoAteEixo($pdo);
            
            if (!$result) {
                return $retorno;
            } else {    
                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Diretriz:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_diretriz']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Objetivo:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_objetivo']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Indicador da Ação:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ds_indicador']."</div>";                    
                $retorno .= "</div>"; 
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Meta da Ação:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ds_meta_plano']."</div>";                
                $retorno .= "</div>";
                                                
                                
                if($result['tipo'] != ""){
                    $retorno .= "<div class='row'>";
                        $retorno .= "<div class='col-sm-2'><b>Unidade Responsável:</b></div>";
                        $retorno .= "<div class='col-sm-9'>".$result['tipo']."</div>";                    
                    $retorno .= "</div>";
                }
                               
            }            
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    /**
     * Retorna TR de todas as Ações de levando em consideração o PAS e a Lotação desse PAS     
     * Um PAS está ligado em um único PES, através do PES podemos listar as Ações, porém também temos
     * que levar em consideração a Lotação, para listar somente dessa Lotação do PAS
     * @param int $idPas
     * @return string
     */
    public function retornaTrPorPasLotacao(int $idPas) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $acao = new DaoPlaAcao();                        
            
            $result = $acao->retornaAcoesLotacaoPorPas($idPas, $pdo);
            
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $id = $v['id_acao'];                   
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_acao'] . "</td>"                            
                            . '<td class = "text-center">'
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                            . ' title="Editar" nome="' . $v['nm_acao'] . '" value=' . $id . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" nome="' . $v['nm_acao'] .'" value=' . $id . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>';
                    $retorno .= "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }
    
    /**
     * 
     * @return type
     */
    public function retornaDadosParaEdicao(){
        
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaAcao();            
            $dao->setIdAcao($this->idAcao);                                             
            $result = $dao->retornaDadosAcaoAteEixo($pdo);
            
            if($result == FALSE){
                return Metodos::retornoAjax("nao_encontrou", "", "");
            }                
                        
            $array = array(                
                "eixo" => $result['id_eixo'],
                "diretriz" => $result['id_diretriz'],
                "objetivo" => $result['id_objetivo'],
                "acao" => $result['nm_acao'],
                "meta" => $result['ds_meta_plano'],
                "indicador" => $result['ds_indicador']                
            );
            
            return Metodos::retornoAjax("ok", "ok", $array);                                    
                                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return;
        }
    }
    
    

}


