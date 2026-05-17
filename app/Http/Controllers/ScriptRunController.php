<?php

namespace App\Http\Controllers;

use App\Models\ScriptRun;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Process\Process;

class ScriptRunController extends Controller
{
    private $scripts = [
        'enrich-companies' => [
            'name' => 'Enrich French companies in Brazil',
            'description' => 'Searches websites, LinkedIn pages, and logo URLs for companies already stored in the directory.',
            'path' => '..\\job_scraper\\search_jobs_french_companies_br.py',
        ],
    ];

    public function index()
    {
        $scripts = collect($this->scripts)->map(function ($script, $key) {
            $script['key'] = $key;
            $script['last_run'] = ScriptRun::where('script_key', $key)->latest('started_at')->first();

            return $script;
        });

        $recentRuns = ScriptRun::latest('started_at')->take(10)->get();

        return view('scripts.index', compact('scripts', 'recentRuns'));
    }

    public function run(string $scriptKey): JsonResponse
    {
        set_time_limit(0);

        abort_unless(isset($this->scripts[$scriptKey]), 404);

        $script = $this->scripts[$scriptKey];
        $scriptPath = base_path($script['path']);

        abort_unless(file_exists($scriptPath), 404, 'Script file not found.');

        $run = ScriptRun::create([
            'script_key' => $scriptKey,
            'script_name' => $script['name'],
            'status' => 'running',
            'started_at' => Carbon::now(),
        ]);

        $process = new Process(['python', $scriptPath], dirname($scriptPath), [
            'PYTHONIOENCODING' => 'utf-8',
            'PYTHONUTF8' => '1',
        ]);
        $process->setTimeout(900);
        $process->run();

        $output = $this->cleanUtf8($process->getOutput());
        $errorOutput = $this->cleanUtf8($process->getErrorOutput());
        $summary = $this->extractSummary($output);

        $run->update([
            'status' => $process->isSuccessful() ? 'success' : 'failed',
            'exit_code' => $process->getExitCode(),
            'finished_at' => Carbon::now(),
            'summary' => $this->cleanUtf8($summary),
            'output' => $output,
            'error_output' => $errorOutput,
        ]);

        return response()->json([
            'status' => $run->status,
            'exit_code' => $run->exit_code,
            'started_at' => optional($run->started_at)->format('Y-m-d H:i:s'),
            'finished_at' => optional($run->finished_at)->format('Y-m-d H:i:s'),
            'summary' => $this->cleanUtf8($summary),
            'output' => $output,
            'error_output' => $errorOutput,
        ], $process->isSuccessful() ? 200 : 500, [], JSON_INVALID_UTF8_SUBSTITUTE);
    }

    private function extractSummary(string $output): array
    {
        foreach (explode("\n", $output) as $line) {
            $line = trim($line);

            if (strpos($line, 'SCRIPT_RESULT_JSON=') !== 0) {
                continue;
            }

            $json = substr($line, strlen('SCRIPT_RESULT_JSON='));
            $decoded = json_decode($this->cleanUtf8($json), true);

            return is_array($decoded) ? $this->cleanUtf8($decoded) : [];
        }

        return [];
    }

    private function cleanUtf8($value)
    {
        if (is_array($value)) {
            return array_map(function ($item) {
                return $this->cleanUtf8($item);
            }, $value);
        }

        if (!is_string($value)) {
            return $value;
        }

        if (preg_match('//u', $value)) {
            return $value;
        }

        $converted = @iconv('Windows-1252', 'UTF-8//IGNORE', $value);

        if ($converted !== false && preg_match('//u', $converted)) {
            return $converted;
        }

        $converted = @iconv('UTF-8', 'UTF-8//IGNORE', $value);

        return $converted !== false ? $converted : '';
    }
}
