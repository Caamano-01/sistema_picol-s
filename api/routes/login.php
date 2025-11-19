<?php
/**
 * ARQUIVO: login.php
 * DESCRIÇÃO: Endpoint para autenticação de usuário.
 * Retorna o perfil (admin ou vendedor) em caso de sucesso.
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $username = $dados["username"] ?? '';
    $senha = $dados["senha"] ?? '';

    if (empty($username) || empty($senha)) {
        http_response_code(400);
        echo json_encode(["erro" => "Nome de usuário e senha são obrigatórios."]);
        exit;
    }

    try {
        // Busca o usuário pelo username
        $stmt = $pdo->prepare("SELECT id, username, senha, perfil FROM usuario WHERE username = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario["senha"])) {
            // Login bem-sucedido
            echo json_encode([
                "sucesso" => true,
                "perfil" => $usuario["perfil"],
                "mensagem" => "Login efetuado com sucesso."
            ]);
        } else {
            // Credenciais inválidas
            http_response_code(401); // Unauthorized
            echo json_encode(["erro" => "Nome de usuário ou senha inválidos."]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro no servidor: " . $e->getMessage()]);
    }

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["erro" => "Método não permitido."]);
}
?>