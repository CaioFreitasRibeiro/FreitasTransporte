<?php
require_once "conexao.php";

$sqlBuscartipocam = "SELECT id, tipo FROM tipocaminhao";
$resulttipocam = $conn->query($sqlBuscartipocam);

$tipocam = array();
if ($resulttipocam->num_rows > 0) {
    while ($row = $resulttipocam->fetch_assoc()) {
        $tipocam[] = $row;
    }
}

echo json_encode(["tipocam" => $tipocam]);

$conn->close();
?>