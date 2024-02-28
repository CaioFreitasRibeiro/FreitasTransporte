document.addEventListener("DOMContentLoaded", function() { //formatar placa
  const inputPlaca = document.getElementById("Placa");
  
  inputPlaca.addEventListener("input", function() {
      const textoDigitado = inputPlaca.value;
      const textoFormatado = formatarPlaca(textoDigitado);
      inputPlaca.value = textoFormatado;
  });

  inputPlaca.addEventListener("keydown", function(event) {
      if (event.key === "Backspace") {
          const textoAtual = inputPlaca.value;
          if (textoAtual.endsWith("-")) {
              inputPlaca.value = textoAtual.substring(0, textoAtual.length - 1);
          }
      }
  });

  function formatarPlaca(texto) {
    let placaFormatada = "";

    for (let i = 0; i < 4 && i < texto.length; i++) {
        const char = texto[i];
        if (/^[a-zA-Z]$/.test(char)) {
            placaFormatada += char.toUpperCase();
        }
    }

    if (texto.length >= 3){placaFormatada += "-";}

    if (texto.length >= 5 && /[0-9]/.test(texto[4])) {
        placaFormatada += texto[4];
    }

    if (texto.length >= 6 && /[a-zA-Z0-9]/.test(texto[5])) {
        placaFormatada += texto[5].toUpperCase();
    }

    for (let i = 6; i < 8 && i < texto.length; i++) {
        if (/[0-9]/.test(texto[i])) {
            placaFormatada += texto[i];
        }
    }
    
    return placaFormatada;
  }
});

let registroAtual = {};

function cadastrar() {
  const Placa = document.getElementById("Placa").value;
  if (Placa.length !== 8) {
    alert("Digite uma placa válida.");
    return;
  }
  registroAtual.Placa = Placa; 

  document.getElementById("camposAdicionais").style.display = "block";
}

function previewImagem(event) { //preview da imagem
  console.log("Preview da imagem chamada");
  const input = event.target;
  const imagemPreview = document.getElementById("imagemPreview");
  
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imagemPreview.src = e.target.result;
      imagemPreview.style.display = "block";
      input.classList.remove("required-field");
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    imagemPreview.style.display = "none";
    input.classList.add("required-field");
  }
}

document.addEventListener("DOMContentLoaded", function () { //preview da imagem
  document.getElementById("foto").addEventListener("change", previewImagem);
});

function formatarData(input) {
  const value = input.value.replace(/\D/g, '');
  const originalLength = input.getAttribute('data-original-length');

  if (value.length > 4) {
    const day = value.substring(0, 2);
    const month = value.substring(2, 4);
    const year = value.substring(4, 8);

    input.value = `${day}/${month}/${year}`;
  } else if (value.length > 2) {
    const day = value.substring(0, 2);
    const month = value.substring(2, 4);

    input.value = `${day}/${month}`;
  } else if (value.length > 0 && value.length <= originalLength) {
    input.value = `${value}`;
  } else {
    input.value = '';
  }
}

document.addEventListener("DOMContentLoaded", function () { //ano fabricação
  const anoInput = document.getElementById("anofabricacao");

  function formatarAno(input) {
    input.addEventListener("input", function () {
      const value = this.value.replace(/\D/g, '');
      if (value.length > 4) {
        this.value = value.slice(0, 4);
      } else {
        this.value = value;
      }
    });
  }

  formatarAno(anoInput);
});

function formatarNumeroMilenario(numero) {
    let numeroString = numero.toString();
    let partes = numeroString.split('.');
    let parteInteiraFormatada = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    let parteDecimalFormatada = partes.length > 1 ? '.' + partes[1] : '';
    let numeroFormatado = parteInteiraFormatada + parteDecimalFormatada;

    return numeroFormatado;
}

