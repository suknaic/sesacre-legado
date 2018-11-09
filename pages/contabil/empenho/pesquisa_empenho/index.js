$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    var url = 'request.php';

    $('body').find('select').select2({
        width: '100%'
    });
    
    $('select').change( function (){
        $(this).select2();
    });
    
    $('body').on('click','.btn-pesquisar', function(){
        var dados = {
            'nr_empenho': $("#nr_empenho").val(),
            'ano_exercicio': $("#ano_exercicio option:selected").val(),
            'fornecedor': $("#fornecedor option:selected").val(),
            'nr_pedido': $("#nr_pedido").val(),
            'nr_contrato': $("#nr_contrato").val(),
            'tipo_gasto': $("#tipo_gasto option:selected").val(),
            'situacao': $("#situacao option:selected").val(),
            'central': $("#central option:selected").val()
        }
        
        lista(dados);
    });
    
    
    
    $('body').on('click', '.cancelar-empenho', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('tr').find('td:first').text();        
        bootbox.confirm({
            title: 'Cancelamento do Empenho',
            //message: 'Você tem Certeza que deseja continuar com a Exclusão do Item <span class="text-danger">' + item + '</span>?',
            message: 'Você tem Certeza que deseja continuar com o \n\
                Cancelamento do Empenho <span class="text-danger">' + item + '</span>?\n\
                <br> \n\
                <div class="form-group"> \n\
                    <label for="rem_justificativa">Justificativa: <span class="text-danger">*</span></label> \n\
                    <div class="input-group"> \n\
                        <span class="input-group-addon"> \n\
                            <p class="fa fa-list inputPFa"></p> \n\
                        </span> \n\
                        <textarea id="rem_justificativa" class="form-control"></textarea>\n\
                    </div> \n\
                </div>',  
            buttons: {
                'cancel': {
                    label: 'Fechar',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Dados = {
                        id: id,
                        justificativa: $("#rem_justificativa").val()
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    
                    $.ajax({
                        "url": url,
                        "dataType": "html",
                        "method": "post",
                        "data": {
                            "acao": "cancelarEmpenho",
                            "dados": Dados
                        },
                        "success": function (response) {     
                            
                            console.log(response)
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }
                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);                                
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
                                func.fechaModalReload();
                                return false;
                            } else {                                
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {                            
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });
    });
    
    
    $('body').on('click', '.ver-empenho', function (e) {
        var id = $(this).val();
        window.open("/pages/contabil/empenho/ver_empenho/index.php?&id=" + id);
    });
    
    $('body').on('click', '.editar-empenho', function (e) {
        var id = $(this).val();
        window.open("/pages/contabil/empenho/edit_empenho/index.php?&id=" + id);
    });
    
});

function lista(dados) {
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaEmpenhos",
            "dados": dados
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [9], true);
        }
    });
}


