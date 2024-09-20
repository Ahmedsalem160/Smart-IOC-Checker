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
              <input
                id="searchInput"
                placeholder="-------------"
                type="text"
                name="query"
                class="form-control"
                aria-label="Text input with dropdown button"
              />
            </div>
          </div>
          <!-- <button id="search" class="search bg-blue">Search</button> -->
          <button class="search bg-blue" type="submit" >Search</button>
        </div>
      </div>
    </form>
    <!--/ Search /-->
@stop
