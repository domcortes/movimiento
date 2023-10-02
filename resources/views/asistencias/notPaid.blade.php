@extends('adminlte::page')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            Listado de asistencias <strong>SIN PAGOS</strong>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('asistencias.index') }}" class="float-right btn btn-info">Registros de asistencias con Pagos</a>
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
                            <th>Regularizar pagos</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($asistencias as $asistencia)
                            <tr>
                                <td>{{ $asistencia->nombreUsuario }}</td>
                                <td>{{ \App\Http\Controllers\SystemController::fechaFormateada($asistencia->fechaAsistencia) }}</td>
                                <td>{!! \App\Http\Controllers\SystemController::botonVerdaderoFalso($asistencia->clasePrueba) !!}</td>
                                <td>
                                    <select name="pagoAsociado" id="pagoAsociado" class="form-control porPagar">
                                        <option value="">Selecciona un pago de fecha</option>
                                        @foreach($pagos as $pago)
                                            @if($pago->id_usuario === $asistencia->id_usuario)
                                                <option value="{{ $pago->id }}">
                                                    Mensualidad del {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pago->fecha_inicio_mensualidad) }} al {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pago->fecha_termino_mensualidad) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
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
