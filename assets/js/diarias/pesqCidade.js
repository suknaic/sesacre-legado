

$(document).ready(function () {
    func = new Funcoes();
    
    $('body').on('click', '.abre-ModalCidade', function (e) {
        e.preventDefault();
        var origemDestino = $(this).data('id'); //Verifica se o usuário está selecionando cidade origem ou destino
        $('#origDest').val(origemDestino);
    });

    $('#pesquisaCidade').on('shown.bs.modal', function (e) {
        e.preventDefault();
        $('#cidadeQuery').focus();
    });
    
    $('#pesquisaCidade').on('hidden.bs.modal', function (e) {
        e.preventDefault();
        $('#cidadeQuery').val('');
        $('#tabelaCidades').dataTable().fnDestroy();
        $('#tabelaCidades tbody').empty();
    });

    $('body').on('click', '.selecionaCidade', function (e) {
        var $this = $(this);
        var dsCidade = $this.find("td:eq(0)").text() + ' - ' + $this.find("td:eq(1)").text();
        if ($("#origDest").val() == 'origem') {
            $("#id_cidade_inicio").val($this.data('cidade'));
            $("#ds_cidade_inicio").val(dsCidade);
        } else {
            $("#id_cidade_fim").data('estado',$this.find("td:eq(1)").text()); //Salva o estado de destino para verificar se a diária é Estadual ou Nacional
            $("#id_cidade_fim").val($this.data('cidade')).trigger('change'); //Dispara o evento 'change' para mostrar para o usuário se é uma diária Estadual ou Nacional
            $("#ds_cidade_fim").val(dsCidade);
        }
        $('#pesquisaCidade').modal('hide');
//        $('#tabelaCidades').dataTable().fnDestroy();
//        $('#tabelaCidades tbody').empty();
    });
    
    $('body').on('keypress', '#cidadeQuery', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });


    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#cidadeQuery").val();
        if (dados == "" || dados.length < 2 || dados == " ") {
            alert("Pesquisa da Cidade precisa ter no mínimo 2 caracteres");
            return;
        }

        $.ajax({
            "url": "/model/diarias/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCidades",
                dados: dados
            },
            "success": function (response) {
                carregaTabela('tabelaCidades', response, [], true);
            }
        });
    });
    
    $('body').on('click', '.selecionaCidade', function (e) {
        var $this = $(this);
        $('#pesquisaCidade').modal('hide');
    });
});




