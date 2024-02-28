var acaoSelecionada = "";

function adicionarProfissao() {
    acaoSelecionada = "adicionar";
    $('#idprof-wrapper').hide();
    $('#Adicionar').prop('disabled', true);
    $('#Alterar').prop('disabled', false);
    $('#Excluir').prop('disabled', false);
}

function alterarProfissao() {
    acaoSelecionada = "alterar";
    $('#idprof-wrapper').show();
    $('#Adicionar').prop('disabled', false);
    $('#Alterar').prop('disabled', true);
    $('#Excluir').prop('disabled', false);
}

function excluirProfissao() {
    acaoSelecionada = "excluir";
    $('#idprof-wrapper').hide();
    $('#Adicionar').prop('disabled', false);
    $('#Alterar').prop('disabled', false);
    $('#Excluir').prop('disabled', true);
}

$('#Executar').click(function() {
    if (acaoSelecionada === "adicionar") {
        alert('Profissão adicionada!');
    } else if (acaoSelecionada === "alterar") {
        alert('Profissão alterada!');
    } else if (acaoSelecionada === "excluir") {
        alert('Profissão excluída!');
    }
});

$('a[name="btn-sair"]').click(function() {
    acaoSelecionada = "";
    $('#idprof-wrapper').hide();
    $('#Adicionar').prop('disabled', false);
    $('#Alterar').prop('disabled', false);
    $('#Excluir').prop('disabled', false);
});
function buscarProfissoes() {
  $.ajax({
    type: "GET",
    url: "buscarProfissoes.php",
    dataType: "json",
    success: function (data) {
      const tbody = document.querySelector("tbody");
      tbody.innerHTML = ""; 

      if (data.profissoes && data.profissoes.length > 0) {
        data.profissoes.forEach(function (profissoes) {
          const newRow = tbody.insertRow();
          const cell1 = newRow.insertCell(0);
          const cell2 = newRow.insertCell(1);

          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
          checkbox.name = "excluirProfissoes[]";
          checkbox.value = profissoes.id;
          cell1.appendChild(checkbox);

          cell2.textContent = profissoes.tipo;
        });
      }
    },
    error: function (error) {
      console.error("Erro ao carregar profissões: " + error);
    },
  });
}

document.addEventListener("DOMContentLoaded", function () {
  buscarProfissoes();
});

document.addEventListener("DOMContentLoaded", function() {
  const inputProfissao = document.getElementById("profissoes");

  inputProfissao.addEventListener("input", function() {
      const textoDigitado = inputProfissao.value;
      const textoFormatado = formatarTexto(textoDigitado);
      inputProfissao.value = textoFormatado;
  });

  function formatarTexto(texto) {
      return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
  }
});

let registroAtual = {};

function verificaNulo() {
  const inputProfissao = document.getElementById("profissoes");
  if (inputProfissao.value === "" || inputProfissao.value.length <= 3) {
    alert("Preencha o campo de texto antes de adicionar uma profissão.");
    return false;
  }
  registroAtual = inputProfissao.value;
  return true;
}

function verificaCheckbox() {
  const checkboxes = document.querySelectorAll('input[name="excluirProfissoes[]"]:checked');
  if (checkboxes.length === 0) {
    alert("Selecione pelo menos uma profissão para excluir.");
    return false;
  }
  return true;
}

