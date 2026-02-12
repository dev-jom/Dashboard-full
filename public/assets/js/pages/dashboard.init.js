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
// Build donut options using server-provided arrays when available
var _topLabels = (window.topProjectsLabels && window.topProjectsLabels.length) ? window.topProjectsLabels : ["Gfrotas", "Public", "Tecvoto"];
var _topSeries = (window.topProjectsCounts && window.topProjectsCounts.length) ? window.topProjectsCounts : [10, 25, 65];
var donutOptions = {
    series: _topSeries,
    chart: {
        height: 320,
        type: "donut",
        events: {
            dataPointSelection: function(event, chartContext, config) {
                var index = config.dataPointIndex;
                var projectName = _topLabels[index] || '—';
                
                if (projectName !== '—') {
                    showTasksModal('Tarefas do Projeto: ' + projectName, 'project', projectName);
                }
            }
        }
    },
    stroke: { show: false },
    labels: _topLabels,
    plotOptions: {
        pie: { donut: { size: '75%' }, customScale: 0.9 }
    },
    dataLabels: { enabled: false },
    // We hide the chart's built-in legend so only the custom/HTML legend
    // (rendered below the chart in the Blade) remains visible.
    legend: { show: false },
    colors: ['#4aa3ff', '#1cc88a', '#f6c23e', '#ff3d60', '#6c5ce7', '#5664d2'],
    tooltip: { y: { formatter: function(value){ return value + ' atividades'; } } }
};

// Inicializa o gráfico de donut (skip se o container marcar para pular inicialização)
var donutEl = document.querySelector("#donut-chart");
if (donutEl && donutEl.dataset && donutEl.dataset.skipThemeInit !== '1') {
    var donutChart = new ApexCharts(donutEl, donutOptions);
    // Render and then synchronize the HTML legend dots below the chart
    // with the chart's slice colors so everything is automatic.
    donutChart.render().then(function(){
        try {
            var colors = (donutChart.w && donutChart.w.config && donutChart.w.config.colors) ? donutChart.w.config.colors : donutOptions.colors;
            var cardBody = donutEl.closest('.card-body');
            var legendContainer = cardBody ? cardBody.querySelector('.row') : null;
            if (legendContainer) {
                var legendDots = legendContainer.querySelectorAll('.mdi-circle');
                legendDots.forEach(function(dot, idx){
                    // remove any bootstrap color utility classes that may conflict
                    dot.classList.remove('text-info','text-danger','text-warning','text-primary','text-success');
                    // apply the exact chart color for that index
                    if (colors && colors[idx]) {
                        dot.style.color = colors[idx];
                    }
                }); 
            }
        } catch (e) {
            // fail silently if DOM structure differs
            console.warn('Could not sync donut legend colors:', e);
        }
    });
} else {
    // skipping theme donut init because server-rendered or custom chart present
}

