<?php
require_once "conexao.php";
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM animal WHERE ani_cod = ?");
        $stmt->execute([$id]);
    }
}
header("Location: admin.php?msg=ok");
exit;
?>