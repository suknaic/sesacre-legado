$(document).ready(function () {

    func = new Funcoes();
    
    $("#dt_inicio").mask("99/99/9999");
    $("#dt_fim").mask("99/99/9999");
    //datapiker, plugins para data
    $('#dt_inicio').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
     $('#dt_fim').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
    
    
    $.ajax({
        "url": "/layout/menus/log/menuLog.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_log").html(response);
        }
    });
        
    
    var table = $('#tabela').DataTable({
        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
        "order": [],
        "language": {
            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
        },
        responsive: true
    });

    //Botão para realizar a pesquisa
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true); 
            var chk = [];
            
            $(".chkAcoes").each(function(){
                if($(this).prop("checked")){
                    chk.push($(this).val());
                }                
            });
                                   
            var Pesquisa = {
                idPessoa: $("#idPessoa option:selected").val(),
                limite: $("#limite").val(),
                dt_inicio: $("#dt_inicio").val(),
                dt_fim: $("#dt_fim").val(),
                acoes: chk
            }                                                            
            
            if (Pesquisa.idPessoa == "" || Pesquisa.idPessoa == 0) {
                func.modalAlert("Selecione um Usuário");
                $this.prop("disabled", false);
                return false;
            }           
            if(chk.length == 0){
                func.modalAlert("Seleciona ao Menos Alguma Ação que Deseja Pesquisar do Usuário");
                $this.prop("disabled", false);
                return false;
            }            
            
            $.ajax({
                "url": "/model/sistema/log/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listaLogTablePessoa",
                    "pesquisa": Pesquisa
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                   
                    var oTable = $('#tabela').dataTable();
                    oTable.fnDestroy();
                    $("#tabela").find("tbody").html(response);
                    var table = $('#tabela').DataTable({
                        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                        "order": [],
                        "language": {
                            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                        },
                        responsive: true
                    });                    
                    $("#tabela").show();
                    //return false;
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });


   

    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-pesquisar').prop("disabled", false);        
        $("#idPessoa").val("0");
        $("#dt_inicio").val("");
        $("#dt_fim").val("");
        $("#limite").val("20");
        $(".chkAcoes").prop("checked", true);

    });
   

});
