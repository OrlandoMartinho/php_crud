<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escola30setembro";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


?>
