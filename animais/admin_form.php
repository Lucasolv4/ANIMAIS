<?php
require_once "conexao.php";
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit; }

$id = $_GET['id'] ?? null;
$animal = ['ani_nome' => '', 'ani_idade' => '', 'ani_porte' => '', 'ani_descricao' => '', 'raca_cod' => ''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM animal WHERE ani_cod = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch() ?: die("Animal não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $idade = trim($_POST['idade']);
    $porte = trim($_POST['porte']);
    $descricao = trim($_POST['descricao']);
    $raca_cod = $_POST['raca_cod'];

    if ($id) {
        $sql = "UPDATE animal SET ani_nome = ?, ani_idade = ?, ani_porte = ?, ani_descricao = ?, raca_cod = ? WHERE ani_cod = ?";
        $pdo->prepare($sql)->execute([$nome, $idade, $porte, $descricao, $raca_cod, $id]);
    } else {
        $sql = "INSERT INTO animal (ani_nome, ani_idade, ani_porte, ani_descricao, raca_cod) VALUES (?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$nome, $idade, $porte, $descricao, $raca_cod]);
    }
    header("Location: admin.php?msg=ok");
    exit;
}

$racas = $pdo->query("SELECT * FROM raca ORDER BY raca_nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Animal</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>Painel Administrativo</h1>
        <nav><a href="admin.php">Voltar</a></nav>
    </header>
    <main style="max-width: 600px;">
        <h2><?= $id ? "Editar Animal" : "Novo Animal" ?></h2>
        <form method="post">
            <label>Nome do Animal:</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($animal['ani_nome']) ?>">

            <label>Raça:</label>
            <select name="raca_cod" required>
                <option value="">Selecione...</option>
                <?php foreach ($racas as $r): ?>
                    <option value="<?= $r['raca_cod'] ?>" <?= $r['raca_cod'] == $animal['raca_cod'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['raca_nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Idade:</label>
            <input type="text" name="idade" required value="<?= htmlspecialchars($animal['ani_idade']) ?>">

            <label>Porte (Pequeno, Médio, Grande):</label>
            <input type="text" name="porte" required value="<?= htmlspecialchars($animal['ani_porte']) ?>">

            <label>Descrição / Comportamento:</label>
            <textarea name="descricao" rows="3"><?= htmlspecialchars($animal['ani_descricao']) ?></textarea>
            <br>
            <button type="submit">Salvar Animal</button>
            <a href="admin.php" class="btn" style="background: #6c757d; margin-left: 10px;">Cancelar</a>
        </form>
    </main>
    <footer>Escola SESI SENAI — Projeto Integrador 3º Ano</footer>
</body>
</html>