<ul class="nav nav-tabs nav-justified botaoDocumentoAcoes">    
     <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">PAS/PTA <b class="caret"></b></a>
        <ul class="dropdown-menu dropdown-menu-md">
            <li class="text-center"><a href="/pages/pla/pas/pas_info.php?token=<?php echo $ptaTitulo->getIdPas(); ?>">Informações do PAS</a></li>
            <li class="text-center"><a href="/pages/pla/pta/index.php?token=<?php echo $ptaTitulo->getIdPas(); ?>">Informações do PTA</a></li>
            <li class="text-center"><a href="/pages/pla/pta/pta_titulo_info.php?token=<?php echo $ptaTitulo->getIdPtaTitulo(); ?>">Título do PTA</a></li>
            <li class="text-center"><a href="/pages/pla/pas/pas_acao.php?token=<?php echo $ptaTitulo->getIdPas(); ?>">Ações do PAS</a></li>            
            <li class="text-center"><a href="/pages/pla/pas/pas_indicador.php?token=<?php echo $ptaTitulo->getIdPas(); ?>">Indicador de Saúde</a></li>            
            <li class="text-center"><a href="#">Relatórios</a></li>            
        </ul>
    </li>
    <li>
        <a href="/pages/pla/pta/acao_det.php?token=<?php echo $ptaTitulo->getIdPtaTitulo(); ?>">Detalhamento das Ações</a>
    </li>        
    <li>
        <a href="/pages/pla/pta/mem_calculo.php?token=<?php echo $ptaTitulo->getIdPtaTitulo(); ?>">Memória de Cálculo</a>
    </li>       
    <!--
    <li>
        <a href="/pages/financeiro/documentos_fiscais/financeiro/index.php">Recurso Por Quadrimestre</a>
    </li>      
    -->
    <li>
        <a href="#">Relatórios</a>
    </li>
</ul>