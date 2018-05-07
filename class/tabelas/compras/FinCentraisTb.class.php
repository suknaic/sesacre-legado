<?php

class FinCentraisTb {
	private $idAtaCentral = null;
	private $idAta = null;
	private $stAtivoAta = null;
	//fin_cont_central
	private $idContCentral = null;
	private $idContrato = null;
	private $stAtivoContrato = null;
        //atributo hibrido
        private $idLotacao = null;
        function getIdAtaCentral() {
            return $this->idAtaCentral;
        }

        function getIdAta() {
            return $this->idAta;
        }

        function getStAtivoAta() {
            return $this->stAtivoAta;
        }

        function getIdContCentral() {
            return $this->idContCentral;
        }

        function getIdContrato() {
            return $this->idContrato;
        }

        function getStAtivoContrato() {
            return $this->stAtivoContrato;
        }

        function getIdLotacao() {
            return $this->idLotacao;
        }

        function setIdAtaCentral($idAtaCentral) {
            $this->idAtaCentral = $idAtaCentral;
        }

        function setIdAta($idAta) {
            $this->idAta = $idAta;
        }

        function setStAtivoAta($stAtivoAta) {
            $this->stAtivoAta = $stAtivoAta;
        }

        function setIdContCentral($idContCentral) {
            $this->idContCentral = $idContCentral;
        }

        function setIdContrato($idContrato) {
            $this->idContrato = $idContrato;
        }

        function setStAtivoContrato($stAtivoContrato) {
            $this->stAtivoContrato = $stAtivoContrato;
        }

        function setIdLotacao($idLotacao) {
            $this->idLotacao = $idLotacao;
        }


}