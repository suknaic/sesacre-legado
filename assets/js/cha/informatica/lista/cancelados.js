$(document).ready(function () {

    func = new Funcoes();

    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOption"
            },
            "success": function (response) {
//                console.log(response);
                $("#lotacao").append(response);
                $("#lotacao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaLotacaoCombo();
// //******************************************************************************************
    function returnChamados() {
        var id_usuario = $("#id_usuario").val();

        $.ajax({
            "url": "/model/cha/informatica/chamado/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "listaChamadoTable2",
                "id_usuario": id_usuario,
                "idStatus": '2'

            },
            "success":
                    function (response) {
                        //console.log(response);
                        func.carregaTabelaPadrao('tabela', response, [10], true);
                    }
        });
    }
    returnChamados();
//******************************************************************************************
    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();

        $('#btn-salvar').val(id);
        $("#nome").val($(this).attr('nome'));
        $("#email").val($(this).attr('email'));
        $("#telefone").val($(this).attr('telefone'));
        $("#cns").val($(this).attr('cns'));
        $("#lotacao").prop("checked", false);

        $("#btn-salvar").removeClass("btn-success");
        $("#btn-salvar").addClass("btn-info");
        $("#btn-salvar").find("#txtBtn").text("Salvar Edição");
        $("#nome").focus();
    });
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });


    $('body').on('keypress', '.formDados', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#btn-salvar").trigger('click');
            return false;
        }
    });

});
