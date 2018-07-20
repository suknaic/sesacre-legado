func = new Funcoes();

$(document).ready(function () {
    
    function lista() {
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaTable"
            },
            "success": function (response) {            
                func.carregaTabelaPadrao('tabela', response, [2]);
            }
        });
    }
    lista();
    
    function decretoCombo(){
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "returnDecretoOption"
            },
            "success": function (response) {            
                $("#id_decreto").html(response);
            }
        });
    }
    
    decretoCombo();
    
    function listaClasseCombo(decreto,classe) {
        var PARAMETROS = {
            decreto: decreto,
            classe: classe
        };  
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "returnClasseOption",
                dados: PARAMETROS
            },
            "success":
                    function (response) {
                        $("#id_classe").html(response);
                    }
        });
    }
    
    $('body').find('select').select2({
        
    });
    
    $('#vl_decreto_valor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    $('#id_decreto').on('change', function(e){
        e.preventDefault();
        var decreto = $("#id_decreto option:selected").val();
        var classe = $("#id_classe_default").val();
        console.log(decreto);
        if (decreto == "0" || decreto == "") {
            $("#id_classe").html("<option value='0'>Selecione a classe</option>");
        } else {
            listaClasseCombo(decreto,classe);
        }
        
    });
    
    
    //*********************************SALVAR***********************************
    $('body').on('click','.btn-salvar', function(e){
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true); //Desabilita o botão enquanto executa a operação
            
            //Carrega os dados do formulário
            var DADOS = {
                decreto: $("#id_decreto option:selected").val(),
                classe: $("#id_classe option:selected").val(),
                tipo: $("#tp_decreto_valor option:selected").val(),
                valor: $("#vl_decreto_valor").val()
            };
            
            if (DADOS.decreto == "0" || DADOS.classe == "0" || DADOS.tipo == "" || DADOS.valor == "" || DADOS.valor == "0,00") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            $.ajax({
                "url": "/model/diarias/decreto_valor/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "cadastrarDecretoValor",
                    "dados": DADOS
                },
                "success": function (response) {
//                    console.log(response);
                    $this.prop("disabled", false);
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location = "/pages/index.php";
                        });
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
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    })
    //*******************************FIM SALVAR*********************************
    
    
    //*********************************EDITAR***********************************
    $('body').on('click','.btn-alterar',function(e){
       var $this = $(this);
       var linha = $this.closest('tr').data('registro');
       
       $("#id_decreto_valor").val(linha.id_decreto_valor);
       $("#id_classe_default").val(linha.id_classe);
       $("#id_decreto").val(linha.id_decreto).trigger('change');
       $("#tp_decreto_valor").val(linha.tp_decreto_valor).trigger('change.select2');
       $("#vl_decreto_valor").val(linha.vl_decreto_valor);
       
       $(".btn-salvar").hide();
       $(".btn-editar").show();
       
       $('html, body').animate({
            scrollTop: $('#formTop').offset().top + 'px'
        }, 'slow');
//       $('body').find('select').trigger('change');
    });
    //*****************************FIM EDITAR***********************************
    
    //********************************REMOVER***********************************
    $('body').on('click', '.btn-excluir', function (e) {

        var $this = $(this);
            
        var dados = $this.closest('tr').data('registro');
        var item = dados.nm_decreto + ' | Classe: ' + dados.cd_classe + ' - ' + dados.nm_classe + ' | Valor: ' + dados.vl_decreto_valor;
        var id = dados.id_decreto_valor;

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
                        id: id
                    }

                    if (Dados.id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/diarias/decreto_valor/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirDecretoValor",
                            "dados": Dados
                        },
                        "success": function (response) {
                            console.log(response);
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
                                //Reload após deletar o registro
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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
    //********************************FIM REMOVER*******************************
    
    //******************************SALVAR EDIÇÃO*******************************
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);
            var id = $this.val()
            $this.prop("disabled", true);


            var Dados = {
                id: $("#id_decreto_valor").val(),
                decreto: $("#id_decreto option:selected").val(),
                classe: $("#id_classe option:selected").val(),
                tipo: $("#tp_decreto_valor option:selected").val(),  
                valor: $("#vl_decreto_valor").val()
            };


            if (Dados.decreto == "0" || Dados.classe == "0" || Dados.tipo == "0" || Dados.valor == "0,00"
                    || Dados.valor == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/diarias/decreto_valor/request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "alteraDecretoValor",
                    "dados": Dados
                },
                "success": function (response) {
                    console.log(response);
                    $this.prop("disabled", false);
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location = "/pages/index.php";
                        });
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
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);
        }
    });
    //****************************FIM SALVAR EDIÇÃO*****************************
    
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').hide();
        $('#id_decreto_valor').val(0);
        $('#id_classe_default').val(0);
        $("#id_decreto").val("0").select2();
        $("#id_classe").val("0").select2();
        $("#tp_decreto_valor").val("0").select2();
        $("#vl_decreto_valor").val("");

    });
});

