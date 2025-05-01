<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para acceder a esta página.';
    header('Location: ../index.php');
    exit();
}

require_once  '../header.php';
require_once  '../MyDatabase.php';
$errores =[];
$insertar_pokemon = false;
$database = new MyDatabase();

//No se va a ejecutar hasta que se envie el form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST['nombre'];
    $id_unico = $_POST['id_unico'];
    $tipo_id = (int) $_POST['tipo'];
    $descripcion = $_POST['descripcion'];


    //verifico que no exista un pokemon con el mismo nombre

    $verif_nombre = $database->query("SELECT id FROM pokemones WHERE nombre = '$nombre'");
    if (count($verif_nombre) > 0) {
        $errores[] = "Error: Ya existe un Pokemon con el nombre $nombre.";

    }

    //verifico que no exista un pokemon con el mismo id

    $verif_id = $database->query("SELECT id FROM pokemones WHERE id_unico = '$id_unico'");
    if (count($verif_id) > 0) {
        $errores[] = "Error: Ya existe un Pokemon con el ID $id_unico.";

    }

//imagen

        $imagen_original = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
//tomo la extension de la foto original
        $extension = strtolower(pathinfo($imagen_original, PATHINFO_EXTENSION));
// determino el nombre final de la imagen con el nombre del pokemon
        $imagen_nombre = strtolower($nombre) . "." . $extension;

        $ruta_destino = "imagenes/Pokemones" . $imagen_nombre;

        if(empty($errores)) { //si no hay errores subo la foto
            if (!move_uploaded_file($imagen_tmp, $ruta_destino)) { //si no se pudo subir la foto, muestro el error
                $errores[] = "Error: No se pudo subir el archivo.";
            }
        }

    if(empty($errores)){ //si no hay errores, hace el insert
        $insertar_pokemon = $database->execute("INSERT INTO pokemones (nombre, id_unico, tipo_id, descripcion, imagen)
                                            VALUES ('$nombre', '$id_unico', $tipo_id, '$descripcion', '$imagen_nombre')");

    }
}

?>

<div class="container mt-5">
    <div class="card shadow rounded mb-5 "style="background-color: #d2f4ea ;" >
        <?php
        if (!empty($errores)) {
            echo "<div class='alert alert-danger'>";
            foreach ($errores as $error) {
                echo "<p>$error</p>";  // Muestra cada error dentro de un párrafo
            }
            echo "</div>";
        }
        if(empty($errores) && $insertar_pokemon) {
            echo "<div class='alert alert-success''> Pokemon agregado con éxito </div> <a class='btn btn-outline-secondary' href='../inicio_logueado.php'>Todos los Pokemones</a>";
        }
         ?>
      <div class="card-header">
        <h2 class="mb-0">Agregar nuevo Pokemon</h2>
      </div>
      <div class="card-body">
        <form action="agregar_pokemon.php" method="POST" enctype="multipart/form-data">

          <!-- Nombre -->
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Pokemon</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>

            <div class="mb-3">
                <label for="id_unico" class="form-label">ID del Pokemon</label>
                <input type="text" class="form-control" id="id_unico" name="id_unico" required >
            </div>

          <!-- Tipo -->
          <div class="mb-3">
            <label class="form-label d-block">Tipo</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="tipo" id="tipoFuego" value="1" >
              <label class="form-check-label" for="tipoFuego">Fuego</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="tipo" id="tipoAgua" value="2">
              <label class="form-check-label" for="tipoAgua">Agua</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="tipo" id="tipoElectrico" value="3">
              <label class="form-check-label" for="tipoElectrico">Eléctrico</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="tipo" id="tipoPlanta" value="4">
              <label class="form-check-label" for="tipoPlanta">Planta</label>
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
          </div>

          <!-- Imagen -->
          <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del Pokemon</label>
            <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*" required>
          </div>

          <!-- Botón -->
          <button type="submit" class="btn btn-success">Agregar Pokemon</button>
        </form>
      </div>
    </div>
  </div>

<?php



require_once $_SERVER['DOCUMENT_ROOT'] . '/ProyectoPokedex/footer.php';
