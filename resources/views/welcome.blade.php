<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url("https://z-p3-scontent.fpuq3-1.fna.fbcdn.net/v/t39.30808-6/317693314_667099621418860_5229976934178739457_n.png?_nc_cat=105&ccb=1-7&_nc_sid=783fdb&_nc_eui2=AeF-gjn1-GjfHrNqdlKZxUg5SwlFN3ErnFFLCUU3cSucUbY_WTyJT4pg0k8dt_U9v9Ta2y7mnC3IVUue15rOr0Ih&_nc_ohc=ot11JbKn3H0AX_vyWPY&_nc_zt=23&_nc_ht=z-p3-scontent.fpuq3-1.fna&oh=00_AfC8TRWqohDcU-EZ3kflGuLK6-SRsJkAoF2DQWwjsaKweQ&oe=65C5D9FF");
            background-size: cover;
        }

        .container-form {
            height: 500px;
            display: flex;
            border-radius: 20px;
            box-shadow: 0 5px 7px rgba(0, 0, 0, .1);
            transition: all 1s ease;
            max-width: 900px;
            margin: 10px;
        }

        .information {
            width: 40%;
            display: flex;
            align-items: center;
            text-align: center;
            background-color: rgba(0, 52, 135, 0.93);
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .info-childs {
            width: 100%;
            padding: 0 30px;
        }

        .info-childs h2 {
            font-size: 2.5rem;
            color: white;
        }

        .info-childs p {
            margin: 15px 0;
            color: white;
        }

        .info-childs input {
            background-color: transparent;
            outline: none;
            border: solid 2px #9191bd;
            border-radius: 20px;
            padding: 10px 20px;
            color: #9191bd;
            cursor: pointer;
            transition: background-color .3s ease;
        }

        .info-childs input:hover {
            background-color: #9191bd;
            border: none;
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .form-information {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 60%;
            background-color: #f8f8f8;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .form-information-childs {
            padding: 0 30px;
        }

        .form-information-childs h2 {
            color: #333;
            font-size: 2rem;
        }

        .form-information-childs p {
            color: #555;
        }

        .icons {
            margin: 15px 0;
        }

        .icons i {
            border-radius: 50%;
            padding: 15px;
            cursor: pointer;
            margin: 0 10px;
            color: #9191bd;
            border: solid thin #9191bd;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .icons i:hover {
            background-color: #c7c7f3;
            color: #fff;
        }

        .form {
            margin: 30px 0 0 0;
        }

        .form label {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-radius: 20px;
            padding: 0 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
            background-color: #fff;
        }

        .form label input {
            width: 100%;
            padding: 10px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 20px;
            color: #333;
        }

        .form label select {
            width: 100%;
            padding: 10px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 20px;
            color: #333;
        }

        .form label i {
            color: #a7a7a7;
        }

        .form button[type="submit"] {
            background-color: #9191bd;
            color: #fff;
            border-radius: 20px;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .form button[type="button"] {
            background-color: #9191bd;
            color: #fff;
            border-radius: 20px;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .form button[type="submit"]:hover {
            background-color: #7a7a9a;
            transition: background-color 0.3s ease;
        }

        .form button[type="button"]:hover {
            background-color: #7a7a9a;
            transition: background-color 0.3s ease;
        }

        .form a {
            background-color: rgba(148, 19, 86, 0.8);
            color: #fff;
            border-radius: 20px;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .form a:hover {
            background-color: rgba(197, 69, 135, 0.8);
        }

        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .my-float {
            margin-top: 16px;
        }

        @media screen and (max-width: 750px) {
            html {
                font-size: 12px;
            }

            body {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                background-image: url("https://renzogracieacademy.com/wp-content/uploads/2019/09/Carlos-and-Helio-Gracie-Brazilian-Jiu-Jitsu-Grandmasters.jpg.webp");
                background-repeat: no-repeat;
                background-position: center center;
            }
        }

        @media screen and (max-width: 580px) {
            html {
                font-size: 10px;
            }

            body {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                background-image: url("https://renzogracieacademy.com/wp-content/uploads/2019/09/Carlos-and-Helio-Gracie-Brazilian-Jiu-Jitsu-Grandmasters.jpg.webp");
                background-repeat: no-repeat;
                background-position: center center;
            }

            .container-form {
                flex-direction: column;
                height: auto;
            }

            .information {
                width: 100%;
                padding: 20px;
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                border-bottom-left-radius: 0px;
            }

            .form-information {
                width: 100%;
                padding: 20px;
                border-top-left-radius: 0px;
                border-top-right-radius: 0;
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
            }

            .bx {
                font-family: boxicons !important;
                font-weight: 400;
                font-style: normal;
                font-variant: normal;
                line-height: 1;
                text-rendering: auto;
                display: inline-block;
                text-transform: none;
                speak: none;
                padding-top: 15px;
                -webkit-font-smoothing: antialiased;
            }
        }
    </style>
    <title>Inicio de sesión | {{ config('adminlte.title') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ config('adminlte.logo') }}">
</head>

<body>
    <div class="container-form">
        <div class="information">
            <div class="info-childs">
                <img src="{{ config('adminlte.logo_img') }}" alt="" style="width: 30%">
                <h2>{{ config('adminlte.title', 'AdminLTE 3') }}</h2>
                <p>“Lo importante no es ser mejor que otra persona, sino ser mejor que ayer”. </p>
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar sesión con tus datos</h2>
                @php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
                @php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
                @php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

                <form action="{{ $login_url }}" method="post" class="form">
                    @csrf
                    <label>
                        <i class="bx bx-envelope"></i>
                        <input type="text" name="rut" id="rut" onKeyPress="return limpiezaRut(event)"
                            placeholder="123456789-0" autocomplete="off" autofocus>
                        @error('email')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </label>
                    <label>
                        <i class="bx bx-lock-alt"></i>
                        <select name="sport" id="sport">
                            <option value="">Selecciona una disciplina</option>
                            <option value="jiujitsu">Jiujitsu</option>
                            <option value="nogi">NOGI</option>
                            <option value="mma">MMA</option>
                            <option value="fisico">Acondicionamiento Físico</option>
                        </select>
                    </label>
                    <br>
                    <button type="button" id="info">Informacion importante</button>
                </form>
                <a href="https://api.whatsapp.com/send?phone=56989004946&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Nataleglock%20Jiujitsu."
                    class="float" target="_blank">
                    <i class='bx bxl-whatsapp'></i>
                </a>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function limpiezaRut(event) {
            let rut = $('#rut').val();
            let rutNoSpaces = rut.replaceAll(' ', '');
            let rutNoComa = rutNoSpaces.replaceAll(',', '');
            let rutNoPoint = rutNoComa.replaceAll('.', '');
            $('#rut').val(rutNoPoint)
        }

        $('#rut').on('change', function() {
            marcarAsistencia()
        })

        $('#sport').on('change', function() {
            marcarAsistencia()
        })

        function marcarAsistencia() {
            let fecha = new Date().toISOString()
            let recaptcha = '{{ env('RECAPTCHA_SITIO') }}'
            let sport = $('#sport').val();
            let rut = $('#rut').val();

            let dataCheck = {
                _token: '{{ csrf_token() }}',
                rut: rut,
                date: fecha.split('T')[0],
                dateTime: fecha.split('T')[0] + ' ' + fecha.split('T')[1].slice(0, -5),
                sport: sport,
                recaptcha: recaptcha
            }

            let url = '{{ route('usuario.checkRut') }}';

            if (sport !== '' && rut !== '') {
                $.post(url, dataCheck)
                    .done(function(response) {
                        if (response.result) {
                            $('#register').prop('disabled', false)
                            swal.fire({
                                imageUrl: '{{ secure_url('/') }}/vendor/adminlte/dist/img/leglockTransparente.png',
                                imageWidth: 100,
                                imageHeight: 100,
                                imageAlt: 'Custom image',
                                title: 'Mensaje de Nataleglock',
                                text: response.message,
                                showConfirmButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Oss!',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.value) {
                                    swal.fire({
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    })
                                    let urlAsistencia = '{{ route('usuario.marcarAsistencia') }}'

                                    $.post(urlAsistencia, dataCheck)
                                        .done(function(responseAsistencia) {
                                            swal.close();

                                            if (responseAsistencia.result) {
                                                let soundfile =
                                                    "{{ secure_url('/') }}/vendor/adminlte/dist/sound/redalert.mp3";
                                                swal.fire({
                                                    imageUrl: '{{ secure_url('/') }}/vendor/adminlte/dist/img/leglockTransparente.png',
                                                    imageWidth: 100,
                                                    imageHeight: 100,
                                                    imageAlt: 'Custom image',
                                                    title: 'Mensaje de Nataleglock',
                                                    html: responseAsistencia.message,
                                                    showConfirmButton: true,
                                                    confirmButtonText: 'Oss!',
                                                    onOpen: function() {
                                                        if (responseAsistencia.alerta) {
                                                            var audplay = new Audio(soundfile)
                                                            audplay.play();
                                                        }
                                                    },
                                                });
                                            }
                                        })
                                } else {
                                    swal.fire({
                                        imageUrl: '{{ secure_url('/') }}/vendor/adminlte/dist/img/leglockTransparente.png',
                                        imageWidth: 100,
                                        imageHeight: 100,
                                        imageAlt: 'Custom image',
                                        title: 'Mensaje de Nataleglock',
                                        text: 'Has cancelado tu ingreso a nuestra escuela',
                                        showConfirmButton: true,
                                        confirmButtonText: 'Oss!',
                                    });
                                }
                            })
                        } else {
                            swal.fire({
                                imageUrl: '{{ secure_url('/') }}/vendor/adminlte/dist/img/leglockTransparente.png',
                                imageWidth: 100,
                                imageHeight: 100,
                                imageAlt: 'Custom image',
                                title: 'Mensaje de Nataleglock',
                                text: response.message,
                                showConfirmButton: true,
                                confirmButtonText: 'Oss!'
                            })
                        }

                        $('#rut').val('')
                    })
            }
        }

        $('#info').on('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Informacion importante de nuestro club',
                html: 'En esta seccion encontraras informacion importante sobre Nataleglock y como funcionamos',
                showConfirmButton: true,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Privacidad',
                denyButtonText: 'Reglamento interno',
                cancelButtonText: '',
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('informaciones.privacidad') }}";
                    window.open(url, '_blank')
                }

                if (result.isDenied) {
                    let url = "{{ route('informaciones.reglamento') }}";
                    window.open(url, '_blank')
                }

            })
        })
    </script>
</body>

</html>
