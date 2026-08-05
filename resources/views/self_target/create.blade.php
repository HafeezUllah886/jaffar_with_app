@extends('layout.popups')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><h3> Create Self Target </h3></div>
                                <div class="col-6 d-flex flex-row-reverse"><button onclick="window.close()" class="btn btn-danger">Close</button></div>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
                <div class="card-body">
                    <form action="{{ route('self_targets.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" class="selectize" id="category">
                                        <option value=""></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th width="20%">Category</th>
                                        <th class="text-center">Qty</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="products_list"></tbody>
                                  
                                </table>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="start">Start</label>
                                    <input type="date" name="startDate" required id="start" value="{{ date('Y-m-d') }}"
                                    class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="date" name="endDate" required id="end" value="{{ date('Y-m-d') }}"
                                    class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="vendor">Vendor</label>
                                    <select name="vendorID" id="vendor" class="selectize1">
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Create Self Target</button>
                            </div>
                </div>
            </form>
            </div>

        </div>
        <!--end card-->
    </div>
    <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
    <style>
        .no-padding {
            padding: 5px 5px !important;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script>
        $(".selectize1").selectize();
        $(".selectize").selectize({
            onChange: function(value) {
                if (!value.length) return;
                if (value != 0) {
                    getSingleProduct(value);
                    this.clear();
                    this.focus();
                }
            },
        });
       
        var existingProducts = [];

        function getSingleProduct(id) {
            $.ajax({
                url: "{{ url('selftarger/getcat/') }}/" + id,
                method: "GET",
                success: function(cat) {
                    let found = $.grep(existingProducts, function(element) {
                        return element === cat.id;
                    });
                    if (found.length > 0) {

                    } else {
                        var id = cat.id;
                        var html = '<tr id="row_' + id + '">';
                        html += '<td class="no-padding" width="70%">' + cat.name + '</td>';
                        html += '<td class="no-padding"><input type="number" name="qty[]" oninput="updateChanges(' + id +')" min="0.1" required step="any" value="1" class="form-control text-center" id="qty_' + id + '"></td>';
                        html += '<td> <span class="btn btn-sm btn-danger" onclick="deleteRow('+id+')">X</span> </td>';
                        html += '<input type="hidden" name="id[]" value="' + id + '">';
                        html += '</tr>';
                        $("#products_list").prepend(html);
                      
                        existingProducts.push(id);
                    }
                }
            });
        }

        function deleteRow(id) {
            existingProducts = $.grep(existingProducts, function(value) {
                return value !== id;
            });
            $('#row_'+id).remove();
           
        }
    </script>
@endsection
