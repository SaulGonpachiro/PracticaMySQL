<?php

require_once "./helpers.php";
require_once "./GestorUsuarios.php";

// 1. Recoger los datos del formulario por POST (con los name del formulario de la practica anterior)
$nombre = trim($_POST["name"] ?? "");
$apellidos = trim($_POST["subname"] ?? "");
$password = trim($_POST["password"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$email = trim($_POST["email"] ?? "");
$sexo = trim($_POST["sex"] ?? "");
$fechaNacimiento = trim($_POST["fecha_nacimiento"] ?? "");

// 1.1 Comprobar los obligatorios (los que en la tabla no pueden ser null)
if ($nombre === "" || $apellidos === "" || $password === "" || $fechaNacimiento === "") {
    sendResponse(false, "Faltan datos obligatorios: name, subname, password y fecha_nacimiento", null);
}

// 2. Crear la instancia de User, los opcionales vacios se guardan como null
$usuario = new User(
    null,
    $nombre,
    $apellidos,
    $password,
    $telefono === "" ? null : $telefono,
    $email === "" ? null : $email,
    $sexo === "" ? null : $sexo,
    $fechaNacimiento
);

// 3. Conectar y guardarlo en la base de datos
try {
    $gestor = new GestorUsuarios();
    $usuarioCreado = $gestor->crear($usuario);

    sendResponse(true, "Usuario creado correctamente", $usuarioCreado->toArray());
} catch (PDOException $e) {
    sendResponse(false, "Error al crear el usuario: " . $e->getMessage(), null);
}
