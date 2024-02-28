<?php
require_once "conexao.php";

$inputValue = $_POST['inputValue'];

$sql = "SELECT placa, renavam, chassi, modelo, anofabricacao FROM caminhao WHERE placa LIKE '%$inputValue%'";
$result = $conn->query($sql);

if ($result === false) {
    die("Erro na consulta SQL: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="linha">';
            echo '<a class="botao-placa" href="/Site/Cadastro_Veiculo/index.php?Placa=' . $row['placa'] . '"> <p class="placa">' . $row['placa'] . '</p> </a>';
            echo '<div class="direita">';
                echo '<p class="renavam">' . $row['renavam'] . '</p>';
                echo '<div class="info-direita">';
                    echo '<p class="chassi">' . $row['chassi'] . '- </p>';
                    echo '<p class="modelo">' . $row['modelo'] . '- </p>';
                    echo '<p class="ano">' . $row['anofabricacao'] . '</p>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="linha-falhou">Nenhum resultado encontrado.</div>';
}

$conn->close();
?>
