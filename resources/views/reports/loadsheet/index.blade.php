@extends('layout.app')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>View Load Sheet Report</h3>
                </div>
                <form action="{{route('reportLoadsheetData')}}" method="get">
                <div class="card-body">
                    <div class="form-group">
                        <label for="orderbooker">Order Booker</label>
                        <select name="orderbooker[]" class="selectize" id="orderbookerID" multiple>
                            @foreach ($orderbookers as $man)
                                <option value="{{$man->id}}">{{$man->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" value="{{date('Y-m-d')}}" class="form-control">
                    </div>

                    <div class="form-group mt-2">
                        <button class="btn btn-success w-100" id="viewBtn">View Report</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
@endsection
@section('page-js')

<script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
<script>
    $(".selectize").selectize({
        plugins: ['remove_button'],
        maxItems: null,
        create: false,
        placeholder: 'Select Order Bookers'
    });

       
    </script>
@endsection
