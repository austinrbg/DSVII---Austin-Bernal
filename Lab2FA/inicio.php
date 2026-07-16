<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema Seguro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #003366; /* Azul oscuro estilo institucional */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .welcome-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            box-sizing: border-box;
            transition: background-color 0.3s;
        }
        .btn-login {
            background-color: #0078FF;
        }
        .btn-login:hover {
            background-color: #005bb5;
        }
        .btn-registro {
            background-color: #28a745;
        }
        .btn-registro:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <h1>Bienvenido al Sistema</h1>
        <p>Seleccione una opción para continuar</p>

        <a href="login.php" class="btn btn-login">Iniciar Sesión</a>

        <a href="registro.php" class="btn btn-registro">Registrarse</a>
    </div>

</body>
</html>