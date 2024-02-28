function formatarCPF(input) {
  let value = input.value.replace(/\D/g, '');

  if (value.length > 3) {
      value = value.substring(0, 3) + '.' + value.substring(3);
  }

  if (value.length > 7) {
      value = value.substring(0, 7) + '.' + value.substring(7);
  }

  if (value.length > 11) {
      value = value.substring(0, 11) + '-' + value.substring(11);
  }

  if (value.length > 14) {
      value = value.substring(0, 14);
  }

  input.value = value;
}

function cadastrar() {
  const codigo = document.getElementById("codigo").value;
  if (codigo.length !== 14) {
    alert("CPF inválido.");
    return;
  }

  registroAtual.codigo = codigo; 

  document.getElementById("camposAdicionais").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function () {
  const registroInput = document.getElementById("registro");

  function formatarRegistro(input) {
    input.addEventListener("input", function () {
      const value = this.value.replace(/\D/g, '');
      if (value.length > 10) {
        this.value = value.slice(0, 10);
      } else {
        this.value = value;
      }
    });
  }

  formatarRegistro(registroInput);
});

document.addEventListener("DOMContentLoaded", function () {
  const registroHabInput = document.getElementById("registroHabilitacao");

  function formatarHabRegistro(input) {
    input.addEventListener("input", function () {
      const value = this.value.replace(/\D/g, '');
      if (value.length > 11) {
        this.value = value.slice(0, 11);
      } else {
        this.value = value;
      }
    });
  }

  formatarHabRegistro(registroHabInput);
});

