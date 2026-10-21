<?php
require_once "conexao.php";
session_start();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE usu_email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['usu_senha'])) {
        $_SESSION['usuario_id'] = $usuario['usu_cod'];
        $_SESSION['usuario_nome'] = $usuario['usu_nome'];
        header("Location: admin.php");
        exit;
    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Administrativo</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>ONG - Restrito</h1>
        <nav><a href="index.php">Voltar ao Site</a></nav>
    </header>
    <main style="max-width: 400px;">
        <h2>Acesso Administrativo</h2>
        <?php if ($erro): ?><div class="msg" style="background:#f8d7da; color:#721c24;"><?= $erro ?></div><?php endif; ?>
        <form method="post">
            <label>E-mail:</label>
            <input type="email" name="email" required>
            
            <label>Senha:</label>
            <input type="password" name="senha" required>
            
            <button type="submit" style="width: 100%;">Entrar</button>
        </form>
        <p style="margin-top:15px; font-size: 0.85rem; color:#666;">Credenciais padrão de teste:<br>E-mail: <b>admin@ong.com</b><br>Senha: <b>admin123</b></p>
    </main>
    <footer>Escola SESI SENAI — Projeto Integrador 3º Ano</footer>
</body>
</html>