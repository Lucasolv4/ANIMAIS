<?php
require_once "conexao.php";

$busca = trim($_GET['busca'] ?? '');
$sql = "SELECT a.*, r.raca_nome FROM animal a JOIN raca r ON r.raca_cod = a.raca_cod WHERE a.ani_nome LIKE ? ORDER BY a.ani_nome";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%{$busca}%"]);
$animais = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ONG - Animais para Adoção</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>ONG Proteção Animal</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="contato.php">Contato</a>
            <a href="login.php" style="background: #3aafa9; padding: 8px 12px; border-radius: 4px;">Área Administrativa</a>
        </nav>
    </header>
    <main>
        <h2>Animais Disponíveis para Adoção</h2>
        <form method="get" style="display: flex; gap: 10px; margin-bottom: 25px;">
            <input type="text" name="busca" placeholder="Pesquisar animal por nome..." value="<?= htmlspecialchars($busca) ?>" style="margin:0;">
            <button type="submit">Buscar</button>
        </form>

        <table>
            <tr>
                <th>Nome</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Porte</th>
                <th>Descrição</th>
            </tr>
            <?php if (empty($animais)): ?>
                <tr><td colspan="5" style="text-align:center;">Nenhum animal encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($animais as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['ani_nome']) ?></td>
                    <td><?= htmlspecialchars($a['raca_nome']) ?></td>
                    <td><?= htmlspecialchars($a['ani_idade']) ?></td>
                    <td><?= htmlspecialchars($a['ani_porte']) ?></td>
                    <td><?= htmlspecialchars($a['ani_descricao']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </main>
    <footer>Escola SESI SENAI — Projeto Integrador 3º Ano</footer>
</body>
</html>