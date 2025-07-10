<?php
require_once '../jwt/JWT.php';
require_once '../config/key.php';

use \Firebase\JWT\JWT;

// Simulasi login sederhana
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === 'admin' && md5($password) === '2fc24a43533f51de9a31ad05388d75aa') { //password = Saichul.95
    $payload = [
        "iss" => "http://localhost",
        "aud" => "http://localhost",
        "iat" => time(),
        "exp" => time() + (60 * 60), // 1 jam
        "data" => [
            "username" => $username
        ]
    ];

    $jwt = JWT::encode($payload, $secretKey);
    $response = [
        'response_code' => '00',
        'response_message' => 'success',
        'token' => $jwt
    ];
    echo json_encode($response);
} else {
    http_response_code(401);
    echo json_encode(["message" => "Login gagal"]);
}
