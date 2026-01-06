// Projects chart initializer - uses server-injected arrays
// Expects: window.topProjectsLabels, window.topProjectsCounts, window.topProjectsPercentages, window.periodLabel
(function(){
  var container = document.querySelector('#testes-por-estrutura');
  if (!container) return;

  // Safe getters from injected window variables
  var labels = (window.topProjectsLabels && Array.isArray(window.topProjectsLabels)) ? window.topProjectsLabels.slice() : [];
  var counts = (window.topProjectsCounts && Array.isArray(window.topProjectsCounts)) ? window.topProjectsCounts.map(function(v){ return Number(v)||0; }) : [];
  var percents = (window.topProjectsPercentages && Array.isArray(window.topProjectsPercentages)) ? window.topProjectsPercentages.slice() : [];

  // Default fallback if no data provided
  if (!labels.length) {
    labels = ['Sem dados'];
  }
  if (!counts.length) {
    counts = labels.map(function(){ return 0; });
  }

  var projetosOptions = {
    chart: {
      type: 'bar',
      height: 700,
      toolbar: { show: false }
    },
    plotOptions: { bar: { horizontal: true } },
    dataLabels: { enabled: false },
    series: [{ name: 'Quantidade', data: counts }],
    xaxis: { categories: labels },
    tooltip: {
      y: {
        formatter: function(val, opts) {
          var count = (typeof val === 'number') ? Math.round(val) : Math.round(Number(val) || 0);
          var total = counts.reduce(function(a,b){ return a + (Number(b)||0); }, 0);
          var pct = '0.0';
          if (total) pct = ((count / total) * 100).toFixed(1);
          return count + ' (' + pct + ' %)';
        }
      }
    },
    grid: { borderColor: '#f1f1f1', padding: { bottom: 5 } },
    colors: ['#1cbb8c']
  };

  var projetosChart = new ApexCharts(container, projetosOptions);
  projetosChart.render();

  // update total projects/activities element if present
  var totalEl = document.getElementById('total-estruturas');
  if (totalEl) {
    // show total activities if available, otherwise number of projects
    var totalActivities = counts.reduce(function(a,b){ return a + (Number(b)||0); }, 0);
    totalEl.textContent = String(totalActivities || labels.length || 0);
  }

  // expose a small API to update the chart if page injects new data later
  window.__projectsChart = {
    update: function(newLabels, newCounts, newPercents){
      try {
        var l = Array.isArray(newLabels) ? newLabels.slice() : labels.slice();
        var c = Array.isArray(newCounts) ? newCounts.map(function(v){ return Number(v)||0; }) : counts.slice();
        projetosChart.updateOptions({ xaxis: { categories: l } });
        projetosChart.updateSeries([{ name: 'Quantidade', data: c }]);
        // update total
        var totalActivities = c.reduce(function(a,b){ return a + (Number(b)||0); }, 0);
        if (totalEl) totalEl.textContent = String(totalActivities || l.length || 0);
      } catch(e){ console.warn('projectsChart.update error', e); }
    }
  };
})();

