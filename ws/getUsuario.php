<?php

require_once "./helpers.php";
require_once "./GestorUsuarios.php";

// 1. Conectar con la base de datos
try {
    $gestor = new GestorUsuarios();
} catch (PDOException $e) {
    sendResponse(false, "Error al conectar: " . $e->getMessage(), null);
}

try {
    // 2. Si llega un id por GET devuelvo solo ese usuario
    if (isset($_GET["id"])) {
        $id = trim($_GET["id"]);

        $usuario = $gestor->obtenerPorId($id);

        if ($usuario === null) {
            sendResponse(false, "Usuario con id $id no encontrado", null);
        }

        sendResponse(true, "Usuario obtenido correctamente", $usuario->toArray());
    }

    // 3. Si no llega id devuelvo todos
    $usuarios = $gestor->obtenerTodos();

    $datos = [];
    foreach ($usuarios as $usuario) {
        $datos[] = $usuario->toArray();
    }

    sendResponse(true, "Usuarios obtenidos correctamente", $datos);
} catch (PDOException $e) {
    sendResponse(false, "Error al obtener los usuarios: " . $e->getMessage(), null);
}
