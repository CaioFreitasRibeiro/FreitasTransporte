<?php
require_once "conexao.php";

$tipoPesquisa = $_POST['tipoPesquisa'];
$inputValue = $_POST['inputValue'];

switch ($tipoPesquisa) {
    case "cpf":
        $colunaPesquisa = "cpf";
        break;
    case "nome":
        $colunaPesquisa = "nome_funcionarios";
        break;
    case "registro":
        $colunaPesquisa = "registro";
        break;
    default:
        break;
}

$sql = "SELECT cpf, nome_funcionarios, registro, uf, tipo FROM funcionarios WHERE $colunaPesquisa LIKE '%$inputValue%'";
$result = $conn->query($sql);

if ($result === false) {
    die("Erro na consulta SQL: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="linha">';
            echo '<a class="botao-cpf" href="/Site/Cadastro_Pessoa/index.php?cpf=' . $row['cpf'] . '"> <p class="cpf">' . $row['cpf'] . '</p> </a>';
            echo '<div class="direita">';
                echo '<p class="nome">' . $row['nome_funcionarios'] . '</p>';
                echo '<div class="info-direita">';
                    echo '<p class="registro">' . $row['registro'] . '- </p>';
                    echo '<p class="uf">' . $row['uf'] . '</p>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="linha-falhou">Nenhum resultado encontrado.</div>';
}

$conn->close();
?>
