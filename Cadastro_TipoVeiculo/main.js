function buscartipocam() {
  $.ajax({
    type: "GET",
    url: "buscartipocam.php",
    dataType: "json",
    success: function (data) {
      const tbody = document.querySelector("tbody");
      tbody.innerHTML = ""; 

      if (data.tipocam && data.tipocam.length > 0) {
        data.tipocam.forEach(function (tipocam) {
          const newRow = tbody.insertRow();
          const cell1 = newRow.insertCell(0);
          const cell2 = newRow.insertCell(1);

          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
          checkbox.name = "excluirtipocam[]"
          checkbox.value = tipocam.id;
          cell1.appendChild(checkbox);

          cell2.textContent = tipocam.tipo;
        });
      }
    },
    error: function (error) {
      console.error("Erro ao carregar tipo de caminhão: " + error);
    },
  });
}

document.addEventListener("DOMContentLoaded", function () {
  buscartipocam();
});

document.addEventListener("DOMContentLoaded", function() {
  const inputProfissao = document.getElementById("tipocam");

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
  const inputcaminhao = document.getElementById("tipocam");
  if (inputcaminhao.value === "" || inputcaminhao.value.length <= 3) {
    alert("Preencha o campo de texto antes de adicionar uma profissão.");
    return false;
  }
  registroAtual = inputcaminhao.value;
  return true;
}

function verificaCheckbox() {
  const checkboxes = document.querySelectorAll('input[name="excluirtipocam[]"]:checked');
  if (checkboxes.length === 0) {
    alert("Selecione pelo menos uma profissão para excluir.");
    return false;
  }
  return true;
}
