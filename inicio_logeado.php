<?php
include 'header.php';
include 'encontrar_pokemon.php';
include_once 'MyDatabase.php';

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
            encontrarPokemon();
            ?>
        </div>

        <div>
            <style>
                table {
                    width: 80%;
                    max-width: 900px;
                    margin: 0 auto;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                    margin-top: 20px;
                    overflow-x: auto;

                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 8px 12px;
                    text-align: left;
                }
                td img {
                    width: 50px;
                    height: 50px;
                    object-fit: cover;
                }
                td button {
                    margin-right: 5px;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }

                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
            </style>

            <table>
                <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($listaDb)) {
                    foreach ($listaDb as $pokemon) {
                        echo "<tr>";
                        echo "<td><img src='" . $pokemon["imagen"] . "' alt='" . $pokemon["nombre"] . "'></td>";  // Imagen
                        $tipo = getTipoById($pokemon['tipo_id']);
                        echo "<td><img src='images/tipos/" . htmlspecialchars($tipo) . "' alt='Tipo " . htmlspecialchars($pokemon['tipo_id']) . "' width='50'></td>";
                        echo "<td>" . $pokemon["nombre"] . "</td>";
                        echo "<td>
                          
                            <button class='btn btn-outline-secondary'>Modificar</button>
                            <button class='btn btn-outline-secondary'>Baja</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron Pokémon.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </main>



<?php
include 'footer.php';