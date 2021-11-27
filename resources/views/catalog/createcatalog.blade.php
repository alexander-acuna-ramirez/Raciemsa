<form method="post" id="form-create">
    
    <div class="modal fade" id="catalogaddmodal" tabindex="-1" role="dialog" aria-labelledby="catalogaddmodal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCatalogoH">Crear catálogo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                    @csrf
                    <div class="row">
                        <div class="col-5">
                        @foreach($nuevoCodigo as $data)
                            <label for="ID_Catalogo">Código</label>
                            <input type="text" class="form-control" readonly name="ID_Catalogo" id="ID_Catalogo"
                            value="{{ $data->Cod }}">
                            @endforeach
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <span class="text-danger">
                                <strong id="name-error"></strong>
                            </span>
                        </div>

                        <div class="col-7">
                            <label for="Ubicacion">Ubicación</label>
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

