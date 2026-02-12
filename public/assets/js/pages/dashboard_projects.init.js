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
    var container = document.getElementById('doughnut');
    if (!container) return;
    if (typeof ApexCharts === 'undefined') {
      console.warn('ApexCharts not available — doughnut will initialize on next load.');
      return;
    }

    var doughnutChartInstance = null;

    function createOrUpdateDoughnut(labels, data) {
      try {
        if (doughnutChartInstance) {
          try { doughnutChartInstance.destroy(); } catch(e){}
          doughnutChartInstance = null;
        }

        var colors = ['#5664d2','#ff3d60','#1cc88a','#f6c23e','#6c5ce7'];
        var opts = {
          chart: {
            height: '100%',
            type: 'donut',
            events: {
              dataPointSelection: function(event, chartContext, config) {
                var idx = config && typeof config.dataPointIndex !== 'undefined' ? config.dataPointIndex : null;
                if (idx === null) return;
                var devName = (labels && labels[idx]) ? labels[idx] : '—';

                if (devName !== '—') {
                  showTasksModal('Tarefas de: ' + devName, 'atribuido_a', devName);
                }
              }
            }
          },
          stroke: { show: false },
          labels: labels.length ? labels : ['Sem dados'],
          series: data.length ? data : [0],
          plotOptions: { pie: { donut: { size: '75%' }, customScale: 0.9 } },
          responsive: [{
            breakpoint: 1400,
            options: {
              plotOptions: {
                pie: {
                  customScale: 0.8,
                  donut: {
                    size: '70%'
                  }
                }
              }
            }
          }],
          dataLabels: { enabled: false },
          legend: { show: false },
          colors: colors,
          tooltip: { y: { formatter: function(val){ return (val || 0) + ' atividades'; } } }
        };

        doughnutChartInstance = new ApexCharts(container, opts);
        doughnutChartInstance.render().then(function(){
          try {
            var colorsUsed = (doughnutChartInstance.w && doughnutChartInstance.w.config && doughnutChartInstance.w.config.colors) ? doughnutChartInstance.w.config.colors : opts.colors;
            // sync color of any existing mdi dots (defensive)
            try {
              var cardBody = container.closest('.card-body');
              var legendContainerOld = cardBody ? cardBody.querySelector('.row') : null;
              if (legendContainerOld) {
                var legendDots = legendContainerOld.querySelectorAll('.mdi-circle');
                legendDots.forEach(function(dot, idx){
                  dot.classList.remove('text-info','text-danger','text-warning','text-primary','text-success');
                  if (colorsUsed && colorsUsed[idx]) { dot.style.color = colorsUsed[idx]; }
                });
              }
            } catch(e){}

            // populate the new HTML legend under the doughnut (doughnut-legend)
            try {
              var legendEl = document.getElementById('doughnut-legend');
              if (legendEl) {
                var labelEls = legendEl.querySelectorAll('.legend-label');
                var pctEls = legendEl.querySelectorAll('.legend-percent');
                var dotEls = legendEl.querySelectorAll('.legend-dot');
                var total = 0;
                try { total = (data && data.length) ? data.reduce(function(a,b){ return a + (Number(b)||0); }, 0) : 0; } catch(e){ total = 0; }
                for (var i = 0; i < 3; i++) {
                  var lab = labels && labels[i] ? labels[i] : '-';
                  var val = data && (typeof data[i] !== 'undefined') ? Number(data[i]) : 0;
                  var pct = (total > 0) ? ((val / total) * 100).toFixed(1) + ' %' : '-';
                  if (labelEls[i]) labelEls[i].textContent = lab;
                  if (pctEls[i]) pctEls[i].textContent = (pct === 'NaN %' ? '-' : pct);
                  if (dotEls[i]) {
                    // clear existing bootstrap color utils and set inline color to match slice
                    dotEls[i].classList.remove('text-info','text-danger','text-warning','text-primary','text-success');
                    if (colorsUsed && colorsUsed[i]) dotEls[i].style.color = colorsUsed[i];
                    else dotEls[i].style.color = '';
                  }
                }
              }
            } catch(e) { console.warn('Could not populate doughnut legend:', e); }

          } catch (e) { console.warn('Could not sync doughnut legend colors:', e); }
        });

        // store last data for external access
        try { container._lastData = { labels: labels.slice(), counts: data.slice() }; } catch(e){}
      } catch(e) { console.warn('createOrUpdateDoughnut error', e); }
    }

    // Fetch data from API and update chart
    async function fetchAndUpdate(dev, range, start, end) {
      try {
        var qs = '?';
        if (dev) qs += 'dev=' + encodeURIComponent(dev) + '&';
        qs += 'range=' + encodeURIComponent(range || 'month');
        if (range === 'custom') {
          if (start) qs += '&start=' + encodeURIComponent(start);
          if (end) qs += '&end=' + encodeURIComponent(end);
        }
        var res = await fetch('/api/dashboard/projects-by-dev' + qs);
        if (!res.ok) throw new Error('HTTP ' + res.status);
        var json = await res.json();
        var labels = json.labels || [];
        var counts = json.counts || json.count || json.counts || [];
        counts = Array.isArray(counts) ? counts.map(function(v){ return Number(v)||0; }) : [];

        createOrUpdateDoughnut(labels, counts);
        try { container._lastData = { labels: labels.slice(), counts: counts.slice() }; } catch(e){}
      } catch (e) {
        console.warn('Error fetching projects-by-dev:', e);
        try { container.innerHTML = '<div style="padding:20px;text-align:center;color:#d9534f">Erro ao carregar o gráfico</div>'; } catch(err){}
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
        try {
          var url = new URL(window.location.href);
          if (dev) url.searchParams.set('dev', dev); else url.searchParams.delete('dev');
          url.searchParams.set('dev_range', range);
          if (start) url.searchParams.set('dev_start', start); else url.searchParams.delete('dev_start');
          if (end) url.searchParams.set('dev_end', end); else url.searchParams.delete('dev_end');
          window.history.replaceState({}, '', url.toString());
        } catch(err) {}
      });

      var initialDev = null;
      if (typeof window.initialDev !== 'undefined' && window.initialDev) {
        initialDev = window.initialDev;
      } else if (devSelect) {
        for (var i = 0; i < devSelect.options.length; i++) {
          var opt = devSelect.options[i];
          if (opt && opt.value && opt.value.toString().trim() !== '') { initialDev = opt.value; break; }
        }
        if (!initialDev) initialDev = devSelect.value || null;
      } else if (window.devList && window.devList.length) {
        initialDev = window.devList[0];
      }
      if (devSelect && initialDev) devSelect.value = initialDev;
      var initialRange = (typeof window.initialDevRange !== 'undefined') ? window.initialDevRange : (rangeSelect ? rangeSelect.value : 'month');
      if (rangeSelect) rangeSelect.value = initialRange;
      if (startInput && window.initialDevStart) startInput.value = window.initialDevStart;
      if (endInput && window.initialDevEnd) endInput.value = window.initialDevEnd;

      fetchAndUpdate(devSelect ? devSelect.value : initialDev, rangeSelect ? rangeSelect.value : initialRange, startInput ? startInput.value : null, endInput ? endInput.value : null);
    } else {
      // No filter form — fallback to previous static summary parsing
      var cardBody = container.closest('.card-body');
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
        chart: { type: 'area', height: 550, toolbar: { show: true } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        series: [ { name: 'Criadas', data: created }, { name: 'Validadas', data: validated } ],
        colors: ['#5664d2', '#1cbb8c'],
        markers: { size: 5 },
        xaxis: { categories: labels, labels: { rotate: -45 } },
        yaxis: { title: { text: 'Quantidade' } },
        legend: { position: 'bottom' },
        tooltip: { shared: true, intersect: false },
        responsive: [{
            breakpoint: 1400,
            options: {
                chart: {
                    height: 400
                }
            }
        }]
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
