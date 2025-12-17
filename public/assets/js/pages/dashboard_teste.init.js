// Donut chart for dashboard_teste (dados serão carregados do backend)
// Variáveis para manter labels, contagens e percentuais
var donutLabelsTeste = ["Reprovado", "Aprovado", "Validado"];
var donutCountsTeste = [4, 44, 99];
var donutPercentsTeste = [2.7, 29.9, 67.3];
// total number of tickets as returned by the API (used as a fallback to compute counts)
var donutTotalTickets = 0;

var donutOptionsTeste = {
  series: donutPercentsTeste,
  chart: {
    height: 400,
    type: "donut",
    events: {
      dataPointSelection: function(event, chartContext, config) {
        var index = (typeof config.dataPointIndex === 'number' && config.dataPointIndex >= 0)
          ? config.dataPointIndex
          : (typeof config.seriesIndex === 'number' && config.seriesIndex >= 0 ? config.seriesIndex : 0);

        var labelFromChart = null;
        try {
          if (chartContext && chartContext.w && Array.isArray(chartContext.w.config.labels)) {
            labelFromChart = chartContext.w.config.labels[index];
          } else if (typeof donutChartTeste !== 'undefined' && donutChartTeste && donutChartTeste.w && Array.isArray(donutChartTeste.w.config.labels)) {
            labelFromChart = donutChartTeste.w.config.labels[index];
          }
        } catch (e) { labelFromChart = null; }

        var statusName = labelFromChart || donutLabelsTeste[index] || '';

        var percent = (donutPercentsTeste && typeof donutPercentsTeste[index] !== 'undefined') ? donutPercentsTeste[index] : 0;
        var count = 0;
        if (donutCountsTeste && typeof donutCountsTeste[index] !== 'undefined') {
          count = Number(donutCountsTeste[index]) || 0;
        } else {
          var normalizeForCompare = function(s){
            return String(s||'').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/["']/g,'').trim();
          };
          var target = normalizeForCompare(statusName);
          var found = -1;
          for (var ii = 0; ii < donutLabelsTeste.length; ii++) {
            if (normalizeForCompare(donutLabelsTeste[ii]).indexOf(target) !== -1 || target.indexOf(normalizeForCompare(donutLabelsTeste[ii])) !== -1) { found = ii; break; }
          }
          if (found >= 0 && donutCountsTeste && typeof donutCountsTeste[found] !== 'undefined') {
            count = Number(donutCountsTeste[found]) || 0;
            percent = (donutPercentsTeste && typeof donutPercentsTeste[found] !== 'undefined') ? donutPercentsTeste[found] : percent;
          } else if (donutTotalTickets && percent) {
            count = Math.round((Number(percent) / 100) * donutTotalTickets);
          }
        }
        count = Number(count) || 0;

        // use the generic modal helper so behavior is consistent across charts
        showTestsModal('Tickets - ' + statusName, 'resultado', statusName);
      }
    }
  },
  stroke: { show: false },
  labels: donutLabelsTeste,
  plotOptions: { pie: { donut: { size: 60, width: 100 } } },
  dataLabels: { enabled: false },
  legend: { show: false },
  colors: ["#bf304a", "#4d8764", "#232db8"],
  tooltip: {
    y: {
      formatter: function (val, opts) {
        var hasValidDpi = (opts && typeof opts.dataPointIndex === 'number' && opts.dataPointIndex >= 0);
        var idx = hasValidDpi ? opts.dataPointIndex : opts.seriesIndex;
        var percent = (typeof val === 'number') ? val : Number(val) || ((donutPercentsTeste && donutPercentsTeste[idx]) ? donutPercentsTeste[idx] : 0);
        var count = 0;
        if (donutCountsTeste && typeof donutCountsTeste[idx] !== 'undefined' && donutCountsTeste[idx] !== null) {
          count = Number(donutCountsTeste[idx]) || 0;
        } else if (donutTotalTickets && percent) {
          count = Math.round((Number(percent) / 100) * donutTotalTickets);
        }
        return count + " (" + Number(percent).toFixed(1) + "%)";
      }
    }
  }
};

var donutChartTeste = new ApexCharts(document.querySelector("#donut-chart-teste"), donutOptionsTeste);
donutChartTeste.render();

// helper: sprint handling
function getSelectedSprint() {
  var btn = document.getElementById('sprintDropdownBtn');
  if (!btn) return '';
  var v = btn.getAttribute('data-sprint');
  return (v && v.length) ? v : '';
}

function buildUrlWithSprint(base) {
  var sprint = getSelectedSprint();
  var url = base;
  if (sprint) {
    url += (base.indexOf('?') === -1 ? '?' : '&') + 'sprint=' + encodeURIComponent(sprint);
  }
  url += (url.indexOf('?') === -1 ? '?' : '&') + '_=' + Date.now();
  return url;
}

// loaders for each chart
function loadStatusDistribution() {
  fetch(buildUrlWithSprint('/api/tests/status-distribution'), { cache: 'no-store' })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if (!(data && Array.isArray(data.series) && Array.isArray(data.labels))) return;

      var removeAccents = function (str) { return String(str).normalize('NFD').replace(/[\u0300-\u036f]/g, ''); };
      var norm = function(s){ var v = String(s||'').replace(/["']/g,'').trim().toLowerCase(); v = removeAccents(v); if (v.indexOf('aprov')!==-1) return 'aprovado'; if (v.indexOf('valid')!==-1) return 'validado'; if (v.indexOf('reprov')!==-1) return 'reprovado'; return v; };

      var map = {};
      for (var i = 0; i < data.labels.length; i++) { map[norm(data.labels[i])] = Number(data.series[i]) || 0; }
      var orderedLabels = ["Reprovado","Aprovado","Validado"];
      var counts = [map['reprovado']||0, map['aprovado']||0, map['validado']||0];
      var total = counts.reduce(function(a,b){return a+b;},0);
      var percents = total>0 ? counts.map(function(c){ return +(((c/total)*100).toFixed(1)); }) : counts;

      donutLabelsTeste = orderedLabels; donutCountsTeste = counts; donutPercentsTeste = percents;
      donutChartTeste.updateOptions({ labels: orderedLabels }); donutChartTeste.updateSeries(percents);

      var totalEl = document.getElementById('total-tickets');
      var totalFromApi = (typeof data.total === 'number') ? data.total : total;
      donutTotalTickets = totalFromApi;
      if (totalEl) totalEl.textContent = String(totalFromApi);

      var aprovados = counts[1]||0; var validados = counts[2]||0;
      var taxa = total>0 ? (((aprovados+validados)/total)*100).toFixed(1) : '0.0';
      var el = document.getElementById('approval-rate'); if (el) el.textContent = taxa + '%';

      var setLegend = function(idText,idPct,qtd,pct,label){ var t=document.getElementById(idText); var p=document.getElementById(idPct); if(t){ var icon=t.querySelector('i'); var iconHTML=icon?icon.outerHTML:''; t.innerHTML = iconHTML + ' ' + label + ' (' + qtd + ')'; } if(p) p.textContent = (Number(pct).toFixed(1)) + ' %'; };
      setLegend('legend-validado','legend-validado-pct',counts[2]||0,percents[2]||0,'Validado');
      setLegend('legend-aprovado','legend-aprovado-pct',counts[1]||0,percents[1]||0,'Aprovado');
      setLegend('legend-reprovado','legend-reprovado-pct',counts[0]||0,percents[0]||0,'Reprovado');
    })
    .catch(function(err){ console.error('status-distribution error', err); });
}

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
        var seriesNames = qntdAttDevsOptions.series.map(function(s){ return s.name; });
        var serie = seriesNames[config.seriesIndex];

        // Valor bruto
        var rawvalue = qntdAttDevsOptions.series[config.seriesIndex].data[config.dataPointIndex];
        var value = Math.round(Number(rawvalue)) || 0;

        // Função de Calcular porcentagem relacionada a Quantidade de tickets proporcional a qntd de atts por dev
        var totalTickets =  (typeof donutTotalTickets !== 'undefined') ? Number(donutTotalTickets) : 0;
        var percent = totalTickets ? ((value / totalTickets) * 100).toFixed(1) : '0.0';

        // try to read the real category (dev name) from chart context or chart instance
        var devName = '';
        try {
          if (chartContext && chartContext.w && chartContext.w.config && chartContext.w.config.xaxis && Array.isArray(chartContext.w.config.xaxis.categories)) {
            devName = chartContext.w.config.xaxis.categories[config.dataPointIndex] || '';
          }
        } catch(e) { devName = ''; }
        if (!devName && typeof qntdAttDevsChart !== 'undefined' && qntdAttDevsChart && qntdAttDevsChart.w && qntdAttDevsChart.w.config && qntdAttDevsChart.w.config.xaxis) {
          var cats = qntdAttDevsChart.w.config.xaxis.categories || [];
          devName = cats[config.dataPointIndex] || '';
        }

        if (!devName) {
          // fallback to static list if present
          var fallback = ['Caio Andrade', 'Davi Andrade', 'Franklin', 'Jeff', 'Kayo', 'Max', 'Milene', 'Moab', 'Murillo', 'Newton'];
          devName = fallback[config.dataPointIndex] || '';
        }

        if (devName) {
          showTestsModal('Tickets - ' + devName, 'atribuido_a', devName);
        }
      }
        }
    },
  tooltip: {
    y: {
      formatter: function(val, opts) {
        // val may be number or string; normalize
        var count = (typeof val === 'number') ? Math.round(val) : Math.round(Number(String(val).replace(',', '.')) || 0);
        var totalTickets = (typeof donutTotalTickets !== 'undefined') ? Number(donutTotalTickets) : 0;
        var percent = totalTickets ? ((count / totalTickets) * 100).toFixed(1) : '0.0';
        return count + ' (' + percent + ' %)';
      }
    }
  },
    xaxis: { categories: ['Caio Andrade', 'Davi Andrade', 'Franklin', 'Jeff', 'Kayo', 'Max', 'Milene', 'Moab', 'Murillo', 'Newton'] },
    

    // Deixando a formatação dos números laterais do gráfico c
    responsive: [{ breakpoint: 768, options: { chart: { width: '100%', height: 382 } } }],
    plotOptions: { bar: { horizontal: false, columnWidth: '70%', endingShape: 'flat' } },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    colors: ['#2b15c1'],
    yaxis: {
      title: { text: '' },
      labels: { formatter: function(val) { return String(Math.round(Number(val) || 0)); } }
    },
    fill: { opacity: 1 },
    legend: { position: 'top', horizontalAlign: 'center', offsetY: 0 }
};

