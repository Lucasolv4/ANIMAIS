<?php
require_once "conexao.php";
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $mensagem = trim($_POST['mensagem']);

    if (!empty($nome) && !empty($email) && !empty($mensagem)) {
        $stmt = $pdo->prepare("INSERT INTO contato (con_nome, con_email, con_mensagem) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $mensagem]);
        $msg = "Mensagem enviada com sucesso! Entraremos em contacto em breve.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contato - ONG</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>ONG Proteção Animal</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="contato.php">Contato</a>
            <a href="login.php">Área Administrativa</a>
        </nav>
    </header>
    <main>
        <h2>Fale Conosco / Quero Adotar</h2>
        <?php if ($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
        <form method="post" style="max-width: 600px;">
            <label>Seu Nome:</label>
            <input type="text" name="nome" required>
            
            <label>Seu E-mail:</label>
            <input type="email" name="email" required>
            
            <label>Mensagem / Interesse:</label>
            <textarea name="mensagem" rows="5" required></textarea>
            
            <button type="submit">Enviar Mensagem</button>
        </form>
    </main>
    <footer>Escola SESI SENAI — Projeto Integrador 3º Ano</footer>
</body>
</html>