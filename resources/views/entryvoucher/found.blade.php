@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $msg }}</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de vales de entrada</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Hora de recepción</th>
                            <th>Fecha de recepción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->ID_vale_entrada}}</td>
                                <td>{{$data->Hora}}</td>
                                <td>{{$data->Fecha_recepcion}}</td>
                                <td>
                                    @if($data->Activo == 1)
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td>
                                    <form action="{{url('/entryvoucher/'.$data->ID_vale_entrada)}}" method="post"
                                          class="formActions">
                                        <a class="btn btn-success" href="{{ url('/entryvoucher/'.$data->ID_vale_entrada) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-primary" href="{{ url('/entryVoucherPDF/'.$data->ID_vale_entrada)  }}">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>

                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger " value="Borrar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
