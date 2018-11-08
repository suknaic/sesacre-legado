


$(document).ready(function () {
    $('body').on('click','.btn-addAnotacao', function(){
       
        var id_documento = $("#id_documento").val();
        var nr_documento = $("#nr_documento").val();
       
        bootbox.confirm({
            title: 'Adicionar Anotação',
            message: 'Você tem Certeza que deseja continuar com a \n\
                Inserção de Anotação para Documento Fiscal <span class="text-danger">' + nr_documento + '</span>?\n\
                <br> \n\
                <div class="form-group"> \n\
                    <label for="anotacao">Anotacao: <span class="text-danger">*</span></label> \n\
                    <div class="input-group"> \n\
                        <span class="input-group-addon"> \n\
                            <p class="fa fa-list inputPFa"></p> \n\
                        </span> \n\
                        <textarea id="anotacao" class="form-control"></textarea>\n\
                    </div> \n\
                </div>',           
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
                

            }
        });
    });
});

