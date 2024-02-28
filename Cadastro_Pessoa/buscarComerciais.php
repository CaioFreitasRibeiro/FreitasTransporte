<?php
require_once "conexao.php";

if (isset($_POST["cpfCom"])) {
    $cpfCom = $_POST["cpfCom"];

    $sql = "SELECT id_comerciais,  nome_comercial, telefone_comercial FROM ref_comerciais WHERE cpf_comercial = ? ORDER BY id_comerciais";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpfCom);
    $stmt->execute();
    $result = $stmt->get_result();

    $referencias_comerciais = array();

    while ($row_comercial = $result->fetch_assoc()) {
        $referencias_comerciais[] = $row_comercial;
    }

    $stmt->close();

    $response = array(
        'referencias_comerciais' => $referencias_comerciais
    );
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'CPF não fornecido.'));
}
$conn->close();
?>