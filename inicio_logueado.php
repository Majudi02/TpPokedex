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
<?php

$database = new MyDatabase();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Usuario']) && isset($_POST['Password'])) {
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
    <main class="flex-grow-1">
        <!-- Formulario de búsqueda -->
        <div class="container d-flex justify-content-center mt-5">
            <form class="d-flex" style="width: 100%; max-width: 900px;" action="inicio_logueado.php" method="post">
                <div class="input-group">
                    <input class="form-control rounded-start-pill" type="text" name="pokemonBuscado" placeholder="Ingrese el nombre, tipo o número de pokémon">
                    <button class="btn text-white rounded-end-pill" type="submit" style="background-color: #20c997;">
                        ¿Quién es este Pokémon?
                    </button>
                </div>
            </form>
        </div>

        <!-- Mostrar resultados de búsqueda o todos los pokemones -->
        <div class="container mt-5 pb-5">
            <?php
            require_once 'MyDatabase.php';
            $db = new MyDatabase();

            // Función para obtener el tipo de Pokémon
            function getTipoById($tipo_id, $db) {
                $resultado = $db->query("SELECT imagen FROM tipo WHERE id = $tipo_id");
                return $resultado ? $resultado[0]['imagen'] : 'default.png';
            }

            // Lógica de búsqueda
            if (isset($_POST["pokemonBuscado"])) {
                $resultadoBusqueda = encontrarPokemon($db);

                if ($resultadoBusqueda === false) {
                    echo "<div class='text-danger'>
                        <h4>Pokemon no encontrado!</h4>
                      </div>";
                }
            }

            // Si es una lista de pokemones
            if (isset($resultadoBusqueda) && is_array($resultadoBusqueda)) {
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Numero</th><th>Nombre</th><th>Imagen</th><th>Tipo</th><th>Acciones</th></tr></thead>";

                foreach ($resultadoBusqueda as $pokemon) {
                    echo "<tbody><tr>";
                    echo "<td>" . htmlspecialchars($pokemon['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($pokemon['nombre']) . "</td>";
                    echo "<td><img src='Imagenes/Pokemones/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></td>";
                    $tipo = getTipoById($pokemon['tipo_id'], $db);
                    echo "<td><img src='Imagenes/Tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                    echo "<td>
                        <a href='./administrar_pokemones/modificar_pokemon.php?id={$pokemon['id']}' class='btn btn-outline-secondary'>Modificar</a>
                        <a href='./administrar_pokemones/eliminar_pokemon.php?id={$pokemon['id']}'
                             class='btn btn-outline-secondary'
                             onclick=\"return confirm('¿Estás seguro de que querés eliminar este Pokémon?');\">
                             Eliminar
                        </a>
                      </td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            }
            // Si no hay búsqueda, mostrar todos los pokemones
            else {
                $pokemones = $db->query("SELECT * FROM pokemones");
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Numero</th><th>Nombre</th><th>Imagen</th><th>Tipo</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";

                foreach ($pokemones as $pokemon) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($pokemon['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($pokemon['nombre']) . "</td>";
                    echo "<td><img src='Imagenes/Pokemones/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></td>";
                    $tipo = getTipoById($pokemon['tipo_id'], $db);
                    echo "<td><img src='Imagenes/Tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                    echo "<td>
                        <a href='./administrar_pokemones/modificar_pokemon.php?id={$pokemon['id']}' class='btn btn-outline-secondary'>Modificar</a>
                        <a href='./administrar_pokemones/eliminar_pokemon.php?id={$pokemon['id']}'
                             class='btn btn-outline-secondary'
                             onclick=\"return confirm('¿Estás seguro de que querés eliminar este Pokémon?');\">
                             Eliminar
                        </a>
                      </td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            }
            ?>
        </div>
        <div class="container d-flex justify-content-center mb-5 ">
            <a href='administrar_pokemones/agregar_pokemon.php' class='btn btn-outline-secondary w-100 fs-5 fw-semibold'>
                <img src="./Imagenes/agregar.png" alt="Agregar" width="25" class="me-2 mt-2 mb-2">
                Nuevo Pokemon
            </a>
        </div>
    </main>

<?php
require_once('footer.php');
