<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
    <title>{{ config('adminlte.title') }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/style.css') }}">


    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
</head>

<body>
    <header>
        <nav class="navegacion">
            <img class="responsive-logo" src="{{ asset($logoSeleccionado) }}" alt="" width="200px">
        </nav>
    </header>

    <div class="fondo active-btn">
        <div class="contenedor-form login">
            <h2>Iniciar sesion</h2>
            <div class="contenedor-input">
                <input type="text" name="rut" id="rut" autocomplete="off">
                <label for="#">Rut</label>
            </div>
            <div class="contenedor-input">
                <span class="icono"></span>
                <select name="clase" id="clase">
                    <option value="">Selecciona una clase</option>
                </select>
                <label for="#">Clases disponibles</label>
            </div>

            <button type="button" class="btn" id="goToPanel">Acceder a mi panel</button>
            <div class="registrar">
                <p>¿No tienes cuenta? <a href="#" class="registrar-link">Registrate</a></p>
            </div>
        </div>

        <div class="contenedor-form registrar">
            <h2>¡Registrate!</h2>
            <form action="" method="post">
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="nameNewUser" id="nameNewUser" required>
                    <label id="labelNombre" for="#">Ingresa tu nombre</label>
                </div>
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="emailNewUser" id="emailNewUser" required>
                    <label id="labelEmail" for="#">Email</label>
                </div>
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="passwordNewUser" id="passwordNewUser">
                    <label id="labelContrasena" for="#">Contraseña</label>
                </div>
                <div class="contenedor-input">
                    <select name="plan" id="plan" required>
                        <option value=""></option>
                        @foreach ($planes as $plan)
                            <option value="{{ $plan->id }}">{{ Str::ucfirst($plan->nombre_plan) }}
                                {{ number_format($plan->monto, 0, ',', '.') }} + IVA ({{ $plan->numero_clases }} clases)
                            </option>
                        @endforeach
                    </select>
                    <label id="labelPlan" for="#">Plan</label>
                </div>
                <button type="button" id="btnRegistrar" class="btn btn-registrar">Registrar</button>
                <div class="registrar">
                    <p>¿Tienes cuenta?<br><a href="#" class="login-link">Inicia sesion o marca tu asistencia</a>
                    </p>
                </div>
            </form>
            <div id="webpaySection"></div>
        </div>
    </div>
    <script src="{{ asset('vendor/adminlte/dist/js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#rut').focus();
        })

        $('#goToPanel').on('click touchstart', function() {
            location.href = "{{ route('welcome') }}"
        })

        $('#rut').on('input', function() {
            let rut = $(this).val();
            let length = rut.length;

            if (length >= 9) {
                let url = "{{ route('asistencia.buscarClases') }}"
                let clasesDisponiblesData = {
                    _token: '{{ csrf_token() }}',
                    rut
                }

                $.post(url, clasesDisponiblesData).done(function(response) {
                    $('#clase').empty();
                    $('#clase').append('<option value="">Selecciona una clase</option>');

                    $.each(response.data, function(key, value) {
                        $('#clase').append($('<option>', {
                            value: value.fecha,
                            text: "Clase del " + value.fecha
                        }));
                    });

                    $('#clase').on('change', function() {
                        let clase = $('#clase').val();

                        swal.fire({
                            icon: 'question',
                            title: 'Accion de marca de asistencia',
                            html: '¿Deseas marcar asistencia a la clase de ' + clase + '?<br>Esta accion es <strong>irreversible</strong>',
                            showConfirmButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Marcar asistencia',
                            cancelButtonText: 'Cancelar accion'
                        }).then((result) => {
                            if (result.value) {
                                let urlMarca = "{{ route('asistencia.marcar') }}"
                                let asistenciaMark = {
                                    _token: "{{ csrf_token() }}",
                                    clase,
                                    rut
                                }

                                $.post(urlMarca, asistenciaMark)
                                .done(function (response) {
                                    response.result ?
                                    toastr.success(response.message) :
                                    toastr.error(response.message)
                                })

                            } else {
                                toastr.info('Accion cancelada por el usuario')
                            }
                        })
                    })
                })
            }

        })

        $('.btn-registrar').on('click touchstart', function() {
            paymentBtn();
        })

        const paymentBtn = () => {
            let getPlanUrl = "{{ secure_url('/') }}/planes/get-plan/" + $('#plan').val();

            $.get(getPlanUrl).done(function(responsePlan) {
                let paymentObject = {
                    _token: '{{ csrf_token() }}',
                    plan: $('#plan').val(),
                    amount: responsePlan.data[0].monto,
                    user: $('#nameNewUser').val(),
                    email: $('#emailNewUser').val(),
                    password: $('#passwordNewUser').val()
                }

                let urlPayment = '{{ route('payments.crearPago') }}';
                $.post(urlPayment, paymentObject).done(function(responsePaymentCreation) {
                    if (responsePaymentCreation.result) {
                        $('#nameNewUser').prop('disabled', true)
                        $('#emailNewUser').prop('disabled', true)
                        $('#passwordNewUser').prop('disabled', true)
                        $('#plan').prop('disabled', true)

                        $('#labelNombre').hide();
                        $('#labelEmail').hide();
                        $('#labelContrasena').hide();
                        $('#labelPlan').hide();

                        $('#btnRegistrar').hide();
                        $('#webpaySection').html(responsePaymentCreation.form)
                    }
                })
            })
        }
    </script>
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif

</body>

</html>
