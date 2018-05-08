$(document).ready(function () {
    func = new Funcoes();
    
    //*********************************************ANEXO****************************************
    $('body').on('click', '.btn-enviarUpload', function (e) {
        var formulario = document.getElementById('form-upload');
        var anexar = new FormData(formulario);

        $.ajax({

            url: '/model/diarias/upload/anexaArquivo.php',
            data: anexar,
            processData: false,
            contentType: false,
            method: "post",

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
                        func.modalAlert(response.msg, 'danger');
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#arquivos").append(response.msg);
                    return false;
                } else {
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                console.log(response);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    });
    
    //********************************REMOVE ANEXO*******************************************
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
                        $this.closest('.form-group').remove();
                    }
                }
            });
        }
    });
});

