<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaDiaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaRelatorio.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaRelatorioDestino.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaRelatorioAnexo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTransporte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTransporteTipo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/diarias/DaoDiaTransporteTemTipo.class.php";

class Relatorio {
    //DIA_RELATORIO
    private $idRelatorio = null;
    private $dsServicoExecutado = null;
    private $dsLocaisExecutado = null;
    private $dtRelatorioDestino = null;
    private $flRetorno = null;
    
    private $idDiaria = null;
    
    
    private $erros = true;
    private $destinos = null;
    private $anexos = null;
   

    function setIdRelatorioDestino($idRelatorioDestino) {
        $this->idRelatorioDestino = $idRelatorioDestino;
    }
    
    function getIdDiaria() {
        return $this->idDiaria;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

        
    function getAnexos() {
        return $this->anexos;
    }

    function setAnexos($anexos) {
        $this->anexos = $anexos;
    }

        
    function getDestinos() {
        return $this->destinos;
    }

    function setDestinos($destinos) {
        $this->destinos = $destinos;
    }

    function getIdRelatorio() {
        return $this->idRelatorio;
    }

    function getDsServicoExecutado() {
        return $this->dsServicoExecutado;
    }

    function getDsLocaisExecutado() {
        return $this->dsLocaisExecutado;
    }

    function getDtRelatorioDestino() {
        return $this->dtRelatorioDestino;
    }

    function getFlRetorno() {
        return $this->flRetorno;
    }

    function setIdRelatorio($idRelatorio) {
        $this->idRelatorio = $idRelatorio;
    }

    function setDsServicoExecutado($dsServicoExecutado) {
        $this->dsServicoExecutado = $dsServicoExecutado;
    }

    function setDsLocaisExecutado($dsLocaisExecutado) {
        $this->dsLocaisExecutado = $dsLocaisExecutado;
    }

    function setDtRelatorioDestino($dtRelatorioDestino) {
        $this->dtRelatorioDestino = $dtRelatorioDestino;
    }

    function setFlRetorno($flRetorno) {
        $this->flRetorno = $flRetorno;
    }
    
    function retornaDadosProposto(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            $daoDiaDiaria->setIdRelatorio($this->getIdRelatorio());
            $daoDiaDiaria->dadosProposto($pdo);
            if ($daoDiaDiaria->getSucesso()) {

                $retorno = $daoDiaDiaria->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    
    function retornaDadosRelatorio(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaRelatorio = new DaoDiaRelatorio();
            $daoDiaRelatorio->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorio->select($pdo);
            
            if ($daoDiaRelatorio->getSucesso()) {
                return json_encode($daoDiaRelatorio->getMsgRetorno()[0]);
            } else {
                return $retorno;
            }
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaTrsDestinos(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaRelatorioDestino = new DaoDiaRelatorioDestino();
            $daoDiaRelatorioDestino->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorioDestino->select($pdo);
            
            if ($daoDiaRelatorioDestino->getSucesso()) {
                foreach ($daoDiaRelatorioDestino->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-destino='" . json_encode($linha) . "' >"
                                    . "<td>".$linha['ds_cidade_inicio']."</td>"
                                    . "<td>".$linha['ds_cidade_fim']."</td>"
                                    . "<td>".$linha['dh_inicio']."</td>"
                                    . "<td>".$linha['dh_fim']."</td>"
                                    . "<td><span role='button' class='remove-destino'>Remover</span> | <span role='button' class='edit-destino'>Alterar</span></td>"
                              . "</tr>";
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaAnexos(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaRelatorioAnexo = new DaoDiaRelatorioAnexo();
            $daoDiaRelatorioAnexo->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorioAnexo->select($pdo);
            if ($daoDiaRelatorioAnexo->getSucesso()) {
                foreach ($daoDiaRelatorioAnexo->getMsgRetorno() as $linha) {
                    $array_anexo = array('id_anexo' => $linha['id_relatorio_anexo'],'path_anexo' => '', 'nm_anexo' => $linha['nm_relatorio_anexo'] , 'nm_mime_type' => $linha['nm_mime_type']);
                    $retorno .= "<div class='form-group' data-anexo='". json_encode($array_anexo) ."'><div class='col-sm-5'><input type='text' value='". $array_anexo['nm_anexo'] ."' class='form-control' disabled></div><div class='col-sm-3'><a target='_blank' href='../relatorio/baixarAnexo.php?id=" . $array_anexo['id_anexo'] . "' class='ver-anexo btn btn-info'>Ver</a><a href='#' class='remove-anexo btn btn-danger'>X</a></div><br/><br/></div>";

                }
            } else {
                $retorno = $daoDiaRelatorioAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    function retornaTransporteTipoOption(PDO $pdo = null, int $idTransporte = 0, int $idTransporteTipo = 0){
        $retorno = "<option value = '0'>Selecione o tipo do transporte</option>";
        
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaTransporteTemTipo = new DaoDiaTransporteTemTipo();
            $daoDiaTransporteTemTipo->setIdTransporte($idTransporte);
            $daoDiaTransporteTemTipo->select($pdo);
            if ($daoDiaTransporteTemTipo->getSucesso()) {
                foreach ($daoDiaTransporteTemTipo->getMsgRetorno() as $linha) {
                    if ($idTransporteTipo == $linha['id_transporte_tipo']) {
                        $retorno .= "<option value = '" . $linha['id_transporte_tipo'] . "'selected>" . $linha['nm_transporte_tipo'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $linha['id_transporte_tipo'] . "'>" . $linha['nm_transporte_tipo'] . "</option>";
                    }
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function retornaTransporteOption(PDO $pdo = null, int $idTransporte = 0) {
        $retorno = "<option value = '0'>Selecione o meio de locomoção</option>";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaTransporte = new DaoDiaTransporte();
        
            $daoDiaTransporte->select($pdo);
            
            if($daoDiaTransporte->getSucesso()){
                foreach ($daoDiaTransporte->getMsgRetorno() as $linha){
                    if ($idTransporte == $linha['id_transporte']) {
                        $retorno .= "<option value = '" . $linha['id_transporte'] . "'selected>" . $linha['nm_transporte'] . "</option>";
                    } else {
                        $retorno .= "<option value = '" . $linha['id_transporte'] . "'>" . $linha['nm_transporte'] . "</option>";
                    }
                }
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            $retorno = "";
        }
        
    } 
    
    function validaRelatorioDestino(){
        $retorno = "";
        $msgErro = "";
        try {
            $destino = json_decode($this->getDestinos());

            $data_inicio = date_create_from_format('d/m/Y H:i', $destino->dh_inicio);
            $data_fim = date_create_from_format('d/m/Y H:i', $destino->dh_fim);

            if (!Metodos::ValidaData($destino->dh_inicio,'d/m/Y H:i') || !Metodos::ValidaData($destino->dh_fim,'d/m/Y H:i')) {
                $msgErro .= 'Data e hora de saída ou chegada inválida.'; 
            }
            
            if ($data_inicio->getTimeStamp() >= $data_fim->getTimeStamp()) {
                $msgErro .= ' Data e hora de chegada não pode ser menor ou igual a data e hora de saída.';
            }
            
            if(empty($msgErro)){
                return Metodos::retornoAjax("ok", "console", $data_fim->format('d/m/Y H:i'));
            } else {
                return Metodos::retornoAjax("Erro", "console", $msgErro);
            }
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }


    function salvarRelatorio() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            
            $daoDiaRelatorio = new DaoDiaRelatorio();
            $daoDiaRelatorio->setDsServicoExecutado($this->getDsServicoExecutado());
            $daoDiaRelatorio->setDsLocaisExecutado($this->getDsLocaisExecutado());
            $daoDiaRelatorio->setDtRelatorioDestino(Metodos::ConverteDataING($this->getDtRelatorioDestino()));
            $daoDiaRelatorio->setFlRetorno($this->getFlRetorno());
            $daoDiaRelatorio->insert($pdo);
            if($daoDiaRelatorio->getSucesso()){
                
                $idRelatorio = $pdo->lastInsertId('dia_relatorio_id_relatorio_seq');
                $this->setIdRelatorio($idRelatorio);
                if (!Log::SalvaLogI('dia_relatorio', $idRelatorio, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $retorno .= $this->percorreRelatorioDestinos($pdo);
                $retorno .= $this->percorreRelatorioAnexos($pdo);
                
                //Atualiza a diaria com o ID do relatorio
                if (empty($retorno)) {
                    $retorno .= $this->associaRelatorioADiaria($pdo);
                }
                
                if (empty($retorno)){
                    $pdo->commit();
                    $retorno = Metodos::retornoAjax("ok", "html", "Cadastro realizado com sucesso.");
                } else {
                    $retorno = Metodos::retornoAjax("Erro", "console", $retorno);
                }
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaRelatorio->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function atualizarRelatorio() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $retorno = "";
            
            $daoDiaRelatorio = new DaoDiaRelatorio();
            $daoDiaRelatorio->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorio->setDsServicoExecutado($this->getDsServicoExecutado());
            $daoDiaRelatorio->setDsLocaisExecutado($this->getDsLocaisExecutado());
            $daoDiaRelatorio->setFlRetorno($this->getFlRetorno());
            $daoDiaRelatorio->setDtRelatorioDestino(Metodos::ConverteDataING($this->getDtRelatorioDestino()));
            
            $daoDiaRelatorio->select($pdo);
            
            if (!$daoDiaRelatorio->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoDiaRelatorio->getMsgRetorno());
            }
            
            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaRelatorio->getMsgRetorno();
            //Atualiza os registros
            $daoDiaRelatorio->update($pdo);
            if ($daoDiaRelatorio->getSucesso()) {


                if (!Log::SalvaLogU('dia_relatorio', $daoDiaRelatorio->getIdRelatorio(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $retorno .= $this->percorreRelatorioDestinos($pdo);
                $retorno .= $this->percorreRelatorioAnexos($pdo);
                
                if (empty($retorno)) { //Não deu nenhum erro
                    $pdo->commit();
                    $retorno = Metodos::retornoAjax("ok", "html", "Relatório atualizado com sucesso.");
                } else {
                    $retorno = Metodos::retornoAjax("Erro", "console", $retorno);
                }
            } else {
                $pdo->rollBack();
                $retorno = Metodos::retornoAjax("Erro", "console", $daoDiaRelatorio->getMsgRetorno());
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    
    //************************************************ RELATORIO DESTINOS ********************************************************
    function percorreRelatorioDestinos(PDO $pdo = null) {
        $retorno = "";
        try {
            $daoDiaRelatorioDestino = new DaoDiaRelatorioDestino();
            $daoDiaRelatorioDestino->setIdRelatorio($this->getIdRelatorio());
            
            //registros do banco
            $daoDiaRelatorioDestino->select($pdo);
            $arrayAuxiliar = $daoDiaRelatorioDestino->getMsgRetorno();
            
            foreach ($this->getDestinos() as $indiceAplicacao => $linhaAplicacao) {
                
                $daoDiaRelatorioDestino->setIdRelatorioDestino($linhaAplicacao['id_relatorio_destino']);
                $daoDiaRelatorioDestino->setIdCidadeInicio($linhaAplicacao['id_cidade_inicio']);
                $daoDiaRelatorioDestino->setIdCidadeFim($linhaAplicacao['id_cidade_fim']);
                $daoDiaRelatorioDestino->setDhInicio($linhaAplicacao['dh_inicio']);
                $daoDiaRelatorioDestino->setDhFim($linhaAplicacao['dh_fim']);
                $daoDiaRelatorioDestino->setIdTransporte($linhaAplicacao['id_transporte']);
                $daoDiaRelatorioDestino->setIdTransporteTipo(empty($linhaAplicacao['id_transporte_tipo']) ? NULL : $linhaAplicacao['id_transporte_tipo']);
                $daoDiaRelatorioDestino->setDsTransporteTipo($linhaAplicacao['ds_transporte_tipo']);
                
                if((int)$linhaAplicacao['id_relatorio_destino'] === 0){ //CADASTRO
                    $retorno .= $this->insereRelatorioDestino($pdo,$daoDiaRelatorioDestino);
                } else { //ALTERAÇÃO
                    //Percorre os registros persistidos no banco
                    foreach ($daoDiaRelatorioDestino->getMsgRetorno() as $indiceBd => $linhaBd) {
                        if($linhaAplicacao['id_relatorio_destino'] == $linhaBd['id_relatorio_destino']){
                            $diferenca = array_diff_assoc($linhaAplicacao, $linhaBd);
                            if ($diferenca) {
                                //Update
                                $retorno .= $this->atualizaRelatorioDestino($pdo,$daoDiaRelatorioDestino);
                            }
                            //remove o indice para permanecer no array apenas os registros que deverão ser removidos
                            unset($arrayAuxiliar[$indiceBd]);
                        }
                    }
                }
                if (!empty($retorno)) {
                    return $retorno;
                    break;
                }
            }
            
            if ($arrayAuxiliar) {
                //registros que foram excluídos
                foreach ($arrayAuxiliar as $linhaAremover) {
                    $daoDiaRelatorioDestino->setIdRelatorioDestino($linhaAremover['id_relatorio_destino']);
                    $retorno .= $this->excluirRelatorioDestino($pdo,$daoDiaRelatorioDestino);
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function insereRelatorioDestino(PDO $pdo = null,DaoDiaRelatorioDestino $daoDiaRelatorioDestino){
        $retorno = "";
        try {

            $daoDiaRelatorioDestino->insert($pdo);
            if ($daoDiaRelatorioDestino->getSucesso()){

                $idRelatorioDestino = $pdo->lastInsertId('dia_relatorio_destino_id_relatorio_destino_seq');
                if (!Log::SalvaLogI('dia_relatorio_destino', $idRelatorioDestino, $pdo)) {
                    $pdo->rollBack();
                    $retorno = STR_ERROR;
                }

                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaRelatorioDestino->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function atualizaRelatorioDestino(PDO $pdo = null,DaoDiaRelatorioDestino $daoDiaRelatorioDestino){
        $retorno = "";
        try {
            //Retorna os dados antes da alteração
            $daoDiaRelatorioDestino->selectLinha($pdo);

            if (!$daoDiaRelatorioDestino->getSucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoDiaRelatorioDestino->getMsgRetorno());
            }

            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaRelatorioDestino->getMsgRetorno();
            
            //Atualiza os registros
            $daoDiaRelatorioDestino->update($pdo);
            
            if ($daoDiaRelatorioDestino->getSucesso()) {

                if (!Log::SalvaLogU('dia_relatorio_destino', $daoDiaRelatorioDestino->getIdRelatorioDestino(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    $retorno = STR_ERROR;
                }
                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaRelatorioDestino->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirRelatorioDestino(PDO $pdo, DaoDiaRelatorioDestino $daoDiaRelatorioDestino) {
        try {
            
            if (!Log::SalvaLogD('dia_relatorio_destino', $daoDiaRelatorioDestino->getIdRelatorioDestino(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }
            
            $daoDiaRelatorioDestino->delete($pdo);
            
            if ($daoDiaRelatorioDestino->getSucesso()) {
                return "";
            } else {
                return $daoDiaRelatorioDestino->getMsgRetorno();
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    //************************************************ FIM ********************************************************
    
    //************************************************ RELATORIO ANEXOS ********************************************************
    
    function percorreRelatorioAnexos(PDO $pdo = null) {
        $retorno = "";
        try {
            $daoDiaRelatorioAnexo = new DaoDiaRelatorioAnexo();
            $daoDiaRelatorioAnexo->setIdRelatorio($this->getIdRelatorio());
            
            //registros do banco
            $daoDiaRelatorioAnexo->select($pdo);
            $arrayAuxiliar = $daoDiaRelatorioAnexo->getMsgRetorno();
            
            if ($this->getAnexos()) {
                foreach ($this->getAnexos() as $indiceAplicacao => $linhaAplicacao) {

                    $daoDiaRelatorioAnexo->setIdRelatorioAnexo($linhaAplicacao['id_anexo']);
                    $daoDiaRelatorioAnexo->setNmRelatorioAnexo($linhaAplicacao['nm_anexo']);
                    $daoDiaRelatorioAnexo->setNmMimeType($linhaAplicacao['nm_mime_type']);
                    $path_arquivo = $linhaAplicacao['path_anexo'];

                    //se o indice for 0, é um cadastro
                    if ((int)$linhaAplicacao['id_anexo'] === 0) {
                        //insert
                        $retorno .= $this->insereRelatorioAnexo($pdo,$daoDiaRelatorioAnexo,$path_arquivo);
                    } else {
                        //Percorre os registros persistidos no banco
                        foreach ($daoDiaRelatorioAnexo->getMsgRetorno() as $indiceBd => $linhaBd) {
                            if($linhaAplicacao['id_anexo'] == $linhaBd['id_relatorio_anexo']){
                                $diferenca = array_diff_assoc($linhaAplicacao, $linhaBd);
                                if ($diferenca) {
                                    //Update - Por enquanto sem tratamento
                                }
                                //remove o indice para permanecer no array apenas os registros que deverão ser removidos
                                unset($arrayAuxiliar[$indiceBd]);
                            }
                        }
                    }

                    //Se ocorrer erro sai do laço e retorna o erro
                    if (!empty($retorno)) {
                        return $retorno;
                        break;
                    }

                }
            }
            if ($arrayAuxiliar) {
                //registros que foram excluídos
                foreach ($arrayAuxiliar as $linhaAremover) {
                    $daoDiaRelatorioAnexo->setIdRelatorioAnexo($linhaAremover['id_relatorio_anexo']);
                    $retorno .= $this->excluirRelatorioAnexo($pdo,$daoDiaRelatorioAnexo);
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function insereRelatorioAnexo(PDO $pdo = null,DaoDiaRelatorioAnexo $daoDiaRelatorioAnexo,string $arquivoPath = ''){
        $retorno = "";
        try {
            //tenta abrir o arquivo pra ver ser existe
            $fp = fopen($arquivoPath, "rb");

            if (!$fp) {
                return "erro ao localizar o arquivo";
            } 
            $daoDiaRelatorioAnexo->setAqRelatorioAnexo($fp);

            $daoDiaRelatorioAnexo->insert($pdo);
            
            if ($daoDiaRelatorioAnexo->getSucesso()){
                $idDiaRelatorioAnexo = $pdo->lastInsertId('dia_relatorio_anexo_id_relatorio_anexo_seq');
                if (!Log::SalvaLogIBinario('dia_relatorio_anexo', $idDiaRelatorioAnexo, $pdo)) {;
                    $pdo->rollBack();
                    return STR_ERROR;
                }
                 unlink($arquivoPath);                
                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaRelatorioAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function atualizaRelatorioAnexo(PDO $pdo = null,DaoDiaRelatorioAnexo $daoDiaRelatorioAnexo,string $arquivoPath = ''){
        $retorno = "";
        try {
            $fp = fopen($arquivoPath, "rb");

            if (!$fp) {
                return "erro ao localizar o arquivo";
            } 
            $daoDiaRelatorioAnexo->setAqRelatorioAnexo($fp);

            //Atualiza os registros
            $daoDiaRelatorioAnexo->update($pdo);
            
            if ($daoDiaRelatorioAnexo->getSucesso()) {
                unlink($arquivoPath);
                $this->erros = false;
            } else {
                $pdo->rollBack();
                return $daoDiaRelatorioAnexo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function excluirRelatorioAnexo(PDO $pdo, DaoDiaRelatorioAnexo $daoDiaRelatorioAnexo) {
        try {
            
            if (!Log::SalvaLogDBinario('dia_relatorio_anexo', $daoDiaRelatorioAnexo->getIdRelatorioAnexo(), $pdo)) {
                $pdo->rollBack();
                return STR_ERROR;
            }
            
            $daoDiaRelatorioAnexo->delete($pdo);
            
            if ($daoDiaRelatorioAnexo->getSucesso()) {
                return "";
            } else {
                return $daoDiaRelatorioAnexo->getMsgRetorno();
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    //************************************************ FIM ********************************************************
    
    function associaRelatorioADiaria(PDO $pdo) {
        $retorno = "";
        try {
            $daoDiaDiaria = new DaoDiaDiaria();
            $daoDiaDiaria->setIdDiaria($this->getIdDiaria());
            
            $daoDiaDiaria->select($pdo);

            if (!$daoDiaDiaria->getSucesso()) {
                return  $daoDiaDiaria->getMsgRetorno();
            }

            //Se não der erro na seleção da diaria, atribui à variável
            $reg_antigo = $daoDiaDiaria->getMsgRetorno();

            //Atualiza os registros
            $daoDiaDiaria->setIdRelatorio($this->getIdRelatorio());
            $daoDiaDiaria->updateDiariaRelatorio($pdo);

            if ($daoDiaDiaria->getSucesso()) {

                if (!Log::SalvaLogU('dia_diaria', $daoDiaDiaria->getIdDiaria(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    $retorno = STR_ERROR;
                }
                $this->erros = false;

            } else {
                $pdo->rollBack();
                return  $daoDiaDiaria->getMsgRetorno();
            }
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
    
    function baixarAnexo(PDO $pdo = null,int $idRelatorioAnexo = 0) {
        $retorno = "";
        try {
            
            if ($idRelatorioAnexo == 0) {
                $retorno = 'Arquivo não informado.';
                return $retorno;
            }
            
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaRelatorioAnexo = new DaoDiaRelatorioAnexo();
            $daoDiaRelatorioAnexo->setIdRelatorioAnexo($idRelatorioAnexo);
            $daoDiaRelatorioAnexo->select($pdo);
            
            if ($daoDiaRelatorioAnexo->getSucesso()) {
                $retorno = $daoDiaRelatorioAnexo->getMsgRetorno()[0];
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function infoProposto(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoDiaRelatorio = new DaoDiaRelatorio();
            $daoDiaRelatorio->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorio->infoProposto($pdo);
            if ($daoDiaRelatorio->getSucesso()) {
                $retorno = $daoDiaRelatorio->getMsgRetorno();
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function infoAnexos(PDO $pdo = null) {
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoDiaRelatorioAnexo = new DaoDiaRelatorioAnexo();
            $daoDiaRelatorioAnexo->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorioAnexo->select($pdo);
            if ($daoDiaRelatorioAnexo->getSucesso()) {
                $retorno = $daoDiaRelatorioAnexo->getMsgRetorno();
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
    function infoDestinosResumo(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoDiaRelatorioDestino = new DaoDiaRelatorioDestino();
            $daoDiaRelatorioDestino->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorioDestino->selectDestinosResumo($pdo);
            if ($daoDiaRelatorioDestino->getSucesso()) {
                $retorno = $daoDiaRelatorioDestino->getMsgRetorno();
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }

    }
    
    function infoDestinosLocomocao(PDO $pdo = null){
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoDiaRelatorioDestino = new DaoDiaRelatorioDestino();
            $daoDiaRelatorioDestino->setIdRelatorio($this->getIdRelatorio());
            $daoDiaRelatorioDestino->select($pdo);
            if ($daoDiaRelatorioDestino->getSucesso()) {
                $retorno = $daoDiaRelatorioDestino->getMsgRetorno();
            } 
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }

    }
    
    function destinosLocomocaoPadrao(PDO $pdo = null){
        
        $retorno = "";
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoDiaTransporteTemTipo = new DaoDiaTransporteTemTipo();
            $daoDiaTransporteTemTipo->infoLocomocao($pdo);

            if ($daoDiaTransporteTemTipo->getSucesso()) {
                $retorno = $daoDiaTransporteTemTipo->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }
    
}


