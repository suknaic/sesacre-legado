<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";
$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadCidade':
        try {

            if(!$session->verificaPermissao(PERFIL_TI)){
                header("Location: /pages/index.php");
            }

            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $cidade = new Cidade();

            $cidade->setNm_cidade(trim($dados['nome']));
            $cidade->setId_estado((int)($dados['estado']));
            $cidade->setId_regional_geo((int)($dados['regionalGeo']));
            $cidade->setId_regional_saude((int)($dados['regionalSaude']));
            
            echo $cidade->cadastrarCidade();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtEstado':
        try {
            
            $est = filter_input(INPUT_GET, 'estado',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            //print_r($est);
            $vinc = new Estado();
            $vinc->setNmEstado(trim($est['nome']));            
            $vinc->setNmSigla(trim($est['sigla']));            
            $vinc->setIdEstado((int)$est['id']);            
            $vinc->setIdPais((int)($est['idp']));            
            echo $vinc->editarEstado();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    
    case 'remEstado':
        try {
                        
            $est = filter_input(INPUT_GET, 'estado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Estado();
            $vinc->setIdEstado((int)$est['id']);
            echo $vinc->removerEstado();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaCidadesTable':
        try {

            if(!$session->verificaPermissao(PERFIL_TI)){
                header("Location: /pages/index.php");
            }

            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $cidade = new Cidade();
            $cidade->setNm_cidade($dados['nome']);
            $cidade->setId_estado($dados['idEstado']);

            echo $cidade->retornaTrCidades();
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'SelectEstadoOption':
        try {
        
            $estado = new Estado();
            echo "<option value = '0'>Selecione um Estado</option>";
            echo $estado->retornaOptionEstado();
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'SelectRegionalSaudeOption':
        try {

//            $estado = new R;
            echo "<option value = '0'>Selecione um Estado</option>";
//            echo $estado->retornaOptionEstado();
            return;

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}







?>