document.addEventListener('DOMContentLoaded', function () { //valor compra, altura, largura e comprimento
  const inputValorCompra = document.getElementById('valorcompra');
  const inputAltura = document.getElementById("Altura");
  const inputComprimento = document.getElementById("Comprimento");
  const inputLargura = document.getElementById("Largura");
  const inputAlturaEx = document.getElementById("AlturaEx");
  const inputComprimentoEx = document.getElementById("ComprimentoEx");
  const inputLarguraEx = document.getElementById("LarguraEx");

  inputValorCompra.addEventListener('click', function () {
    const lengthCompra = inputValorCompra.value.length;
    inputValorCompra.setSelectionRange(lengthCompra, lengthCompra);
  });

  inputValorCompra.addEventListener('input', function () {
    const valorDigitadoCompra = inputValorCompra.value.replace(/\D/g, ''); 
    const valorNumericoCompra = parseFloat(valorDigitadoCompra) / 100; 
    valorNumericoCompra.toLocaleString('pt-BR');

    inputValorCompra.value = 'R$' + valorNumericoCompra.toFixed(2);
    if (inputValorCompra.value == "R$0.00" || inputValorCompra.value == "R$NaN") {
      inputValorCompra.value = "";
    }
  });

  inputAltura.addEventListener('click', function () {
    const lengthAltura = inputAltura.value.length;
    inputAltura.setSelectionRange(lengthAltura, lengthAltura);
  });

  inputAltura.addEventListener('input', function () {
    const valorDigitadoAltura = inputAltura.value.replace(/\D/g, ''); 
    const valorNumericoAltura = parseFloat(valorDigitadoAltura) / 100;
    valorNumericoAltura.toLocaleString('pt-BR');

    inputAltura.value = valorNumericoAltura.toFixed(2);
    if (inputAltura.value == "0.00" || inputAltura.value == "NaN" ) {
      inputAltura.value = "";
    }
  });

  inputComprimento.addEventListener('click', function () {
    const lengthComprimento = inputComprimento.value.length;
    inputComprimento.setSelectionRange(lengthComprimento, lengthComprimento);
  });

  inputComprimento.addEventListener('input', function () {
    const valorDigitadoComprimento = inputComprimento.value.replace(/\D/g, ''); 
    const valorNumericoComprimento = parseFloat(valorDigitadoComprimento) / 100; 
    valorNumericoComprimento.toLocaleString('pt-BR');

    inputComprimento.value = valorNumericoComprimento.toFixed(2);
    if (inputComprimento.value == "0.00" || inputComprimento.value == "NaN" ) {
      inputComprimento.value = "";
    }
  });

  inputLargura.addEventListener('click', function () {
    const lengthLargura = inputLargura.value.length;
    inputLargura.setSelectionRange(lengthLargura, lengthLargura);
  });

  inputLargura.addEventListener('input', function () {
    const valorDigitadoLargura = inputLargura.value.replace(/\D/g, ''); 
    const valorNumericoLargura= parseFloat(valorDigitadoLargura) / 100; 
    valorNumericoLargura.toLocaleString('pt-BR');

    inputLargura.value = valorNumericoLargura.toFixed(2);
    if (inputLargura.value == "0.00" || inputLargura.value == "NaN" ) {
      inputLargura.value = "";
    }
  });

  inputAlturaEx.addEventListener('click', function () {
    const lengthAlturaEx = inputAlturaEx.value.length;
    inputAlturaEx.setSelectionRange(lengthAlturaEx, lengthAlturaEx);
  });

  inputAlturaEx.addEventListener('input', function () {
    const valorDigitadoAlturaEx = inputAlturaEx.value.replace(/\D/g, ''); 
    const valorNumericoAlturaEx = parseFloat(valorDigitadoAlturaEx) / 100; 
    valorNumericoAlturaEx.toLocaleString('pt-BR');

    inputAlturaEx.value = valorNumericoAlturaEx.toFixed(2);
    if (inputAlturaEx.value == "0.00" || inputAlturaEx.value == "NaN" ) {
      inputAlturaEx.value = "";
    }
  });

  inputComprimentoEx.addEventListener('click', function () {
    const lengthComprimento = inputComprimento.value.length;
    inputComprimento.setSelectionRange(lengthComprimento, lengthComprimento);
  });

  inputComprimentoEx.addEventListener('input', function () {
    const valorDigitadoComprimentoEx = inputComprimentoEx.value.replace(/\D/g, ''); 
    const valorNumericoComprimentoEx = parseFloat(valorDigitadoComprimentoEx) / 100; 
    valorNumericoComprimentoEx.toLocaleString('pt-BR');

    inputComprimentoEx.value = valorNumericoComprimentoEx.toFixed(2);
    if (inputComprimentoEx.value == "0.00" || inputComprimentoEx.value == "NaN" ) {
      inputComprimentoEx.value = "";
    }
  });

  inputLarguraEx.addEventListener('click', function () {
    const lengthLarguraEx = inputLarguraEx.value.length;
    inputLarguraEx.setSelectionRange(lengthLarguraEx, lengthLarguraEx);
  });

  inputLarguraEx.addEventListener('input', function () {
    const valorDigitadoLarguraEx = inputLarguraEx.value.replace(/\D/g, ''); 
    const valorNumericoLarguraEx= parseFloat(valorDigitadoLarguraEx) / 100; 
    valorNumericoLarguraEx.toLocaleString('pt-BR');

    inputLarguraEx.value = valorNumericoLarguraEx.toFixed(2);
    if (inputLarguraEx.value == "0.00" || inputLarguraEx.value == "NaN" ) {
      inputLarguraEx.value = "";
    }
  });
});

