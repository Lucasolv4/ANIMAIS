<?php
$dsn = "mysql:host=localhost;dbname=db_ong_animais;charset=utf8mb4";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>