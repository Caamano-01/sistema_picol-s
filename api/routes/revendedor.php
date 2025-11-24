<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    $sql = $pdo->query("SELECT id, `razão social`, cnpj, endereco FROM revendedor ORDER BY `razão social`");
    echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO revendedor (`razão social`, cnpj, endereco) VALUES (?, ?, ?)");
    $stmt->execute([
        $dados["nome"],  // continua recebendo "nome" do frontend
        $dados["cnpj"],
        $dados["endereco"]
    ]);

    echo json_encode(["sucesso" => true]);
}
?>