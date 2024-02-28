document.addEventListener("DOMContentLoaded", function() { //formatar placa
    const inputPlaca = document.getElementById("searchInput");

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
        if (tipoPesquisa === "placa") {
            formatarPlaca(this);
            inputValue = "";
        } 
    });

    $("#searchType").trigger("change");
});

function formatarCampoPesquisa(input) {
    var tipoPesquisa = $("#searchType").val();
    if (tipoPesquisa === "placa") {
        formatarPlaca(input);
    }
}