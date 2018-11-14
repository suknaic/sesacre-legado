<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/fornecedor/ForFornecedor.class.php";
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 06/11/18
 * Time: 17:35
 */

class DaoFornecedor extends ForFornecedor {
    public function cadastrarFornecedor($pdo) {
        try {
            $sql = $pdo->prepare("INSERT 
                                    INTO for_fornecedor (id_pessoa, fl_distribuidora, fl_exclusivo)
                                      VALUES (:idPessoa, :flDistribuidora, :flExclusivo)");

            $sql->bindValue(":flDistribuidora", $this->getFlDistribuidora()  === '' ? NULL : $this->getFlDistribuidora(), PDO::PARAM_STR);
            $sql->bindValue(":flExclusivo", $this->getFlExclusiva() === '' ? NULL : $this->getFlExclusiva(), PDO::PARAM_STR);
            $sql->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $e) {
            return Metodos::retornoAjax('Erro', 'console', $e->getMessage());
        }
    }

    public function retornaFornecedores ($pdo, $filtro) {
        try {
            $sql = $pdo->prepare("SELECT DISTINCT ON (PE.id_pessoa) PE.id_pessoa, FORN.id_fornecedor,
                                     PE.nm_pessoa, SUBSTR(PE.nr_cep, 1, 5) || '-' || SUBSTR(PE.nr_cep, 6,8) as cep, PE.nr_telefone_celular,
                                     PE.nr_telefone_residencial, PE.nm_email,
                                     array_to_string(array_agg(DISTINCT MED.nm_medicamento), '; ') as medicamento,
                                     array_to_string(array_agg(DISTINCT SE.nm_servico), '; ') as servico,
                                     array_to_string(array_agg(DISTINCT MATCON.nm_material_consumo), '; ') as material_consumo,
                                     array_to_string(array_agg(DISTINCT MATPERM.nm_material_permanente), '; ') as material_permanente,
                                     CASE
                                         WHEN PF.id_pessoa IS NOT NULL THEN PF.nr_cpf
                                         WHEN PJ.id_pessoa IS NOT NUll THEN PJ.nr_cnpj
                                     END AS cpf_cnpj,
                                     CASE
                                         WHEN PF.id_pessoa IS NOT NULL THEN '1'
                                         WHEN PJ.id_pessoa IS NOT NUll THEN '2'
                                     END AS tipo_pessoa,
                                     CASE
                                         WHEN FORN.fl_exclusivo = '1' THEN 's'
                                         ELSE 'n'
                                     END AS fornecedor_exclusivo,
                                     CASE
                                         WHEN FORN.fl_distribuidora = '1' THEN 's'
                                         ELSE 'n'
                                     END AS fornecedor_distribuidora
                                  FROM for_fornecedor FORN
                                      INNER JOIN ses_pessoa PE ON PE.id_pessoa = FORN.id_pessoa
                                      LEFT JOIN ses_pessoa_fisica PF ON PE.id_pessoa = PF.id_pessoa
                                      LEFT JOIN ses_pessoa_juridica PJ ON PE.id_pessoa = PJ.id_pessoa
                                      INNER JOIN for_fornecedor_medicamento FORNMED ON FORNMED.id_fornecedor = FORN.id_fornecedor
                                      INNER JOIN for_medicamento MED ON MED.id_medicamento = FORNMED.id_medicamento
                                      INNER JOIN for_fornecedor_servico FORNSE ON FORNSE.id_fornecedor = FORN.id_fornecedor
                                      INNER JOIN for_servico SE ON SE.id_servico = FORNSE.id_servico
                                      INNER JOIN for_fornecedor_material_consumo FORNMATCON ON FORNMATCON.id_fornecedor = FORN.id_fornecedor
                                      INNER JOIN for_material_consumo MATCON ON MATCON.id_material_consumo = FORNMATCON.id_material_consumo
                                      INNER JOIN for_fornecedor_material_permanente FORNMATPERM ON FORNMATPERM.id_fornecedor = FORN.id_fornecedor
                                      INNER JOIN for_material_permanente MATPERM ON MATPERM.id_material_permanente = FORNMATPERM.id_material_permanente
                                          WHERE PE.st_ativo = '1' ".$filtro." 
                                              GROUP BY PE.id_pessoa,PF.tp_sexo,
                                                      PF.nm_civil, PF.id_pessoa, PF.nr_cpf, PJ.id_pessoa, PJ.nr_cnpj, FORN.id_fornecedor");
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return Metodos::retornoAjax('Erro', 'console', $e->getMessage());
        }
    }
}