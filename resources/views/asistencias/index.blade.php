@extends('adminlte::page')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            Listado de asistencias
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="display" id="tablaPagos">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Fecha de pago</th>
                                <th>Fecha de vencimiento</th>
                                <th>Cantidad clases</th>
                                <th>Tipo Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($asistencias as $asistencia)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    @include('js.datatable')
    @include('js.toastr')
@endsection
