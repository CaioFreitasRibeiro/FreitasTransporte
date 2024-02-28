<?php

require_once "conexao.php";

if(isset($_POST["registrar"])) {
    $cpf = isset($_POST["Cpf"]) ? $_POST["Cpf"] : "";
    $registro = isset($_POST["registro"]) ? $_POST["registro"] : "";
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $cep = isset($_POST["cep"]) ? $_POST["cep"] : "";
    $rua = isset($_POST["rua"]) ? $_POST["rua"] : "";
    $bairro = isset($_POST["bairro"]) ? $_POST["bairro"] : "";
    $cidade = isset($_POST["cidade"]) ? $_POST["cidade"] : "";
    $uf = isset($_POST["uf"]) ? $_POST["uf"] : "";
    
    $selectIdTipo = "SELECT id FROM profissoes WHERE tipo = ?";
    $stmtVerificarIdTipo= $conn->prepare($selectIdTipo);
    $stmtVerificarIdTipo->bind_param("s", $tipo);
    $stmtVerificarIdTipo->execute();
    $resultado = $stmtVerificarIdTipo->get_result();
    $tipoArray = $resultado->fetch_assoc();
    $idTipo = $tipoArray['id'];

    $registroHabilitacao = isset($_POST["registroHabilitacao"]) ? $_POST["registroHabilitacao"] : "";
    $dataprimeiraHabilitacao = isset($_POST["dataprimeiraHabilitacao"]) ? $_POST["dataprimeiraHabilitacao"] : "";
    $dataprimeiraHabilitacao = date("Y-m-d", strtotime(str_replace("/", "-", $dataprimeiraHabilitacao)));
    if (isset($_POST["habilitacoes"])) {
        $opcoesSelecionadas = $_POST["habilitacoes"];
    
        if (!is_array($opcoesSelecionadas)) {
            $opcoesSelecionadas = array($opcoesSelecionadas);
        }
    
        $Habilitacao = implode('', $opcoesSelecionadas);
    
        $Habilitacao = substr($Habilitacao, 0, 5);
    
        echo "String de Habilitação: " . $Habilitacao;
    }

    $dataValidadeHabilitacao = isset($_POST["dataValidadeHabilitacao"]) ? $_POST["dataValidadeHabilitacao"] : "";
    $dataValidadeHabilitacao = date("Y-m-d", strtotime(str_replace("/", "-", $dataValidadeHabilitacao))); 

    if(isset($_FILES['foto'])) 
    {
        $foto = $_FILES['foto'];
        if($foto['error']) {
            echo "Sem fotos.";
            $sqlFuncionarios = "INSERT INTO funcionarios (cpf, registro, nome_funcionarios, tipo, rua, bairro, cidade, uf, cep) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmtFuncionarios = $conn->prepare($sqlFuncionarios);
            $stmtFuncionarios->bind_param("sisssssss", $cpf, $registro, $nome, $idTipo, $rua, $bairro, $cidade, $uf, $cep);
        } else if ($foto['size'] > 2097152) {
            /*echo '<script>';
            echo 'window.location.href = "index.php";';
            echo 'alert("Foto muito grande! Poste uma foto que tenha menos de 2MB");';
            echo '</script>';*/
        } else {
            $pasta = "Foto_funcionario/Funcionario_";
            $nomeFoto = $cpf;
            $extensaoFoto = "png";
            
            $path = $pasta . $nomeFoto . "." . $extensaoFoto;
            $salvarFoto = move_uploaded_file($foto['tmp_name'], $path);

            $conteudoNovaFoto = $pasta . $nomeFoto;
            
            $sqlFuncionarios = "INSERT INTO funcionarios (cpf, registro, nome_funcionarios, tipo, rua, bairro, cidade, uf, cep, foto) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmtFuncionarios = $conn->prepare($sqlFuncionarios);
            $stmtFuncionarios->bind_param("sisissssss", $cpf, $registro, $nome, $idTipo, $rua, $bairro, $cidade, $uf, $cep, $conteudoNovaFoto);
        }  
    }

    if($tipo === 'Motorista')
    {
        $sqlMotoristas = "INSERT INTO motoristas (registro_habilitacao, data_primeira_habilitacao, tipo_habilitacao, data_validade_habilitacao, cpf_motoristas)
                        VALUES ('$registroHabilitacao', '$dataprimeiraHabilitacao', '$Habilitacao', '$dataValidadeHabilitacao', '$cpf');";

        if ($conn->query($sqlMotoristas) === TRUE) {
            echo "Dados do motorista inseridos com sucesso!<br>";
        } else {
            echo "Erro: " . $sqlMotoristas . "<br>" . $conn->error;
        }
    }

    if ($stmtFuncionarios->execute()) {
        echo '<script>';
        echo 'window.location.href = "index.php";'; 
        echo 'alert("Dados de usuários inseridos com sucesso!");';
        echo '</script>';
    } else {
        echo 'Erro: ' . $stmtFuncionarios->error;
    }
    $stmtFuncionarios->close();
    $conn->close(); 
    header("Location: index.php?cpf=$cpf");
    exit();

} elseif (isset($_POST["alterar"])) {
    $cpf = isset($_POST["Cpf"]) ? $_POST["Cpf"] : "";
    $registro = isset($_POST["registro"]) ? $_POST["registro"] : "";
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
    $cep = isset($_POST["cep"]) ? $_POST["cep"] : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $rua = isset($_POST["rua"]) ? $_POST["rua"] : "";
    $bairro = isset($_POST["bairro"]) ? $_POST["bairro"] : "";
    $cidade = isset($_POST["cidade"]) ? $_POST["cidade"] : "";
    $uf = isset($_POST["uf"]) ? $_POST["uf"] : "";

    $selectIdTipo = "SELECT id FROM profissoes WHERE tipo = ?";
    $stmtVerificarIdTipo= $conn->prepare($selectIdTipo);
    $stmtVerificarIdTipo->bind_param("s", $tipo);
    $stmtVerificarIdTipo->execute();
    $resultadoIdTipo = $stmtVerificarIdTipo->get_result();
    if ($resultadoIdTipo) {
        $tipoArray = $resultadoIdTipo->fetch_assoc();
        $idTipo = $tipoArray['id'];
    } else {
        echo "Erro ao obter o ID do tipo de funcionário: " . $stmtVerificarIdTipo->error;
    }

    $sqlUpdateRegistro = "UPDATE funcionarios SET registro = ? WHERE cpf = ?";
    $stmtUpdateRegistro = $conn->prepare($sqlUpdateRegistro);
    $stmtUpdateRegistro->bind_param("is", $registro, $cpf);

    if ($stmtUpdateRegistro->execute()) {
        echo "Registro Atualizado!";
    }
    else {
        var_dump($registro);
    }

    $sqlAtualizacao = "UPDATE funcionarios SET registro = ?, nome_funcionarios = ?, tipo = ?, rua = ?, bairro = ?, cidade = ?, uf = ?, cep = ? WHERE cpf = ?";
    $stmtAtualizacao = $conn->prepare($sqlAtualizacao);
    $stmtAtualizacao->bind_param("isissssss", $registro, $nome, $idTipo, $rua, $bairro, $cidade, $uf, $cep, $cpf);

    if(isset($_FILES['foto'])) {
        $foto = $_FILES['foto'];
        if($foto['error']) {
            echo "Sem fotos";
        } else if ($foto['size'] > 2097152) {
            echo '<script>';
            echo 'window.location.href = "index.php";';
            echo 'alert("Foto muito grande! Poste uma foto que tenha menos de 2MB");';
            echo '</script>';
        } else {
            $pasta = "Foto_funcionario/Funcionario_";
            $nomeFoto = $cpf;
            $extensaoFoto = "png";
        
            $path = $pasta . $nomeFoto . "." . $extensaoFoto;
    
            if (file_exists($path)) {
                if (unlink($path)) {
                    echo "";
                } else {
                    echo "";
                }
            }
            $salvarNovaFoto = move_uploaded_file($foto['tmp_name'], $path);
            if ($salvarNovaFoto) {
                $sqlFotoNulo = "UPDATE funcionarios SET foto = NULL WHERE cpf = ?";
                $stmtNulo = $conn->prepare($sqlFotoNulo);
                $stmtNulo->bind_param("s", $cpf);
                if ($stmtNulo->execute()) {
                    $sqlAtualizarFoto = "UPDATE funcionarios SET foto = ? WHERE cpf = ?";
                    $stmtAtualizarFoto = $conn->prepare($sqlAtualizarFoto);
                    $stmtAtualizarFoto->bind_param("ss", $path, $cpf);
                     if ($stmtAtualizarFoto->execute()) {
                        echo "Foto do funcionário alterada com sucesso!<br>";
                    } else {
                        echo "Erro ao atualizar a foto: " . $stmtAtualizarFoto->error;
                    }
                    $stmtAtualizarFoto->close();
                } else {echo "Erro ao salvar a nova foto";}
            } else {
                echo "Erro ao mover a nova foto para a pasta.";
            }
        }
    }

    $registroHabilitacao = isset($_POST["registroHabilitacao"]) ? $_POST["registroHabilitacao"] : "";
    $dataprimeiraHabilitacao = isset($_POST["dataprimeiraHabilitacao"]) ? $_POST["dataprimeiraHabilitacao"] : "";
    $dataprimeiraHabilitacao = date("Y-m-d", strtotime(str_replace("/", "-", $dataprimeiraHabilitacao)));
    
    if (isset($_POST["habilitacoes"])) {
        $opcoesSelecionadas = $_POST["habilitacoes"];
    
        if (!is_array($opcoesSelecionadas)) {
            $opcoesSelecionadas = array($opcoesSelecionadas);
        }
    
        $Habilitacao = implode('', $opcoesSelecionadas);
    
        $Habilitacao = substr($Habilitacao, 0, 5);
    
        echo "String de Habilitação: " . $Habilitacao;
    }

    $dataValidadeHabilitacao = isset($_POST["dataValidadeHabilitacao"]) ? $_POST["dataValidadeHabilitacao"] : "";
    $dataValidadeHabilitacao = date("Y-m-d", strtotime(str_replace("/", "-", $dataValidadeHabilitacao))); 

    if ($tipo === 'Gerente') {
        $sqlVerificarMotorista = "SELECT * FROM motoristas WHERE cpf_motoristas = ?";
        $stmtVerificarMotorista = $conn->prepare($sqlVerificarMotorista);
        $stmtVerificarMotorista->bind_param("s", $cpf);
        $stmtVerificarMotorista->execute();
        $resultado = $stmtVerificarMotorista->get_result();
    
        if ($resultado->num_rows > 0) {
            // O registro de motorista existe, faça a exclusão
            $sqlExcluirMotorista = "DELETE FROM motoristas WHERE cpf_motoristas = ?";
            $stmtExcluirMotorista = $conn->prepare($sqlExcluirMotorista);
            $stmtExcluirMotorista->bind_param("s", $cpf);
    
            if ($stmtExcluirMotorista->execute()) {
                echo "Registro de motorista excluído com sucesso!<br>";
            } else {
                echo "Erro ao excluir o registro de motorista: " . $stmtExcluirMotorista->error;
            }
            $stmtExcluirMotorista->close();
        } else {
            echo "Tipo não precisa ser alterado.";
        }
        $stmtVerificarMotorista->close();
    }
    if ($stmtAtualizacao->execute()) {
        echo "Dados do funcionário alterados com sucesso!<br>";
    } else {
        echo "Erro: " . $stmtAtualizacao->error;
    } 
    
    if($tipo === 'Motorista')
    {
        $sqlVerificarMotorista = "SELECT * FROM motoristas WHERE cpf_motoristas = ?";
        $stmtVerificarMotorista = $conn->prepare($sqlVerificarMotorista);
        $stmtVerificarMotorista->bind_param("s", $cpf);
        $stmtVerificarMotorista->execute();
        $resultado = $stmtVerificarMotorista->get_result();

        if ($resultado->num_rows > 0) {
            // O motorista já existe, faça a atualização
            $sqlAtualizarMotorista = "UPDATE motoristas SET registro_habilitacao = ?, data_primeira_habilitacao = ?, tipo_habilitacao = ?, data_validade_habilitacao = ? WHERE cpf_motoristas = ?";
            $stmtAtualizarMotorista = $conn->prepare($sqlAtualizarMotorista);
            $stmtAtualizarMotorista->bind_param("sssss", $registroHabilitacao, $dataprimeiraHabilitacao, $Habilitacao, $dataValidadeHabilitacao, $cpf);
        
            if ($stmtAtualizarMotorista->execute()) {
                echo "Dados do motorista atualizados com sucesso!<br>";
            } else {
                echo "Erro ao atualizar os dados do motorista: " . $stmtAtualizarMotorista->error;
            }
            $stmtAtualizarMotorista->close();
        } else {
            // O motorista não existe, faça a inserção
            $sqlInserirMotorista = "INSERT INTO motoristas (registro_habilitacao, data_primeira_habilitacao, tipo_habilitacao, data_validade_habilitacao, cpf_motoristas) VALUES (?, ?, ?, ?, ?)";
            $stmtInserirMotorista = $conn->prepare($sqlInserirMotorista);
            $stmtInserirMotorista->bind_param("sssss", $registroHabilitacao, $dataprimeiraHabilitacao, $Habilitacao, $dataValidadeHabilitacao, $cpf);
        
            if ($stmtInserirMotorista->execute()) {
                echo "Dados do motorista alterados com sucesso! <br>";
            } else {
                echo "Erro ao inserir os dados do motorista: " . $stmtInserirMotorista->error;
            }
            $stmtInserirMotorista->close();
        }
    }

    if ($stmtAtualizacao->execute()) {
        /*echo '<script>';
        echo 'window.location.href = "index.php";';
        echo 'alert("Dados de usuários alterados com sucesso!");';
        echo '</script>';*/
    } else {
        echo 'Erro: ' . $stmtAtualizacao->error;
    }
    $stmtAtualizacao->close();
    $conn->close();
    header("Location: index.php?cpf=$cpf");
    exit();

} elseif (isset($_POST["excluir"])) {
    $cpf = isset($_POST["Cpf"]) ? $_POST["Cpf"] : "";
    $foto = $_FILES['foto'];
    $pasta = "Foto_funcionario/Funcionario_";
    $nomeFoto = $cpf;
    
    $path = $pasta . $nomeFoto . ".png";

    if (file_exists($path)) {
        if (unlink($path)) {
            echo "";
        } else {
            echo "";
        }
    } else {
        echo "";
    }   
    
    $dir = "Documento_funcionario";
    $ext = 'pdf';

    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if (is_file($dir . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) == $ext) {
                if (strpos($file, $cpf) !== false) {
                    $filePath = $dir . '/' . $file;
    
                    // Exclui o arquivo
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

    $sqlVerificarMotorista = "SELECT * FROM motoristas WHERE cpf_motoristas = ?";
    $stmtVerificarMotorista = $conn->prepare($sqlVerificarMotorista);
    $stmtVerificarMotorista->bind_param("s", $cpf);
    $stmtVerificarMotorista->execute();
    $resultado = $stmtVerificarMotorista->get_result();

    if ($resultado->num_rows > 0) {
        $sqlExcluirMotorista = "DELETE FROM motoristas WHERE cpf_motoristas = ?";
        $stmtExcluirMotorista = $conn->prepare($sqlExcluirMotorista);
        $stmtExcluirMotorista->bind_param("s", $cpf);

        if ($stmtExcluirMotorista->execute()) {
            echo "";
        } else {
            echo "Erro ao excluir o registro de motorista: <br>" . $stmtExcluirMotorista->error;
        }
        $stmtExcluirMotorista->close();
    } else {
        echo "";
    }
    $stmtVerificarMotorista->close();
    
    
    $sqlVerificardocumentos = "SELECT * FROM documentos WHERE cpf_documentos = ?";
    $stmtVerificardocumentos = $conn->prepare($sqlVerificardocumentos);
    $stmtVerificardocumentos->bind_param("s", $cpf);
    $stmtVerificardocumentos->execute();
    $resultado = $stmtVerificardocumentos->get_result();

    if ($resultado->num_rows > 0) {
        $sqlExcluirdocumentos = "DELETE FROM documentos WHERE cpf_documentos = ?";
        $stmtExcluirdocumentos = $conn->prepare($sqlExcluirdocumentos);
        $stmtExcluirdocumentos->bind_param("s", $cpf);

        if ($stmtExcluirdocumentos->execute()) {
            echo "";
        } else {
            echo "Erro ao excluir o registro de documento: " . $stmtExcluirdocumentos->error;
        }
        $stmtExcluirdocumentos->close();
    } 
    else { echo ""; }

    $sqlVerificarref_comerciais = "SELECT * FROM ref_comerciais WHERE cpf_comercial = ?";
    $stmtVerificarref_comerciais = $conn->prepare($sqlVerificarref_comerciais);
    $stmtVerificarref_comerciais->bind_param("s", $cpf);
    $stmtVerificarref_comerciais->execute();
    $resultado = $stmtVerificarref_comerciais->get_result();

    if ($resultado->num_rows > 0) {
        $sqlExcluirref_comerciais = "DELETE FROM ref_comerciais WHERE cpf_comercial = ?";
        $stmtExcluirref_comerciais = $conn->prepare($sqlExcluirref_comerciais);
        $stmtExcluirref_comerciais->bind_param("s", $cpf);

        if ($stmtExcluirref_comerciais->execute()) {
            echo "";
        } else {
            echo "Erro ao excluir o registro de referência comercial: " . $stmtExcluirref_comerciais->error;
        }
        $stmtExcluirref_comerciais->close();
    } 
    else { echo ""; }

    $sqlVerificarref_profissionais = "SELECT * FROM ref_profissionais WHERE cpf_empresa = ?";
    $stmtVerificarref_profissionais = $conn->prepare($sqlVerificarref_profissionais);
    $stmtVerificarref_profissionais->bind_param("s", $cpf);
    $stmtVerificarref_profissionais->execute();
    $resultado = $stmtVerificarref_profissionais->get_result();

    if ($resultado->num_rows > 0) {
        $sqlExcluirref_profissionais = "DELETE FROM ref_profissionais WHERE cpf_empresa = ?";
        $stmtExcluirref_profissionais = $conn->prepare($sqlExcluirref_profissionais);
        $stmtExcluirref_profissionais->bind_param("s", $cpf);

        if ($stmtExcluirref_profissionais->execute()) {
            echo "";
        } else {
            echo "Erro ao excluir o registro de referência profissional: " . $stmtExcluirref_profissionais->error;
        }
        $stmtExcluirref_profissionais->close();
    } 
    
    $sqlVerificarFuncionario = "SELECT * FROM funcionarios WHERE cpf = ?";
    $stmtVerificarFuncionario = $conn->prepare($sqlVerificarFuncionario);
    $stmtVerificarFuncionario->bind_param("s", $cpf);
    $stmtVerificarFuncionario->execute();
    $resultado = $stmtVerificarFuncionario->get_result();

    if ($resultado->num_rows > 0) {
        $sqlExcluirFuncionario = "DELETE FROM funcionarios WHERE cpf = ?";
        $stmtExcluirFuncionario = $conn->prepare($sqlExcluirFuncionario);
        $stmtExcluirFuncionario->bind_param("s", $cpf);

        if ($stmtExcluirFuncionario->execute()) {
            /*echo '<script>';
            echo 'window.location.href = "index.php";';
            echo 'alert("Dados de usuários removidos com sucesso!");';
            echo '</script>';*/
            $stmtExcluirFuncionario->close();
        } else {
            echo "Erro ao excluir o registro de funcionario: " . $stmtExcluirFuncionario->error;
        }
    } else { echo ""; }
    $conn->close();
    header("Location: index.php");
    exit();
}
?>