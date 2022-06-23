<?php

require("config.php");
//Cookie contador de visitas:
//include_once("cookie_contador_de_visitas.php");

//Conexão banco de dados
require("db_connect.php");

//Sessão:
session_start();

///Verificar email:
if(isset($_POST['btn-entrar'])) {
    $erros = array();
    $email = mysqli_escape_string($connect, $_POST['email']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);

    if(empty($email) or empty($senha))
    {
        $erros[] = "( ! ) O campo email/senha precisa ser preenchido ( ! )";
        
    } else {
        $sql = "SELECT email FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($connect, $sql);

        if(mysqli_num_rows($resultado) > 0) {
            //porque existe algum registro no $resultado

            $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
            $resultado = mysqli_query($connect, $sql);

            if(mysqli_num_rows($resultado) == 1)
            {
                $dados = mysqli_fetch_array($resultado);
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: painel.php');
            } else {
                $erros[] = "<li> Usuário e senha não conferem </li>";
            }
            
        } else {
            $erros[] = "<li> Usuário inexistente </li>";
        }
        //fechar conexão com banco de dados:
        mysqli_close($connect);
    }//endelse
}//endif
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?=$app?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
    .footer {
        position:absolute;
        bottom:0;
        width:100%;
        /* superior | direita | inferior | esquerda */
        padding: 8px 0 8px 0;
    }
    </style>
</head>
<body>
    <?php include("templates/header.php");?>
    <div class="row">
        <div class="col s2"></div>
        <div class="col s4">
            <div class="card">
                <div class="card-image">
                <img src="assets/img/Crowfunding.jpg">
                </div>
                <div class="card-content">
                <p>Também conhecido como vaquinha online, é um financiamento coletivo, onde as pessoas podem ajudar na arrecadação de dinheiro para uma causa ou projeto no qual tem interesse.</p>
                </div>
            </div>    
        </div>
    
      <div class="col s1"></div>
      <div class="col s3">
        <?php
        if(!empty($erros))
        {
            foreach($erros as $erro) echo $erro;
        }
        ?>
        <h4>Login de Usuário</h4>
        <br>
        <form action="" method="post">
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email"><br>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha"><br>

            <input class="btn waves-effect waves-light" type="submit" value="ENTRAR" name="btn-entrar">
        </form>

      </div>
      <div class="col s3"></div>
    </div><!--row-->
    <!-- <a href="cadastro_usuario.php"><h3>Cadastro de Usuário</h3></a> -->
    <!--<a href="cadastro_fornecedor.php"><h3>Cadastro de Fornecedor</h3></a>-->
    
    <?php include("templates/footer.php");?>
</body>
</html>