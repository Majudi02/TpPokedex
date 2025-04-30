<?php
require_once 'header.php';
require_once 'encontrar_pokemon.php';

?>
    <main class="flex-grow-1">
        <!-- Formulario de búsqueda -->
        <div class="container d-flex justify-content-center mt-5">
            <form class="d-flex" style="width: 100%; max-width: 900px;" action="inicio_logeado.php" method="post">
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
                    echo "<td><img src='./Imagenes/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></td>";
                    $tipo = getTipoById($pokemon['tipo_id'], $db);
                    echo "<td><img src='./Imagenes/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
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
                    echo "<td><img src='images/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></td>";
                    $tipo = getTipoById($pokemon['tipo_id'], $db);
                    echo "<td><img src='images/tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
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
            <a href='agregar_pokemon.php' class='btn btn-outline-secondary w-100'>Nuevo Pokemon</a>
        </div>
    </main>



<?php
include 'footer.php';