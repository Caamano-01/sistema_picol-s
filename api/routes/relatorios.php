<?php
/**
 * ARQUIVO: relatorios.php
 * DESCRIÇÃO: Endpoint para retornar diferentes tipos de relatórios de vendas.
 * 1. ?vendas=true: Total faturado por mês.
 * 2. ?ranking=true: Picolés mais vendidos por quantidade no último mês.
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

try {
    // -------------------------------------------------------------------------
    // 1. RELATÓRIO DE FATURAMENTO MENSAL (VENDAS TOTAIS)
    // -------------------------------------------------------------------------
    if (isset($_GET["vendas"])) {
        $sql = "
            SELECT 
                DATE_FORMAT(nf.data, '%m/%Y') AS mes,
                SUM(nl.quantidade_vendida * nl.valor_unitario) AS total
            FROM nota_fiscal nf
            INNER JOIN nota_lote nl ON nl.id_nota = nf.id
            GROUP BY YEAR(nf.data), MONTH(nf.data)
            ORDER BY YEAR(nf.data), MONTH(nf.data)
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // -------------------------------------------------------------------------
    // 2. RELATÓRIO DE RANKING DE PICOLÉS (MAIS VENDIDOS NO ÚLTIMO MÊS)
    // -------------------------------------------------------------------------
    if (isset($_GET["ranking"])) {
        // Calcula primeiro e último dia do mês anterior
        $sql = "
            SELECT 
                p.nome AS picole,
                SUM(nl.quantidade_vendida) AS quantidade_vendida
            FROM nota_lote nl
            INNER JOIN lote l ON l.id = nl.id_lote
            INNER JOIN picole p ON p.id = l.id_picole
            INNER JOIN nota_fiscal nf ON nf.id = nl.id_nota
            WHERE nf.data >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
              AND nf.data < DATE_FORMAT(CURDATE(), '%Y-%m-01')
            GROUP BY p.nome
            ORDER BY quantidade_vendida DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // -------------------------------------------------------------------------
    // 3. ERRO PADRÃO
    // -------------------------------------------------------------------------
    http_response_code(400); // Bad Request
    echo json_encode(["erro" => "Relatório inválido. Use ?vendas=true ou ?ranking=true"]);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
}
?>
