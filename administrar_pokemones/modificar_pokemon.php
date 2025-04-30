<?php
require_once ('../header.php');
require_once ('../MyDatabase.php');
$database = new MyDatabase();

$errores = [];
$modificacion_exitosa = false;

$id = (int) $_GET['id'];
$pokemon = $database->query("SELECT * FROM pokemones WHERE id=".$id);
if (empty($pokemon)) {
    $errores[] = "No se encontró el Pokémon con ID $id.";
} else {
    $pokemon = $pokemon[0];

    $nombre = $pokemon['nombre'];
    $id_unico = $pokemon['id_unico'];
    $tipo_id = $pokemon['tipo_id'];
    $descripcion = $pokemon['descripcion'];
    $imagen_nombre = $pokemon['imagen'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errores)) {
    // Aquí definimos las variables una vez que el formulario se envió
    $nombre = $_POST['nombre'];
    $id_unico = $_POST['id_unico'];
    $tipo_id = (int) $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $imagen_nombre = $pokemon['imagen']; // mantener la imagen anterior por defecto

    // Si se subió una nueva imagen:
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_original = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $extension = strtolower(pathinfo($imagen_original, PATHINFO_EXTENSION));
        $imagen_nombre = strtolower($nombre) . "." . $extension;
        $ruta_destino = "../imagenes/" . $imagen_nombre;

        if (!move_uploaded_file($imagen_tmp, $ruta_destino)) {
            $errores[] = "Error: No se pudo subir la nueva imagen.";
        } else {
            // Borro la imagen anterior si es distinta
            $imagen_anterior = "../imagenes/" . $pokemon['imagen'];
            if ($imagen_anterior !== $ruta_destino && file_exists($imagen_anterior)) {
                unlink($imagen_anterior);
            }
        }
    }
}

if (empty($errores)) {
    $query = "UPDATE pokemones SET 
                nombre = '$nombre', 
                id_unico = '$id_unico', 
                tipo_id = $tipo_id, 
                descripcion = '$descripcion', 
                imagen = '$imagen_nombre' 
              WHERE id = $id";

    $modificacion_exitosa = $database->execute($query);
}

?>

<div class="container mt-5">
    <div class="card shadow rounded mb-5" style="background-color: #d2f4ea;">
        <?php
        if (!empty($errores)) {
            echo "<div class='alert alert-danger'>";
            foreach ($errores as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errores) && isset($modificacion_exitosa) && $modificacion_exitosa) {
            echo "<div class='alert alert-success'>Pokémon modificado con éxito</div>";
        }
        ?>
        <div class="card-header">
            <h2 class="mb-0">Modificar Pokemon</h2>

        </div>
        <a class='btn btn-outline-secondary' href='../inicio_logeado.php'>Todos los Pokemones</a>
        <div class="card-body">
            <form action="modificar_pokemon.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                <!-- Nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Pokemon</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($pokemon['nombre']) ?>" required>
                </div>

                <!-- ID Único -->
                <div class="mb-3">
                    <label for="id_unico" class="form-label">ID del Pokemon</label>
                    <input type="text" class="form-control" id="id_unico" name="id_unico" value="<?= $pokemon['id_unico'] ?>" required>
                </div>

                <!-- Tipo -->
                <div class="mb-3">
                    <label class="form-label d-block">Tipo</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" value="1" <?= $pokemon['tipo_id'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tipoFuego">Fuego</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" value="2" <?= $pokemon['tipo_id'] == 2 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tipoAgua">Agua</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" value="3" <?= $pokemon['tipo_id'] == 3 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tipoElectrico">Eléctrico</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" value="4" <?= $pokemon['tipo_id'] == 4 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tipoPlanta">Planta</label>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($pokemon['descripcion']) ?></textarea>
                </div>

                <!-- Imagen actual -->
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen del Pokemon Actual:</label>
                    <p class="ms-5"> <img src="../imagenes/<?= $pokemon['imagen'] ?>" width="100"></p>
                    <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-success">Modificar Pokemon</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once ('../footer.php');
