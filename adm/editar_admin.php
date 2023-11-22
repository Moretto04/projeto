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
            $stmt_update = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_IMAGEM = :url WHERE ADM_ID = :avatar_id");
            $stmt_update->bindParam(':url', $url_editada, PDO::PARAM_STR);
            $stmt_update->bindParam(':avatar_id', $avatar_id, PDO::PARAM_INT);
            $stmt_update->execute();
        }
    }


    // Atualizando as informações do admnin.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    try {
        $stmt_update_admin = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :admin_id");
        $stmt_update_admin->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt_update_admin->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update_admin->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt_update_admin->bindParam(':ativo', $ativo, PDO::PARAM_STR);
        $stmt_update_admin->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt_update_admin->execute();

        echo "<script>alert('Administrador atualizado com sucesso!'); window.location.href = 'listar_admin.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao atualizar administrador');</script>" . $e->getMessage() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../visual/editar_admin/editar_admin.css">
</head>

<body>
    <!-- <h2>Editar Administrador</h2> -->
    <div class="container">
        <img src="../visual/charlie-logo.png" style="width: 40%; margin-right: 40px; " alt="">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="input-data" style="width: 400px;">
                    <input type="text" name="nome" id="nome" value="<?= $admin['ADM_NOME'] ?>" required>
                    <div class="underline"></div>
                    <label for="nome">Nome</label>
                </div>
                <div class="input-data">
                    <input type="text" name="email" id="email" value="<?= $admin['ADM_EMAIL'] ?>" required>
                    <div class="underline"></div>
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="form-row">
                <div class="input-data">
                    <input type="password" name="senha" id="senha" value="<?= $admin['ADM_SENHA'] ?>" required>
                    <div class="underline"></div>
                    <label for="senha">Senha</label>
                </div>
                <div id="ativo">
                    <label class="form-check-label" for="ativo">Ativo</label>
                    <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" checked>
                </div>
            </div>

            <div class="form-row" >
                <div id="url_imagens">
                    <?php
                    foreach ($imagens_existentes as $avatar) {
                        echo '<div class="input-data" style="width: 400px;">';
                            echo '<input type="text" name="editar_avatar_url[' . $avatar['ADM_IMAGEM'] . ']" value="' . $avatar['ADM_IMAGEM'] . '">';
                            echo '<div class="underline"></div>';
                            echo '<label for="imagem">Imagem URL</label>';
                        echo '</div>';
                        echo '<br>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-row submit-btn">
                <div class="input-data">
                    <button style="margin-top: 30px;" class="btn btn-outline-success" type="submit">Cadastrar Produto</button>
                </div>
            </div>

        </form>
    </div>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="listar_admin.php" style="text-decoration: none; color: white;"> Voltar</a></button>
    </div>

    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>