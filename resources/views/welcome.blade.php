<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
    <title>{{ config('adminlte.title') }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/style.css') }}">
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
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" autocomplete="off">
                    <label for="#">Email</label>
                </div>

                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password">
                    <label for="#">Password</label>
                </div>

                <div class="recordar">
                    <a href="#">¿No recuerda contraseña?</a>
                </div>

                <button type="submit" class="btn">Iniciar sesion</button>
                <div class="registrar">
                    <p>¿No tienes cuenta? <a href="#" class="registrar-link">Registrate</a></p>
                </div>
            </form>
        </div>

        <div class="contenedor-form registrar">
            <h2>¡Registrate!</h2>
            <form action="" method="post">
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="" id="" required>
                    <label for="#">Ingresa tu nombre</label>
                </div>
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="" id="" required>
                    <label for="#">Email</label>
                </div>
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password">
                    <label for="#">Contraseña</label>
                </div>
                <div class="contenedor-input">
                    <select name="plan" id="plan" required>
                        <option value="">Selecciona un plan</option>
                        @foreach ($planes as $plan)
                            <option value="{{ $plan->id }}">{{ Str::ucfirst($plan->nombre_plan) }}
                                {{ number_format($plan->monto, 0, ',', '.') }} + IVA ({{ $plan->numero_clases }} clases)
                            </option>
                        @endforeach
                    </select>
                    <label for="#">Plan</label>
                </div>
                <div class="contenedor-input">
                    <select name="payment" id="payment" required>
                        <option value="">Selecciona un medio de pago</option>
                        <option value="khipu">Khipu</option>
                    </select>
                    <label for="#">Metodo de pago</label>
                </div>

                <button type="submit" class="btn">Pagar y registrarse</button>

                <div class="registrar">
                    <p>¿Tienes cuenta? <a href="#" class="login-link">Inicia sesion</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('vendor/adminlte/dist/js/app.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//storage.googleapis.com/installer/khipu-2.0.js"></script>
    <script>
        $('#payment, #plan').on('change', function() {
            paymentBtn();
        })

        const paymentBtn = () => {
            let getPlanUrl = "{{ secure_url('/') }}/planes/get-plan/" + $('#plan').val();

            $.get(getPlanUrl).done(function(responsePlan) {
                let paymentObject = {
                    _token: '{{ csrf_token() }}',
                    mode: $('#payment').val(),
                    plan: $('#plan').val(),
                    amount: responsePlan.data[0].monto,
                }

                let urlPayment = '{{ route('payments.crear-pago') }}';
                $.post(urlPayment, paymentObject).done(function(responsePaymentCreation) {
                    console.log(responsePaymentCreation);
                })
            })



        }
    </script>

</body>

</html>
