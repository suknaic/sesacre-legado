$(document).ready(function () {

    func = new Funcoes();    
    
     //Masca para valor
    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });
    });
    
    $("body").on("focus", "#quantidade", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });
    });
    
    function calculaValorTotal(){
        var valor = $('#valor').val();
        var qtd = $("#quantidade").val();
        valor = valor.replace('.' , '');        
        valor = parseFloat(valor.replace(',' , '.'));

        qtd = qtd.replace('.' , '');        
        qtd = parseFloat(qtd.replace(',' , '.'));
        
        $("#total").val((qtd*valor).toFixed(4));
        $("#total").priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        }); 
    }
    
    function calculaValor(qtd, valor){                        
        valor = valor.replace('.' , '');        
        valor = parseFloat(valor.replace(',' , '.'));

        qtd = qtd.replace('.' , '');        
        qtd = parseFloat(qtd.replace(',' , '.'));
        
        return (qtd*valor).toFixed(4);          
    }
    
    
    $('body').on('keyup', '#quantidade', function(){
        calculaValorTotal();
    });
    
    $('body').on('keyup', '#valor', function(){
        calculaValorTotal();
    });   
   
    $('body').on('change', '#select-tipo-gasto', function (e) {       
        window.location.href = "itens.php?token="+$("#pta_titulo").val()+"&tokenT="+$("#select-tipo-gasto option:selected").val();              
    });
   
   
   $('body').on('click', '#informacoes', function(e){            
        $.ajax({
            "url": "/model/pla/pta/request_itens.php",
            "dataType": 'html',
            "data": {
                acao: "listaInfo",
                id: $("#pta_titulo").val()
            },
            "success": function (response) {
                $('#info-2').find('span').html(response);                
            }
        });                
    });
    
    $('body').on('change', '#tipo_gasto_categoria', function (e) {                          
        var $this = $(this);
        
        if($this.find("option:selected").val() == 0){
           $(".infoCentral").hide();  
        }else{
            $("#central").val($this.find("option:selected").attr('lotacao'));
           
            $(".infoCentral").show(); 
        }                            
    });
   
    function changeDetAcao() {
        
        var Dados = {            
            det_acao : $("#det_acao").val()
        }           
        
        $.ajax({
            "url": "/model/pla/pta/request_itens.php",
            "dataType": 'html',
            "data": {
                acao: "infoDetAcao",
                dados: Dados
            },
            "success": function (response) {
                $(".info_det_acao").html(response);                
            }
        });
    }
   
    $('body').on('change', '#det_acao', function (e) {
        changeDetAcao();        
    });
   
    
    $('body').on('click', '#btn-pesquisa', function (e) {
        
        var tipo = $('input[name=optradio]:checked', '#modalItem').val();
        
        var Dados = {            
            nome : $("#nomeItemPesquisa").val()
        } 
        
        if(Dados.nome == "" || Dados.nome.length < 3 || Dados.nome == " "){
            alert("Pesquisa do Item precisa ter no mínimo 3 caracteres");
            return;
        }
        
        var acao = "pesquisaItem";
        if(tipo == "C"){
            acao = "pesquisaItemPorCodigo";
        }
        
        $.ajax({
            "url": "/model/pla/pta/request_itens.php",
            "dataType": 'html',
            "data": {
                acao: acao,
                dados: Dados
            },
            "success": function (response) {                    
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
                        
    });
   
   
    $('#modalItem').on('shown.bs.modal', function () {
//        $(this).find('.modal-dialog').css({width:'auto',
//            height:'auto', 
//           'max-height':'100%'});
        $('#nomeItemPesquisa').focus();
    });
    
    $('body').on('keypress', '#nomeItemPesquisa', function (e) {
        var key = e.which;
        if (key == 13) {                
            $("#btn-pesquisa").trigger('click');            
        }        
    });
    
    $('body').on('click', '.selecionaItem', function (e) {      
        
        var $this = $(this);
        
        var item = $this.attr('item');
        $("#pan-codigo").val($this.attr('item'));  
        $("#pan-descricao-codigo").text($this.attr('item'));
        $("#pan-desc-item").text($this.find("td:eq(0)").text());
        $("#pan-item").text($this.find("td:eq(1)").text());
        $("#pan-grupo").text($this.find("td:eq(2)").text());
        $("#pan-sub-grupo").text($this.find("td:eq(3)").text());
        $("#pan-despesa").text($this.find("td:eq(4)").text());
        $("#pan-tipo").text($this.find("td:eq(5)").text());
        
        
        $('#modalItem').modal('hide');
    });
    
    $('body').on('change', '#fonte', function (e, acao, tp_fonte, portaria, convenio) {   
        var $this = $(this);        
        
        var Dados = {            
            fonte : $this.val()
        }
        
        $.ajax({
            "url": "/model/pla/pta/request_itens.php",
            "dataType": 'html',
            "data": {
                acao: "retornaSelectPortConv",
                dados: Dados
            },
            "success": function (response) {                
                $(".selectPortConv").html(response);
                $("#tp_fonte").val(0);
                if(acao == "editar"){
                    console.log(tp_fonte);
                    if(tp_fonte != null){
                        $("#tp_fonte").val(tp_fonte);
                        $("#tp_fonte").trigger('change');
                    }
                    if(portaria != null){
                        $("#portaria").val(portaria);
                    }
                    if(convenio != null){
                        $("#convenio").val(convenio);
                    } 
                }
                               
            }
        });                        
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            
            
            var Dados = {
                pta_titulo: $("#pta_titulo").val(),
                det_acao: $("#det_acao option:selected").val(),    
                material: $("#pan-codigo").val(),
                unid_medida: $("#unid_medida").val(),
                quantidade: $("#quantidade").val(),
                valor: $("#valor").val(),
                tipo_gasto_categoria: $("#tipo_gasto_categoria option:selected").val(),
                tipo_gasto: $("#select-tipo-gasto option:selected").val(),
                fonte: $("#fonte option:selected").val(),
                descricao: $("#descricao").val(),
                tp_fonte: $("#tp_fonte option:selected").val(),
                portaria: $("#portaria option:selected").val(),
                convenio: $("#convenio option:selected").val()                
                
            }
            
            if (Dados.det_acao == 0 || Dados.pta_titulo == "0"
                    || Dados.material == "" || Dados.material == 0
                    || Dados.unid_medida == 0 || Dados.quantidade == "" || Dados.quantidade == 0
                    || Dados.valor == "" || Dados.tipo_gasto_categoria == 0
                    || Dados.fonte == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            
            $.ajax({
                "url": "/model/pla/pta/request_itens.php",
                "dataType": "html",
                "data": {
                    "acao": "salvar",
                    "dados": Dados
                },
                "success": function (response) {                    
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'primary');
                        acaoRealizada();
                        //$('.modal-alert').on('hidden.bs.modal', function (e) {                            
                          //  acaoRealizada();
                        //});                        
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                id: $this.val(),
                pta_titulo: $("#pta_titulo").val(),
                det_acao: $("#det_acao option:selected").val(),    
                material: $("#pan-codigo").val(),
                unid_medida: $("#unid_medida").val(),
                quantidade: $("#quantidade").val(),
                valor: $("#valor").val(),
                tipo_gasto_categoria: $("#tipo_gasto_categoria option:selected").val(),
                tipo_gasto: $("#select-tipo-gasto option:selected").val(),
                fonte: $("#fonte option:selected").val(),
                descricao: $("#descricao").val(),
                tp_fonte: $("#tp_fonte option:selected").val(),
                portaria: $("#portaria option:selected").val(),
                convenio: $("#convenio option:selected").val()                
            }
            
            if (Dados.det_acao == 0 || Dados.pta_titulo == "0"
                    || Dados.material == "" || Dados.material == 0
                    || Dados.unid_medida == 0 || Dados.quantidade == "" || Dados.quantidade == 0
                    || Dados.valor == "" || Dados.tipo_gasto_categoria == 0
                    || Dados.fonte == 0 || Dados.id == ""
                    || Dados.id == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
                        
            $.ajax({
                "url": "/model/pla/pta/request_itens.php",
                "dataType": "html",
                "data": {
                    "acao": "editar",
                    "dados": Dados
                },
                "success": function (response) {                    
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();                     
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.attr("nome");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Item <span class="text-danger">' + item + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Dados = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/pla/pta/request_itens.php",
                        "dataType": "html",
                        "data": {
                            "acao": "rem",
                            "dados": Dados
                        },
                        "success": function (response) {
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);
                                console.log("Parse JSON");
                                console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    console.log('Console Mensagem');
                                    console.log(response);
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'primary');
                                func.fechaModalReload();
                                return false;
                            } else {
                                console.log('Ultimo else');
                                console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });
    });
    
    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();        
                
        var Dados = {            
            id : $(this).val()            
        }          
        
        $.ajax({
            "url": "/model/pla/pta/request_itens.php",
            "dataType": 'html',
            "data": {
                acao: "retornaDadosEdicao",
                dados: Dados
            },
            "success": function (response) {
                                
                              
                try {
                    response = JSON.parse(response);
                } catch (e) {                    
                    console.log(response);
                    return false;
                }
                
                
                
                if(response.tipoMsg == "nao_encontrou"){
                    func.modalAlert(func.msgRegistroNaoEncontrado);
                    $('.modal-alert').on('hidden.bs.modal', function (e) {                        
                        location.reload();
                    });
                }
                if(response.tipoMsg == "ok"){
                    var info = response.msg;
                    
                    $("#det_acao").val(info.id_pta_acao_det);
                    $("#pan-codigo").val(info.cd_desc_material);  
                    $("#pan-descricao-codigo").text(info.cd_desc_material);
                    $("#pan-desc-item").text(info.nm_desc_material);
                    $("#pan-item").text(info.nm_material);
                    $("#pan-grupo").text(info.nm_grupo);
                    $("#pan-sub-grupo").text(info.nm_sub_grupo);
                    $("#pan-despesa").text(info.cd_elemento_despesa);
                    $("#pan-tipo").text(info.tp_material);
                    $("#unid_medida").val(info.id_unidade_medida);
                    $("#quantidade").val(info.qt_pta_item);   
                    $("#valor").val(info.vl_pta_item);
                    $("#tipo_gasto_categoria").val(info.id_tipo_gasto_categoria);
                    $("#fonte").val(info.id_fonte);
                    $("#tp_fonte").val(info.tp_fonte);
                    $("#descricao").val(info.ds_pta_item);
                    //$('#proj_ppa_ati').trigger('change', ['editar', info.eixo, info.acao]);       
                    $("#tipo_gasto_categoria").trigger("change");
                    $("#valor").trigger("keyup");
                    //$("#valor").trigger("focus");                    
                    $("#fonte").trigger("change", ['editar', info.tp_fonte, info.id_portaria, info.id_convenio]);
                    $("#det_acao").trigger("change");
                    
                    $(".btn-salvar").hide();
                    $(".btn-editar").show();
                    $(".btn-editar").val(Dados.id);
                    $('html, body').animate({
                        scrollTop: $('#page-content').offset().top + 'px'
                    }, 'slow');
                    
                }                                

            }
        });              

    });
        
    
    function listaItens(destroi){
                        
        var Dados = {            
            pta_titulo : $("#pta_titulo").val(),
            tipo_gasto : $("#select-tipo-gasto").val()
        }
        
        $.ajax({
            "url": "/model/pla/pta/request_itens.php",
            "dataType": 'html',
            "data": {
                acao: "retornaItens",
                dados: Dados
            },
            "success": function (response) {   
                
                if(destroi == true){                         
                    var oTable = $('.tabela-itens-salvo').dataTable();
                    oTable.fnDestroy();                  
                }                                                  
             
                $(".tabelasItens").html(response);   
                
                var colunaEscondida = [];
                $('.tabela-itens-salvo').each(function(){                    
                    var table = $('#' + $(this).attr('id')).dataTable({
                        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                        "order": [],
                        "language": {
                            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                        },
                        responsive: true,
                        dom: 'Bfrtip',
                        "scrollX": true,
                        buttons: [
                            {
                                extend: 'pageLength'
                            },
                            {
                                extend: 'excelHtml5',
                                text: '<i class="fa fa-file-excel-o"></i> Excel',
                                footer: true,
                                exportOptions: {
                                    columns: function (idx) {
                                        if ($.inArray(idx, colunaEscondida) < 0) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                                footer: true,
                                exportOptions: {
                                    columns: function (idx) {
                                        if ($.inArray(idx, colunaEscondida) < 0) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i> Imprimir',
                                footer: true,
                                exportOptions: {
                                    columns: function (idx) {
                                        if ($.inArray(idx, colunaEscondida) < 0) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }
                                }
                            }
                        ]
                    });
                    $("#" + $(this).attr('id')).show();
                    //console.log($(this).attr('id'));
                });
                return false;
                $.each( $(".tabela-itens-salvo"), function( index, value ) {
                    
                    console.log( index + ": " + value );
                  });
                console.log( $(".tabela-itens-salvo").attr('id') );
                var colunaEscondida = [4];                
                var table = $('.tabela-itens-salvo').dataTable({
                "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                "ordering": false,                
                "language": {
                    "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                },
                responsive: true,            
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
                    {
                        extend: 'pageLength'                  
                    }, 
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',                            
                        exportOptions: {
                            columns: function ( idx ) {
                                        if($.inArray( idx, colunaEscondida ) < 0){
                                            return true;
                                        }else{
                                            return false;
                                        }    
                                    }
                        }
                    },     
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        exportOptions: {
                            columns: function ( idx ) {
                                        if($.inArray( idx, colunaEscondida ) < 0){
                                            return true;
                                        }else{
                                            return false;
                                        }    
                                    }
                        }
                    },                        
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Imprimir',                           
                        exportOptions: {
                            columns: function ( idx ) {                                        
                                        if($.inArray( idx, colunaEscondida ) < 0){
                                            return true;
                                        }else{
                                            return false;
                                        }                                            
                                    }                                    							
                            }                            
                    }
                ]
            });
            //$(".tabela-itens-salvo").show();
            }
        });
        
    }
    
    listaItens(false);
    
    
    function acaoRealizada(){
        
        $("#pan-codigo").val("");  
        $("#pan-descricao-codigo").text("");
        $("#pan-desc-item").text("");
        $("#pan-item").text("");
        $("#pan-grupo").text("");
        $("#pan-sub-grupo").text("");
        $("#pan-despesa").text("");
        $("#pan-tipo").text("");
        
      
        
        $("#unidade_medidia").val(0);
        $("#quantidade").val("");
        $("#valor").val("");
        $("#descricao").val("");
        $("#valor").trigger("keyup");
        listaItens(true);
        
    }
    
    
    $('body').on('click', '.btn-informacoes', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var Dados = {
                id : $this.val()
            }
            
            $.ajax({
                "url": "/model/pla/pta/request_itens.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaInfoDoItem",
                    dados: Dados
                },
                "success": function (response) {           
                    $("#modalInformacoes").find('.modal-body').html(response);
                    $("#modalInformacoes").modal('show');

                }
            });                                      
        }
    });
    
    $('body').on('click', '.pesquisaSaldoFonte', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var Dados = {                
                pta_titulo: $("#pta_titulo").val()
            }                        
            
            $.ajax({
                "url": "/model/pla/pta/request_itens.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaLimiteFonte",
                    dados: Dados
                },
                "success": function (response) {           
                    $("#modalValoresLimite").find('.modal-body').html(response);
                    $("#modalValoresLimite").modal('show');

                }
            });                                      
        }
    });
    
    $('body').on('change', '#tp_fonte', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            if($("#tp_fonte option:selected").val() != 0){
                $("#portaria").val(0);                
                $('#portaria').prop('disabled', true);
                $("#convenio").val(0);                
                $('#convenio').prop('disabled', true);
            }else{
                $('#portaria').prop('disabled', false);
                $('#convenio').prop('disabled', false);
            }
            
        }
    });
    
   
});