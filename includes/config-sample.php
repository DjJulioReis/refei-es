<?php
// Este é um arquivo de exemplo.
// O sistema gera o config.php automaticamente via setup.php.
// Se preferir criar manualmente, renomeie este arquivo para config.php e preencha os dados abaixo.

$db_host = 'localhost';
$db_user = 'seu_usuario';
$db_pass = 'sua_senha';
$db_name = 'santa_helena_db';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
