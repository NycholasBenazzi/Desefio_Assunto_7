<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: 15d_login.php');
    exit();
}

$cor_fundo = $_SESSION['cor_fundo'] ?? 'blue';
$usuario = htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <style>
        body {
            background-color: <?php echo $cor_fundo; ?>;
            color: #111;
            font-family: Arial, sans-serif;
            padding: 30px;
        }
    </style>
</head>
<body>
    <h2>Bem-vindo, <?php echo $usuario; ?>!</h2>
    <p>Seu perfil foi carregado com sucesso.</p>
    <a href="15d_logout.php">Sair</a>
</body>
</html>