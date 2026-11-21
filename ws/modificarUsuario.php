<?php

require_once "./helpers.php";
require_once "./GestorUsuarios.php";

// 1. Recoger el id por GET y comprobar que llega
$id = trim($_GET["id"] ?? "");

if ($id === "") {
    sendResponse(false, "Falta el id", null);
}

// 2. Recoger los datos nuevos por POST
$nombre = trim($_POST["name"] ?? "");
$apellidos = trim($_POST["subname"] ?? "");
$password = trim($_POST["password"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$email = trim($_POST["email"] ?? "");
$sexo = trim($_POST["sex"] ?? "");
$fechaNacimiento = trim($_POST["fecha_nacimiento"] ?? "");

try {
    // 3. Conectar y comprobar que existe el usuario
    $gestor = new GestorUsuarios();
    $usuario = $gestor->obtenerPorId($id);

    if ($usuario === null) {
        sendResponse(false, "Usuario con id $id no encontrado", null);
    }

    // 4. Solo cambio lo que llega relleno, lo que viene vacio se queda como estaba
    if ($nombre !== "") {
        $usuario->setNombre($nombre);
    }
    if ($apellidos !== "") {
        $usuario->setApellidos($apellidos);
    }
    if ($password !== "") {
        $usuario->setPassword($password);
    }
    if ($telefono !== "") {
        $usuario->setTelefono($telefono);
    }
    if ($email !== "") {
        $usuario->setEmail($email);
    }
    if ($sexo !== "") {
        $usuario->setSexo($sexo);
    }
    if ($fechaNacimiento !== "") {
        $usuario->setFechaNacimiento($fechaNacimiento);
    }

    // 5. Guardar los cambios y devolver el usuario como ha quedado
    $usuarioModificado = $gestor->modificar($usuario);

    sendResponse(true, "Usuario modificado correctamente", $usuarioModificado->toArray());
} catch (PDOException $e) {
    sendResponse(false, "Error al modificar el usuario: " . $e->getMessage(), null);
}
