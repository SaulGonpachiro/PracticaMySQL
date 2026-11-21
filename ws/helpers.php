<?php

// devuelve la respuesta en JSON con el formato que pide el enunciado y para
function sendResponse($success, $message, $data)
{
    header("Content-Type: application/json");
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    die;
}
