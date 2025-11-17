<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    echo json_encode(
        $pdo->query("SELECT * FROM embalagem ORDER BY tipo")->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO embalagem (tipo) VALUES (?)");
    $stmt->execute([$dados["tipo"]]);

    echo json_encode(["sucesso" => true]);
}