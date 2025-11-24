<?php
/**
 * ARQUIVO: nota.php
 * DESCRIÇÃO: Endpoint para listar notas fiscais (GET) e emitir novas notas (POST) com múltiplos itens.
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    // GET: Listar notas com revendedor
    echo json_encode(
        $pdo->query("
            SELECT n.*, r.`razão social` AS revendedor
            FROM nota_fiscal n
            INNER JOIN revendedor r ON r.id = n.id_revendedor
            ORDER BY n.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC)
    );
    exit;
}

if ($method === "POST") {
    $dados = json_decode(file_get_contents("php://input"), true);

    // Validação básica e tipagem
    $id_revendedor = isset($dados["id_revendedor"]) ? (int)$dados["id_revendedor"] : 0;
    $itens = isset($dados["itens"]) && is_array($dados["itens"]) ? $dados["itens"] : [];

    if ($id_revendedor <= 0 || empty($itens)) {
        http_response_code(400);
        echo json_encode(["erro" => "Revendedor inválido ou nenhum item informado."]);
        exit;
    }

    foreach ($itens as $index => $item) {
        if (!isset($item["id_lote"], $item["quantidade_vendida"], $item["valor_unitario"])) {
            http_response_code(400);
            echo json_encode(["erro" => "Item #{$index} incompleto."]);
            exit;
        }
        $item["id_lote"] = (int)$item["id_lote"];
        $item["quantidade_vendida"] = (int)$item["quantidade_vendida"];
        $item["valor_unitario"] = (float)$item["valor_unitario"];

        if ($item["id_lote"] <= 0 || $item["quantidade_vendida"] <= 0 || $item["valor_unitario"] <= 0) {
            http_response_code(400);
            echo json_encode(["erro" => "Item #{$index} possui valores inválidos."]);
            exit;
        }
    }

    try {
        $pdo->beginTransaction();

        // Inserir capa da nota com valor total inicial zero
        $stmt_nota = $pdo->prepare("
            INSERT INTO nota_fiscal (data, id_revendedor, valor_total)
            VALUES (NOW(), ?, 0)
        ");
        $stmt_nota->execute([$id_revendedor]);
        $id_nota = $pdo->lastInsertId();

        // Atualizar número da nota
        $pdo->prepare("UPDATE nota_fiscal SET numero = CONCAT('NF', LPAD(?, 4, '0')) WHERE id = ?")
            ->execute([$id_nota, $id_nota]);

        $valor_total_nota = 0;

        // Inserir itens e atualizar estoque
        foreach ($itens as $item) {
            $valor_total_item = $item["quantidade_vendida"] * $item["valor_unitario"];
            $valor_total_nota += $valor_total_item;

            // Lock no lote para evitar concorrência
            $stmt_lock = $pdo->prepare("SELECT quantidade FROM lote WHERE id = ? FOR UPDATE");
            $stmt_lock->execute([$item["id_lote"]]);
            $lote = $stmt_lock->fetch(PDO::FETCH_ASSOC);

            if (!$lote || $lote["quantidade"] < $item["quantidade_vendida"]) {
                throw new Exception("Estoque insuficiente ou lote #{$item['id_lote']} não encontrado.");
            }

            // Inserir item na nota
            $stmt_item = $pdo->prepare("
                INSERT INTO nota_lote (id_nota, id_lote, quantidade_vendida, valor_unitario)
                VALUES (?, ?, ?, ?)
            ");
            $stmt_item->execute([
                $id_nota,
                $item["id_lote"],
                $item["quantidade_vendida"],
                $item["valor_unitario"]
            ]);

            // Baixar estoque
            $stmt_update = $pdo->prepare("
                UPDATE lote SET quantidade = quantidade - ? WHERE id = ?
            ");
            $stmt_update->execute([$item["quantidade_vendida"], $item["id_lote"]]);
        }

        // Atualizar valor_total da nota
        $pdo->prepare("UPDATE nota_fiscal SET valor_total = ? WHERE id = ?")
            ->execute([$valor_total_nota, $id_nota]);

        $pdo->commit();

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Nota fiscal (ID: {$id_nota}) emitida com sucesso.",
            "id_nota" => $id_nota,
            "valor_total" => $valor_total_nota
        ]);

    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(["erro" => "Falha na emissão da nota: " . $e->getMessage()]);
    }

    exit;
}
?>