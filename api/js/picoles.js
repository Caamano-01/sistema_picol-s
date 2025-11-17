document.addEventListener("DOMContentLoaded", async () => {
    await carregarCombos();

    document.getElementById("formPicole").addEventListener("submit", async (e) => {
        e.preventDefault();

        const dados = {
            nome: document.getElementById("nome").value,
            tipo: document.getElementById("tipo").value,
            id_sabor: document.getElementById("sabor").value,
            id_embalagem: document.getElementById("embalagem").value
        };

        await apiPost("picole.php", dados);

        alert("Picolé cadastrado com sucesso!");
        e.target.reset();
    });
});

async function carregarCombos() {
    const sabores = await apiGet("sabor.php");
    const embalagens = await apiGet("embalagem.php");

    document.getElementById("sabor").innerHTML =
        sabores.map(s => `<option value="${s.id}">${s.nome}</option>`).join("");

    document.getElementById("embalagem").innerHTML =
        embalagens.map(e => `<option value="${e.id}">${e.tipo}</option>`).join("");
}
