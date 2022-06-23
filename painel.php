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
        *{margin:0;}
        body{
            background-color: #e1f5fe;
            padding:0;
        }
        .footer {
            position: relative;
            bottom: 0;
            margin-bottom: 0;
            /* superior | direita | inferior | esquerda */
            padding: 8px 0 8px 0;
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
            //se o usuario for 'admin', logo tem acesso privilegiado, então dar direitos de modificações.
            $email = $dados['email'];
            $sql = "SELECT * FROM usuarios WHERE email = '$email' AND tipo = 'admin'";
            
            $resul = mysqli_query($connect, $sql);

            $admin = mysqli_num_rows($resul) > 0;//boolean

            if ($admin) {
                include("usuario_admin.php");
            }
            else {//não é admin - é user normal
                include("usuario_comum.php");
            }
            ?>

            <!-- ideia de colocar cookie para que o js saiba que um user é o não admin -->
            <?php
            // $cookie_name = "user";
            // $cookie_value = "John Doe";
            // setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

            // if(!isset($_COOKIE[$cookie_name])) {
            //     echo "Cookie named '" . $cookie_name . "' is not set!";
            // } else {
            //     echo "Cookie '" . $cookie_name . "' is set!<br>";
            //     echo "Value is: " . $_COOKIE[$cookie_name];
            // }
            ?>


            <?php
            //    while($dado = $resultado->fetch_array()) {
            //      $usuarios[] = $dado;
            //    };
            //    echo count($usuarios);//4 registros atualmente;
            ?>
    
            
            <br>
            <a class="btn waves-effect waves-light red" href="logout.php"><i class="tiny material-icons">exit_to_app</i> Finalizar sessão</a>
        </div>
        <div class="col s1"></div>
    </div>

    <?php include("templates/footer.php");?>
</body>
</html>