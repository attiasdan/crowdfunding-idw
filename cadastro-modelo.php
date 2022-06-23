<?php

require("config.php");
//Está é uma página RESTRITA (só pode ser vista quando está logado)

//Conexão com banco de dados
require("db_connect.php");

//Sessão
session_start();

//Verificação para proibir acesso não permitido:
if(!isset($_SESSION['logado'])) {
    header('Location: index.php');
}

//Dados
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM usuarios WHERE id = '$id';";
$resultado = mysqli_query($connect, $sql); //enviar comando SQL para o SGBD
$dados = mysqli_fetch_array($resultado); //todos os dados do usuário com o $id


$idUsuario = $_GET['id'];
if(isset($_POST['enviar'])) {
    $nome = mysqli_escape_string($connect, $_POST['nome']);
    $email = mysqli_escape_string($connect, $_POST['email']);
    $capital = mysqli_escape_string($connect, $_POST['capital']);
    $tipo = mysqli_escape_string($connect, $_POST['tipo']);

    $sql = "UPDATE usuarios
            SET
            nome = '$nome',
            email = '$email',
            capital = '$capital',
            tipo = '$tipo'
            WHERE id = '$idUsuario'";
    $resultado = mysqli_query($connect, $sql);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - <?=$app?></title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body{
            background-color: #e1f5fe;
        }
        .footer {
            position:absolute;
            bottom:0;
            width:100%;
        }
    </style>
</head>
<body>
    <?php include("templates/header.php");?>
    <div class="row">
        <div class="col s1"></div>
        <div class="col s10">
        
            <?php
            $sql = "SELECT * FROM usuarios WHERE id = '$idUsuario'";
            
            $resul = mysqli_query($connect, $sql);

            $dado = mysqli_fetch_array($resul);//boolean

            echo '
            <form action="" method="post">
                <label for="fname">Nome:</label><br>
                <input type="text" id="fname" name="nome" value="'.$dado["nome"].'"><br>
                <label for="femail">E-mail:</label><br>
                <input type="text" id="lname" name="email" value="'.$dado["email"].'"><br>
                <label for="fcapital">Capital:</label><br>
                <input type="text" id="lname" name="capital" value="'.$dado["capital"].'"><br>
                <label for="ftipo">Tipo:</label><br>
                <input type="text" id="lname" name="tipo" value="'.$dado["tipo"].'"><br>
                <br>
                <input class="btn waves-effect waves-light" type="submit" name="enviar" value="Confirmar alterações">
            </form>';
            ?>

            <br>
            <a href="painel.php">Voltar</a>
        </div>
        <div class="col s1"></div>
    </div>

    <?php include("templates/footer.php");?>
</body>
</html>