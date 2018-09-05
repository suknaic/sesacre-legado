func = new Funcoes();

$(document).ready(function () {
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('#dt_liquidacao').mask("99/99/9999");
    
    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
    
    $('body').on('click', '.remover-documento', function (e) {
        $(this).closest("tr").remove();
        atualizaValorLiquidacao();
    });
    
    $('body').on('click','.addDocumento', function(e){
        
        var documento = $("#selectDocumentoFiscal option:selected").data('objeto');
        
        //Se não selecionou nenhum documento fiscal, retornar
        if (documento == undefined) {
            return false;
        }
        
        var erro = false;
        
        //percorre os documentos fiscais já inseridos ,caso já tenha sido inserido retorna erro e não continua
        $("tr.documentoFiscal").each(function() {
            if (documento.id_documento_fiscal == $(this).data('id')) {
                func.modalAlert("Documento fiscal já adicionado");
                erro = true;
            }
        });
        
        if (!erro) {
            $("#vl_liquidacao").prop("disabled",true);
            
            
            var linhaTabela = `<tr data-id=${documento.id_documento_fiscal} data-objeto='${JSON.stringify(documento)}' class="documentoFiscal">
                             <td class="text-center">${documento.nr_documento_fiscal}</td>
                             <td class="text-center">${documento.nm_tipo_documento}</td>
                             <td class="text-center">${documento.competencia}</td>
                             <td class="text-center">${documento.dt_emissao}</td>
                             <td class="text-center">${documento.dt_atesto}</td>
                             <td class="text-center">${documento.vl_documento}</td>
                             <td class="text-center">${documento.vl_documento}</td>
                             <td class="text-center">${documento.nm_situacao}</td>
                             <td class="text-center">
                                <button type="button" class="text-primary ver-documento" title="Ver Documento Fiscal" value="${documento.id_documento_fiscal}">
                                    <i class='fa fa-file-text-o' aria-hidden='true'></i>
                                </button>
                                <button type="button" class="text-danger remover-documento" title="Remover Documento Fiscal">
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button>
                            </td>
                          </tr>`;

            $('#tabelaDocumentos tbody').append(linhaTabela);
            atualizaValorLiquidacao();
        }
    });
    
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var documentos = [];

            $(".documentoFiscal").each(function () {
                documentos.push($(this).data("id"));
            });

            var dados = {
                "idLiquidacao": $("#id_liquidacao").val(),
                "nrLiquidacao": $("#nr_liquidacao").val(),
                "vlLiquidacao": $("#vl_liquidacao").val(),
                "dtLiquidacao": $("#dt_liquidacao").val(),
                "obsLiquidacao": $("#desc_liquidacao").val(),
                "docsLiquidacao": documentos
            }
            

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "atualizaLiquidacao",
                    "dados": dados
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
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
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

function atualizaValorLiquidacao(){
    var vl_liquidacao = 0;
    $("tr.documentoFiscal").each(function() {
        let documento = $(this).data('objeto'); 
        vl_liquidacao = func.converteValorIngFloat(documento.vl_documento) + vl_liquidacao;
    });
    
    if (vl_liquidacao == 0){
        $("#vl_liquidacao").prop("disabled",false);
    }
    
    $("#vl_liquidacao").val(valorComMascara(vl_liquidacao));
}

function valorComMascara(valor) { 
    var valor = Number(valor).toFixed(4);
    var valorStr = valor.toString();
    valorStr = valorStr.split('.');
    valorStr[0] = valorStr[0].split(/(?=(?:...)*$)/).join('.');
    return valorStr.join(',');
}
    



