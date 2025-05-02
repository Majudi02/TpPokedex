<?php
require_once 'MyDatabase.php';

$database = new MyDatabase();
$conn = $database->getConnection();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['Usuario'];
    $password = $_POST['Password'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario'] = strtoupper($usuario);
        $_SESSION['success'] = '¡Has iniciado sesión correctamente!';
        header('Location: inicio_logueado.php');
        exit();
    } else {
        $_SESSION['error'] = 'Usuario o contraseña incorrecta';
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Pokedex - Login</title>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">

<div class="card shadow p-4" style="width: 100%; max-width: 500px;">
    <h2 class="text-center mb-4">Iniciar sesión</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="mb-3">
            <input type="text" class="form-control" id="Usuario" name="Usuario" placeholder="Nombre de Usuario" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="Password" name="Password" placeholder="Contraseña" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Ingresar</button>
        <a href="pagina_principal.php" class="btn btn-outline-secondary mt-2 w-100">Volver</a>
    </form>

    <p class="mt-3 text-center">¿No tenés una cuenta? <a href="registrarse.php">Registrarse</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>