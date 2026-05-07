$(document).ready(function () {

    func = new Funcoes();
  
    function listaEixo() {
        var pes = $("#pes").val();
        $.ajax({
            "url": "/model/pla/eixo/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEixoTable",
                pes: pes
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [2]);

            }
        });
    }
    listaEixo();
    
    $('body').on('click', '#addProjAti', function(e){
        var id = $('#proj_ppa_ati option:selected').val();
        var nome = $('#proj_ppa_ati option:selected').text();
        var duplicado = 0;
        if(id == 0){
            return;
        }
        $( ".crossTabelaLista" ).each(function() {            
            if(id == $( this ).find('.valorProjAti').attr('value')){
                duplicado = 1;                
                return;
            }
        });
        if(duplicado == 1){
            return;
        }
        $('#tabelaLista').find('tbody').append('<tr><td>'+nome+'</td>\n\
            <td class="text-center crossTabelaLista excluirHtml add" role="button">\n\
                <p class="fa fa fa-times inputPFa text-danger valorProjAti" value="'+id+'"></p></td>\n\
            </tr>');       
    });
    
    $('body').on('click', '.excluirHtml', function(e){
        $(this).closest('tr').remove();
    });
    

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var projAti = [];
           
            $(".crossTabelaLista" ).each(function() {            
                projAti.push($( this ).find('.valorProjAti').attr('value'));                    
            });
                     
            var Eixo = {
                pes: $("#pes").val(),
                ordem: $("#ordem").val(),
                nome: $("#nome").val(),  
                proj_ati: projAti
            }
           
            if ($("#pes").val() == "" || $("#ordem").val() == "" 
                    || $("#nome").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/pla/eixo/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadEixo",
                    "eixo": Eixo
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
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
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
            
            var projAti = [];
           
            $(".crossTabelaLista" ).each(function() {   
                if($(this).hasClass('add')){
                    projAti.push(['add', $( this ).find('.valorProjAti').attr('value')]);                    
                }else if($( this ).find('.valorProjAti').is(':checked')){                    
                    projAti.push(['rem', $( this ).find('.valorProjAti').attr('value')]);                    
                }                
            });
                        
            var Eixo = {
                pes: $("#pes").val(),
                ordem: $("#ordem").val(),
                nome: $("#nome").val(),                
                id: $this.val(),
                proj_ati: projAti
                
            }                        

             if ($("#pes").val() == "" || $("#ordem").val() == "" || $("#nome").val() == ""
                    || $this.val() == "") {               
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/pla/eixo/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edtEixo",
                    "eixo": Eixo
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
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
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
        var item = $this.closest('td').find('.btn-edit').attr("nome");

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
                    var Eixo = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/pla/eixo/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remEixo",
                            "eixo": Eixo
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
                                func.modalAlert(response.msg);
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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
        var id = $(this).val();               
        var Eixo = {
            id: id
        }
        $('#tabelaLista').find('tbody').html("");
        $("#nome").val("");
        $("#ordem").val("");
        if (id == "") {
            func.modalAlert(func.msgPreencherCampos);
            $this.prop("disabled", false);
            return false;
        }
        $.ajax({
            "url": "/model/pla/eixo/request.php",
            "dataType": "html",
            "data": {
                "acao": "retornaDadosParaEdicao",
                "eixo": Eixo
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
                    
                    $("#nome").val(response.msg.nm_eixo);
                    $("#ordem").val(response.msg.nr_ordem);
                    var ppa_proj_ati = response.msg.ppa_proj_ati;
                    if(Object.keys(ppa_proj_ati).length > 0){
                        $.each(ppa_proj_ati, function( i, l, k ){
                            $('#tabelaLista').find('tbody').append('<tr><td>'+l+'</td>\n\
                                    <td class="text-center crossTabelaLista rem">\n\
                                        <input type="checkbox" value="'+i+'" class="magic-checkbox valorProjAti" role="button" />\n\
                                        </td>\n\
                                    </tr>');
                            //console.log( "Index #" + i + ": " + l);
                        });                        
                    }
                    
                    $('.btn-editar').val(id);                    
                    $('.btn-salvar').hide();
                    $('.btn-editar').show();
                    $('html, body').animate({
                        scrollTop: $('#page-content').offset().top + 'px'
                    }, 'slow');
                    
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
    });
    
    $('body').on('click', '#informacoes', function(e){
        var idPes = $("#pes").val();        
        $.ajax({
            "url": "/model/pla/eixo/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaInfo",
                pes: idPes
            },
            "success": function (response) {
                $('#info-2').find('span').html(response);                
            }
        });                
    });
    
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $("#nome").val("");
        $("#ordem").val("");        

    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });            

    $('body').on('keypress', '.formEixo', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });

});
