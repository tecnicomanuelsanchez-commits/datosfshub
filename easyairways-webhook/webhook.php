<?php
// === WEBHOOK FSHub EasyAirways (versión Render con Docker) ===
// Recibe eventos de FSHub y los reenvía automáticamente a tu servidor InfinityFree

header("Content-Type: application/json");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
    echo json_encode(["error" => "JSON inválido o vacío"]);
    exit;
}

// === CONFIGURACIÓN ===
$server_url = "https://easyairways.infinityfree.me/guardar.php";

// === Reenviar a tu servidor InfinityFree ===
$ch = curl_init($server_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// === Responder a FSHub ===
echo json_encode([
    "success" => true,
    "status" => $httpcode,
    "forwarded_to" => $server_url,
    "server_response" => $response,
    "timestamp" => date('Y-m-d H:i:s')
]);
?>
