<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$categoria_id = $_GET['id'];

// Busca as informações da categoria.
$stmt_categoria= $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :categoria_id");
$stmt_categoria->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
$stmt_categoria->execute();
$categoria = $stmt_categoria->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizando as informações do admnin.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;


    try {
        $stmt_update_categoria = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome, CATEGORIA_DESC = :descricao, CATEGORIA_ATIVO = :ativo WHERE CATEGORIA_ID = :categoria_id");
        $stmt_update_categoria->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt_update_categoria->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt_update_categoria->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt_update_categoria->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt_update_categoria->execute();

        echo "<script>alert('Categoria atualizada com sucesso!'); window.location.href = 'listar_categoria.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao atualizar categoria');</script>" . $e->getMessage() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../visual/editar_admin/editar_admin.css">
</head>

<body>
    <!-- <h2>Editar Categoria</h2> -->
    <div class="container">
        <img src="../visual/charlie-logo.png" style="width: 40%; margin-right: 40px; " alt="">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="input-data" style="width: 400px;">
                    <input type="text" name="nome" id="nome" value="<?= $categoria['CATEGORIA_NOME'] ?>" required>
                    <div class="underline"></div>
                    <label for="nome">Nome</label>
                </div>
                <div id="ativo">
                    <label class="form-check-label" for="ativo">Ativo</label>
                    <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" checked>
                </div>
            </div>

            <div class="form-row">
                <div class="input-data textarea">
                    <textarea name="descricao" id="descricao" rows="8" cols="80" required><?= $categoria['CATEGORIA_DESC'] ?></textarea>
                    <br />
                    <div class="underline"></div>
                    <label for="">Descricao</label>
                    <br />
                </div>
            </div>

            <div class="form-row submit-btn">
                <div class="input-data">
                    <button style="margin-top: 30px;" class="btn btn-outline-success" type="submit">Atualizar Categoria</button>
                </div>
            </div>

        </form>
    </div>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="categoria_funcoes.php" style="text-decoration: none; color: white;"> Voltar</a></button>
    </div>

    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>