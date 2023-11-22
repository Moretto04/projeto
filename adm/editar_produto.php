<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$produto_id = $_GET['id'];

// Busca as informações do produto.
$stmt_produto = $pdo->prepare("SELECT * FROM PRODUTO WHERE PRODUTO_ID = :produto_id");
$stmt_produto->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$stmt_produto->execute();
$produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);

// Busca as categorias.
$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
$stmt_categoria->execute();
$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);

// Busca as imagens do produto.
$stmt_img = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id ORDER BY IMAGEM_ORDEM");
$stmt_img->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$stmt_img->execute();
$imagens_existentes = $stmt_img->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizando as URLs das imagens. 

    // Atualizando as informações do produto.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? "\x01" : "\x00";
    $desconto = $_POST['desconto'];

    try {
        $stmt_update_produto = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo, PRODUTO_DESCONTO = :desconto WHERE PRODUTO_ID = :produto_id");
        $stmt_update_produto->bindParam(':nome', $nome);
        $stmt_update_produto->bindParam(':descricao', $descricao);
        $stmt_update_produto->bindParam(':preco', $preco);
        $stmt_update_produto->bindParam(':categoria_id', $categoria_id);
        $stmt_update_produto->bindParam(':ativo', $ativo);
        $stmt_update_produto->bindParam(':desconto', $desconto);
        $stmt_update_produto->bindParam(':produto_id', $produto_id);
        $stmt_update_produto->execute();

        echo "<script>alert('Produto atualizado com sucesso!'); window.location.href = 'listar_produtos.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao atualizar produto');</script>" . $e->getMessage() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../visual/editar_produto/editar_produto.css">
</head>

<body>
    <!-- <h2>Editar Produto</h2> -->
    <div class="container">
        <img src="../visual/charlie-logo.png" style="width: 40%;" alt="">
        <form action="" method="post" enctype="multipart/form-data">


            <div class="form-row">
                <div class="input-data">
                    <input type="text" name="nome" id="nome" value="<?= $produto['PRODUTO_NOME'] ?>" required>
                    <div class="underline"></div>
                    <label for="nome">Nome</label>
                </div>
                <div class="input-data">
                    <input type="number" name="preco" id="preco" step="0.01" required>
                    <div class="underline"></div>
                    <label for="preco">Preço</label>
                </div>
            </div>



            <div class="form-row">
                <div class="input-data">
                    <input type="number" name="desconto" id="desconto" step="0.01" required>
                    <div class="underline"></div>
                    <label for="desconto">Desconto</label>
                </div>
                <div id="categoria">
                    <label for="categoria_id">Categoria</label>
                    <select name="categoria_id" id="categoria_id" class="form-select" required>
                        <?php
                        foreach ($categorias as $categoria) :
                            $selected = $produto['CATEGORIA_ID'] == $categoria['CATEGORIA_ID'] ? 'selected' : '';
                        ?>
                            <option value="<?= $categoria['CATEGORIA_ID'] ?>" <?= $selected ?>>
                                <?= $categoria['CATEGORIA_NOME'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <div class="form-row">
                <div class="input-data textarea">
                    <textarea name="descricao" id="descricao" rows="8" cols="80" required><?= $produto['PRODUTO_DESC'] ?></textarea>
                    <br />
                    <div class="underline"></div>
                    <label for="">Descricao</label>
                    <br />
                </div>
            </div>



            <div class="form-row">
                <div id="url_imagens">
                    <?php
                    foreach ($imagens_existentes as $imagem) {
                        echo '<div class="input-data" style="padding-right: 30px;">';
                        echo '<input type="text" name="editar_imagem_url[' . $imagem['IMAGEM_ID'] . ']" value="' . $imagem['IMAGEM_URL'] . '">';
                        echo '<div class="underline"></div>';
                        echo '<label for="imagem">Imagem URL</label>';
                        echo '</div>';
                        echo '<br>';
                    }
                    ?>
                </div>
                <div id="ativo">
                    <label class="form-check-label" for="ativo" style="margin-left: 18px;">Ativo</label>
                    <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" checked>
                </div>
            </div>

            <div class="form-row submit-btn">
                <div class="input-data">
                    <button style="margin-top: 5px;" class="btn btn-outline-success" type="submit">Atualizar Produto</button>
                </div>
            </div>
        </form>
    </div>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="listar_produtos.php" style="text-decoration: none; color: white;"> Voltar</a></button>
    </div>

    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>