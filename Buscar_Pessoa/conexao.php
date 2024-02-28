<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "dbfreitastransporte";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>