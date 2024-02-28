<?php
require_once "conexao.php"; 

if (isset($_POST["placaDoc"])) {
    $placaDoc = $_POST["placaDoc"];

    $sql = "SELECT id, arquivos, descricao FROM documento_caminhao WHERE placa_documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $placaDoc);
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
        'documento_caminhao' => $documentos
    );
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'Placa não fornecida.'));
}

$conn->close();
?>