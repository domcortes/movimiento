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
                                <th>Fecha de asistencia</th>
                                <th>Clase de prueba</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($asistencias as $asistencia)
                            <tr>
                                <td>{{ $asistencia->usuario->name }}</td>
                                <td>{{ \App\Http\Controllers\SystemController::fechaFormateada($asistencia->fecha_asistencia) }}</td>
                                <td>{!! \App\Http\Controllers\SystemController::botonVerdaderoFalso($asistencia->clasePrueba) !!}</td>
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
