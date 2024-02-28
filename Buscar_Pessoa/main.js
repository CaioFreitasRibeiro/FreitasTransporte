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

function formatarNome(input) {
    let value = input.value.replace(/[^a-zA-Zá-úÁ-Ú\s]/g, ''); 

    if (value.length > 50) {
        value = value.substring(0, 50);
    }

    input.value = value;
}

function formatarRegistro(input) {
    input.addEventListener("input", function () {
      const value = this.value.replace(/\D/g, '');
      if (value.length > 10) {
        this.value = value.slice(0, 10);
      } else {
        this.value = value + "";
      }
    });
}

$(document).ready(function() {
    $("#searchType, #searchInput").on("input", function() {
        realizarPesquisa();
    });

    function realizarPesquisa() {
        var tipoPesquisa = $("#searchType").val();
        var inputValue = $("#searchInput").val();

        $.ajax({
            type: "POST",
            url: "buscarResultados.php", 
            data: { tipoPesquisa: tipoPesquisa, inputValue: inputValue },
            success: function(response) {
                $("#resultados").html(response);
            },
            error: function(error) {
                console.error("Erro na requisição AJAX: ", error);
            }
        });
    }
    
    realizarPesquisa();

    $("#searchInput").on("input", function() {
        var tipoPesquisa = $("#searchType").val();
        if (tipoPesquisa === "cpf") {
            formatarCPF(this);
            inputValue = "";
        } else if (tipoPesquisa === "nome") {
            formatarNome(this);
            inputValue = "";
        } else if (tipoPesquisa === "registro") {
            formatarRegistro(this);
            inputValue = "";
        }
    });

    $("#searchType").trigger("change");
});



function formatarCampoPesquisa(input) {
    var tipoPesquisa = $("#searchType").val();
    if (tipoPesquisa === "cpf") {
        formatarCPF(input);
    } else if(tipoPesquisa === "nome") {
        formatarNome(input);
    } else if (tipoPesquisa === "registro"){
        formatarRegistro(input);
    }
}