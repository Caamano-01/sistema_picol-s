<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

if (isset($_GET["vendas"])) {

    $sql = "
        SELECT 
            DATE_FORMAT(data_emissao, '%m/%Y') AS mes,
            SUM(quantidade_vendida * valor_unitario) AS total
        FROM nota_fiscal
        GROUP BY mes
        ORDER BY MIN(data_emissao)
    ";

    echo json_encode(
        $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

echo json_encode(["erro" => "Relatório inválido"]);
?>