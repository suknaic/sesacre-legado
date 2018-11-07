<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 05/11/18
 * Time: 10:50
 */

    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/Fornecedor.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoaJuridica/PessoaJuridica.class.php";
    $session = new Session('ajaxSemAcesso');

    switch ($_REQUEST['acao']) {
        case 'retornaPais':
            try {
                $pais = new Pais();

                echo "<option value ='0'>Selecione um País</option>";
                echo $pais->retornaOptionPaises();
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'retornaEstado':
            try {
                $pais = filter_input(INPUT_GET, 'pais', FILTER_DEFAULT);
                $idEstado = filter_input(INPUT_GET, 'estado', FILTER_DEFAULT);

                $estado = new Estado();

                echo "<option value ='0'>Selecione um Estado</option>";
                echo $estado->retornaOptionEstado($pais, $idEstado);
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'retornaCidade':
            try {
                $estado = filter_input(INPUT_GET, 'estado', FILTER_DEFAULT);
                $idCidade = filter_input(INPUT_GET, 'cidade', FILTER_DEFAULT);

                $cidade = new Cidade();

                if (empty($estado)) {
                    echo $cidade->retornaOptionTodasCidades();
                } else {
                    echo $cidade->retornaOptionCidadeUf($estado, $idCidade);
                }
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'retornaCidadeUf':
            try {
                $uf = filter_input(INPUT_POST, 'uf', FILTER_DEFAULT);

                $cidade = new Cidade();

                echo $cidade->retornaCidadeUf($uf);
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'cadastrarFornecedor':
            try {
                $dados = filter_input(INPUT_POST, 'dadosFornecedor', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//                print_r($dados);
//                return;
                session_start();
                $_SESSION['idUser'] = 7;
                $fornecedor = new Fornecedor();
                $fornecedor->setPessoaFisica(empty($dados['pessoaFisica']) ? null:$dados['pessoaFisica']);
                $fornecedor->setPessoaJuridica(empty($dados['pessoaJuridica']) ? null:$dados['pessoaJuridica']);
                $fornecedor->setPessoa(empty($dados['pessoa']) ? null:$dados['pessoa']);
                $fornecedor->setMedicamento(array_unique($dados['materialServico']['medicamento']));
                $fornecedor->setServico(array_unique($dados['materialServico']['servico']));
                $fornecedor->setMaterialConsumo(array_unique($dados['materialServico']['materialConsumo']));
                $fornecedor->setMaterialPermanente(array_unique($dados['materialServico']['materialPermanente']));
                $fornecedor->setFlDistribuidora($dados['empDist']);
                $fornecedor->setFlExclusiva($dados['empExc']);

                echo $fornecedor->cadastrarFornecedor();
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }


    }