var radialCharts = [null, null, null];
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
                };    // create first radial and keep reference
    try {
        var c1 = new ApexCharts(document.querySelector("#radialchart-1"), radialoptions);
        c1.render();
        radialCharts[0] = c1;
        // open modal on click using same modal used by the donut chart
        try {
            var el1 = document.querySelector('#radialchart-1');
            if (el1) {
                var parentCol1 = el1.closest('.col-sm-4') || el1.parentElement;
                parentCol1.addEventListener('click', function () {
                    var lbl = el1.dataset.statusLabel || '-';
                    var cnt = el1.dataset.statusCount || '0';
                    var pct = el1.dataset.statusPct || '0';
                    document.getElementById('modalTitle').textContent = 'Detalhes da Situação';
                    document.getElementById('modalProject').textContent = lbl;
                    document.getElementById('modalValue').textContent = cnt;
                    document.getElementById('modalDetails').textContent = 'Porcentagem: ' + pct + ' %';
                    var modalElement = document.getElementById('donutModal');
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                });

                // hover tooltip (uses #project-status-tooltip)
                try {
                    var tooltip = document.getElementById('project-status-tooltip');
                    if (tooltip) tooltip.style.position = 'fixed';
                    parentCol1.addEventListener('mouseenter', function (ev) {
                        try {
                            var lbl = el1.dataset.statusLabel || '-';
                            var cnt = el1.dataset.statusCount || '0';
                            tooltip.textContent = lbl + ': ' + cnt + ' atividades';
                            tooltip.style.backgroundColor = statusToColorMap[lbl] || statusToColorMap['default'];
                            tooltip.style.display = 'block';
                            tooltip.style.left = (ev.clientX + 12) + 'px';
                            tooltip.style.top = (ev.clientY + 12) + 'px';
                        } catch (e) {}
                    });
                    parentCol1.addEventListener('mousemove', function (ev) {
                        try {
                            tooltip.style.left = (ev.clientX + 12) + 'px';
                            tooltip.style.top = (ev.clientY + 12) + 'px';
                        } catch (e) {}
                    });
                    parentCol1.addEventListener('mouseleave', function () {
                        try { tooltip.style.display = 'none'; } catch (e) {}
                    });
                } catch (e) { console.warn('radial1 hover', e); }
            }
        } catch (e) { console.warn('attach radial1 click', e); }
    } catch(e) { console.warn('radial 1 init', e); }

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
    try {
        var c2 = new ApexCharts(document.querySelector("#radialchart-2"), radialoptions);
        c2.render();
        radialCharts[1] = c2;
        try {
            var el2 = document.querySelector('#radialchart-2');
            if (el2) {
                var parentCol2 = el2.closest('.col-sm-4') || el2.parentElement;
                parentCol2.addEventListener('click', function () {
                    var lbl = el2.dataset.statusLabel || '-';
                    var cnt = el2.dataset.statusCount || '0';
                    var pct = el2.dataset.statusPct || '0';
                    document.getElementById('modalTitle').textContent = 'Detalhes da Situação';
                    document.getElementById('modalProject').textContent = lbl;
                    document.getElementById('modalValue').textContent = cnt;
                    document.getElementById('modalDetails').textContent = 'Porcentagem: ' + pct + ' %';
                    var modalElement = document.getElementById('donutModal');
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                });

                try {
                    var tooltip2 = document.getElementById('project-status-tooltip');
                    if (tooltip2) tooltip2.style.position = 'fixed';
                    parentCol2.addEventListener('mouseenter', function (ev) {
                        try {
                            var lbl = el2.dataset.statusLabel || '-';
                            var cnt = el2.dataset.statusCount || '0';
                            tooltip2.textContent = lbl + ': ' + cnt + ' atividades';
                            tooltip2.style.backgroundColor = statusToColorMap[lbl] || statusToColorMap['default'];
                            tooltip2.style.display = 'block';
                            tooltip2.style.left = (ev.clientX + 12) + 'px';
                            tooltip2.style.top = (ev.clientY + 12) + 'px';
                        } catch (e) {}
                    });
                    parentCol2.addEventListener('mousemove', function (ev) {
                        try {
                            tooltip2.style.left = (ev.clientX + 12) + 'px';
                            tooltip2.style.top = (ev.clientY + 12) + 'px';
                        } catch (e) {}
                    });
                    parentCol2.addEventListener('mouseleave', function () {
                        try { tooltip2.style.display = 'none'; } catch (e) {}
                    });
                } catch (e) { console.warn('radial2 hover', e); }
            }
        } catch (e) { console.warn('attach radial2 click', e); }
    } catch(e) { console.warn('radial 2 init', e); }

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
    try {
        var c3 = new ApexCharts(document.querySelector("#radialchart-3"), radialoptions);
        c3.render();
        radialCharts[2] = c3;
        try {
            var el3 = document.querySelector('#radialchart-3');
            if (el3) {
                var parentCol3 = el3.closest('.col-sm-4') || el3.parentElement;
                parentCol3.addEventListener('click', function () {
                    var lbl = el3.dataset.statusLabel || '-';
                    var cnt = el3.dataset.statusCount || '0';
                    var pct = el3.dataset.statusPct || '0';
                    document.getElementById('modalTitle').textContent = 'Detalhes da Situação';
                    document.getElementById('modalProject').textContent = lbl;
                    document.getElementById('modalValue').textContent = cnt;
                    document.getElementById('modalDetails').textContent = 'Porcentagem: ' + pct + ' %';
                    var modalElement = document.getElementById('donutModal');
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                });

                try {
                    var tooltip3 = document.getElementById('project-status-tooltip');
                    if (tooltip3) tooltip3.style.position = 'fixed';
                    parentCol3.addEventListener('mouseenter', function (ev) {
                        try {
                            var lbl = el3.dataset.statusLabel || '-';
                            var cnt = el3.dataset.statusCount || '0';
                            tooltip3.textContent = lbl + ': ' + cnt + ' atividades';
                            tooltip3.style.backgroundColor = statusToColorMap[lbl] || statusToColorMap['default'];
                            tooltip3.style.display = 'block';
                            tooltip3.style.left = (ev.clientX + 12) + 'px';
                            tooltip3.style.top = (ev.clientY + 12) + 'px';
                        } catch (e) {}
                    });
                    parentCol3.addEventListener('mousemove', function (ev) {
                        try {
                            tooltip3.style.left = (ev.clientX + 12) + 'px';
                            tooltip3.style.top = (ev.clientY + 12) + 'px';
                        } catch (e) {}
                    });
                    parentCol3.addEventListener('mouseleave', function () {
                        try { tooltip3.style.display = 'none'; } catch (e) {}
                    });
                } catch (e) { console.warn('radial3 hover', e); }
            }
        } catch (e) { console.warn('attach radial3 click', e); }
    } catch(e) { console.warn('radial 3 init', e); }

    // Dynamic updater: fetch top-3 statuses for selected project and update radials and labels
    (function(){
                var colors = ['#4aa3ff', '#1cc88a', '#f6c23e'];
                function updateRadials(labels, counts, percentages){
            labels = Array.isArray(labels) ? labels : [];
            counts = Array.isArray(counts) ? counts : [];
            percentages = Array.isArray(percentages) ? percentages : [];
            for (var i=0;i<3;i++){
                var lbl = labels[i] || '-';
                var cnt = typeof counts[i] !== 'undefined' ? counts[i] : 0;
                var pct = typeof percentages[i] !== 'undefined' ? percentages[i] : 0;
                var labelEl = document.querySelectorAll('.status-label')[i];
                var valueEl = document.querySelectorAll('.status-value')[i];
                if (labelEl) labelEl.textContent = lbl;
                if (valueEl) valueEl.textContent = (pct === '-' ? '-' : (pct + ' %'));
                var chart = radialCharts[i];
                try {
                    if (chart && typeof chart.updateSeries === 'function') chart.updateSeries([ Math.round(pct)||0 ]);
                } catch(e){ console.warn('updateRadials chart update', e); }
                // store dataset for possible future use
                var el = document.querySelector('#radialchart-'+(i+1));
                if (el){ el.dataset.statusLabel = lbl; el.dataset.statusCount = String(cnt); el.dataset.statusPct = String(pct); }
            }
        }

        async function fetchAndUpdateProject(project, range, start, end){
            try {
                if (!project) { updateRadials([],[],[]); return; }
                var qs = '?project=' + encodeURIComponent(project) + '&range=' + encodeURIComponent(range || 'month');
                if (range === 'custom'){
                    if (start) qs += '&start=' + encodeURIComponent(start);
                    if (end) qs += '&end=' + encodeURIComponent(end);
                }
                var res = await fetch('/api/dashboard/project-statuses' + qs);
                if (!res.ok) throw new Error('HTTP ' + res.status);
                var json = await res.json();
                var labels = json.labels || [];
                var counts = json.counts || [];
                var percentages = json.percentages || [];
                while (labels.length < 3) labels.push('-');
                while (counts.length < 3) counts.push(0);
                while (percentages.length < 3) percentages.push(0);
                updateRadials(labels.slice(0,3), counts.slice(0,3), percentages.slice(0,3));
            } catch(e){ console.warn('Error fetching project statuses', e); updateRadials([],[],[]); }
        }

        // wire the project form
        var pForm = document.getElementById('project-status-filter-form');
        if (pForm){
            var pSelect = document.getElementById('project-select');
            var pRange = document.getElementById('project-range-select');
            var pStart = document.getElementById('project-start-date');
            var pEnd = document.getElementById('project-end-date');
            pForm.addEventListener('submit', function(e){ e.preventDefault(); fetchAndUpdateProject(pSelect ? pSelect.value : null, pRange ? pRange.value : 'month', pStart ? pStart.value : null, pEnd ? pEnd.value : null); try { var url = new URL(window.location.href); if (pSelect && pSelect.value) url.searchParams.set('project', pSelect.value); else url.searchParams.delete('project'); url.searchParams.set('project_range', pRange.value); if (pStart && pStart.value) url.searchParams.set('project_start', pStart.value); else url.searchParams.delete('project_start'); if (pEnd && pEnd.value) url.searchParams.set('project_end', pEnd.value); else url.searchParams.delete('project_end'); window.history.replaceState({},'',url.toString()); } catch(e){}
            });
            // initial fetch using current form values or URL params
            try {
                // If the select exists but has no value, prefer server-provided initialProject
                if (pSelect && !pSelect.value && window.initialProject) {
                    pSelect.value = window.initialProject;
                }
                // prefer explicit select value, otherwise fallback to server initialProject or first available project
                var projVal = (pSelect && pSelect.value) ? pSelect.value : (window.initialProject || null);
                if (!projVal && window.projectsList && window.projectsList.length) projVal = window.projectsList[0];
                var rangeVal = (pRange && pRange.value) ? pRange.value : (window.initialProjectRange || 'month');
                var startVal = (pStart && pStart.value) ? pStart.value : (window.initialProjectStart || null);
                var endVal = (pEnd && pEnd.value) ? pEnd.value : (window.initialProjectEnd || null);
                fetchAndUpdateProject(projVal, rangeVal, startVal, endVal);
            } catch(e){}
        }
    })();

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

