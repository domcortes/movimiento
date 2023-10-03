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
                            <div class="btn-group float-right">
                                <a href="{{ route('asistencias.index') }}" class="btn btn-info">Registros de asistencias con Pagos</a>
                                <a href="{{ route('asistencias.pendientes') }}" class="btn btn-success">Actualizar listado</a>
                            </div>
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
                                    <select markup="{{ $asistencia->idAsistencia }}" user="{{ $asistencia->idUsuario }}" name="pagoAsociado" id="pagoAsociado" class="form-control porPagar">
                                        <option value="">Selecciona un pago de fecha</option>
                                        @foreach($pagos as $pago)
                                            @if($pago->id_usuario === $asistencia->idUsuario)
                                                <option value="{{ $pago->id }}">
                                                    Mensualidad del {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pago->fecha_inicio_mensualidad)->format('d-m-Y') }} al {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pago->fecha_termino_mensualidad)->format('d-m-Y') }}
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

@section('css')
@section('css')
    <style>
        .select2-selection__rendered {
            line-height: 35px !important;
        }
        .select2-container .select2-selection--single {
            height: 39px !important;
        }
        .select2-selection__arrow {
            height: 38px !important;
        }
    </style>
@endsection

@endsection
@section('js')
    @include('js.datatable')
    @include('js.toastr')
    <script>
        $('.porPagar').select2({
            width: '100%',
        });

        $('.porPagar').on('change', function () {
            let data = {
                _token: '{{ csrf_token() }}',
                usuario: $(this).attr('user'),
                pago: $(this).val(),
                asistencia: $(this).attr('markup')
            }

            let url = '{{ route('pago.actualizarPago') }}'

            $.post(url, data)
            .done(function (response) {
                if(response.result){
                    toastr.success(response.message)
                } else {
                    toastr.error(response.message)
                }
            })
        })
    </script>
@endsection
