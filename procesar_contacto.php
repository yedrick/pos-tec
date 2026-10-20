<?php
// ============================================================================
// procesar_contacto.php — Procesa el formulario de contacto de POS Tec
// Recibe los datos vía POST, los valida y los muestra para imprimir.
// ============================================================================

// Solo aceptar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

// Recibir y sanitizar los datos del formulario
$nombre  = isset($_POST['nombre'])  ? htmlspecialchars(trim($_POST['nombre']),  ENT_QUOTES, 'UTF-8') : '';
$email   = isset($_POST['email'])   ? htmlspecialchars(trim($_POST['email']),   ENT_QUOTES, 'UTF-8') : '';
$titulo  = isset($_POST['titulo'])  ? htmlspecialchars(trim($_POST['titulo']),  ENT_QUOTES, 'UTF-8') : '';
$mensaje = isset($_POST['mensaje']) ? htmlspecialchars(trim($_POST['mensaje']), ENT_QUOTES, 'UTF-8') : '';

// Validación del lado del servidor
$errores = [];

if ($nombre === '') {
    $errores[] = 'El campo "Nombre" es obligatorio.';
} elseif (strlen($nombre) < 3) {
    $errores[] = 'El "Nombre" debe tener al menos 3 caracteres.';
}

if ($email === '') {
    $errores[] = 'El campo "Correo electrónico" es obligatorio.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El "Correo electrónico" no tiene un formato válido.';
}

if ($titulo === '') {
    $errores[] = 'El campo "Título o Asunto" es obligatorio.';
} elseif (strlen($titulo) < 3) {
    $errores[] = 'El "Título o Asunto" debe tener al menos 3 caracteres.';
}

if ($mensaje === '') {
    $errores[] = 'El campo "Mensaje" es obligatorio.';
} elseif (strlen($mensaje) < 10) {
    $errores[] = 'El "Mensaje" debe contener al menos 10 caracteres.';
}

$hayErrores = count($errores) > 0;

