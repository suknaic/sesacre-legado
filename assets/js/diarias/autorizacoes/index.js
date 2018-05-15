

function listaDiarias(){
    $.ajax({
        "url": "/model/diarias/autorizacoes/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaDiarias"
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}
listaDiarias();


$(document).ready(function () {
    func = new Funcoes();
    
    $('#tabela').on('click', '.acao', function (e) {
        e.preventDefault();
        var $this = $(this);
        
        var tipo = $this.data('tipo'); //recebe a informação se é deferimento ou indeferimento
        var diaria = $this.closest('tr').data("diaria"); //A tabela possui a tag data-diaria que fornece informações gerais da diaria em cada linha da tabela do html
        
        //Campo invisivel para armazenar informações necessárias 
        $("#id_diaria").data('id',diaria.id_diaria);
        $("#id_diaria").data('tipo',tipo);
        $('#btn-confirmar').html(tipo);
    });

    
    $('#acao').on('shown.bs.modal', function (e) {
        e.preventDefault();        
        $('#motivo').focus();
    });
    
    $('#acao').on('click','#btn-cancelar',function(e){
       e.preventDefault();
       $('#motivo').val('');
    });

    $('#acao').on('click','#btn-confirmar',function(e){
        e.preventDefault();
        
        var $this = $(this);
        var estagio; 
        
        $this.prop("disabled", true);

        if ($("#id_diaria").data('tipo') == 'Deferir') {
            estagio = '4'; //Deferido
        } else {
            estagio = '3'; //Indeferido
        }
       
        if ($("#motivo").val() == '') {
            $('#acao').modal('hide'); //Esconde o modal que contem a motivação para o modal do error não ficar por trás do outro modal
            func.modalAlert('Por favor informe a motivação para o deferimento ou indeferimento da solicitação de diária.');
            $this.prop("disabled", false);
            return false;
        }
       
        var DADOS = {
            diaria: $("#id_diaria").data('id'),
            estagio: estagio,
            obs: $("#motivo").val()
        }
        
       
       $.ajax({
            "url": "/model/diarias/autorizacoes/request.php",
            "dataType": "html",
            "method": "post",
            "data": {
                "acao": "atualizaEstagioDiaria",
                "dados": DADOS
            },
            "success": function (response) {
                
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
                        top.location.href = "/pages/diarias/autorizacoes/index.php";
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
       
       $('#acao').modal('hide');
       $('#motivo').val('');
    });
});

