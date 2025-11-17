<?php
require "config.php";

$stmt = $pdo->query("SELECT id, tipo FROM embalagem ORDER BY tipo");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
