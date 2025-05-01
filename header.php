<?php
if (session_status() === PHP_SESSION_NONE) {  //inicia sesion solo si no hay una previamente iniciada
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <title>Pokedex</title>

    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #d2f4ea;">
            <div class="container-fluid d-flex justify-content-between align-items-center">

                <a class="navbar-brand" href="index.php">
                    <img src="./Imagenes/Logo_img.png" alt="Logo" width="70" height="70" class="ms-3">
                </a>

                <div class="flex-grow-1 text-center">
                    <a href="index.php">
                        <img class="m-0 pb-2" src="./Imagenes/Logo_Pokdex.png" width="210" height="100" alt="Pokedex">
                    </a>
                </div>

                <div class="me-4 d-flex align-items-center">

                    <?php
                    $pagina_actual = basename($_SERVER['PHP_SELF']);
                    if (isset($_SESSION['usuario']) && $pagina_actual === 'inicio_logueado.php'): ?>
                        <span class="me-3 fw-bold">Usuario: <?php echo $_SESSION['usuario']; ?></span>
                        <a href="logout.php" class="btn btn-outline-danger">Cerrar sesión</a>

                    <?php elseif ($pagina_actual !== 'index.php'): ?>
                        <form action="login.php" method="post" class="d-flex align-items-center">
                            <a href="login.php" class="btn btn-outline-secondary me-2">Ingresar</a>
                            <a href="registrarse.php" class="btn btn-outline-success">Registrarse</a>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </nav>
    </header>