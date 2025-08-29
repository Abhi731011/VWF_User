
@extends('master.main')

@section('content')
@php
    $baseurl = 'http://localhost/ngo/public/';
@endphp
<div class="container py-4">
    <div class="row justify-content-center">
        @foreach($packages as $package)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm package-card h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header text-center text-white" style="background:
                        @if($package->name == 'Starter') linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
                        @elseif($package->name == 'Professional') linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
                        @else linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
                        @endif
                        border-radius: 0 0 20px 20px;">
                        <h4 class="mb-0">{{ $package->name }}</h4>
                        <div style="font-size: 1.2rem; font-weight: 600;">{{ $package->currency }} {{ number_format($package->price, 2) }} /
                            @if($package->duration_type == 'month') month @elseif($package->duration_type == 'year') year @else {{ $package->duration_type }} @endif
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if($package->image)
                            <div class="text-center mb-3">
                                <img src="{{ $baseurl . $package->image }}" alt="{{ $package->name }}" style="max-width: 200px; max-height: 400px; border-radius: 10px;">
                            </div>
                        @endif
                        <div class="mb-2 text-center">
                            @if($package->icon)
                                <img src="{{ $baseurl . $package->icon }}" alt="icon" style="max-width: 32px; max-height: 32px;">
                            @endif
                            @if($package->is_featured)
                                <span class="badge bg-success ms-2">Featured</span>
                            @endif
                        </div>
                        {{-- <div class="mb-2"><strong>Slug:</strong> {{ $package->slug }}</div> --}}
                        <div class="mb-2"><strong>Description:</strong> {{ $package->description }}</div>
                        <div class="mb-2"><strong>Goodies Count:</strong> {{ $package->goodies_count }}</div>
                        <div class="mb-2"><strong>Status:</strong> <span class="badge {{ $package->status ? 'bg-primary' : 'bg-secondary' }}">{{ $package->status ? 'Active' : 'Inactive' }}</span></div>
                        <ul class="list-unstyled mb-0">
                            @php
                                $features = $package->perks ?? [];
                                $maxFeatures = 7;
                            @endphp
                            @for($i = 0; $i < $maxFeatures; $i++)
                                <li class="d-flex align-items-center mb-2">
                                    @if(isset($features[$i]) && $features[$i])
                                        <span class="me-2" style="color: #38ef7d; font-size: 1.2rem;">
                                            <i class="ri-checkbox-circle-fill"></i>
                                        </span>
                                        <span>{{ $features[$i] }}</span>
                                    @else
                                        <span class="me-2" style="color: #ccc; font-size: 1.2rem;">
                                            {{-- <i class="ri-checkbox-blank-circle-line"></i> --}}
                                        </span>
                                        {{-- <span style="color: #ccc;">Feature not available</span> --}}
                                    @endif
                                </li>
                            @endfor
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                        <a href="#" class="btn btn-primary w-100" style="border-radius: 10px;">Choose {{ $package->name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .package-card {
        transition: transform 0.2s;
    }
    .package-card:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    @media (max-width: 576px) {
        .package-card {
            margin-bottom: 1.5rem;
        }
        .card-header {
            font-size: 1.1rem;
        }
    }
</style>
@endsection