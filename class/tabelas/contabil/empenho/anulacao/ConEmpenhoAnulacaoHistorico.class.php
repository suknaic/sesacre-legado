<?php

class ConEmpenhoAnulacaoHistorico {

   private $id_empenho_anulacao_historico = null;
   private $id_empenho_anulacao = null;
   private $id_empenho_anulacao_situacao = null;
   private $id_empenho_anulacao_status = null;
   private $id_pessoa = null;
   private $ds_empenho_anulacao_historico = null;
   private $dh_empenho_anulacao_historico = null;
   private $id_lotacao = null;
   private $id_doc_tipo_lotacao = null;
    
   function getIdLotacao() {
       return $this->id_lotacao;
   }

   function getIdDocTipoLotacao() {
       return $this->id_doc_tipo_lotacao;
   }

   function setIdLotacao($id_lotacao) {
       $this->id_lotacao = $id_lotacao;
       return $this;
   }

   function setIdDocTipoLotacao($id_doc_tipo_lotacao) {
       $this->id_doc_tipo_lotacao = $id_doc_tipo_lotacao;
       return $this;
   }

   function getIdEmpenhoAnulacaoHistorico() {
       return $this->id_empenho_anulacao_historico;
   }

   function getIdEmpenhoAnulacao() {
       return $this->id_empenho_anulacao;
   }

   function getIdEmpenhoAnulacaoSituacao() {
       return $this->id_empenho_anulacao_situacao;
   }

   function getIdEmpenhoAnulacaoStatus() {
       return $this->id_empenho_anulacao_status;
   }

   function getIdPessoa() {
       return $this->id_pessoa;
   }

   function getDsEmpenhoAnulacaoHistorico() {
       return $this->ds_empenho_anulacao_historico;
   }

   function getDhEmpenhoAnulacaoHistorico() {
       return $this->dh_empenho_anulacao_historico;
   }

   function setIdEmpenhoAnulacaoHistorico($id_empenho_anulacao_historico) {
       $this->id_empenho_anulacao_historico = $id_empenho_anulacao_historico;
       return $this;
   }

   function setIdEmpenhoAnulacao($id_empenho_anulacao) {
       $this->id_empenho_anulacao = $id_empenho_anulacao;
       return $this;
   }

   function setIdEmpenhoAnulacaoSituacao($id_empenho_anulacao_situacao) {
       $this->id_empenho_anulacao_situacao = $id_empenho_anulacao_situacao;
       return $this;
   }

   function setIdEmpenhoAnulacaoStatus($id_empenho_anulacao_status) {
       $this->id_empenho_anulacao_status = $id_empenho_anulacao_status;
       return $this;
   }

   function setIdPessoa($id_pessoa) {
       $this->id_pessoa = $id_pessoa;
       return $this;
   }

   function setDsEmpenhoAnulacaoHistorico($ds_empenho_anulacao_historico) {
       $this->ds_empenho_anulacao_historico = $ds_empenho_anulacao_historico;
       return $this;
   }

   function setDhEmpenhoAnulacaoHistorico($dh_empenho_anulacao_historico) {
       $this->dh_empenho_anulacao_historico = $dh_empenho_anulacao_historico;
       return $this;
   }


}

