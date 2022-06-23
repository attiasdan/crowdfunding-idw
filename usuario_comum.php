<?php $sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($connect, $sql);
$dado = $resultado->fetch_array();

echo '<h4>Bem vindo(a), '.$dado["nome"].'!</h4>';

echo '<hr>';
echo '<h5><b>Capital aplicado:</b> R$ '.$dado["capital"].'</h5>';

echo '<br><a class="btn waves-effect waves-light" href="deposito_usuario.php?id='.$dado["id"].'"><i class="small material-icons">add</i>DEPÓSITO</a><br>';

echo '<br><br><br><br><h5><b>Propósito do fundo:</b><br>
Aumentar o patrimônio dos <i>stakeholders</i>.</h5>
<br><br><br><br><br><br>';