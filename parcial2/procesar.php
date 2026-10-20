<?php

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$pedido = $_POST['pedido'];

$carta = [
    'Saltena de pollo - Bs 6',
    'Docena de saltenas - Bs 65',
    'Refresco de mocochinchi - Bs 5'
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido recibido - Salteneria El Horno</title>
</head>

<body>
    <h1>Pedido recibido en Salteneria El Horno</h1>
    <p><?php echo $nombre; ?></p>
    <p><?php echo $correo; ?></p>
    <p><?php echo $pedido; ?></p>
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