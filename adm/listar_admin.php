<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*,ADM_IMAGEM, ADM_ID, ADM_NOME, ADM_EMAIL, ADM_ATIVO FROM ADMINISTRADOR ORDER BY ADM_ID");
    $stmt->execute();
    $admin = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar os administradores: " . $e->getMessage() . "</p>";
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
    <title>Lista de Administradores</title>

</head>

<body>
    <!-- <h2>Lista de Administradores</h2> -->
    <div id="logo">
        <a id="logo" href="admin_funcoes.php"><img src="../visual/charlie-logo2.png"
                style="width: 40%; background-color: black; " alt=""></a>
    </div>
    <div id="search-container">
        <input type="text" id="search-input" placeholder="Pesquisar...">
        <button id="search-button" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-xl"
                style="color: #ff0000; "></i></button>
    </div>
    <table id="admin-table" class="table table-hover table-striped-columns">
        <thead>
            <th>IMAGEM</th>
            <th>ID</th>
            <th>NOME</th>
            <th>EMAIL</th>
            <th>ATIVO</th>
            <th>AÇÕES</th>

        </thead>

        <?php foreach ($admin as $admin): ?> <!--aq ele esta se referindo as infos do banco-->
            <tr>
                <td><img src="<?php echo $admin['ADM_IMAGEM']; ?>" alt="<?php echo $admin['ADM_NOME']; ?>" width="50"></td>

                <td>
                    <?php echo $admin['ADM_ID']; ?>
                </td>

                <td>
                    <?php echo $admin['ADM_NOME']; ?>
                </td>

                <td>
                    <?php echo $admin['ADM_EMAIL']; ?>
                </td>

                <td>
                    <?php echo ($admin['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?>
                </td>

                <td>
                    <button type="button" id="editar" class="btn btn-success"><a href="editar_admin.php?id=<?php echo $admin['ADM_ID']; ?>">EDITAR</a></button>
                    <button id="excluir" <?php echo $admin['ADM_ID']; ?>" type="button" class="btn btn-danger" onclick="excluirAdmin(<?php echo $admin['ADM_ID']; ?>)">EXCLUIR</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div id="voltar">
        <button id="btn" type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="admin_funcoes.php"> Voltar</a></button>
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
            var tableRows = document.querySelectorAll('#admin-table tbody tr');
            var tableHead = document.querySelector('#admin-table thead');

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>