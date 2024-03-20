<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenida a Movimiento NA</title>
</head>
<body>
    <div class="container">
        <p>Bienvenido a <strong>Movimiento NA!</strong></p>
        <p>En este mail te damos la bienvenida, dentro de poco enviaremos tambien tu mail de pago respectivo</p>
        <p>Tu nuevo usuario de acceso es {{ $usuario->email }} y la contrasena es la que pusiste al comienzo de este registro</p>
        <p>El link de acceso es <a href="{{ route('welcome') }}">este</a></p>
        <br><br><br>
        <p>Cualquier duda puedes contactarte con el administrador <a href="#">aqui</a></p>
        <p>Bienvenido</p>
        <hr>
        <small>
            <ul>
                <li>Este mail fue enviado de forma automatica, favor no responder</li>
                <li>No es necesario imprimirlo, salvemos al planeta solo mostrando este mail desde tu dispositivo inteligente</li>
            </ul>
        </small>
    </div>
</body>
</html>
