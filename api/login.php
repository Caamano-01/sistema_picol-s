<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

require "config.php";

$dados = json_decode(file_get_contents("php://input"), true);

if (!isset($dados["username"]) || !isset($dados["senha"])) {
    http_response_code(400);
    echo json_encode(["erro" => "Usuário ou senha não informados"]);
    exit;
}

$username = $dados["username"];
$senha = $dados["senha"];

$stmt = $pdo->prepare("SELECT id, username, senha, perfil FROM usuario WHERE username = ?");
$stmt->execute([$username]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    http_response_code(401);
    echo json_encode(["erro" => "Usuário ou senha inválidos"]);
    exit;
}

if ($senha !== $usuario["senha"]) {
    http_response_code(401);
    echo json_encode(["erro" => "Usuário ou senha inválidos"]);
    exit;
}

echo json_encode([
    "sucesso" => true,
    "perfil" => $usuario["perfil"]
]);