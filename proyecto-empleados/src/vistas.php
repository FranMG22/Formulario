<?php
// src/vistas.php

/**
 * Genera un <select> dinámico basado en un array
 */
function pintarSelect($nombre, $opciones, $seleccionado = '') {
    $html = "<select name='$nombre' id='$nombre' class='form-control'>";
    $html .= "<option value=''>-- Seleccione --</option>";
    
    foreach ($opciones as $clave => $valor) {
        $selectedAttr = ($clave == $seleccionado) ? 'selected' : '';
        $html .= "<option value='$clave' $selectedAttr>$valor</option>";
    }
    
    $html .= "</select>";
    return $html;
}

/**
 * Muestra un error si existe para un campo
 */
function mostrarError($errores, $campo) {
    if (isset($errores[$campo])) {
        return "<div class='error-msg' style='color:red; font-size:0.9em;'>{$errores[$campo]}</div>";
    }
    return "";
}
?>