// Initialize Doughnut Chart on projects dashboard if canvas exists
window.addEventListener('load', function(){
  try {
    var canvas = document.getElementById('doughnut');
    if (!canvas) return;
    if (typeof Chart === 'undefined') {
      console.warn('Chart.js not available yet — doughnut will initialize on next load.');
      return;
    }

    // helper to create or update the doughnut chart instance
    function createOrUpdateDoughnut(labels, data) {
      // ensure canvas fills its wrapper so Chart.js can compute sizes correctly
      canvas.style.width = canvas.style.width || '100%';
      canvas.style.height = canvas.style.height || '100%';
      var ctx = canvas.getContext('2d');
      if (canvas._chartInstance) { canvas._chartInstance.destroy(); }
      var colors = ['#5664d2','#ff3d60','#1cc88a','#f6c23e','#6c5ce7'];
      canvas._chartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: labels.length ? labels : ['Sem dados'],
          datasets: [{
            data: data.length ? data : [0],
            backgroundColor: colors.slice(0, Math.max(1, labels.length || 1)),
            hoverBackgroundColor: colors.slice(0, Math.max(1, labels.length || 1)),
            hoverBorderColor: '#fff'
          }]
        },
        options: {
          maintainAspectRatio: false,
          legend: { position: 'bottom' },
          cutoutPercentage: 60,
          tooltips: { callbacks: { label: function(tooltipItem, data){
            var d = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || 0;
            return data.labels[tooltipItem.index] + ': ' + d.toLocaleString();
          } } }
        }
      });
      // show chart container and hide placeholder
      try {
        var containerEl = document.getElementById('doughnut-container');
        var placeholderEl = document.getElementById('doughnut-placeholder');
        if (containerEl) containerEl.style.display = 'block';
        if (placeholderEl) placeholderEl.style.display = 'none';
      } catch (e) {}

      // attach last data so click handler can access counts
      canvas._lastData = { labels: labels.slice(), counts: data.slice() };

      // attach click handler to open modal with details
      try {
        canvas.onclick = function(evt) {
          try {
            if (!canvas._chartInstance) return;
            var active = canvas._chartInstance.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!active || !active.length) return;
            var idx = active[0].index;
            var d = canvas._lastData || {};
            var project = (d.labels && d.labels[idx]) ? d.labels[idx] : '—';
            var value = (d.counts && d.counts[idx]) ? d.counts[idx] : 0;

            document.getElementById('modalTitle').textContent = 'Detalhes do Projeto';
            document.getElementById('modalProject').textContent = project;
            document.getElementById('modalValue').textContent = value;
            var details = 'Atividades: ' + value;
            document.getElementById('modalDetails').textContent = details;

            var modalElement = document.getElementById('donutModal');
            if (modalElement) {
              var modal = new bootstrap.Modal(modalElement);
              modal.show();
            }
          } catch (err) { console.warn('donut click handler error', err); }
        };
      } catch (e) { /* ignore if bootstrap or Chart not available */ }
    }

    // Fetch data from API and update chart
    async function fetchAndUpdate(dev, range, start, end) {
      try {
        if (!dev) {
          // no dev selected — hide chart and show placeholder
          try {
            var containerEl = document.getElementById('doughnut-container');
            var placeholderEl = document.getElementById('doughnut-placeholder');
            if (containerEl) containerEl.style.display = 'none';
            if (placeholderEl) {
              placeholderEl.style.display = 'flex';
              placeholderEl.textContent = 'Selecione o filtro para visualizar o gráfico';
            }
          } catch (e) {}
          return;
        }

        var qs = '?dev=' + encodeURIComponent(dev) + '&range=' + encodeURIComponent(range || 'month');
        if (range === 'custom') {
          if (start) qs += '&start=' + encodeURIComponent(start);
          if (end) qs += '&end=' + encodeURIComponent(end);
        }
        var res = await fetch('/api/dashboard/projects-by-dev' + qs);
        if (!res.ok) throw new Error('HTTP ' + res.status);
        var json = await res.json();
        var labels = json.labels || [];
        var counts = json.counts || json.count || json.counts || [];
        // ensure numeric arrays
        counts = Array.isArray(counts) ? counts.map(function(v){ return Number(v)||0; }) : [];

        // update the chart with projects (labels) and counts
        createOrUpdateDoughnut(labels, counts);
        try { if (canvas) canvas._lastData = { labels: labels.slice(), counts: counts.slice() }; } catch(e){}
      } catch (e) {
        console.warn('Error fetching projects-by-dev:', e);
        try {
          var containerEl = document.getElementById('doughnut-container');
          var placeholderEl = document.getElementById('doughnut-placeholder');
          if (containerEl) containerEl.style.display = 'none';
          if (placeholderEl) placeholderEl.style.display = 'flex';
          if (placeholderEl) placeholderEl.textContent = 'Erro ao carregar o gráfico';
        } catch(err){}
      }
    }

    // Wire the filter form (if present)
    var form = document.getElementById('dev-projects-filter-form');
    if (form) {
      var devSelect = document.getElementById('dev-select');
      var rangeSelect = document.getElementById('dev-range-select');
      var startInput = document.getElementById('dev-start-date');
      var endInput = document.getElementById('dev-end-date');

      function toggleCustom() {
        if (!rangeSelect) return;
        if (rangeSelect.value === 'custom') {
          if (startInput) startInput.style.display = 'inline-block';
          if (endInput) endInput.style.display = 'inline-block';
        } else {
          if (startInput) startInput.style.display = 'none';
          if (endInput) endInput.style.display = 'none';
        }
      }
      rangeSelect && rangeSelect.addEventListener('change', toggleCustom);
      toggleCustom();

      form.addEventListener('submit', function(e){
        e.preventDefault();
        var dev = devSelect ? devSelect.value : null;
        var range = rangeSelect ? rangeSelect.value : 'month';
        var start = startInput ? startInput.value : null;
        var end = endInput ? endInput.value : null;
        fetchAndUpdate(dev, range, start, end);
        // update URL query params without reloading so back/refresh keep state
        try {
          var url = new URL(window.location.href);
          if (dev) url.searchParams.set('dev', dev); else url.searchParams.delete('dev');
          url.searchParams.set('dev_range', range);
          if (start) url.searchParams.set('dev_start', start); else url.searchParams.delete('dev_start');
          if (end) url.searchParams.set('dev_end', end); else url.searchParams.delete('dev_end');
          window.history.replaceState({}, '', url.toString());
        } catch(err) { /* ignore */ }
      });

      // initial load: prefer window.initialDev or first option
      var initialDev = (typeof window.initialDev !== 'undefined' && window.initialDev) ? window.initialDev : (window.devList && window.devList.length ? window.devList[0] : (devSelect ? devSelect.value : null));
      if (devSelect && initialDev) devSelect.value = initialDev;
      var initialRange = (typeof window.initialDevRange !== 'undefined') ? window.initialDevRange : (rangeSelect ? rangeSelect.value : 'month');
      if (rangeSelect) rangeSelect.value = initialRange;
      if (startInput && window.initialDevStart) startInput.value = window.initialDevStart;
      if (endInput && window.initialDevEnd) endInput.value = window.initialDevEnd;

      fetchAndUpdate(devSelect ? devSelect.value : initialDev, rangeSelect ? rangeSelect.value : initialRange, startInput ? startInput.value : null, endInput ? endInput.value : null);
    } else {
      // No filter form — fallback to previous static summary parsing
      var cardBody = canvas.closest('.card-body');
      var summaryCols = cardBody ? cardBody.querySelectorAll('.row.text-center .col-4') : [];
      var labels = [];
      var data = [];
      if (summaryCols && summaryCols.length) {
        summaryCols.forEach(function(col){
          var numEl = col.querySelector('h5');
          var labelEl = col.querySelector('p');
          var rawNum = numEl ? numEl.textContent.trim().replace(/[^0-9]/g,'') : '';
          var value = rawNum === '' ? 0 : parseInt(rawNum,10);
          data.push(value);
          labels.push(labelEl ? labelEl.textContent.trim() : '—');
        });
      } else {
        labels = ['Activated','Pending']; data = [9595,36524];
      }
      createOrUpdateDoughnut(labels, data);
    }
  } catch (e) {
    console.error('Error initializing doughnut chart (projects):', e);
  }
});

