@extends('layouts.app')

@push('styles')
<style>
    .directory-page { background: #f7f9fc; min-height: calc(100vh - 74px); }
    .surface { border: 1px solid rgba(31, 41, 55, .08); border-radius: 8px; background: #ffffff; box-shadow: 0 18px 48px rgba(15, 23, 42, .06); }
    .meta { color: #64748b; }
    .company-row { border-top: 1px solid rgba(31, 41, 55, .08); }
    .company-row:first-child { border-top: 0; }
    .company-logo { width: 52px; height: 52px; object-fit: contain; border: 1px solid rgba(31, 41, 55, .08); border-radius: 8px; background: #fff; }
    .company-logo-placeholder { width: 52px; height: 52px; border-radius: 8px; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="directory-page py-4 py-md-5">
    <div class="container">
        <div class="surface p-4 p-md-5 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <p class="text-uppercase fw-semibold text-primary small mb-2">Brazil directory</p>
                    <h1 class="fw-bold mb-2">French companies in Brazil</h1>
                    <p class="text-muted mb-0">Build a reusable company database for VIE research, outreach, and future job scraping.</p>
                </div>
                <a href="{{ route('companies.create') }}" class="btn btn-primary">Add company</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
        @endif

        <div class="surface">
            @forelse($companies as $company)
                <div class="company-row p-4">
                    <div class="d-flex flex-wrap justify-content-between gap-3">
                        <div class="d-flex gap-3">
                            @if($company->logo_url)
                                <img class="company-logo" src="{{ $company->logo_url }}" alt="{{ $company->name }} logo">
                            @else
                                <div class="company-logo-placeholder">{{ strtoupper(substr($company->name, 0, 1)) }}</div>
                            @endif
                            <div>
                                <h2 class="h5 fw-bold mb-1">
                                    <a class="text-decoration-none" href="{{ route('companies.show', $company) }}">{{ $company->name }}</a>
                                </h2>
                                <p class="meta mb-2">
                                    {{ $company->sector ?? 'Sector not specified' }}
                                    @if($company->city || $company->state)
                                        | {{ collect([$company->city, $company->state])->filter()->join(', ') }}
                                    @endif
                                </p>
                                @if($company->website)
                                    <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a>
                                @endif
                            </div>
                        </div>
                        <div class="text-md-end">
                            <span class="badge bg-light text-dark px-3 py-2">{{ $company->brazil_job_offers_count }} offers</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-5 text-center">
                    <h2 class="h4 fw-bold mb-2">No companies yet</h2>
                    <p class="text-muted mb-3">Start with the French companies you already know are active in Brazil.</p>
                    <a href="{{ route('companies.create') }}" class="btn btn-primary">Add first company</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
