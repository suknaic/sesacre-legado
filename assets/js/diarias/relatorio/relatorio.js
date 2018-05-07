

function carregaTabela(nomeTabela, response, colunaEscondida, destroi = false) {

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
            }
        ]
    });
    $("#" + nomeTabela).show();
}

function limpaFormDestino(){
    $("#id_relatorio_destino").val(0);
    $("#ds_cidade_inicio").val('');
    $("#id_cidade_inicio").val(0);
    $("#dh_inicio").val('');
    $("#ds_cidade_fim").val('');
    $("#id_cidade_fim").val(0);
    $("#dh_fim").val('');
    $("#id_transporte").val(0);
    $("#id_transporte_tipo").val(0);
    $("#ds_transporte_tipo").val('');

    $(".btn-editar").hide();
    $(".btn-cancelar").hide();
    $(".add-destino").show();
    $(".btn-limpar").show();
    atualizaCombos();
}
limpaFormDestino();

function atualizaCombos(){
    //Dispara a trigger do select2 para mudar os valores dos input do tipo Select
    $('#formDestino').find('select').trigger('change');
}

function editaLinhaDestino(dadosLinha){

    $(".btn-editar").show();
    $(".btn-cancelar").show();
    $(".add-destino").hide();
    $(".btn-limpar").hide();
    
    //Aqui irá guardar as informações originais em caso do usuário cancelar a alteração
    $("#id_relatorio_destino").data('destino',dadosLinha);
    
    //AQUI IRÁ RECEBER OS DADOS DA LINHA QUE DESEJA EDITAR E ATRIBUIRÁ AO FORMULÁRIO DA PÁGINA
    for( var dado in dadosLinha){
        var atributo_id = "#" + dado;
        $(atributo_id).val(dadosLinha[dado]);
    };
    $('html, body').animate({
        scrollTop: $('#viagem').offset().top + 'px'
    }, 'slow');
    atualizaCombos();
}

function encapsulaDadosDoFormDestino(){

    var Destino = {
        id_relatorio_destino: $("#id_relatorio_destino").val(),
        ds_cidade_inicio: $("#ds_cidade_inicio").val(),
        id_cidade_inicio: $("#id_cidade_inicio").val(),
        dh_inicio: $("#dh_inicio").val(),
        ds_cidade_fim: $("#ds_cidade_fim").val(),
        id_cidade_fim: $("#id_cidade_fim").val(),
        dh_fim: $("#dh_fim").val(),
        id_transporte: $("#id_transporte").val(),
        id_transporte_tipo: $("#id_transporte_tipo").val(),
        ds_transporte_tipo: $("#ds_transporte_tipo").val()
    };
    
    
    if(Destino.ds_cidade_inicio === '' || Destino.ds_cidade_fim === ''
            || Destino.dh_inicio === '' || Destino.dh_fim === ''
            || Destino.id_transporte === 0 || Destino.id_transporte_tipo === 0) {
        func.modalAlert(func.msgPreencherCampos);
        return false;
    }
    
    if(Destino.id_cidade_inicio === Destino.id_cidade_fim){
        func.modalAlert('Cidade de origem deve ser diferente da cidade de destino.');
        return false;
    }
    
     //Validar data e hora de início e fim***********
    $.ajax({
        "url": "/model/diarias/relatorio/request.php",
        "dataType": 'html',
        "data": {
            acao: "validaRelatorioDestino",
            dados: JSON.stringify(Destino)
        },
        "success": function (response) {
            try {
                response = JSON.parse(response);
            } catch (e) {
                func.modalAlert(func.msgErroPadrao);
                console.log("Parse JSON");
                console.log(response);
                return false;
            }
            if (response.tipoMsg === "Erro") {
                func.modalAlert(response.msg);
                return false;
            } else if (response.tipoMsg === "ok") {

                var linha =  `<tr data-destino='${JSON.stringify(Destino)}'>
                    <td>${Destino.ds_cidade_inicio}</td>
                    <td>${Destino.dh_inicio}</td>
                    <td>${Destino.ds_cidade_fim}</td>
                    <td>${Destino.dh_fim}</td>
                    <td><span role="button" class="remove-destino">Remover</span> | <aspan role="button" class="edit-destino">Alterar</span></td>
                 </tr>`;

                $("#destinos").find("tbody").append(linha);    
                limpaFormDestino();
            }
        }
    });
                   
}

function retornaItinerario(){

    var itinerarioOriginal = $("#id_relatorio_destino").data('destino');
    
    if (itinerarioOriginal != null){
        var linha = `<tr data-destino='${JSON.stringify(itinerarioOriginal)}'>
                    <td>${itinerarioOriginal.ds_cidade_inicio}</td>
                    <td>${itinerarioOriginal.dh_inicio}</td>
                    <td>${itinerarioOriginal.ds_cidade_fim}</td>
                    <td>${itinerarioOriginal.dh_fim}</td>
                    <td><span role="button" class="remove-destino">Remover</span> | <span role="button" class="edit-destino">Alterar</span></td>
                 </tr>`;
        $("#destinos").find("tbody").append(linha);    
        limpaFormDestino();
    }
    
}


