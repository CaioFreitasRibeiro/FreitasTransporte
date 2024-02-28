<?php
require_once "conexao.php";

if (isset($_POST["adicionarDocumento"])) {
    $placa = isset($_POST["placaDoc"]) ? $_POST["placaDoc"] : "";
    $descricao = isset($_POST["descricaoDocumento"]) ? $_POST["descricaoDocumento"] : "";
    if ($_FILES["documentoInput"]["error"] === 0) {
        $documento = $_FILES["documentoInput"];
        if ($documento['error']) {
            die("Falha ao enviar o documento. Escolha outro documento");
        }

        $extensao_documento = strtolower(pathinfo($documento['name'], PATHINFO_EXTENSION));
        $diretorio_documentos = "Documento_veiculo/Veiculo_";
        $nome_documento_unico = $descricao . "_" . $placa . "." . $extensao_documento;
        $caminho_completo = $diretorio_documentos . $nome_documento_unico;
        if (move_uploaded_file($documento['tmp_name'], $caminho_completo)) {
            $sql = "INSERT INTO documento_caminhao (arquivos, descricao, placa_documento) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $caminho_completo, $descricao, $placa);
            if ($stmt->execute()) {
                exit();
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt->error]);
                echo 'window.location.href = index.php;';
                echo 'alert("Falha ao adicionar um documento!");';
            }
        
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Erro ao fazer upload do documento: " . $_FILES["documentoInput"]["error"]]);
        }
    } else {
        echo "Erro ao fazer upload do documento: " . $_FILES["documentoInput"]["error"];
    }
    $conn->close();
    header("Location: index.php?Placa=$placa#formDocumento");
} else if (isset($_POST["excluirDocumento"]) && isset($_POST["excluirDocumentos"])) {
    $DocumentosSelecionados = $_POST["excluirDocumentos"];
    $placa = $_POST["placaDoc"];
    
    foreach ($DocumentosSelecionados as $idDocumento) {
        $sqlSelectArquivo = "SELECT arquivos FROM documento_caminhao WHERE id = ? AND placa_documento = ?";
        $stmtSelectArquivo = $conn->prepare($sqlSelectArquivo);
        $stmtSelectArquivo->bind_param("is", $idDocumento, $placa);
        $stmtSelectArquivo->execute();
        $stmtSelectArquivo->store_result();

        if ($stmtSelectArquivo->num_rows > 0) {
            $stmtSelectArquivo->bind_result($caminhoArquivo);
            $stmtSelectArquivo->fetch();
            $stmtSelectArquivo->close();

            if (file_exists($caminhoArquivo) && unlink($caminhoArquivo)) {
                $sqlExcluir = "DELETE FROM documento_caminhao WHERE id = ? AND placa_documento = ?";
                $stmtExcluir = $conn->prepare($sqlExcluir);
                $stmtExcluir->bind_param("is", $idDocumento, $placa);

                if ($stmtExcluir->execute()) {
                    echo json_encode(["success" => true, "message" => "Documento(s) excluído(s) com sucesso."]);
                } else {
                    echo json_encode(["success" => false, "error" => "Erro ao excluir o registro do documento: " . $stmtExcluir->error]);
                }

                $stmtExcluir->close();
            } else {
                echo json_encode(["success" => false, "error" => "Erro ao excluir o arquivo físico."]);
            }
        }
    }
} else {
    echo '<script>';
    echo 'window.location.href = "index.php";';
    echo 'alert("Método de solicitação inválido!");';
    echo '</script>';
    echo json_encode(["success" => false, "error" => "Método de solicitação inválido."]);
}
$conn->close();
header("Location: index.php?Placa=$placa#formDocumento");
?>
