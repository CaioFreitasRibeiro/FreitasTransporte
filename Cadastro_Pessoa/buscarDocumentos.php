<?php
require_once "conexao.php"; 

if (isset($_POST["cpfDoc"])) {
    $cpfDoc = $_POST["cpfDoc"];

    $sql = "SELECT id_documentos, arquivos, descricao FROM documentos WHERE cpf_documentos = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpfDoc);
    $stmt->execute();
    $result = $stmt->get_result();

    $documentos = array();
    if($result->num_rows > 0) {
        while ($row_documento = $result->fetch_assoc()) {
            $documentos[] = $row_documento;
        }
    }

    $stmt->close();

    $response = array(
        'documentos' => $documentos
    );
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'CPF não fornecido.'));
}

$conn->close();
?>