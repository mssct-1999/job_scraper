@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <p class="text-uppercase fw-semibold text-primary small mb-2">New Brazil offer</p>
                            <h1 class="h3 fw-bold mb-0">Register a VIE or job offer</h1>
                        </div>
                        <a href="{{ route('brazil-offers.index') }}" class="btn btn-outline-secondary">Back</a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">Please check the highlighted fields.</div>
                    @endif

                    <form action="{{ route('brazil-offers.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label" for="title">Title</label>
                                <input id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="french_company_id">Company</label>
                                <select id="french_company_id" name="french_company_id" class="form-select">
                                    <option value="">Not linked yet</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('french_company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="offer_type">Offer type</label>
                                <select id="offer_type" name="offer_type" class="form-select">
                                    @foreach(['VIE', 'CDI', 'CDD', 'Internship', 'Freelance', 'Other'] as $type)
                                        <option value="{{ $type }}" {{ old('offer_type', 'VIE') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="status">Status</label>
                                <select id="status" name="status" class="form-select">
                                    @foreach(['open', 'closed', 'draft'] as $status)
                                        <option value="{{ $status }}" {{ old('status', 'open') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="source">Source</label>
                                <input id="source" name="source" class="form-control" value="{{ old('source', 'manual') }}" placeholder="business_france">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="city">City</label>
                                <input id="city" name="city" class="form-control" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="state">State</label>
                                <input id="state" name="state" class="form-control" value="{{ old('state') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="contract_start_date">Contract start</label>
                                <input id="contract_start_date" name="contract_start_date" type="date" class="form-control" value="{{ old('contract_start_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="published_at">Published date</label>
                                <input id="published_at" name="published_at" type="date" class="form-control" value="{{ old('published_at') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="source_url">Source URL</label>
                                <input id="source_url" name="source_url" type="url" class="form-control @error('source_url') is-invalid @enderror" value="{{ old('source_url') }}">
                                @error('source_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
