document.addEventListener("DOMContentLoaded", async () => {
    const revs = await apiGet("revendedor.php");
    const lotes = await apiGet("lote.php");

    document.getElementById("revendedor").innerHTML =
        revs.map(r => `<option value="${r.id}">${r.nome}</option>`).join("");

    document.getElementById("lote").innerHTML =
        lotes.map(l => `<option value="${l.id}">Lote ${l.id} - ${l.quantidade} unidades</option>`).join("");

    document.getElementById("formNota").addEventListener("submit", async (e) => {
        e.preventDefault();

        const dados = {
            id_revendedor: document.getElementById("revendedor").value,
            id_lote: document.getElementById("lote").value,
            quantidade_vendida: document.getElementById("quantidade").value,
            valor_unitario: document.getElementById("valor").value
        };

        await apiPost("nota.php", dados);

        alert("Nota fiscal emitida!");
    });
});