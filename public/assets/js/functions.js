document.getElementById("btn-trabalhe").addEventListener("click", function () {
    document.getElementById("btn-contato").classList.remove("ativo");
    this.classList.add("ativo");

    // Mostra o formulário Trabalhe Conosco e esconde o formulário Contato
    document.querySelector(".sac-f").classList.remove("ativado");
    document.querySelector(".financeiro-f").classList.add("ativado");
});

document.getElementById("btn-contato").addEventListener("click", function () {
    document.getElementById("btn-trabalhe").classList.remove("ativo");
    this.classList.add("ativo");

    // Mostra o formulário Contato e esconde o formulário Trabalhe Conosco
    document.querySelector(".financeiro-f").classList.remove("ativado");
    document.querySelector(".sac-f").classList.add("ativado");
});

function validarFormulario() {
    $inputFile = document.querySelector("curriculo");

    if ($inputFile.files.lenght === 0) {
        alert("Por favor selecione um arquivo");
    }
}
