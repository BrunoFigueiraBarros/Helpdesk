<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <label class="form-label" for="usu_nom">Nome</label>
                        <input type="text" class="form-control" id="usu_nom" name="usu_nom" placeholder="Ingrese Nome" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_ape">Apelido</label>
                        <input type="text" class="form-control" id="usu_ape" name="usu_ape" placeholder="Ingrese Apellido" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_email">E-mail</label>
                        <input type="email" class="form-control" id="usu_email" name="usu_email" placeholder="test@test.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_pass">Senha</label>
                        <input type="text" class="form-control" id="usu_pass" name="usu_pass" placeholder="************" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_nivel">Tipo</label>
                        <select class="select2" id="usu_nivel" name="usu_nivel">
                            <option value="1">Usuario</option>
                            <option value="2">Suporte</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>