// Donut chart for dashboard_teste (dados serão carregados do backend)
// Variáveis para manter labels, contagens e percentuais
var donutLabelsTeste = ["Reprovado", "Aprovado", "Validado"];
var donutCountsTeste = [4, 44, 99];
var donutPercentsTeste = [2.7, 29.9, 67.3];

var donutOptionsTeste = {
    series: donutPercentsTeste,
    chart: {
        height: 400,
        type: "donut",
        events: {
            dataPointSelection: function(event, chartContext, config) {
                // Em pie/donut, use seriesIndex para determinar o slice clicado
                const index = (typeof config.seriesIndex === 'number' && config.seriesIndex >= 0)
                    ? config.seriesIndex
                    : config.dataPointIndex;
                const statusName = donutLabelsTeste[index];
                const count = donutCountsTeste[index] || 0;
                const percent = donutPercentsTeste[index] || 0;

                // Se existir o modal nesta página, preenche e mostra
                var modalElement = document.getElementById('donutModal');
                if (modalElement) {
                    var title = document.getElementById('modalTitle');
                    var nameEl = document.getElementById('modalProject');
                    var valueEl = document.getElementById('modalValue');
                    var detailsEl = document.getElementById('modalDetails');
                    if (title) title.textContent = `Detalhes do Status`;
                    if (nameEl) nameEl.textContent = statusName;
                    if (valueEl) valueEl.textContent = `${count} (${percent.toFixed(1)}%)`;
                    if (detailsEl) detailsEl.textContent = `Quantidade de tarefas com o status ${statusName} (${percent.toFixed(1)}% do total).`;

                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        }
    },
    stroke: { show: false },
    labels: donutLabelsTeste,
    plotOptions: {
        pie: {
            donut: { size: "150%" },
            donut: { width: "100%" },
        }
    },
    dataLabels: { enabled: false },
    legend: { show: false },
    colors: ["#bf304a", "#4d8764", "#232db8"],
    tooltip: {
        y: {
            formatter: function (val, opts) {
                // Em pie/donut, ApexCharts normalmente usa seriesIndex; dataPointIndex pode ser -1
                var hasValidDpi = (opts && typeof opts.dataPointIndex === 'number' && opts.dataPointIndex >= 0);
                var idx = hasValidDpi ? opts.dataPointIndex : opts.seriesIndex;
                var count = (donutCountsTeste && donutCountsTeste[idx]) ? donutCountsTeste[idx] : 0;
                var percent = (donutPercentsTeste && donutPercentsTeste[idx]) ? donutPercentsTeste[idx] : val;
                return count + " (" + Number(percent).toFixed(1) + "%)";
            }
        }
    }
};

var donutChartTeste = new ApexCharts(document.querySelector("#donut-chart-teste"), donutOptionsTeste);
donutChartTeste.render();

// Carrega dados reais do backend para o donut
fetch('/api/tests/status-distribution?_=' + Date.now(), { cache: 'no-store' })
  .then(function(r){ return r.json(); })
  .then(function(data){
    if (!(data && Array.isArray(data.series) && Array.isArray(data.labels))) return;

    // Função de normalização (case-insensitive, remove aspas/acentos, mapeia variações)
    var removeAccents = function (str) {
      return String(str)
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');
    };
    var norm = function(s){
      var v = String(s || '')
        .replace(/["']/g, '') // remove aspas
        .trim()
        .toLowerCase();
      v = removeAccents(v);
      if (v.indexOf('aprov') !== -1) return 'aprovado';
      if (v.indexOf('valid') !== -1) return 'validado';
      if (v.indexOf('reprov') !== -1) return 'reprovado';
      return v;
    };

    // Monta um mapa status -> contagem a partir do retorno (normalizado)
    var map = {};
    for (var i = 0; i < data.labels.length; i++) {
      map[norm(data.labels[i])] = Number(data.series[i]) || 0;
    }

    // Ordem desejada para o donut e para o modal
    var orderedLabels = ["Reprovado", "Aprovado", "Validado"];
    var counts = [map['reprovado'] || 0, map['aprovado'] || 0, map['validado'] || 0];
    var total = counts.reduce(function(a,b){ return a + b; }, 0);
    var percents = total > 0 ? counts.map(function(c){ return +( (c/total)*100 ).toFixed(1); }) : counts;

    // Atualiza variáveis globais para o handler do modal
    donutLabelsTeste = orderedLabels;
    donutCountsTeste = counts;
    donutPercentsTeste = percents;

    // Atualiza o gráfico (labels + percentuais)
    donutChartTeste.updateOptions({ labels: orderedLabels });
    donutChartTeste.updateSeries(percents);

    // Atualiza Total de Tickets (card) – usa total do backend se disponível
    var totalEl = document.getElementById('total-tickets');
    var totalFromApi = (typeof data.total === 'number') ? data.total : total;
    if (totalEl) totalEl.textContent = String(totalFromApi);
    console.log('status-distribution:', { counts: counts, percents: percents, total: totalFromApi });

    // Atualiza Taxa de Aprovação = (Aprovado + Validado) / total (usando counts ordenados)
    var aprovados = counts[1] || 0; // ordem: [Reprovado, Aprovado, Validado]
    var validados = counts[2] || 0;
    var taxa = total > 0 ? (((aprovados + validados) / total) * 100).toFixed(1) : '0.0';
    var el = document.getElementById('approval-rate');
    if (el) el.textContent = taxa + '%';

    // Atualiza legendas abaixo do donut
    var setLegend = function(idText, idPct, qtd, pct, label){
      var t = document.getElementById(idText);
      var p = document.getElementById(idPct);
      if (t) {
        var icon = t.querySelector('i');
        var iconHTML = icon ? icon.outerHTML : '';
        t.innerHTML = iconHTML + ' ' + label + ' (' + qtd + ')';
      }
      if (p) p.textContent = (Number(pct).toFixed(1)) + ' %';
    };
    // ordem: [Reprovado, Aprovado, Validado]
    setLegend('legend-validado', 'legend-validado-pct', counts[2] || 0, percents[2] || 0, 'Validado');
    setLegend('legend-aprovado', 'legend-aprovado-pct', counts[1] || 0, percents[1] || 0, 'Aprovado');
    setLegend('legend-reprovado', 'legend-reprovado-pct', counts[0] || 0, percents[0] || 0, 'Reprovado');
  })
  .catch(function(err){ console.error('status-distribution error', err); });

// QntdAttDevs: cópia do gráfico financeiro (barra) para o dashboard de testes
// Container: #qntd-att-devs
var qntdAttDevsOptions = {
    series: [
        { name: 'Criadas',   data: [21, 1, 11, 21, 20, 2, 21, 6, 43, 1] }
    ],
    chart: {
        type: 'bar',
        height: 482,
        toolbar: { show: false },
        events: {
            dataPointSelection: function(event, chartContext, config) {
                var categories = ['Caio Andrade', 'Davi Andrade', 'Franklin', 'Jeff', 'Kayo', 'Max', 'Milene', 'Moab', 'Murillo', 'Newton'];
                var seriesNames = qntdAttDevsOptions.series.map(function(s){ return s.name; });
                var sprint = categories[config.dataPointIndex];
                var serie = seriesNames[config.seriesIndex];
                var value = qntdAttDevsOptions.series[config.seriesIndex].data[config.dataPointIndex];

                var modalElement = document.getElementById('financialModal');
                if (modalElement) {
                    var typeEl = document.getElementById('financialType');
                    var monthEl = document.getElementById('financialMonth');
                    var valueEl = document.getElementById('financialValue');
                    var detailsEl = document.getElementById('financialDetails');
                    if (typeEl) typeEl.textContent = serie;
                    if (monthEl) monthEl.textContent = sprint;
                    if (valueEl) valueEl.textContent = value;
                    if (detailsEl) detailsEl.textContent = serie + ': ' + value + ' em ' + sprint + '.';
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        }
    },
    xaxis: { categories: ['Caio Andrade', 'Davi Andrade', 'Franklin', 'Jeff', 'Kayo', 'Max', 'Milene', 'Moab', 'Murillo', 'Newton'] },
    responsive: [{ breakpoint: 768, options: { chart: { width: '100%', height: 382 } } }],
    plotOptions: { bar: { horizontal: false, columnWidth: '70%', endingShape: 'rounded' } },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    colors: ['#2b15c1'],
    yaxis: { title: { text: '' } },
    fill: { opacity: 1 },
    legend: { position: 'top', horizontalAlign: 'center', offsetY: 0 }
};

var qntdAttDevsChart = new ApexCharts(document.querySelector('#qntd-att-devs'), qntdAttDevsOptions);
qntdAttDevsChart.render();

// Carrega dados do backend para QntdAttDevs e atualiza card total-devs
fetch('/api/devs/activities-count?_=' + Date.now(), { cache: 'no-store' })
  .then(function(r){ return r.json(); })
  .then(function(data){
    if (data && Array.isArray(data.categories) && Array.isArray(data.series)) {
      qntdAttDevsChart.updateOptions({ xaxis: { categories: data.categories } });
      qntdAttDevsChart.updateSeries(data.series);
      var totalDevsEl = document.getElementById('total-devs');
      if (totalDevsEl && typeof data.totalDevs === 'number') {
        totalDevsEl.textContent = String(data.totalDevs);
      }
      console.log('devs-activities:', { categories: data.categories, series: data.series, totalDevs: data.totalDevs });
    }
  })
  .catch(function(err){ console.error('activities-count error', err); });



// TestesPorEstrutura: cópia do exemplo de barra horizontal
var testesPorEstruturaOptions = {
    chart: {
        height: 800,
        type: 'bar',
        toolbar: { show: false }
    },
    plotOptions: {
        bar: { horizontal: true }
    },
    dataLabels: { enabled: false },
    series: [{ data: [380, 430, 450, 475, 550, 584, 780, 1100, 1220, 1365] }],
    colors: ['#1cbb8c'],
    grid: { borderColor: '#f1f1f1', padding: { bottom: 5 } },
    xaxis: {
        categories: ['PMS', 'ARARUAMA', 'ACARI', 'SINERGIA', 'TECVOTO', 'PM SOSSEGO', 'CM RIACHO DE SANTO ANTÔNIO', 'LICITAÇÕES', 'GFROTAS', 'TODAS AS ESTRUTURAS']
    },
    legend: { offsetY: 5 }
};

var testesPorEstrutura = new ApexCharts(document.querySelector('#testes-por-estrutura'), testesPorEstruturaOptions);
testesPorEstrutura.render();

// Carrega dados do backend para TestesPorEstrutura e atualiza card total-estruturas
fetch('/api/structures/tests-count?_=' + Date.now(), { cache: 'no-store' })
  .then(function(r){ return r.json(); })
  .then(function(data){
    if (data && Array.isArray(data.categories) && Array.isArray(data.series)) {
      testesPorEstrutura.updateOptions({ xaxis: { categories: data.categories } });
      testesPorEstrutura.updateSeries(data.series);
      var totEstrEl = document.getElementById('total-estruturas');
      if (totEstrEl && typeof data.totalEstruturas === 'number') {
        totEstrEl.textContent = String(data.totalEstruturas);
      }
      console.log('structures-count:', { categories: data.categories, series: data.series, totalEstruturas: data.totalEstruturas });
    }
  })
  .catch(function(err){ console.error('structures-tests-count error', err); });
