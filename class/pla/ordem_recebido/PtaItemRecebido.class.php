<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPtaItemRecebido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";

class PtaItemRecebido{
    
    private $idPtaItemRecebido = null;
    private $idOrdemDestino = null;
    private $idPtaAcaoDet = null;
    private $dhRecebido = null;
    private $dsPtaItemRecebido = null;
    private $qtPtaItemRecebido = null;
    private $idTipoGasto = null;
    private $idTipoGastoCategoria = null;
    private $dhPtaItemRecebido = null;
    
    function getIdPtaItemRecebido() {
        return $this->idPtaItemRecebido;
    }

    function getIdOrdemDestino() {
        return $this->idOrdemDestino;
    }

    function getIdPtaAcaoDet() {
        return $this->idPtaAcaoDet;
    }

    function getDhRecebido() {
        return $this->dhRecebido;
    }

    function getDsPtaItemRecebido() {
        return $this->dsPtaItemRecebido;
    }

    function getQtPtaItemRecebido() {
        return $this->qtPtaItemRecebido;
    }

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getIdTipoGastoCategoria() {
        return $this->idTipoGastoCategoria;
    }

    function getDhPtaItemRecebido() {
        return $this->dhPtaItemRecebido;
    }

    function setIdPtaItemRecebido($idPtaItemRecebido) {
        $this->idPtaItemRecebido = $idPtaItemRecebido;
    }

    function setIdOrdemDestino($idOrdemDestino) {
        $this->idOrdemDestino = $idOrdemDestino;
    }

    function setIdPtaAcaoDet($idPtaAcaoDet) {
        $this->idPtaAcaoDet = $idPtaAcaoDet;
    }

    function setDhRecebido($dhRecebido) {
        $this->dhRecebido = $dhRecebido;
    }

    function setDsPtaItemRecebido($dsPtaItemRecebido) {
        $this->dsPtaItemRecebido = $dsPtaItemRecebido;
    }

    function setQtPtaItemRecebido($qtPtaItemRecebido) {
        $this->qtPtaItemRecebido = $qtPtaItemRecebido;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
    }

    function setIdTipoGastoCategoria($idTipoGastoCategoria) {
        $this->idTipoGastoCategoria = $idTipoGastoCategoria;
    }

