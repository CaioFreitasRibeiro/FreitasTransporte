<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/Site/Cadastro_Pessoa/Freitas_transporte.png">
    <title>Cadastro de profissões</title>
</head>
<body>
    <script src="main.js"> </script>
    <form id=formProfissao method="post" action="adicionarProfissoes.php" enctype="multipart/form-data" autocomplete="off">
        <h2>Cadastro de profissões</h2>
        <div class="container-wrapper">
        <span id="idprof-wrapper" style="display: none;">
            <input type="text" id="idprof" name="idprof" readonly>
            <label>Profissão:</label>
        </span>
        <input type="text" id="profissoes" name="profissao">
        <button type="button" id="Adicionar" name="adicionar" onclick="adicionarProfissao()">Adição</button>
        <button type="button" id="Alterar" name="alterar" onclick="alterarProfissao()">Alteração</button>
        <button type="button" id="Excluir" name="excluir" onclick="excluirProfissao()">Excluir</button>

        <table>
            <thead>
                <tr>
                    <th>Ação</th>
                    <th>Profissão</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <button type="submit" id="Executar" name="executar">Executar</button>
        <a href="/Site/index.html" name="btn-sair">Sair </a>
        </div>
    </form>
</body>