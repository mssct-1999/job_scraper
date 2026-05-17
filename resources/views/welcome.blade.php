@extends('layouts.app')

@push('styles')
<style>
    .landing-page {
        background: #f7f9fc;
    }

    .landing-hero {
        min-height: calc(100vh - 112px);
        display: flex;
        align-items: center;
    }

    .hero-panel {
        background: #ffffff;
        border: 1px solid rgba(31, 41, 55, .08);
        border-radius: 8px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, .08);
    }

    .metric-card {
        border: 1px solid rgba(31, 41, 55, .08);
        border-radius: 8px;
        background: #ffffff;
    }

    .text-soft {
        color: #64748b;
    }

    .status-ready {
        background: #dcfce7;
        color: #166534;
    }
</style>
@endpush

@section('content')
<div class="landing-page">
    <section class="landing-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <p class="text-uppercase fw-semibold text-primary small mb-3">Simple job tracking</p>
                    <h1 class="display-5 fw-bold lh-sm mb-3">Find scraped offers faster, review them clearly, and keep your applications moving.</h1>
                    <p class="lead text-soft mb-4">
                        A focused workspace for browsing scraped job offers, checking useful details, and jumping straight to the original listing.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg px-4">View jobs</a>
                        <a href="{{ route('companies.index') }}" class="btn btn-outline-primary btn-lg px-4">French companies in Brazil</a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4">Login</a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <p class="text-soft small mb-1">Workspace</p>
                                <h2 class="h4 fw-bold mb-0">Job pipeline</h2>
                            </div>
                            <span class="badge status-ready px-3 py-2">Ready</span>
                        </div>

                        <div class="metric-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">French companies</span>
                                <span class="h4 mb-0">Brazil</span>
                            </div>
                        </div>
                        <div class="metric-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">VIE opportunities</span>
                                <span class="badge bg-primary">Open roles</span>
                            </div>
                        </div>
                        <div class="metric-card p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">External links</span>
                                <span class="badge bg-light text-dark">One click</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
