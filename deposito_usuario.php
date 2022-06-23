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
$sql = "SELECT * FROM usuarios WHERE id = '$idUsuario'";

$resul = mysqli_query($connect, $sql);

$dado = mysqli_fetch_array($resul);

if(isset($_POST['enviar'])) {
    $add = $_POST['capital'] + $dado['capital'];
    $capital = mysqli_escape_string($connect, $add);
    
    $sql = "UPDATE usuarios SET capital = '$capital' WHERE id = '$idUsuario'";
    $resultado = mysqli_query($connect, $sql);

    // Registrando na table 'transferencias':
    $tipo = "Depósito";
    $dataOperacao = date('d/m/Y \à\s H:i:s');
    $valor = mysqli_escape_string($connect, $_POST['capital']);

    $sql = "INSERT INTO transferencias (idUsuario, valor, tipo, dataOperacao) VALUES ('$idUsuario', '$valor', '$tipo', '$dataOperacao')";
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
            <h4>DEPÓSITO</h4>
            <?php
            echo '
            <form action="" method="post">
                <label for="fcapital">Valor do depósito:</label><br>
                <input type="text" id="lcapital" name="capital" placeholder="R$" value=""><br>
                <br>
                <button class="btn waves-effect waves-light green" type="submit" name="enviar">CONFIRMAR DEPÓSITO</button>
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