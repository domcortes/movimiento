@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1>Listado de clases</h1>
        </div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                @if (auth()->user()->role === 'profesor' || auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalContenido">Nuevo contenido</button>
                @endif
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="alert alert-info">
        <div class="row">
            <div class="col-md-4">
                {{ $pago->fecha_inicio_mensualidad }} | {{ $pago->fecha_termino_mensualidad }}
            </div>
            <div class="col-md-4 text-center">
                {{ $pago->cantidad_clases }} clases incluidas
            </div>
            <div class="col-md-4 text-right">
                xx clases tomadas
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="timeline">
                    @foreach ($clases as $clase)
                        <div class="time-label">
                            <span class="bg-green">{{ $clase->fecha }}</span>
                        </div>
                        <div>
                            <i class="fa fa-camera bg-purple"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
                                <h3 class="timeline-header"><a href="#">{{ $clase->nombreCreador }}</a> <small>cargó nuevo contenido</small></h3>
                                <div class="timeline-body">
                                    {!! $clase->contenido !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalContenido" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar contenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('clases.update', $pago->id) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Fecha Clase</label>
                                    <input type="date" name="fechaInicio" id="fechaInicio" required
                                        min="{{ $pago->fecha_inicio_mensualidad }}"
                                        max="{{ $pago->fecha_termino_mensualidad }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Agrega tu contenido aqui</label>
                                    <textarea id="summernote" name="contenido"></textarea>
                                </div>
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
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Agregue su contenido aqui',
                lang: 'es-ES',
                height: 200,
            });
        });
    </script>
    @include('js.toastr')
@stop
