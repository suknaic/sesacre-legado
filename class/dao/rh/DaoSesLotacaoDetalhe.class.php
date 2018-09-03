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
            $sql = "INSERT INTO ses_lotacao_detalhe (id_pai, id_lotacao_categoria, nm_lotacao, ds_logradouro, ds_bairro, nr_cnpj, nr_cep, id_cidade, nm_email, mp_latitude, mp_longitude, id_pessoa, id_pessoa_juridica) 
                                     VALUES (:id_pai, :id_lotacao_categoria, :nm_lotacao, :ds_logradouro, :ds_bairro, :nr_cnpj, :nr_cep, :id_cidade, :nm_email, :mp_latitude, :mp_longitude, :id_pessoa, :id_pessoa_juridica)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pai", $this->getId_pai() === '' ? null : $this->getId_pai(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao_categoria", $this->getId_lotacao_categoria(), PDO::PARAM_INT);
            $result->bindValue(":nm_lotacao", $this->getNm_lotacao() === '' ? null : $this->getNm_lotacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_logradouro", $this->getDs_logradouro() === '' ? null : $this->getDs_logradouro(), PDO::PARAM_STR);
            $result->bindValue(":ds_bairro", $this->getDs_bairro() === '' ? null : $this->getDs_bairro(), PDO::PARAM_STR);
            $result->bindValue(":nr_cnpj", $this->getNr_cnpj() === '' ? null : $this->getNr_cnpj(), PDO::PARAM_STR);
            $result->bindValue(":nr_cep", $this->getNr_cep() === '' ? null : $this->getNr_cep(), PDO::PARAM_INT);
            $result->bindValue(":id_cidade", $this->getId_cidade() === '' ? null : $this->getId_cidade(), PDO::PARAM_INT);
            $result->bindValue(":nm_email", $this->getNm_email() === '' ? null : $this->getNm_email(), PDO::PARAM_STR);
            $result->bindValue(":mp_latitude", $this->getMp_latitude() === '' ? null : $this->getMp_latitude(), PDO::PARAM_STR);
            $result->bindValue(":mp_longitude", $this->getMp_longitute() === '' ? null : $this->getMp_longitute(), PDO::PARAM_STR);
            $result->bindValue(":id_pessoa", $this->getId_pessoa() === '' ? null : $this->getId_pessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa_juridica", $this->getId_pessoa_juridica() === '' ? null : $this->getId_pessoa_juridica(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();
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

    function retornarLotacoesPesquisa($pdo, $filtro) {
        $retorno = FALSE;
//        $sql = "SELECT ld.id_lotacao_detalhe, ld.nm_lotacao, ld.id_pai, pa.nm_lotacao pai, lc.id_lotacao_categoria, lc.nm_lotacao_categoria, ld.nr_cnpj, ld.ds_logradouro, ld.ds_bairro, ld.nr_cep, ld.nm_email, ld.mp_latitude, ld.mp_longitude, ld.st_ativo,
//                       ld.id_pessoa, p.nm_pessoa responsavel, ld.id_pessoa_juridica, pj.id_pessoa_juridica, ppj.nm_pessoa juridica,
//                       ld.id_cidade, ci.nm_cidade, e.nm_sigla,
//                       array_to_string(array_agg(t.nr_telefone), ', ') as nr_telefone
//                FROM ses_lotacao_detalhe ld
//                    left join ses_lotacao pa on pa.id_lotacao = ld.id_pai
//                    left join ses_lotacao_categoria lc on lc.id_lotacao_categoria = ld.id_lotacao_categoria
//                    left join ses_pessoa p on p.id_pessoa = ld.id_pessoa
//                    left join ses_pessoa_juridica pj on pj.id_pessoa_juridica = ld.id_pessoa_juridica
//                    left join ses_pessoa ppj on pj.id_pessoa = ppj.id_pessoa
//                    left join ses_cidade ci on ld.id_cidade = ci.id_cidade
//                    left join ses_estado e on ci.id_estado = e.id_estado
//                    left join ses_telefone t on ld.id_lotacao = t.id_lotacao
//                $filtro
//		group by ld.id_lotacao_detalhe, lc.id_lotacao_categoria, p.id_pessoa, pj.id_pessoa_juridica, lc.nm_lotacao_categoria, ld.nm_lotacao, pai, juridica, ci.nm_cidade, e.nm_sigla
//                ORDER BY lc.nm_lotacao_categoria, ld.nm_lotacao";
        $sql = "SELECT ld.id_lotacao_detalhe, ld.nm_lotacao, ld.id_pai, ld.nr_cnpj, ld.ds_logradouro, ld.ds_bairro, ld.nr_cep, ld.nm_email, ld.mp_latitude, ld.mp_longitude, ld.st_ativo,
                       ld.id_pessoa, ld.id_cidade                                    
                FROM ses_lotacao_detalhe ld
                    left join ses_lotacao pa on pa.id_lotacao = ld.id_pai
                $filtro
		        group by ld.id_lotacao_detalhe, ld.nm_lotacao
                ORDER BY ld.nm_lotacao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
}
