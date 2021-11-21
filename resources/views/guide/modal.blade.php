<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Datos del proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Razón Social</th>
                            <th>RUC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->Codigo_guia_remision}}</td>
                                <td>{{$data->Fecha_de_emision}}</td>
                                <td>{{$data->Inicio_traslado}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $datos->links() !!}
            </div>
        </div>
      </div>
    </div>
  </div>
</div>