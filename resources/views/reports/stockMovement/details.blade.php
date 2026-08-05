@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="javascript:window.print()" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Stock Movement Report</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end card-header-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">From</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($from)) }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">To (Closing Date)</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($to)) }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Printed On</p>
                                        <h5 class="fs-14 mb-0"><span id="total-amount">{{ date("d M Y") }}</span></h5>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center table-nowrap align-middle mb-0" id="datatables">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col" class="text-start">Product</th>
                                                <th scope="col">Opening</th>
                                                <th scope="col" class="bg-success">Stock In</th>
                                                <th scope="col" class="bg-danger">Stock Out</th>
                                                <th scope="col">Closing</th>
                                                <th scope="col">Closing Value</th>
                                                <th scope="col">Current</th>
                                                <th scope="col">Current Value</th>
                                            </tr>
                                           
                                        </thead>
                                        <tbody>
                                           
                                        @foreach ($products as $key => $product)
                                        @if ($product->opening_stock > 0 || $product->stock_in > 0 || $product->stock_out > 0 || $product->closing_stock > 0)

                                            <tr>
                                                <td class="p-1 m-0">{{ $key+1}}</td>
                                                <td class="text-start p-1 m-0">{{ $product->name}}</td>
                                               
                                                <td class="text-end p-1 m-0">{{ $product->opening_stock }}</td>

                                                <td class="text-end p-1 m-0 text-success">{{ $product->stock_in }}</td>
                                                <td class="text-end p-1 m-0 text-danger">{{ $product->stock_out }}</td>
                                                <td class="text-end p-1 m-0 ">{{ $product->closing_stock }}</td>
                                                <td class="text-end p-1 m-0 ">{{ number_format($product->closing_value,0) }}</td>
                                                <td class="text-end p-1 m-0 ">{{ $product->current_stock }}</td>
                                                <td class="text-end p-1 m-0 ">{{ number_format($product->current_value,0) }}</td>
                                            </tr>
                                        @endif
                                        @endforeach
                                      
                                    </tbody>
                                    </table><!--end table-->

                                </div>

                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

@endsection
@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
<!--datatable responsive css-->
<link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js')}}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <script>
        $('#datatables').DataTable({
    responsive: false,
    dom: 'Bfrtip',
    buttons: ['print', 'excel', 'pdf'],
    footerCallback: function (row, data, start, end, display) {
        var api = this.api();

        // Helper function to get integer or float from string
        var intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };

        // Total for Tax Exc column
        var totalTaxExc1 = api
            .column(4, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        var totalTaxExc = api
            .column(5, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for Bill Amount (RP) column
        var totalBillAmount = api
            .column(6, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for GST (18%) column
        var totalGst = api
            .column(7, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total for Qty column
        var totalQty = api
            .column(8, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
        var totalWH= api
            .column(9, { search: 'applied' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Update the footer
        $(api.column(2).footer()).html(totalTaxExc1.toFixed(2));
        $(api.column(3).footer()).html(totalTaxExc.toFixed(2));
        $(api.column(4).footer()).html(totalBillAmount.toFixed(2));
        $(api.column(5).footer()).html(totalGst.toFixed(2));
        $(api.column(6).footer()).html(totalQty.toFixed(2));
        $(api.column(7).footer()).html(totalWH.toFixed(2));
    },
});
    </script>
@endsection






