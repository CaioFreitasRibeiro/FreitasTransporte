<?php
require_once "conexao.php";

if(isset($_POST["adicionarComercial"])){
    $nomeComercial = isset($_POST["nome-com"]) ? trim($_POST["nome-com"]): "";
    $telefoneComercial = isset($_POST["Telefone-com"]) ? trim($_POST["Telefone-com"]): "";
    $cpfComercial = isset($_POST["cpfCom"]) ? $_POST["cpfCom"]:"";
    
    $sql = "INSERT INTO ref_comerciais (nome_comercial, telefone_comercial, cpf_comercial) 
            VALUES ('$nomeComercial', '$telefoneComercial', '$cpfComercial')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>';
        echo 'window.location.href = "index.php";';
        echo 'alert("Referencia comercial adicionada com sucesso!");';
        echo '</script>';
    } else {
        echo "Erro ao registrar a referência comercial: " . $conn->error;
    }
    header("Location: index.php?cpf=$cpfComercial#referencias-comerciais");
} else if (isset($_POST["excluirComercial"]) && isset($_POST["excluirReferenciasComerciais"])) {
    $cpfComercial = $_POST["cpfCom"];

    $ComerciaisSelecionadas = $_POST["excluirReferenciasComerciais"];
    $ComerciaisParaExcluir = implode(",", $ComerciaisSelecionadas);

    $sqlExcluir = "DELETE FROM ref_comerciais WHERE id_comerciais IN ($ComerciaisParaExcluir)";

    if ($conn->query($sqlExcluir) === TRUE) {
        echo json_encode(["success" => true, "message" => "Comerciais excluídas com sucesso."]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
    header("Location: index.php?cpf=$cpfComercial");
}

$conn->close();
exit();
?>