document.addEventListener("DOMContentLoaded", function () {
  const cepInput = document.getElementById("cep");

  cepInput.addEventListener("input", (event) => {
    const value = event.target.value;
    const formattedValue = formatCep(value);
    cepInput.value = formattedValue;
  });

  function formatCep(cep) {
    const cleanedCep = cep.replace(/\D/g, "");
    const limitedCep = cleanedCep.slice(0, 8);
    const formattedCep = limitedCep.replace(/^(\d{5})(\d{3})$/, "$1-$2");
    return formattedCep;
  }
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
function formatarTelefone(input) {
  let value = input.value.replace(/\D/g, "");
  if (value.length > 10) {
    value = value.slice(0, 10);
  }
  value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
  value = value.replace(/(\d)(\d{4})$/, "$1-$2");
  input.value = value;
};

document.addEventListener("DOMContentLoaded", function () {
  const buscarDadosBtn = document.getElementById("buscarDados");
  const cpfInput = document.getElementById("codigo");
  const cpfProfInput = document.getElementById("cpfProf");
  const cpfDocInput = document.getElementById("cpfDoc");

  $(document).ready(function() {
    const cpfValue = cpfInput.value;
    cpfProfInput.value = cpfValue;
    cpfDocInput.value = cpfValue;
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

function habilitarCamposAdicionais() {
  document.getElementById("codigo").disabled = true;
  document.getElementById("camposAdicionais").style.display = "block";
}

let tipoSelect; 

document.addEventListener("DOMContentLoaded", function () {
  tipoSelect = document.getElementById("tipo");
  tipoSelect.addEventListener("change", atualizarCamposAdicionais);
});

function atualizarCamposAdicionais() {
  const selecionouMotorista = tipoSelect.value === "Motorista";
  const camposMotorista = document.getElementById("campos-Motorista");
  
  if (selecionouMotorista) {
    camposMotorista.style.display = "block";
    document.getElementById("registroHabilitacao").classList.add("campo-obrigatorio");
    document.getElementById("dataprimeiraHabilitacao").classList.add("campo-obrigatorio");
    document.getElementById("dataValidadeHabilitacao").classList.add("campo-obrigatorio");
  } else {
    camposMotorista.style.display = "none";
    document.getElementById("registroHabilitacao").classList.remove("campo-obrigatorio");
    document.getElementById("dataprimeiraHabilitacao").classList.remove("campo-obrigatorio");
    document.getElementById("dataValidadeHabilitacao").classList.add("campo-obrigatorio");
  }
}

function previewImagem(event) {
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

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("foto").addEventListener("change", previewImagem);
});

function adicionarReferenciaComercial() {
  const produto = document.getElementById("produto").value;
  const marca = document.getElementById("marca").value;

  const referenciaComercial = document.createElement("div");
  referenciaComercial.innerHTML = `<strong>Produto:</strong> ${produto}, <strong>Marca:</strong> ${marca}`;
  document.getElementById("referencias_comerciais").appendChild(referenciaComercial);

  document.getElementById("produto").value = "";
  document.getElementById("marca").value = "";
}

document.addEventListener("DOMContentLoaded", function () {
  const tipoSelect = document.getElementById("tipo");
  const camposMotorista = document.getElementById("campos-Motorista");

  function atualizarCamposAdicionais() {
    const selecionouMotorista = tipoSelect.value === "Motorista";

    if (selecionouMotorista) {
      camposMotorista.style.display = "block";
    } else {
      camposMotorista.style.display = "none";
    }
  }

  atualizarCamposAdicionais();

  tipoSelect.addEventListener("change", atualizarCamposAdicionais);
});

document.addEventListener("DOMContentLoaded", function () {
  const tipoSelect = document.getElementById("tipo");
  const camposMotorista1 = document.getElementById("campos-Motorista1");

  function atualizarCamposAdicionais() {
    const selecionouMotorista = tipoSelect.value === "Motorista";

    if (selecionouMotorista) {
      camposMotorista1.style.display = "block";
    } else {
      camposMotorista1.style.display = "none";
    }
  }

  atualizarCamposAdicionais();

  tipoSelect.addEventListener("change", atualizarCamposAdicionais);
});

function registrarFuncionario() {
  const nome = document.getElementById("nome");
  const registro = document.getElementById("registro");
  const rua = document.getElementById("rua");
  const bairro = document.getElementById("bairro");
  const cidade = document.getElementById("cidade");
  const cep = document.getElementById("cep");
  const tipoSelect = document.getElementById("tipo");
  const fotoInput = document.getElementById("foto");
  
  if (!nome.value || !registro.value || !rua.value || !bairro.value || !cidade.value || !cep.value) {
    alert("Preencha os campos de motoristas restantes.");
    return false;
    
  } else if (tipoSelect.value === "Motorista") {
    const registroHabilitacao = document.getElementById("registroHabilitacao");
    const dataprimeiraHabilitacao = document.getElementById("dataprimeiraHabilitacao");
    const dataValidadeHabilitacao = document.getElementById("dataValidadeHabilitacao");

    if (!registroHabilitacao.value || !dataprimeiraHabilitacao.value || !dataValidadeHabilitacao.value) {
      alert("Preencha os campos de motoristas restantes.");
      return false;
    }
  } else if (!fotoInput.files || !fotoInput.files.length === 0) {
    alert("Selecione uma foto de perfil");
    return false;
  } else {
    return true;
  }
}

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

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("botaoExcluir").addEventListener("click", function (e) {
    var confirmacao = confirm("Tem certeza de que deseja excluir esses dados?");
  
    if (!confirmacao) {
      e.preventDefault();
    }
  });
});

function cadastrarComerciais(){
  const telefoneInput = document.getElementById("Telefone-com");
  const nomeInput = document.getElementById("nome-com");
  if (telefoneInput.length !== 14) {
    alert("Telefone inválido.");
    return;
  } else if (!telefoneInput.value || !nomeInput.value){
    alert("Campos vazios. Preencha-os corretamente.");
    return;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("botaoExcluir").addEventListener("click", function (e) {
    const registro = document.getElementById("registro");
    const nome = document.getElementById("nome");
    const cep = document.getElementById("cep");
    const rua = document.getElementById("rua");
    const bairro = document.getElementById("bairro");
    const cidade = document.getElementById("cidade");

    if (!registro.value || !nome.value || !cep.value || !rua.value || !bairro.value || !cidade.value) {
      alert("Campo(s) vazio(s)! Preencha todos os campos corretamente!")
    } else if (registro.value.length < 10) {
      alert("Registro inválido! Digite um registro com 10 caracteres!");
      e.preventDefault();
    } else if (cep.value.lenght < 9) {
      alert("Cep inválido!");
      e.preventDefault();
    }
  });

  document.getElementById("botaoRegistrar").addEventListener("click", function (e) {
    const registro = document.getElementById("registro");
    const nome = document.getElementById("nome");
    const cep = document.getElementById("cep");
    const rua = document.getElementById("rua");
    const bairro = document.getElementById("bairro");
    const cidade = document.getElementById("cidade");

    if (!registro.value || !nome.value || !cep.value || !rua.value || !bairro.value || !cidade.value) {
      alert("Campo(s) vazio(s)! Preencha todos os campos corretamente!")
    } else if (registro.value.length < 10) {
      alert("Registro inválido! Digite um registro com 10 caracteres!");
      e.preventDefault();
    } else if (cep.value.lenght < 9) {
      alert("Cep inválido!");
      e.preventDefault();
    } 
  });

  document.getElementById("botaoAlterar").addEventListener("click", function (e) {
    const registro = document.getElementById("registro");
    const nome = document.getElementById("nome");
    const cep = document.getElementById("cep");
    const rua = document.getElementById("rua");
    const bairro = document.getElementById("bairro");
    const cidade = document.getElementById("cidade");
    
    if (!registro.value || !nome.value || !cep.value || !rua.value || !bairro.value || !cidade.value) {
    alert("Campo(s) vazio(s)! Preencha todos os campos corretamente!")
    } else if (registro.value.length < 10) {
      alert("Registro inválido! Digite um registro com 10 caracteres!");
      e.preventDefault();
    } else if (cep.value.lenght < 9) {
      alert("Cep inválido!");
      e.preventDefault();
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

function cadastrarProfissionais(){
  const telefoneProfInput = document.getElementById("telefone-prof");
  const empresa = document.getElementById("empresa");
  if (telefoneProfInput.length !== 14) {
    alert("Telefone inválido.");
    return;
  } else if (!telefoneProfInput.value || !empresa.value){
    alert("Campos vazios. Preencha-os corretamente.")
    return;
  }
}

function buscarDocumentos(cpfValue) {
  const cpfDocInput = document.getElementById("cpfDoc");
  cpfDocInput.value = cpfValue;

  const tbodyDocTable = document.getElementById("tbody-doc");

  fetch("buscarDocumentos.php", {
    method: "POST",
    body: new URLSearchParams({ cpfDoc: cpfValue }),
  })
    .then((response) => response.json())
    .then((data) => {
      tbodyDocTable.innerHTML = "";
      if (data.documentos && data.documentos.length > 0) {
        data.documentos.forEach(function (documento) {
          const newRow = tbodyDocTable.insertRow();
          const cell1 = newRow.insertCell(0);

          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
          checkbox.name = "excluirDocumentos[]"
          checkbox.value = documento.id_documentos;
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

function buscarDadosComerciais(cpfValue) {
  const cpfComInput = document.getElementById("cpfCom");
  cpfComInput.value = cpfValue;
  
  const tbodyComTable = document.getElementById("tbody-com");

  const telefoneInput = document.getElementById("Telefone-com");
  
  telefoneInput.addEventListener("input", () => {
    formatarTelefone(telefoneInput);
  });

  fetch("buscarComerciais.php", {
    method: "POST",
    body: new URLSearchParams({ cpfCom: cpfValue }),
  })
  .then((response) => response.json())
  .then((data) => {

    tbodyComTable.innerHTML = "";
      if (data.referencias_comerciais && data.referencias_comerciais.length > 0) {
        data.referencias_comerciais.forEach(function (referencia) {
          const newRow = tbodyComTable.insertRow();
          const cell1 = newRow.insertCell(0);
          const cell2 = newRow.insertCell(1);
          const cell3 = newRow.insertCell(2);

          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
          checkbox.name = "excluirReferenciasComerciais[]"
          checkbox.value = referencia.id_comerciais;
          cell1.appendChild(checkbox);

          cell2.textContent = referencia.nome_comercial;
          cell3.textContent = referencia.telefone_comercial;

          console.log("Dados retornados na tabela.");
        });
      } else {
        console.log("Nenhuma referência registrada!");
      }
    })
    .catch((error) => {
      console.error("Erro ao carregar referências comerciais: " + error);
    });
}

function buscarDadosProfissionais(cpfValue) {
  const cpfProfInput = document.getElementById("cpfProf"); 
  cpfProfInput.value = cpfValue;

  const tbodyProfTable = document.getElementById("tbody-prof"); 

  const telefoneProfInput = document.getElementById("telefone-prof");
  telefoneProfInput.addEventListener("input", () => {
    formatarTelefone(telefoneProfInput);
  });
  
  fetch("buscarProfissionais.php", {
    method: "POST",
    body: new URLSearchParams({ cpfProf: cpfValue }), 
  })
  .then((response) => response.json())
  .then((data) => {

      tbodyProfTable.innerHTML = ""; 
      if (data.referencias_profissionais && data.referencias_profissionais.length > 0) {
        data.referencias_profissionais.forEach(function (referencia) {
          const newRow = tbodyProfTable.insertRow();
          const cell1 = newRow.insertCell(0);
          const cell2 = newRow.insertCell(1);
          const cell3 = newRow.insertCell(2);

          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
          checkbox.name = "excluirReferenciasProfissionais[]"
          checkbox.value = referencia.id_profissional;
          cell1.appendChild(checkbox);
          cell2.textContent = referencia.telefone;
          cell3.textContent = referencia.nome_empresa;

          console.log("Dados de referências profissionais retornados na tabela.");
        });
      } else {
        console.log("Nenhuma referência profissional registrada!");
      }
    })
    .catch((error) => {
      console.error("Erro ao carregar referências profissionais: " + error);
    });
}

$(document).ready(function() {
  var cpf = $("#codigo").val();
  $.ajax({
      type: "POST",
      url: "buscarDados.php",
      data: { cpf: cpf },
      dataType: "json",
      success: function(data) {
        $("#registro").val(data.registro);
        $("#nome").val(data.nome);
        $("#tipo").val(data.tipo);
        $("#rua").val(data.rua);
        $("#bairro").val(data.bairro);
        $("#cidade").val(data.cidade);
        $("#UF").val(data.uf);
        $("#cep").val(data.cep);
        $("#imagemPreview").attr("src", data.foto);
        console.log("Tipo: ", data.tipo);

        if (data.tipo === "Motorista") {
          $("#registroHabilitacao").val(data.registro_habilitacao);
          $("#dataprimeiraHabilitacao").val(data.data_primeira_habilitacao);
          $("spanHabilitacao").text(data.tipo_habilitacao);
          $("#dataValidadeHabilitacao").val(data.data_validade_habilitacao);
          $("#campos-Motorista1").show();
          $("#campos-Motorista").show();
          if (data.letrasResult['A'] === true) {
            $('#habilitacaoA').prop('checked', true);
          } else { $('#habilitacaoA').prop('checked', false);}
          if (data.letrasResult['B'] === true) {
            $('#habilitacaoB').prop('checked', true);
          } else { $('#habilitacaoB').prop('checked', false);}
          if (data.letrasResult['C'] === true) {
            $('#habilitacaoC').prop('checked', true);
          } else { $('#habilitacaoC').prop('checked', false);}
          if (data.letrasResult['D'] === true) {
            $('#habilitacaoD').prop('checked', true);
          } else { $('#habilitacaoD').prop('checked', false);}
          if (data.letrasResult['E'] === true) {
            $('#habilitacaoE').prop('checked', true);
          } else { $('#habilitacaoE').prop('checked', false);}
        } else {
          $("#campos-Motorista1").hide();
          $("#campos-Motorista").hide();
        }

        $("#botaoRegistrar").hide();
        $("#botaoRegistrar").prop("disabled", true);
        $("#botaoAlterar").show();
        $("#botaoAlterar").prop("disabled", false);
        $("#botaoExcluir").show();
        $("#botaoExcluir").prop("disabled", false);

        if (data.registro !== undefined && data.nome !== undefined) {
          $(".title").show();
          $("#documentos-section").show();
          buscarDocumentos(cpf);
          const spanNomeArquivo = document.getElementById("spanNomeArquivo");
          if (spanNomeArquivo) {
            spanNomeArquivo.addEventListener("change", function (event) {
              mostrarNomeArquivo(event.target);
            });
          }
          $("#referencias-comerciais").show();
          buscarDadosComerciais(cpf);
          $("#referencias-profissionais").show();
          buscarDadosProfissionais(cpf);
        } else {
          $("#tipo").val("Motorista");
          $("#campos-Motorista1").show();
          $("#campos-Motorista").show();
          $("#UF").val("MG");
          $("#imagemPreview").attr("src", "");
          $("#botaoRegistrar").show();
          $("#botaoRegistrar").prop("disabled", false);
          $("#botaoAlterar").hide();
          $("#botaoAlterar").prop("disabled", true);
          $("#botaoExcluir").hide();
          $("#botaoExcluir").prop("disabled", true);
          $(".title").hide();
          $("#documentos-section").hide();
          $("#referencias-comerciais").hide();
          $("#referencias-profissionais").hide();
        }
    },
      error: function(error) {
      if (error.responseJSON && error.responseJSON.error) {
          alert("Erro: " + error.responseJSON.error);
      } else {
          alert("Ocorreu um erro desconhecido.");
      }
    }
  });
});