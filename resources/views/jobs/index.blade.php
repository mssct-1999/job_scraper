@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Job Offers</h1>

    @if($jobs->isEmpty())
        <p>No job offers found.</p>
    @else
        <div class="row">
            @foreach($jobs as $job)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                {{ $job->title ?? $job->position ?? ($job->company ?? 'Job #' . ($job->id ?? $loop->iteration)) }}
                            </h5>

                            @if($job->sent_candidature)
                                <div>
                                @if($job->sent_candidature === 'O')
                                    <span class="badge bg-success ms-2">Sent</span>
                                @elseif($job->sent_candidature === 'N')
                                    <span class="badge bg-danger ms-2">Refused</span>
                                @else
                                    <span class="badge bg-secondary ms-2">{{ $job->sent_candidature }}</span>
                                @endif
                                </div>
                            @endif

                            </div>

                            @if(isset($job->description))
                                <p class="card-text">{{ $job->description }}</p>
                            @else
                                <ul class="list-unstyled small mb-0">
                                    @foreach($job->toArray() as $key => $value)
                                        @if(!in_array($key, ['id','title','position','company','description','created_at','updated_at','url','link','apply_link','job_url','apply_url']))
                                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @php
                            $jobLink = $job->url ?? $job->link ?? $job->apply_link ?? $job->job_url ?? $job->apply_url ?? null;
                        @endphp
                        <div class="card-footer text-muted small d-flex justify-content-between align-items-center">
                            <div>
                                @if(isset($job->created_at))
                                    Posted: {{ $job->created_at }}
                                @endif
                            </div>
                            <div>
                                @if($jobLink)
                                    <a href="{{ $jobLink }}" target="_blank" rel="noopener noreferrer">Voir</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
