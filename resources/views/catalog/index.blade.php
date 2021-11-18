@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
   

    <a data-toggle="collapse" href="#collapseMaterial" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" aria-expanded="false" aria-controls="collapseExample"><i
                class="fas fa-eye text-white-50"></i> Mostrar Material </a>
    
</div>
  <div class="collapse" id="collapseMaterial">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
        <h1 class="h3 mb-0 text-gray-800">Catalogos</h1>
        
        
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#catalogaddmodal"><i
                class="fas fa-plus-circle text-white-50"></i> Crear catalogo </a>
    </div>
    
    <div class="col-md-6" style="float:none;margin:auto;">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de catalogos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Ubicacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->ID_Catalogo}}</td>
                                <td>{{$data->Ubicacion}}</td>
                                <td>
                                    <!--<a class="btn btn-success" href="{{url('/catalog/'.$data->ID_Catalogo.'/edit')}}">
                                        Editar
                                    </a>-->
                                    <form action="{{url('/catalog/'.$data->ID_Catalogo)}}" method="post">
                                        <a class="btn btn-success" href="{{url('/catalog/'.$data->ID_Catalogo.'/edit')}}">
                                            Editar
                                        </a>
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input class="btn btn-danger d-inline" type="submit"
                                        onclick="return confirm('¿Seguro que quieres borrar esto?')"
                                        value="Borrar">
                                    </form>
                                </td>
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
<!--Material-->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Materiales</h1>
        <a href="{{url('/catalog/create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus-circle text-white-50"></i> Crear Material </a>         
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de materiales</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Numero de Parte</th>
                            <th>Descripcion</th>
                            <th>Unidad de medida</th>
                            <th>Stock</th>
                            <th>Codigo SAP</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datosM as $dataM)
                            <tr>
                                <td>{{$dataM->Numero_de_parte}}</td>
                                <td>{{$dataM->Descripcion}}</td>
                                <td>{{$dataM->Unidad_de_medida}}</td>
                                <td>{{$dataM->Stock}}</td>
                                <td>{{$dataM->Codigo_sap}}</td>
                                
                                <td>
                                    <!--<a class="btn btn-success" href="{{url('/catalog/'.$data->ID_Catalogo.'/edit')}}">
                                        Editar
                                    </a>-->
                                    <form action="{{url('/material/update'.$data->Numero_de_parte)}}" method="post">
                                    <a class="btn btn-success" href="{{url('/catalog/'.$data->ID_Catalogo.'/edit')}}">                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger d-inline" type="submit"
                                        onclick="return confirm('¿Seguro que quieres borrar esto?')">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $datos->links() !!}
            </div>
        </div>
</div>
<!-- Modal -->
<div class="modal fade" id="catalogaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCatalogoH">Crear catalogo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{url('/catalog')}}" class="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <label for="ID_Catalogo">Codigo</label>
                            <input type="text" class="form-control" readonly name="ID_Catalogo" id="ID_Catalogo" value="{{ $Next }}">
                        </div>
    
                        <div class="col-7">
                            <label for="Ubicacion">Ubicacion</label>
                            <input type="text" class="form-control" name="Ubicacion" id="Ubicacion">
                            @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                <br>
                            @enderror
                        </div>   
                    </div>    
                    <!-- Buttons -->
                    <div class="modal-footer">
                    <div class="row mt-3">
                        <div class="col">
                        <button type="button" class="btn btn-danger btn-icon-split float-right mx-1" data-dismiss="modal" >
                            <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Cancelar</span>
                                </button> 
                      <button type="submit" class="btn btn-success btn-icon-split float-right mx-1">
                          <span class="icon text-white-50">
                              <i class="fas fa-check"></i>
                               </span>
                                <span class="text">Agregar</span>
                            </button> 
                        </div>
                    </div>          
                
                </form>
      </div>
      </div>
    </div>
  </div>
</div>
@endsection


