
function Funcoes() {

    this.msgErroPadrao = "Ocorreu um Erro, Por favor, contate o administrador do sistema.";
    this.msgSenhaNaoIgual = "O Campo Nova Senha precisa ser igual ao Repetir Nova Senha.";
    this.msgSenhaAlteradaSucesso = "Senha Alterada com Sucesso.";
    this.msgSistemaManutencao = "Sistema em Manutenção.";
    this.msgPreencherCampos = "Por Favor Preencha os Campos Necessários.";
    this.msgSemPermissao = "Você não tem permissão para esta ação.";
    this.msgAcaoSucesso = "Ação Realizada com Sucesso.";
    this.msgPerguntaRemover = "Deseja Remover?";
    this.msgRegistroNaoEncontrado = "Registro não encontrado";
    this.msgCaixaDeConfirmacao = "Confirmação";
    //********************************************************************************************************************
    this.extrairCarater = function (str, x) {
        return str.split(x).join('');
    }
//********************************************************************************************************************

    /**
     * 
     * @param {type} texto
     * @param {type} cor success, warning, primary, danger, info
     * @returns {undefined}
     */
    this.modalAlert = function (texto, cor) {
        var classeN = ['alert-success', 'alert-warning', 'alert-primary', 'alert-danger', 'alert-info', 'alert-default'];
        if (typeof cor !== 'undefined') {
            $('.modal-alert').find('.alert').removeClass(classeN.join(' ')).addClass('alert-' + cor);
        } else {
            $('.modal-alert').find('.alert').removeClass(classeN.join(' ')).addClass('alert-warning');
        }
        $('.modal-alert').find('.textoModal').text(texto);
        $('.modal-alert').modal('show');
    }

    /**
     * Carrega as funcionalidade do dataTable padrão para utilização nas telas
     * @param string nomeTabela
     * @param object response
     * @param array colunaEscondida
     * @param destroi destroi = true ela destroi a tabela já criada, false ela não destroi
     * @returns true
     */
    this.carregaTabelaPadrao = function (nomeTabela, response, colunaEscondida, destroi = false) {

        if (destroi == true) {
            var oTable = $('#' + nomeTabela).dataTable();
            oTable.fnDestroy();
        }

        $("#" + nomeTabela).find("tbody").html(response);
        var table = $('#' + nomeTabela).dataTable({
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
                    orientation: 'landscape',
                    pageSize: 'TABLOID',
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
        $("#" + nomeTabela).show();
    }

    /**
     * Carrega as funcionalidade do dataTable padrão para utilização nas telas
     * @param string nomeTabela
     * @param object response
     * @param object foot
     * @param array colunaEscondida
     * @param destroi destroi = true ela destroi a tabela já criada, false ela não destroi
     * @returns true
     */
    this.carregaTabelaPadraoFoot = function (nomeTabela, response, foot, colunaEscondida, destroi = false) {

        if (destroi == true) {
            var oTable = $('#' + nomeTabela).dataTable();
            oTable.fnDestroy();
        }

        $("#" + nomeTabela).find("tbody").html(response);
        $("#" + nomeTabela).find('tfoot').html(foot);
        var table = $('#' + nomeTabela).dataTable({
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
        $("#" + nomeTabela).show();
    }



    this.fechaModalReload = function () {
        $('.modal-alert').on('hidden.bs.modal', function (e) {
            location.reload();
        });
    }
    
    /**
     * 
     * @param string valor
     * @returns string
     */
    this.converteValorIng = function(valor){
        valor = valor.replace('.' , '');
        valor = valor.replace(',' , '.');
        return valor;
    }
    
    /**
     * 
     * @param string valor
     * @returns float
     */
    this.converteValorIngFloat = function(valor){
        valor = valor.replace('.' , '');
        valor = parseFloat(valor.replace(',' , '.'));
        return valor;
    }


}


$('body').keyup(function (e) {
    if (e.keyCode == 32) {
        $('.modal-alert').modal('hide');
    }
});
$(document).ajaxStart(function () {
    $.LoadingOverlay("show");
});
$(document).ajaxStop(function () {
    $.LoadingOverlay("hide");
});
$('.loadAjax').on('click', function () {
    $.LoadingOverlay("show");
});
$('body').on('click', '.loadAjax', function () {
    $.LoadingOverlay("show");
});
function somenteNumeros(num) {
    var er = /[^0-9.]/;
    er.lastIndex = 0;
    var campo = num;
    if (er.test(campo.value)) {
        campo.value = "";
    }
}

