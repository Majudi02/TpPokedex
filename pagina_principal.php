<?php
include 'header.php';
include 'encontrar_pokemon.php';
?>

    <main class="flex-grow-1">

        <div class="container d-flex justify-content-center mt-5">
            <form class="d-flex" style="width: 100%; max-width: 900px;" action="pagina_principal.php" method="post">
                <div class="input-group" >
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

                function getTipoById($tipo_id, $db) {
                    $resultado = $db->query("SELECT imagen FROM tipo WHERE id = $tipo_id");
                    return $resultado ? $resultado[0]['imagen'] : 'default.png';
                }

                if ($resultadoBusqueda === false){
                    echo "<div class='text-danger'>
                               <h4>Pokemon no encontrado!</h4>
                          </div>";
                }

                //si es una lista de pokmones
                if (is_array($resultadoBusqueda) && isset($resultadoBusqueda[0])){
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>Numero</th><th>Nombre</th><th>Imagen</th><th>Tipo</th></tr></thead>";

                    foreach ($resultadoBusqueda as $pokemon){
                        echo "<tbody><tr>";
                        echo "<td>". htmlspecialchars($pokemon['id']) . "</td>";
                        echo "<td>".htmlspecialchars($pokemon['nombre'])."</td>";
                        echo "<td><img src='./Imagenes/". htmlspecialchars($pokemon['imagen']) ."' alt='".htmlspecialchars($pokemon['nombre']) ."'  width='50'> </td>";
                        $tipo= getTipoById($pokemon['tipo_id'], $db);
                        echo "<td><img src='./Imagenes/". htmlspecialchars($tipo) ."' alt='Tipo ".htmlspecialchars($pokemon['tipo_id']) ."'  width='50'></td>";
                        echo "</tr>";

                    }
                    echo "</tbody></table>";
                }

                //si es un solo pokemon
                elseif (is_array($resultadoBusqueda) && isset($resultadoBusqueda['id'])){
                    echo "<h4 class='text-success'>Pokemon Encontrado</h4>";
                    echo "<table class='table table-bordered'>";

                    echo "<thead><tr><th>Numero</th><th>Nombre</th><th>Imagen</th><th>Tipo</th></tr></thead>";
                    echo "<tbody><tr>";
                    echo "<td>". htmlspecialchars($resultadoBusqueda['id']) . "</td>";
                    echo "<td>". htmlspecialchars($resultadoBusqueda['nombre']) . "</td>";
                    echo "<td><img src='./Imagenes/". htmlspecialchars($resultadoBusqueda['imagen']) ."' alt='".htmlspecialchars($resultadoBusqueda['nombre']) ."'  width='50'> </td>";
                    $tipo= getTipoById($resultadoBusqueda['tipo_id'], $db);
                    echo "<td><img src='./Imagenes/". htmlspecialchars($tipo) ."' alt='Tipo ".htmlspecialchars($resultadoBusqueda['tipo_id']) ."'  width='50'></td>";
                    echo "</tr></tbody></table>";
                }


                //muestra tdo por defecto o cuando hay una busqueda no encontrada

                if (!isset($_POST["pokemonBuscado"]) || $resultadoBusqueda === false) {

                    $pokemones = $db->query("SELECT * FROM pokemones");

                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>Numero</th><th>Nombre</th><th>Imagen</th><th>Tipo</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($pokemones as $pokemon){
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($pokemon['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($pokemon['nombre']) . "</td>";
                        echo "<td><img src='images/" . htmlspecialchars($pokemon['imagen']) . "' alt='" . htmlspecialchars($pokemon['nombre']) . "' width='50'></td>";
                        $tipo = getTipoById($pokemon['tipo_id'], $db);
                        echo "<td><img src='images/tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table>";
                }
                ?>

        </div>
    
    </main>


<?php
include 'footer.php';