// Fecha y hora de recepción
$fechaRecepcion = date('d/m/Y \a \l\a\s H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hayErrores ? 'Error en el formulario' : 'Mensaje Recibido'; ?> — POS Tec</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ===== Reset y base ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #1a1a3e 40%, #24243e 100%);
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ===== Contenedor principal ===== */
        .contenedor {
            width: 100%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            padding: 2.5rem 2.5rem 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: aparecer 0.6s ease-out;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== Encabezado ===== */
        .encabezado {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .encabezado .icono {
            font-size: 3rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .encabezado h1 {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6ee7b7, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.3rem;
        }

        .encabezado .subtitulo {
            font-size: 0.9rem;
            color: #9ca3af;
        }

        /* ===== Tabla de datos ===== */
        .tabla-datos {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tabla-datos tr {
            transition: background 0.2s ease;
        }

        .tabla-datos tr:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        .tabla-datos tr:not(:last-child) td,
        .tabla-datos tr:not(:last-child) th {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tabla-datos th {
            text-align: left;
            width: 180px;
            padding: 1rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #93c5fd;
            background: rgba(59, 130, 246, 0.08);
            vertical-align: top;
        }

        .tabla-datos td {
            padding: 1rem 1.2rem;
            font-size: 0.95rem;
            color: #e5e7eb;
            line-height: 1.6;
            word-break: break-word;
        }

        .tabla-datos .etiqueta-icono {
            margin-right: 0.4rem;
        }

        /* ===== Pie de datos ===== */
        .info-fecha {
            text-align: center;
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            padding: 0.6rem 1rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
        }

        /* ===== Botones ===== */
        .acciones {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.8rem;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-imprimir {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.35);
        }

        .btn-imprimir:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(59, 130, 246, 0.5);
        }

        .btn-volver {
            background: rgba(255, 255, 255, 0.08);
            color: #d1d5db;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-volver:hover {
            background: rgba(255, 255, 255, 0.14);
            transform: translateY(-2px);
        }

        /* ===== Errores ===== */
        .error-container {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .error-container h2 {
            color: #fca5a5;
            font-size: 1rem;
            margin-bottom: 0.8rem;
        }

        .error-container ul {
            list-style: none;
            padding: 0;
        }

        .error-container li {
            padding: 0.35rem 0;
            color: #fecaca;
            font-size: 0.9rem;
        }

        .error-container li::before {
            content: '⚠️ ';
        }

        /* ===== Estilos de impresión ===== */
        @media print {
            body {
                background: #fff !important;
                color: #1a1a1a !important;
                padding: 0 !important;
            }

            .contenedor {
                background: #fff !important;
                border: 2px solid #333 !important;
                box-shadow: none !important;
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
                max-width: 100% !important;
                padding: 2rem !important;
                border-radius: 0 !important;
            }

            .encabezado h1 {
                background: none !important;
                -webkit-text-fill-color: #1a1a1a !important;
                color: #1a1a1a !important;
            }

            .encabezado .subtitulo {
                color: #555 !important;
            }

            .tabla-datos th {
                background: #f3f4f6 !important;
                color: #1e40af !important;
            }

            .tabla-datos td {
                color: #1a1a1a !important;
            }

            .tabla-datos tr:not(:last-child) td,
            .tabla-datos tr:not(:last-child) th {
                border-bottom: 1px solid #d1d5db !important;
            }

            .tabla-datos {
                border: 1px solid #d1d5db !important;
            }

            .info-fecha {
                color: #374151 !important;
                background: #f9fafb !important;
            }

            /* Ocultar botones al imprimir */
            .acciones {
                display: none !important;
            }

            .no-imprimir {
                display: none !important;
            }
        }

        /* ===== Responsive ===== */
        @media (max-width: 600px) {
            .contenedor { padding: 1.5rem 1.2rem 1.2rem; }
            .tabla-datos th { width: 130px; padding: 0.8rem; font-size: 0.78rem; }
            .tabla-datos td { padding: 0.8rem; font-size: 0.88rem; }
            .acciones { flex-direction: column; }
            .btn { justify-content: center; width: 100%; }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <?php if ($hayErrores): ?>
            <!-- ===== VISTA DE ERRORES ===== -->
            <div class="encabezado">
                <span class="icono">❌</span>
                <h1>Error en el envío</h1>
                <p class="subtitulo">No se pudo procesar tu mensaje. Corrige los errores e intenta nuevamente.</p>
            </div>

            <div class="error-container">
                <h2>Se encontraron los siguientes problemas:</h2>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="acciones">
                <a href="index.html#contacto" class="btn btn-volver">
                    ⬅️ Volver al formulario
                </a>
            </div>

        <?php else: ?>
            <!-- ===== VISTA DE ÉXITO CON DATOS ===== -->
            <div class="encabezado">
                <span class="icono">✅</span>
                <h1>Mensaje Recibido Exitosamente</h1>
                <p class="subtitulo">POS Tec — Formulario de Contacto</p>
            </div>

            <table class="tabla-datos">
                <tr>
                    <th><span class="etiqueta-icono">👤</span> Nombre</th>
                    <td><?php echo $nombre; ?></td>
                </tr>
                <tr>
                    <th><span class="etiqueta-icono">📧</span> Correo</th>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <th><span class="etiqueta-icono">📋</span> Asunto</th>
                    <td><?php echo $titulo; ?></td>
                </tr>
                <tr>
                    <th><span class="etiqueta-icono">💬</span> Mensaje</th>
                    <td><?php echo nl2br($mensaje); ?></td>
                </tr>
            </table>

            <div class="info-fecha">
                🕐 Recibido el <strong><?php echo $fechaRecepcion; ?></strong>
            </div>

            <div class="acciones">
                <button type="button" class="btn btn-imprimir" onclick="window.print();">
                    🖨️ Imprimir
                </button>
                <a href="index.html#contacto" class="btn btn-volver">
                    ⬅️ Volver al formulario
                </a>
            </div>

        <?php endif; ?>
    </div>
</body>
</html>
