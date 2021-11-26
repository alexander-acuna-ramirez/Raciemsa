<form method="post" id="form-catalog-edit" >
    <div class="modal fade" id="catalogeditmodal" tabindex="-1" role="dialog" aria-labelledby="catalogeditmodal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCatalogoH">Editar catalogo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                {{ method_field('PUT') }}
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <label for="ID_Catalogo">Codigo</label>
                            <input type="text" class="form-control" disabled name="ID_Catalogo" id="ID_Catalogo"
                            value="#">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <span class="text-danger">
                                <strong id="name-error"></strong>
                            </span>
                        </div>

                        <div class="col-7">
                            <label for="Ubicacion">Ubicacion</label>
                            <input type="text" class="form-control" name="Ubicacion" id="Ubicacion">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <span class="text-danger">
                                <strong id="email-error"></strong>
                            </span>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="modal-footer">
                        <div class="row mt-3">
                            <div class="col">
                                <button type="button" class="btn btn-danger btn-icon-split float-right mx-1"
                                    data-dismiss="modal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Cancelar</span>
                                </button>
                                <button type="submit" id="submit"
                                    class=" btn btn-success btn-icon-split float-right mx-1">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Agregar</span>
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

