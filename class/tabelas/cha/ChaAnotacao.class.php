<?php

class ChaAnotacao{

   private $id_anotacao = null;
   private $id_chamado = null;
   private $id_pessoa = null;
   private $ds_anotacao = null;
   private $dh_anotacao = null;

   function getId_anotacao() {
       return $this->id_anotacao;
   }

   function getId_chamado() {
       return $this->id_chamado;
   }

   function getId_pessoa() {
       return $this->id_pessoa;
   }

   function getDs_anotacao() {
       return $this->ds_anotacao;
   }

   function getDh_anotacao() {
       return $this->dh_anotacao;
   }

   function setId_anotacao($id_anotacao) {
       $this->id_anotacao = $id_anotacao;
   }

   function setId_chamado($id_chamado) {
       $this->id_chamado = $id_chamado;
   }

   function setId_pessoa($id_pessoa) {
       $this->id_pessoa = $id_pessoa;
   }

   function setDs_anotacao($ds_anotacao) {
       $this->ds_anotacao = $ds_anotacao;
   }

   function setDh_anotacao($dh_anotacao) {
       $this->dh_anotacao = $dh_anotacao;
   }

}
