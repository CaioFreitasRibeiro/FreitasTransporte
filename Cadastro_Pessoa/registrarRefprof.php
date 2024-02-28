<?php
require_once "conexao.php";

if (isset($_POST["adicionarProfissional"])) {
    $telefoneProfissional = isset($_POST["telefone-prof"]) ? trim($_POST["telefone-prof"]) : "";
    $empresaProfissional = isset($_POST["empresa"]) ? trim($_POST["empresa"]) : "";
    $cpfProfissional = isset($_POST["cpfProf"]) ? $_POST["cpfProf"] : "";

    $sql = "INSERT INTO ref_profissionais (telefone, nome_empresa, cpf_empresa) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $telefoneProfissional, $empresaProfissional, $cpfProfissional);

    if ($stmt->execute()) {
        echo '<script>';
        echo 'window.location.href = "index.php";';
        echo 'alert("Referencia profissional adicionada com sucesso!");';
        echo '</script>';
    } else {
        echo "Erro ao registrar a referência profissional: " . $stmt->error;
    }
    $stmt->close();
    header("Location: index.php?cpf=$cpfProfissional#referencias-profissionais");
} else if (isset($_POST["excluirProfissional"]) && isset($_POST["excluirReferenciasProfissionais"])) {
    $cpfProfissional = isset($_POST["cpfProf"]) ? $_POST["cpfProf"] : "";

    $ProfissionaisSelecionadas = $_POST["excluirReferenciasProfissionais"];
    $ProfissionaisParaExcluir = implode(",", $ProfissionaisSelecionadas);

    $sqlExcluir = "DELETE FROM ref_profissionais WHERE id_profissional IN ($ProfissionaisParaExcluir)";

    if ($conn->query($sqlExcluir) === TRUE) {
        echo json_encode(["success" => true, "message" => "Comerciais excluídas com sucesso."]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
    header("Location: index.php?cpf=$cpfProfissional");
}

$conn->close();
exit();
?>
