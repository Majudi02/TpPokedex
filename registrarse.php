<?php
session_start(); // Inicia la sesión

require_once 'MyDatabase.php';

$database = new MyDatabase();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['Usuario'];
    $password = $_POST['Password'];

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    if ($user) {
        $_SESSION['error'] = 'Este usuario ya está registrado.';
        header('Location: registrarse.php');
        exit();
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuario (usuario, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $usuario, $hash);
        $stmt->execute();

        $_SESSION['success'] = 'Te registraste correctamente. ¡Ahora puedes iniciar sesión!';
        header('Location: pagina_principal.php');
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
    <title>Pokedex - Registrarse</title>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">

<div class="card shadow p-4" style="width: 100%; max-width: 500px;">
    <h2 class="text-center mb-4">Registrarse</h2>

    <!-- Si el usuario ya existe muestra error-->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <form action="registrarse.php" method="POST">
        <div class="mb-3">
            <label for="Usuario" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="Usuario" name="Usuario" required>
        </div>
        <div class="mb-3">
            <label for="Password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="Password" name="Password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Registrarse</button>
        <a href="pagina_principal.php" class="btn btn-outline-secondary mt-2 w-100">Volver</a>
    </form>

    <p class="mt-3 text-center">¿Ya tenés cuenta? <a href="login.php">Iniciar sesión</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


