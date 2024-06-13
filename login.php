<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nome']) && isset($_POST['senha'])) {
  
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

 
        if (empty($nome) || empty($senha)) {
            echo "Por favor, preencha todos os campos.";
        } else {

            if ($nome === 'Princesa' && $senha === '12345678') {
                header("Location: admin.php");
                exit;
            } else {
                echo "Nome de usuário ou senha incorretos. Tente novamente.";
            }
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
