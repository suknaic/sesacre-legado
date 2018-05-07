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
    
    //select2
    $("#rede").select2();
    
    //Desabilitando campos
    $("body").on("change","#portaria", function() {
        var texto = $(this).val();
        if(texto != 0) {
            document.getElementById("rede").disabled = true;
        } else{
            document.getElementById("rede").disabled = false;
        }
    });
    $("body").on("change","#rede", function() {
        var texto = $(this).val();
        if(texto != 0) {
            document.getElementById("portaria").disabled = true;
        } else{
            document.getElementById("portaria").disabled = false;
        }
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

    $('body').on('click', '.btn-edit', function (e) {
        var id_portaria = $(this).attr('value');
        top.location = "/pages/orcamento/bloco_orcamentario/cadastrar/portaria/cad_portaria.php?idPortaria="+id_portaria;
    });

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Portaria = {
                nm: $("#portaria").val(),
                id_rede: $("#rede").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/blocOrcamentario/portaria/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listaraPortaria",
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
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        //destruindo o datatable para não da bug
                        var oTable = $('#tabela_port').dataTable();
                        oTable.fnDestroy();
                        //criando o datable novamente
                        $("#retorno").html(response.msg);
                        $('#tabela_port').DataTable({
                            "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
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
                                        columns: function (idx) {
                                            if ($.inArray(idx) < 0) {
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
                                    exportOptions: {
                                        columns: function (idx) {
                                            if ($.inArray(idx) < 0) {
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
                                    exportOptions: {
                                        columns: function (idx) {
                                            if ($.inArray(idx) < 0) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        }
                                    }
                                }
                            ]
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

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var idPortaria = $this.val();
        var nmPortaria = $this.closest('td').find('.btn-edit').attr("portaria");
        
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem certeza que deseja continuar com a exclusão da portaria <span class="text-danger">' + nmPortaria + '</span> ?',
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
                    var Portaria = {
                        id: idPortaria,
                        nome: nmPortaria
                    };

                    if (idPortaria == "" && nmPortaria == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/orcamento/blocOrcamentario/portaria/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerPortaria",
                            "portaria": Portaria
                        },
                        "success": function (response) {
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
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        }
                    });
                }
            }
        });
    });
});
