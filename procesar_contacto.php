<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$nombre  = isset($_POST['nombre'])  ? htmlspecialchars(trim($_POST['nombre']),  ENT_QUOTES, 'UTF-8') : '';
$email   = isset($_POST['email'])   ? htmlspecialchars(trim($_POST['email']),   ENT_QUOTES, 'UTF-8') : '';
$titulo  = isset($_POST['titulo'])  ? htmlspecialchars(trim($_POST['titulo']),  ENT_QUOTES, 'UTF-8') : '';
$mensaje = isset($_POST['mensaje']) ? htmlspecialchars(trim($_POST['mensaje']), ENT_QUOTES, 'UTF-8') : '';

$fecha = date('d/m/Y H:i:s');

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>Mensaje Recibido — POS Tec</title>';
echo '</head>';
echo '<body>';

echo '<h1>Mensaje Recibido</h1>';
echo '<hr>';

echo '<p><strong>Nombre:</strong> ' . $nombre . '</p>';
echo '<p><strong>Correo:</strong> ' . $email . '</p>';
echo '<p><strong>Asunto:</strong> ' . $titulo . '</p>';
echo '<p><strong>Mensaje:</strong> ' . nl2br($mensaje) . '</p>';

echo '<hr>';
echo '<p><em>Recibido el ' . $fecha . '</em></p>';

echo '<br>';
echo '<button onclick="window.print();">Imprimir</button>';
echo ' ';
echo '<a href="index.html#contacto">Volver al formulario</a>';

echo '</body>';
echo '</html>';
?>
