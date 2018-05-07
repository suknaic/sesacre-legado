$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    //menu programa trabalho
    $.ajax({
        "url": "/layout/menus/orcamento/programa_trabalho/menu_programa_trabalho.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_prog_trab").html(response);
        }
    });
    
    //select2
    $("#funcao").select2();
    $("#subFuncao").select2();
    $("#programa").select2();
    $("#ano").select2();
    
    //metodo para carregar os programas no comboBox
    function listaPrograma() {
        var idPrograma = {
            id: $("#id_programa").val()
        };
        $.ajax({
            "url": "/model/orcamento/programaTrabalho/request.php",
            "dataType": "html",
            "data": {
                "acao": "listaProgramas",
                "progTrab": idPrograma
            },
            "success": function (response) {
                $("#programa").append(response);
            }
        });
    };
    listaPrograma();
    
    //metodo para carregar as funçoẽs no comboBox
    function listaFuncao(){
        var idFuncao = {
            id : $("#id_funcao").val()
        };
        $.ajax({
            "url": "/model/orcamento/programaTrabalho/request.php",
            "dataType": "html",
            "data": {
                "acao": "listaFuncoes",
                "progTrab": idFuncao
            },
            "success": function (response) {
                $("#funcao").append(response);
            }
        });
    }
    listaFuncao();
    
    //metodo para carregar as subFunções no comboBox
    function listaSubFuncao(){
        var idSubFuncao = {
            id: $("#id_subfuncao").val()
        };
        $.ajax({
            "url": "/model/orcamento/programaTrabalho/request.php",
            "dataType": "html",
            "data": {
                "acao": "listaSubFuncoes",
            "progTrab": idSubFuncao
            },
            "success": function (response) {
                $("#subFuncao").append(response);
            }
        });
    }
    listaSubFuncao();
    
    //metodo para carregar os anos no comboBox
    function listaAno(){
        $.ajax({
            "url": "/model/orcamento/programaTrabalho/request.php",
            "dataType": "html",
            "data": {
                "acao": "retornaAno"
            },
            "success": function (response) {
                $("#ano").append(response);
            }
        });
    }
    listaAno();
    
    $('body').on('click', '.btn-limpar', function (e) {
        $("#codigo").val("");
        $("#descricao").val("");
        $("#ano").select2('val','0');
        $("#funcao").select2('val','0');
        $("#subFuncao").select2('val','0');
        $("#programa").select2('val','0');
    });
    
    $('body').on('click', '.btn-cancelar', function (e) {
        top.location = "/pages/orcamento/programa_trabalho/programaTrabalho.php";
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var progTrab = {
                    cd: $("#codigo").val(),
                    ds: $("#descricao").val(),
                    aa: $("#ano").val(),
                  func: $("#funcao").val(),
               subFunc: $("#subFuncao").val(),
              programa: $("#programa").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/programaTrabalho/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarProgTrab",
                    "progTrab": progTrab
                },
                "success": function (response) {
                    $this.prop("disabled", false);
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
                            $("body").find("#codigo").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
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
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var progTrab = {
                    id: $("#id_programa_trabalho").val(),
                    cd: $("#codigo").val(),
                    ds: $("#descricao").val(),
                    aa: $("#ano").val(),
                  func: $("#funcao").val(),
               subFunc: $("#subFuncao").val(),
              programa: $("#programa").val(),
              verifica: $("#verifica").val()
            };
            
            $.ajax({
                "url": "/model/orcamento/programaTrabalho/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarProgTrab",
                    "progTrab": progTrab
                },
                "success": function (response) {
                    $this.prop("disabled", false);
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
                            $("body").find("#codigo").html("");
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location = "/pages/orcamento/programa_trabalho/programaTrabalho.php";
                        });
                        return false;
                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
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
});
