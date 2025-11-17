<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

// Lê o JSON vindo do fetch()
$dados = json_decode(file_get_contents("php://input"), true);

// Validação simples
if (
    !isset($dados["nome"]) ||
    !isset($dados["tipo"]) ||
    !isset($dados["id_sabor"]) ||
    !isset($dados["id_embalagem"])
) {
    http_response_code(400);
    echo json_encode(["erro" => "Dados incompletos"]);
    exit;
}

try {
    $sql = "INSERT INTO picole (nome, tipo, id_sabor, id_embalagem)
            VALUES (:nome, :tipo, :id_sabor, :id_embalagem)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":nome"        => $dados["nome"],
        ":tipo"        => $dados["tipo"],
        ":id_sabor"    => $dados["id_sabor"],
        ":id_embalagem"=> $dados["id_embalagem"]
    ]);

    echo json_encode([
        "sucesso" => true,
        "id"      => $pdo->lastInsertId()
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "erro" => "Erro ao cadastrar picolé",
        "detalhes" => $e->getMessage()
    ]);
}
