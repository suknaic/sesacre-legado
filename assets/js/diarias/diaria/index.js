
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

function listaLotacaoCombo(idPessoa, proponenteProposto) {
    $.ajax({
        "url": "/model/diarias/diaria/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption",
            pessoa: idPessoa,
        },
        "success": function (response) {

            if (proponenteProposto === 1) {
                $("#id_lotacao_proponente").html(response);
            } else {
                $("#id_lotacao_proposto").html(response);
            }

        }
    });
}

function listaContratoFuncao(idPessoa, proponenteProposto) {
    $.ajax({
        "url": "/model/diarias/diaria/request.php",
        "dataType": "html",
        "data": {
            acao: "listaFuncaoOption",
            pessoa: idPessoa
        },
        "success":
                function (response) {
                    if (proponenteProposto === 1) {
                        $("#id_funcao_proponente").html(response);

                    } else {
                        $("#id_funcao_proposto").html(response);
                    }
                }
    });
}


function listaClasseCombo(decreto, classe) {
    var PARAMETROS = {
        decreto: decreto,
        classe: classe
    };
    $.ajax({
        "url": "/model/diarias/diaria/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaClasseOption",
            dados: PARAMETROS
        },
        "success":
                function (response) {
                    $("#id_classe").html(response);
                }
    });
}

function listaHistorico(){
    var id = $("#id_diaria").val();
    
    $.ajax({
        "url": "/model/diarias/diaria/request.php",
        "dataType": 'html',
        "data": {
            acao: 'listaHistoricoTexto',
            id: id
        },
        "success":
            function(response){
                if (response) {
                    $("#historico").html(response);
                    $("#observacoes").show();   
                }
            }
    });
}

function atualizaCombos() {
    //Dispara a trigger do select2 para mudar os valores dos input do tipo Select
    $('#destinoForm').find('select').trigger('change');
}


function editLinhaItinerario(dadosLinha) {

    $(".btn-editar").show();
    $(".btn-cancelar").show();
    $(".add-itinerario").hide();
    $(".btn-limpar").hide();

    //Aqui irá guardar as informações originais em caso do usuário cancelar a alteração
    $("#id_diaria_destino").data('itinerario', dadosLinha);

    //AQUI IRÁ RECEBER OS DADOS DA LINHA QUE DESEJA EDITAR E ATRIBUIRÁ AO FORMULÁRIO DA PÁGINA
    for (var dado in dadosLinha) {
        var atributo_id = "#" + dado;
        
        //Como o combo da classe carrega dinamicamente de acordo com o decreto
        //foi necessario criar uma variavel adicional para controlar o reload dos select2
        if (dado === 'id_classe') {
            var atrAux = atributo_id + '_default';
            $(atrAux).val(dadosLinha[dado]);
        }
        
        //trata o checkbox da fl_pernoite
        if (dado === 'fl_pernoite') {
            var atrAux = atributo_id;
            
            if (dadosLinha[dado] === 'S'){
                $(atrAux).prop("checked", true);
            } else {
                $(atrAux).prop("checked", false);
            }
            
        }
        
        
        //Aqui mascara os valores que vieram do BD sem separador de milhar e . como separador decimal
        //é necessário forçar a máscara para o usuário que está operando
        if (dado === 'vl_diaria_destino' || dado === 'qt_diaria_destino') {
            $(atributo_id).val(valorComMascara(dadosLinha[dado]));
        } else {
            $(atributo_id).val(dadosLinha[dado]);
        }
        
    }
    ;
    $('html, body').animate({
        scrollTop: $('#viagem').offset().top + 'px'
    }, 'slow');
    atualizaCombos();
}

