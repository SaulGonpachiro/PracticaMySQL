<?php

require_once "./helpers.php";
require_once "./GestorUsuarios.php";

// 1. Recoger el id por GET y comprobar que llega
$id = trim($_GET["id"] ?? "");

if ($id === "") {
    sendResponse(false, "Falta el id", null);
}

// 2. Conectar con la base de datos
try {
    $gestor = new GestorUsuarios();
} catch (PDOException $e) {
    sendResponse(false, "Error al conectar: " . $e->getMessage(), null);
}

try {
    // 3. Buscar el usuario antes de borrarlo, para poder devolver sus datos
    $usuario = $gestor->obtenerPorId($id);

    if ($usuario === null) {
        sendResponse(false, "Usuario con id $id no encontrado", null);
    }

    // 4. Borrarlo y devolver lo que se ha borrado
    $gestor->borrar($id);

    sendResponse(true, "Usuario eliminado correctamente", $usuario->toArray());
} catch (PDOException $e) {
    sendResponse(false, "Error al eliminar el usuario: " . $e->getMessage(), null);
}
