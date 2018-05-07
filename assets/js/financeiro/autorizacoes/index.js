/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
func = new Funcoes();

function listaLotacaoCombo() {
    $.ajax({
        "url": "/model/financeiro/autorizacoes/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption"
        },
        "success": function (response) {
            //console.log(response);
            $("#id_lotacao").append(response);
            $("#id_lotacao").select2({
                width: " 100%"
            });
        }
    });
}
listaLotacaoCombo();

function listaPessoaContratoCombo() {
    $.ajax({
        "url": "/model/financeiro/autorizacoes/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaContratoOption"
        },
        "success": function (response) {
            $("#id_pessoa").append(response);
            $("#id_pessoa").select2({
                width: " 100%"
            });
        }
    });
}
listaPessoaContratoCombo();

function listaAutorizacoes(){
    $.ajax({
        "url": "/model/financeiro/autorizacoes/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaAutorizacoes"
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}
listaAutorizacoes();

$(document).ready(function () {
   
    $("#dt_ini").mask("99/99/9999");
    $("#dt_fim").mask("99/99/9999");
    
    //datapiker, plugins para data
    $('#dt_ini').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });    
     //datapiker, plugins para data
    $('#dt_fim').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
    
    //Combo box dos tipos de autorizações
    $("#tipo_autorizacao").select2({
        width: " 100%"
    });

    //Esconde o campo de lotação quando a Autorização não precisar da mesma
    $('body').on('change', "#tipo_autorizacao", function(){
        if ($("#tipo_autorizacao option:selected").attr('lotacao') != '1' && $("#tipo_autorizacao option:selected").val() > 0) {
            $("#campo_lotacao").hide();
        } else {
            $("#campo_lotacao").show();
        }
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);


            var Dados = {
                autorizacao: $("#tipo_autorizacao option:selected").val(),
                lotacao: $("#id_lotacao option:selected").val(),
                pessoa: $("#id_pessoa option:selected").val(),  
                dt_ini: $("#dt_ini").val(),
                dt_fim: $("#dt_fim").val()
            };


            if ((Dados.lotacao == "0" && (Dados.autorizacao == '1' || Dados.autorizacao == '2')) || Dados.pessoa == "0" || Dados.autorizacao == "0"
                    || Dados.dt_ini == "" || Dados.dt_fim == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/financeiro/autorizacoes/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrar_autorizacao",
                    "dados": Dados
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
                            top.location.href = "/pages/financeiro/autorizacoes/index.php";
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
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        
        //ID da autorização a ser removida
        var id = $this.val(); 
        
        //Tipo da autorização a ser excluída
        var autorizacao = $this.attr('tp_aut');
        
        
        var item = $this.closest('tr').find('td:eq(0)').text()+" - "+$this.closest('tr').find('td:eq(1)').text();

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
                        autorizacao: autorizacao
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/financeiro/autorizacoes/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluir_autorizacao",
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
                                //Reload após deletar o registro
                                location.reload();
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

        var $this = $(this);
        //ID da autorização a ser removida
        var id = $this.val(); 
        //Tipo da autorização a ser excluída
        var autorizacao = $this.attr('tp_aut');
        
        var Dados = {
            autorizacao: autorizacao,
            id: id
        }
        
        $.ajax({
            "url": "/model/financeiro/autorizacoes/request.php",
            "dataType": "html",
            "data": {
                "acao": "retornaAutorizacao",
                "dados": Dados
            },
            "success": function (response) {
//                console.log(response);
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
                        func.modalAlert(response);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
//                    func.modalAlert(response.msg, 'primary');
                    var info = response.msg;
                    $("#id_pessoa").val(info.id_pessoa).select2();
                    
                    if (info.id_lotacao){
                        $("#id_lotacao").val(info.id_lotacao).select2();   
                    } else {
                        $("#campo_lotacao").hide();
                    }
                    $("#dt_ini").val(info.dt_ini);
                    $("#dt_fim").val(info.dt_fim);
                    $("#tipo_autorizacao").val(info.tipo_autorizacao)
                                          .select2()
                                          .prop("disabled",true);
                    $(".btn-salvar").hide();
                    $(".btn-editar").show();
                    $('.btn-editar').val(info.id_autorizacao)
                    $('html, body').animate({
                        scrollTop: $('#page-content').offset().top + 'px'
                    }, 'slow');
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
    });
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);
            var id = $this.val()
            $this.prop("disabled", true);


            var Dados = {
                autorizacao: $("#tipo_autorizacao option:selected").val(),
                lotacao: $("#id_lotacao option:selected").val(),
                pessoa: $("#id_pessoa option:selected").val(),  
                dt_ini: $("#dt_ini").val(),
                dt_fim: $("#dt_fim").val(),
                id: id
            };


            if ((Dados.lotacao == "0" && (Dados.autorizacao == '1' || Dados.autorizacao == '2')) || Dados.pessoa == "0" || Dados.autorizacao == "0"
                    || Dados.dt_ini == "" || Dados.dt_fim == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/financeiro/autorizacoes/request.php",
                "dataType": "html",
                "data": {
                    "acao": "atualizar_autorizacao",
                    "dados": Dados
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
                            top.location.href = "/pages/financeiro/autorizacoes/index.php";
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
    
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $("#campo_lotacao").show();
        $("#id_pessoa").val(0).select2();
        $("#id_lotacao").val(0).select2();
        $("#tipo_autorizacao").val(0).select2().prop("disabled",false);
        $("#dt_ini").val("");
        $("#dt_fim").val("");
        $("#id_lotacao").show();

    });
});