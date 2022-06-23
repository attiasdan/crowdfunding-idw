<!-- DESATUALIZADO - FAZER ATUALIZAÇÃO -->
<?php
//Conexão banco de dados
require_once("db_connect.php");

//Sessão:
session_start();

//Verificar cadastro:
if(isset($_POST['submit']))
{
  $erros = array();
  $nome = mysqli_escape_string($connect, $_POST['nome']);
  $email = mysqli_escape_string($connect, $_POST['email']);
  $dnasc = mysqli_escape_string($connect, $_POST['dnascimento']);
  $senha = mysqli_escape_string($connect, $_POST['senha']);
  $confirmarSenha = mysqli_escape_string($connect, $_POST['confirmarSenha']);

  //verificar se não ficou nenhum campo obrigatório vazio e erros gerais:
  if(empty($nome) or empty($senha) or empty($email) or empty($dnasc) or empty($confirmarSenha))
  {
    if(empty($nome))
     $erros[] = "<li> Campo 'Nome' está vazio. </li>";

    if(empty($email))
     $erros[] = "<li> Campo 'E-mail' está vazio. </li>";

    if(empty($dnasc))
     $erros[] = "<li> Campo 'Data de nascimento' está vazio. </li>";

    if(empty($senha))
     $erros[] = "<li> Campo 'Senha' está vazio. </li>";

    if(empty($confirmarSenha))
     $erros[] = "<li> Campo 'Confirmar Senha' está vazio. </li>";
    
    //valores nos campos 'senha' && 'confirmarSenha' são iguais?
    if($senha !== $confirmarSenha)
     $erros[] = "<li> Os valores nos campos 'senha' e 'confirmarSenha' têm que ser iguais. </li>";
    
    //verifica se o usuário já existe, se existir retornar com erro:
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($connect, $sql);
    if(mysqli_num_rows($resultado) > 0) {
      //encontrou registro de usuario, então não permitir cadastro
      $erros[] = "<li> <b>".mysqli_fetch_array($resultado)['nome']."</b>, você já possui cadastro. </li>";
    }
  }
  else {//se nenhum erro
    $sql = "INSERT INTO usuarios (nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$dnasc', '$senha')";
    $resultado = mysqli_query($connect, $sql);
    
    //só pra exibir o nome na pagina painel:
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($connect, $sql);
    $dados = mysqli_fetch_array($resultado);
    $_SESSION['id_usuario'] = $dados['id'];
    //usuário cadastrado com sucesso, então redireciona:
    $_SESSION['logado'] = true;
    header('Location: painel.php');
  }
  //fechar conexão com banco de dados:
  mysqli_close($connect);
}//endif(isset($_POST['submit']))
?>

<html>
<head>
    <title>Cadastro Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <h2 class="title">Cadastro Usuário</h2>

    <?php
    if(!empty($erros))
    {
        foreach($erros as $erro) echo $erro;
    }
    ?>
    <p>Prezado(a) usuário, preencha com seus dados:</p>

    <form action="" method="post">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"><br>

        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email"><br>

        <label for="dnascimento">Data de nascimento:</label>
        <input type="date" id="dnascimento" name="dnascimento"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha"><br>

        <label for="confirmarSenha">Confirmar Senha:</label>
        <input type="password" id="confirmarSenha" name="confirmarSenha"><br>

        <input type="reset" value="Limpar" name="limpar">
        <input type="submit" value="Cadastrar" name="submit">
        
    </form>
</body>
</html>