document.addEventListener("DOMContentLoaded", function () { //renavam
  const inputRenavam = document.getElementById("renavam");

  inputRenavam.addEventListener("input", function () {
      const renavam = inputRenavam.value;
      const renavamFormatado = formatarRenavam(renavam);
      inputRenavam.value = renavamFormatado;
  });

  inputRenavam.addEventListener("keydown", function (event) {
    if (event.key === "Backspace") {
      const renavamAtual = inputRenavam.value;
      if (renavamAtual.endsWith("-") || renavamAtual.endsWith(".")) {
        inputRenavam.value = renavamAtual.substring(0, renavamAtual.length - 1);
        event.preventDefault();
      }
    }
  });

  function formatarRenavam(renavam) {
    renavam = renavam.replace(/[^0-9]/g, "");
  
    if (renavam.length > 11) {
      renavam = renavam.substr(0, 11);
    }
    return renavam;
  }
})

document.addEventListener("DOMContentLoaded", function () { //chassi
  const inputChassi = document.getElementById("chassi");

  inputChassi.addEventListener("input", function () {
    const chassi = inputChassi.value;
    const chassiFormatado = formatarChassi(chassi);
    inputChassi.value = chassiFormatado;
  });

  inputChassi.addEventListener("keydown", function (event) {
    if (event.key === "Backspace") {
      const chassiAtual = inputChassi.value;
      if (chassiAtual.endsWith("-")) {
        inputChassi.value = chassiAtual.substring(0, chassiAtual.length - 1);
        event.preventDefault();
      }
    }
  });

  function formatarChassi(chassi) {
    chassi = chassi.replace(/[^0-9A-Za-z]/g, "");

    chassi = chassi.substr(0, 18);

    return chassi.toUpperCase(chassi);
  }
});

/*document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("botaoSair").addEventListener("click", function (e) {
    var confirmacao = confirm("Tem certeza de que deseja voltar para o menu?");
  
    if (!confirmacao) {
      e.preventDefault();
    }
  });
});*/

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("botaoExcluir").addEventListener("click", function (e) {
    var confirmacao = confirm("Tem certeza de que deseja excluir esses dados?");
  
    if (!confirmacao) {
      e.preventDefault();
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const inputPDF = document.getElementById("documentoInput");
  
  const nomeArquivoSpan = document.getElementById("spanNomeArquivo");
  
  inputPDF.addEventListener("change", function () {
    if (inputPDF.files.length > 0) {
      const nomeArquivo = inputPDF.files[0].name;
    
      nomeArquivoSpan.textContent = "Arquivo selecionado: " + nomeArquivo;
    } else {
      nomeArquivoSpan.textContent = "Nenhum arquivo selecionado";
    }
  });
});

function permitirSaida() {
  window.onbeforeunload = null;
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("botaoCancelar").addEventListener("click", function (e) {
    var confirmacao = confirm("Tem certeza de que deseja cancelar? Alguns dados podem não ser salvos.");
  
    if (!confirmacao) {
      e.preventDefault();
    } else {
      window.onbeforeunload = location.reload();
      permitirSaida();
    }
  });
});

function Docnull(){
  const arquivo = document.getElementById("documentoInput");
  const descDoc = document.getElementById("descricaoDocumento");

  if (!arquivo.value || !descDoc.value)
  {
    alert("Campos vazios. Preencha-os corretamente.");
    arquivo
  }
}

