$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    //menu do bloco orçamentario
    $.ajax({
        "url": "/layout/menus/orcamento/bloco_orcamentario/menu_bloco_orcamentario.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_bloco_orcamentario").html(response);
        }
    });
    
    //Mascara para data
    $("#data").mask("99/99/9999");
    
    //Mascara para valor
    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });

    //datapiker, plugins para data
    $('#data').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    //Fechando o datapicker ao selecionar data
    $('#data').datepicker().on('changeDate', function () {
        $('#data').datepicker('hide');
    });
    
    //buscando o select option
    $("#rede").select2();
    
    $('body').on('click', '.btn-limpar', function (e) {
        $("#portaria").val("");
        $("#data").val("");
        $("#valor").val("");
        $("#rede").select2('val','0');
    });
    
    //metodo para carregar rede tematica no comboBox
    function listarRedeTematica(){
        var id_rede = {
            id: $("#id_rede").val()
        };
        $.ajax({
            "url": "/model/orcamento/blocOrcamentario/portaria/request.php",
            "dataType": "html",
            "data": {
                "acao": "listarRedeTematica",
                "portaria": id_rede
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#rede").append(response);
                }
                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                }
            }
        });
    }
    listarRedeTematica();
    
    $('body').on('click', '.btn-cancelar', function (e) {
       top.location = "/pages/orcamento/bloco_orcamentario/pesquisar/portaria/pesq_portaria.php";
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Portaria = {
                    nome: $("#portaria").val(),
                    data: $("#data").val(),
                   valor: $("#valor").val(),
                    rede: $("#rede").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/blocOrcamentario/portaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarPortaria",
                    "portaria": Portaria
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
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#codigo").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
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
    
    $('body').on('click', '.btn-atualizar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Portaria = {
                      id: $("#id_portaria").val(),
                    nome: $("#portaria").val(),
                    data: $("#data").val(),
                   valor: $("#valor").val(),
                    rede: $("#rede").val(),
                verifica: $("#verifica").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/blocOrcamentario/portaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarPortaria",
                    "portaria": Portaria
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
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#codigo").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                           top.location = "/pages/orcamento/bloco_orcamentario/pesquisar/portaria/pesq_portaria.php";
                        });
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
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
});