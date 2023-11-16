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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../visual/listar_produtos/lista.css">
    <title>Lista Produtos</title>

</head>

<body>
    <h2>Lista de Administradores</h2>
    <div id="logo"><img src="../visual/charlie-logo.png" style="width: 20%;" alt=""></div>
    <table  class="table table-hover table-striped-columns">
        <tr>
            <th>IMAGEM</th>
            <th>ID</th> 
            <th>NOME</th> 
            <th>EMAIL</th>
            <th>ATIVO</th>
            <th>EDITAR</th>
            
        </tr>
        
        <?php foreach($admin as $admin): ?> <!--aq ele esta se referindo as infos do banco-->
        <tr>
            <td><img src="<?php echo $admin['ADM_IMAGEM']; ?>" alt="<?php echo $admin['ADM_NOME']; ?>" width="50"></td>

            <td><?php echo $admin['ADM_ID']; ?></td>
            
            <td><?php echo $admin['ADM_NOME']; ?></td>

            <td><?php echo $admin['ADM_EMAIL']; ?></td>

            <td><?php echo ($admin['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>

            <td>
                <button type="button" id="editar" class="btn btn-success"><a href="editar_admin.php?id=<?php echo $admin['ADM_ID']; ?>">EDITAR</a></button>
                <button type="button" class="btn btn-danger"><a href="excluir_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>">EXCLUIR</a></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div id="voltar">
        <button id="btn"  type="button" class="btn btn-dark" ><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="admin_funcoes.php"> VOLTAR AO PAINEL</a></button>
    </div>
    
    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