function limpaFormItinerario() {

    $("#id_diaria_destino").removeData('itinerario');
    $("#fl_pernoite").prop("checked", false);
    $("#id_diaria_destino").val(0);
    $("#id_classe_default").val(0);
    $("#id_cidade_inicio").val(0);
    $("#ds_cidade_inicio").val('');
    $("#id_cidade_fim").val(0);
    $("#ds_cidade_fim").val('');
    $("#dh_inicio").val('');
    $("#dh_fim").val('');
    $("#id_transporte").val(0);
    $("#id_decreto_default").val(0);
    $("#id_decreto").val(0);
    $("#id_classe").val(0);
    $("#qt_diaria_destino").val(0);
    $("#vl_diaria_destino").val(0);

    $(".btn-editar").hide();
    $(".btn-cancelar").hide();
    $(".add-itinerario").show();
    $(".btn-limpar").show();
    atualizaCombos();
}
limpaFormItinerario();

function valorComMascara(valor) { 
    var valor = Number(valor).toFixed(2);
    var valorStr = valor.toString();
    valorStr = valorStr.split('.');
    valorStr[0] = valorStr[0].split(/(?=(?:...)*$)/).join('.');
    return valorStr.join(',');
}

function valorSemMascara(valor){
     valor = valor.replace('.' , '');
     valor = parseFloat(valor.replace(',' , '.'));
     return valor;
}

function encapsulaDadosDoFormItinerario() {
    var pernoite = "";
    if ($('#fl_pernoite').is(":checked")) {
        pernoite = "S";
    } else {
        pernoite = "N";
    }
    
    var valor = valorSemMascara($("#vl_diaria_destino").val());
    var qtd = valorSemMascara($("#qt_diaria_destino").val());
    var total = (qtd * valor).toFixed(2);
   
    var Itinerario = {
        id_diaria_destino: $("#id_diaria_destino").val(),
        ds_cidade_inicio: $("#ds_cidade_inicio").val(),
        id_cidade_inicio: $("#id_cidade_inicio").val(),
        dh_inicio: $("#dh_inicio").val(),
        ds_cidade_fim: $("#ds_cidade_fim").val(),
        id_cidade_fim: $("#id_cidade_fim").val(),
        dh_fim: $("#dh_fim").val(),
        fl_pernoite: pernoite,
        id_transporte: $("#id_transporte").val(),
        id_decreto: $("#id_decreto").val(),
        //id_classe_default: $("#id_classe").val(), //O select da Classe varia de acordo com o decreto, usei uma variável auxiliar para guardar a classe do registro cadastro em vez de usar o option select dentro do input #id_classe
        id_classe: $("#id_classe").val(),
        qt_diaria_destino: qtd,
        vl_diaria_destino: valor,
        vl_total: total
    };
    
    if (Itinerario.ds_cidade_inicio === '' || Itinerario.ds_cidade_fim === ''
            || Itinerario.dh_inicio === '' || Itinerario.dh_fim === ''
            || Itinerario.id_transporte === 0 || Itinerario.id_classe === 0
            || Itinerario.qt_diaria_destino === 0 || Itinerario.vl_diaria_destino === 0) {
        func.modalAlert(func.msgPreencherCampos);
        return false;
    }

    if (Itinerario.id_cidade_inicio === Itinerario.id_cidade_fim) {
        func.modalAlert("Cidade de origem deve ser diferente da cidade de destino.");
        return false;
    }
    
    //Validar data e hora de início e fim***********
    $.ajax({
        "url": "/model/diarias/diaria/request.php",
        "dataType": 'html',
        "data": {
            acao: "validaDiariaDestino",
            dados: JSON.stringify(Itinerario)
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

                var linha = `<tr data-itinerario='${JSON.stringify(Itinerario)}'>
                    <td>${Itinerario.ds_cidade_inicio}</td>
                    <td>${Itinerario.ds_cidade_fim}</td>
                    <td>${Itinerario.dh_inicio}</td>
                    <td>${Itinerario.dh_fim}</td>
                    <td>${valorComMascara(Itinerario.vl_total)}</td>
                    <td><span role='button' class="remove-itinerario">Remover</span> | <span role='button' class="edit-itinerario">Alterar</span></td>
                 </tr>`;

                $("#itinerario").find("tbody").append(linha);
                limpaFormItinerario();
            }
        }
    });

    //********************* fim**********************


}        

