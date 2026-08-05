@extends('layout.app')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>View Products Purchases Report</h3>
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
                        <label for="catID">Category</label>
                             <select name="catID" id="catID" class="form-control">
                                <option value="all">All</option>
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
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
@section('page-js')

    <script>
        $("#viewBtn").on("click", function (){

            var from = $("#from").val();
            var to = $("#to").val();
            var catID = $("#catID").find(":selected").val();
            var url = "{{ route('reportPurchaseProductsData', ['from' => ':from', 'to' => ':to', 'catID' => ':catID']) }}"
        .replace(':from', from)
        .replace(':to', to)
        .replace(':catID', catID);

        window.open(url, "_blank", "width=1000,height=800");
        });
    </script>
@endsection
