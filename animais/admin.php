<?php
require_once "conexao.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$animais = $pdo->query("SELECT a.*, r.raca_nome FROM animal a JOIN raca r ON r.raca_cod = a.raca_cod ORDER BY a.ani_nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo - ONG</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>Painel da ONG (Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>)</h1>
        <nav>
            <a href="admin.php">Gerenciar Animais</a>
            <a href="logout.php" style="color: #ffcccc;">Sair</a>
        </nav>
    </header>
    <main>
        <h2>Gestão de Animais</h2>
        <a href="animal_form.php" class="btn">Novo Animal</a>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="msg" style="margin-top: 15px;">Operação realizada com sucesso!</div>
        <?php endif; ?>

        <table>
            <tr>
                <th>Nome</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Porte</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($animais as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['ani_nome']) ?></td>
                <td><?= htmlspecialchars($a['raca_nome']) ?></td>
                <td><?= htmlspecialchars($a['ani_idade']) ?></td>
                <td><?= htmlspecialchars($a['ani_porte']) ?></td>
                <td>
                    <a href="animal_form.php?id=<?= $a['ani_cod'] ?>" class="btn" style="padding: 6px 10px; font-size: 0.85rem;">Editar</a>
                    <form method="post" action="animal_excluir.php" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este animal?');">
                        <input type="hidden" name="id" value="<?= $a['ani_cod'] ?>">
                        <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.85rem;">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </main>
    <footer>Escola SESI SENAI — Projeto Integrador 3º Ano</footer>
</body>
</html>