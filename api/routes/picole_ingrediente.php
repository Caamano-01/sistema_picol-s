<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

// LISTAR TODOS OS INGREDIENTES DO PICOLÉ
if ($method === "GET") {

    if (isset($_GET["id_picole"])) {
        // Lista somente os ingredientes de um picolé
        $stmt = $pdo->prepare("
            SELECT pi.*, 
                   i.nome AS ingrediente,
                   pi.tipo_ingrediente
            FROM picole_ingrediente pi
            LEFT JOIN ingrediente i ON (pi.id_ingrediente = i.id AND pi.tipo_ingrediente = 'ingrediente')
            WHERE pi.id_picole = ?
        ");
        $stmt->execute([$_GET["id_picole"]]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // Lista geral
    echo json_encode(
        $pdo->query("SELECT * FROM picole_ingrediente")->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("
        INSERT INTO picole_ingrediente (id_picole, id_ingrediente, tipo_ingrediente)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([
        $dados["id_picole"],
        $dados["id_ingrediente"],
        $dados["tipo_ingrediente"]
    ]);

    echo json_encode(["sucesso" => true]);
    exit;
}
?>