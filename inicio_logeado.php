<?php
require_once 'header.php';
require_once 'encontrar_pokemon.php';

 $database = new MyDatabase();
 $listaDb = $database->query("SELECT * FROM pokemones");
$tiposDb = $database->query("Select * from tipo");

function getTipoById($tipo_id) {
    $db = new MyDatabase();

    $resultado = $db->query("SELECT imagen FROM tipo WHERE id = $tipo_id");

    return $resultado ? $resultado[0]['imagen'] : 'default.png'; // Si no se encuentra, retorna una imagen por defecto
}

?>
    <main class="flex-grow-1">


        <div class="container d-flex justify-content-center mt-5">
            <form class="d-flex" style="width: 100%; max-width: 900px;" method="post" action="pagina_principal.php"">
            <div class="input-group" >
                <input class="form-control rounded-start-pill" type="text" name="nombrePokemon"
                       placeholder="Ingrese el nombre, tipo o número de pokémon">
                <button class="btn text-white rounded-end-pill" type="submit" style="background-color: #20c997;">
                    ¿Quién es este Pokémon?
                </button>
            </div>
            </form>
        </div>

        <div>
            <?php
            encontrarPokemon($listaDb);
            ?>
        </div>

        <div class="container mt-5 pb-5">

            <table class='table table-bordered'>
                <thead>
                <tr>
                    <th>Numero</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($listaDb)) {
                    foreach ($listaDb as $pokemon) {
                        echo "<tr>";
                        echo "<td>". htmlspecialchars($pokemon['id']) . "</td>";
                        echo "<td>" . $pokemon["nombre"] . "</td>";
                        echo "<td><img src='" . $pokemon["imagen"] . "' alt='" . $pokemon["nombre"] . "'></td>";  // Imagen
                        $tipo = getTipoById($pokemon['tipo_id']);
                        echo "<td><img src='images/tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                        echo "<td >
                        <a href='./administrar_pokemones/modificar_pokemon.php?id={$pokemon['id']}' class='btn btn-outline-secondary '>Modificar</a>
                        <a href='./administrar_pokemones/eliminar_pokemon.php?id={$pokemon['id']}' class='btn btn-outline-secondary'>Eliminar</a>
                        </td>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron Pokémon.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="container d-flex justify-content-center mb-5 ">
        <a href='agregar_pokemon.php' class='btn btn-outline-secondary w-100'>Nuevo Pokemon</a>
        </div>
    </main>



<?php
include 'footer.php';