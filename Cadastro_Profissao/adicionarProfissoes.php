<?php
require_once "conexao.php";

if (isset($_POST["adicionar"])) {
    $profissao = $_POST["profissao"];

    $sqlSelect = "SELECT * FROM profissoes WHERE tipo = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("s", $profissao);
    $stmtSelect->execute();
    $resultado = $stmtSelect->get_result();

    if ($resultado->num_rows < 1) {
        $sqlInserir = "INSERT INTO profissoes (tipo) VALUES (?)";
        $stmtInserir = $conn->prepare($sqlInserir);
        $stmtInserir->bind_param("s", $profissao);
    
        if ($stmtInserir->execute()) {
            echo json_encode(["success" => true, "message" => "Profissão adicionada com sucesso."]);
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

} else if (isset($_POST["excluir"]) && isset($_POST["excluirProfissoes"])) {
    $profissoesSelecionadas = $_POST["excluirProfissoes"];
    $profissoesParaExcluir = implode(",", $profissoesSelecionadas);

    $sqlExcluir = "DELETE FROM profissoes WHERE id IN ($profissoesParaExcluir)";

    if ($conn->query($sqlExcluir) === TRUE) {
        echo json_encode(["success" => true, "message" => "Profissões excluídas com sucesso."]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
    header("Location: index.php");
}
$conn->close();
?>