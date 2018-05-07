<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

if(!$session->vPComprasAdminTi()){
    echo '<div id="menu_gcon">     
               <ul class="nav nav-tabs nav-justified botaoDocumentoAcoes">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Pesquisar<b class="caret"></b></a>
                        <ul class="dropdown-menu dropdown-menu-md">
                            <li class="text-center"><a href="/pages/compras/gcon/pesquisa/pesquisa.php">Processo</a></li><hr>
                            <li class="text-center"><a href="/pages/compras/gcon/objeto/objeto.php">Objeto</a></li>
                            <li class="text-center"><a href="/pages/compras/gcon/situacao/situacao.php">Situação</a></li>
                            <li class="text-center"><a href="/pages/compras/gcon/modalidade/modalidade.php">Modalidade</a></li>
                            <li class="text-center"><a href="/pages/compras/gcon/unidade/unidade.php">Unidades Contempladas</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                       <a href="#" data-toggle="dropdown" class="dropdown-toggle">Cadastrar<b class="caret"></b></a>
                       <ul class="dropdown-menu dropdown-menu-md">
                           <li class="text-center"><a href="/pages/compras/gcon/processo/processo.php">Processo</a></li><hr>
                           <li class="text-center"><a href="/pages/compras/gcon/objeto/novo_objeto.php">Objeto</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/situacao/nova_situacao.php">Situação</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/modalidade/nova_modalidade.php">Modalidade</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/unidade/nova_unidade.php">Unidades Contempladas</a></li>
                       </ul>
                    </li>
               </ul>';
}else{
    echo '<div id="menu_gcon">     
               <ul class="nav nav-tabs nav-justified botaoDocumentoAcoes">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Pesquisar<b class="caret"></b></a>
                        <ul class="dropdown-menu dropdown-menu-md">
                            <hr><li class="text-center"><a href="/pages/compras/gcon/pesquisa/pesquisa.php">Processo</a></li><hr>
                            
                            <li class="text-center"><a href="/pages/compras/gcon/objeto/objeto.php">Objeto</a></li>
                            <li class="text-center"><a href="/pages/compras/gcon/situacao/situacao.php">Situação</a></li>
                            <li class="text-center"><a href="/pages/compras/gcon/modalidade/modalidade.php">Modalidade</a></li>
                            <li class="text-center"><a href="/pages/compras/gcon/unidade/unidade.php">Unidades Contempladas</a></li>
                            <hr><li class="text-center"><a href="/pages/compras/gcon/usuario/usuario.php">Usuário</a></li><hr>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                       <a href="#" data-toggle="dropdown" class="dropdown-toggle">Cadastrar<b class="caret"></b></a>
                       <ul class="dropdown-menu dropdown-menu-md">
                           <hr><li class="text-center"><a href="/pages/compras/gcon/processo/processo.php">Processo</a></li><hr>
                           <li class="text-center"><a href="/pages/compras/gcon/objeto/novo_objeto.php">Objeto</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/situacao/nova_situacao.php">Situação</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/modalidade/nova_modalidade.php">Modalidade</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/unidade/nova_unidade.php">Unidades Contempladas</a></li>
                           <hr><li class="text-center"><a href="/pages/compras/gcon/usuario/novoUsuario.php">Usuário</a></li><hr>
                       </ul>
                    </li>
                    <li class="dropdown">
                       <a href="#" data-toggle="dropdown" class="dropdown-toggle">Desativados<b class="caret"></b></a>
                       <ul class="dropdown-menu dropdown-menu-md">
                           <hr><li class="text-center"><a href="/pages/compras/gcon/processo/processosDesativados.php">Processo</a></li><hr>
                           <li class="text-center"><a href="/pages/compras/gcon/objeto/objetosDesativados.php">Objeto</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/situacao/situacaoDesativada.php">Situação</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/modalidade/modalidadeDesativada.php">Modalidade</a></li>
                           <li class="text-center"><a href="/pages/compras/gcon/unidade/unidadeDesativadas.php">Unidades Contempladas</a></li>
                       </ul>
                    </li>
               </ul>';
}
