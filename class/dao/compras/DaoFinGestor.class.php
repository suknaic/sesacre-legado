<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinGestorTb.class.php";

class DaoFinGestor extends FinGestorTb {

	private $sucesso = false;
	private $msgRetorno = null;

	public function __construct() {

	}

	/**
	 * @return mixed
	 */
	public function sucesso() {
		return $this->sucesso;
	}

	/**
	 * @return mixed
	 */
	public function getMsgRetorno() {
		return $this->msgRetorno;
	}

	public function insertGestor($pdo = null) {
		if (!empty($pdo)) {
			try {
				$sql = "INSERT INTO fin_gestor (id_pessoa, id_contrato, tp_gestor, dt_ini_gestor, dt_fim_gestor)
                VALUES (:pessoa, :contrato, :tipo, :dataIni, :dataFim)";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
				$stmt->bindValue(":contrato", $this->getIdContrato() === '' ? null : $this->getIdContrato(), PDO::PARAM_INT);
				$stmt->bindValue(":tipo", $this->getTpGestor(), PDO::PARAM_INT);
				$stmt->bindValue(":dataIni", $this->getDtIniGestor(), PDO::PARAM_STR);
				$stmt->bindValue(":dataFim", $this->getDtFimGestor() === '' ? null : $this->getDtFimGestor(), PDO::PARAM_STR);
				$stmt->execute();
				$this->sucesso = true;
			} catch (PDOException $e) {
				$this->sucesso = false;

				if ($e->getCode() == "23505") {
					$this->msgRetorno = 'Alguns itens já ser encontra salvo no sistema';
				} else {
					$this->msgRetorno = $e->getMessage();
				}
			}
		} else {
			$this->sucesso = false;
			$this->msgRetorno = 'Sem conexão com o banco de dados';
		}
	}
}
