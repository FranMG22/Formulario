<?php
function sanitizarInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validarDni($dni) {
    if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) {
        return false;
    }
    return true;

}

function validarEmail($email) {
    $email = trim($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validarFecha($fecha) {
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    return $d && $d->format('Y-m-d') === $fecha;
}
?>