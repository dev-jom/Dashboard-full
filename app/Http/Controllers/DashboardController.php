<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Data atual
        $now = Carbon::now();
        $mesAtual = $now->month;
        $anoAtual = $now->year;

        // Projetos distintos com tickets criados este mês
        $projetosMes = DB::table('tickets_redmine')
            ->select('project')
            ->whereYear('created_at', $anoAtual)
            ->whereMonth('created_at', $mesAtual)
            ->distinct()
            ->count('project');

        // Projetos no mês anterior
        $prevMonth = $now->copy()->subMonth();
        $mesAnterior = $prevMonth->month;
        $anoMesAnterior = $prevMonth->year;
        $projetosMesPrev = DB::table('tickets_redmine')
            ->select('project')
            ->whereYear('created_at', $anoMesAnterior)
            ->whereMonth('created_at', $mesAnterior)
            ->distinct()
            ->count('project');

        // Calcula variação percentual mês a mês
        if ($projetosMesPrev == 0) {
            if ($projetosMes == 0) {
                $projetosMesChange = 0;
                $projetosMesIsUp = false;
            } else {
                $projetosMesChange = 100;
                $projetosMesIsUp = true;
            }
        } else {
            $projetosMesChange = round((($projetosMes - $projetosMesPrev) / $projetosMesPrev) * 100, 1);
            $projetosMesIsUp = ($projetosMes - $projetosMesPrev) >= 0;
        }

        // Projetos distintos com tickets criados este ano
        $projetosAno = DB::table('tickets_redmine')
            ->select('project')
            ->whereYear('created_at', $anoAtual)
            ->distinct()
            ->count('project');

        // Projetos no ano anterior
        $anoAnterior = $anoAtual - 1;
        $projetosAnoPrev = DB::table('tickets_redmine')
            ->select('project')
            ->whereYear('created_at', $anoAnterior)
            ->distinct()
            ->count('project');

        // Calcula variação percentual ano a ano
        if ($projetosAnoPrev == 0) {
            if ($projetosAno == 0) {
                $projetosAnoChange = 0;
                $projetosAnoIsUp = false;
            } else {
                $projetosAnoChange = 100;
                $projetosAnoIsUp = true;
            }
        } else {
            $projetosAnoChange = round((($projetosAno - $projetosAnoPrev) / $projetosAnoPrev) * 100, 1);
            $projetosAnoIsUp = ($projetosAno - $projetosAnoPrev) >= 0;
        }

        // --- Sprint calculations (10 business days per sprint) ---
        $sprintInfo = $this->inferSprintFromDate($now->toDateString());
        $sprintStart = $sprintInfo['start'];
        $sprintEnd = $sprintInfo['end'];
        $sprintLabel = $sprintInfo['label'];
        $sprintNumber = $sprintInfo['number'];

        // projetos na sprint atual
        $projetosSprint = DB::table('tickets_redmine')
            ->select('project')
            ->whereBetween('created_at', [$sprintStart->startOfDay(), $sprintEnd->endOfDay()])
            ->distinct()
            ->count('project');

        // sprint anterior
        $prevSprintStart = $this->addBusinessDays($sprintStart->toDateString(), -10);
        $prevSprintEnd = $this->addBusinessDays($prevSprintStart, 9);
        $projetosSprintPrev = DB::table('tickets_redmine')
            ->select('project')
            ->whereBetween('created_at', [
                Carbon::parse($prevSprintStart)->startOfDay(),
                Carbon::parse($prevSprintEnd)->endOfDay()
            ])
            ->distinct()
            ->count('project');

        // variação sprint a sprint
        if ($projetosSprintPrev == 0) {
            if ($projetosSprint == 0) {
                $projetosSprintChange = 0;
                $projetosSprintIsUp = false;
            } else {
                $projetosSprintChange = 100;
                $projetosSprintIsUp = true;
            }
        } else {
            $projetosSprintChange = round((($projetosSprint - $projetosSprintPrev) / $projetosSprintPrev) * 100, 1);
            $projetosSprintIsUp = ($projetosSprint - $projetosSprintPrev) >= 0;
        }

        // --- Top projects by activity (period filter: month|year|custom) ---
        $range = $request->query('range', 'month'); // month, year, custom
        $topLimit = max(1, (int) $request->query('top', 3));
        if ($range === 'year') {
            $periodStart = $now->copy()->startOfYear();
            $periodEnd = $now->copy()->endOfYear();
            $periodLabel = 'Este ano';
        } elseif ($range === 'custom') {
            $startStr = $request->query('start');
            $endStr = $request->query('end');
            try {
                $periodStart = $startStr ? Carbon::parse($startStr)->startOfDay() : $now->copy()->startOfMonth();
            } catch (\Exception $e) {
                $periodStart = $now->copy()->startOfMonth();
            }
            try {
                $periodEnd = $endStr ? Carbon::parse($endStr)->endOfDay() : $now->copy()->endOfMonth();
            } catch (\Exception $e) {
                $periodEnd = $now->copy()->endOfMonth();
            }
            $periodLabel = ($periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'));
        } else {
            // default: month
            $periodStart = $now->copy()->startOfMonth();
            $periodEnd = $now->copy()->endOfMonth();
            $periodLabel = 'Este mês';
        }

        $topProjectsQuery = DB::table('tickets_redmine')
            ->select('project', DB::raw('count(*) as activities'))
            ->whereBetween('created_at', [$periodStart->startOfDay(), $periodEnd->endOfDay()])
            ->groupBy('project')
            ->orderByDesc('activities')
            ->limit($topLimit)
            ->get();

        $topProjectsLabels = $topProjectsQuery->pluck('project')->toArray();
        $topProjectsCounts = $topProjectsQuery->pluck('activities')->toArray();

        // total activities in the period (for percentage calculation)
        $totalActivities = DB::table('tickets_redmine')
            ->whereBetween('created_at', [$periodStart->startOfDay(), $periodEnd->endOfDay()])
            ->count();

        $topProjectsPercentages = [];

        // If there are no activities in the selected date range, try fallback by sprint code (e.g. SP154)
        if ($totalActivities === 0 || empty($topProjectsCounts)) {
            $sprintCode = 'SP' . $sprintNumber;
            // Try to get top projects by sprint code (extract SP### from the free-text `sprint` column)
            $topProjectsQuery = DB::table('tickets_redmine')
                ->select(DB::raw("project, count(*) as activities"))
                ->whereRaw("substring(sprint from '(SP[0-9]+)') = ?", [$sprintCode])
                ->groupBy('project')
                ->orderByDesc('activities')
                ->limit($topLimit)
                ->get();

            $topProjectsLabels = $topProjectsQuery->pluck('project')->toArray();
            $topProjectsCounts = $topProjectsQuery->pluck('activities')->toArray();

            $totalActivities = DB::table('tickets_redmine')
                ->whereRaw("substring(sprint from '(SP[0-9]+)') = ?", [$sprintCode])
                ->count();

            // adjust period label to indicate we used sprint fallback
            $periodLabel = 'Sprint ' . $sprintCode;
        }

        foreach ($topProjectsCounts as $cnt) {
            if ($totalActivities > 0) {
                $topProjectsPercentages[] = round(($cnt / $totalActivities) * 100, 1);
            } else {
                $topProjectsPercentages[] = 0;
            }
        }

        return view('dashboard', [
            'projetosMes' => $projetosMes,
            'projetosMesPrev' => $projetosMesPrev,
            'projetosMesChange' => $projetosMesChange,
            'projetosMesIsUp' => $projetosMesIsUp,
            'projetosAno' => $projetosAno,
            'projetosAnoPrev' => $projetosAnoPrev,
            'projetosAnoChange' => $projetosAnoChange,
            'projetosAnoIsUp' => $projetosAnoIsUp,
            'projetosSprint' => $projetosSprint,
            'projetosSprintPrev' => $projetosSprintPrev,
            'projetosSprintChange' => $projetosSprintChange,
            'projetosSprintIsUp' => $projetosSprintIsUp,
            'sprintLabel' => $sprintLabel,
            'sprintNumber' => $sprintNumber,
            'topProjectsLabels' => $topProjectsLabels ?? [],
            'topProjectsCounts' => $topProjectsCounts ?? [],
            'topProjectsPercentages' => $topProjectsPercentages ?? [],
            'periodLabel' => $periodLabel ?? null,
        ]);
    }

    /**
     * Infer sprint from a date string (YYYY-MM-DD). Returns array with number, label, start and end as Carbon instances.
     */
    private function inferSprintFromDate($dateStr, $refSprint = 154, $refStartStr = '2025-12-04', $sprintWorkdays = 10)
    {
        $date = Carbon::parse($dateStr)->startOfDay();
        try {
            $refStart = Carbon::parse($refStartStr)->startOfDay();
        } catch (\Exception $e) {
            $refStart = Carbon::create(2025, 12, 4)->startOfDay();
        }

        $bdDiff = $this->businessDaysBetween($refStart->toDateString(), $date->toDateString());
        $sprintIndex = (int) floor($bdDiff / $sprintWorkdays);
        $sprintNumber = $refSprint + $sprintIndex;

        $sprintStart = Carbon::parse($this->addBusinessDays($refStart->toDateString(), $sprintIndex * $sprintWorkdays));
        $sprintEnd = Carbon::parse($this->addBusinessDays($sprintStart->toDateString(), $sprintWorkdays - 1));

        $label = "SP{$sprintNumber} (" . $sprintStart->format('d/m/Y') . " - " . $sprintEnd->format('d/m/Y') . ")";

        return [
            'number' => $sprintNumber,
            'label' => $label,
            'start' => $sprintStart,
            'end' => $sprintEnd,
        ];
    }

    private function isBusinessDay($dateStr)
    {
        $d = Carbon::parse($dateStr);
        return $d->isWeekday();
    }

    private function addBusinessDays($dateStr, $businessDays)
    {
        $date = Carbon::parse($dateStr);
        if ($businessDays == 0) return $date->toDateString();
        $step = $businessDays > 0 ? 1 : -1;
        $remaining = abs($businessDays);
        while ($remaining > 0) {
            $date = $date->addDays($step);
            if ($date->isWeekday()) {
                $remaining--;
            }
        }
        return $date->toDateString();
    }

    private function businessDaysBetween($startStr, $endStr)
    {
        $start = Carbon::parse($startStr)->startOfDay();
        $end = Carbon::parse($endStr)->startOfDay();
        if ($start->equalTo($end)) return 0;
        $sign = 1;
        if ($start->gt($end)) {
            $tmp = $start; $start = $end; $end = $tmp; $sign = -1;
        }
        $days = 0;
        $cur = $start->copy();
        while ($cur->lt($end)) {
            $cur->addDay();
            if ($cur->isWeekday()) $days++;
        }
        return $days * $sign;
    }

    /**
     * Return projects summary as JSON (for quick debugging).
     */
    public function summary(Request $request)
    {
        $now = Carbon::now();
        $mesAtual = $now->month;
        $anoAtual = $now->year;

        $projetosMes = DB::table('tickets_redmine')
            ->select('project')
            ->whereYear('created_at', $anoAtual)
            ->whereMonth('created_at', $mesAtual)
            ->distinct()
            ->count('project');

        $projetosAno = DB::table('tickets_redmine')
            ->select('project')
            ->whereYear('created_at', $anoAtual)
            ->distinct()
            ->count('project');

        return response()->json([
            'projetosMes' => $projetosMes,
            'projetosAno' => $projetosAno,
        ]);
    }

    /**
     * Serve the "All Projects" page with the 'testes-por-estrutura' chart data.
     */
    public function projectsAll(Request $request)
    {
        $now = Carbon::now();

        // Determine period from query (reuse same logic as index)
        $range = $request->query('range', 'month');
        if ($range === 'year') {
            $periodStart = $now->copy()->startOfYear();
            $periodEnd = $now->copy()->endOfYear();
            $periodLabel = 'Este ano';
        } elseif ($range === 'custom') {
            $startStr = $request->query('start');
            $endStr = $request->query('end');
            try {
                $periodStart = $startStr ? Carbon::parse($startStr)->startOfDay() : $now->copy()->startOfMonth();
            } catch (\Exception $e) {
                $periodStart = $now->copy()->startOfMonth();
            }
            try {
                $periodEnd = $endStr ? Carbon::parse($endStr)->endOfDay() : $now->copy()->endOfMonth();
            } catch (\Exception $e) {
                $periodEnd = $now->copy()->endOfMonth();
            }
            $periodLabel = ($periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'));
        } else {
            $periodStart = $now->copy()->startOfMonth();
            $periodEnd = $now->copy()->endOfMonth();
            $periodLabel = 'Este mês';
        }

        // Get all projects and their activity counts in the period
        $projectsQuery = DB::table('tickets_redmine')
            ->select('project', DB::raw('count(*) as activities'))
            ->whereBetween('created_at', [$periodStart->startOfDay(), $periodEnd->endOfDay()])
            ->groupBy('project')
            ->orderByDesc('activities')
            ->get();

        $labels = $projectsQuery->pluck('project')->toArray();
        $counts = $projectsQuery->pluck('activities')->toArray();

        $totalActivities = array_sum($counts);
        $percentages = [];
        foreach ($counts as $c) {
            $percentages[] = $totalActivities > 0 ? round(($c / $totalActivities) * 100, 1) : 0;
        }

        return view('projects_all', [
            'topProjectsLabels' => $labels,
            'topProjectsCounts' => $counts,
            'topProjectsPercentages' => $percentages,
            'periodLabel' => $periodLabel,
        ]);
    }

    
}
