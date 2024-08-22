@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <div class="heroSection">
        <div class="bgimage">
            <img src="{{asset('assets/images/HeroSection.png')}}" alt="HeroSection" />
        </div>
        <h3>IOC Collection</h3>
    </div>
    <!--/ Hero Section /-->
    <!-- Search -->
     <!-- search About any IOC -->
<form action="{{ route('search.iocs') }}" method="POST">
    @csrf
    <div class="d-flex justify-content-center container">
        <div class="selectBox">
            
                <div class="searchBox">
                    <div class="input-group border-none">
                    <button
                        class="btn btn-outline-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        All
                    </button>
                    <ul class="dropdown-menu">
                        <li>Hash</li>
                        <li>Ip</li>
                        <li>Domain</li>
                    </ul>
                    <input
                        type="text"
                        class="form-control"
                        aria-label="Text input with dropdown button"
                        name="query"
                        placeholder="Enter a Search Query (e.g., WannaCry)"
                    />
                    </div>
                </div>
            
                <button class="search bg-blue" type="submit" >Search</button>
            
        </div>
    </div>
    </form>
    <!--/ Search /-->
@stop
