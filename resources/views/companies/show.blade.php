@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            @if($company->logo_url)
                <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo" style="width: 72px; height: 72px; object-fit: contain; border: 1px solid rgba(31, 41, 55, .08); border-radius: 8px; background: #fff;">
            @endif
            <div>
                <p class="text-uppercase fw-semibold text-primary small mb-2">Company profile</p>
                <h1 class="fw-bold mb-1">{{ $company->name }}</h1>
                <p class="text-muted mb-0">{{ collect([$company->sector, $company->city, $company->state])->filter()->join(' | ') }}</p>
            </div>
        </div>
        <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Details</h2>
                    <dl class="mb-0">
                        <dt>Website</dt>
                        <dd>@if($company->website)<a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a>@else <span class="text-muted">Not set</span> @endif</dd>
                        <dt>LinkedIn</dt>
                        <dd>@if($company->linkedin_url)<a href="{{ $company->linkedin_url }}" target="_blank" rel="noopener noreferrer">Open LinkedIn</a>@else <span class="text-muted">Not set</span> @endif</dd>
                        <dt>Logo</dt>
                        <dd>@if($company->logo_url)<a href="{{ $company->logo_url }}" target="_blank" rel="noopener noreferrer">Open logo</a>@else <span class="text-muted">Not set</span> @endif</dd>
                        <dt>Contact</dt>
                        <dd>{{ collect([$company->contact_name, $company->contact_email, $company->contact_phone])->filter()->join(' | ') ?: 'Not set' }}</dd>
                        <dt>Source</dt>
                        <dd>@if($company->source_url)<a href="{{ $company->source_url }}" target="_blank" rel="noopener noreferrer">Open source</a>@else <span class="text-muted">Not set</span> @endif</dd>
                    </dl>
                    @if($company->notes)
                        <hr>
                        <p class="mb-0">{{ $company->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Brazil offers</h2>
                        <a href="{{ route('brazil-offers.create') }}" class="btn btn-sm btn-primary">Add offer</a>
                    </div>
                    @forelse($company->brazilJobOffers as $offer)
                        <div class="border-top py-3">
                            <h3 class="h6 fw-bold mb-1"><a href="{{ route('brazil-offers.show', $offer) }}">{{ $offer->title }}</a></h3>
                            <p class="text-muted small mb-0">{{ $offer->offer_type }} | {{ $offer->status }} | {{ collect([$offer->city, $offer->state])->filter()->join(', ') }}</p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No offer linked to this company yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
