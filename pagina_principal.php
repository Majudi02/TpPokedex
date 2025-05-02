<?php
session_start();

include 'header.php';
include 'encontrar_pokemon.php';
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

    <main class="flex-grow-1">

        <div class="container d-flex justify-content-center mt-5">
            <form class="d-flex" style="width: 100%; max-width: 900px;" action="pagina_principal.php" method="post">
                <div class="input-group">
                    <input class="form-control rounded-start-pill" type="text" name="pokemonBuscado"
                           placeholder="Ingrese el nombre, tipo o número de pokémon">
                    <button class="btn text-white rounded-end-pill" type="submit" style="background-color: #20c997;">
                        ¿Quién es este Pokémon?
                    </button>
                </div>
            </form>
        </div>

        <div class="container mt-5 pb-5">
            <?php
            require_once 'MyDatabase.php';
            $db = new MyDatabase();
            $resultadoBusqueda = encontrarPokemon($db);

            function getTipoById($tipo_id, $db)
            {
                $resultado = $db->query("SELECT imagen FROM tipo WHERE id = $tipo_id");
                return $resultado ? $resultado[0]['imagen'] : 'default.png';
            }

            if (isset($_POST["pokemonBuscado"]) && $resultadoBusqueda === false) {
                echo "<div class='text-danger'><h4>¡Pokémon no encontrado!</h4></div>";
            }

            // Si es una lista de pokemones
            if (is_array($resultadoBusqueda) && isset($resultadoBusqueda[0])) {
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Número</th><th>Nombre</th><th>Imagen</th><th>Tipo</th></tr></thead><tbody>";

                foreach ($resultadoBusqueda as $pokemon) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($pokemon['id']) . "</td>";
                    echo "<td><a href='vistaPokemon.php?id_unico=" . urlencode($pokemon['id_unico']) . "'>" . htmlspecialchars($pokemon['nombre']) . "</a></td>";
                    echo "<td><a href='vistaPokemon.php?id_unico=" . urlencode($pokemon['id_unico']) . "'><img src='Imagenes/Pokemones/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></a></td>";
                    $tipo = getTipoById($pokemon['tipo_id'], $db);
                    echo "<td><img src='Imagenes/Tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            }

            // Si es un solo pokemon
            elseif (is_array($resultadoBusqueda) && isset($resultadoBusqueda['id'])) {
                echo "<h4 class='text-success'>Pokémon Encontrado</h4>";
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Número</th><th>Nombre</th><th>Imagen</th><th>Tipo</th></tr></thead><tbody><tr>";
                echo "<td>" . htmlspecialchars($resultadoBusqueda['id']) . "</td>";
                echo "<td><a href='vistaPokemon.php?id_unico=" . urlencode($resultadoBusqueda['id_unico']) . "'>" . htmlspecialchars($resultadoBusqueda['nombre']) . "</a></td>";
                echo "<td><a href='vistaPokemon.php?id_unico=" . urlencode($resultadoBusqueda['id_unico']) . "'><img src='Imagenes/Pokemones/" . htmlspecialchars($resultadoBusqueda['imagen']) . "' alt='" . htmlspecialchars($resultadoBusqueda['nombre']) . "' width='50'></a></td>";
                $tipo = getTipoById($resultadoBusqueda['tipo_id'], $db);
                echo "<td><img src='Imagenes/Tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($resultadoBusqueda['tipo_id']) . "' width='50'></td>";
                echo "</tr></tbody></table>";
            }

            // Mostrar todos por defecto o si no se encontró ninguno
            if (!isset($_POST["pokemonBuscado"]) || $resultadoBusqueda === false) {
                $pokemones = $db->query("SELECT * FROM pokemones");
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Número</th><th>Nombre</th><th>Imagen</th><th>Tipo</th></tr></thead><tbody>";

                foreach ($pokemones as $pokemon) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($pokemon['id']) . "</td>";
                    echo "<td><a href='vistaPokemon.php?id_unico=" . urlencode($pokemon['id_unico']) . "'>" . htmlspecialchars($pokemon['nombre']) . "</a></td>";
                    echo "<td><a href='vistaPokemon.php?id_unico=" . urlencode($pokemon['id_unico']) . "'><img src='Imagenes/Pokemones/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></a></td>";
                    $tipo = getTipoById($pokemon['tipo_id'], $db);
                    echo "<td><img src='Imagenes/Tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            }
            ?>
        </div>
    </main>

<?php include 'footer.php'; ?>