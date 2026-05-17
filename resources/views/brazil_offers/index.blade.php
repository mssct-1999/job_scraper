@extends('layouts.app')

@push('styles')
<style>
    .offers-page { background: #f7f9fc; min-height: calc(100vh - 74px); }
    .surface { border: 1px solid rgba(31, 41, 55, .08); border-radius: 8px; background: #ffffff; box-shadow: 0 18px 48px rgba(15, 23, 42, .06); }
    .offer-card { border: 1px solid rgba(31, 41, 55, .08); border-radius: 8px; background: #ffffff; transition: transform .18s ease, box-shadow .18s ease; }
    .offer-card:hover { transform: translateY(-3px); box-shadow: 0 22px 58px rgba(15, 23, 42, .10); }
    .meta { color: #64748b; }
</style>
@endpush

@section('content')
@php
    $vieCount = $offers->where('offer_type', 'VIE')->count();
    $openCount = $offers->where('status', 'open')->count();
@endphp

<div class="offers-page py-4 py-md-5">
    <div class="container">
        <div class="surface p-4 p-md-5 mb-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <p class="text-uppercase fw-semibold text-primary small mb-2">Brazil opportunities</p>
                    <h1 class="fw-bold mb-2">VIE and job offers in Brazil</h1>
                    <p class="text-muted mb-0">A destination table for manual entries today and Business France scraper results later.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('brazil-offers.create') }}" class="btn btn-primary">Add offer</a>
                </div>
            </div>
            <div class="row g-2 mt-4">
                <div class="col-4">
                    <div class="bg-light rounded p-3 text-center">
                        <div class="h3 fw-bold mb-0">{{ $offers->count() }}</div>
                        <div class="small meta">Total</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-light rounded p-3 text-center">
                        <div class="h3 fw-bold mb-0">{{ $vieCount }}</div>
                        <div class="small meta">VIE</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-light rounded p-3 text-center">
                        <div class="h3 fw-bold mb-0">{{ $openCount }}</div>
                        <div class="small meta">Open</div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
        @endif

        @if($offers->isEmpty())
            <div class="surface p-5 text-center">
                <h2 class="h4 fw-bold mb-2">No Brazil offers yet</h2>
                <p class="text-muted mb-3">Add a VIE offer manually, then connect your scraper to this table.</p>
                <a href="{{ route('brazil-offers.create') }}" class="btn btn-primary">Add first offer</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($offers as $offer)
                    <div class="col-md-6 col-xl-4">
                        <article class="offer-card h-100 p-4">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <h2 class="h5 fw-bold mb-1"><a class="text-decoration-none" href="{{ route('brazil-offers.show', $offer) }}">{{ $offer->title }}</a></h2>
                                    <p class="text-muted mb-0">{{ optional($offer->frenchCompany)->name ?? 'Company not linked' }}</p>
                                </div>
                                <span class="badge bg-primary px-3 py-2">{{ $offer->offer_type }}</span>
                            </div>
                            <p class="small meta mb-3">{{ collect([$offer->city, $offer->state, $offer->country])->filter()->join(', ') }}</p>
                            @php
                                $descriptionPreview = $offer->description ?? 'No description saved yet.';
                                $descriptionPreview = strlen($descriptionPreview) > 140 ? substr($descriptionPreview, 0, 137) . '...' : $descriptionPreview;
                            @endphp
                            <p class="mb-3">{{ $descriptionPreview }}</p>
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <span class="badge bg-light text-dark">{{ ucfirst($offer->status) }}</span>
                                @if($offer->source_url)
                                    <a href="{{ $offer->source_url }}" target="_blank" rel="noopener noreferrer">Open source</a>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
