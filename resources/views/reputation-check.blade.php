@extends('layouts.app')
@section('content')
      <!-- Hero Section -->
      <div class="heroSection">
        <div class="bgimage">
          <img src="/assets/HeroSection.png" alt="image" />
        </div>
        <h3>Reputation Check</h3>
      </div>
      <!--/ Hero Section /-->
      <form action="{{ route('repudation.result') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        
        <!-- Search Input -->
        <div class="mb-3"> 
            <label for="single_ioc" class="form-label">Search for a single IP, URL, or Domain:</label>
            <input type="text" id="single_ioc" name="single_ioc" class="form-control" placeholder="Enter IP, URL, or Domain">
        </div>

        <!-- OR separator -->
        <div class="text-center my-3">
            <span>OR</span>
        </div>

        <!-- File Upload Input with FontAwesome Icon -->
        <div class="mb-3">
            <label for="ioc_file" class="form-label">
                <i class="fas fa-upload me-2"></i>Upload a file (txt, xls, xlsx, csv):
            </label>
            <input type="file" id="ioc_file" name="ioc_file" class="form-control">
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check me-2"></i>Check Reputation
            </button>
        </div>
      </form>


@stop
@section('style')
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@stop