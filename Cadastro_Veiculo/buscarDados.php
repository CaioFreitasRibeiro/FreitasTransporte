<?php
require_once "conexao.php";

if (isset($_POST['placa'])) {
    $placa = $_POST['placa'];

    $sql_caminhao = "SELECT c.placa, c.modelo, c.renavam, c.chassi, c.anofabricacao, c.foto, c.datacompra, c.valorcompra, 
                    c.cor, t.tipo as tipo_caminhao, c.tipocombustivel, c.alturaIN, c.larguraIN, c.comprimentoIN, c.alturaEX, c.larguraEX, 
                    c.comprimentoEX FROM caminhao c
                    LEFT JOIN tipocaminhao t ON t.id = c.tipocaminhao WHERE c.placa = ?";
    $stmt_caminhao = $conn->prepare($sql_caminhao);
    $stmt_caminhao->bind_param("s", $placa);
    $stmt_caminhao->execute();
    $result_caminhao = $stmt_caminhao->get_result();

    $data = array();

    if ($result_caminhao->num_rows > 0) {
        $data['exists'] = true;
        $row_caminhao = $result_caminhao->fetch_assoc();
        $data['placa'] = $row_caminhao['placa'];
        $data['modelo'] = $row_caminhao['modelo'];
        $data['renavam'] = $row_caminhao['renavam'];
        $data['chassi'] = $row_caminhao['chassi'];
        $data['anofabricacao'] = $row_caminhao['anofabricacao'];
        $data['foto'] = $row_caminhao['foto'];
        $data['datacompra'] = $row_caminhao['datacompra'];
        $data['valorcompra'] = $row_caminhao['valorcompra'];
        $data['cor'] = $row_caminhao['cor'];
        $data['tipocaminhao'] = $row_caminhao['tipo_caminhao'];
        $data['tipocombustivel'] = $row_caminhao['tipocombustivel'];
        $data['altura'] = $row_caminhao['alturaIN'];
        $data['largura'] = $row_caminhao['larguraIN'];
        $data['comprimento'] = $row_caminhao['comprimentoIN'];
        $data['alturaEx'] = $row_caminhao['alturaEX'];
        $data['larguraEx'] = $row_caminhao['larguraEX'];
        $data['comprimentoEx'] = $row_caminhao['comprimentoEX'];
    } else {
        $data['exists'] = false;
        $data['error'] = "Nenhum registro encontrado.";
    }

    echo json_encode($data);
    
    $stmt_caminhao->close();
} else {
    $data['exists'] = false;
    $data['error'] = "Placa não especificada.";
    echo json_encode($data);
}

$conn->close();
?>