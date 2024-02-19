<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('https://www.conaf.cl/wp-content/files_mf/cache/th_4fdefb5842aa2dc68092ca1241ed9f5d_brigada-IF_bomberos200.jpg');
            background-size: cover;
            background-position: center
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 99;
        }

        .logo {
            font-size: 2.3rem;
            color: #fff;
            user-select: none;
            cursor: pointer;
        }

        .navegacion a {
            position: relative;
            font-size: 1.1rem;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;

        }

        .navegacion a::after {
            content: "";
            position: absolute;
            width: 100%;
            bottom: -6px;
            left: 0;
            height: 2px;
            background: #fff;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform .4s;
        }

        .navegacion a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .navegacion .btn {
            width: 140px;
            height: 50px;
            background: transparent;
            border: 2px solid #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            color: #fff;
            font-weight: 600;
            margin-left: 40px;
        }

        .navegacion .btn:hover {
            background: #fff;
            color: #090f1d;
        }

        .fondo {
            position: relative;
            width: 400px;
            height: 440px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .5);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: transform .5s ease height .2s ease;
            transform: scale(1);
        }

        .fondo .active-btn {
            transform: scale(1);
        }

        .fondo-active {
            height: 455px;
        }

        .fondo .contenedor-form {
            width: 100%;
            padding: 40px;
        }

        .fondo .contenedor-form.login {
            transition: .17s ease;
            transform: translateX(0);
        }

        .fondo.active .contenedor-form.login {
            transition: none;
            transform: translateX(-400px);
        }

        .fondo .active .contenedor-form.registar {
            transition: transform .17s ease;
            transform: translateX(0);
        }

        .fondo .icono-cerrar {
            position: absolute;
            top:  0;
            right: 0;
            width: 45px;
            height: 45px;
            background-color: #090f1d;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom-left-radius: 20px;
            cursor: pointer;
            z-index: 1;
            font-size: 1.8em;
            color: #f1efef;
        }

        .contenedor-form h2 {
            font-size: 2em;
            color: #f1efef;
            text-align: center;
        }

        .contentedor-input {
            position: relative;
            width: 100%;
            height: 50px;
            border-bottom: 2px solid #f1efef;
            margin: 30px 0;
        }

        .contenedor-input label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 1em;
            font-weight: 600;
            pointer-events: none;
            transition: .4s;
            color: #f1efef;
        }

        .contenedor-input input:focus~label,
        .contenedor-input input:valid~label{
            top: -5px;
        }

        .contenedor-input input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: #f1efef;
            padding: 0 35px 0 5px;
        }

        .contenedor-input .icono {
            position: absolute;
            right: 8px;
            font-size: 1.4em;
            color: #f1efef;
            line-height: 57px;
        }

        .recordar {
            font-size: .9em;
            margin: -15px 0 15px;
            display: flex;
            justify-content: space-between;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <header>
        <h2 class="logo">Movimiento</h2>
        <nav class="navegacion">
            <a href="#">link 1</a>
            <a href="#">link 2</a>
            <a href="#">link 3</a>
            <a href="#">link 4</a>
            <button class="btn">Iniciar sesion</button>
        </nav>
    </header>
    <div class="fondo">
        <span class="icono-cerrar">
            <i class="fa-solid fa-xmark"></i>
        </span>
        <div class="contenedor-form login">
            <h2>Iniciar sesion</h2>
            <form action="#">
                <div class="contenedor-input">
                    <span class="icono">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" required name="" id="">
                        <label for="#">Email</label>
                    </span>
                </div>
                <div class="contenedor-input">
                    <span class="icono">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" required name="" id="">
                        <label for="#">Contraseña</label>
                    </span>
                </div>
                <div class="recordar">
                    <a href="">¿Olvide contraseña?</a>
                </div>
                <button type="submit" class="btn">Iniciar sesion</button>
                <div class="registrar">
                    <p>¿sin cuenta? <a href="#" class="registrar-link">Registrarse</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
