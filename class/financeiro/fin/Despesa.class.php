<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinDespesa.class.php";

class Despesa {

	private $idDespesa = null;
	private $cdDespesa = null;
	private $sucesso = null;
	private $msgRetorno = null;

	function getMsgRetorno() {
		return $this->msgRetorno;
	}

	function Sucesso() {
		return $this->sucesso;
	}

	function getIdDespesa() {
		return $this->idDespesa;
	}

	function getCdDespesa() {
		return $this->cdDespesa;
	}

	function setIdDespesa($idDespesa) {
		$this->idDespesa = $idDespesa;
		return $this;
	}

	function setCdDespesa($cdDespesa) {
		$this->cdDespesa = $cdDespesa;
		return $this;
	}

	/**
	 * Retorna o Id da Despesa
	 * @param type $cdDespesa
	 * @return string
	 */
	public function carregaPorCodigoDespesa($cdDespesa, $pdo = null) {

		try {
			if ($pdo == null) {
				$conexao = new Conexao();
				$pdo = $conexao->connect();
			}
			$dao = new DaoFinDespesa();
			$dao->retornaPorCodigoDespesa($cdDespesa, $pdo);
			if ($dao->Sucesso()) {
				$result = $dao->getMsgRetorno();
				$this->sucesso = true;
				$this->idDespesa = $result['id_despesa'];
				$this->cdDespesa = $result['cd_despesa'];
			} else {
				$this->sucesso = false;
				$this->msgTipo = "Erro";
				$this->msgRetorno = "Elemento de Despesa Não Cadastrado.";
			}
		} catch (Exception $ex) {
			$this->sucesso = false;
			$this->msgTipo = "Erro";
			$this->msgRetorno = $ex->getMessage();
		}
	}

	/**
	 * Retorna os Options dos Elmentos de Despesa
	 * @return string
	 */
	public function retornaOptionDespesaElemento(PDO $pdo = null) {
		$retorno = "";
		try {
                        if(empty($pdo)){
                            $conexao = new Conexao();
                            $pdo = $conexao->connect();
                        }
			$dao = new DaoFinDespesa();

			$dao->retornaTodosDespesaElemento($pdo);

			$retorno .= "<option value=0>Selecione uma ".STR_DESPESA_ELEMENTO."</option>";

			if ($dao->Sucesso()) {
				foreach ($dao->getMsgRetorno() as $v) {
					$retorno .= "<option value='" . $v['id_despesa_elemento'] . "'>" . $v['cd_despesa_elemento'] . "</option>";
				}
			}
			return $retorno;
		} catch (Exception $ex) {
			$retorno = "";
		}
	}

	public function retornaOptionsSubElemento() {
		$retorno = "";
		try {
			$conexao = new Conexao();
			$pdo = $conexao->connect();
			$dao = new DaoFinDespesa();
			$dao->setIdDespesaElemento($this->idDespesa);
			$dao->retornaSubElementoPorElemento($pdo);

			$retorno .= "<option value=0>Selecione um Sub Elemento</option>";

			if ($dao->Sucesso()) {
				foreach ($dao->getMsgRetorno() as $v) {
					$retorno .= "<option value='" . $v['id_despesa'] . "'>" . $v['cd_despesa'] . "-" . $v['ds_despesa'] . "</option>";
				}
			}
			return $retorno;
		} catch (Exception $ex) {
			$retorno = "";
		}
	}

}

?>
