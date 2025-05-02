<?php

include 'header.php';
require_once 'database.php';


// Verificar si 'id_unico' está en la URL
$id_unico = isset($_GET['id_unico']) ? $_GET['id_unico'] : null;
$database = new MyDatabase();
if ($id_unico) {
    // Hacer la consulta para obtener los datos del Pokémon específico
    $pokemonDatos = $database->query(
        "SELECT p.nombre, p.id_unico, p.imagen, p.descripcion, t.tipo, t.imagen AS tipo_imagen
         FROM pokemones p
         JOIN tipo t ON p.tipo_id = t.id
         WHERE p.id_unico = '$id_unico'"
    );

    if (count($pokemonDatos) > 0) {
        $pokemon = $pokemonDatos[0]; // Tomar el primer (y único) resultado
    } else {
        echo "Pokémon no encontrado.";
        exit();
    }

    // Asignar clase de color según el tipo
    $colorClase = '';
    switch ($pokemon["tipo"]) {
        case 'FUEGO':
            $colorClase = 'color-fuego';
            break;
        case 'PLANTA':
            $colorClase = 'color-planta';
            break;
        case 'ELECTRICO':
            $colorClase = 'color-electrico';
            break;
        case 'AGUA':
            $colorClase = 'color-agua';
            break;
    }

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Pokédex - <?= htmlspecialchars($pokemon['nombre']); ?></title>
        <link rel="stylesheet" href="estilos/style-vistaPokemon.css">
    </head>
    <body>
    <div class="container">
        <div class="pokemon-container">
            <img src="imagenes/<?= htmlspecialchars($pokemon['imagen']); ?>" alt="<?= htmlspecialchars($pokemon['nombre']); ?>" class="pokemon-image">

            <div class="pokemon-card">
                <div class="pokemon-details">
                    <div class="pokemon-name <?= $colorClase; ?>"><?= htmlspecialchars($pokemon['nombre']); ?> <span class="pokemon-id">(<?= htmlspecialchars($pokemon['id_unico']); ?>)</span></div>
                </div>

                <div class="tipo">
                    <img src="imagenes/<?= htmlspecialchars($pokemon['tipo_imagen']); ?>" alt="<?= htmlspecialchars($pokemon['tipo']); ?>" width="50">
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($pokemon['tipo']); ?></p>
                </div>

                <!-- Descripción del Pokémon -->
                <div class="pokemon-description">
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($pokemon['descripcion']); ?></p>
                </div>
                <div class="contenedor_btn">
                    <button class="btn btn-warning botonform me-6" onclick="regresar()" id="cancelar-boton-login">
                        <a href="pagina_principal.php">← Volver a la Pokédex</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} else {
    // Si no hay 'id_unico', no hacer consulta y mostrar la lista de Pokémon
    $pokemones = $database->query(
        "SELECT p.nombre, p.id_unico, p.imagen
         FROM pokemones p"
    );

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Pokédex</title>
        <link rel="stylesheet" href="estilos/style-pokedex.css">
    </head>
    <body>
    <div class="container">
        <div class="pokedex-lista">
            <h2>Pokédex</h2>
            <ul>
                <?php foreach ($pokemones as $pokemon) { ?>
                    <li>
                        <a href="vistaPokemon.php?id_unico=<?= htmlspecialchars($pokemon['id_unico']); ?>">
                            <img src="imagenes/<?= htmlspecialchars($pokemon['imagen']); ?>" alt="<?= htmlspecialchars($pokemon['nombre']); ?>" width="50">
                            <?= htmlspecialchars($pokemon['nombre']); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    </body>
    </html>
    <?php
}
?>
<?php include 'footer.php'; ?>