var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();

function init(){
    $("#ticket_form").on("submit",function(e){
        guardar(e);	
    });
}

$(document).ready(function(){

    $.post("../../controller/usuario.php?op=combo", function (data) {
        $('#usu_asig').html(data);
    });

    if (rol_id==1){
        tabla=$('#ticket_data').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [		          
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                    ],
            "ajax":{
                url: '../../controller/ticket.php?op=listar_x_usu',
                type : "post",
                dataType : "json",	
                data:{ usu_id : usu_id },						
                error: function(e){
                    console.log(e.responseText);	
                }
            },
            "ordering": false,
            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,
            "autoWidth": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "nenhum resultado encontrado",
                "sEmptyTable":     "Não há dados disponíveis nesta tabela",
                "sInfo":           "Mostrando um total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando um total de 0 registros",
                "sInfoFiltered":   "(filtrado de em total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Seguinte",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Ative para classificar a coluna em ordem crescente",
                    "sSortDescending": ": Ative para classificar a coluna em ordem decrescente"
                }
            }     
        }).DataTable(); 
    }else{
        tabla=$('#ticket_data').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [		          
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                    ],
            "ajax":{
                url: '../../controller/ticket.php?op=listar',
                type : "post",
                dataType : "json",						
                error: function(e){
                    console.log(e.responseText);	
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,
            "autoWidth": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "nenhum resultado encontrado",
                "sEmptyTable":     "Não há dados disponíveis nesta tabela",
                "sInfo":           "Mostrando um total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando um total de 0 registros",
                "sInfoFiltered":   "(filtrado de em total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Seguinte",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Ative para classificar a coluna em ordem crescente",
                    "sSortDescending": ": Ative para classificar a coluna em ordem decrescente"
                }
            }     
        }).DataTable(); 
    }

});

function ver(tick_id){
    window.location.href='../DetalheTicket/?ID='+ tick_id +'';
}

function atribuir(tick_id){
    $.post("../../controller/ticket.php?op=mostrar", {tick_id : tick_id}, function (data) {
        data = JSON.parse(data);
        $('#tick_id').val(data.tick_id);

        $('#mdltitulo').html('atribuir Agente');
        $("#modalatribuir").modal('show');
    });
 
}

function guardar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=atribuir",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var tick_id = $('#tick_id').val();
            $.post("../../controller/email.php?op=ticket_asignado", {tick_id : tick_id}, function (data) {

            });

            swal("Correto!", "Atribuído Corretamente", "success");

            $("#modalatribuir").modal('hide');
            $('#ticket_data').DataTable().ajax.reload();
        }
    });
}

function CambiarEstado(tick_id){
    swal({
        title: "HelpDesk",
        text: "Tem certeza de reabrir o ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/ticket.php?op=reabrir", {tick_id : tick_id,usu_id : usu_id}, function (data) {

            });

            $('#ticket_data').DataTable().ajax.reload();	

            swal({
                title: "HelpDesk!",
                text: "Ticket Aberto",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

init();