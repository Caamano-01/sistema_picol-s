/**
 * ARQUIVO: relatorios.js
 * DESCRIÇÃO: Busca dados de múltiplos relatórios e renderiza gráficos usando Chart.js.
 */

document.addEventListener("DOMContentLoaded", async () => {

    // Função auxiliar para mostrar mensagens de erro no HTML
    function exibirMensagem(idElemento, mensagem) {
        const container = document.getElementById(idElemento);
        if (container) {
            container.insertAdjacentHTML("afterend", `<p class="text-danger mt-2">${mensagem}</p>`);
        }
    }

    // Função para buscar dados da API
    async function apiGet(url) {
        try {
            const resp = await fetch(url);
            if (!resp.ok) throw new Error(`Erro HTTP ${resp.status}`);
            return await resp.json();
        } catch (err) {
            console.error("Falha na requisição:", err);
            return null;
        }
    }

    // Função para gerar cores aleatórias
    function gerarCoresAleatorias(numCores) {
        const cores = [];
        for (let i = 0; i < numCores; i++) {
            const r = Math.floor(Math.random() * 200) + 30;
            const g = Math.floor(Math.random() * 200) + 30;
            const b = Math.floor(Math.random() * 200) + 30;
            cores.push(`rgba(${r}, ${g}, ${b}, 0.8)`);
        }
        return cores;
    }

    // --------------------------------------------------------
    // 1. FATURAMENTO MENSAL
    // --------------------------------------------------------
    const dadosVendas = await apiGet("relatorios.php?vendas=true");

    if (dadosVendas && dadosVendas.length > 0) {
        const labelsVendas = dadosVendas.map(r => r.mes);
        const valoresVendas = dadosVendas.map(r => parseFloat(r.total));

        new Chart(document.getElementById("graficoVendas"), {
            type: 'bar',
            data: {
                labels: labelsVendas,
                datasets: [{
                    label: "Faturamento Total (R$)",
                    data: valoresVendas,
                    backgroundColor: "rgba(54, 162, 235, 0.7)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true },
                    title: {
                        display: true,
                        text: 'Faturamento Mensal'
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    } else {
        console.log("Nenhum dado de faturamento encontrado.");
        exibirMensagem("graficoVendas", "Nenhum dado de faturamento encontrado.");
    }

    // --------------------------------------------------------
    // 2. RANKING DE PICOLÉS
    // --------------------------------------------------------
    const dadosRanking = await apiGet("relatorios.php?ranking=true");

    if (dadosRanking && dadosRanking.length > 0) {
        const labelsRanking = dadosRanking.map(r => r.picole);
        const valoresRanking = dadosRanking.map(r => parseInt(r.quantidade_vendida));
        const coresRanking = gerarCoresAleatorias(dadosRanking.length);

        new Chart(document.getElementById("graficoRanking"), {
            type: 'doughnut',
            data: {
                labels: labelsRanking,
                datasets: [{
                    label: "Unidades Vendidas",
                    data: valoresRanking,
                    backgroundColor: coresRanking,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Ranking de Picolés Mais Vendidos'
                    }
                }
            }
        });
    } else {
        console.log("Nenhum dado de ranking encontrado.");
        exibirMensagem("graficoRanking", "Nenhum dado de ranking encontrado.");
    }

});