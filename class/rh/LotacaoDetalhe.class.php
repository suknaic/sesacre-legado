<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesLotacaoDetalhe.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesLotacao.class.php";
/**
 * Description of LotacaoDetalhe
 *
 * @author elivelton
 */
class LotacaoDetalhe {

    private $id_lotacao_detalhe = null;
    private $id_pai = null;
    private $id_lotacao_categoria = null;
    private $nm_lotacao_detalhe = null;
    private $nr_cnpj = null;
    private $id_cidade = null;
    private $ds_logradouro = null;
    private $ds_bairro = null;
    private $nr_cep = null;
    private $nm_email = null;
    private $nr_telefone = null;
    private $mp_latitude = null;
    private $mp_longitute = null;
    private $st_ativo = null;
    private $nmPessoa = null;
    private $nmCidade = null;
    private $id_pessoa = null;
    private $id_pessoa_juridica = null;
    private $st_principal = null;
    private $id_telefone = null;

    function getId_lotacao_detalhe() {
        return $this->id_lotacao_detalhe;
    }

    function getId_pai() {
        return $this->id_pai;
    }

    function getId_lotacao_categoria() {
        return $this->id_lotacao_categoria;
    }

    function getNm_lotacao_detalhe() {
        return $this->nm_lotacao_detalhe;
    }

    function getNr_cnpj() {
        return $this->nr_cnpj;
    }

    function getId_cidade() {
        return $this->id_cidade;
    }

    function getDs_logradouro() {
        return $this->ds_logradouro;
    }

    function getDs_bairro() {
        return $this->ds_bairro;
    }

    function getNr_cep() {
        return $this->nr_cep;
    }

    function getNm_email() {
        return $this->nm_email;
    }

    function getNr_telefone() {
        return $this->nr_telefone;
    }

    function getMp_latitude() {
        return $this->mp_latitude;
    }

    function getMp_longitute() {
        return $this->mp_longitute;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
    }

