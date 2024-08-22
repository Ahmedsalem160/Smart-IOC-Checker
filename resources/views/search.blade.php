@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Search Indicators of Compromise (IOCs)</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('search.iocs') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="query">Enter a Search Query (e.g., WannaCry):</label>
            <input type="text" name="query" id="query" class="form-control" placeholder="Enter query..." required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Search</button>
    </form>
</div>
@endsection
