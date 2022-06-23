<?php
require("db_connect.php");
$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($connect, $sql);
//$usuarios = mysqli_fetch_array($resultado);
//var_dump($usuarios);

echo "<h5>PAINEL DE CONTROLE</h5>".
        "<table border='1'>".
            "<tr style='background-color: #00695c; color: white;'>".
                "<td>ID</td>".
                "<td>NOME</td>".
                "<td>E-MAIL</td>".
                "<td>CAPITAL INVESTIDO</td>".
                "<td>TIPO DE ACESSO</td>".
                "<td>AÇÕES</td>".
            "</tr>";
while ($dado = $resultado->fetch_array() ) {
            echo '
                <tr style="background-color: #e0f2f1;">
                    <td>'.$dado["id"].'</td>
                    <td>'.$dado["nome"].'</td>
                    <td>'.$dado["email"].'</td>
                    <td>R$ '.$dado["capital"].'</td>
                    <td>'.$dado["tipo"].'</td>
                    <td>
                        <a href="usu_editar.php?id='.$dado["id"].'"><i class="small material-icons">create</i></a> 
                        <a href="usu_excluir.php?id='.$dado["id"].'"><i class="small material-icons">delete</i></a>
                    </td>
                </tr>';
}
echo "</table>";

echo '
    <br>
    <a class="btn waves-effect waves-light green" href="cadastro_usuario.php">
    <i class="tiny material-icons">add</i>
    USUÁRIO</a>
    <a class="btn waves-effect waves-light blue" href="relatorio_transferencias.php">
    <i class="tiny material-icons">assignment</i>
    RELATÓRIO DE TRANSFERÊNCIAS</a>
    <br>';
?>