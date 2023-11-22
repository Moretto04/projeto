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
        $stmt = $pdo->prepare("DELETE FROM ADMINISTRADOR WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "<script>alert('Administrador excluido com sucesso!'); window.location.href = 'listar_admin.php';</script>";
        } else {
            $mensagem = "<script>alert('Erro ao excluir administrador');</script>";
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
    <title>Excluir Administrador</title>
</head>

<body>
    <h2>Excluir Administrador</h2>
    <p><?php echo $mensagem; ?></p>
    <a href="listar_admin.php">Voltar à Lista de administradores</a>
</body>