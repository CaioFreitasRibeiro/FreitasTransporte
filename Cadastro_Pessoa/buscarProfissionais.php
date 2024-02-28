<?php
require_once "conexao.php";

if (isset($_POST["cpfProf"])) {
    $cpfProf = $_POST["cpfProf"];

    $sql = "SELECT id_profissional, telefone, nome_empresa FROM ref_profissionais WHERE cpf_empresa = ? ORDER BY id_profissional";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpfProf);
    $stmt->execute();
    $result = $stmt->get_result();

    $referencias_profissionais = array();

    while ($row_profissional = $result->fetch_assoc()) {
        $referencias_profissionais[] = $row_profissional;
    }

    $stmt->close();

    $response = array(
        'referencias_profissionais' => $referencias_profissionais
    );
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'CPF não fornecido.'));
}
$conn->close();
?>