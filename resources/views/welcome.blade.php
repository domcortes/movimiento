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
        <span class="icono-cerrar">
            <i class="fa-solid fa-xmark"></i>
        </span>

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
            <h2>Registrar</h2>
            <form action="" method="post">
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="" id="">
                    <label for="#">Nombre usuario</label>
                </div>
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="" id="">
                    <label for="#">Email</label>
                </div>
                <div class="contenedor-input">
                    <span class="icono"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="" id="">
                    <label for="#">Contraseña</label>
                </div>

                <button type="submit" class="btn">Registrarse</button>

                <div class="registrar">
                    <p>¿Tienes cuenta? <a href="#" class="login-link">Inicia sesion</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('vendor/adminlte/dist/js/app.js') }}"></script>
</body>

</html>
