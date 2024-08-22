@extends('layouts.app')
@section('content')
      <!-- Hero Section -->
      <div class="heroSection">
        <div class="bgimage">
          <img src="/assets/HeroSection.png" alt="image" />
        </div>
        <h3>Network Sweep</h3>
      </div>
      <!--/ Hero Section /-->
      <!-- Search -->
    <form action="{{route('sweep.search')}}" method="POST">
        @csrf
      <div class="d-flex justify-content-center container">
        <div class="selectBox">
          <div class="searchBox">
            <div class="input-group border-none">
            <select class="form-control border-none" name="selected_malware" id="selected_malware">
                        <option value="" disabled selected>Select a Malware Family ....</option>
                        @foreach($malwareFamilies as $malware)
                            <option value="{{ $malware->id }}">{{ $malware->name }}</option>
                        @endforeach
                    </select>
              <!-- <button
                class="btn btn-outline-secondary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Scope
              </button>
              <ul class="dropdown-menu">
                @foreach($malwareFamilies as $malware)
                    <li>{{$malware->name}}</li>
                @endforeach
              </ul> -->
              <input
                type="text"
                class="form-control"
                aria-label="Text input with dropdown button"
              />
            </div>
          </div>
          
            <button type="submit" class="search bg-blue">Start Sweep</button>
          
        </div>
      </div>
      </form>
      <!--/ Search /-->
@stop