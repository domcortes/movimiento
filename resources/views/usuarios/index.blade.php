@extends('adminlte::page')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            Listado de Usuarios
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalCrearPago">Agregar usuario</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="display" id="tablaPagos">
                        <thead>
                        <tr>
                            <th>Nombre Alumno</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{ $alumno->name }}</td>
                                <td><a href="mailto:{{ $alumno->email }}">{{ $alumno->email }}</a></td>
                                <td><a href="tel:+{{ $alumno->telefono }}">+{{ $alumno->telefono }}</a></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="https://api.whatsapp.com/send?phone=56939089104" class="btn btn-success"><i class="fa fa-whatsapp"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCrearPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Crear mensualidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pagos.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Alumno</label>
                                    <select name="alumno" id="alumno" class="form-control" required>
                                        <option value="">Selecciona un alumno</option>
                                        @foreach($alumnos as $alumno)
                                            <option value="{{ $alumno->id }}">{{ $alumno->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha de Pago</label>
                                    <input type="date" name="fechaPago" id="fechaPago" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha de vencimiento</label>
                                    <input type="date" name="fechaVencimiento" id="fechaVencimiento" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Inicio mensualidad</label>
                                    <input type="date" name="inicioMensualidad" id="inicioMensualidad" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Término mensualidad</label>
                                    <input type="date" name="terminoMensualidad" id="terminoMensualidad" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cantidad de clases</label>
                                    <input type="number" name="cantidadClases" id="cantidadClases" class="form-control" required step="1" value="12">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Medio de pago</label>
                                    <select name="medioPago" id="medioPago" class="form-control" required>
                                        <option value="">Selecciona un medio de pago</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="e-pago">Pago por terminal electronico</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear mensualidad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('js.datatable')
    @include('js.toastr')
    <script>
        $('#fechaPago').on('change', function(){
            let fechaPago = new Date($(this).val());
            let inicioMensualidad = moment(new Date(fechaPago)).add(1,'days')
            let fechaCalculada = moment(new Date(fechaPago)).add(31,'days')

            $('#fechaVencimiento').val(fechaCalculada.format('YYYY-MM-DD'));
            $('#inicioMensualidad').val(inicioMensualidad.format('YYYY-MM-DD'));
            $('#terminoMensualidad').val(fechaCalculada.format('YYYY-MM-DD'));
        })
    </script>
@endsection
