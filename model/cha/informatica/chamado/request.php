<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/chamado/Chamado.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/formularios/formSistemas/FormSistemas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/categoriaTipo/CategoriaTipo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/categoriaPrimaria/CategoriaPrimaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/categoriaSecundaria/CategoriaSecundaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vinculo/Vinculo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/cargo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/funcao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

$session = new Session('ajax');

if (!$session->vPChamado()) {
    echo "SessaoExpirada";
    return;
}

if (!$session->verificaPermissao(PERFIL_TI)) {
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
    case 'cadastrarChamado':
        try {

            if (!$session->vPChamado()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $data = date('Y-m-d H:i');

            $dadosFormInfraestrutura = filter_input(INPUT_POST, 'dadosFormInfraestrutura', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosFormSistema = filter_input(INPUT_POST, 'dadosFormSistema', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosChamado = filter_input(INPUT_POST, 'dadosChamado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $idSolicitante = $session->getIdUser();
            $cha = new Chamado();
            $cha->setIdCategoriaSecundaria($dadosChamado['idCategoriaSecundaria']);
            $cha->setIdPessoaSolicitante($idSolicitante);
            $cha->setIdPessoaServico($dadosChamado['idPessoaServico']);
            $cha->setDhAbertura($data);
            $cha->setDsChamado($dadosChamado['dsChamado']);
            $cha->setNrTelefoneSolicitante($dadosChamado['nrTelefoneSolicitante']);
            $cha->setDsFinalizado($dadosChamado['dsFinalizado']);
            $cha->setDhFinalizado($dadosChamado['dhFinalizado']);
            $cha->setNrAvaliacao($dadosChamado['nrAvaliacao']);
            $cha->setDhAvaliacao($dadosChamado['dhAvaliacao']);
            $cha->setDsAvaliacao($dadosChamado['dsAvaliacao']);
            $cha->setVlChamado($dadosChamado['vlChamado']);
            $cha->setIdStatus($dadosChamado['idStatus']);
            $cha->setDhAgendamento($dadosChamado['dhAgendamento']);
            $cha->setIdPrioridade($dadosChamado['idPrioridade']);
            $cha->setDhCancelamento($dadosChamado['dhCancelamento']);
            $cha->setDsCancelamento($dadosChamado['dsCancelamento']);
            $cha->setDtPrazo($dadosChamado['dtPrazo']);

            if (array_key_exists('anexos', $dadosChamado)) {
                $cha->setAnexos($dadosChamado['anexos']);
            }

//             print_r($cha);
            echo $cha->salvarChamado($dadosFormSistema, $dadosFormInfraestrutura);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editarChamado':
        try {

            if (!$session->vPChamado()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $data = date('Y-m-d H:i');

            $dadosFormSistema = filter_input(INPUT_POST, 'dadosFormSistema', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosChamado = filter_input(INPUT_POST, 'dadosChamado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $idSolicitante = $session->getIdUser();
            $cha = new Chamado();
            $cha->setIdCategoriaSecundaria($dadosChamado['idCategoriaSecundaria']);
            $cha->setIdPessoaSolicitante($idSolicitante);
            $cha->setIdPessoaServico($dadosChamado['idPessoaServico']);
            $cha->setDhAbertura($data);
            $cha->setDsChamado($dadosChamado['dsChamado']);
            $cha->setNrTelefoneSolicitante($dadosChamado['nrTelefoneSolicitante']);
            $cha->setDsFinalizado($dadosChamado['dsFinalizado']);
            $cha->setDhFinalizado($data);
            $cha->setNrAvaliacao($dadosChamado['nrAvaliacao']);
            $cha->setDhAvaliacao($data);
            $cha->setDsAvaliacao($dadosChamado['dsAvaliacao']);
            $cha->setVlChamado($dadosChamado['vlChamado']);
            $cha->setIdStatus($dadosChamado['idStatus']);
            $cha->setDhAgendamento($dadosChamado['dhAgendamento']);
            $cha->setIdPrioridade($dadosChamado['idPrioridade']);
            $cha->setDhCancelamento($data);
            $cha->setDsCancelamento($dadosChamado['dsCancelamento']);
            $cha->setDtPrazo($dadosChamado['dtPrazo']);
//             print_r($cha);
            echo $cha->editarChamado($dadosFormSistema);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'removerFormSistema':
        try {

            if (!$session->vPChamadoAcao()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $get = filter_input(INPUT_POST, 'idChamado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sistema = new FormSistemas();
            $sistema->setIdChamado((int) explode("-", $get['idChamado'])[0]);
            $sistema->setIdFormSistemas((int) explode("-", $get['idChamado'])[1]);
//            print_r($sistema);
//            return;
            echo $sistema->removerFormSistemas();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'cancela':
        try {
            $get = filter_input(INPUT_GET, 'chamado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $idChamado = explode("-", $get['id']);
            $cha = new Chamado();
            $cha->setIdChamado((int) $idChamado[0]);

            echo $cha->cancela();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'listaChamadoTable':
        try {

            $cha = new Chamado();
            $idPessoaFisica = filter_input(INPUT_POST, 'id_usuario', FILTER_DEFAULT);
            echo $cha->retornaTrChamado($idPessoaFisica);

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaChamadoTable1':
        try {

            $cha = new Chamado();
            $idPessoaFisica = filter_input(INPUT_POST, 'id_usuario', FILTER_DEFAULT);
            $idStatus = filter_input(INPUT_POST, 'idStatus', FILTER_DEFAULT);
            echo $cha->retornaTrChamado1($idPessoaFisica, $idStatus);

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaChamadoTable2':
        try {

            $cha = new Chamado();
            $idPessoaFisica = filter_input(INPUT_POST, 'id_usuario', FILTER_DEFAULT);
            $idStatus = filter_input(INPUT_POST, 'idStatus', FILTER_DEFAULT);
            echo $cha->retornaTrChamado2($idPessoaFisica, $idStatus);

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'returnPessoa':
        try {
            $cha = new Chamado();
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
            $cha->setIdPessoaSolicitante($idPessoaFisica);
            echo $cha->retornaPessoa();
            //echo $cha->retornaChamado();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'returnChamadoVisualiza':
        try {
            $cha = new Chamado();
            $idGet = filter_input(INPUT_POST, 'id_get', FILTER_DEFAULT);
            $cha->setIdChamado($idGet);
            echo $cha->retornaChamadoVisualiza($idGet);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'returnChamados':
        try {
            $cha = new Chamado();
            $cha->setIdPessoaSolicitante($session->getIdUser());
            echo $cha->retornaPessoa();
            //echo $cha->retornaChamado();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaLotacaoOptionPessoa1':
        try {
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
            $prog = new Lotacao();
            $prog->setId_pessoa((int) $idPessoaFisica);
            echo $prog->retornaOptionLotacaoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaLotacaoOptionPessoa':
        try {
            $prog = new Lotacao();
            $prog->setId_pessoa($session->getIdUser());
            echo $prog->retornaOptionLotacaoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'returnTelefones':
        try {
            $idLotacao = $_REQUEST['idLotacao'];
            $lotacao = new Lotacao();
            $lotacao->returnTelefones($idLotacao);
            //            print_r($prog);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaCargoOptionPessoa1':
        try {
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
//            print_r($idPessoaFisica);
            $prog = new Contrato();
            $prog->setId_pessoa_fisica((int) $idPessoaFisica);
//            print_r($prog);
            echo $prog->retornaOptionCargoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaCargoOptionPessoa':
        try {
            $prog = new Contrato();
            $prog->setId_pessoa_fisica($session->getIdUser());
            echo $prog->retornaOptionCargoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaFuncaoOptionPessoa1':
        try {
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
            $prog = new Contrato();
            $prog->setId_pessoa_fisica((int) $idPessoaFisica);
            echo $prog->retornaOptionFuncaoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaFuncaoOptionPessoa':
        try {
            $prog = new Contrato();
            $prog->setId_pessoa_fisica($session->getIdUser());
            echo $prog->retornaOptionFuncaoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaVinculoOptionPessoa1':
        try {
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
            $prog = new Contrato();
            $prog->setId_pessoa_fisica((int) $idPessoaFisica);
            echo $prog->retornaOptionVinculoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaVinculoOptionPessoa':
        try {
            $prog = new Contrato();
            $prog->setId_pessoa_fisica($session->getIdUser());
            echo $prog->retornaOptionVinculoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaEscolaridadeOptionPessoa1':
        try {
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
            $prog = new Escolaridade();
            $prog->setIdPessoaFisica((int) $idPessoaFisica);
            echo $prog->retornaOptionEscolaridadePessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaEscolaridadeOptionPessoa':
        try {
            $prog = new Escolaridade();
            $prog->setIdPessoaFisica($session->getIdUser());
            echo $prog->retornaOptionEscolaridadePessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaEstadoCivilOptionPessoa1':
        try {
            $idPessoaFisica = filter_input(INPUT_POST, 'idPessoa', FILTER_DEFAULT);
            $prog = new pessoaFisica();
            $prog->setId_pessoa_fisica((int) $idPessoaFisica);
            echo $prog->retornaOptionEstadoCivilPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaEstadoCivilOptionPessoa':
        try {
            $prog = new pessoaFisica();
            $prog->setId_pessoa_fisica($session->getIdUser());
            echo $prog->retornaOptionEstadoCivilPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaPaisOption':
        try {
            $pais = new Pais();
            echo $pais->retornaOptionPaises();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listaPessoaOption':
        try {
            $pessoa = new Contrato();
            echo $pessoa->retornaOptionPessoaChamado(null, $session->getIdUser());
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listaTiposTable':
        try {

            $vinc = new CategoriaTipo();
            echo $vinc->listarCategoriaTipo();
            // echo 'teste';
            return;

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'SelectPrincipaisOpt':
        try {

            $vinc = new CategoriaTipo();
            echo $vinc->retornaOptionPrincipais();
            // echo 'teste';
            return;

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaSecundariaOption':
        try {
            $sec = new CategoriaSecundaria();
            $idCategoriaPrimaria = filter_input(INPUT_GET, 'idCategoriaPrimaria', FILTER_DEFAULT);
            echo $sec->retornaOptionCategoriaSecundaria($idCategoriaPrimaria, null);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaPrimariaOption':
        try {
            $prim = new CategoriaPrimaria();
            $idCategoriaTipo = filter_input(INPUT_GET, 'idCategoriaTipo', FILTER_DEFAULT);
            echo $prim->retornaOptionCategoriaPrimaria($idCategoriaTipo, null);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaTipoOption':
        try {
            $tip = new CategoriaTipo();
            $idCategoriaPrincipal = filter_input(INPUT_GET, 'idCategoriaPrincipal', FILTER_DEFAULT);
            echo $tip->retornaOptionCategoriaTipo($idCategoriaPrincipal, null);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaPrincipaisOption':
        try {
            $prin = new Principal();
            echo $prin->retornaOptionPrincipal();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'retornaFormulario':
        try {
            $idCategoriaSecundaria = filter_input(INPUT_POST, 'idCategoriaSecundaria', FILTER_DEFAULT);
            $sec = new CategoriaSecundaria();
            switch ($idCategoriaSecundaria) {
                case '1':
                    $sec->dominioCriarUsuario();
                    return;
                    break;
                case '2':
                    $sec->dominioDesativarUsuario();
                    return;
                    break;
                case '3':
                    $sec->dominioExluirUsuario();
                    return;
                    break;
                case '4':
                    $sec->dominioHabilitarUsuario();
                    return;
                    break;
                case '5':
                    $sec->dominioRedefinirSenha();
                    return;
                    break;
                case '6':
                    $sec->redeAtivacaoDePontoDeRede();
                    return;
                    break;
                case '7':
                    $sec->redeAtualizacaoDeAplicativosNosServidores();
                    return;
                    break;
                case '8':
                    $sec->redeConectorizacaoDeCabos();
                    return;
                    break;
                case '9':
                    $sec->redeConfeccaoDeLineCord();
                    return;
                    break;
                case '10':
                    $sec->redeConfeccaoDeNovoPontoDeRede();
                    return;
                    break;
                case '11':
                    $sec->redeConfeccaoDePatchCord();
                    return;
                    break;
                case '12':
                    $sec->redeConfiguracaoDeRotasNoGateway();
                    return;
                    break;
                case '13':
                    $sec->redeConfiguracaoDeVlan();
                    return;
                    break;
                case '14':
                    $sec->redeCriacaoConfiguracaoDeVpn();
                    return;
                    break;
                case '15':
                    $sec->redeInstalacaoSubstituicaoDeSwitch();
                    return;
                    break;
                case '16':
                    $sec->redeLevantamentoDeMaterialParaMudancaDeLayout();
                    return;
                    break;
                case '17':
                    $sec->redeManutencaoDeConectorKeystone();
                    return;
                    break;
                case '18':
                    $sec->redeManutencaoDeConectorRj45();
                    return;
                    break;
                case '19':
                    $sec->redeManutencaoDeRack();
                    return;
                    break;
                case '20':
                    $sec->redePermissaoDeAcesso();
                    return;
                    break;
                case '21':
                    $sec->redeRemanejamentoDePontoDeRede();
                    return;
                    break;
                case '22':
                    $sec->redeServicoDeEstruturacaoDeRede();
                    return;
                    break;
                case '23':
                    $sec->redeServicoDeReestruturacaoDeRede();
                    return;
                    break;
                case '24':
                    $sec->redeVerificacaoDeCabeamentoDeRede();
                    return;
                    break;
                case '133':
                    $sec->cadWebCriarUsuario();
                    return;
                    break;
                case '134':
                    $sec->cadWebDesabilitarUsuario();
                    return;
                    break;
                case '135':
                    $sec->cadWebExcluirUsuario();
                    return;
                    break;
                case '136':
                    $sec->cadWebHabilitarUsuario();
                    return;
                    break;
                case '137':
                    $sec->cadWebOutros();
                    return;
                    break;
                case '138':
                    $sec->cadWebRedefinirSenha();
                    return;
                    break;
                case '139':
                    $sec->emailCriarUsuario();
                    return;
                    break;
                case '140':
                    $sec->emailCriarEmailParaDepartamento();
                    return;
                    break;
                case '141':
                    $sec->emailOutros();
                    return;
                    break;
                case '142':
                    $sec->emailRedefinirSenha();
                    return;
                    break;
                case '143':
                    $sec->gepCriarUsuario();
                    return;
                    break;
                case '144':
                    $sec->gepDesabilitarUsuario();
                    return;
                    break;
                case '145':
                    $sec->gepHabilitarUsuario();
                    return;
                    break;
                case '146':
                    $sec->gepOutros();
                    return;
                    break;
                case '147':
                    $sec->gepPermissoes();
                    return;
                    break;
                case '148':
                    $sec->gepRedefinirSenha();
                    return;
                    break;
                case '149':
                    $sec->gepTreinamento();
                    return;
                    break;
                case '150':
                    $sec->grpCriarUsuario();
                    return;
                    break;
                case '151':
                    $sec->grpDesabilitarUsuario();
                    return;
                    break;
                case '152':
                    $sec->grpHabilitarUsuario();
                    return;
                    break;
                case '153':
                    $sec->grpOutros();
                    return;
                    break;
                case '154':
                    $sec->grpPermissoes();
                    return;
                    break;
                case '155':
                    $sec->grpRedefinirSenha();
                    return;
                    break;
                case '156':
                    $sec->grpTreinamento();
                    return;
                    break;
                case '157':
                    $sec->hospubAdicionarNovoExame();
                    return;
                    break;
                case '158':
                    $sec->hospubCadastroDeProfissional();
                    return;
                    break;
                case '159':
                    $sec->hospubCriarUsuario();
                    return;
                    break;
                case '160':
                    $sec->hospubGerarPlanilhaDeAtendimento();
                    return;
                    break;
                case '161':
                    $sec->hospubOutros();
                    return;
                    break;
                case '162':
                    $sec->hospubPermissoes();
                    return;
                    break;
                case '163':
                    $sec->hospubRedefinirSenha();
                    return;
                    break;
                case '164':
                    $sec->kanbanCriarUsuario();
                    return;
                    break;
                case '165':
                    $sec->kanbanRedefinirSenha();
                    return;
                    break;
                case '166':
                    $sec->pesCriarUsuario();
                    return;
                    break;
                case '169':
                    $sec->pesOutros();
                    return;
                    break;
                case '170':
                    $sec->pesPermissoes();
                    return;
                    break;
                case '171':
                    $sec->pesRedefinirSenha();
                    return;
                    break;
                case '172':
                    $sec->pesTreinamento();
                    return;
                    break;
                case '173':
                    $sec->sesacrenetCriarUsuario();
                    return;
                    break;
                case '174':
                    $sec->sesacrenetOutros();
                    return;
                    break;
                case '175':
                    $sec->sesacrenetPermissoes();
                    return;
                    break;
                case '176':
                    $sec->sesacrenetRedefinirSenha();
                    return;
                    break;
                case '178':
                    $sec->siagCadastrarSetor();
                    return;
                    break;
                case '179':
                    $sec->siagCriarUsuario();
                    return;
                    break;
                case '180':
                    $sec->siagGerarEtiquetas();
                    return;
                    break;
                case '181':
                    $sec->siagOutros();
                    return;
                    break;
                case '182':
                    $sec->siagRedefinirSenha();
                    return;
                    break;
                case '183':
                    $sec->siagTrocarDeSetor();
                    return;
                    break;
            }
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>