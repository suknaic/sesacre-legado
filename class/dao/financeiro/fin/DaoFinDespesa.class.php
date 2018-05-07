<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinDespesa.class.php";

class DaoFinDespesa extends FinDespesa {

	private $sucesso = null;
	private $msgRetorno = null;

	function getMsgRetorno() {
		return $this->msgRetorno;
	}

	function Sucesso() {
		return $this->sucesso;
	}

	/**
	 * Retorna as informações Por Código da Despesa
	 * Que vai até o SubElemento da Despesa
	 * @param string $cdDespesa
	 * @param type $pdo
	 * @return boolean
	 */
	function retornaPorCodigoDespesa($cdDespesa, $pdo) {

		$sql = " SELECT id_despesa, cd_despesa"
			. " FROM view_despesa"
			. " WHERE cd_despesa = :cdDespesa";
		try {
			$sth = $pdo->prepare($sql);
			$sth->bindValue(":cdDespesa", $cdDespesa, PDO::PARAM_STR);
			$sth->execute();
			if ($sth->rowCount() >= 1) {
				$this->sucesso = true;
				$this->msgRetorno = $sth->fetch(PDO::FETCH_ASSOC);
			} else {
				$this->sucesso = false;
				$this->msgRetorno = "Não encontrou Registros";
			}

		} catch (PDOException $e) {
			$this->sucesso = false;
			$this->msgRetorno = $e->getMessage();
		}
	}

	function retornaTodosDespesaElemento($pdo) {

		$sql = " SELECT id_despesa_elemento, cd_despesa_elemento"
			. " FROM view_despesa_elemento"
			. " ORDER BY cd_despesa_elemento";
		try {
			$sth = $pdo->prepare($sql);
			$sth->execute();
			if ($sth->rowCount() >= 1) {
				$this->sucesso = true;
				$this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);
			} else {
				$this->sucesso = false;
				$this->msgRetorno = "Não encontrou Registros";
			}

		} catch (PDOException $e) {
			$this->sucesso = false;
			$this->msgRetorno = $e->getMessage();
		}
	}

	function retornaSubElementoPorElemento($pdo) {

		$sql = "select id_despesa, cd_despesa, ds_despesa from fin_despesa
                where  id_despesa_elemento = :elemento";
		try {
			$sth = $pdo->prepare($sql);
			$sth->bindValue(":elemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
			$sth->execute();
			if ($sth->rowCount() >= 1) {
				$this->sucesso = true;
				$this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);
			} else {
				$this->sucesso = false;
				$this->msgRetorno = "Não encontrou Registros";
			}

		} catch (PDOException $e) {
			$this->sucesso = false;
			$this->msgRetorno = $e->getMessage();
		}
	}
}
