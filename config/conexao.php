<?php

//CONFIGURAÇÃO BANCO DE DADOS

$host = '144.22.157.228';
$db = 'Charlie';
$user = 'Charlie';
$pass = 'Charlie';
$charset = 'utf8mb4';   

//especificando qual tipo de banco de dados ira ser usado
$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // nome do banco de dados (driver)


//CRIANDO A CONEXÃO COM O BANCO DE DADOS ATRAVES DO PDO

try{ //try analisa se existe algum erro nesta intrucao
$pdo = new PDO ($dsn, $user, $pass);//criando a conexao com o banco de dados atraves de pdo
}catch (PDOException $e){// Se houver erro ira captura-lo e trata-lo
    echo "Erro ao tentar conectar com o banco de dados <p> ".$e;
} 

?>
