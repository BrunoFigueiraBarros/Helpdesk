

$(document).on("click","#btnactualizar", function(){
   var pass = $("#txtpass").val();
   var newpass = $("#txtpassnew").val();

    if (pass.length == 0 || newpass.length == 0) {
        swal("Error!", "Campos vazios", "error");
    }else{
        if (pass==newpass){

            var usu_id = $('#user_idx').val();
            $.post("../../controller/usuario.php?op=password", {usu_id:usu_id,usu_pass:newpass}, function (data) {
                swal("Correto!", "Atualizado com sucesso", "success");
            });

        }else{
            swal("Error!", "As senhas não correspondem", "error");
        }
    }
});