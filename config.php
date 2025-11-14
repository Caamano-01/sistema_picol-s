<?php
/**
 * Configuração e Conexão com o Banco de Dados
*/

// Configurações do Banco de Dados
define('DB_HOST', 'localhost'); // Host do MySQL
define('DB_NAME', 'sistema_picoles'); // Nome do banco de dados
define('DB_USER', 'root'); // Utilizador do MySQL
define('DB_PASS', '1@asdfg');

try {
    // Cria a instância PDO
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    
    // Define o modo de erro para exceções, útil para debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Define o fetch mode padrão para objetos, mas podes mudar para ASSOC se preferires
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Se a conexão for bem-sucedida, não faz nada (o script continua)
    
} catch (PDOException $e) {
    // Em caso de erro na conexão
    die("Erro na Conexão com o Banco de Dados: " . $e->getMessage());
}
?>