
$(document).ready(function () {        
    
    //instacinado fucoes js
    func = new Funcoes();
    //Mascara do sistema
    $('.data').mask("99/99/9999")
    //fim
    $(".select").select2({
        width: " 100%"
    });    
    $(".select_funcionarios").select2();  

    //Carrega Gestores, Fiscais, Sub-Fiscais
    $.ajax({
        "url": "/model/compras/gestaoContratos/aditamento/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaOptionsGestores"
        },
        "success": function (response) {
            $("body").find(".select_funcionarios").html(response);
        }
    });
    //fim
    
    $('body').on('click', '.add-pessoa', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            
            var select = $this.closest(".input-group").clone();
            select.find(".add-pessoa").find('i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
            select.find(".add-pessoa").addClass('remove-pessoa btn-danger').removeClass('add-pessoa btn-primary');            
            select.css("margin-top", "5px");
            $this.closest(".input-group").after(select);
            $this.closest(".col-sm-6").find('.remove-pessoa').first().closest('.input-group').find('.select2-selection--single').remove();
            $this.closest(".col-sm-6").find('.remove-pessoa').first().closest('.input-group').find('.select2-container').remove();           
            $this.closest(".col-sm-6").find('.remove-pessoa').first().closest('.input-group').find('.select_funcionarios').select2({width: "100%"});            
            
            console.log(select);
        }
    });


    //busca produtos
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });
    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        if (dados == "" || dados.length < 2 || dados == " ") {
            alert("Pesquisa do Item precisa ter no mínimo 2 caracteres");
            return;
        }
        $.ajax({
            "url": "/model/compras/gestaoContratos/aditamento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "pesquisaContrato",
                "dados": dados

            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $('body').on('click', '.selecionaItem', function (e) {
        
//        var itinerarioOriginal = $("#id_diaria_destino").data('itinerario');
//
//    if (itinerarioOriginal != null){
//        var linha = `<tr data-itinerario='${JSON.stringify(itinerarioOriginal)}'>
//                        <td>${itinerarioOriginal.ds_cidade_inicio}</td>
//                        <td>${itinerarioOriginal.ds_cidade_fim}</td>
//                        <td>${itinerarioOriginal.dh_inicio}</td>
//                        <td>${itinerarioOriginal.dh_fim}</td>
//                        <td>${valorComMascara(itinerarioOriginal.vl_total)}</td>
//                        <td><span role='button' class="remove-itinerario">Remover</span> | <span role='button' class="edit-itinerario">Alterar</span></td>
//                     </tr>`;
//        $("#itinerario").find("tbody").append(linha);
//        limpaFormItinerario();
//    }
        var contrato = $(this).data('contrato');
        console.log(contrato);
        console.log(contrato.nr_contrato);
        
        
        var $this = $(this);
        var processo = $this.attr('processo');
        $("#id_processo").val(processo);
        $("#itemGrp").val($this.attr('item'));
        $("#ada_cpr").text($this.find("td:eq(0)").text());
        $("#licitacao").text($this.find("td:eq(1)").text());
        $("#categoria").text($this.find("td:eq(2)").text());
        $("#obejto").text($this.find("td:eq(3)").text());
        $("#modalidade").text($this.find("td:eq(4)").text());
        $('#modalItem').modal('hide');
        //lista os tipo de gastos da licitação
        //retornaTipoDeGastoLicitacao($this.attr('processo'));
        
        $.ajax({
            "url": "/model/compras/contrato/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsAtas",
                "dados": $this.find("td:eq(4)").text()

            },
            "success": function (response) {
                //console.log(response);
                if (response != 'NotSRP') {
                    $(".campoAta").removeClass("hidden");
                    $("body").find("#ata").html(response);
                } else {
                    $(".campoAta").addClass("hidden");
                }
            }
        });
    });
    //fim de busca licitacao do gcon
    
    $('body').on('click', '.salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            $("select[name=subFiscais\\[\\]]").each(function () {
                subFiscais.push($(this).val());
            });
        }
    });
  

});
