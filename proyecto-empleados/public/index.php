<?php
// public/index.php

require_once '../src/datos.php';
require_once '../src/validaciones.php';
require_once '../src/vistas.php';

$errores = [];
$mostrarResumen = false;

// Inicializamos todo vacío
$nombre = $apellidos = $dni = $email = $telefono = $fecha_alta = "";
$provincia = $sede = $departamento = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. SANITIZACIÓN (A todos los campos por seguridad, sin excepción)
    $nombre       = sanitizarInput($_POST['nombre'] ?? '');
    $apellidos    = sanitizarInput($_POST['apellidos'] ?? '');
    $dni          = sanitizarInput($_POST['dni'] ?? '');
    $email        = sanitizarInput($_POST['email'] ?? '');
    $telefono     = sanitizarInput($_POST['telefono'] ?? '');
    $fecha_alta   = sanitizarInput($_POST['fecha_alta'] ?? '');
    
    // Selects
    $provincia    = sanitizarInput($_POST['provincia'] ?? '');
    $sede         = sanitizarInput($_POST['sede'] ?? '');
    $departamento = sanitizarInput($_POST['departamento'] ?? '');

    // 2. VALIDACIONES ESPECÍFICAS (Solo DNI, Email y Fecha)

    // --- Validación DNI ---
    if (empty($dni)) {
        $errores['dni'] = "El DNI es obligatorio.";
    } elseif (!validarDni($dni)) {
        $errores['dni'] = "DNI no válido (revisa la letra).";
    }

    // --- Validación Email ---
    if (empty($email)) {
        $errores['email'] = "El correo es obligatorio.";
    } elseif (!validarEmail($email)) {
        $errores['email'] = "Formato de correo incorrecto.";
    }

    // --- Validación Fecha de Alta ---
    if (empty($fecha_alta)) {
        $errores['fecha_alta'] = "La fecha de alta es obligatoria.";
    } elseif (!validarFecha($fecha_alta)) {
        $errores['fecha_alta'] = "Fecha no válida.";
    }

    // Si el array de errores está vacío, permitimos el alta
    if (empty($errores)) {
        $mostrarResumen = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Fase IAW 1</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; padding: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-weight: bold; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        .error-msg { color: red; font-size: 0.85rem; margin-top: 3px; }
        .resumen { background: #e2e6ea; padding: 15px; border-radius: 5px; border-left: 5px solid #28a745; }
        button { background: #0056b3; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>

    <?php if ($mostrarResumen): ?>
        <div class="resumen">
            <h2>Alta Realizada</h2>
            <p><strong>Empleado:</strong> <?= $nombre ?> <?= $apellidos ?></p>
            <p><strong>DNI:</strong> <?= $dni ?> (Validado)</p>
            <p><strong>Email:</strong> <?= $email ?> (Validado)</p>
            <p><strong>Fecha de Alta:</strong> <?= $fecha_alta ?> (Validado)</p>
            <p><strong>Ubicación:</strong> <?= $sedes[$sede] ?? $sede ?> - <?= $provincias[$provincia] ?? $provincia ?></p>
            <br>
            <a href="index.php">Volver</a>
        </div>
    <?php else: ?>

        <h1>Nuevo Empleado</h1>
        <form action="index.php" method="POST">
            
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= $nombre ?>" required>
            </div>
            <div class="form-group">
                <label>Apellidos:</label>
                <input type="text" name="apellidos" value="<?= $apellidos ?>" required>
            </div>

            <div class="form-group">
                <label>DNI:</label>
                <input type="text" name="dni" value="<?= $dni ?>" placeholder="12345678L">
                <?php if (isset($errores['dni'])) echo "<div class='error-msg'>{$errores['dni']}</div>"; ?>
            </div>

            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="email" value="<?= $email ?>">
                <?php if (isset($errores['email'])) echo "<div class='error-msg'>{$errores['email']}</div>"; ?>
            </div>

            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?= $telefono ?>">
            </div>

            <div class="form-group">
                <label>Fecha de Alta:</label>
                <input type="date" name="fecha_alta" value="<?= $fecha_alta ?>">
                <?php if (isset($errores['fecha_alta'])) echo "<div class='error-msg'>{$errores['fecha_alta']}</div>"; ?>
            </div>

            <div class="form-group">
                <label>Provincia:</label>
                <?= pintarSelect('provincia', $provincias, $provincia) ?>
            </div>
            <div class="form-group">
                <label>Sede:</label>
                <?= pintarSelect('sede', $sedes, $sede) ?>
            </div>
            <div class="form-group">
                <label>Departamento:</label>
                <?= pintarSelect('departamento', $departamentos, $departamento) ?>
            </div>

            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

</body>
</html>