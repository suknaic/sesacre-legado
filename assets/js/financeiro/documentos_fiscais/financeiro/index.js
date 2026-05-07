$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //pegando menu do financeiro
    $.ajax({
        "url": "/layout/menus/financeiro/documento_fiscal/financeiro/menuFinanceiro.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_financeiro").html(response);
        }
    });

    $('.dropdown-toggle').dropdown();
    $('#demo-dt-basic').DataTable({
        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
        "language": {
            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
        },
        responsive: true
    });
});