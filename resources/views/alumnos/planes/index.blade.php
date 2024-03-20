@extends('adminlte::page')

@section('content')
    <br>
    <div class="card">
        <div class="card-header bg-dark">
            <div class="row">
                <div class="col-md-6">{{ $usuario->name }}</div>
                <div class="col-md-6">
                    <div class="btn-group float-right">
                        @if (auth()->user()->role === 'alumno')
                            <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>
                        @else
                            <a href="{{ route('alumnos.index') }}" class="btn btn-primary">Volver</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha de pago</th>
                        <th>Nombre Profesor</th>
                        <th>Inicio mensualidad</th>
                        <th>Termino Mensualidad</th>
                        <th>Cantidad de clases</th>
                        <th>Clases tomadas</th>
                        <th>Monto pagado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($misPlanes as $miPlan)
                        <tr>
                            <td>{{ $miPlan->fecha_pago }}</td>
                            <td>{{ $miPlan->nombre_profesor }}</td>
                            <td>{{ $miPlan->fecha_inicio_mensualidad }}</td>
                            <td>{{ $miPlan->fecha_termino_mensualidad }}</td>
                            <td>{{ $miPlan->cantidad_clases }}</td>
                            <td></td>
                            <td>{{ number_format($miPlan->monto, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group">
                                    @if (auth()->user()->role === 'alumno')
                                        <a href="{{ route('clases.show', $miPlan->id) }}" class="btn btn-primary">Ver mis clases</a>
                                    @else
                                        <a href="{{ route('clases.show', $miPlan->id) }}" class="btn btn-primary">Ver clases</a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">No existen planes activos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
