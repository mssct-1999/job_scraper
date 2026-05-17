@extends('layouts.app')

@push('styles')
<style>
    .jobs-page {
        background: #f7f9fc;
        min-height: calc(100vh - 74px);
    }

    .jobs-hero,
    .job-card,
    .empty-state {
        border: 1px solid rgba(31, 41, 55, .08);
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 18px 48px rgba(15, 23, 42, .06);
    }

    .stat-box {
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid rgba(31, 41, 55, .06);
    }

    .job-card {
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .job-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 22px 58px rgba(15, 23, 42, .10);
    }

    .job-title {
        color: #111827;
    }

    .meta-label {
        color: #64748b;
    }

    .job-description {
        color: #475569;
        min-height: 72px;
    }
</style>
@endpush

@section('content')
@php
    $sentCount = $jobs->where('sent_candidature', 'O')->count();
    $refusedCount = $jobs->where('sent_candidature', 'N')->count();
    $pendingCount = max($jobs->count() - $sentCount - $refusedCount, 0);
@endphp

<div class="jobs-page py-4 py-md-5">
<div class="container">
    <div class="jobs-hero p-4 p-md-5 mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase fw-semibold text-primary small mb-2">Scraped opportunities</p>
                <h1 class="fw-bold mb-2">Job offers</h1>
                <p class="text-muted mb-0">Review every scraped role, open the original offer, and keep track of candidature status.</p>
            </div>
            <div class="col-lg-5">
                <div class="row g-2">
                    <div class="col-4">
                        <div class="stat-box p-3 text-center">
                            <div class="h3 fw-bold mb-0">{{ $jobs->count() }}</div>
                            <div class="small meta-label">Total</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box p-3 text-center">
                            <div class="h3 fw-bold mb-0">{{ $sentCount }}</div>
                            <div class="small meta-label">Sent</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box p-3 text-center">
                            <div class="h3 fw-bold mb-0">{{ $pendingCount }}</div>
                            <div class="small meta-label">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($jobs->isEmpty())
        <div class="empty-state p-5 text-center">
            <h2 class="h4 fw-bold mb-2">No job offers found</h2>
            <p class="text-muted mb-0">Run your scraper, then come back here to review the collected offers.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($jobs as $job)
                @php
                    $jobTitle = $job->title ?? $job->position ?? 'Job #' . ($job->id ?? $loop->iteration);
                    $jobCompany = $job->company ?? 'Company not specified';
                    $jobLocation = $job->location ?? $job->country ?? null;
                    $jobLink = $job->url ?? $job->link ?? $job->apply_link ?? $job->job_url ?? $job->apply_url ?? null;
                    $jobKey = method_exists($job, 'getKey') ? $job->getKey() : ($job->id ?? null);
                @endphp

                <div class="col-md-6 col-xl-4">
                    <article class="job-card h-100 d-flex flex-column">
                        <div class="p-4 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <h2 class="h5 fw-bold job-title mb-1">{{ $jobTitle }}</h2>
                                    <p class="mb-0 text-muted">{{ $jobCompany }}</p>
                                </div>
                                @if($job->sent_candidature === 'O')
                                    <span class="badge bg-success px-3 py-2">Sent</span>
                                @elseif($job->sent_candidature === 'N')
                                    <span class="badge bg-danger px-3 py-2">Refused</span>
                                @elseif($job->sent_candidature)
                                    <span class="badge bg-secondary px-3 py-2">{{ $job->sent_candidature }}</span>
                                @else
                                    <span class="badge bg-light text-dark px-3 py-2">Pending</span>
                                @endif
                            </div>

                            @if($jobLocation)
                                <p class="small meta-label mb-3">{{ $jobLocation }}</p>
                            @endif

                            @if(isset($job->description))
                                @php
                                    $descriptionPreview = strlen($job->description) > 160 ? substr($job->description, 0, 157) . '...' : $job->description;
                                @endphp
                                <p class="job-description mb-0">{{ $descriptionPreview }}</p>
                            @else
                                <ul class="list-unstyled small mb-0">
                                    @foreach($job->toArray() as $key => $value)
                                        @if($value && !in_array($key, ['id','title','position','company','description','created_at','updated_at','url','link','apply_link','job_url','apply_url','sent_candidature','location','country']))
                                            <li class="mb-1"><span class="meta-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span> {{ $value }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="border-top p-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <span class="small meta-label">
                                    @if(isset($job->created_at))
                                        Posted: {{ $job->created_at }}
                                    @else
                                        Scraped offer
                                    @endif
                                </span>
                                <div class="d-flex gap-2">
                                    @if($jobKey && $job->sent_candidature !== 'O')
                                        <form action="{{ route('jobs.updateCandidature', $jobKey) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">Mark sent</button>
                                        </form>
                                    @endif
                                    @if($jobLink)
                                        <a class="btn btn-sm btn-primary" href="{{ $jobLink }}" target="_blank" rel="noopener noreferrer">Open offer</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</div>
</div>
@endsection
