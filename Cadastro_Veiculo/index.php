<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/Site/Cadastro_Pessoa/Freitas_transporte.png">
    <title>Cadastrar de veículos</title>
  </head>
  <body>
    <form id="formCaminhao" method="post" action="registrarVeiculo.php" enctype="multipart/form-data" autocomplete="off">
    <script src="main.js"> </script>
    <div id="camposAdicionais">
      <div class="title-basico">Informações básicas <a class="obrigatorio">*</a></div>
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
            <label>Digite a placa:</label>
            <input type="text" id="Placa" name="placa" name="Placa" placeholder="Digite a placa">
          </div>
          <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" placeholder="Digite o modelo" name="modelo" required>
          </div>
          <div class="form-group">
              <label for="anofabricacao">Ano de fabricação:</label>
              <input type="text" id="anofabricacao" placeholder="Digite o ano" name="anofabricacao" maxlength=4 required>
            </div>
            <div class="form-group">
              <label for="renavam">Renavam:</label>
              <input type="text" id="renavam" placeholder="Digite o renavam" name="renavam" required>
            </div>
          <div class="form-group">
            <label for="chassi">Chassi:</label>
            <input type="text" id="chassi" placeholder="Digite o chassi" name="chassi" required>
          </div>
          <div class="form-group tipo">
            <label for="tipocaminhao">Tipo veiculo:</label>
            <div class="input-container">
              <select id="tipocaminhao" name="tipocaminhao" required>
                <?php
                  require_once "conexao.php";
                  $sql = "SELECT tipo FROM tipocaminhao";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $tipo = $row["tipo"];
                      echo "<option value='$tipo'>$tipo</option>";
                    }
                  } else {
                    echo "<option value=''>Nenhuma tipo encontrado</option>";
                  }
                  $conn->close();
                ?>
              </select>
            </div>
            <!--<a id="botaoTipo" href="/Site/Cadastro_TipoVeiculo/index.php"> Outro tipo</a> !-->
          </div>
          <div class="form-group combu">
              <label for="tipocombustivel">Tipo combustível:</label>
              <div class="input-container">
                <select id="tipocombustivel" name="tipocombustivel">
                    <option value="Diesel" selected>Diesel</option>
                    <option value="Gasolina">Gasolina</option>
                    <option value="Etanol">Etanol</option>
                </select>
              </div>
            </div> 
          </div>
        </div>
      <div class="title">Informações avançadas</div>
      <div class="form-container-avancadas">
          <div class="form-group">
            <div class="input-group">
                <label for="cor">Cor do veículo:</label>
                <input type="text" id="cor" name="cor" placeholder="Digite a cor" class="input-avancado">
            </div>
            <div class="input-group">
                <label for="datacompra">Data da compra:</label>
                <input type="text" id="datacompra" name="datacompra" placeholder="DD/MM/AAAA" data-original-length="8" oninput="formatarData(this)" class="input-avancado">
            </div>
            <div class="input-group">
                <label for="valorcompra">Valor da compra:</label>
                <input type="text" id="valorcompra" name="valorcompra" placeholder="Digite o valor" class="input-avancado">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <label for="Altura">Altura interna: </label>
              <input type="text" id="Altura" name="Altura" placeholder="Altura interna" class="input-avancado">
            </div>
            <div class="input-group">
              <label for="Largura">Largura interna: </label>
              <input type="text" id="Largura" name="Largura" placeholder="Largura interna" class="input-avancado">
            </div>
            <div class="input-group">
              <label for="Comprimento">Comprimento interno: </label>
              <input type="text" id="Comprimento" name="Comprimento" placeholder="Comprimento interno" class="input-avancado">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <label for="Altura">Altura externa: </label>
              <input type="text" id="AlturaEx" name="AlturaEx" placeholder="Altura externa" class="input-avancado">
            </div>
            <div class="input-group">
              <label for="Largura">Largura externa: </label>
              <input type="text" id="LarguraEx" name="LarguraEx" placeholder="Largura externa" class="input-avancado">
            </div>
            <div class="input-group">
              <label for="Comprimento">Comprimento externo: </label>
              <input type="text" id="ComprimentoEx" name="ComprimentoEx" placeholder="Comprimento externo" class="input-avancado">
            </div>
          </div>
        </div>
        <div class="botoes">
        <button class="botao-acao" data-action="registrar" id="botaoRegistrar" type="submit" name="registrar">Registrar</button>
        <button class="botao-acao" data-action="alterar" id="botaoAlterar" type="submit" name="alterar">Alterar</button>
        <button class="botao-acao" data-action="excluir" id="botaoExcluir" type="submit" name="excluir">Excluir</button>
        <a href="index.php" id="botaoCancelar">Cancelar</a>
        <a id="botaoSair" href="/Site/Buscar_Caminhao/index.html">Sair</a>
      </div>
    </form>
    <form id="formDocumento" method="post" action="registrarDocVeiculo.php" enctype="multipart/form-data" autocomplete="off">
          <div class="titledoc">Documentos do veículo</div>
            <div id="documentos-section">
              <span id="spanNomeArquivo">Nenhum arquivo selecionado</span>
              <div class="Campos-preenchimento">
                <input type="hidden" id="placaDoc" name="placaDoc" value="">
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
                    <th>Id</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody id="tbody-doc">

                </tbody>
              </table>  
              <br>      
              <button id="excluirDocumento" type="submit" name="excluirDocumento">Excluir</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </body>
  <script>
      const urlParams = new URLSearchParams(window.location.search);
      const placaParam = urlParams.get('Placa');

      const placaInput = document.getElementById("Placa");

      const fragment = window.location.hash.substr(1);

      if (placaParam && placaInput) {
        placaInput.value = placaParam;
      
        const successMessage = "'<?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?>'";
      
        if (successMessage) {
        }
      
        $("#buscarDados").click();
      }
      
    </script>

</html>