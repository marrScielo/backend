<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Nuevo Mensaje de Contacto</h2>
<p><strong>Nombre:</strong> {{ $datos['nombre'] }} {{ $datos['apellido'] }}</p>
<p><strong>Email:</strong> {{ $datos['email'] }}</p>
<p><strong>Celular:</strong> {{ $datos['celular'] }}</p>
<p><strong>Comentario:</strong></p>
<p>{{ $datos['comentario'] }}</p>

</body>
</html>