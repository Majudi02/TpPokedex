<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para acceder a esta página.';
    header('Location: index.php');
    exit();
}
require_once 'MyDatabase.php';
include 'encontrar_pokemon.php';
?>

<!DOCTYPE html><html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <title>Pokedex</title>
    </head>

<body>
    <?php include 'header.php'; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php

$database = new MyDatabase();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['Usuario'];
    $password = $_POST['Password'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario'] = strtoupper($usuario); // Guarda el usuario en la sesion
        $_SESSION['success'] = 'Inicio de sesión exitoso. ¡Bienvenido!';
        header('Location: inicio_logueado.php');
        exit();
    } else {
        $_SESSION['error'] = 'Usuario o contraseña incorrecta';
        header('Location: login.php'); // Vuelve a login si hay error
        exit();
    }
}
?>