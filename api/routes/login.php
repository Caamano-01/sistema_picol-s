<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

require "../config.php";

$dados = json_decode(file_get_contents("php://input"), true);

// Verifica se os campos existem no JSON recebido
if (!isset($dados["username"]) || !isset($dados["senha"])) {
    http_response_code(400);
    echo json_encode(["erro" => "Usuário ou senha não informados"]);
    exit;
}

// ATENÇÃO: As variáveis corretas são extraídas do array $dados
$username_input = $dados["username"];
$senha_input = $dados["senha"];

$stmt = $pdo->prepare("SELECT id, username, senha, perfil FROM usuario WHERE username = ?");
// Executa usando a variável correta
$stmt->execute([$username_input]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Compara a senha de entrada ($senha_input) com a senha do banco ($usuario["senha"])
if (!$usuario || $senha_input !== $usuario["senha"]) {
    http_response_code(401);
    echo json_encode(["erro" => "Usuário ou senha inválidos"]);
    exit;
}

echo json_encode([
    "sucesso" => true,
    "perfil" => $usuario["perfil"]
]);
exit;
?>