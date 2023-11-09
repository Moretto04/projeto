<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - administrador </title>

    <!--page css-->
    <link rel="stylesheet" href="../visual/login/login.css">

    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


</head>
<body>
    <div style="border-radius: 20px;" class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="processa_login.php" method="post">
                <h1 style="color: white;">Login</h1>
                <input style="border-radius: 30px;" id="name" name="name" type="text" placeholder="Usuario" required />
                <input style="border-radius: 30px;" id="password" type="password" name="password" placeholder="Senha" required/>
                <button type="join" value="Join" name="btn" id="btn" style="border-radius: 30px; margin-top: 30px;">logar</button>

                <?php
                    if(isset($_GET['erro'])){
                        echo '<p style="color: red;">Nome de usuario ou senha invalido!</p>';
                    }
                ?>

            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <img src="../visual/charlie-logo.png" style="width: 100%;" alt="">
                </div>
            </div>
        </div>
    </div>



    <script src="../login/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>