<?php

function cambiarFormato($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//eSCAPA / sanitizar EL HTML , PARA EVITAR DATOS MALICIOSS

function sani($html) : string{
    $sani = htmlspecialchars($html);
    return $sani;
}
