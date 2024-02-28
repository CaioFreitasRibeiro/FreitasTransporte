<?php
require_once "conexao.php";

$sqlBuscarProfissoes = "SELECT id, tipo FROM profissoes";
$resultProfissoes = $conn->query($sqlBuscarProfissoes);

$profissoes = array();
if ($resultProfissoes->num_rows > 0) {
    while ($row = $resultProfissoes->fetch_assoc()) {
        $profissoes[] = $row;
    }
}

echo json_encode(["profissoes" => $profissoes]);

$conn->close();
?>