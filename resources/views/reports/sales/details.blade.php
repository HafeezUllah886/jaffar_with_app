@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-success ml-4"><i class="ri-whatsapp-line mr-4"></i> Whatsapp</a>
                                <a href="{{ route('reportSalesPrint', [$from, $to, $type]) }}" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Sales Report</h3>
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
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">To</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($to)) }}</h5>
                                    </div>
                                    <!--end col-->
                                    <!--end col-->
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Printed On</p>
                                        <h5 class="fs-14 mb-0"><span id="total-amount">{{ date("d M Y") }}</span></h5>
                                        {{-- <h5 class="fs-14 mb-0"><span id="total-amount">{{ \Carbon\Carbon::now()->format('h:i A') }}</span></h5> --}}
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0" id="datatables">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col" class="text-start">Customer Name</th>
                                                <th scope="col" class="text-start">Order Booker</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Disc</th>
                                                <th scope="col">P-Disc</th>
                                                <th scope="col">Fright (-)</th>
                                                <th scope="col">Fright (+)</th>
                                                <th scope="col">WH</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody >

                                        @foreach ($sales as $key => $item)
                                            <tr>
                                                <td>{{ $item->id}}</td>
                                                <td class="text-start">{{ $item->customer->title }}</td>
                                                <td class="text-start">{{ $item->orderbooker->name }}</td>
                                                <td>{{ date("d M Y", strtotime($item->date))}}</td>
                                                <td class="text-end">{{ number_format($item->discount, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->pdiscount, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->fright, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->fright1, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->whValue, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->net, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-end">Total</th>
                                                <th class="text-end">{{number_format($sales->sum('discount'), 2)}}</th>
                                                <th class="text-end">{{number_format($sales->sum('pdiscount'), 2)}}</th>
                                                <th class="text-end">{{number_format($sales->sum('fright'), 2)}}</th>
                                                <th class="text-end">{{number_format($sales->sum('fright1'), 2)}}</th>
                                                <th class="text-end">{{number_format($sales->sum('whValue'), 2)}}</th>
                                                <th class="text-end">{{number_format($sales->sum('net'), 2)}}</th>
                                            </tr>
                                        </tfoot>
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
        $(api.column(4).footer()).html(totalTaxExc1.toFixed(2));
        $(api.column(5).footer()).html(totalTaxExc.toFixed(2));
        $(api.column(6).footer()).html(totalBillAmount.toFixed(2));
        $(api.column(7).footer()).html(totalGst.toFixed(2));
        $(api.column(8).footer()).html(totalQty.toFixed(2));
        $(api.column(9).footer()).html(totalWH.toFixed(2));
    },
});
    </script>
@endsection


