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
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalCrearUsuario">Agregar usuario</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="display" id="tablaPagos">
                        <thead>
                        <tr>
                            <th>Nombre Alumno</th>
                            <th>Rol</th>
                            <th>Email</th>
                            <th>Deportes</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{ $alumno->name }}</td>
                                <td>{{ $alumno->role }}</td>
                                <td><a href="mailto:{{ $alumno->email }}">{{ $alumno->email }}</a></td>
                                <td>{{ $alumno->disciplina }}</td>
                                <td><a href="tel:+{{ $alumno->telefono }}">+{{ $alumno->telefono }}</a></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="https://api.whatsapp.com/send?phone={{ $alumno->telefono }}" class="btn btn-success"><i class="fa-brands fa-whatsapp"></i></a>
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

    <div class="modal fade" id="modalCrearUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('usuario.crearUsuario') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre de usuario</label>
                                    <input type="text" name="name" id="name" class="form-control" required placeholder="al menos un nombre y un apellido">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required placeholder="emailusuario@email.com">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Deporte</label>
                                    <select name="deporte[]" id="deporte" class="form-control deporte" multiple="multiple">
                                        <option value="jiujitsu">Jiujitsu</option>
                                        <option value="nogi">Nogi</option>
                                        <option value="mma">MMA</option>
                                        <option value="fisico">Acondicionamiento Fisico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tipo de matricula</label>
                                    <select name="tipoMatricula" id="tipoMatricula" class="form-control">
                                        <option value="adulto">Adulto</option>
                                        <option value="niños">Niño</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Rut</label>
                                    <input type="text" name="rut" id="rut" class="form-control" onKeyPress="return limpiezaRut(event)" required placeholder="sin puntos y con guion">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Teléfono celular <small>(para notificaciones por whatsapp)</small></label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" required placeholder="codigo de pais y telefono">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Rol</label>
                                    <select name="rol" id="rol" class="form-control">
                                        <option value="alumno">Alumno</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear usuario</button>
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
        $('.deporte').select2({
            width:'100%',
            height: 'resolve',
            placeholder: 'Selecciona las disciplinas'
        })

        function limpiezaRut(event){
            let rut = $('#rut').val();
            let rutNoSpaces = rut.replaceAll(' ','');
            let rutNoComa = rutNoSpaces.replaceAll(',','');
            let rutNoPoint = rutNoComa.replaceAll('.','');

            $('#rut').val(rutNoPoint)
        }
    </script>
@endsection
