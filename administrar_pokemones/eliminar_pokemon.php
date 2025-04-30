<?php
require_once ('../MyDatabase.php');
$database = new MyDatabase();

$id=$_GET['id'];
$pokemon = $database->query("SELECT * FROM pokemones WHERE id=".$id);

    if(!empty($pokemon)){

        $rutaImagen = "../imagenes/" . $pokemon[0]['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
        $eliminar_pokemon= $database->execute("DELETE FROM pokemones WHERE id=".$id);

}
header("Location: ../inicio_logeado.php");
exit();