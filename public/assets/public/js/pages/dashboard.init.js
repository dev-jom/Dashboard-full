var options = {
        series: [{
            name: "2024",
            type: "column",
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
        }, {
            name: "2023",
            type: "line",
            data: [23, 32, 27, 38, 27, 32, 27, 38, 22, 31, 21, 16]
        }],
        chart: {
            height: 280,
            type: "line",
            toolbar: {
                show: !1
            }
        },
        stroke: {
            width: [0, 3],
            curve: "smooth"
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "20%"
            }
        },
        dataLabels: {
            enabled: !1
        },
        legend: {
            show: !1
        },
        colors: ["#fcb92c", "#ff3d60"],
        labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]
    },
chart = new ApexCharts(document.querySelector("#line-column-chart"), options);
chart.render();
// Configuração do gráfico de donut com suporte a clique
var donutOptions = {
    series: [10, 25, 65],
    chart: {
        height: 230,
        type: "donut",
        events: {
            dataPointSelection: function(event, chartContext, config) {
                const projectNames = ["Gfrotas", "Public", "Tecvoto"];
                const projectDetails = [
                    "Detalhes sobre o projeto Gfrotas. Este é um projeto interno da empresa.",
                    "Detalhes sobre o projeto Public. Projeto voltado para o público em geral.",
                    "Detalhes sobre o projeto Tecvoto. Solução de votação eletrônica."
                ];
                
                const index = config.dataPointIndex;
                const projectName = projectNames[index];
                const value = donutOptions.series[index];
                
                // Atualiza o conteúdo do modal
                document.getElementById('modalTitle').textContent = `Detalhes do Projeto`;
                document.getElementById('modalProject').textContent = projectName;
                document.getElementById('modalValue').textContent = value;
                document.getElementById('modalDetails').textContent = projectDetails[index];
                
                // Mostra o modal
                var modalElement = document.getElementById('donutModal');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();

                // Adiciona evento de clique ao botão de fechar
                var closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        modal.hide();
                    });
                }

            }
        }
    },
    stroke: {
        show: false      
    },
    labels: ["Gfrotas", "Public", "Tecvoto"],
    plotOptions: {
        pie: {
            donut: {
                size: "75%"
            },
            customScale: 0.9
        }
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        show: false
    },
    colors: ["#4aa3ff", "#eeb902", "#ff3d60"],
    tooltip: {
        y: {
            formatter: function(value) {
                return value + "%";
            }
        }
    }
};

// Inicializa o gráfico de donut
var donutChart = new ApexCharts(document.querySelector("#donut-chart"), donutOptions);
donutChart.render();

var radialoptions = {
        series: [20],
        chart: {
            type: "radialBar",
            wight: 60,
            height: 60,
            sparkline: {
                enabled: !0
            }
        },
        dataLabels: {
            enabled: !1
        },
        colors: ["#5664d2"],
        stroke: {
            lineCap: "round"
        },    
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "70%"
                },
                track: {
                    margin: 0
                },
                dataLabels: {
                    show: !1
                }
            }
        }
    },
radialchart = new ApexCharts(document.querySelector("#radialchart-1"), radialoptions);
radialchart.render();
radialoptions = {
    series: [80],
    chart: {
        type: "radialBar",
        wight: 60,
        height: 60,
        sparkline: {
            enabled: !0
        }
    },
    dataLabels: {
        enabled: !1
    },
    colors: ["#4aa3ff"],
    stroke: {
        lineCap: "round"
    },
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 0,
                size: "70%"
            },
            track: {
                margin: 0
            },
            dataLabels: {
                show: !1
            }
        }
    }
};
(radialchart = new ApexCharts(document.querySelector("#radialchart-2"), radialoptions)).render();
radialoptions = {
    series: [30],
    chart: {
        type: "radialBar",
        wight: 60,
        height: 60,
        sparkline: {
            enabled: !0
        }
    },
    dataLabels: {
        enabled: !1
    },
    colors: ["#eeb902"],
    stroke: {
        lineCap: "round"
    },
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 0,
                size: "70%"
            },
            track: {
                margin: 0
            },
            dataLabels: {
                show: !1
            }
        }
    }
};
(radialchart = new ApexCharts(document.querySelector("#radialchart-3"), radialoptions)).render();