var qntdAttDevsChart = new ApexCharts(document.querySelector('#qntd-att-devs'), qntdAttDevsOptions);
qntdAttDevsChart.render();

function loadDevActivities() {
  fetch(buildUrlWithSprint('/api/devs/activities-count'), { cache: 'no-store' })
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

  }

  // TestesPorEstrutura: cópia do exemplo de barra horizontal
var testesPorEstruturaOptions = {
    chart: {
        height: 800,
        type: 'bar',
        toolbar: { show: false }
    ,
    events: {
      dataPointSelection: function(event, chartContext, config) {
        try {
          var cat = '';
          if (chartContext && chartContext.w && chartContext.w.config && chartContext.w.config.xaxis && Array.isArray(chartContext.w.config.xaxis.categories)) {
            cat = chartContext.w.config.xaxis.categories[config.dataPointIndex] || '';
          }
        } catch(e) { var cat = ''; }
        if (!cat && typeof testesPorEstrutura !== 'undefined' && testesPorEstrutura && testesPorEstrutura.w && testesPorEstrutura.w.config && testesPorEstrutura.w.config.xaxis) {
          var cats = testesPorEstrutura.w.config.xaxis.categories || [];
          cat = cats[config.dataPointIndex] || '';
        }
        if (cat) {
          showTestsModal('Tickets - ' + cat, 'estrutura', cat);
        }
      }
    }
    },
    plotOptions: {
        bar: { horizontal: true }
    },
    dataLabels: { enabled: false },
    // Use named series so ApexCharts tooltip shows the series name (matches other charts)
    series: [{ name: 'Quantidade', data: [380, 430, 450, 475, 550, 584, 780, 1100, 1220, 1365] }],
    colors: ['#1cbb8c'],
    tooltip: {
      enabled: true,
      shared: false,
      intersect: true,
      y: {
        formatter: function(val, opts) {
          // normalize value
          var count = (typeof val === 'number') ? Math.round(val) : Math.round(Number(String(val).replace(',', '.')) || 0);
          var totalTickets = (typeof donutTotalTickets !== 'undefined') ? Number(donutTotalTickets) : 0;
          var percent = '0.0';
          if (totalTickets) {
            percent = ((count / totalTickets) * 100).toFixed(1);
          } else {
            // fallback to series sum
            try {
              var sdata = (testesPorEstruturaOptions && testesPorEstruturaOptions.series && testesPorEstruturaOptions.series[0] && testesPorEstruturaOptions.series[0].data) ? testesPorEstruturaOptions.series[0].data : [];
              var sum = sdata.reduce(function(a,b){ return a + (Number(b)||0); }, 0);
              percent = sum ? ((count / sum) * 100).toFixed(1) : '0.0';
            } catch(e){ percent = '0.0'; }
          }
          return count + ' (' + percent + ' %)';
        }
      }
    },
    grid: { borderColor: '#f1f1f1', padding: { bottom: 5 } },
    legend: { offsetY: 5 }
};