    function getNmCidade() {
        return $this->nmCidade;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getSt_principal() {
        return $this->st_principal;
    }

    function getId_telefone() {
        return $this->id_telefone;
    }

    function setId_lotacao_detalhe($id_lotacao_detalhe) {
        $this->id_lotacao_detalhe = $id_lotacao_detalhe;
    }

    function setId_pai($id_pai) {
        $this->id_pai = $id_pai;
    }

    function setId_lotacao_categoria($id_lotacao_categoria) {
        $this->id_lotacao_categoria = $id_lotacao_categoria;
    }

    function setNm_lotacao_detalhe($nm_lotacao_detalhe) {
        $this->nm_lotacao_detalhe = $nm_lotacao_detalhe;
    }

    function setNr_cnpj($nr_cnpj) {
        $this->nr_cnpj = $nr_cnpj;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setDs_logradouro($ds_logradouro) {
        $this->ds_logradouro = $ds_logradouro;
    }

    function setDs_bairro($ds_bairro) {
        $this->ds_bairro = $ds_bairro;
    }

    function setNr_cep($nr_cep) {
        $this->nr_cep = $nr_cep;
    }

    function setNm_email($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setNr_telefone($nr_telefone) {
        $this->nr_telefone = $nr_telefone;
    }

    function setMp_latitude($mp_latitude) {
        $this->mp_latitude = $mp_latitude;
    }

    function setMp_longitute($mp_longitute) {
        $this->mp_longitute = $mp_longitute;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
    }

    function setNmCidade($nmCidade) {
        $this->nmCidade = $nmCidade;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setSt_principal($st_principal) {
        $this->st_principal = $st_principal;
    }

    function setId_telefone($id_telefone) {
        $this->id_telefone = $id_telefone;
    }

    public function cadastrarlotacaoDetalhe() {
        try {
            if (empty($this->id_lotacao_categoria && $this->nm_lotacao_detalhe && $this->id_pai && $this->id_pessoa_juridica && $this->ds_logradouro && $this->ds_bairro && $this->nr_cep && $this->id_cidade)) {
                return Metodos::retornoAjax('Erro', 'alert', STR_PREENCHER_CAMPOS);
            }
            return Metodos::retornoAjax('Erro', 'alert', 'Tudo ok Até Aqui!');
            //********** Conexão *********
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //****************************

            //********************************** Set's **********************************
            $daoSesLotacaoDetalhe = new DaoSesLotacaoDetalhe();
            $daoSesLotacaoDetalhe->setNm_lotacao($this->nm_lotacao);
            $daoSesLotacaoDetalhe->setNr_cnpj($this->nr_cnpj);
            $daoSesLotacaoDetalhe->setDs_logradouro($this->ds_logradouro);
            $daoSesLotacaoDetalhe->setDs_bairro($this->ds_bairro);
            $daoSesLotacaoDetalhe->setNr_cep($this->nr_cep);
            $daoSesLotacaoDetalhe->setNm_email($this->nm_email);
            $daoSesLotacaoDetalhe->setMp_latitude($this->mp_latitude);
            $daoSesLotacaoDetalhe->setMp_longitute($this->mp_longitute);
            $daoSesLotacaoDetalhe->setId_lotacao($this->id_lotacao);
            $daoSesLotacaoDetalhe->setId_lotacao_categoria($this->id_lotacao_categoria);
            $daoSesLotacaoDetalhe->setId_cidade($this->id_cidade);
            $daoSesLotacaoDetalhe->setId_pessoa($this->id_pessoa);
            $daoSesLotacaoDetalhe->setId_pai($this->id_pai);
            //***************************************************************************

            //****************** Insert Lotação Detalhe ****************
            $insert = $daoSesLotacaoDetalhe->insertLotacaoDetalhe($pdo);
            //**********************************************************
            var_dump($insert);
            return;
            if (!$insert) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $insert);
            } else {
                //************************ Log Lotação Detalhe *************************
                $this->setId_lotacao($pdo->lastInsertId('ses_lotacao_detalhe_id_lotacao_detalhe_seq'));
                if (!Log::SalvaLogI('ses_lotacao', $this->getId_lotacao(), $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }
                //*********************************************************************
            }
            
            //************************* Insert Telefone ***************************
            return;
            if (count($this->nr_telefone) > 0) {
                $daoSesLotacao = new DaoSesLotacao();
                foreach ($this->nr_telefone as $numero) {
                    $daoSesLotacao->setNr_telefone(Metodos::removeMascaraCel_Tel($numero['telefone']));
                }
            }       
            //*********************************************************************
            
            //********************** Finaliza transação ***************************
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            //*********************************************************************
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function retornarLotacoes($nome, $categoria, $lotacaoPai) {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $rh = new DaoSesLotacaoDetalhe();
            $filtro = "";
            //*****************************************************************
            $filter = array();
            if (!empty($nome)) {
                $filter[] = "ld.nm_lotacao ilike '%$nome%'";
            }
            if (!empty($categoria)) {
                $filter[] = "lc.id_lotacao_categoria = $categoria";
            }
            if (!empty($lotacaoPai)) {
                $filter[] = "pa.id_lotacao = $lotacaoPai";
            }

            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            }
            //******************************************************************
            $result = $rh->retornarLotacoesPesquisa($pdo, $filtro);
            var_dump($result);
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    //************ formatar mascara do telefone ****************
                    $telefone = explode(",", $v['nr_telefone']);
                    $numeros = "";
                    foreach ($telefone as $nr) {
                        $numeros .= Metodos::formataTelefone(trim($nr)) . ", ";
                    }
                    $numeros = substr($numeros, 0, strlen($numeros) - 2);
                    //**********************************************************
                    $idlotacao = $v['id_lotacao'];
                    $retorno .= "<tr>";
                    $retorno .= "   <td>" . $v['nm_lotacao'] . "</td>
                                        <td>" . $v['nm_sigla'] . " - " . $v['nm_cidade'] . "</td>
                                        <td>" . $v['ds_logradouro'] . "</td>   
                                        <td>" . $v['ds_bairro'] . "</td>
                                        <td>" . $v['responsavel'] . "</td>   
                                        <td>" . $numeros . "</td> 
                                        <td>" . $v['pai'] . "</td>
                                        <td style='text-align: center;'>                           
                                            <button type='button' class='btn btn-default btn-edit btn-xs'                               
                                                  title='Editar' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
                                                  <i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i>                                
                                            </button>";
                    if ($v['st_ativo'] == '0') {
                        $retorno.= "        <button type='button' class='btn btn-default btn-ativar btn-xs' title='Ativar' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
                                                <i class='ion-checkmark-round text-success' aria-hidden='true'></i>                                
                                            </button>";
                    } else {
                        $retorno.= "        <button type='button' class='btn btn-default btn-desativar btn-xs' title='Desativar' nome='" . $v['nm_lotacao'] . "' value='" . $idlotacao . "' >
                                                <i class='ion-close-round text-danger' aria-hidden='true'></i>                                
                                            </button>";
                    }
                    $retorno.=          "</td>
                                </tr>";
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}
