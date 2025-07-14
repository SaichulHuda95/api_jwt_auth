<?php
require_once "../config/init.php";
require_once "../jwt/validate.php";

use \Firebase\JWT\JWT;

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (!$authHeader || strpos($authHeader, 'Bearer ') !== 0) {
    http_response_code(401);
    echo json_encode(["message" => "Token tidak ditemukan"]);
    exit;
}

$jwt = str_replace('Bearer ', '', $authHeader);

try {
    $decoded = JWT::decode($jwt, $secretKey, ['HS256']);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["message" => "Token tidak valid", "error" => $e->getMessage()]);
    exit;
}