var testesPorEstrutura = new ApexCharts(document.querySelector('#testes-por-estrutura'), testesPorEstruturaOptions);
testesPorEstrutura.render();
// Carrega dados do backend para TestesPorEstrutura e atualiza card total-estruturas
function loadStructuresCount() {
  fetch(buildUrlWithSprint('/api/structures/tests-count'), { cache: 'no-store' })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if (data && Array.isArray(data.categories) && Array.isArray(data.series)) {
        testesPorEstrutura.updateOptions({ xaxis: { categories: data.categories } });
        testesPorEstrutura.updateSeries(data.series);
        var totEstrEl = document.getElementById('total-estruturas');
        if (totEstrEl && typeof data.totalEstruturas === 'number') {
          totEstrEl.textContent = String(data.totalEstruturas);
        }
        console.log('structures-count:', { categories: data.categories,totalEstruturas: data.totalEstruturas });
      }
    })
    .catch(function(err){ console.error('structures-tests-count error', err); });
}

// Helper: load all charts (used on sprint change)
function loadAllCharts() {
  loadStatusDistribution();
  loadDevActivities();
  loadStructuresCount();
}

// Generic helper to open the system modal and load tests for a given field/value
function showTestsModal(titleText, field, value) {
  var modalElement = document.getElementById('donutModal');
  if (!modalElement) return;
  var title = document.getElementById('modalTitle');
  if (title) title.textContent = titleText;
  var modalBody = modalElement.querySelector('.modal-body');
  // create and show modal immediately, then populate it asynchronously
  var modal = new bootstrap.Modal(modalElement);
  modal.show();
  // ensure close buttons hide the modal (covers data-dismiss/data-bs-dismiss and .btn-close)
  try {
    var closeEls = modalElement.querySelectorAll('[data-bs-dismiss="modal"],[data-dismiss="modal"], .btn-close, .modal-footer .btn');
    closeEls.forEach(function(btn){
      btn.addEventListener('click', function(ev){ try { modal.hide(); } catch(e){} });
    });
  } catch(e){}

  if (modalBody) {
    modalBody.innerHTML = '<div class="text-center py-4">Carregando...</div>';
    var url = buildUrlWithSprint('/api/tests/search?field=' + encodeURIComponent(field) + '&value=' + encodeURIComponent(value));
    fetch(url, { cache: 'no-store' })
      .then(function(r){ return r.json(); })
      .then(function(data){
        var items = (data && Array.isArray(data.tests)) ? data.tests : [];
        if (!items.length) {
          modalBody.innerHTML = '<div class="text-center py-3 text-muted">Nenhum ticket encontrado.</div>';
          return;
        }
        var escapeHtml = function(str){ return String(str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;'); };
        var html = '<div style="max-height:420px;overflow:auto;padding-right:6px">';
  var statusColors = { 'Reprovado': '#bf304a', 'Aprovado': '#4d8764', 'Validado': '#232db8' };
  var isStatus = (field === 'resultado');
  // colors for other charts
  var fieldColors = { 'atribuido_a': '#2b15c1', 'estrutura': '#1cbb8c' };
        items.forEach(function(t){
          var ticket = (t.numero_ticket !== null && typeof t.numero_ticket !== 'undefined') ? ('#' + String(t.numero_ticket)) : '';
          var resumo = escapeHtml(t.resumo_tarefa || '');
          var link = t.link_tarefa || '#';
          // determine display label and color
          var labelText = '';
          if (field === 'resultado') {
            labelText = value;
          } else if (field === 'atribuido_a') {
            // show the actual developer name (value) instead of the generic label
            labelText = value || '';
          } else if (field === 'estrutura') {
            // show the specific estrutura name when available
            labelText = value || 'Estrutura';
          } else {
            labelText = field;
          }
          var labelEsc = escapeHtml(labelText);
          var color = null;
          if (field === 'resultado') {
            color = statusColors[value] || '#444';
          } else if (fieldColors[field]) {
            color = fieldColors[field];
          }
          var cardStyle = 'background:#23272b;border-radius:10px;padding:18px 16px 14px 16px;margin-bottom:18px;box-shadow:0 2px 8px rgba(0,0,0,0.07);border:1px solid #343a40;';
          var divider = '<hr style="border:0;border-top:1.5px solid #343a40;margin:0 0 14px 0;">';
          html += '<div style="' + cardStyle + '">';
          html += '<div class="d-flex align-items-start mb-1">';
          if (color) {
            html += '<div style="flex:0 0 90px;padding-top:4px;">' +
                      '<span style="display:inline-block;padding:.25rem .5rem;border-radius:.25rem;background:' + color + ';color:#fff;font-size:1rem;">' + labelEsc + '</span>' +
                    '</div>';
          } else {
            html += '<div style="flex:0 0 90px;padding-top:4px;">' +
                      '<span class="badge badge-info" style="padding:.35rem .6rem;font-size:1rem;">' + labelEsc + '</span>' +
                    '</div>';
          }
          html += '<div class="flex-fill">' +
                      '<a href="' + escapeHtml(link) + '" target="_blank" style="text-decoration:underline;color:#f8f9fa;font-size:1.08rem;">' + ticket + ' - ' + resumo + '</a>' +
                    '</div>';
          html += '</div>';
          html += '</div>';
          html += divider;
        });
        html += '</div>';
        modalBody.innerHTML = html;
      })
      .catch(function(err){ console.error('tests-search error', err); modalBody.innerHTML = '<div class="text-center py-3 text-muted">Erro ao carregar os tickets.</div>'; });
  }
}

// Load available sprints and wire change handler
function loadSprints() {
  var btn = document.getElementById('sprintDropdownBtn');
  var menu = document.getElementById('sprintDropdownMenu');
  if (!menu || !btn) return;
  fetch('/api/tests/sprints?_=' + Date.now(), { cache: 'no-store' })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if (!data || !Array.isArray(data.sprints)) return;
      // Clear existing and add default
      menu.innerHTML = '';
      var defaultItem = document.createElement('a');
      defaultItem.className = 'dropdown-item';
      defaultItem.href = '#';
      defaultItem.setAttribute('data-sprint', '');
      defaultItem.textContent = 'Todas as Sprints';
      menu.appendChild(defaultItem);

      data.sprints.forEach(function(s){
        var opt = document.createElement('a');
        opt.className = 'dropdown-item';
        opt.href = '#';
        opt.setAttribute('data-sprint', s);
        opt.textContent = s;
        menu.appendChild(opt);
      });

      // attach click handlers for each item
      var items = menu.querySelectorAll('.dropdown-item');
      items.forEach(function(a){
        a.addEventListener('click', function(ev){
          ev.preventDefault();
          var sp = a.getAttribute('data-sprint') || '';
          btn.setAttribute('data-sprint', sp);
          btn.innerHTML = (sp || 'Todas as Sprints') + ' <i class="mdi mdi-chevron-down"></i>';
          // reload charts for the selected sprint
          loadAllCharts();
        });
      });
    })
    .catch(function(err){ console.error('sprints list error', err); });
}

// initialize sprint selector and load charts
loadSprints();
loadAllCharts();
