@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <p class="text-uppercase fw-semibold text-primary small mb-2">{{ $offer->offer_type }} offer</p>
            <h1 class="fw-bold mb-1">{{ $offer->title }}</h1>
            <p class="text-muted mb-0">{{ collect([$offer->city, $offer->state, $offer->country])->filter()->join(', ') }}</p>
        </div>
        <a href="{{ route('brazil-offers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Offer details</h2>
                    <dl class="mb-0">
                        <dt>Company</dt>
                        <dd>
                            @if($offer->frenchCompany)
                                <a href="{{ route('companies.show', $offer->frenchCompany) }}">{{ $offer->frenchCompany->name }}</a>
                            @else
                                <span class="text-muted">Not linked</span>
                            @endif
                        </dd>
                        <dt>Status</dt>
                        <dd>{{ ucfirst($offer->status) }}</dd>
                        <dt>Source</dt>
                        <dd>{{ $offer->source }}</dd>
                        <dt>Contract start</dt>
                        <dd>{{ optional($offer->contract_start_date)->format('Y-m-d') ?? 'Not set' }}</dd>
                        <dt>Published</dt>
                        <dd>{{ optional($offer->published_at)->format('Y-m-d') ?? 'Not set' }}</dd>
                        <dt>Source URL</dt>
                        <dd>@if($offer->source_url)<a href="{{ $offer->source_url }}" target="_blank" rel="noopener noreferrer">Open source</a>@else <span class="text-muted">Not set</span> @endif</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Description</h2>
                    <p class="mb-0">{{ $offer->description ?: 'No description saved yet.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
