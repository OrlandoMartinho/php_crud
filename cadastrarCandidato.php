<?php

include 'conexao.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $curso = $conn->real_escape_string($_POST['curso']);
    $mensagem = $conn->real_escape_string($_POST['mensagem']);


    $sql = "INSERT INTO candidaturas (nome, email, telefone, curso, mensagem) VALUES ('$nome', '$email', '$telefone', '$curso', '$mensagem')";

    if ($conn->query($sql) === TRUE) {
        echo "Candidatura enviada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
