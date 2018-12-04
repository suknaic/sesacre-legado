<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/recurso/DaoRecRecurso.class.php";

class Recurso{
    
    private $idRecurso = null;
    private $idSistema = null;
    private $nmRecurso = null;
    private $lkRecurso = null;
    private $dsRecurso = null;
    private $idPessoa = null;    
    private $sucesso = null;
    private $msgRetorno = null;

    public function sucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    public function getIdRecurso() {
        return $this->idRecurso;
    }

    public function getIdSistema() {
        return $this->idSistema;
    }

    public function getNmRecurso() {
        return $this->nmRecurso;
    }

    public function getLkRecurso() {
        return $this->lkRecurso;
    }

    public function getDsRecurso() {
        return $this->dsRecurso;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function setIdRecurso($idRecurso) {
        $this->idRecurso = $idRecurso;
        return $this;
    }

    public function setIdSistema($idSistema) {
        $this->idSistema = $idSistema;
        return $this;
    }

    public function setNmRecurso($nmRecurso) {
        $this->nmRecurso = $nmRecurso;
        return $this;
    }

    public function setLkRecurso($lkRecurso) {
        $this->lkRecurso = $lkRecurso;
        return $this;
    }

    public function setDsRecurso($dsRecurso) {
        $this->dsRecurso = $dsRecurso;
        return $this;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    
    private function retornaRecursoSetado(array $dados) : RecRecurso{
        $dadosRecurso = new RecRecurso();
        $dadosRecurso->setIdRecurso($dados['id_recurso']);
        $dadosRecurso->setIdSistema($dados['id_sistema']);
        $dadosRecurso->setNmRecurso($dados['nm_recurso']);
        $dadosRecurso->setLkRecurso($dados['lk_recurso']);
        $dadosRecurso->setDsRecurso($dados['ds_recurso']);
        return $dadosRecurso;        
    }
    
    
    private function ajustaRetornoDasPermissoesAcoes(array $acoes) : array{
        $per = array(
            "cadastrar" => false,
            "editar" => false,
            "excluir" => false            
        );
        
        foreach ($acoes as $key => $value) {
            if($value['fl_cadastrar'] == '1') $per['cadastrar'] = true;
            if($value['fl_editar'] == '1') $per['editar'] = true;
            if($value['fl_excluir'] == '1') $per['excluir'] = true;                      
        }
        return $per;        
    }
    

    public function retornaRecursoPessoa(PDO $pdo = null){
        
        try{            
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();                
            }            
            $dao = new DaoRecRecurso();
            $dao->setLkRecurso($this->lkRecurso);
            $dao->retornaPorLkRecurso($pdo);
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi Possível Localizar o Recurso.";
                return;
            }            
            $dadosRecurso = $this->retornaRecursoSetado($dao->getMsgRetorno());            
            $dao->setIdRecurso($dadosRecurso->getIdRecurso());
            $dao->retornaTudoPorUsuarioRecurso((int) $this->getIdPessoa(), $pdo);            
            if(!$dao->Sucesso()){                    
                $this->sucesso = false;
                $this->msgRetorno = "Usuário não possui acesso a esse Recurso.";
                return;
            }            
            /*
             * Contém todos os Dados de todos os lugares onde o usuário possivel
             */
            $dadosRetorno = $dao->getMsgRetorno();                                 
            $permissoes = $this->ajustaRetornoDasPermissoesAcoes($dadosRetorno);            
            $this->sucesso = true;
            $this->msgRetorno = $permissoes;
            return;            
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }                        
    }
    
    
    function retornaTrRecursos(Session $session){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tabela = '';
                                                
            $dao = new DaoRecRecurso();
            $dao->retornaTodosRecurso($pdo);
            
            if ($dao->sucesso()) {                                                                              
                foreach ($dao->getMsgRetorno() as $linha) {                   
                    $tabela .= '<tr>'
                                . '<td class="text-center">'.$linha['nm_recurso'].'</td>'
                                . '<td class="text-center">'.$linha['ds_recurso'].'</td>'
                                . '<td class="text-center">'.$linha['nm_sistema'].'</td>'
                                . '<td class="text-center">'.$linha['lk_recurso'].'</td>'
                                . '<td class="text-center">Quantidade de Uso(A FAZER)</td>'                                
                                . '<td class="text-center">'
                                    . ' <button type="button" title="Ver Recurso" class="ver-recurso" value='.$linha['id_recurso'].'>'
                                        . '<i class="fa fa-file-text-o text-info" aria-hidden="true"></i>'
                                    . '</button> ';                    
                    if($session->recursoPodeEditar()){
                        $tabela .=  ' <button type="button" title="Editar Recurso" class="editar-recurso" value='.$linha['id_recurso'].'>'
                                        . '<i class="fa fa-pencil-square-o text-primary" aria-hidden="true"></i>'
                                    . '</button> ';                                    
                    }                                                          
                    if($session->recursoPodeExcluir()){
                        $tabela .= ' <button type="button" title="Excluir Recurso" class="cancelar-recurso" value='.$linha['id_recurso'].'>'
                                        . '<i class="fa fa-trash text-danger" aria-hidden="true"></i>'
                                    . '</button> ';
                    }
                    
                    $tabela .= '</td>'
                            . '</tr>';                    
                }
            } 
            return $tabela;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR );
        }
    }
    
    
    
}

