<?php
require_once "conexao.php";
$cpf = $_POST['cpf'];

$sql_funcionario = "SELECT f.registro, f.nome_funcionarios, f.tipo, f.rua, f.bairro, f.cidade, f.uf, f.cep, f.foto, p.tipo AS tipo_profissao 
                    FROM funcionarios f
                    LEFT JOIN profissoes p ON f.tipo = p.id
                    WHERE f.cpf = ?";
$stmt_funcionario = $conn->prepare($sql_funcionario);
$stmt_funcionario->bind_param("s", $cpf);
$stmt_funcionario->execute();
$result_funcionario = $stmt_funcionario->get_result();

$data = array();

if ($result_funcionario->num_rows > 0 ) {
    $data['exists'] = true;
    $row_funcionario = $result_funcionario->fetch_assoc();
    $data['registro'] = $row_funcionario['registro'];
    $data['tipo'] = $row_funcionario['tipo_profissao'];
    $data['nome'] = $row_funcionario['nome_funcionarios'];
    $data['rua'] = $row_funcionario['rua'];
    $data['bairro'] = $row_funcionario['bairro'];
    $data['cidade'] = $row_funcionario['cidade'];
    $data['uf'] = $row_funcionario['uf'];
    $data['cep'] = $row_funcionario['cep'];
    $data['foto'] = $row_funcionario['foto'];
    
    if ($row_funcionario['tipo'] === "Motorista") {
        $sql_motorista = "SELECT registro_habilitacao, data_primeira_habilitacao, tipo_habilitacao, data_validade_habilitacao 
                          FROM motoristas WHERE cpf_motoristas = ?";
        $stmt_motorista = $conn->prepare($sql_motorista);
        $stmt_motorista->bind_param("s", $cpf);
        $stmt_motorista->execute();
        $result_motorista = $stmt_motorista->get_result();
        
        if ($result_motorista->num_rows > 0) {
            $row_motorista = $result_motorista->fetch_assoc();
            $data["registro_habilitacao"] = $row_motorista["registro_habilitacao"];
            $data["data_primeira_habilitacao"] = $row_motorista["data_primeira_habilitacao"];
            $data["data_validade_habilitacao"] = $row_motorista["data_validade_habilitacao"];
        }
        $stmt_motorista->close();
    }

    $sql_habilitacoes = "SELECT tipo_habilitacao FROM motoristas WHERE cpf_motoristas = ?";
    $stmt_habilitacoes = $conn->prepare($sql_habilitacoes);
    $stmt_habilitacoes->bind_param("s", $cpf);
    $stmt_habilitacoes->execute();
    $result_habilitacoes = $stmt_habilitacoes->get_result();

    $letras = ['A', 'B', 'C', 'D', 'E'];

    $letrasResult = [];

    foreach ($letras as $letra) {
        $data["habilitacao$letra"] = false;

        while ($row_habilitacao = $result_habilitacoes->fetch_assoc()) {
            $tipo_habilitacao = $row_habilitacao['tipo_habilitacao'];
            if (strpos($tipo_habilitacao, $letra) !== false) {
                $data["habilitacao$letra"] = true;
                break; 
            }
        }
        $letrasResult[$letra] = $data["habilitacao$letra"];
        $result_habilitacoes->data_seek(0); 
    }

    $data['letrasResult'] = $letrasResult;
    
} else {
    $data['exists'] = false;
    $data['error'] = "Nenhum registro encontrado.";
}

echo json_encode($data);

$stmt_funcionario->close();
$conn->close();
?>