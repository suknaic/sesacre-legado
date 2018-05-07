<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/ata/FinAtaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/centrais/FinCentraisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestor/FinGestorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/fiscais/FinFiscaisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/sub_fiscal/SubFiscalModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

$session = new Session('ajax');
//var_dump($session->getIdUser());
//return FALSE;
if (!$session->vPContratos()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    CASE 'cadastrarAta':
        try {
            $ata = filter_input(INPUT_POST, 'contrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finContratoModel = new FinContratoModel();
            $finContratoModel->setNrContrato($ata['num_ata']);
            $finContratoModel->setIdProcesso($ata['id_processo']);
            $finContratoModel->setTpContrato(1);
            $finContratoModel->setIdPessoa($session->getIdUser());
            $finContratoModel->setIdPessoaFornecedor($ata['empresa']);
            $finContratoModel->setIdOrgaoGerenciador(empty($ata['orgaoGerenciador']) ? null : $ata['orgaoGerenciador']);
            $finContratoModel->setDsObjeto($ata['desc_objeto']);
            $finContratoModel->setDtIniVigenciaContrato($ata['vig_inicial']);
            $finContratoModel->setDtFimVigenciaContrato($ata['vig_final']);
            $finContratoModel->setDtAssinatura($ata['data_assinatura']);
            $finContratoModel->setDtPublicacao($ata['data_publicacao']);
            $finContratoModel->setDsObsContrato($ata['obs_ata']);
            $finContratoModel->setIdLotacaoCentral($ata['central']);
            echo $finContratoModel->cadastraAta();
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarContrato':
        try {
            $contrato = filter_input(INPUT_POST, 'contrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finContratoModel = new FinContratoModel();
            $finContratoModel->setNrContrato($contrato['num_cont']);
            $finContratoModel->setIdProcesso($contrato['id_processo']);
            $finContratoModel->setIdPessoa($session->getIdUser());
            $finContratoModel->setIdPessoaFornecedor($contrato['empresa']);
            $finContratoModel->setNrPrazoEntrega($contrato['prazo']);
            $finContratoModel->setIdContratoAlt($contrato['ata']);
            $finContratoModel->setDsObjeto($contrato['desc_objeto']);
            $finContratoModel->setDtIniVigenciaContrato($contrato['vig_inicial']);
            $finContratoModel->setDtFimVigenciaContrato($contrato['vig_final']);
            $finContratoModel->setDtAssinatura($contrato['data_assinatura']);
            $finContratoModel->setDtPublicacao($contrato['data_publicacao']);
            $finContratoModel->setDsObsContrato($contrato['obs_contrato']);
            $finContratoModel->setIdLotacaoCentral($contrato['central']);
            $finContratoModel->setIdPessoaGestorTitular($contrato['gestores']);
            $finContratoModel->setIdPessoaGestorSubstituto($contrato['gestoresSub']);
            $finContratoModel->setIdPessoaFiscalTitular($contrato['fiscais']);
            $finContratoModel->setIdPessoaFiscalSubstituto($contrato['fiscaisSub']);
            $finContratoModel->setIdPessoaSubFiscalTitular($contrato['subFiscais']);
            $finContratoModel->setIdPessoaSubFiscalSubstituto($contrato['subFiscaisSub']);
            if (isset($contrato['confCont'][0])) {
                if ($contrato['confCont'][0] === 'S') {
                    $finContratoModel->setFlServicoContinuado($contrato['confCont'][0]);
                }
            }
            $finContratoModel->setIdContratoAlt($contrato["ata"]);

            echo $finContratoModel->cadastrarContrato();
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsAtas':
        try {
             $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finAtaModel = new FinAtaModel();
            $verificarSRP = substr($dados, -3, 3);
            
            if ($verificarSRP == "srp" || $verificarSRP == "SRP" ) {
                echo $finAtaModel->retornaOptionsAtas(null);
            } else {
                echo 'NotSRP';
            }
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

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
            $finContratoModel = new FinContratoModel();
            echo $finContratoModel->retornaLicitacaoGcon();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsGestores':
        try {
            $contratoModel = new Contrato();
            echo '<option value="">Selecione um Gestor</option>';
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsGestoresSubstitutos':
        try {
            $contratoModel = new Contrato();
            echo '<option value="">Selecione um Gestor substituto</option>';
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsFiscais':
        try {
            $contratoModel = new Contrato();
            echo '<option value="">Selecione um Fiscal</option>';
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsFiscaisSub':
        try {
            $contratoModel = new Contrato();
            echo '<option value="">Selecione um Fiscal substituto</option>';
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsSubFiscais':
        try {
            $contratoModel = new Contrato();
            echo '<option value="">Selecione um Sub-Fiscal</option>';
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsSubFiscaisSub':
        try {
            $contratoModel = new Contrato();
            echo '<option value="">Selecione um Sub-Fiscal substituto</option>';
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
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

    CASE 'editarAta':
        try {
            $ata = filter_input(INPUT_POST, 'contrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finContratoModel = new FinContratoModel();
            $finContratoModel->setIdFornecedor($ata['idFornecedor']);
            $finContratoModel->setIdContrato($ata['id_contrato']);
            $finContratoModel->setNrContrato($ata['num_ata']);
            $finContratoModel->setIdProcesso($ata['id_processo']);
            $finContratoModel->setTpContrato(1);
            $finContratoModel->setIdPessoa($session->getIdUser());
            $finContratoModel->setIdPessoaFornecedor($ata['empresa']);
            $finContratoModel->setDsObjeto($ata['desc_objeto']);
            $finContratoModel->setDtIniVigenciaContrato($ata['vig_inicial']);
            $finContratoModel->setDtFimVigenciaContrato($ata['vig_final']);
            $finContratoModel->setDtAssinatura($ata['data_assinatura']);
            $finContratoModel->setDtPublicacao($ata['data_publicacao']);
            $finContratoModel->setDsObsContrato($ata['obs_ata']);
            $finContratoModel->setIdLotacaoCentral($ata['central']);
            echo $finContratoModel->editarAta();
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'editarContrato':
        try {
            $contrato = filter_input(INPUT_POST, 'contrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
         
            $finContratoModel = new FinContratoModel();
            $finContratoModel->setIdFornecedor($contrato['idFornecedor']);
            $finContratoModel->setIdContrato($contrato['id_contrato']);
            $finContratoModel->setNrContrato($contrato['num_cont']);
            $finContratoModel->setIdProcesso($contrato['id_processo']);
            $finContratoModel->setTpContrato(2);
            $finContratoModel->setIdPessoa($session->getIdUser());
            $finContratoModel->setIdPessoaFornecedor($contrato['empresa']);
            $finContratoModel->setDsObjeto($contrato['desc_objeto']);
            $finContratoModel->setDtIniVigenciaContrato($contrato['vig_inicial']);
            $finContratoModel->setDtFimVigenciaContrato($contrato['vig_final']);
            $finContratoModel->setDtAssinatura($contrato['data_assinatura']);
            $finContratoModel->setDtPublicacao($contrato['data_publicacao']);
            $finContratoModel->setDsObsContrato($contrato['obs_contrato']);
            $finContratoModel->setIdLotacaoCentral($contrato['central']);
            echo $finContratoModel->editarContrato();
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'removeCentral':
        try {
            $central = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finCentraisModel = new FinCentraisModel();
            $finCentraisModel->setIdContrato($central["idContrato"]);
            $finCentraisModel->setIdLotacao($central["idLotacao"]);
            $finCentraisModel->removeCentral();
            return '';
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
