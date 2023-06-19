function init(){
}

$(document).ready(function() {

});
$(document).on("click", "#btnSuporte", function () {
    if ($('#usu_nivel').val()==1){
        $('#lbltitulo').html("Acceso Suporte");
        $('#btnSuporte').html("Acceso Usuario");
        $('#usu_nivel').val(2);
        $("#imgtipo").attr("src","public/2.jpg");
    }else{
        $('#lbltitulo').html("Acceso Usuario");
        $('#btnSuporte').html("Acceso Suporte");
        $('#usu_nivel').val(1);
        $("#imgtipo").attr("src","public/1.jpg");
    }
});

init();