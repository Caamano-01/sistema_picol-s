<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

// GET (listar ou buscar por ID)
if ($method === "GET") {
    if (isset($_GET["id"])) {
        $stmt = $pdo->prepare("SELECT * FROM picole WHERE id = ?");
        $stmt->execute([$_GET["id"]]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $sql = "
            SELECT p.id, p.nome, p.tipo,
                   s.nome AS sabor,
                   e.tipo AS embalagem
            FROM picole p
            LEFT JOIN sabor s ON s.id = p.id_sabor
            LEFT JOIN embalagem e ON e.id = p.id_embalagem
            ORDER BY p.id DESC
        ";
        echo json_encode($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (criar)
if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("
        INSERT INTO picole (nome, tipo, id_sabor, id_embalagem)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([
        $dados["nome"],
        $dados["tipo"],
        $dados["id_sabor"],
        $dados["id_embalagem"]
    ]);

    echo json_encode(["sucesso" => true, "id" => $pdo->lastInsertId()]);
    exit;
}
?>