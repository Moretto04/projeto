<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$admin_id = $_GET['id'];

// Busca as informações do ADEMAR.
$stmt_admin = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :admin_id");
$stmt_admin->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
$stmt_admin->execute();
$admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);

// Busca as imagens do ADEMAR.
$stmt_img = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :admin_id");
$stmt_img->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
$stmt_img->execute();
$imagens_existentes = $stmt_img->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizando as URLs das imagens.
    if (isset($_POST['editar_avatar_url'])) {
        foreach ($_POST['editar_avatar_url'] as $avatar_id => $url_editada) {
            $stmt_update = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_IMAGEM = :url");
            $stmt_update->bindParam(':url', $url_editada, PDO::PARAM_STR);
            $stmt_update->execute();
        }
    }

    
    // Atualizando as informações do produto.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? "\x01" : "\x00";
 

    try {
        $stmt_update_produto = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :admin_id");
        $stmt_update_produto->bindParam(':nome', $nome);
        $stmt_update_produto->bindParam(':email', $email);
        $stmt_update_produto->bindParam(':senha', $senha);
        $stmt_update_produto->bindParam(':ativo', $ativo);
        $stmt_update_produto->execute();

        echo "<p style='color:green;'>Administrador atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar Administrador: " . $e->getMessage() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
</head>
<body>
<h2>Editar Produto</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= $admin['ADM_NOME'] ?>" required>
    <p>
    <label for="email">EMAIL:</label>
    <input name="email" id="email" required><?= $admin['ADM_EMAIL'] ?></input>
    <p>
    <label for="senha">SENHA:</label>
    <input type="password" name="senha" id="senha" step="0.01" value="<?= $admin['ADM_SENHA'] ?>" required>    
    <p>
    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" <?= $admin['ADM_ATIVO'] ? 'checked' : '' ?>>
    <p>

    <?php 
    foreach($imagens_existentes as $avatar) {
        echo '<div>';
        echo '<label>URL da Imagem:</label>';
        echo '<input type="text" name="editar_avatar_url[' . $avatar['ADM_IMAGEM'] . ']" value="' . $avatar['ADM_IMAGEM'] . '">';
        echo '</div>';
    }
    ?>

    <button type="submit">Atualizar Administrador</button>
    <div>
        <button><a href="listar_admin.php">Voltar</a></button>
    </div>
</form>
</body>
</html>