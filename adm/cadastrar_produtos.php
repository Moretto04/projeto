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

// Bloco de consulta para buscar categorias.
try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao buscar categorias: " . $e->getMessage() . "</p>";
}

// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $desconto = $_POST['desconto'];
    $imagens = $_POST['imagem_url'];

    // Inserindo produto no banco.
    try {
        $sql = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, CATEGORIA_ID, PRODUTO_ATIVO, PRODUTO_DESCONTO) VALUES (:nome, :descricao, :preco, :categoria_id, :ativo, :desconto)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->execute();

        // Pegando o ID do produto inserido.
        $produto_id = $pdo->lastInsertId();

        // Inserindo imagens no banco.
        foreach ($imagens as $ordem => $url_imagem) {
            $sql_imagem = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM) VALUES (:url_imagem, :produto_id, :ordem_imagem)";
            $stmt_imagem = $pdo->prepare($sql_imagem);
            $stmt_imagem->bindParam(':url_imagem', $url_imagem, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
            $stmt_imagem->execute();
        }

        echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href = 'listar_produtos.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao cadastrar produto');</script>" . $e->getMessage() . "</p>";
    }
}
?>


<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <script>
        function adicionarImagem() {
            // Obtém o contêiner de imagens
            const containerImagens = document.getElementById('containerImagens');

            // Obtém o elemento com o ID 'containerImagens'
            const containerOriginal = document.getElementById('containerImagens');

            // Clona o conteúdo dentro do elemento 'containerImagens'
            const novoFormRow = containerOriginal.cloneNode(true);

            // Remove o botão "Adicionar mais imagens" do novo form-row
            const botaoAdicionar = novoFormRow.querySelector('.btn');
            botaoAdicionar.parentNode.removeChild(botaoAdicionar);

            // Obtém a div com o ID 'ativo'
            const divAtivo = document.getElementById('ativo');

            // Adiciona o novo form-row antes da div com o ID 'ativo'
            containerImagens.parentNode.insertBefore(novoFormRow, divAtivo);
        }
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="../visual/cadastrar_produtos/cadastrar_produto.css">
</head>

<body>

    <div class="container">
        <img src="../visual/charlie-logo.png" style="width: 40%;" alt="">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="input-data">
                    <input type="text" name="nome" id="nome" required>
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
                        // Loop para preencher o dropdown de categorias.
                        foreach ($categorias as $categoria) :
                        ?>


                            <option value="<?= $categoria['CATEGORIA_ID'] ?>">
                                <?= $categoria['CATEGORIA_NOME'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <div class="form-row">
                <div class="input-data textarea">
                    <textarea name="descricao" id="descricao" rows="8" cols="80" required></textarea>
                    <br />
                    <div class="underline"></div>
                    <label for="">Descricao</label>
                    <br />
                </div>
            </div>


            <div class="form-row " id="clone">
                <div class="input-data" id="containerImagens">
                    <input type="text" name="imagem_url[]" required>
                    <div class="underline"></div>
                    <label for="imagem">Imagem URL</label>
                    <button type="button" class="btn btn-outline-dark" style="margin-top: 20px;" onclick="adicionarImagem()">Adicionar mais imagens</button>
                </div>
                <div id="ativo">
                    <label class="form-check-label" for="ativo">Ativo</label>
                    <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" checked>
                </div>
            </div>


            <div class="form-row submit-btn">
                <div class="input-data">
                    <button style="margin-top: 30px;" class="btn btn-success" type="submit">Cadastrar Produto</button>
                </div>
            </div>
        </form>
    </div>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="produtos_funcoes.php" style="text-decoration: none; color: white;"> Voltar</a></button>
    </div>

    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>