<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesLotacaoDetalhe.class.php";

    /**
 * Description of DaoSesLotacaoDetalhe
 *
 * @author elivelton
 */
class DaoSesLotacaoDetalhe extends SesLotacaoDetalhe {
    
    public function insertLotacaoDetalhe($pdo) {
        try {
            
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function selectBuscaLotacaoDetalhe($pdo){
        try {
            
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function selectDadosLotacaoDetalhe($pdo){
        try {
            
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function updateLotacaoDetalhe($pdo){
        try {
            
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function updateDesativaLotacaoDetalhe($pdo){
        try {
            
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    public function cadastrarTelefone($pdo) {
        try {
            $sql = $pdo->prepare("INSERT INTO ses_telefone (nr_telefone, st_principal, id_lotacao_detalhe) 
                                     VALUES (:nr_telefone, :st_principal, :id_lotacao_detalhe)");
            $sql->bindValue(":nr_telefone", $this->getNr_telefone() === '' ? null : $this->getNr_telefone(), PDO::PARAM_INT);
            $sql->bindValue(":st_principal", $this->getSt_principal() === '' ? null : $this->getSt_principal(), PDO::PARAM_INT);
            $sql->bindValue(":id_lotacao_detalhe", $this->getId_lotacao_detalhe() === '' ? null : $this->getId_lotacao_detalhe(), PDO::PARAM_INT);

            $sql->execute();
            return TRUE;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }
}
