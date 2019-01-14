<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/recurso/DaoRecGrupoRecurso.class.php";

class GrupoRecurso {
    private $idGrupoRecurso = null;
    private $nmGrupoRecurso = null;
    private $stAtivo = null;
    private $sucesso = null;
    private $msgRetorno = null;
    
    function getIdGrupoRecurso() {
        return $this->idGrupoRecurso;
    }

    function getNmGrupoRecurso() {
        return $this->nmGrupoRecurso;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdGrupoRecurso($idGrupoRecurso) {
        $this->idGrupoRecurso = $idGrupoRecurso;
        return $this;
    }

    function setNmGrupoRecurso($nmGrupoRecurso) {
        $this->nmGrupoRecurso = $nmGrupoRecurso;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function cadastrarGrupoRecurso(Session $session){
        try {
            
//            if(!$session->recursoPodeCadastrar()){
//                return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
//            }
            
            if (empty($this->getNmGrupoRecurso())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoRecGrupoRecurso = new DaoRecGrupoRecurso();
            $daoRecGrupoRecurso->setNmGrupoRecurso($this->getNmGrupoRecurso());
            
            $daoRecGrupoRecurso->insert($pdo);

            if($daoRecGrupoRecurso->Sucesso()){
                $idGrupoRecurso = $pdo->lastInsertId('rec_grupo_recurso_id_grupo_recurso_seq');
                if (!Log::SalvaLogI('rec_grupo_recurso', $idGrupoRecurso, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $daoRecGrupoRecurso->getMsgRetorno());
            }
            
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage() );
        }
    }
    
    public function retornaOptionGrupoRecurso(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoRecGrupoRecurso = new DaoRecGrupoRecurso();
            $daoRecGrupoRecurso->retornaTodosGrupoRecurso($pdo);
            
            $opcoes = [];
            if ($daoRecGrupoRecurso->Sucesso()) {
                foreach ($daoRecGrupoRecurso->getMsgRetorno() as $linha) {
                    $opcoes[] = (object) array('id' => $linha['id_grupo_recurso'], 'nome' => $linha['nm_grupo_recurso'], 'data' => json_encode($linha));
                }
                return json_encode($opcoes);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}

