<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="Freitas_transporte.png">
    <title>Cadastro de Pessoas</title>
</head>

<body>
  <form id="formFuncionario" method="post" action="registrarFuncionario.php" enctype="multipart/form-data" autocomplete="off" onsubmit="return registrarFuncionario();">
    <script src="main.js"> </script>
    <div id="camposAdicionais">
      <div class="title-Funcionario"> Dados da Pessoa<a class="obrigatorio">*</a></div>
      <div class="container">
        <div class="image-container">
          <img id="imagemPreview" src="">
            <label class="custom-file-upload">
              <input type="file" id="foto" name="foto" accept="*/image" onchange="previewImagem(event)">
              Escolher Foto
            </label>
        </div>

        <div class="form-container">
          <div class="form-group">
            <label>Digite o cpf: </label>
            <input type="text" id="codigo" placeholder="Digite o cpf" name="Cpf" maxlength="14" name="cpf" oninput="formatarCPF(this)">
          </div>
          <div class="form-group">
            <label for="registro">Registro:</label>
            <input type="text" id="registro" placeholder="Digite o registro" name="registro" required>
          </div>
          <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" placeholder="Digite o nome" name="nome" required>
          </div>
          <div class="form-group tipo">
            <label for="tipo">Tipo:</label>
            <div class="input-container">
              <select id="tipo" name="tipo">
              <?php
                require_once "conexao.php";
                
                $sql = "SELECT tipo FROM profissoes";
            
                $result = $conn->query($sql);
            
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $tipo = $row["tipo"];
                    echo "<option value='$tipo'>$tipo</option>";
                  }
                } else {
                  echo "<option value=''>Nenhuma profissão encontrada</option>";
                }
                $conn->close();
                ?>
              </select>
            </div>
            
          </div>

          <div class="form-group"> 
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required>
          </div>

          <div class="form-group"> 
            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua"placeholder="Digite a rua" required>
          </div>

          <div class="form-group"> 
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" placeholder="Digite o bairro" required>
          </div>
      
          <div class="form-group"> 
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade" required>
          </div>
      
          <div class="form-group uf">
            <label for="UF">UF:</label>
            <div class="input-container">
              <select id="UF" name="uf">
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MT">MT</option>
                <option value="MS">MS</option>
                <option value="MG" selected>MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option>
                <option value="SP">SP</option>
                <option value="SE">SE</option>
                <option value="TO">TO</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div id="campos-Motorista1" class="title-motorista"> Campos do Motorista *</div>
      <div id="campos-Motorista">
        <div class="form-group">
          <div class="input-group">
            <label for="registroHabilitacao">Registro da Habilitação:</label>
            <input type="text" id="registroHabilitacao" name="registroHabilitacao" maxlength="11" placeholder="Digite o registro da Habilitação">
          </div>
          <div class="input-group">
            <label for="dataprimeiraHabilitacao">Data da primeira Habilitação:</label>
            <input type="text" id="dataprimeiraHabilitacao" name="dataprimeiraHabilitacao" placeholder="DD/MM/AAAA" data-original-length="8" oninput="formatarData(this)">
          </div>
        </div>
      
        <div class="form-group">
          <span id="spanHabilitacao"> </span>
          <div class="input-group-checkbox">
            Tipo de Habilitação:
            <div class="checkbox-group">
              <label for="habilitacaoA">A</label>
              <input type="checkbox" id="habilitacaoA" name="habilitacoes[]" value="A">
              <label for="habilitacaoB">B</label>
              <input type="checkbox" id="habilitacaoB" name="habilitacoes[]" value="B">
              <label for="habilitacaoC">C</label>
              <input type="checkbox" id="habilitacaoC" name="habilitacoes[]" value="C">
              <label for="habilitacaoD">D</label>
              <input type="checkbox" id="habilitacaoD" name="habilitacoes[]" value="D">
              <label for="habilitacaoE">E</label>
              <input type="checkbox" id="habilitacaoE" name="habilitacoes[]" value="E">
            </div>
          </div>
          <div class="input-group">
            <label for="dataValidadeHabilitacao">Validade da Habilitação:</label>
            <input type="text" id="dataValidadeHabilitacao" name="dataValidadeHabilitacao" placeholder="DD/MM/AAAA" data-original-length="8" oninput="formatarData(this)">
          </div>
        </div>
      </div>
      <div class="botoes">
        <button class="botao-acao" data-action="registrar" id="botaoRegistrar" type="submit" name="registrar">Registrar</button>
        <button class="botao-acao" data-action="alterar" id="botaoAlterar" type="submit" name="alterar">Alterar</button>
        <button class="botao-acao" data-action="excluir" id="botaoExcluir" type="submit" name="excluir">Excluir</button>
        <a href="index.php" id="botaoCancelar">Cancelar</a>
        <a id="botaoSair" href="/Site/Buscar_Pessoa/index.html">Sair</a>
      </div>
      </form>
      <br>
      
      <h2 class="title">Documentos</h2>
      <form id="formDocumento" method="post" action="registrarDocumento.php" enctype="multipart/form-data" autocomplete="off">
      <div id="documentos-section">
        <span id="spanNomeArquivo">Nenhum arquivo selecionado</span>
        <div class="Campos-preenchimento">
          <input type="hidden" id="cpfDoc" name="cpfDoc" value="">
          <label for="descricaoDocumento">Descrição do Documento:</label> <br>
          <input type="text" id="descricaoDocumento" name="descricaoDocumento" placeholder="Digite a descrição">
          <label class="custom-file-upload">
              <input type="file" id="documentoInput" name="documentoInput" accept="application/pdf">
              Anexar Documento
          </label>
          <button id="enviarDocumento" data-action="adicionarDocumento" type="submit" name="adicionarDocumento">Adicionar</button>
        </div>
        <table id="documentosTable">
          <thead>
            <tr>
              <th>Ação</th>
              <th>Descrição</th>
              <th>Visualização</th>
            </tr>
          </thead>
          <tbody id="tbody-doc">

          </tbody>
        </table>
        <br>      
        <button id="excluirDocumento" type="submit" name="excluirDocumento">Excluir</button>
      </form>
      </div>

      <h2 class="title">Referências Comerciais</h2>
      <div id="referencias-comerciais">
        <form id="formComercial" method="post" action="registrarRefcom.php" enctype="multipart/form-data" autocomplete="off">
        <div class="form-group comerciais">
          <input type="hidden" id="cpfCom" name="cpfCom">
          <div class="input-group"> 
            <label for="Telefone-com">Telefone:</label>
            <input type="text" id="Telefone-com" name="Telefone-com" placeholder="Digite o telefone">
          </div>
          <div class="input-group">
            <label for="nome-com">Nome:</label>
            <input type="text" id="nome-com" name="nome-com" placeholder="Digite o nome">
          </div>
          <div class="input-group">
            <button id="adicionarComercial" type="submit" name="adicionarComercial">Adicionar</button>
          </div>
        </div>
        <table id="comerciaisTable">
          <thead>
            <tr>
              <th>Ação</th>
              <th>Nome</th>
              <th>Telefone</th>
            </tr>
          </thead>
          <tbody id="tbody-com">

          </tbody>
        </table>          
        <br> 
        <button id="excluirComercial" type="submit" name="excluirComercial">Excluir</button>
        </form>
      </div>

      <h2 class="title">Referências Profissionais</h2>
      <div id="referencias-profissionais">
        <form id="formProfissional" method="post" action="registrarRefprof.php" enctype="multipart/form-data" autocomplete="off">
        <div class="form-group profissionais">
        <input type="hidden" id="cpfProf" name="cpfProf">
          <div class="input-group"> 
            <label for="telefone-prof">Telefone:</label>
            <input type="text" id="telefone-prof" name="telefone-prof" placeholder="Digite o telefone" maxlength="14">
          </div>
          <div class="input-group">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa" placeholder="Digite o nome da empresa">
          </div>
          <div class="input-group">
            <button id="adicionarProfissional" type="submit" name="adicionarProfissional" >Adicionar</button>
          </div>
        </div>
        <table id="profissionaisTable">
          <thead>
            <tr>
              <th>Ação</th>
              <th>Telefone</th>
              <th>Empresa</th>
            </tr>
          </thead>
          <tbody id="tbody-prof">

          </tbody>
        </table>
        <br>         
        <button id="excluirProfissional" type="submit" name="excluirProfissional">Excluir</button>
        </form>
      </div>
    </div>

    <script>
      const urlParams = new URLSearchParams(window.location.search);
      const cpfParam = urlParams.get('cpf');

      const codigoInput = document.getElementById("codigo");

      if (cpfParam && codigoInput) {
        codigoInput.value = cpfParam;
      
        const successMessage = "'<?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?>'";
      
        if (successMessage) {
          //alert("Login Realizado com sucesso");
        }
      
        $("#buscarDados").click();
      }
    </script>

</body>
</html>