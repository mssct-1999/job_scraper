@extends('layouts.app')

@push('styles')
<style>
    .scripts-page { background: #f7f9fc; min-height: calc(100vh - 74px); }
    .surface { border: 1px solid rgba(31, 41, 55, .08); border-radius: 8px; background: #ffffff; box-shadow: 0 18px 48px rgba(15, 23, 42, .06); }
    .meta { color: #64748b; }
    .script-output { max-height: 260px; overflow: auto; background: #111827; color: #e5e7eb; border-radius: 8px; }
    .progress { height: 10px; }
</style>
@endpush

@section('content')
<div class="scripts-page py-4 py-md-5">
    <div class="container">
        <div class="surface p-4 p-md-5 mb-4">
            <p class="text-uppercase fw-semibold text-primary small mb-2">Automation</p>
            <h1 class="fw-bold mb-2">Script runner</h1>
            <p class="text-muted mb-0">Run enrichment scripts from the interface and keep a history of the latest updates.</p>
        </div>

        <div class="row g-4">
            @foreach($scripts as $script)
                <div class="col-lg-7">
                    <div class="surface p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <h2 class="h4 fw-bold mb-1">{{ $script['name'] }}</h2>
                                <p class="meta mb-0">{{ $script['description'] }}</p>
                            </div>
                            <button class="btn btn-primary run-script-btn" data-script-key="{{ $script['key'] }}" data-run-url="{{ route('scripts.run', $script['key']) }}">
                                Run script
                            </button>
                        </div>

                        <dl class="row mb-4">
                            <dt class="col-sm-4">Last run</dt>
                            <dd class="col-sm-8" id="last-run-{{ $script['key'] }}">
                                @if($script['last_run'])
                                    {{ optional($script['last_run']->finished_at ?? $script['last_run']->started_at)->format('Y-m-d H:i:s') }}
                                @else
                                    Not run yet
                                @endif
                            </dd>
                            <dt class="col-sm-4">Last status</dt>
                            <dd class="col-sm-8" id="last-status-{{ $script['key'] }}">
                                {{ $script['last_run']->status ?? 'Not run yet' }}
                            </dd>
                        </dl>

                        <div class="progress mb-3 d-none" id="progress-wrap-{{ $script['key'] }}">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="progress-bar-{{ $script['key'] }}" style="width: 0%"></div>
                        </div>

                        <div class="row g-3 mb-3" id="summary-{{ $script['key'] }}"></div>

                        <pre class="script-output p-3 mb-0 d-none" id="output-{{ $script['key'] }}"></pre>
                    </div>
                </div>
            @endforeach

            <div class="col-lg-5">
                <div class="surface p-4">
                    <h2 class="h5 fw-bold mb-3">Recent runs</h2>
                    @forelse($recentRuns as $run)
                        <div class="border-top py-3">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $run->script_name }}</div>
                                    <div class="small meta">{{ optional($run->started_at)->format('Y-m-d H:i:s') }}</div>
                                </div>
                                <span class="badge {{ $run->status === 'success' ? 'bg-success' : ($run->status === 'failed' ? 'bg-danger' : 'bg-secondary') }}">
                                    {{ $run->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No script run has been recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.run-script-btn').forEach((button) => {
    button.addEventListener('click', async () => {
        const scriptKey = button.dataset.scriptKey;
        const progressWrap = document.getElementById(`progress-wrap-${scriptKey}`);
        const progressBar = document.getElementById(`progress-bar-${scriptKey}`);
        const output = document.getElementById(`output-${scriptKey}`);
        const summary = document.getElementById(`summary-${scriptKey}`);
        let progress = 8;

        button.disabled = true;
        button.textContent = 'Running...';
        progressWrap.classList.remove('d-none');
        output.classList.add('d-none');
        summary.innerHTML = '';
        progressBar.style.width = `${progress}%`;

        const timer = setInterval(() => {
            progress = Math.min(progress + 6, 92);
            progressBar.style.width = `${progress}%`;
        }, 900);

        try {
            const response = await fetch(button.dataset.runUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const responseText = await response.text();
            let data = {};

            try {
                data = JSON.parse(responseText);
            } catch (parseError) {
                throw new Error(`Server returned ${response.status}. ${responseText.slice(0, 220)}`);
            }

            if (!response.ok) {
                throw new Error(data.message || data.error_output || `Server returned ${response.status}`);
            }

            clearInterval(timer);
            progressBar.style.width = '100%';
            button.disabled = false;
            button.textContent = 'Run script';

            document.getElementById(`last-run-${scriptKey}`).textContent = data.finished_at || data.started_at || 'Just now';
            document.getElementById(`last-status-${scriptKey}`).textContent = data.status;

            const items = [
                ['Companies updated', data.summary?.updated],
                ['Websites found', data.summary?.websites_found],
                ['LinkedIn found', data.summary?.linkedin_found],
                ['Logos found', data.summary?.logos_found],
            ];

            summary.innerHTML = items.map(([label, value]) => `
                <div class="col-6 col-md-3">
                    <div class="bg-light rounded p-3 text-center">
                        <div class="h4 fw-bold mb-0">${value ?? 0}</div>
                        <div class="small meta">${label}</div>
                    </div>
                </div>
            `).join('');

            output.textContent = [data.output, data.error_output].filter(Boolean).join('\n');
            output.classList.remove('d-none');
        } catch (error) {
            clearInterval(timer);
            progressBar.classList.remove('progress-bar-animated');
            progressBar.classList.add('bg-danger');
            button.disabled = false;
            button.textContent = 'Run script';
            output.textContent = error.message;
            output.classList.remove('d-none');
        }
    });
});
</script>
@endpush
