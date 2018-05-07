

$(document).ready(function () {
    func = new Funcoes();
    
    $('body').on('click', '.abre-ModalCidade', function (e) {
        e.preventDefault();
        var origemDestino = $(this).data('id'); //Verifica se o usuário está selecionando cidade origem ou destino
        $('#origDest').val(origemDestino);
    });

    $('#pesquisaCidade').on('shown.bs.modal', function (e) {
        e.preventDefault();
        $('#cidadeQuery').val('');
        $('#cidadeQuery').focus();
    });

    $('body').on('click', '.selecionaCidade', function (e) {
        var $this = $(this);
        var dsCidade = $this.find("td:eq(0)").text() + ' - ' + $this.find("td:eq(1)").text();
        if ($("#origDest").val() == 'origem') {
            $("#id_cidade_inicio").val($this.data('cidade'));
            $("#ds_cidade_inicio").val(dsCidade);
        } else {
            $("#id_cidade_fim").val($this.data('cidade'));
            $("#ds_cidade_fim").val(dsCidade);
        }
        $('#pesquisaCidade').modal('hide');
        $('#tabelaCidades').dataTable().fnDestroy();
        $('#tabelaCidades tbody').empty();
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




