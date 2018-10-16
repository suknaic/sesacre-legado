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
            $cidade->setId_estado(($dados['estado']));
            $cidade->setId_regional_geo(($dados['regionalGeo']));
            $cidade->setId_regional_saude(($dados['regionalSaude']));

            echo $cidade->cadastrarCidade();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtCidade':
        try {
            
            $dados = filter_input(INPUT_GET, 'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $cidade = new Cidade();
            $cidade->setId_cidade($dados['id']);
            $cidade->setNm_cidade(trim($dados['nome']));
            $cidade->setId_estado(($dados['estado']));
            $cidade->setId_regional_geo(($dados['regionalGeo']));
            $cidade->setId_regional_saude(($dados['regionalSaude']));

            echo $cidade->editarCidade();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    
    case 'remCidade':
        try {
                        
            $id = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $cidade = new Cidade();
            $cidade->setId_cidade($id['id']);

            echo $cidade->removerCidade();
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

            if(!$session->verificaPermissao(PERFIL_TI)){
                header("Location: /pages/index.php");
            }

            $id = filter_input(INPUT_GET, 'id_cidade', FILTER_DEFAULT);

            $estado = new Estado();
            echo "<option value = ''>Selecione um Estado</option>
                  <option value = 'Todos'>Todas as Cidades</option>";
            echo $estado->retornaOptionEstado(null, $id);
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'SelectRegionalSaudeOption':
        try {

            if(!$session->verificaPermissao(PERFIL_TI)){
                header("Location: /pages/index.php");
            }

            $id = filter_input(INPUT_GET, 'id_regional', FILTER_DEFAULT);
            $cidade = new Cidade();

            echo $cidade->retornaOptionRegionalSaude($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'SelectRegionalGeoOption':
        try {

            if(!$session->verificaPermissao(PERFIL_TI)){
                header("Location: /pages/index.php");
            }

            $id = filter_input(INPUT_GET, 'id_regional', FILTER_DEFAULT);
            $cidade = new Cidade();

            echo $cidade->retornaOptionRegionalGeo($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'carregaDadosCidade':
        try {

            if(!$session->verificaPermissao(PERFIL_TI)){
                header("Location: /pages/index.php");
            }

            $id = filter_input(INPUT_GET, 'id_cidade', FILTER_DEFAULT);

            $cidade = new Cidade();
            $cidade->setId_cidade(base64_decode($id));

            echo $cidade->carregaDadosCidade();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}

?>