$(document).ready(function () {
    func = new Funcoes();
    //Combo box dos tipos de autorizações
    $('body').find("select").select2({
    });
    
    $('#dh_inicio').mask("99/99/9999 99:99");
    $('#dh_fim').mask("99/99/9999 99:99");
    
     //datapiker, plugins para data
    $('#dt_relatorio_destino').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
    
    //Essa informação será usada para complementar a informação do anexo
    $("#idRelatorio").val($("#id_relatorio").val());
    
    
    //Preenche o form para edição do itinerario
    $('#destinos').on('click', '.edit-destino', function(e){
       e.preventDefault();
       retornaItinerario();
       var destino = $(this).closest('tr').data('destino');
       $(this).closest('tr').remove();
       editaLinhaDestino(destino);
    });
    
      //Edita o itinerario
    $('body').on('click','.btn-editar', function(e){
        e.preventDefault();
        encapsulaDadosDoFormDestino();
    });
    
    //Inclui o itinerario
    $('body').on('click','.add-destino', function(e){
        e.preventDefault();
        encapsulaDadosDoFormDestino();
    });
    
    //Cancela alteração do itinerario
    $('body').on('click','.btn-cancelar', function(e){
        e.preventDefault();
        retornaItinerario();
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            var retorno = "";
            if ($('#fl_retorno').is(":checked")){
                retorno = "S";
            }else{
                retorno = "N";
            }
            
            //Percorre os destinos
            var destinos = [];
            $("#destinos tbody tr").each(function (e){
                var destino = $(this).data('destino');
                destinos.push(destino);
            });
            
            //Percorre os anexos
            var anexos = [];
            $('#arquivos .form-group').each(function(e){
                var anexo = $(this).data('anexo');
                anexos.push(anexo);
            });
            
                 
            var Relatorio = {
                idDiaria: $("#id_diaria").val(),
                idRelatorio: $("#id_relatorio").val(),
                dsServExec: $("#ds_servico_executado").val(),
                dsLocsExec: $("#ds_locais_executado").val(),
                dtRelDest: $("#dt_relatorio_destino").val(),
                flRet: retorno,  
                destinos: destinos,
                anexos: anexos
                
            };
            
            if (Relatorio.dsServExec == "" || Relatorio.dsLocsExec == ""
                    || Relatorio.dtRelDest == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            if (destinos.length === 0){
                func.modalAlert('Nenhum itinerario foi informado para a diária.');
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/diarias/relatorio/request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "salvarRelatorio",
                    "dados": Relatorio
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
                        //Reload após deletar o registro
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
    
    $('body').on('click', '.remove-destino', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);

            var itinerario = $this.closest("tr").data('destino');

            var mensagem = "Origem: " + itinerario.ds_cidade_inicio + " em " + itinerario.dh_inicio + " / Destino: " + itinerario.ds_cidade_fim + " em " + itinerario.dh_fim;
            bootbox.confirm({
                title: 'Caixa de Confirmação',
                message: 'Você tem Certeza que deseja continuar com a Exclusão do Itinerário do Relatório <span class="text-danger">' + mensagem + '</span>?',
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

                        if (itinerario.id_relatorio_destino > 0) {

                            $.ajax({
                            "url": "/model/diarias/relatorio/request.php",
                            "dataType": "html",
                            "data": {
                                "acao": "excluirRelatorioDestinoIndividual",
                                "id": itinerario.id_relatorio_destino
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
                        $this.closest('tr').remove();
                    }
                }
            });
        }
    });
    
    $('body').on('click','.ver-anexo', function(e){
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            var $this = $(this);

            var anexo = $this.closest(".form-group").data('anexo');
            $.ajax({
                "url": "/model/diarias/relatorio/request.php",
                "dataType": "html",
                "data": {
                    "acao": "abreArquivo",
                    "id": anexo.id_relatorio_anexo
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
    });
    
    $('body').on('click', '.remove-anexo', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);

            var anexo = $this.closest(".form-group").data('anexo');

            var mensagem = "Arquivo: " + anexo.nm_anexo;
            bootbox.confirm({
                title: 'Caixa de Confirmação',
                message: 'Você tem Certeza que deseja continuar com a Exclusão do anexo do Relatório <span class="text-danger">' + mensagem + '</span>?',
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
                            id: anexo.id_anexo,
                            caminho: anexo.path_anexo
                        }

                        $.ajax({
                            "url": "/model/diarias/relatorio/request.php",
                            "dataType": "html",
                            "data": {
                                "acao": "excluirRelatorioAnexoIndividual",
                                "id": anexo.id_relatorio_anexo
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
                    $this.closest('tr').remove();
                    }
                }
            });
        }
    });
});