$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    $("#dataRecebimento").mask("99/99/9999");
    
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js
            if ($("#nomeRepresentante").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#rgCpf").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#dataRecebida").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var protocolo = {
                "ordem": $("#ordem").val(),
                "nomeRepresentante": $("#nomeRepresentante").val(),
                "rgCpf": $("#rgCpf").val(),
                "dataRecebimento": $("#dataRecebimento").val(),
                "email": $("#email").val(),
                "quantidade": $("#quantidade").val(),
                "obsProtocolo": $("#obsProtocolo").val()
            }
            $.ajax({
                "method": "POST",
                "url": "/model/financeiro/ordem/entrega/request.php",
                "dataType": 'html',
                "data": {
                    "acao": "salvaProtocolo",
                    "protocolo": protocolo
                },
                "success": function (response) {
                    console.log(response);
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "/pages/financeiro/ordem/index.php";
                        });
                        return false;
                    } else {
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
        }
    });
});
