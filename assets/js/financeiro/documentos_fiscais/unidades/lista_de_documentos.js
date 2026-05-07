$(document).ready(function () {
    $('#demo-dt-basic').DataTable({
        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
        "language": {
             "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
        },
        responsive: true
    });
});