options = {
    series: [{
        data: [23, 32, 27, 38, 27, 32, 27, 34, 26, 31, 28]
    }],
    chart: {
        type: "line",
        width: 80,
        height: 35,
        sparkline: {
            enabled: !0
        }
    },
    stroke: {
        width: [3],
        curve: "smooth"
    },
    colors: ["#5664d2"],
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function (e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart = new ApexCharts(document.querySelector("#spak-chart1"), options)).render();
options = {
    series: [{
        data: [24, 62, 42, 84, 63, 25, 44, 46, 54, 28, 54]
    }],
    chart: {
        type: "line",
        width: 80,
        height: 35,
        sparkline: {
            enabled: !0
        }
    },
    stroke: {
        width: [3],
        curve: "smooth"
    },
    colors: ["#5664d2"],
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function (e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart = new ApexCharts(document.querySelector("#spak-chart2"), options)).render();
options = {
    series: [{
        data: [42, 31, 42, 34, 46, 38, 44, 36, 42, 32, 54]
    }],
    chart: {
        type: "line",
        width: 80,
        height: 35,
        sparkline: {
            enabled: !0
        }
    },
    stroke: {
        width: [3],
        curve: "smooth"
    },
    colors: ["#5664d2"],
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function (e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart = new ApexCharts(document.querySelector("#spak-chart3"), options)).render(), $("#usa-vectormap").vectorMap({
    map: "us_merc_en",
    backgroundColor: "transparent",
    regionStyle: {
        initial: {
            fill: "#e8ecf4",
            stroke: "#74788d",
            "stroke-width": 1,
            "stroke-opacity": .4
        }
    }
});

// Financial Overview Column Chart
var financialChartOptions = {
    series: [{
        name: 'Melhorias',
        data: [15, 12, 18, 10]
    }, {
        name: 'Bugs',
        data: [20, 8, 10, 9]
    }],
    chart: {
        type: 'bar',
        height: 392,
        width: '100%',
        toolbar: {
            show: false
        },
        events: {
            dataPointSelection: function(event, chartContext, config) {
                const categories = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                                 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                const seriesNames = ['Melhorias', 'Bugs'];
                const month = categories[config.dataPointIndex];
                const seriesName = seriesNames[config.seriesIndex];
                const value = financialChartOptions.series[config.seriesIndex].data[config.dataPointIndex];
                
                // Update modal content
                document.getElementById('financialType').textContent = seriesName;
                document.getElementById('financialMonth').textContent = month;
                document.getElementById('financialValue').textContent = value;
                
                // Add details based on the data type
                let details = '';
                if (seriesName === 'Melhorias') {
                    details = `Foram registradas ${value} melhorias no mês de ${month}.`;
                } else {
                    details = `Foram encontrados ${value} bugs no mês de ${month}.`;
                }
                document.getElementById('financialDetails').textContent = details;
                
                // Mostra o modal
                var modalElement = document.getElementById('financialModal');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();

                var closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        modal.hide();
                    });
                }
            }
        }
    },
    responsive: [
        {
            breakpoint: 768,
            options: {
                chart: {
                    width: '100%'
                }
            }
        }
    ],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '50%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    colors: ['#1cbb8c', '#fcb92c'],
    xaxis: {
        categories: ['Jan', 'Fev', 'Mar', 'Abr'],
    },
    yaxis: {
        title: {
            text: ''
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val
            }
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'center',
        offsetY: 0
    }
};

var financialChart = new ApexCharts(document.querySelector("#financial-chart"), financialChartOptions);
financialChart.render();

// === Cópia do módulo financial chart: 'criadasXaprovadas' ===
// Criamos uma cópia profunda para não compartilhar referências com o gráfico original
var criadasXaprovadasOptions = JSON.parse(JSON.stringify(financialChartOptions));

// Dados e legendas próprios para não ficar igual ao gráfico original
criadasXaprovadasOptions.series = [
    { name: 'Criadas',   data: [12, 18, 22, 15] },
    { name: 'Aprovadas', data: [10, 14, 20, 13] }
];
// Alinhar os rótulos do eixo X com os meses do handler de clique
criadasXaprovadasOptions.xaxis = {
    categories: ['Sprint 147', 'Sprint 148', 'Sprint 149', 'Sprint 150']
};

