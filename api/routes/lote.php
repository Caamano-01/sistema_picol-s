<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    echo json_encode(
        $pdo->query("
            SELECT l.*, p.nome AS picole
            FROM lote l
            INNER JOIN picole p ON p.id = l.id_picole
            ORDER BY l.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("
        INSERT INTO lote (id_picole, quantidade, data_producao)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([
        $dados["id_picole"],
        $dados["quantidade"],
        $dados["data_producao"]
    ]);

    echo json_encode(["sucesso" => true]);
}
?>