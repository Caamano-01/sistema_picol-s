document.addEventListener("DOMContentLoaded", async () => {
    const dados = await apiGet("relatorios.php?vendas=true");

    const labels = dados.map(r => r.mes);
    const valores = dados.map(r => r.total);

    new Chart(document.getElementById("graficoVendas"), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Vendas (R$)",
                data: valores,
                backgroundColor: "rgba(54, 162, 235, 0.7)"
            }]
        }
    });
});