<?php
require_once "conexao.php"; 

$placa = $_POST['placa'];

$sql = "SELECT foto FROM caminhao WHERE placa = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$placa]);
$result = $stmt->fetch();

$imagem_blob = $result['foto'];

$stmt->close();
$conn->close();
?>