$(document).ready(function () {

    func = new Funcoes();
                           
    $('body').on('change', '#acao', function (e) {        
        var Dados = {            
            id : $('#acao option:selected').val()            
        }   
        if(Dados.id == 0 || Dados.id == ""){        
            $('#infoAcao').html(" ");
            return false;
        }        
        var enc = JSON.stringify(Dados);              
        $.ajax({
            "url": "/model/pla/pas/request_indicador.php",
            "dataType": 'html',
            "data": {
                acao: "retornaDadosAcao",
                dados: enc
            },
            "success": function (response) {                       
                $('#infoAcao').html(response);             
            }
        });         
    });
    
    
    $('body').on('click', '#addIndicador', function(e){
        var id = $('#indicador option:selected').val();
        var nome = $('#indicador option:selected').text();
        var duplicado = 0;
        if(id == 0){
            return;
        }
        $( ".crossTabelaLista" ).each(function() {            
            if(id == $( this ).find('.valorIndicador').attr('value')){
                duplicado = 1;                
                return;
            }
        });
        if(duplicado == 1){
            return;
        }
        $('#tabelaLista').find('tbody').append('<tr><td>'+nome+'</td>\n\
            <td class="text-center crossTabelaLista excluirHtml add" role="button">\n\
                <p class="fa fa fa-times inputPFa text-danger valorIndicador" value="'+id+'"></p></td>\n\
            </tr>');       
    });
    
    $('body').on('click', '.excluirHtml', function(e){
        $(this).closest('tr').remove();
    });
    
    function lista() {        
        var Dados = {            
            pas : $("#pas").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request_indicador.php",
            "dataType": 'html',
            "data": {
                acao: "retornaPasAcao",
                dados: Dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabela', response, [4], true);
            }
        });
    }
    
    lista();
              
   $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {            
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var indicadores = [];
           
            $(".crossTabelaLista" ).each(function() {            
                indicadores.push($( this ).find('.valorIndicador').attr('value'));                    
            });
                     
            var Dados = {
                acao: $("#acao option:selected").val(),
                pas: $("#pas").val(),     
                indicadores: indicadores
            }
           
            if (Dados.acao == 0 || Dados.acao == "" 
                    || Dados.pas == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }                   
            
            if(Dados.indicadores.length <= 0){
                func.modalAlert('Não foi selecionado nenhum Indicador de Saúde');
                $this.prop("disabled", false);
                return false;
            }
                        
            
            $.ajax({
                "url": "/model/pla/pas/request_indicador.php",
                "dataType": "html",
                "data": {
                    "acao": "cad",
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
    
    //$('#acao').prop('disabled', true);
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            
            var indicadores = [];
           
            $(".crossTabelaLista" ).each(function() {   
                if($(this).hasClass('add')){
                    indicadores.push(['add', $( this ).find('.valorIndicador').attr('value')]);                    
                }else if($( this ).find('.valorIndicador').is(':checked')){                    
                    indicadores.push(['rem', $( this ).find('.valorIndicador').attr('value')]);                    
                }                
            });
            
            var Dados = {
                acao: $("#acao option:selected").val(),
                pas: $("#pas").val(),     
                indicadores: indicadores,
                id: $this.val()
            }
            
            if (Dados.acao == "0" || Dados.pas == "0" || Dados.acao == ""
                    || Dados.id == "" || Dados.id == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            $.ajax({
                "url": "/model/pla/pas/request_indicador.php",
                "dataType": "html",
                "data": {
                    "acao": "edt",
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
                        func.fechaModalReload()                        
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
            title: 'Caixa de Confirmação',
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
                        id: id,
                        pas: $("#pas").val()
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/pla/pas/request_indicador.php",
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
                                func.fechaModalReload()  
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
    
    
    $('body').on('click', '.btn-edit', function(e){
        
        var Dados = {            
            id : $(this).val(),
            pas: $("#pas").val()
        }         
        $('#tabelaLista').find('tbody').html("");
        $("#acao").val("");        
        if (Dados.id == "") {
            func.modalAlert(func.msgPreencherCampos);
            $this.prop("disabled", false);
            return false;
        }        
        $.ajax({
            "url": "/model/pla/pas/request_indicador.php",
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
                    return false;
                }
                if(response.tipoMsg == "ok"){
                    var info = response.msg;                    
                    $("#acao").val(info.id_acao);
                    $("#acao").trigger('change');
                    $('#acao').prop('disabled', true);
                    var indicadores = response.msg.indicadores;
                    if(Object.keys(indicadores).length > 0){
                        $.each(indicadores, function( i, l, k ){
                            $('#tabelaLista').find('tbody').append('<tr><td>'+l+'</td>\n\
                                    <td class="text-center crossTabelaLista rem">\n\
                                        <input type="checkbox" value="'+i+'" class="magic-checkbox valorIndicador" role="button" />\n\
                                        </td>\n\
                                    </tr>');
                            //console.log( "Index #" + i + ": " + l);
                        });                        
                    }                                                                                                    
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
    
    $('body').on('click', '#informacoes', function(e){
        var idPas = $("#pas").val();        
        $.ajax({
            "url": "/model/pla/pas/request_indicador.php",
            "dataType": 'html',
            "data": {
                acao: "listaInfo",
                pas: idPas
            },
            "success": function (response) {
                $('#info-2').find('span').html(response);                
            }
        });                
    });
         
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });
   

    $('body').on('click', '.btn-nova-acao', function (e) {
        window.location.href = "pas_acao_novo.php?token="+$("#pas").val();         
    });


});
