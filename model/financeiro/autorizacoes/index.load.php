<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Autorizacao.class.php";

$session = new Session();
if(!$session->vPFinanceiro()){
    header("Location: /pages/index.php"); 
}

$autorizacao = new Autorizacao();

//Retorna os tipos de autorizações
$tipos_autorizacoes = $autorizacao->selectTiposAutorizacoes();


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

