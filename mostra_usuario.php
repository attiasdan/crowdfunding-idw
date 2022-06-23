<html>
<head>
    <title>Mostra Usuário</title>
</head>
<body>
<?php
$nome = $_POST['nome'];
$dnascimento = $_POST['dnascimento'];
$email = $_POST['email'];

echo 'Confira os seus dados<br>';
echo 'Nome: '.$nome.'<br>';
echo 'E-mail: '.$email.'<br>';
echo 'Data de nascimento: '.$dnascimento.'<br>';
?>
</body>
</html>