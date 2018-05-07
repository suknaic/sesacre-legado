<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/ata/FinAtaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/centrais/FinCentraisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestor/FinGestorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/fiscais/FinFiscaisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/sub_fiscal/SubFiscalModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";

$session = new Session('ajax');

if (!$session->vPContratos()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    CASE 'retornaPessoaJuridica':
        try {
            $pessoaJuridicaModel = new SesPessoaJuridicaModel();
            echo "<option value = '0'>Selecione um contratado</option>";
            echo $pessoaJuridicaModel::optionPessoaJuridica();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaCnpj':
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $pessoaJuridicaModel = new SesPessoaJuridicaModel();
            $pessoaJuridicaModel->setId_pessoa_juridica($id);
            echo $pessoaJuridicaModel->returnnaCnpj();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaPessoaFisica':
        try {
            $modalidadeModel = new ModalidadeModel();
            echo $modalidadeModel->retornaOptionsPessoaFisica();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaLicitacao':
        try {
            $finAtaModel = new FinAtaModel();
            echo $finAtaModel->retornaLicitacaoGcon();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaCentrais':
        try {
            $centrais = new FinCentralModel();
            echo $centrais->retornaOptionsCentrais();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOrgaoGerenciador':
        try {
            $finAtaModel = new FinAtaModel();
            echo $finAtaModel->optionsOrgaoGerenciador();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarAta':
        try {
            $ata = filter_input(INPUT_GET, 'ata', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finAtaModel = new FinAtaModel();
            $finAtaModel->setNrAta($ata['num_ata']);
            $finAtaModel->setIdProcesso($ata['id_processo']);
            $finAtaModel->setTipoContratado($ata['tipoContratado']);
            $finAtaModel->setIdPessoa($ata['empresa']);
            $finAtaModel->setOrgaoGerenciador(empty($ata['orgaoGerenciador']) ? null : $ata['orgaoGerenciador']);
            $finAtaModel->setDsObjeto($ata['desc_objeto']);
            $finAtaModel->setDtIniVigenciaAta($ata['vig_inicial']);
            $finAtaModel->setDtFimVigenciaAta($ata['vig_final']);
            $finAtaModel->setDtAssinatura($ata['data_assinatura']);
            $finAtaModel->setDtPublicacao($ata['data_publicacao']);
            $finAtaModel->setDsObsAta($ata['obs_ata']);
            $finAtaModel->setFlCarona($ata['confAta']);
            $finAtaModel->setIdLotacaoCentral($ata['central']);
            $finAtaModel->setIdFonte($ata['fonte']);
            $finAtaModel->setIdProgramaTrabalho($ata['programa']);
            echo $finAtaModel->cadastraAta();
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsFonte':
        try {
            $fonte = new Fonte();
            echo '<option value="">Selecione uma fonte</option>';
            echo $fonte->retornaOptionSelect(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaProgramaPorFonte':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $qddValor = new QddValor();
            $qddValor->setAno($dados["ano"]);
            $qddValor->setIdFonte($dados["fonte"]);
            echo '<option value="">Selecione uma Programa</option>';
            echo $qddValor->retornaProgramaPorFonteQDD(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
