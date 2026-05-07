<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPessoaJuridica.class.php";

class SesPessoaJuridicaModel {

    private $id_pessoa_juridica = null;
    private $id_pessoa = null;
    private $nr_cnae = null;
    private $nr_cnpj = null;
    private $ds_insc_estadual = null;
    private $ds_insc_municipal = null;
    private $dt_fundacao = null;

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getNr_cnae() {
        return $this->nr_cnae;
    }

    function getNr_cnpj() {
        return $this->nr_cnpj;
    }

    function getDs_insc_estadual() {
        return $this->ds_insc_estadual;
    }

    function getDs_insc_municipal() {
        return $this->ds_insc_municipal;
    }

    function getDt_fundacao() {
        return $this->dt_fundacao;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setNr_cnae($nr_cnae) {
        $this->nr_cnae = $nr_cnae;
    }

    function setNr_cnpj($nr_cnpj) {
        $this->nr_cnpj = $nr_cnpj;
    }

    function setDs_insc_estadual($ds_insc_estadual) {
        $this->ds_insc_estadual = $ds_insc_estadual;
    }

    function setDs_insc_municipal($ds_insc_municipal) {
        $this->ds_insc_municipal = $ds_insc_municipal;
    }

    function setDt_fundacao($dt_fundacao) {
        $this->dt_fundacao = $dt_fundacao;
    }

    public static function optionPessoaJuridica(int $id = null) {
        try {
            $options = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $result = '';
            $result = $pessoaJuridica->listaPessoaJuridica($pdo);
            $option = '';
            foreach ($result as $linha) {
                if ($id == $linha["id_pessoa"]) {
                    $option .= '<option value = "' . $linha["id_pessoa"] . '" selected>' . $linha["nr_cnpj"]." - ".$linha["nm_fantasia"] . '</option>';
                } else {
                    $option .= '<option value = "' . $linha["id_pessoa"] . '">' . $linha["nr_cnpj"]." - ".$linha["nm_fantasia"]  . '</option>';
                }
            }
            return $option;
            //Seta os Campos
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function returnnaCnpj() {
        try {

            if ($this->id_pessoa_juridica != '' && $this->id_pessoa_juridica != "") {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $DaoSesPessoaJuridica = new DaoSesPessoaJuridica();
                $DaoSesPessoaJuridica->setId_pessoa_juridica($this->id_pessoa_juridica);
                $result = '';
                $result = $DaoSesPessoaJuridica->retornaCnpj($pdo, $DaoSesPessoaJuridica);
                return Metodos::retornoAjax("ok", "html", $result[0]["nr_cnpj"]);
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public static function optionPessoaFisica($id = null) {
        try {
            $options = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $result = '';
            $result = $pessoaJuridica->retornaPessoaFisica($pdo);
            $option = '';
            foreach ($result as $linha) {
                if (!empty($id) && $id == $linha["id_pessoa"]) {
                    $option .= '<option value = "' . $linha["id_pessoa"] . '" selected>' . $linha["nm_pessoa"] . '</option>';
                } else {
                    $option .= '<option value = "' . $linha["id_pessoa"] . '">' . $linha["nm_pessoa"] . '</option>';
                }
            }
            return $option;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public static function retornaOptionsPessoaJuridicaCadastrada($id = null) {
        try {
            $options = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaJuridica = new DaoSesPessoaJuridica();
            $result = '';
            $result = $pessoaJuridica->retornaPessoaJuridicaCadastrada($pdo);
            $option = '';
            foreach ($result as $linha) {
                if (!empty($id) && $id == $linha["id_fornecedor"]) {
                    $option .= '<option value = "' . $linha["id_pessoa"] . '" selected>' . $linha["nm_pessoa"] .' - ' .$linha["nr_cnpj"]. '</option>';
                } else {
                    $option .= '<option value = "' . $linha["id_pessoa"] . '">' . $linha["nm_pessoa"] .'-' .$linha["nr_cnpj"]. '</option>';
                }
            }
            return $option;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