function buscarDocumentos(PlacaValue) {
  const placaDocInput = document.getElementById("placaDoc");
  placaDocInput.value = PlacaValue;
  
  const tbodyDocTable = document.getElementById("tbody-doc");

  fetch("buscarDocumentos.php", {
    method: "POST",
    body: new URLSearchParams({ placaDoc: PlacaValue }),
  })
  .then((response) => response.json())
  .then((data) => {
    tbodyDocTable.innerHTML = "";
    if (data.documento_caminhao && data.documento_caminhao.length > 0) {
      data.documento_caminhao.forEach(function (documento) {
        const newRow = tbodyDocTable.insertRow();
        const cell1 = newRow.insertCell(0);

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.name = "excluirDocumentos[]"
        checkbox.value = documento.id;
        cell1.appendChild(checkbox);
       
        const cell2 = newRow.insertCell(1); 
        const cell3 = newRow.insertCell(2);

        cell2.textContent = documento.descricao;
        const visualizarLink = document.createElement("a");
        visualizarLink.textContent = "Visualizar";
        visualizarLink.href = documento.arquivos;
        visualizarLink.target = "_blank";

        cell3.appendChild(visualizarLink);
        console.log("Dados de documentos retornados na tabela.");
      });
    } else {
      console.log("Nenhum documento registrado!");
    }
  })
  .catch((error) => {
    console.error("Erro ao carregar documentos: " + error);
  });
}

