document.addEventListener("DOMContentLoaded", async () => {
    await carregarCombos();

    document.getElementById("form-picole").addEventListener("submit", async (e) => {
        e.preventDefault();

        const ingredientesSelecionados = Array.from(
        document.getElementById("ingredientes-picole").selectedOptions
        ).map(opt => opt.value);

        const dados = {
            nome: document.getElementById("nome-picole").value,
            tipo: document.getElementById("tipo-picole").value,
            id_sabor: document.getElementById("sabor-picole").value,
            id_embalagem: document.getElementById("embalagem-picole").value,
            ingredientes: ingredientesSelecionados,
            conservante: document.getElementById("conservante-picole").value || null,
            adtivo: document.getElementById("adtivo-picole").value || null
        };

        await apiPost("picole.php", dados);
        alert("Picolé cadastrado!");
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