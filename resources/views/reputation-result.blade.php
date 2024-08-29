@extends('layouts.app')
@section('content')
      <!-- Hero Section -->
      <div class="heroSection">
        <div class="bgimage">
          <img src="/assets/HeroSection.png" alt="image" />
        </div>
        <h3>Reputation Result</h3>
      </div>
      <!--/ Hero Section /-->
      <!-- Start alert -->
      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
       <!-- End Alert -->
      @foreach($results as $ioc => $result)
        <h3>{{ $ioc }} (Type: {{ $result['type'] }})</h3>
        @if(isset($result['data']['positives']))
            <p>Positives: {{ $result['data']['positives'] }}</p>
            <p>Details: <pre>{{ json_encode($result['data'], JSON_PRETTY_PRINT) }}</pre></p>
        @else
            <p>No data available for this IOC.</p>
        @endif
    @endforeach
@stop