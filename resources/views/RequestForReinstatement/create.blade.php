@extends('layouts.master')

@section('content')
<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>

<form action="/RequestForReinstatement/save" method="POST" id="main_form" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Nueva Solicitud de Reposicion</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Crear Nueva Solicitud de Reposicion</h6>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="Codigo_reposicion">Proveedor</label>
                        <select class="form-control" name="Proveedor">
                            @foreach($reinstatement as $data)
                            <option value="{{$data->Codigo_proveedor}}">{{$data->Razon_social}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Fecha</label>
                        <input type="text" class="form-control" name="Fecha" id="" placeholder="Fecha del requerimiento">                      
                    </div>
                </div>
            </div>
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Requerimientos</h6>
            </div>
            <div class="card-body">
                <span id="result"></span>
                <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                        <tr>
                            <th width="20%">Numero de Parte</th>
                            <th width="10%">Cantidad</th>
                            <th width="10%">Prioridad</th>
                            <th width="30%">Observaciones</th>
                            <th width="20%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td>
                            @csrf
                            <input type="submit" name="save" id="save" class="btn btn-primary" value="Guardar" />
                            </td>
                        </tr>
                    </tfoot>
            </table>
            </div>
        </div>
    </div>

</form>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function onlyNumberKey(evt) {    
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>

<script>
$(document).ready(function(){
    var count = 1;
    var count2 = 1;
    dynamic_field(count, count2);
    function dynamic_field(number, numberF)
    {
        html = '<tr>';
        html += '<td><input type="text" id="num'+numberF+'Parte" name="numParte[]" class="form-control " /><span class="text-danger error-text numParte_error" name="numParte.*"></span></td>';
        html += '<td><input type="text" id="num'+numberF+'Cant" name="cant[]" class="form-control" onkeypress="return onlyNumberKey(event)"/></td>';
        html += '<td><input type="hidden" name="prior[]" class="form-control" /><input type="checkbox" name="prior[]" class="form-control" style="width:25px; height:25px; margin-top:5px; margin-left:30px;" value="1"/></td>';
        html += '<td><input type="text" name="observ[]" class="form-control" /></td>';
        if(number > 1)
        {
            html += '<td><button type="button" class="btn btn-success btn-icon-split btn-sm mr-1" name="add" id="add">';
            html += '<span class="icon text-white-50">';
            html += '<i class="fa fa-plus"></i></span>';
            html += '<span class="text">Agregar</span></button>';
            html += '<button type="button" class="btn btn-danger btn-icon-split btn-sm remove" name="remove" id="">';
            html += '<span class="icon text-white-50">';
            html += '<i class="fa fa-trash"></i></span>';
            html += '<span class="text">Remover</span></button></td></tr>';
            $('tbody').append(html);
        }
        else
        {   
            html += '<td><button type="button" class="btn btn-success btn-icon-split btn-sm" name="add" id="add">';
            html += '<span class="icon text-white-50">';
            html += '<i class="fa fa-plus"></i></span>';
            html += '<span class="text">Agregar</span></button></td></tr>';
            $('tbody').html(html);
        }
    }
    
    $(document).on('click', '#add', function(){
        count++;
        count2++;
        dynamic_field(count, count2);
    });
    $(document).on('click', '.remove', function(){
        count--;
        $(this).closest("tr").remove();
    });

    $('#main_form').on('submit', function(event){
        event.preventDefault();       
        $.ajax({
            url:'{{ route("RequestForReinstatement.save") }}',
            method:'post',
            data:$(this).serialize(),
            dataType:'json',
            beforeSend:function(){
                for(var c = 0; c <= count; c++){
                    $('#num'+c+'Cant').css('border',"1px solid #d4daed");
                    $('#num'+c+'Cant').focusin(function () {
                    $(this).css({ 'box-shadow': '0 0 0 0.2rem rgba(78, 115, 223, 0.25)' }); 
                    });
                    $('#num'+c+'Cant').focusout(function () {
                    $(this).css({ 'box-shadow': 'bac8f3' });
                    });
                }
            },
            success:function(data)
            {
                if(data.status == 0)
                {
                    for(var c = 0; c <= count2; c++)
                    {
                        if($('#num'+c+'Cant').val() == ''){
                            $('#num'+c+'Cant').css('border',"0.12em solid red");
                            $('#num'+c+'Cant').focusin(function () {
                                $(this).css({ 'box-shadow': '0 0 5px red' });
                            });
                            $('#num'+c+'Cant').focusout(function () {
                                $(this).css({ 'box-shadow': '0 0 5px #f4f4f4 ' });
                            });
                        }
                    }
                    var error_html = '';
                    var can = 1;
                    var nump = 1;
                    $.each(data.error, function(prefix, val){
                        if((prefix.substring(0,4) == 'cant') && (can == 1)){
                            error_html += '<p style="margin:0;">- La <b>Cantidad</b> es un campo Requerido y Numerico</p>';
                            can = 0;
                        }
                        if((prefix.substring(0,8) == 'numParte') && (nump == 1)){
                            error_html += '<p style="margin:0;">- El <b>Numero De Parte</b> es un campo Requerido</p>';
                            nump = 0;
                        }
                    });
                    $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                    $("html, body").animate({ scrollTop: 0 }, 800);
                }
                else
                {
                    $('#result').html('');
                    Swal.fire({
                    title: '¿Esta seguro?',
                    text: "Se creara la nueva solicitud",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Grabar solicitud',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        })
                        Toast.fire({
                        icon: 'success',
                        title: 'La solicitud fue creada correctamente'
                        })
                        dynamic_field(1);
                    }
                    })
                }
                $('#save').attr('disabled', false);
            }
        })
    });
});
</script>
@endsection