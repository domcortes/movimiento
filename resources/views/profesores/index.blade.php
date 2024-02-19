@extends('adminlte::page')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            Listado de Profesores
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#modalCrearUsuario">Agregar profesor</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="display" id="tablaPagos">
                        <thead>
                            <tr>
                                <th>Nombre Profesor</th>
                                <th>Rol</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profesores as $profesor)
                                <tr>
                                    <td>{{ $profesor->name }}</td>
                                    <td>{{ $profesor->role }}</td>
                                    <td><a href="mailto:{{ $profesor->email }}">{{ $profesor->email }}</a></td>
                                    <td><a href="tel:+{{ $profesor->telefono }}">+{{ $profesor->telefono }}</a></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary contenido"
                                                teacher='{{ $profesor->id }}' data-toggle="modal"
                                                data-target="#exampleModalLong">
                                                <i class="fa-solid fa-arrows-to-circle"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary planes"
                                                teacher='{{ $profesor->id }}' data-toggle="modal"
                                                data-target="#modalPlanes">
                                                <i class="fa-solid fa-ruler-combined"></i>
                                            </button>
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

    <div class="modal fade" id="modalCrearUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('profesores.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nombre de profesor</label>
                                    <input type="text" name="name" id="name" class="form-control" required
                                        placeholder="al menos un nombre y un apellido">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required
                                        placeholder="emailusuario@email.com">
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Rut</label>
                                    <input type="text" name="rut" id="rut" class="form-control"
                                        onKeyPress="return limpiezaRut(event)" required
                                        placeholder="sin puntos y con guion">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Teléfono celular <small>(para notificaciones por
                                            whatsapp)</small></label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" required
                                        placeholder="codigo de pais y telefono">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Rol</label>
                                    <select name="rol" id="rol" class="form-control">
                                        <option value="alumno">Alumno</option>
                                        <option value="profesor" selected>Profesor</option>
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

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear contenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Contenido destinado a:</label>
                                    <select name="destino" id="destino" class="form-control" required>
                                        <option value="">Selecciona a quien quieres compartir este contenido</option>
                                        <option value="publico">Publico general</option>
                                        <option value="especifico">Seleccion de alumnos con mensualidad al dia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Seleccion de alumnos <small>(solo usuarios con mensualidades al
                                            diasource)</small></label>
                                    <select name="alumnos[]" multiple="multiple" id="alumnos" class="form-control">
                                        @foreach ($alumnos as $alumno)
                                            <option value="{{ $alumno->id }}">{{ $alumno->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="">Contenido a cargar</label>
                                <textarea class="form-control" name="contenido" id="contenido" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear contenido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPlanes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear contenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <form action="{{ route('planes.store') }}" method="POST">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Selecciona un profesor</label>
                                                    <select name="teacher" id="teacher" class="form-control" required>
                                                        <option value="">Selecciona un proveedor</option>
                                                        @foreach ($profesores as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Cantidad de clases incluidas</label>
                                                    <input type="number" name="clases" id="clases"
                                                        class="form-control" placeholder="numero entero" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Monto del plan</label>
                                                    <input type="number" name="monto" id="monto"
                                                        class="form-control" placeholder="ej. : 40000" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Crear plan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Cant</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="planTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('js.datatable')
    @include('js.toastr')
    <script>
        $('#destino, #alumnos').select2({
            width: '100%',
            height: 'resolve',
        })

        $('#contenido').summernote();

        $('.planes').on('click', function(){
            $('#planTable').empty();
        })

        $('#teacher').on('change', function() {
            let teacher = $(this).val();
            let url = '{{ secure_url('/') }}/planes/' + teacher

            $.get(url).done(function(response) {
                $('#planTable').empty();

                response.data.forEach(function(item) {
                    let newRow = '<tr><td>' + item.numero_clases + '</td><td>' + item.monto + '</td></tr>';
                    $('#planTable').append(newRow);
                });
            })
        })

        function limpiezaRut(event) {
            let rut = $('#rut').val();
            let rutNoSpaces = rut.replaceAll(' ', '');
            let rutNoComa = rutNoSpaces.replaceAll(',', '');
            let rutNoPoint = rutNoComa.replaceAll('.', '');

            $('#rut').val(rutNoPoint)
        }
    </script>
@endsection
