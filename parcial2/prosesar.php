<?php

$nombre = $_REQUEST['nombre'];
$correo = $_REQUEST['correo_electronico'];
$pedidos = $_REQUEST['salteñas'];

//la carta
$carata = [
    'Salteña de Pollo 6 Bs.',
    'Docena de salteñas 65 Bs.',
    'Refresco de  moconchinchi 4 Bs.'
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido recibido - Salteñeria El Horno</title>
</head>

<body>
    <h1>Pedido recibido en Salteneria El Horno</h1>
    <h2>Datos del cliente:</h2>
    <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
    <p><strong>Correo electrónico:</strong> <?php echo $correo; ?></p>
    <p><strong>Pedido:</strong> <?php echo $pedidos; ?></p>
    <h2>Nuestra Carta:</h2>
    <ul>
        <?php
        foreach ($carta as $saltena) {
            echo "<li>$saltena</li>";
        }
        ?>
    </ul>
    <p>Te atiende Yerson Jarandilla Vicente.</p>
</body>

</html>