    function setDhPtaItemRecebido($dhPtaItemRecebido) {
        $this->dhPtaItemRecebido = $dhPtaItemRecebido;
    }


    
    public function salvar(){
        try {  
                                   
            if(empty($this->idOrdemDestino) && empty($this->idPtaAcaoDet)
                    && empty($this->qtPtaItemRecebido)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaPtaItemRecebido();
           
            $dao->setIdOrdemDestino($this->idOrdemDestino);
            
            $dao->setDhRecebido(Metodos::validaConverteDataING($this->dhRecebido));
            
            $dao->setDsPtaItemRecebido($this->dsPtaItemRecebido);            
            $dao->setQtPtaItemRecebido($this->qtPtaItemRecebido);            
            $dao->setIdPtaAcaoDet($this->idPtaAcaoDet);
            
           
            //Verifica se Já existe alguma Pre Loa Cadastrada no Sistema para esse Ano
            $daoPL->verificaExistePorAno($pdo);
            if($daoPL->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já existe uma Pré-LOA Cadastrada Para Este Ano."
                        . " Caso deseje Criar uma Nova, desative Primeiro."
                        . " Somente Uma Pré-LOA por Ano pode estar Ativa.");
                $pdo->rollBack();
                return $retorno;
            }
            //Salva o Registro da Pre Loa
            $daoPL->insert($pdo);
            
            if(!$daoPL->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoPL->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPL->setIdPreLoa($pdo->lastInsertId('pla_pre_loa_id_pre_loa_seq'));            

            if (!Log::SalvaLogI('pla_pre_loa', $daoPL->getIdPreLoa(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            
            $daoPLH = new DaoPlaPreLoaHistorico();
            $daoPLH->setIdPreLoa($daoPL->getIdPreLoa());
            $daoPLH->setIdPessoa($this->idPessoa);
            $daoPLH->setStPreLoa($daoPL->getStPreLoa());
            $daoPLH->setDsPreLoaHistorico($this->dsPreLoaHistorico);
            
            //Salva o Registro do Historico de Mensagens
            $daoPLH->insert($pdo);
            if(!$daoPLH->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoPLH->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPLH->setIdPreLoaHistorico($pdo->lastInsertId('pla_pre_loa_historico_id_pre_loa_historico_seq'));            

            if (!Log::SalvaLogI('pla_pre_loa_historico', $daoPLH->getIdPreLoaHistorico(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            
            //Iremos fazer uma Busca na PAS e gerar os Valores que serão inseridos na Pre LOA
            $pas = new Pas();
            $pas->retornaValoresPreLOA((int)$daoPL->getAaPreLoa(), $pdo);
            
            if(!$pas->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $pas->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $result = $pas->getMsgRetorno();
            
            if(count($result) < 1){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível encontrar nenhuma PAS.");
                $pdo->rollBack();
                return $retorno;
            }
            
            $daoPLV = new DaoPlaPreLoaValores();
            $daoPLV->setIdPreLoa($daoPL->getIdPreLoa());            
            
            
            //Preparar os Dados Para Dar Insert
            foreach ($result as $key => $value) {
                                               
                //Seta os Campos para Salvar no Banco de Dados
                $daoPLV->setIdProgramaTrabalho($value['id_programa_trabalho']);
                $daoPLV->setIdDespesaElemento($value['id_despesa_elemento']);
                $daoPLV->setIdFonte($value['id_fonte']);
                $daoPLV->setVlPreLoaValores(number_format($value['valor'], 4, '.', ''));
                
                $daoPLV->insert($pdo);
                if(!$daoPLV->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $daoPLV->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                $daoPLV->setIdPreLoaValores($pdo->lastInsertId('pla_pre_loa_valores_id_pre_loa_valores_seq'));            

                if (!Log::SalvaLogI('pla_pre_loa_valores', $daoPLV->getIdPreLoaValores(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                
                
            }
            
                                                          
            $retorno = Metodos::retornoAjax("ok", "html", "Pré-LOA Criada com Sucesso.");
            $pdo->commit();
            return $retorno;
                                                           
            
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    
    /**
     * 
     * @param int $idLotacao
     * @param int $perfil
     * @param type $user
     * @return string
     */
    public function retornaTrOrdemEsperandoRecebido(int $idLotacao, int $perfil, $user){
        
        $retorno = "";
        
        try {  
                                   
            if(empty($idLotacao)){
                return $retorno;
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            
            if($perfil != 1){                
                $pasPesLot = new PasPesLot();
                if(!$pasPesLot->verificaPermissao($user, $idLotacao, $pdo)){
                    return "Sem Permissão";
                }
            }
            
            
            $sql = " SELECT V.id_pre_loa_valores, V.id_pre_loa"
                . " , V.id_programa_trabalho, VPT.ds_programa_trabalho, VPT.programa_trabalho"
                . " , V.id_despesa_elemento, VDE.cd_despesa_elemento"
                . " , V.id_fonte, F.nr_fonte"
                . " , V.vl_pre_loa_valores"                    
                . " FROM pla_pre_loa_valores V"
                . " INNER JOIN view_despesa_elemento VDE ON VDE.id_despesa_elemento = V.id_despesa_elemento"
                . " INNER JOIN view_programa_trabalho VPT ON VPT.id_programa_trabalho = V.id_programa_trabalho"
                . " INNER JOIN fin_fonte F ON F.id_fonte = V.id_fonte"
                . " WHERE V.id_pre_loa = :idPreLoa"
                . " ORDER BY VPT.ds_programa_trabalho, VDE.cd_despesa_elemento, F.nr_fonte";
            try {
                $result = $pdo->prepare($sql);
                $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
                $result->execute();
                if ($result->rowCount() >= 1){
                    $this->sucesso = true; 
                    $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;                
                    $this->msgRetorno = "Não encontrou Registros";                
                } 
            } catch (PDOException $e) {
                $this->sucesso = false;            
                $this->msgRetorno = $e->getMessage();            
            }
            
            
            
            echo $idLotacao;
            
            return;
            
            
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        } 
            
    }
    
        
}

