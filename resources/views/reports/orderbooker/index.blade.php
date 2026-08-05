@extends('layout.app')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>View Orderbooker Report</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mt-2">
                        <label for="from">From</label>
                        <input type="date" name="from" id="from" value="{{firstDayOfMonth()}}" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="to">To</label>
                                <input type="date" name="to" id="to" value="{{lastDayOfMonth()}}" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="orderbooker">Order Booker</label>
                        <select name="orderbookerID" id="orderbookerID" class="selectize">
                            @foreach ($orderbookers as $orderbooker)
                                <option value="{{ $orderbooker->id }}">{{ $orderbooker->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-success w-100" id="viewBtn">View Report</button>
                    </div>
                </div>
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
        $(".selectize").selectize();

        $("#viewBtn").on("click", function (){
            var from = $("#from").val();
            var to = $("#to").val();
            var orderbooker = $("#orderbookerID").find(":selected").val();
            var url = "{{ route('reportOrderbookerData', ['from' => ':from', 'to' => ':to', 'orderbooker' => ':orderbooker']) }}"
        .replace(':from', from)
        .replace(':to', to)
        .replace(':orderbooker', orderbooker);
            window.open(url, "_blank", "width=1000,height=800");
        });
    </script>
@endsection
