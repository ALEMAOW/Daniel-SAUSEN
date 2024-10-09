<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($senha !== $confirma_senha) {
            echo "As senhas não coincidem.";
        exit;
    }

    $servername = "localhost"; 
    $username = "seu_usuario";
    $password = "sua_senha";
    $dbname = "seu_banco_de_dados";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO clientes (nome, sobrenome, email, telefone, data_nascimento, senha) VALUES (?, ?, ?, ?, ?, ?)");
    $hashed_senha = password_hash($senha, PASSWORD_DEFAULT); 
    $stmt->bind_param("ssssss", $nome, $sobrenome, $email, $telefone, $data_nascimento, $hashed_senha);

    if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
    } else {
            echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
