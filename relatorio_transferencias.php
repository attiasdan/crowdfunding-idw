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
// $sql = "SELECT * FROM transferencias;";
// $resultado = mysqli_query($connect, $sql); //enviar comando SQL para o SGBD
// $dados = mysqli_fetch_array($resultado); //todos os dados do usuário com o $id

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RELATÓRIO DE TRANSFERÊNCIAS - <?=$app?></title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        @media print {
            * {
                visibility:hidden;
            }
            #yesprint {
                visibility:visible;
                position: absolute;
                top:0;
                left:0;                                     
            }                                  
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col s1"></div>
        <div class="col s10" id="yesprint">
        
            <?php
            $sql = "SELECT * FROM transferencias";
            $resul = mysqli_query($connect, $sql);
            //$dado = mysqli_fetch_array($resul);

            echo "<h5>RELATÓRIO DE TRANSFERÊNCIAS</h5>".
                "<table border='1'>".
                    "<tr style='background-color: #00695c; color: white;'>".
                        "<td>idTransferência</td>".
                        "<td>idUsuario</td>".
                        "<td>valor</td>".
                        "<td>tipoOperação</td>".
                        "<td>dataOperação</td>".
                    "</tr>";
                while ($dado = $resul->fetch_array() ) {
                            echo '
                                <tr style="background-color: #e0f2f1;">
                                    <td>'.$dado["idTransferencia"].'</td>
                                    <td>'.$dado["idUsuario"].'</td>
                                    <td>'.$dado["valor"].'</td>
                                    <td>'.$dado["tipo"].'</td>
                                    <td>'.$dado["dataOperacao"].'</td>
                                </tr>';
                }
                echo "</table>";

            ?>
        </div>
        <div class="col s1">
        </div>
    </div>
    <div class="row">
        <button class="btn waves-effect waves-light orange" onclick="window.print()"><i class="tiny material-icons">print</i> IMPRIMIR</button>
        
    </div>

</body>
</html>