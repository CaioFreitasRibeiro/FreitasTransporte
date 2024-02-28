<?php
require_once "conexao.php";

if (isset($_POST["adicionarDocumento"])) {
    $cpf = isset($_POST["cpfDoc"]) ? $_POST["cpfDoc"] : "";
    $descricao = isset($_POST["descricaoDocumento"]) ? $_POST["descricaoDocumento"] : "";
    if ($_FILES["documentoInput"]["error"] === 0) {
        $documento = $_FILES["documentoInput"];
        if ($documento['error']) {
            die("Falha ao enviar o documento. Escolha outro documento");
        }

        $extensao_documento = strtolower(pathinfo($documento['name'], PATHINFO_EXTENSION));
        $diretorio_documentos = "Documento_funcionario/Funcionario_";
        $nome_documento_unico = $descricao . "_" . $cpf . "." . $extensao_documento;
        $caminho_completo = $diretorio_documentos . $nome_documento_unico;
        if (move_uploaded_file($documento['tmp_name'], $caminho_completo)) {
            $sql = "INSERT INTO documentos (arquivos, descricao, cpf_documentos) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $caminho_completo, $descricao, $cpf);
            if ($stmt->execute()) {
                header("Location: index.php?cpf=$cpf");
                exit();
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt->error]);
                echo 'window.location.href = "index.php";';
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
    header("Location: index.php?cpf=$cpf#formDocumento");
} else if (isset($_POST["excluirDocumento"]) && isset($_POST["excluirDocumentos"])) {
    $DocumentosSelecionados = $_POST["excluirDocumentos"];
    $cpf = $_POST["cpfDoc"];
    
    foreach ($DocumentosSelecionados as $idDocumento) {
        $sqlSelectArquivo = "SELECT arquivos FROM documentos WHERE id_documentos = ? AND cpf_documentos = ?";
        $stmtSelectArquivo = $conn->prepare($sqlSelectArquivo);
        $stmtSelectArquivo->bind_param("is", $idDocumento, $cpf);
        $stmtSelectArquivo->execute();
        $stmtSelectArquivo->store_result();

        if ($stmtSelectArquivo->num_rows > 0) {
            $stmtSelectArquivo->bind_result($caminhoArquivo);
            $stmtSelectArquivo->fetch();
            $stmtSelectArquivo->close();

            if (file_exists($caminhoArquivo) && unlink($caminhoArquivo)) {
                $sqlExcluir = "DELETE FROM documentos WHERE id_documentos = ? AND cpf_documentos = ?";
                $stmtExcluir = $conn->prepare($sqlExcluir);
                $stmtExcluir->bind_param("is", $idDocumento, $cpf);

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
    header("Location: index.php?cpf=$cpf");
} else {
    echo '<script>';
    echo 'window.location.href = "index.php";';
    echo 'alert("Método de solicitação inválido!");';
    echo '</script>';
    echo json_encode(["success" => false, "error" => "Método de solicitação inválido."]);
    $conn->close();
}
?>
