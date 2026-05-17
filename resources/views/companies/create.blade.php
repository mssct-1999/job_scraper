@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <p class="text-uppercase fw-semibold text-primary small mb-2">New company</p>
                            <h1 class="h3 fw-bold mb-0">Register a French company in Brazil</h1>
                        </div>
                        <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">Back</a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            Please check the highlighted fields.
                        </div>
                    @endif

                    <form action="{{ route('companies.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Company name</label>
                                <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="legal_name">Legal name</label>
                                <input id="legal_name" name="legal_name" class="form-control" value="{{ old('legal_name') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="sector">Sector</label>
                                <input id="sector" name="sector" class="form-control" value="{{ old('sector') }}" placeholder="Tech, industry, energy">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="city">City</label>
                                <input id="city" name="city" class="form-control" value="{{ old('city') }}" placeholder="Sao Paulo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="state">State</label>
                                <input id="state" name="state" class="form-control" value="{{ old('state') }}" placeholder="SP">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="website">Website</label>
                                <input id="website" name="website" type="url" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}">
                                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="linkedin_url">LinkedIn</label>
                                <input id="linkedin_url" name="linkedin_url" type="url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url') }}">
                                @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="logo_url">Logo URL</label>
                                <input id="logo_url" name="logo_url" type="url" class="form-control @error('logo_url') is-invalid @enderror" value="{{ old('logo_url') }}">
                                @error('logo_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="contact_name">Contact name</label>
                                <input id="contact_name" name="contact_name" class="form-control" value="{{ old('contact_name') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="contact_email">Contact email</label>
                                <input id="contact_email" name="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}">
                                @error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="contact_phone">Contact phone</label>
                                <input id="contact_phone" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="source_url">Source URL</label>
                                <input id="source_url" name="source_url" type="url" class="form-control @error('source_url') is-invalid @enderror" value="{{ old('source_url') }}">
                                @error('source_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea id="notes" name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save company</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
