@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make a ride</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        <label class="float-right ">Example = 12 st Alexandria ,Egypt</label>
                        <input id="location" type="text" class="form-control" placeholder="Where you want to go ?">
                        <div id="search_holders" style="width: 90%; display: none; overflow: auto" class="bg-white h-50  position-absolute container"></div>
                        <br>
                        <button class="test float-right btn btn-danger">Confirm place</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('javascripts')
    <script src="{{asset('js/user_location/bundle.js')}}"></script>
@endpush
