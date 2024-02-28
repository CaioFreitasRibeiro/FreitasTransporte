<?php
require_once "conexao.php"; 

$cpf = $_POST['cpf']; // Suponha que você tenha recebido o CPF do usuário através de um formulário POST

$sql = "SELECT foto FROM funcionarios WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$cpf]);
$result = $stmt->fetch();

$imagem_blob = $result['foto'];

$stmt->close();
$conn->close();
?>