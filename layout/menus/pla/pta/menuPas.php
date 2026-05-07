<ul class="nav nav-tabs nav-justified botaoDocumentoAcoes">
    <li>
        <a href="/pages/pla/pas/pas_info.php?token=<?php echo $idPas; ?>">PAS</a>
    </li>    
    <li >
        <a href="/pages/pla/pas/pas_acao.php?token=<?php echo $idPas; ?>">Ações do PAS</a>
    </li>    
    <li>
        <a href="/pages/pla/pas/pas_indicador.php?token=<?php echo $idPas; ?>">Indicador de Saúde</a>
    </li>  
    <li>
        <a href="/pages/pla/pta/index.php?token=<?php echo $idPas; ?>">PTA</a>
    </li> 
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Validações <b class="caret"></b></a>
        <ul class="dropdown-menu dropdown-menu-md">
            <li class="text-center"><a href="/pages/pla/pta/pta_validacao_central.php?token=<?php echo $idPas; ?>">Validar Itens dos PTAs com a Central de Demanda</a></li>            
        </ul>
    </li>
    <li>
        <a href="#">Relatórios</a>
    </li>
</ul>