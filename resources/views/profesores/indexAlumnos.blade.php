@extends('adminlte::page')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            Listado de Alumnos
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalCrearUsuario">Agregar profesor</button>
                                <button type="button" class="btn btn-secondary planes" data-toggle="modal"
                                    data-target="#modalPlanes">Crear plan</button>
                            </div>
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
                            @foreach ($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->name }}</td>
                                    <td><a href="mailto:{{ $alumno->email }}">{{ $alumno->email }}</a></td>
                                    <td><a href="tel:+{{ $alumno->telefono }}">+{{ $alumno->telefono }}</a></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-info">
                                                Mensualidades
                                            </a>
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

        $('.planes').on('click', function() {
            $('#planTable').empty();
        })

        $('#teacher').on('change', function() {
            let teacher = $(this).val();
            let url = '{{ secure_url('/') }}/planes/' + teacher

            $.get(url).done(function(response) {
                $('#planTable').empty();

                response.data.forEach(function(item) {
                    let newRow = '<tr><td>' + item.numero_clases + '</td><td>' + item.monto +
                        '</td></tr>';
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
