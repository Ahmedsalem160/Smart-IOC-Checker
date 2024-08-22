@extends('layouts.app')

@section('content')
<!-- <div class="container mt-5">
    <h2 class="mb-4">Search Results for "{{ $query }}"</h2>

    @if(empty($iocResults))
        <div class="alert alert-warning">
            No IOCs found for this query.
        </div>
    @else
    @foreach ($iocResults as $category => $indicators)
    <h3>{{ ucfirst($category) }}</h3>
    <ul>
        @foreach (array_slice($indicators, 0, 10) as $indicator)
            <li>{{ htmlspecialchars($indicator, ENT_QUOTES, 'UTF-8') }}</li>
        @endforeach

        @if (count($indicators) > 10)
            <div style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; padding: 5px;">
                @foreach (array_slice($indicators, 10) as $indicator)
                    <li>{{ htmlspecialchars($indicator, ENT_QUOTES, 'UTF-8') }}</li>
                @endforeach
            </div>
        @endif
    </ul>
    @endforeach

    @endif

        <a href="{{ route('search.form') }}" class="btn btn-secondary mt-3">Back to Search</a>
    </div> -->


          <!-- Table -->
          <div class="w-full h-full mt-5">
        <div class="container">
          <div class="tableContainer">
            <table class="table - mb-0">
              <thead class="text-capitalize">
                <tr>
                  <th scope="col">Type</th>
                  <th scope="col">Value</th>
                  <th scope="col">Source</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($iocResults as $type => $values)
                    @foreach($values as $ioc)
                    
                    <tr>
                        <td style="text-align:center;">{{ ucfirst($type)}}</td>
                        <td style="text-align:center;">{{ $ioc}}</td>
                        <td style="text-align:center;">{{ $source }}</td>
                    </tr>
                    @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!--/ Table /-->
@endsection
