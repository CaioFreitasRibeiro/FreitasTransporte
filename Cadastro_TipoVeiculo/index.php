<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/Site/Cadastro_Pessoa/Freitas_transporte.png">
    <title>Adicionar tipo do veículo</title>
</head>
<body>
    <script src="main.js"> </script>
    <form id=formtipocam method="post" action="adicionartipocam.php" enctype="multipart/form-data" autocomplete="off">
        <h2>Cadastro de tipo do veículo</h2>
        <div class="container-wrapper">
            <div id="modo-botao">
                Escolher modo: 
                <button class="botao-inclusao" type="button"> Inclusão </button>
                <button class="botao-alteracao" type="button"> Alteração </button>
            </div>
            <span>
            <label>Tipo veículo:</label>
            <input type="text" id="tipocam" name="tipocam">
            <button type="submit" id="Adicionar" name="adicionar" onclick="return verificaNulo()">Adicionar</button>
            </span>
            <table>
                <thead>
                    <tr>
                        <th>Ação</th>
                        <th>Tipo veículo</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <button data-action="excluir" id="botaoExcluir" type="submit" name="excluir" onclick="return verificaCheckbox()">Excluir</button>
            <a href="/Site/index.html" name="btn-sair">Voltar</a>
        </div>
    </form>
</body>