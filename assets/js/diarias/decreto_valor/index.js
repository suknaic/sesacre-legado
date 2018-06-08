$(document).ready(function () {
    
    func = new Funcoes();
    
    function lista() {
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaTable"
            },
            "success": function (response) {            
                func.carregaTabelaPadrao('tabela', response, [2]);
            }
        });
    }
    lista();
    
    function decretoCombo(){
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "returnDecretoOption"
            },
            "success": function (response) {            
                $("#id_decreto").html(response);
            }
        });
    }
    
    decretoCombo();
    
    function listaClasseCombo(decreto) {
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "returnClasseOption",
                dados: decreto
            },
            "success":
                    function (response) {
                        $("#id_classe").html(response);
                    }
        });
    }
    
    $('body').find('select').select2({
    });
    
    $('#id_decreto').on('change', function(e){
        e.preventDefault();
        var decreto = $("#id_decreto").val();
        listaClasseCombo(decreto);
    });
    
    
    //*********************************SALVAR***********************************
    $('body').on('click','.btn-salvar', function(e){
        e.stopPropagation();
        if (e.isDefaultPrevented()) {

        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true); //Desabilita o botão enquanto executa a operação
            
            //Carrega os dados do formulário
            var DADOS = {
                decreto: $("#id_decreto option:selected").val(),
                classe: $("#id_classe option:selected").val(),
                tipo: $("#tp_decreto_valor option:selected").val(),
                valor: $("#vl_decreto_valor").val()
            };
            
            if (DADOS.decreto == "0" || DADOS.classe == "0" || DADOS.tipo == "" || DADOS.valor == "" || DADOS.valor == "0") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            $.ajax({
                "url": "/model/diarias/decreto_valor/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "cadastrarDecretoValor",
                    "dados": DADOS
                },
                "success": function (response) {
//                    console.log(response);
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
    })
    //*******************************FIM SALVAR*********************************
});

