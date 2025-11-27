<?php
/**
 * ARQUIVO: relatorios.php
 * DESCRIÇÃO: Endpoint para retornar diferentes tipos de relatórios de vendas.
 * 1. ?vendas=true: Total faturado por mês.
 * 2. ?ranking=true: Picolés mais vendidos por quantidade no último mês.
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

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
    // 2. RELATÓRIO DE RANKING DE PICOLÉS (MAIS VENDIDOS NO ÚLTIMO MÊS COM VENDAS)
    // -------------------------------------------------------------------------
    if (isset($_GET["ranking"])) {
        // 1. Encontra o ano e mês da última nota fiscal registrada
        $stmt_ultima_data = $pdo->prepare("SELECT YEAR(MAX(data)) AS ultimo_ano, MONTH(MAX(data)) AS ultimo_mes FROM nota_fiscal");
        $stmt_ultima_data->execute();
        $data_max = $stmt_ultima_data->fetch(PDO::FETCH_ASSOC);

        if (empty($data_max['ultimo_ano'])) {
            // Se não houver nota fiscal, retorna vazio.
            echo json_encode([]);
            exit;
        }

        $ultimo_ano = $data_max['ultimo_ano'];
        $ultimo_mes = $data_max['ultimo_mes'];

        // 2. Consulta de Ranking (filtrando pelo último mês encontrado)
        $sql = "
            SELECT 
                p.nome AS picole,
                SUM(nl.quantidade_vendida) AS quantidade_vendida
            FROM nota_lote nl
            INNER JOIN lote l ON l.id = nl.id_lote
            INNER JOIN picole p ON p.id = l.id_picole
            INNER JOIN nota_fiscal nf ON nf.id = nl.id_nota
            WHERE YEAR(nf.data) = :ultimo_ano AND MONTH(nf.data) = :ultimo_mes
            GROUP BY p.nome
            ORDER BY quantidade_vendida DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ultimo_ano', $ultimo_ano);
        $stmt->bindParam(':ultimo_mes', $ultimo_mes);
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