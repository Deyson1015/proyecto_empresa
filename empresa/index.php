<?php

require_once 'Usuario.php';

$usuario = new Usuario();

// Aquí puedes probar:
// $usuario->crearUsuario("Ana", "ana@mail.com", 22);
// print_r($usuario->listarUsuarios());



echo "<pre>";
$usuario->listarUsuarios();
echo "</pre>";




