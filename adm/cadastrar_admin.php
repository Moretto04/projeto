<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();

// Importa a configuração de conexão com o banco de dados.
require_once('../config/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}


// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = $_POST['ativo'];
    $avatar = $_POST['avatar'];


    // Inserindo produto no banco.
    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM) VALUES (:nome, :email, :senha, :ativo, :avatar)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);

        $stmt->execute();

        echo "<script>alert('Administrador cadastrado com sucesso!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao cadastrar administrador');</script>" . $e->getMessage() . "</p>";
    }
}
?>

<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Administrador</title>

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../visual/cadastrar_admin/cadastrar_admin.css">
</head>

<body>
    <!-- <h2>Cadastrar Administrador</h2> -->
    <div class="container">
        <img src="../visual/charlie-logo.png" style="width: 40%; margin-right: 30px;" alt="">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="input-data" style="width: 400px;" >
                    <input type="text" name="nome" id="nome" required>
                    <div class="underline"></div>
                    <label for="nome">Nome</label>
                </div>
                <div class="input-data">
                    <input type="text" name="email" id="email" required>
                    <div class="underline"></div>
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="form-row">
                <div class="input-data">
                    <input type="password" name="senha" id="senha" required>
                    <div class="underline"></div>
                    <label for="preco">Senha</label>
                </div>

                <div id="ativo">
                    <label class="form-check-label" for="ativo">Ativo</label>
                    <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" checked>
                </div>
            </div>

            <div class="form-row">
                <div class="input-data" id="containerImagens">
                    <input type="text" name="avatar" id="avatar" required>
                    <div class="underline"></div>
                    <label for="imagem">Imagem URL</label>
                </div>
            </div>

            <div class="form-row submit-btn">
                <div class="input-data">
                    <button style="margin-top: 30px;" class="btn btn-outline-success" type="submit">Cadastrar admin</button>
                </div>
            </div>

        </form>
    </div>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="admin_funcoes.php" style="text-decoration: none; color: white;"> Voltar</a></button>
    </div>


    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>