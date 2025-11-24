<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    echo json_encode(
        $pdo->query("SELECT * FROM aditivo_nutritivo ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO aditivo_nutritivo (nome) VALUES (?)");
    $stmt->execute([$dados["nome"]]);

    echo json_encode(["sucesso" => true]);
}
?>