function retornaItinerario() {
    var itinerarioOriginal = $("#id_diaria_destino").data('itinerario');

    if (itinerarioOriginal != null){
        var linha = `<tr data-itinerario='${JSON.stringify(itinerarioOriginal)}'>
                        <td>${itinerarioOriginal.ds_cidade_inicio}</td>
                        <td>${itinerarioOriginal.ds_cidade_fim}</td>
                        <td>${itinerarioOriginal.dh_inicio}</td>
                        <td>${itinerarioOriginal.dh_fim}</td>
                        <td>${valorComMascara(itinerarioOriginal.vl_total)}</td>
                        <td><span role='button' class="remove-itinerario">Remover</span> | <span role='button' class="edit-itinerario">Alterar</span></td>
                     </tr>`;
        $("#itinerario").find("tbody").append(linha);
        limpaFormItinerario();
    }
}


$(document).ready(function () {
    func = new Funcoes();

    $('#dh_inicio').mask("99/99/9999 99:99");
    $('#dh_fim').mask("99/99/9999 99:99");
    
    $('#dt_criacao').mask("99/99/9999");
    
    //datapiker, plugins para data
    $('#dt_criacao').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });

    $("body").on("focus", ".decimal", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
    
    $("#observacoes").hide();
    $("#enviar_diaria").hide();
    
    if ($("#id_diaria").val() > 0) {
        listaHistorico();
    } 
    
    var estagio = $("#st_estagio").val();
    
    if(estagio == '1' || estagio == '3'){ //Criada ou Indeferida
        $("#enviar_diaria").show();
    } else {
        if(estagio == '4' || estagio == '2'){ //Deferida ou Enviada para Deferimento
            $("#salvar_diaria").prop('disabled',true);
        }
    }
    
//    $("#observacoes").hide();

    $('body').on('click', '.btn-limpar', function (e) {
        limpaFormItinerario();
    });
    //Combo box dos tipos de autorizações
    $("#diariaForm").find("select").select2({
    });

    if ($("#id_tipo option:selected").val() > 1) {
        $("#diaria_pai").show();
    } else {
        $("#diaria_pai").hide();
    }

    $('body').on('change', "#id_pessoa_proponente", function (e) {
        e.preventDefault();
        var id = $("#id_pessoa_proponente option:selected").val();
        var tipo = 1; //Proponente
        listaLotacaoCombo(id, tipo);
        listaContratoFuncao(id, tipo);
    });

    $('body').on('change', "#id_pessoa_proposto", function (e) {
        e.preventDefault();
        var id = $("#id_pessoa_proposto option:selected").val();
        var tipo = 2; //Proposto
        listaLotacaoCombo(id, tipo);
        listaContratoFuncao(id, tipo);
    });

    $('body').on('change', "#id_decreto", function (e) {
        e.preventDefault();
        var decreto = $("#id_decreto option:selected").val();
        var classe = $("#id_classe_default").val();
        if (decreto > 0) {
            listaClasseCombo(decreto, classe);
        } else {
            $("#id_classe").html('<option value="0">Selecione a classe</option>');
        }
    });

    //Esconde o campo da diaria PAI quando for solicitação de COMPLEMENTO ou PRORROGAÇÃO
    $('body').on('change', "#id_tipo", function (e) {
        e.preventDefault();
        if ($("#id_tipo option:selected").val() > 1) {
            $("#diaria_pai").show();
        } else {
            $("#diaria_pai").hide();
        }
    });
    
    //Preenche o form para edição do itinerario
    $('#itinerario').on('click', '.edit-itinerario', function (e) {
        e.preventDefault();
        retornaItinerario();
        var itinerario = $(this).closest('tr').data('itinerario');
        $(this).closest('tr').remove();
        editLinhaItinerario(itinerario);
    });

    //Edita o itinerario
    $('body').on('click', '.btn-editar', function (e) {
        e.preventDefault();
        encapsulaDadosDoFormItinerario();
    });

    //Inclui o itinerario
    $('body').on('click', '.add-itinerario', function (e) {
        e.preventDefault();
        encapsulaDadosDoFormItinerario();
    });

    //Cancela alteração do itinerario
    $('body').on('click', '.btn-cancelar', function (e) {
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

            var pernoite = "";
            if ($('#fl_pernoite').is(":checked")) {
                pernoite = "S";
            } else {
                pernoite = "N";
            }
            
            //Percorre os anexos
            var anexos = [];
            $('#arquivos .form-group').each(function(e){
                var anexo = $(this).data('anexo');
                anexos.push(anexo);
            });
            
            //Percorre o itinerario
            var itinerario = [];
            $("#itinerario tbody tr").each(function (e) {
                var destino = $(this).data('itinerario');
                itinerario.push(destino);
            });
            

            var Diaria = {
                idDiaria: $("#id_diaria").val(),
                idDiariaPai: $("#id_diaria_pai option:selected").val(),
                tipo: $("#id_tipo option:selected").val(),
                proponente: $("#id_pessoa_proponente option:selected").val(),
                proponenteLotacao: $("#id_lotacao_proponente option:selected").val(),
                proponenteFuncao: $("#id_funcao_proponente option:selected").val(),
                proposto: $("#id_pessoa_proposto option:selected").val(),
                propostoLotacao: $("#id_lotacao_proposto option:selected").val(),
                propostoFuncao: $("#id_funcao_proposto option:selected").val(),
                servicosExec: $("#ds_servico_executado").val(),
                locaisExec: $("#ds_locais_executado").val(),
                obs: $("#ds_obs").val(),
                dtCriacao: $("#dt_criacao").val(),
                itinerario: itinerario,
                anexos: anexos
            };


            //Validação dos campos
            if (Diaria.tipo == "" || Diaria.proponente == "" ||
                    Diaria.proponenteLotacao == "" || Diaria.proponenteFuncao == "" ||
                    Diaria.proposto == "" || Diaria.propostoLotacao == "" ||
                    Diaria.servicosExec == "" || Diaria.locaisExec == "") {

                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if (Diaria.tipo > 1 && Diaria.idDiariaPai === "") {
                func.modalAlert("É necessário informar a diária principal.");
                $this.prop("disabled", false);
                return false;
            }

            if (itinerario.length === 0) {
                func.modalAlert('Nenhum itinerario foi informado para a diária.');
                $this.prop("disabled", false);
                return false;
            }


            $.ajax({
                "url": "/model/diarias/diaria/request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "salvarDiaria",
                    "dados": Diaria
                },
                "success": function (response) {
                    //console.log(response);
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
                            top.location.href = "/pages/diarias/index.php";
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

    $('body').on('click', '.remove-itinerario', function (e) {

        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);

            var itinerario = $this.closest("tr").data('itinerario');

            var mensagem = "Origem: " + itinerario.ds_cidade_inicio + " / Destino: " + itinerario.ds_cidade_fim + " / Quantidade: " + itinerario.qt_diaria_destino + " / Valor total: " + itinerario.vl_total;
            bootbox.confirm({
                title: 'Caixa de Confirmação',
                message: 'Você tem Certeza que deseja continuar com a Exclusão do Itinerário da Diária <span class="text-danger">' + mensagem + '</span>?',
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
                        $this.closest('tr').remove();
                    }
                }
            });
        }
    });
    
    $('body').on('click','#enviar_diaria', function(e){
        
        var idDiaria = $("#id_diaria").val();
        var proponente = $("#id_pessoa_proponente option:selected").text();
        var proposto = $("#id_pessoa_proposto option:selected").text();
        var mensagem = "Nº: " + idDiaria + " / Proponente: " + proponente + " / Proposto: " + proposto;
        
        var DADOS = {
            diaria: idDiaria,
            estagio: '2', //Enviado para deferimento
            obs: 'Enviado a diária para deferimento.'
        }
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar o envio para deferimento da Diária <span class="text-danger">' + mensagem + '</span>?',
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

                    $.ajax({
                        "url": "/model/diarias/request.php",
                        "dataType": "html",
                        "method": "post",
                        "data": {
                            "acao": "atualizaEstagioDiaria",
                            "dados": DADOS
                        },
                        "success": function (response) {
//                            console.log(response);
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
    
});
