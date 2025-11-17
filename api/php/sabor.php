<?php
require "config.php";

$stmt = $pdo->query("SELECT id, nome FROM sabor ORDER BY nome");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
