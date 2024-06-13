<?php
include 'conexao.php';

// Inicializa variáveis para pesquisa
$termo_pesquisa = "";

// Processa o formulário de pesquisa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $termo_pesquisa = $conn->real_escape_string($_POST['termo_pesquisa']);
}

// Consulta SQL para buscar as inscrições
$sql = "SELECT * FROM candidaturas";

// Aplica o filtro de pesquisa, se houver
if (!empty($termo_pesquisa)) {
    $sql .= " WHERE nome = '$termo_pesquisa' OR email = '$termo_pesquisa' OR telefone = '$termo_pesquisa' OR id = '$termo_pesquisa'";
}


$result = $conn->query($sql);

// Função para aprovar uma inscrição
function aprovarInscricao($conn, $id) {
    $sql = "UPDATE candidaturas SET status = 'Aprovada' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Função para eliminar uma inscrição
function eliminarInscricao($conn, $id) {
    $sql = "DELETE FROM candidaturas WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Processa ação de aprovar ou eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aprovar'])) {
        $id = $_POST['id'];
        if (aprovarInscricao($conn, $id)) {
            echo "<script>alert('Inscrição aprovada com sucesso!');</script>";
            echo "<script>window.location.replace('admin.php');</script>";
        } else {
            echo "<script>alert('Erro ao aprovar a inscrição.');</script>";
        }
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id'];
        if (eliminarInscricao($conn, $id)) {
            echo "<script>alert('Inscrição eliminada com sucesso!');</script>";
            echo "<script>window.location.replace('admin.php');</script>";
        } else {
            echo "<script>alert('Erro ao eliminar a inscrição.');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Inscrições</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        form {
            display: inline;
            margin-right: 5px;
        }
        form button {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Painel de Administração - Inscrições</h1>
        <nav>
            <ul>
                <li><a href="#">Inscrições</a></li>
                <li><a href="login.html">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="controles">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <select name="tipo_pesquisa">
                    <option value="nome">Nome</option>
                    <option value="id">ID</option>
                    <option value="email">Email</option>
                    <option value="telefone">Telefone</option>
                </select>
                <input type="text" name="termo_pesquisa" placeholder="Pesquisar por nome, ID, email ou telefone" value="<?php echo $termo_pesquisa; ?>">
                <button type="submit">Pesquisar</button>
            </form>
        </section>

        <section id="inscricoes">
            <h2>Todas as Inscrições</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Curso</th>
                    <th>Mensagem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['telefone'] . "</td>";
                        echo "<td>" . $row['curso'] . "</td>";
                        echo "<td>" . $row['mensagem'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>";
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='aprovar' onclick=\"return confirm('Deseja realmente aprovar esta inscrição?')\">Aprovar</button>";
                        echo "</form>";
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='eliminar' onclick=\"return confirm('Deseja realmente eliminar esta inscrição?')\">Eliminar</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhuma inscrição encontrada.</td></tr>";
                }
                ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Escola 30 de Setembro. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
