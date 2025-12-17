<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardTesteApiController extends Controller
{
    // GET /api/tests/status-distribution
    public function statusDistribution(Request $request)
    {
        // Normaliza o campo 'resultado' para chaves canônicas
        $sprint = $request->query('sprint');
        $query = Test::select('resultado');
        if ($sprint) {
            $query = $query->where('sprint', $sprint);
        }

        $rows = $query->get()
            ->map(function ($t) {
                $val = trim((string) $t->resultado);
                $low = mb_strtolower(self::removeAccents($val));
                if (strpos($low, 'aprov') !== false) return 'Aprovado';
                if (strpos($low, 'valid') !== false) return 'Validado';
                if (strpos($low, 'reprov') !== false) return 'Reprovado';
                return $val ?: 'Indefinido';
            })
            ->groupBy(function ($v) { return $v; })
            ->map(function ($g) { return $g->count(); });

        $order = ['Reprovado', 'Aprovado', 'Validado'];
        $series = [];
        foreach ($order as $k) { $series[] = (int) ($rows[$k] ?? 0); }

        return response()->json([
            'labels' => $order,
            'series' => $series,
            'total'  => array_sum($series),
        ]);
    }

    // GET /api/devs/activities-count
    public function devActivitiesCount(Request $request)
    {
        // Normaliza nomes, ignora vazios e conta por dev
        $sprint = $request->query('sprint');
        $query = Test::select('atribuido_a');
        if ($sprint) { $query = $query->where('sprint', $sprint); }
        $all = $query->get();
        $counts = [];
        foreach ($all as $row) {
            $nameRaw = (string) $row->atribuido_a;
            $nameTrim = trim($nameRaw);
            if ($nameTrim === '') continue;
            $key = mb_strtolower(self::removeAccents($nameTrim));
            if (!isset($counts[$key])) {
                // guarde o display (primeira ocorrência) e n
                $counts[$key] = ['display' => $nameTrim, 'n' => 0];
            }
            $counts[$key]['n']++;
        }

        // Ordena por quantidade desc
        uasort($counts, function($a,$b){ return $b['n'] <=> $a['n']; });
        $categories = array_map(function($v){ return $v['display']; }, array_values($counts));
        $data = array_map(function($v){ return $v['n']; }, array_values($counts));

        return response()->json([
            'categories' => $categories,
            'series' => [[ 'name' => 'Quantidade', 'data' => $data ]],
            'totalDevs' => count($categories),
        ]);
    }

    // GET /api/structures/tests-count
    public function structuresTestsCount(Request $request)
    {
        // Conta por "estrutura", dividindo registros com múltiplas estruturas (e.g. ["PMS","CÂMARAS"]) e normalizando
        $sprint = $request->query('sprint');
        $query = Test::select('estrutura');
        if ($sprint) { $query = $query->where('sprint', $sprint); }
        $all = $query->get();
        $counts = [];
        foreach ($all as $row) {
            $raw = (string) $row->estrutura;
            // Remove colchetes e aspas
            $clean = str_replace(['[',']','"','"',"'"], '', $raw);
            // Divide por vírgula
            $parts = array_map('trim', explode(',', $clean));
            foreach ($parts as $p) {
                if ($p === '' || $p === null) continue;
                $normalized = self::normalizeText($p);
                $display = self::restoreDisplay($p); // preserva caixa original sem aspas
                $key = $normalized;
                if (!isset($counts[$key])) {
                    $counts[$key] = ['display' => $display, 'n' => 0];
                }
                $counts[$key]['n']++;
            }
        }

        // Ordena por quantidade desc
        uasort($counts, function($a,$b){ return $b['n'] <=> $a['n']; });
        $categories = array_map(function($v){ return $v['display']; }, array_values($counts));
        $data = array_map(function($v){ return $v['n']; }, array_values($counts));

        return response()->json([
            'categories' => $categories,
            'series' => [[ 'data' => $data ]],
            'totalEstruturas' => count($categories),
        ]);
    }

    // GET /api/tests/sprints
    public function sprints(Request $request)
    {
        // Retorna valores distintos da coluna sprint (não nulos) em ordem decrescente
        $list = Test::whereNotNull('sprint')
            ->distinct()
            ->orderBy('sprint', 'desc')
            ->pluck('sprint')
            ->filter()
            ->values()
            ->all();

        return response()->json([ 'sprints' => $list ]);
    }

    // GET /api/tests/by-status
    // Returns list of tests matching a normalized status (e.g., Reprovado, Aprovado, Validado)
    public function testsByStatus(Request $request)
    {
        $status = (string) $request->query('status', '');
        $sprint = (string) $request->query('sprint', '');
        if ($status === '') {
            return response()->json([ 'tests' => [] ]);
        }

        // map canonical status to a simple filter
        $low = mb_strtolower($status);
        $query = Test::query();
        if ($sprint) { $query->where('sprint', $sprint); }

        if (strpos($low, 'aprov') !== false) {
            $query->where('resultado', 'like', '%aprov%');
        } elseif (strpos($low, 'valid') !== false) {
            $query->where('resultado', 'like', '%valid%');
        } elseif (strpos($low, 'reprov') !== false) {
            $query->where('resultado', 'like', '%reprov%');
        } else {
            // fallback: try to match the raw status text anywhere
            $query->where('resultado', 'like', '%'. $status .'%');
        }

        // select only the fields we need
        $rows = $query->select('numero_ticket', 'resumo_tarefa', 'link_tarefa')->orderBy('numero_ticket','desc')->get();

        // normalize output
        $out = $rows->map(function($r){
            return [
                'numero_ticket' => $r->numero_ticket,
                'resumo_tarefa' => (string) $r->resumo_tarefa,
                'link_tarefa' => (string) $r->link_tarefa,
            ];
        })->all();

        return response()->json([ 'tests' => $out ]);
    }

    // GET /api/tests/search
    // Generic search by allowed fields: resultado, atribuido_a, estrutura
    public function testsSearch(Request $request)
    {
        $field = (string) $request->query('field', '');
        $value = (string) $request->query('value', '');
        $sprint = (string) $request->query('sprint', '');

        $allowed = ['resultado','atribuido_a','estrutura'];
        if ($field === '' || $value === '' || !in_array($field, $allowed)) {
            return response()->json([ 'tests' => [] ]);
        }

        $query = Test::query();
        if ($sprint) { $query->where('sprint', $sprint); }

        // For resultado, try substring matching (case-insensitive)
        if ($field === 'resultado') {
            $query->where($field, 'like', '%'.$value.'%');
        } elseif ($field === 'estrutura') {
            // estrutura may contain comma-separated or bracketed lists; match by LIKE
            $query->where($field, 'like', '%'.$value.'%');
        } else {
            // atribuido_a exact-ish match: use LIKE to be permissive
            $query->where($field, 'like', '%'.$value.'%');
        }

        $rows = $query->select('numero_ticket', 'resumo_tarefa', 'link_tarefa')->orderBy('numero_ticket','desc')->get();

        $out = $rows->map(function($r){
            return [
                'numero_ticket' => $r->numero_ticket,
                'resumo_tarefa' => (string) $r->resumo_tarefa,
                'link_tarefa' => (string) $r->link_tarefa,
            ];
        })->all();

        return response()->json([ 'tests' => $out ]);
    }

    private static function removeAccents($str)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    }

    private static function normalizeText($str)
    {
        $s = trim((string)$str);
        $s = str_replace(['"',"'"], '', $s);
        $s = mb_strtolower(self::removeAccents($s));
        return $s;
    }

    private static function restoreDisplay($str)
    {
        $s = trim((string)$str);
        $s = trim($s, "\"'");
        return $s;
    }
}
