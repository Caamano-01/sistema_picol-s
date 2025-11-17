<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    echo json_encode(
        $pdo->query("
            SELECT n.*, r.nome AS revendedor
            FROM nota_fiscal n
            INNER JOIN revendedor r ON r.id = n.id_revendedor
            ORDER BY n.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("
        INSERT INTO nota_fiscal 
        (id_revendedor, id_lote, quantidade_vendida, valor_unitario, data_emissao)
        VALUES (?, ?, ?, ?, NOW())
    ");

    $stmt->execute([
        $dados["id_revendedor"],
        $dados["id_lote"],
        $dados["quantidade_vendida"],
        $dados["valor_unitario"]
    ]);

    echo json_encode(["sucesso" => true]);
}