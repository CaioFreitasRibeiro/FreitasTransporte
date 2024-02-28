<?php
require_once "conexao.php";

if (isset($_POST["adicionar"])) {
    $tipocam = $_POST["tipocam"];

    $sqlSelect = "SELECT * FROM tipocaminhao WHERE tipo = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("s", $tipocam);
    $stmtSelect->execute();
    $resultado = $stmtSelect->get_result();

    if ($resultado->num_rows < 1) {
        $sqlInserir = "INSERT INTO tipocaminhao (tipo) VALUES (?)";
        $stmtInserir = $conn->prepare($sqlInserir);
        $stmtInserir->bind_param("s", $tipocam);
    
        if ($stmtInserir->execute()) {
            echo json_encode(["success" => true, "message" => "Tipo de veículo adicionada com sucesso."]);
        } else {
            echo json_encode(["success" => false, "error" => $stmtInserir->error]);
        }
        $stmtInserir->close();
        header("Location: index.php");
    } else {
        echo '<script>';
        echo 'window.location.href = "index.php";';
        echo 'alert("Profissão já foi adicionada!");';
        echo '</script>';
    }

} else if (isset($_POST["excluir"]) && isset($_POST["excluirtipocam"])) {
    $tipocamSelecionadas = $_POST["excluirtipocam"];
    $tipocamParaExcluir = implode(",", $tipocamSelecionadas);

    $sqlExcluir = "DELETE FROM tipocaminhao WHERE id IN ($tipocamParaExcluir)";

    if ($conn->query($sqlExcluir) === TRUE) {
        echo json_encode(["success" => true, "message" => "Tipo de veículo excluídas com sucesso."]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
    header("Location: index.php");
}
$conn->close();
?>