// --- Sprints area chart loader ---
(function(){
  async function loadSprintsArea(query){
    try{
      var qs = (typeof query !== 'undefined' && query !== null) ? (query || '') : (window.location.search || '');
      var container = document.getElementById('spline_area');
      if(!container) return;
      container.innerHTML = '<div style="padding:30px;text-align:center;color:#6c757d">Carregando gráfico...</div>';
      var url = '/api/dashboard/sprints-tasks' + qs;
      var res = await fetch(url);
      if(!res.ok) throw new Error('HTTP '+res.status);
      var json = await res.json();
      var labels = json.labels || [];
      var created = json.created || [];
      var validated = json.validated || [];
      if(!labels.length){ container.innerHTML = '<div style="padding:30px;text-align:center;color:#6c757d">Sem dados para exibir</div>'; return; }
      container.innerHTML = '';
      var options = {
        chart: { type: 'area', height: 373, toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        series: [ { name: 'Criadas', data: created }, { name: 'Validadas', data: validated } ],
        colors: ['#5664d2', '#1cbb8c'],
        markers: { size: 5 },
        xaxis: { categories: labels, labels: { rotate: -45 } },
        yaxis: { title: { text: 'Quantidade' } },
        legend: { position: 'top' },
        tooltip: { shared: true, intersect: false }
      };
      if(typeof ApexCharts === 'undefined'){
        console.warn('ApexCharts not loaded');
        container.innerHTML = '<div style="padding:30px;text-align:center;color:#d9534f">Biblioteca de gráficos não encontrada</div>';
        return;
      }
      var chart = new ApexCharts(container, options);
      chart.render();
      // expose last chart instance so we can update later if needed
      window.__sprintsAreaChart = chart;
    }catch(e){ console.error('Erro carregando sprints area', e); var c=document.getElementById('spline_area'); if(c) c.innerHTML = '<div style="padding:30px;text-align:center;color:#d9534f">Erro ao carregar gráfico</div>' }
  }

  // expose a helper to reload the sprints area from other code (e.g. form submit)
  window.reloadSprintsArea = function(query){ return loadSprintsArea(query); };

  if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ loadSprintsArea(); }); else loadSprintsArea();
})();
