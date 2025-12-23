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
      // Limit the number of slices (useful when the HTML shows more summary cols)
      // Set window.doughnutDesiredCount from server or console to override.
      var desiredCount = (window.doughnutDesiredCount && Number(window.doughnutDesiredCount)) || 2;
      if (labels.length > desiredCount) {
        labels = labels.slice(0, desiredCount);
        data = data.slice(0, desiredCount);
      }
    } else {
      labels = ['Activated','Pending'];
      data = [9595,36524];
    }

    // ensure canvas fills its wrapper so Chart.js can compute sizes correctly
    canvas.style.width = canvas.style.width || '100%';
    canvas.style.height = canvas.style.height || '100%';
    var ctx = canvas.getContext('2d');
    if (canvas._chartInstance) { canvas._chartInstance.destroy(); }

    var doughnutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: ['#5664d2','#ff3d60'],
          hoverBackgroundColor: ['#5664d2','#ff3d60'],
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
    canvas._chartInstance = doughnutChart;
  } catch (e) {
    console.error('Error initializing doughnut chart (projects):', e);
  }
});