// Replace the financial ApexCharts instance with a Chart.js Radar chart.
// We create the canvas inside the existing container and initialize Chart.js on window load
// Replace the financial ApexCharts instance with a Chart.js Radar chart.
// We create the canvas inside the existing container and initialize Chart.js on window load
window.addEventListener('load', function(){
    try {
        var finContainer = document.querySelector('#financial-chart');
        if (!finContainer) return;
        // insert canvas
        finContainer.innerHTML = '<canvas id="financial-radar" style="max-width:100%;height:360px"></canvas>';
        if (typeof Chart === 'undefined') {
            console.warn('Chart.js not available yet — radar will initialize on next load.');
            return;
        }
        var ctx = document.getElementById('financial-radar').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                datasets: [{
                    label: "Desktops",
                    backgroundColor: "rgba(252, 185, 44, 0.2)",
                    borderColor: "#fcb92c",
                    pointBackgroundColor: "#fcb92c",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "#fcb92c",
                    data: [65, 59, 90, 81, 56, 55, 40]
                }, {
                    label: "Tablets",
                    backgroundColor: "rgba(84, 56, 220, 0.2)",
                    borderColor: "#5664d2",
                    pointBackgroundColor: "#5664d2",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "#5664d2",
                    data: [28, 48, 40, 19, 96, 27, 100]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scale: {
                    ticks: { beginAtZero: true }
                }
            }
        });
    } catch (e) {
        console.error('Error initializing financial radar chart:', e);
    }
});

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
    // If a dynamic loader is managing the spline area, skip the static initializer
    if (window && window.__sprintsAreaManaged) {
        // dynamic loader will render the spline area
    } else {
        var splineAreaEl = document.querySelector('#spline_area');
        if (splineAreaEl) {
            var splineAreaOptions = {
                chart: { 
                    height: 500, 
                    type: 'area',
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: true,
                        autoSelected: 'zoom'
                    }
                },
                dataLabels: { enabled: true },
                stroke: { curve: 'smooth', width: 10 },
                series: [
                    // Alinhar quantidade de pontos às 4 sprints
                    { name: 'Criadas', data: [34, 40, 28, 52] },
                    { name: 'Validadas', data: [32, 60, 34, 46] }
                ],
                colors: ['#4aa3ff', '#1cc88a', '#f6c23e', '#ff3d60'],
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
                tooltip: { x: { show: true } },
                legend: { offsetY: 7 }
            };
            var splineAreaChart = new ApexCharts(splineAreaEl, splineAreaOptions);
            splineAreaChart.render();
        }
    }
} catch (e) {
    console.error('Erro ao inicializar o gráfico #spline_area:', e);
}