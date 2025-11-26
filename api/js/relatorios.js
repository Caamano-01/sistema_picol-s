/**
 * ARQUIVO: relatorios.js
 * DESCRIÇÃO: Busca dados de múltiplos relatórios e renderiza gráficos usando Chart.js.
 * Depende de api.js para a função apiGet.
 */

document.addEventListener("DOMContentLoaded", async () => {

    // Função auxiliar para mostrar mensagens de erro no HTML
    function exibirMensagem(idElemento, mensagem) {
        const container = document.getElementById(idElemento);
        if (container) {
            // Insere a mensagem logo abaixo do elemento Canvas/h3
            container.insertAdjacentHTML("afterend", `<p class="alert alert-danger mt-2">${mensagem}</p>`);
        }
    }

    // Função para gerar cores aleatórias (Pode ser mantida se for usada em Ranking)
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
    try {
        // Usa a função apiGet de api.js para buscar o relatório
        const dadosVendas = await apiGet("../routes/relatorios.php?vendas=true");

        if (dadosVendas && dadosVendas.length > 0) {
            const labelsVendas = dadosVendas.map(r => r.mes);
            const valoresVendas = dadosVendas.map(r => parseFloat(r.total));

            new Chart(document.getElementById('graficoVendas'), {
                type: 'line',
                data: {
                    labels: labelsVendas,
                    datasets: [{
                        label: 'Faturamento Total (R$)',
                        data: valoresVendas,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: true } }
                }
            });
        } else {
            exibirMensagem("graficoVendas", "Nenhum dado de faturamento encontrado.");
        }
    } catch (error) {
        console.error("Erro ao carregar Faturamento Mensal:", error);
        exibirMensagem("graficoVendas", "Erro ao carregar dados de faturamento. Verifique o console.");
    }

    // --------------------------------------------------------
    // 2. RANKING DE PICOLÉS
    // --------------------------------------------------------
    try {
        const dadosRanking = await apiGet("../routes/relatorios.php?ranking=true");

        if (dadosRanking && dadosRanking.length > 0) {
            const labelsRanking = dadosRanking.map(r => r.picole);
            const valoresRanking = dadosRanking.map(r => parseInt(r.quantidade_vendida));
            const coresRanking = gerarCoresAleatorias(dadosRanking.length);

            new Chart(document.getElementById("graficoRanking"), {
                type: 'bar', // Tipo barra para ranking fica melhor
                data: {
                    labels: labelsRanking,
                    datasets: [{
                        label: "Unidades Vendidas",
                        data: valoresRanking,
                        backgroundColor: coresRanking,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    },
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
            exibirMensagem("graficoRanking", "Nenhum dado de ranking encontrado.");
        }
    } catch (error) {
        console.error("Erro ao carregar Ranking de Picolés:", error);
        exibirMensagem("graficoRanking", "Erro ao carregar dados de ranking. Verifique o console.");
    }
});