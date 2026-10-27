<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: 15d_perfil.php');
    exit();
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $cor_fundo = $_POST['cor_fundo'] ?? 'blue';

    $coresPermitidas = [
        'blue' => 'Azul',
        'red' => 'Vermelho',
        'green' => 'Verde',
        'yellow' => 'Amarelo',
        'purple' => 'Roxo',
        'gray' => 'Cinza'
    ];

    if (!array_key_exists($cor_fundo, $coresPermitidas)) {
        $cor_fundo = 'blue';
    }

    $servername = 'localhost';
    $username = 'root';
    $password = 'Senai@118';
    $dbname = 'exercicio';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Falha na conexão com o banco de dados: ' . $conn->connect_error);
    }

    $sql = 'SELECT usuario FROM usuarios WHERE usuario = ? AND senha = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $usuario, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['cor_fundo'] = $cor_fundo;

        header('Location: 15d_perfil.php');
        exit();
    }

    $mensagem = '<p style="color: red;">Usuário ou senha incorretos!</p>';

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <form method="post" action="">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>

        <label for="cor_fundo">Cor de fundo:</label>
        <select name="cor_fundo" id="cor_fundo">
            <option value="blue">Azul</option>
            <option value="red">Vermelho</option>
            <option value="green">Verde</option>
            <option value="yellow">Amarelo</option>
            <option value="purple">Roxo</option>
            <option value="gray">Cinza</option>
        </select><br><br>

        <button type="submit">Entrar</button>
    </form>

    <?php echo $mensagem; ?>
</body>
</html>