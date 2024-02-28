<?php
require_once "conexao.php";

if(isset($_POST["registrar"])) {
    $placa = isset($_POST["placa"]) ? $_POST["placa"] : "";
    $modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : "";
    $anofabricacao = isset($_POST["anofabricacao"]) ? $_POST["anofabricacao"] : "";
    $renavam = isset($_POST["renavam"]) ? $_POST["renavam"] : "";
    $chassi = isset($_POST["chassi"]) ? $_POST["chassi"] : "";
    $tipo = isset($_POST["tipocaminhao"]) ? $_POST["tipocaminhao"] : "";
    $tipocombustivel = isset($_POST["tipocombustivel"]) ? $_POST["tipocombustivel"] : "";
    $cor = isset($_POST["cor"]) ? $_POST["cor"] : "";
    $datacompra = isset($_POST["datacompra"]) ? $_POST["datacompra"] : null;
    $datacompra = date("Y-m-d", strtotime(str_replace("/", "-", $datacompra)));
    if ($datacompra == "00/00/0000" || $datacompra == "0000-00-00" || empty($_POST["datacompra"])) {$datacompra = null;}
    $valorcompra = isset($_POST["valorcompra"]) ? $_POST["valorcompra"] : null;
    $valorcompra = str_replace("R$", "", $valorcompra);
    if ($valorcompra == "R$0.00" || $valorcompra == 0.00 || empty($_POST["valorcompra"])) {$valorcompra = null;}
    $altura = isset($_POST["Altura"]) ? $_POST["Altura"] : null;
    if ($altura == 0.00 || empty($_POST["Altura"])) {$altura = null;}
    $largura = isset($_POST["Largura"]) ? $_POST["Largura"] : null;
    if ($largura == 0.00 || empty($_POST["Largura"])) {$largura = null;}
    $comprimento = isset($_POST["Comprimento"]) ? $_POST["Comprimento"] : null;
    if ($comprimento == 0.00 || empty($_POST["Comprimento"])) {$comprimento = null;}
    $alturaEX = isset($_POST["AlturaEx"]) ? $_POST["AlturaEx"] : null;
    if ($alturaEX == 0.00 || empty($_POST["AlturaEx"])) {$alturaEX = null;}
    $larguraEX = isset($_POST["LarguraEx"]) ? $_POST["LarguraEx"] : null;
    if ($larguraEX == 0.00 || empty($_POST["LarguraEx"])) {$larguraEX = null;}
    $comprimentoEX = isset($_POST["ComprimentoEx"]) ? $_POST["ComprimentoEx"] : null;
    if ($comprimentoEX == 0.00 || empty($_POST["ComprimentoEx"])) {$comprimentoEX = null;}

    $selectIdTipo = "SELECT id FROM tipocaminhao WHERE tipo = ?";
    $stmtVerificarIdTipo= $conn->prepare($selectIdTipo);
    $stmtVerificarIdTipo->bind_param("s", $tipo);
    $stmtVerificarIdTipo->execute();
    $resultado = $stmtVerificarIdTipo->get_result();
    $tipoArray = $resultado->fetch_assoc();
    $tipocaminhao= $tipoArray['id'];

    if(isset($_FILES['foto'])) 
    {
        $foto = $_FILES['foto'];
        if($foto['error']) {
            echo "Sem fotos.";
            $sqlInserir = "INSERT INTO caminhao (placa, modelo, renavam, chassi, anofabricacao, datacompra, valorcompra, cor, tipocaminhao, 
                           tipocombustivel, alturaIN, larguraIN, comprimentoIN, alturaEX, larguraEX, comprimentoEX)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

            $stmt = $conn->prepare($sqlInserir);
            if (!$stmt) {
                die("Erro na preparação da consulta: " . $conn->error);
            }
            $stmt->bind_param("ssisisssssdddddd", $placa, $modelo, $renavam, $chassi, $anofabricacao, $datacompra, $valorcompra, $cor, $tipocaminhao, $tipocombustivel, $altura, $largura, $comprimento, $alturaEX, $larguraEX, $comprimentoEX);
            if (!$stmt->execute()) {
                die("Erro na execução da consulta: " . $stmt->error);
            }
        } else {
            $pasta = "Foto_veiculo/Veiculo_";
            $nomeFoto = $placa;
            $extensaoFoto = "png";
            
            $path = $pasta . $nomeFoto . "." . $extensaoFoto;
            $salvarFoto = move_uploaded_file($foto['tmp_name'], $path);

            $conteudoNovaFoto = $pasta . $nomeFoto;
            
            $sqlInserir = "INSERT INTO caminhao (placa, modelo, renavam, chassi, anofabricacao, foto, datacompra, valorcompra, cor, tipocaminhao, 
                           tipocombustivel, alturaIN, larguraIN, comprimentoIN, alturaEX, larguraEX, comprimentoEX)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

            $stmt = $conn->prepare($sqlInserir);
            $stmt->bind_param("ssisissssssdddddd", $placa, $modelo, $renavam, $chassi, $anofabricacao, $conteudoNovaFoto, $datacompra, $valorcompra, $cor, $tipocaminhao, $tipocombustivel, $altura, $largura, $comprimento, $alturaEX, $larguraEX, $comprimentoEX);
        }  
    }

    if ($conn->query($sqlInserir) === TRUE) {
        echo "Dados do caminhão inseridos com sucesso!<br>";
    } else {
        echo "Erro: " . $sqlInserir . "<br>" . $conn->error;
    }

    $stmt->close();
    header("Location: index.php?Placa=$placa");

} else if(isset($_POST["alterar"])) {
    $placa = isset($_POST["placa"]) ? $_POST["placa"] : "";
    $modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : "";
    $anofabricacao = isset($_POST["anofabricacao"]) ? $_POST["anofabricacao"] : "";
    $renavam = isset($_POST["renavam"]) ? $_POST["renavam"] : "";
    $chassi = isset($_POST["chassi"]) ? $_POST["chassi"] : "";
    $tipocaminhao = isset($_POST["tipocaminhao"]) ? $_POST["tipocaminhao"] : "";
    $tipocombustivel = isset($_POST["tipocombustivel"]) ? $_POST["tipocombustivel"] : "";
    $cor = isset($_POST["cor"]) ? $_POST["cor"] : "";
    if (empty($_POST["cor"])) {$cor = null;}
    $datacompra = isset($_POST["datacompra"]) ? $_POST["datacompra"] : null;
    $datacompra = date("Y-m-d", strtotime(str_replace("/", "-", $datacompra)));
    if ($datacompra == "00/00/0000" || $datacompra == "0000-00-00" || empty($_POST["datacompra"])) {$datacompra = null;}
    $valorcompra = isset($_POST["valorcompra"]) ? $_POST["valorcompra"] : null;
    $valorcompra = str_replace("R$", "", $valorcompra);
    if ($valorcompra == "R$0.00" || $valorcompra == 0.00 || empty($_POST["valorcompra"])) {$valorcompra = null;}
    $altura = isset($_POST["Altura"]) ? $_POST["Altura"] : null;
    if ($altura == 0.00 || empty($_POST["Altura"])) {$altura = null;}
    $largura = isset($_POST["Largura"]) ? $_POST["Largura"] : null;
    if ($largura == 0.00 || empty($_POST["Largura"])) {$largura = null;}
    $comprimento = isset($_POST["Comprimento"]) ? $_POST["Comprimento"] : null;
    if ($comprimento == 0.00 || empty($_POST["Comprimento"])) {$comprimento = null;}
    $alturaEX = isset($_POST["AlturaEx"]) ? $_POST["AlturaEx"] : null;
    if ($alturaEX == 0.00 || empty($_POST["AlturaEx"])) {$alturaEX = null;}
    $larguraEX = isset($_POST["LarguraEx"]) ? $_POST["LarguraEx"] : null;
    if ($larguraEX == 0.00 || empty($_POST["LarguraEx"])) {$larguraEX = null;}
    $comprimentoEX = isset($_POST["ComprimentoEx"]) ? $_POST["ComprimentoEx"] : null;
    if ($comprimentoEX == 0.00 || empty($_POST["ComprimentoEx"])) {$comprimentoEX = null;}
    if(isset($_FILES['foto'])) 
    {
        $foto = $_FILES['foto'];
        if($foto['error']) {
            echo "Sem fotos.";
            $sqlUpdate = "UPDATE caminhao SET modelo = ?, renavam = ?, chassi = ?, anofabricacao = ?, datacompra = ?, valorcompra = ?, cor = ?,
                           tipocaminhao = ?, tipocombustivel = ?, alturaIN = ?, larguraIN = ?, comprimentoIN = ?, alturaEX = ?, larguraEX = ?, comprimentoEX = ? WHERE placa = ?";

            $stmt = $conn->prepare($sqlUpdate);
            if (!$stmt) {
                die("Erro na preparação da consulta: " . $conn->error);
            }
            $stmt->bind_param("sisisssssdddddds", $modelo, $renavam, $chassi, $anofabricacao, $datacompra, $valorcompra, $cor, $tipocaminhao, $tipocombustivel, $altura, $largura, $comprimento, $alturaEX, $larguraEX, $comprimentoEX, $placa);
            if (!$stmt->execute()) {
                die("Erro na execução da consulta: " . $stmt->error);
            }
        } else {
            $pasta = "Foto_veiculo/Veiculo_";
            $nomeFoto = $placa;
            $extensaoFoto = "png";
            
            $path = $pasta . $nomeFoto . "." . $extensaoFoto;
            $salvarFoto = move_uploaded_file($foto['tmp_name'], $path);

            $conteudoNovaFoto = $pasta . $nomeFoto;
            
            $sqlUpdate = "UPDATE caminhao SET modelo = ?, renavam = ?, chassi = ?, anofabricacao = ?, foto = ?, datacompra = ?, valorcompra = ?, cor = ?,
                           tipocaminhao = ?, tipocombustivel = ?, alturaIN = ?, larguraIN = ?, comprimentoIN = ?, alturaEX = ?, larguraEX = ?, comprimentoEX = ? WHERE placa = ?";
        
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("sisissssssdddddds", $modelo, $renavam, $chassi, $anofabricacao, $conteudoNovaFoto, $datacompra, $valorcompra, $cor, $tipocaminhao, $tipocombustivel, $altura, $largura, $comprimento, $alturaEX, $larguraEX, $comprimentoEX, $placa);
        }  
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Dados do caminhão atualizados com sucesso!<br>";
    } else {
        echo "Erro: " . $sqlUpdate . "<br>" . $conn->error;
    }

    $stmt->close();
    header("Location: index.php?Placa=$placa");
    
} else if (isset($_POST["excluir"])) {
    $placa = isset($_POST["placa"]) ? $_POST["placa"] : "";

    $foto = $_FILES['foto'];
    $pasta = "Foto_veiculo/Veiculo_";
    $nomeDoc = $placa;
    
    $path = $pasta . $nomeDoc . ".png";

    if (file_exists($path)) {
        if (unlink($path)) {
            echo "";
        } else {
            echo "";
        }
    } else {
        echo "";
    }   

    $dir = "Documento_veiculo";
    $ext = 'pdf';

    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if (is_file($dir . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) == $ext) {
                if (strpos($file, $placa) !== false) {
                    $filePath = $dir . '/' . $file;
    
                    if (unlink($filePath)) {
                        echo '';
                    } else {
                        echo 'Erro ao excluir o arquivo: ' . $filePath . '<br>';
                    }
                }
            }
        }
        closedir($handle);
    }

    $sqlVerificardocumentos = "SELECT * FROM documento_caminhao WHERE placa_documento = ?";
    $stmtVerificardocumentos = $conn->prepare($sqlVerificardocumentos);
    $stmtVerificardocumentos->bind_param("s", $placa);
    $stmtVerificardocumentos->execute();
    $resultadoDoc = $stmtVerificardocumentos->get_result();

    if ($resultadoDoc->num_rows > 0) {
        $sqlExcluirdocumentos = "DELETE FROM documento_caminhao WHERE placa_documento = ?";
        $stmtExcluirdocumentos = $conn->prepare($sqlExcluirdocumentos);
        $stmtExcluirdocumentos->bind_param("s", $placa);

        if ($stmtExcluirdocumentos->execute()) {
            $stmtExcluirdocumentos->close();
            echo "Documento excluido com sucesso";
        } else {
            echo "Erro ao excluir o registro de documento: " . $stmtExcluirdocumentos->error;
        }
    } 
    else { echo "Não há documentos salvos <br>"; }

    $sqlVerificarCaminhao = "SELECT * FROM caminhao WHERE placa = ?";
    $stmtVerificarC = $conn->prepare($sqlVerificarCaminhao);
    $stmtVerificarC->bind_param("s", $placa);
    $stmtVerificarC->execute();
    $resultado = $stmtVerificarC->get_result();
    
    if ($resultado->num_rows > 0) {
        $sqlExcluir = "DELETE FROM caminhao WHERE placa = ?";
        $stmtExcluir = $conn->prepare($sqlExcluir);
        $stmtExcluir->bind_param("s", $placa);
    
        if ($stmtExcluir->execute()) {
            $stmtExcluir->close();
            echo "Usuario excluido com sucesso";
        } else {
            echo "Erro ao excluir o registro de funcionario: " . $stmtExcluir->error;
        }
    } else { echo ""; }
    header("Location: index.php");
}
$conn->close();
exit();
?>
