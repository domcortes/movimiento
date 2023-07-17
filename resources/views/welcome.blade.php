@extends('adminlte::auth.login')

@section('auth_header','Ingresa tu rut sin puntos y con guión')
@section('css')
    <style>
        .float{
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:40px;
            background-color:#25d366;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            font-size:30px;
            box-shadow: 2px 2px 3px #999;
            z-index:100;
        }

        .my-float{
            margin-top:16px;
        }
    </style>
@stop

@section('auth_body')
    <form action="" method="post">
        @csrf
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Rut</label>
                    <input type="text" name="rut" id="rut" class="form-control" onKeyPress="return limpiezaRut(event)" placeholder="123456789-0">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <button class="btn btn-primary float-right" id="register" disabled>OSS!</button>
                <a href="{{ route('login') }}" class="btn btn-dark">Intranet</a>
            </div>
        </div>
    </form>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=56939089104&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Nataleglock%20Jiujitsu." class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
@stop

@section('auth_footer')

@stop

@section('js')
    <script>

        function limpiezaRut(event){
            let rut = $('#rut').val();
            let rutNoSpaces = rut.replaceAll(' ','');
            let rutNoComa = rutNoSpaces.replaceAll(',','');
            let rutNoPoint = rutNoComa.replaceAll('.','');

            $('#rut').val(rutNoPoint)
        }

        $('#rut').on('change', function(){
            let dataCheck = {
                _token: '{{ csrf_token() }}',
                rut: $(this).val(),
                date: new Date().toISOString().split('T')[0]
            }

            let url = '{{ route('usuario.checkRut') }}';

            $.post(url, dataCheck)
            .done(function (response) {
                if(response.result) {
                    $('#register').prop('disabled', false)
                    swal.fire({
                        imageUrl: '{{ secure_url('/') }}/vendor/adminlte/dist/img/leglockTransparente.png',
                        imageWidth: 100,
                        imageHeight: 100,
                        imageAlt: 'Custom image',
                        title: 'Mensaje de Nataleglock',
                        text: response.message,
                        showConfirmButton:true,
                        confirmButtonText:'Oss!'
                    })
                } else {
                    swal.fire({
                        imageUrl: '{{ secure_url('/') }}/vendor/adminlte/dist/img/leglockTransparente.png',
                        imageWidth: 100,
                        imageHeight: 100,
                        imageAlt: 'Custom image',
                        title: 'Mensaje de Nataleglock',
                        text: response.message,
                        showConfirmButton:true,
                        confirmButtonText:'Oss!'
                    })
                }

                $(this).val('')
            })
        })
    </script>
@stop
