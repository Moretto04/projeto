<?php

session_start();

if (!isset($_SESSION['admin_logado'])) {
    header("location:login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link href="../visual/painel_admin/painel_adm.css" rel="stylesheet">

</head>

<body>
    
    <div id="background">
        <img src="../visual/charlie-logo.png" alt="">
        <!-- <div class="vertical"></div>   -->
        <div>
            <h2>Bem-vindo Administrador!</h2>
            <p style="text-align: center; margin-bottom: 50px;" >O que gostaria de fazer hoje?</p>
        </div>
        <div id="buttons">
            <a href="admin_funcoes.php">
                <button id="button_insert_prod" class="btn btn-dark btn2">ADMINISTRADORES</button>
            </a>

            <a href="produtos_funcoes.php">
                <button id="button_list_prod" class="btn btn-dark btn2">PRODUTOS</button>
            </a>

            <a href="categoria_funcoes.php">
                <button id="button_list_prod" class="btn btn-dark btn2">CATEGORIAS</button>
            </a>

            <a href="login.php">
                <button id="button_exit" class="btn btn-dark btn3">SAIR</button>
            </a>
        </div>
    </div>

</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>