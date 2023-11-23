<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD FROM PRODUTO JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID INNER JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID ORDER BY PRODUTO_ID");
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar produtos: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../visual/listar_produtos/lista.css">
    <title>Lista de Produtos</title>

</head>

<body>
    <!-- <h2>Lista de Produtos</h2> -->
    <div id="logo">
        <a id="logo" href="produtos_funcoes.php"><img src="../visual/charlie-logo2.png" style="width: 40%;" alt=""></a>
    </div>
    <div id="search-container">
        <input type="text" id="search-input" placeholder="Pesquisar...">
        <button id="search-button" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-xl" style="color: #ff0000; "></i></button>
    </div>
    <table id="produtos-table" class="table table-hover table-striped-columns">

        <thead>
            <th>IMAGEM</th>
            <th>NOME</th>
            <th>DESCRIÇÃO</th>
            <th>PREÇO</th>
            <th>CATEGORIA</th>
            <th>ATIVO</th>
            <th>DESCONTO</th>
            <th>ESTOQUE</th>
            <th>ID</th>
            <th>AÇÕES</th>
        </thead>


        <?php foreach ($produtos as $produto): ?> <!--aq ele esta se referindo as infos do banco-->
            <tr>
                <td><img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50"></td>

                <td>
                    <?php echo $produto['PRODUTO_NOME']; ?>
                </td>

                <td>
                    <?php echo $produto['PRODUTO_DESC']; ?>
                </td>

                <td>
                    <?php echo $produto['PRODUTO_PRECO']; ?>
                </td>

                <td>
                    <?php echo $produto['CATEGORIA_NOME']; ?>
                </td>

                <td>
                    <?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?>
                </td>

                <td>
                    <?php echo $produto['PRODUTO_DESCONTO']; ?>
                </td>

                <td>
                    <?php echo $produto['PRODUTO_QTD']; ?>
                </td>

                <td>
                    <?php echo $produto['PRODUTO_ID']; ?>
                </td>

                <td>
                    <button type="button" id="editar" class="btn btn-success"><a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>">EDITAR</a></button>
                    <button type="button" class="btn btn-danger" style="margin-top: 10px; margin-bottom: 10px;"><a href="excluir_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>">EXCLUIR</a></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="produtos_funcoes.php"> Voltar</a></button>
    </div>


    
    <!-- alert do botão de excluir -->

    <script>
        function excluirAdmin() {
            alert("Função desabilitada!");
            var btn = document.getElementById('excluir');
        }
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('search-input');
            var searchButton = document.getElementById('search-button');
            var tableRows = document.querySelectorAll('#produtos-table tbody tr');
            var tableHead = document.querySelector('#produtos-table thead');

            searchButton.addEventListener('click', function () {
                var searchTerm = searchInput.value.toLowerCase();

                tableRows.forEach(function (row) {
                    var rowData = Array.from(row.children).map(function (cell) {
                        return cell.textContent.toLowerCase();
                    });

                    var shouldShow = rowData.some(function (data) {
                        return data.includes(searchTerm);
                    });

                    row.style.display = shouldShow ? '' : 'none';
                });

                // Garantir que o thead seja exibido
                tableHead.style.display = 'table-header-group';
            });

            searchInput.addEventListener('input', function () {
                var searchTerm = searchInput.value.trim().toLowerCase();

                tableRows.forEach(function (row) {
                    var rowData = Array.from(row.children).map(function (cell) {
                        return cell.textContent.toLowerCase();
                    });

                    var shouldShow = rowData.some(function (data) {
                        return data.includes(searchTerm);
                    });

                    row.style.display = shouldShow || searchTerm === '' ? '' : 'none';
                });

                // Garantir que o thead seja exibido
                tableHead.style.display = 'table-header-group';
            });
        });
    </script>





    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>