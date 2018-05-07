$(document).ready(function () {

    func = new Funcoes();       
    
    
    function lista(){
        
        var ano = $("#ano").val();
        
        $.ajax({
            "url": "/model/pla/pre_loa/request_valores.php",
            "dataType": 'html',
            "data": {
                acao: "simulaValores",
                ano: ano
            },
            "success": function (response) {         
                $("#informacao").html(response);    
                $("#botao").show();
                $("#sesacre-xlsx").show();
            }
        });        
    }
    
    lista();
    
    $('body').on('click', '.btn-gerar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var ano = $("#ano").val();
            
            bootbox.confirm({
                title: 'Caixa de Confirmação',                
                message: 'Você tem certeza que deseja Gerar a Prévia-LOA do Ano de <span class="text-danger">' + ano + '</span>?<br> <textarea class="form-control" id="texto" rows="4" style="text-align: left;"></textarea>',
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
                        var texto = $("#texto").val();                        
                        var Dados = {
                            ano: ano,
                            texto: texto
                        }
                        
                        $.ajax({
                            "url": "/model/pla/pre_loa/request_valores.php",
                            "dataType": "html",
                            "data": {
                                "acao": "criar",
                                "dados": Dados
                            },
                            "success": function (response) {
                                
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
                                    func.modalAlert(response.msg, 'success');
                                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                                        window.location.href = "index.php?token="+ano;
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
                                console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        });


                    }
                }
            });
            
        }
    });
    
       
});

function exportExcel(format, ano) {
    return ExcellentExport.convert({
        anchor: 'sesacre-' + format,
        filename: 'pre_loa-'+ano,
        format: format
    }, [{
        name: 'Pre-LOA',
        from: {
            table: 'tabela'
        }
    }]);
}