// Estilos do gráfico (copiados do original para personalização independente)
criadasXaprovadasOptions.responsive = [
    {
        breakpoint: 768,
        options: {
            chart: {
                width: '100%',
                height: 382,
            }
        }
    }
];
criadasXaprovadasOptions.plotOptions = {
    bar: {
        horizontal: false,
        columnWidth: '50%',
        endingShape: 'flat'
    },
};
criadasXaprovadasOptions.dataLabels = { enabled: false };
criadasXaprovadasOptions.stroke = { show: true, width: 2, colors: ['transparent'] };
criadasXaprovadasOptions.colors = ['#fcb92c', '#1cbb8c'];
criadasXaprovadasOptions.yaxis = { title: { text: '' } };
criadasXaprovadasOptions.fill = { opacity: 1 };
criadasXaprovadasOptions.tooltip = { y: { formatter: function (val) { return val } } };
criadasXaprovadasOptions.legend = { position: 'top', horizontalAlign: 'center', offsetY: 0 };

// Mantém as mesmas funcionalidades e aparência; ajuste os dados se necessário
// Exemplo: pode renomear as séries se quiser diferenciar visualmente
// criadasXaprovadasOptions.series[0].name = 'Criadas';
// criadasXaprovadasOptions.series[1].name = 'Aprovadas';
// Importantíssimo: o handler deve ler de criadasXaprovadasOptions para não conflitar com o original
criadasXaprovadasOptions.chart.events = {
    dataPointSelection: function(event, chartContext, config) {
        const categories = ['Sprint 147', 'Sprint 148', 'Sprint 149', 'Sprint 150'];
        const seriesNames = criadasXaprovadasOptions.series.map(function(s){ return s.name; });
        const month = categories[config.dataPointIndex];
        const seriesName = seriesNames[config.seriesIndex];
        const value = criadasXaprovadasOptions.series[config.seriesIndex].data[config.dataPointIndex];

        // Atualiza o conteúdo do modal existente
        document.getElementById('financialType').textContent = seriesName;
        document.getElementById('financialMonth').textContent = month;
        document.getElementById('financialValue').textContent = value;

        let details = '';
        if (seriesName === 'Melhorias') {
            details = `Foram registradas ${value} melhorias no mês de ${month}.`;
        } else if (seriesName === 'Bugs') {
            details = `Foram encontrados ${value} bugs no mês de ${month}.`;
        } else {
            details = `${seriesName}: ${value} em ${month}.`;
        }
        document.getElementById('financialDetails').textContent = details;

        // Mostra o modal
        var modalElement = document.getElementById('financialModal');
        var modal = new bootstrap.Modal(modalElement);
        modal.show();

        var closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                modal.hide();
            });
        }
    }
};

// Instância com nome diferente apontando para o container #criadasXaprovadas-chart
var criadasXaprovadasChart = new ApexCharts(
    document.querySelector('#criadasXaprovadas-chart'),
    criadasXaprovadasOptions
);
criadasXaprovadasChart.render();

// Spline Area chart for #spline_area on the dashboard page
// Kept minimal to avoid loading the full apexcharts.init.js (which initializes many other charts)
try {
    var splineAreaEl = document.querySelector('#spline_area');
    if (splineAreaEl) {
        var splineAreaOptions = {
            chart: { height: 373, type: 'area' },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [
                // Alinhar quantidade de pontos às 4 sprints
                { name: 'series1', data: [34, 40, 28, 52] },
                { name: 'series2', data: [32, 60, 34, 46] }
            ],
            colors: ['#5664d2', '#1cbb8c'],
            xaxis: {
                type: 'category',
                categories: [
                    'Sprint 147',
                    'Sprint 148',
                    'Sprint 149',
                    'Sprint 150'
                ]
            },
            grid: { borderColor: '#f1f1f1', padding: { bottom: 15 } },
            tooltip: { x: { show: false } },
            legend: { offsetY: 7 }
        };
        var splineAreaChart = new ApexCharts(splineAreaEl, splineAreaOptions);
        splineAreaChart.render();
    }
} catch (e) {
    console.error('Erro ao inicializar o gráfico #spline_area:', e);
}
