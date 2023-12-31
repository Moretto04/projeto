<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

require_once('../config/conexao.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM PRODUTOS WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "<script>alert('Produto excluido com sucesso!'); window.location.href = 'listar_produtos.php';</script>";
        } else {
            $mensagem = "<script>alert('Erro ao excluir produto');</script>";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Excluir Produto</title>
</head>

<body>
    <h2>Excluir Produto</h2>
    <p><?php echo $mensagem; ?></p>
    <a href="listar_produtos.php">Voltar à Lista de Produtos</a>
</body>

</html>