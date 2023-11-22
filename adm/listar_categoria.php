<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT CATEGORIA.*,CATEGORIA_ID, CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO FROM CATEGORIA ORDER BY CATEGORIA_ID");
    $stmt->execute();
    $categoria = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Lista de Categorias</title>

</head>

<body>
    <h2>Lista de Categorias</h2>
    <div id="logo">
        <a id="logo" href="categoria_funcoes.php"><img src="../visual/charlie-logo.png" style="width: 40%;" alt=""></a>
    </div>
    <table  class="table table-hover table-striped-columns">
        <tr>
            <th>ID</th> 
            <th>NOME</th> 
            <th>DESC</th>
            <th>ATIVO</th>
            <th>AÇÕES</th>
            
        </tr>
        
        <?php foreach($categoria as $categoria): ?> <!--aq ele esta se referindo as infos do banco-->
        <tr>
            <td><?php echo $categoria['CATEGORIA_ID']; ?></td>
            
            <td><?php echo $categoria['CATEGORIA_NOME']; ?></td>

            <td><?php echo $categoria['CATEGORIA_DESC']; ?></td>

            <td><?php echo ($categoria['CATEGORIA_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>

            <td>
                <button type="button" id="editar" class="btn btn-success"><a href="editar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>">EDITAR</a></button>
                <button type="button" class="btn btn-danger"><a href="excluir_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>">EXCLUIR</a></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div id="voltar">
        <button id="btn"  type="button" class="btn btn-dark" ><i class="fa-solid fa-arrow-left" style="color: #ff0000;"></i><a href="categoria_funcoes.php"> VOLTAR AO PAINEL</a></button>
    </div>
    
    <script src="https://kit.fontawesome.com/60bef82a49.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