$(document).ready(function() {
  console.log("Documento carregado");
  var placa = $("#Placa").val();
  $.ajax({
      type: "POST",
      url: "buscarDados.php",
      data: { placa: placa },
      dataType: "json",
      success: function(data) {
        $("#modelo").val(data.modelo);
        $("#anofabricacao").val(data.anofabricacao);
        $("#renavam").val(data.renavam);
        $("#chassi").val(data.chassi);
        if (data.datacompra !="0000-00-00"){
          $("#datacompra").val(data.datacompra);
        } else {$("#datacompra").val("");}
        if (data.valorcompra > 0){
          $("#valorcompra").val("R$" + data.valorcompra);
        } else { $("#valorcompra").val("");}
        $("#tipocaminhao").val(data.tipocaminhao);
        $("#tipocombustivel").val(data.tipocombustivel);
        $("#cor").val(data.cor);
        if(data.altura > 0){
          $("#Altura").val(data.altura);
        } else {$("#Altura").val("");}
        if(data.comprimento > 0){
          $("#Comprimento").val(data.comprimento);
        } else {$("#Comprimento").val("");}
        $("#Largura").val(data.largura);
        if(data.largura > 0){
          $("#Largura").val(data.largura);
        } else {$("#Largura").val("");}
        if(data.alturaEx > 0){
          $("#AlturaEx").val(data.alturaEx);
        } else {$("#AlturaEx").val("");}
        if(data.comprimentoEx > 0){
          $("#ComprimentoEx").val(data.comprimentoEx);
        } else {$("#ComprimentoEx").val("");}
        $("#LarguraEx").val(data.larguraEx);
        if(data.larguraEx > 0){
          $("#LarguraEx").val(data.larguraEx);
        } else {$("#LarguraEx").val("");}
        $("#imagemPreview").attr("src", data.foto);

        $("#botaoRegistrar").hide();
        $("#botaoRegistrar").prop("disabled", true);
        $("#botaoAlterar").show();
        $("#botaoAlterar").prop("disabled", false);
        $("#botaoExcluir").show();
        $("#botaoExcluir").prop("disabled", false);
        $("#botaoSair").on('click', function(){
          var confirmacao = confirm("Tem certeza de que deseja voltar para o menu?");
          if (!confirmacao) {
            e.preventDefault();
          }
        });    
        
        if (data.modelo !== undefined && data.renavam !== undefined) {
          $("#documentos-section").show();
          $(".titledoc").show();
          buscarDocumentos(placa);
          const spanNomeArquivo = document.getElementById("spanNomeArquivo");
          if (spanNomeArquivo) {
            spanNomeArquivo.addEventListener("change", function (event) {
              mostrarNomeArquivo(event.target);
            });
          }
        } else {
          $("#imagemPreview").attr("src", "");
          $("#tipocaminhao").val("Baú");
          $("#tipocombustivel").val("Diesel");
          $("#botaoRegistrar").show();
          $("#botaoRegistrar").prop("disabled", false);
          $("#botaoAlterar").hide();
          $("#botaoAlterar").prop("disabled", true);
          $("#botaoExcluir").hide();
          $("#botaoExcluir").prop("disabled", true);
          $(".titledoc").hide();
          $("#documentos-section").hide();
          $("#botaoSair").on('click', function(){
            window.location.href = "/Site/Buscar_Caminhao/index.html";
          });
        }
    },
      error: function(error) {
          alert("Erro: " + error.responseJSON.error);
      }
  });
});
/*
function salvarDadosTemporarios() {
  var timestamp = new Date().getTime();
  var formData = {
      placa: document.getElementById("Placa").value,
      modelo: document.getElementById("modelo").value,
      anofabricacao: document.getElementById("anofabricacao").value,
      renanam: document.getElementById("renavam").value,
      chassi: document.getElementById("chassi").value,
      tipoVeiculo: document.getElementById("tipocaminhao").value,
      tipoCombustivel: document.getElementById("tipocombustivel").value,
      cor: document.getElementById("cor").value,
      dataCompra: document.getElementById("datacompra").value,
      valorCompra: document.getElementById("valorcompra").value,
      alturaIN: document.getElementById("Altura").value,
      alturaEX: document.getElementById("AlturaEx").value,
      larguraIN: document.getElementById("Largura").value,
      larguraEX: document.getElementById("LarguraEx").value,
      comprimentoIN: document.getElementById("Comprimento").value,
      comprimentoEX: document.getElementById("ComprimentoEx").value,
      timestamp: timestamp
  };

  localStorage.setItem('tempDataVeiculo', JSON.stringify(formData));
}

window.onbeforeunload = function () {
  salvarDadosTemporarios();
};

function limparDadosTemporarios() {
  localStorage.removeItem('tempDataVeiculo');
}

document.addEventListener("DOMContentLoaded", function () {
  var cachedData = localStorage.getItem('tempDataVeiculo');

  if (cachedData) {
    var formData = JSON.parse(cachedData);
    var currentTime = new Date().getTime();
    var timeDifference = (currentTime - formData.timestamp) / (1000 * 60);

    if (timeDifference < 10) {
      document.getElementById("Placa").value = formData.placa;
      document.getElementById("modelo").value = formData.modelo;
      document.getElementById("anofabricacao").value = formData.anofabricacao;
      document.getElementById("renavam").value = formData.renavam;
      document.getElementById("chassi").value = formData.chassi;
      document.getElementById("tipocaminhao").value = formData.tipoVeiculo;
      document.getElementById("tipocombustivel").value = formData.tipoCombustivel;
      document.getElementById("cor").value = formData.cor;
      document.getElementById("datacompra").value = formData.dataCompra;
      document.getElementById("valorcompra").value = formData.valorCompra;
      document.getElementById("Altura").value = formData.alturaIN;
      document.getElementById("AlturaEx").value = formData.alturaEX;
      document.getElementById("Largura").value = formData.larguraIN;
      document.getElementById("LarguraEx").value = formData.larguraEX;
      document.getElementById("Comprimento").value = formData.comprimentoIN;
      document.getElementById("ComprimentoEx").value = formData.comprimentoEX;
    } else {
      limparDadosTemporarios();
    }
  }

  localStorage.removeItem('tempDataVeiculo');

  var botaoTipo = document.getElementById("botaoTipo");
  if (botaoTipo) {
      botaoTipo.addEventListener("click", function () {
          salvarDadosTemporarios();
          document.cookie = "dadosSalvos=true";
      });
  }
});

document.getElementById("formCaminhao").addEventListener("submit", function () {
  limparDadosTemporarios();
});

document.getElementById("botaoRegistrar").addEventListener("click", function () {
  limparDadosTemporarios();
});

document.getElementById("botaoCancelar").addEventListener("click", function () {
  limparDadosTemporarios();
});

document.getElementById("botaoSair").addEventListener("click", function () {
  limparDadosTemporarios();
});


window.addEventListener("beforeunload", function () {
  var dadosSalvos = document.cookie.replace(/(?:(?:^|.*;\s*)dadosSalvos\s*=\s*([^;]*).*$)|^.*$/, "$1");

  if (dadosSalvos !== "true") {
      salvarDadosTemporarios();
  }
});*/