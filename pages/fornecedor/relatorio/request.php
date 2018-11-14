<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 05/11/18
 * Time: 10:50
 */
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/MaterialPermanente.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/MaterialConsumo.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/Servico.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/Medicamento.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/Fornecedor.class.php";
    $session = new Session('ajaxSemAcesso');

    switch ($_REQUEST['acao']) {
        case 'retornaMedicamento':
            try {
                $medicamento = new Medicamento();

                echo $medicamento->retornaOptionMedicamento();
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'retornaServico':
            try {
                $servico = new Servico();

                echo $servico->retornaOptionServico();
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'retornaMaterialConsumo':
            try {
                $materialConsumo = new MaterialConsumo();

                echo $materialConsumo->retornaOptionMaterialConsumo();
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }

        case 'retornaMaterialPermanente':
            try {
                $materialPermanente = new MaterialPermanente();

                echo $materialPermanente->retornaOptionMaterialPermanente();
                return;
            } catch (Exception $e) {
                echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
                return;
            }
    }