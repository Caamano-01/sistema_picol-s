<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config.php";

$ingredientes = [];

// Ingredientes básicos
$ingred = $pdo->query("SELECT id, nome, 'ingrediente' AS tipo FROM ingrediente ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Aditivos nutricionais
$aditivos = $pdo->query("SELECT id, nome, 'aditivo_nutritivo' AS tipo FROM aditivo_nutritivo ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Conservantes
$conservantes = $pdo->query("SELECT id, nome, 'conservante' AS tipo FROM conservante ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Junta tudo
$ingredientes = array_merge($ingred, $aditivos, $conservantes);

echo json_encode($ingredientes);
?>