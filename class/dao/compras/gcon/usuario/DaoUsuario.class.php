<?php

require_once $_SERVER['DOCUMENT_ROOT']."/class/tabelas/compras/gcon/usuario/usuarioExtd.class.php";

class DaoUsuario extends UsuarioExtd {
    //cadastrar registro do usuario
    function cadastrarRegistroUsuario($pdo){
   
        try {
            $cadastra = $pdo->prepare("INSERT INTO ses_perfil_pessoa(id_perfil, id_pessoa) VALUES (:id_perfil, :id_pessoa)");
            $cadastra->bindValue(":id_perfil", $this->getIdPermissao(), PDO::PARAM_INT);
            $cadastra->bindValue(":id_pessoa", $this->getIdUsuario(), PDO::PARAM_INT);
            $cadastra->execute();
            return true;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    //pesquisa registros dos usuários
    function  listarRegistroUsuario($pdo, $perfis){
        
        try {
            $busca = $pdo->prepare("SELECT perfil_pessoa.id_perfil_pessoa, perfil.id_perfil, perfil.nm_perfil, pessoa.id_pessoa, pessoa.nm_pessoa FROM ses_perfil_pessoa AS perfil_pessoa
                                        INNER JOIN ses_perfil AS perfil ON perfil.id_perfil=perfil_pessoa.id_perfil
                                        INNER JOIN ses_pessoa AS pessoa ON pessoa.id_pessoa=perfil_pessoa.id_pessoa
                                    WHERE perfil.id_perfil IN $perfis ORDER BY perfil.nm_perfil");
            $busca->execute();
             if ($busca->rowCount() >= 0){
                 return $busca->fetchAll(PDO::FETCH_ASSOC);
             }
             else{
                 return false;
             }
             return false;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //edita o registro de um usuário
    function editarRegistroUsuario($pdo){
        
        try{
            $edita = $pdo->prepare("UPDATE ses_perfil_pessoa SET id_perfil = :id_permissao, id_pessoa = :id_usuario WHERE id_perfil_pessoa = :id_perfil_pessoa");
            $edita->bindValue(":id_permissao", $this->getIdPermissao(), PDO::PARAM_INT);
            $edita->bindValue(":id_usuario", $this->getIdUsuario(), PDO::PARAM_INT);
            $edita->bindValue(":id_perfil_pessoa", $this->getIdPerfilPessoa(), PDO::PARAM_INT);
            $edita->execute();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //deleta o registro de um usuario
    function deletarRegistroUsuario($pdo){
        
        try{
            $exclui = $pdo->prepare("DELETE FROM ses_perfil_pessoa WHERE id_perfil_pessoa = :id_perfil_pessoa");
            $exclui->bindValue(":id_perfil_pessoa", $this->getIdPerfilPessoa(), PDO::PARAM_INT);
            $exclui->execute();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    //litas tecnicos
    function listarTecnicos($pdo){
        
        try {
            $list = $pdo->prepare("SELECT DISTINCT P.id_pessoa, P.nm_pessoa 
                                         FROM ses_pessoa as P
                                             INNER JOIN ses_pessoa_fisica as F ON F.id_pessoa=P.id_pessoa
                                                  WHERE P.st_ativo=:status 
                                                       ORDER BY P.nm_pessoa");
            $list->bindValue(':status', 1, PDO::PARAM_INT);
            $list->execute();
            if ($list->rowcount() >= 0){
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    //litas perfis
    function listarPerfis($pdo, $perfis){
        
        try {
            $list = $pdo->prepare("SELECT id_perfil, nm_perfil FROM ses_perfil WHERE id_perfil IN $perfis");
            $list->execute();
            if ($list->rowcount() >= 0){
                return $list->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    //verificar se registro já existe
    function verificaRegistroUsuario($pdo){
        
        try {
            $verifica = $pdo->prepare("SELECT perfil.nm_perfil, pessoa.nm_pessoa FROM ses_perfil_pessoa AS perfil_pessoa
                                            INNER JOIN ses_perfil AS perfil ON perfil.id_perfil=perfil_pessoa.id_perfil
                                            INNER JOIN ses_pessoa AS pessoa ON pessoa.id_pessoa=perfil_pessoa.id_pessoa
                                        WHERE perfil.id_perfil = :id_permissao AND pessoa.id_pessoa = :id_usuario");
            $verifica->bindValue(":id_permissao", $this->getIdPermissao(), PDO::PARAM_INT);
            $verifica->bindValue(":id_usuario", $this->getIdUsuario(), PDO::PARAM_INT);
            $verifica->execute();
            
            if ($verifica->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //carrega dados do resgistro do usuario para log
    function retornaRegistroUsuario($pdo){
        try {
            $sql = $pdo->prepare('SELECT *
                                          FROM ses_perfil_pessoa
                                              WHERE id_perfil_pessoa=:idPerfilPessoa');
            $sql->bindValue(':idPerfilPessoa', $this->getIdPerfilPessoa(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}